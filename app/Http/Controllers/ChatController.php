<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Update the current user's last_seen_at timestamp (heartbeat for patient online status).
     */
    public function heartbeat(Request $request)
    {
        auth()->user()->update(['last_seen_at' => now()]);
        return response()->json(['ok' => true]);
    }

    /**
     * Return the list of contacts the current user can chat with.
     * Eligibility: at least one completed appointment between the pair.
     */
    public function getContacts(Request $request)
    {
        $me = auth()->user();

        if ($me->isDoctor()) {
            $contactIds = Appointment::where('doctor_id', $me->id)
                ->where('status', 'completed')
                ->distinct()
                ->pluck('patient_id');
        } else {
            $contactIds = Appointment::where('patient_id', $me->id)
                ->where('status', 'completed')
                ->distinct()
                ->pluck('doctor_id');
        }

        $contacts = User::whereIn('id', $contactIds)->get();

        $result = $contacts->map(function ($contact) use ($me) {
            $lastMsg = ChatMessage::where(function ($q) use ($me, $contact) {
                $q->where('sender_id', $me->id)->where('receiver_id', $contact->id);
            })->orWhere(function ($q) use ($me, $contact) {
                $q->where('sender_id', $contact->id)->where('receiver_id', $me->id);
            })->latest()->first();

            $unread = ChatMessage::where('sender_id', $contact->id)
                ->where('receiver_id', $me->id)
                ->whereNull('read_at')
                ->count();

            $isOnline = $contact->isDoctor()
                ? (bool) $contact->is_available
                : ($contact->last_seen_at && $contact->last_seen_at->gt(now()->subMinutes(5)));

            $photo = $contact->profile_photo
                ? asset('storage/' . $contact->profile_photo)
                : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');

            $name = $contact->isDoctor()
                ? 'Dr ' . $contact->first_name . ' ' . $contact->last_name
                : $contact->first_name . ' ' . $contact->last_name;

            $lastPreview = null;
            if ($lastMsg) {
                $lastPreview = ($lastMsg->image && !$lastMsg->body)
                    ? '📷 Image'
                    : Str::limit($lastMsg->body, 40);
            }

            return [
                'id'                => $contact->id,
                'name'              => $name,
                'photo'             => $photo,
                'is_online'         => $isOnline,
                'last_message'      => $lastPreview,
                'last_message_time' => $lastMsg ? $lastMsg->created_at->diffForHumans() : null,
                'last_message_at'   => $lastMsg ? $lastMsg->created_at->timestamp : 0,
                'unread_count'      => $unread,
            ];
        })->sortByDesc('last_message_at')->values();

        return response()->json($result);
    }

    /**
     * Return paginated messages between current user and the given contact.
     * If after_id=0 (initial load) returns last 100 messages.
     * Otherwise returns only messages newer than after_id (for polling).
     */
    public function getMessages(Request $request, $userId)
    {
        $me      = auth()->user();
        $contact = User::findOrFail($userId);

        if (!$this->canChat($me, $contact)) {
            return response()->json(['error' => 'Not allowed'], 403);
        }

        $afterId = (int) $request->query('after_id', 0);

        $baseQuery = ChatMessage::where(function ($q) use ($me, $contact) {
            $q->where('sender_id', $me->id)->where('receiver_id', $contact->id);
        })->orWhere(function ($q) use ($me, $contact) {
            $q->where('sender_id', $contact->id)->where('receiver_id', $me->id);
        });

        if ($afterId === 0) {
            $messages = (clone $baseQuery)
                ->orderBy('id', 'desc')
                ->limit(100)
                ->get()
                ->reverse()
                ->values();
        } else {
            $messages = (clone $baseQuery)
                ->where('id', '>', $afterId)
                ->orderBy('id')
                ->get();
        }

        // Mark incoming unread messages as read
        ChatMessage::where('sender_id', $contact->id)
            ->where('receiver_id', $me->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $isOnline = $contact->isDoctor()
            ? (bool) $contact->is_available
            : ($contact->last_seen_at && $contact->last_seen_at->gt(now()->subMinutes(5)));

        return response()->json([
            'messages' => $messages->map(fn($msg) => [
                'id'    => $msg->id,
                'body'  => $msg->body,
                'image' => $msg->image ? asset('storage/' . $msg->image) : null,
                'mine'  => $msg->sender_id === $me->id,
                'time'  => $msg->created_at->format('h:i A'),
                'date'  => $msg->created_at->toDateString(),
            ]),
            'is_online' => $isOnline,
        ]);
    }

    /**
     * Store a new message (text and/or image).
     */
    public function sendMessage(Request $request, $userId)
    {
        $me      = auth()->user();
        $contact = User::findOrFail($userId);

        if (!$this->canChat($me, $contact)) {
            return response()->json(['error' => 'Not allowed'], 403);
        }

        $request->validate([
            'body'  => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if (!$request->filled('body') && !$request->hasFile('image')) {
            return response()->json(['error' => 'Message cannot be empty'], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            Storage::disk('public')->makeDirectory('chat_images');
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        $msg = ChatMessage::create([
            'sender_id'   => $me->id,
            'receiver_id' => $contact->id,
            'body'        => $request->filled('body') ? $request->body : null,
            'image'       => $imagePath,
        ]);

        return response()->json([
            'id'    => $msg->id,
            'body'  => $msg->body,
            'image' => $imagePath ? asset('storage/' . $imagePath) : null,
            'mine'  => true,
            'time'  => $msg->created_at->format('h:i A'),
            'date'  => $msg->created_at->toDateString(),
        ]);
    }

    /**
     * Return total unread message count for the current user (used in sidebar badge).
     */
    public function unreadCount(Request $request)
    {
        $count = ChatMessage::where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Determine if two users are eligible to chat.
     * At least one completed appointment must exist between the pair.
     */
    private function canChat(User $a, User $b): bool
    {
        if ($a->isDoctor() && $b->isPatient()) {
            return Appointment::where('doctor_id', $a->id)
                ->where('patient_id', $b->id)
                ->where('status', 'completed')
                ->exists();
        }

        if ($a->isPatient() && $b->isDoctor()) {
            return Appointment::where('doctor_id', $b->id)
                ->where('patient_id', $a->id)
                ->where('status', 'completed')
                ->exists();
        }

        return false;
    }
}
