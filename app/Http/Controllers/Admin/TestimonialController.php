<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.dashboard.manage_home.manage_testimonials', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating'          => 'required|integer|min:1|max:5',
            'title'           => 'required|string|max:150',
            'content'         => 'required|string|max:1000',
            'author_name'     => 'required|string|max:150',
            'author_location' => 'nullable|string|max:100',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'is_active'       => 'nullable|boolean',
            'sort_order'      => 'nullable|integer|min:0',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $this->processPhoto($request->file('photo'));
        }

        Testimonial::create([
            'rating'          => $request->rating,
            'title'           => $request->title,
            'content'         => $request->content,
            'author_name'     => $request->author_name,
            'author_location' => $request->author_location,
            'photo'           => $photoPath,
            'is_active'       => $request->boolean('is_active', true),
            'sort_order'      => $request->input('sort_order', 0),
        ]);

        return back()->with('success', 'Testimonial added successfully.');
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'rating'          => 'required|integer|min:1|max:5',
            'title'           => 'required|string|max:150',
            'content'         => 'required|string|max:1000',
            'author_name'     => 'required|string|max:150',
            'author_location' => 'nullable|string|max:100',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'is_active'       => 'nullable|boolean',
            'sort_order'      => 'nullable|integer|min:0',
        ]);

        $photoPath = $testimonial->photo;

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $this->processPhoto($request->file('photo'));
        }

        $testimonial->update([
            'rating'          => $request->rating,
            'title'           => $request->title,
            'content'         => $request->content,
            'author_name'     => $request->author_name,
            'author_location' => $request->author_location,
            'photo'           => $photoPath,
            'is_active'       => $request->boolean('is_active', true),
            'sort_order'      => $request->input('sort_order', 0),
        ]);

        return back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->photo) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted successfully.');
    }

    private function processPhoto($file): string
    {
        Storage::disk('public')->makeDirectory('testimonials');

        $manager  = new ImageManager(new Driver());
        $filename = 'testimonials/testimonial_' . time() . '_' . rand(100, 999) . '.jpg';
        $fullPath = storage_path('app/public/' . $filename);

        $manager->decodePath($file->getPathname())
                ->cover(300, 300)
                ->encodeUsingMediaType('image/jpeg', 90)
                ->save($fullPath);

        return $filename;
    }
}
