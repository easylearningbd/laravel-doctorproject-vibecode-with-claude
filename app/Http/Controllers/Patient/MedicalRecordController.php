<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\PatientMedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $patient = Auth::user();

        $records = PatientMedicalRecord::where('patient_id', $patient->id)
            ->orderBy('record_date', 'desc')
            ->paginate(10);

        return view('patient.dashboard.medical.medical_records', compact('records'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'record_for'  => 'required|string|max:255',
            'record_date' => 'required|date',
            'comments'    => 'nullable|string|max:2000',
            'record_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp,doc,docx|max:10240',
        ]);

        $patient = Auth::user();

        // Generate record number: MR-YYYY-XXXXXX
        $year  = now()->year;
        $last  = PatientMedicalRecord::whereYear('created_at', $year)->max('id') ?? 0;
        $count = PatientMedicalRecord::whereYear('created_at', $year)->count();
        $seq   = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $recordNumber = "MR-{$year}-{$seq}";

        $filePath         = null;
        $fileOriginalName = null;

        if ($request->hasFile('record_file')) {
            $file             = $request->file('record_file');
            $fileOriginalName = $file->getClientOriginalName();
            $filePath         = $file->store("medical_records/patient_{$patient->id}", 'public');
        }

        PatientMedicalRecord::create([
            'patient_id'         => $patient->id,
            'record_number'      => $recordNumber,
            'title'              => $request->title,
            'record_for'         => $request->record_for,
            'record_date'        => $request->record_date,
            'comments'           => $request->comments,
            'file_path'          => $filePath,
            'file_original_name' => $fileOriginalName,
        ]);

        return back()->with('success', 'Medical record added successfully.');
    }

    public function update(Request $request, $id)
    {
        $patient = Auth::user();
        $record  = PatientMedicalRecord::where('patient_id', $patient->id)->findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'record_for'  => 'required|string|max:255',
            'record_date' => 'required|date',
            'comments'    => 'nullable|string|max:2000',
            'record_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp,doc,docx|max:10240',
        ]);

        $filePath         = $record->file_path;
        $fileOriginalName = $record->file_original_name;

        if ($request->hasFile('record_file')) {
            // Delete old file
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $file             = $request->file('record_file');
            $fileOriginalName = $file->getClientOriginalName();
            $filePath         = $file->store("medical_records/patient_{$patient->id}", 'public');
        } elseif ($request->input('remove_file') == '1' && $filePath) {
            Storage::disk('public')->delete($filePath);
            $filePath         = null;
            $fileOriginalName = null;
        }

        $record->update([
            'title'              => $request->title,
            'record_for'         => $request->record_for,
            'record_date'        => $request->record_date,
            'comments'           => $request->comments,
            'file_path'          => $filePath,
            'file_original_name' => $fileOriginalName,
        ]);

        return back()->with('success', 'Medical record updated successfully.');
    }

    public function destroy($id)
    {
        $patient = Auth::user();
        $record  = PatientMedicalRecord::where('patient_id', $patient->id)->findOrFail($id);

        if ($record->file_path) {
            Storage::disk('public')->delete($record->file_path);
        }

        $record->delete();

        return back()->with('success', 'Medical record deleted successfully.');
    }

    public function download($id)
    {
        $patient = Auth::user();
        $record  = PatientMedicalRecord::where('patient_id', $patient->id)->findOrFail($id);

        if (!$record->file_path || !Storage::disk('public')->exists($record->file_path)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download(
            $record->file_path,
            $record->file_original_name ?? basename($record->file_path)
        );
    }
}
