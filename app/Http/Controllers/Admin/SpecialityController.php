<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpecialityController extends Controller
{
    public function index()
    {
        $specialities = Speciality::latest()->get();
        return view('admin.dashboard.spcialities.all_spcialities', compact('specialities'));
    }
    // End Method

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255|unique:specialities,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('specialities', 'public');
        }

        Speciality::create([
            'name'  => $request->name,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Speciality added successfully.');
    }
    // End Method

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255|unique:specialities,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $speciality = Speciality::findOrFail($id);

        $imagePath = $speciality->image;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('specialities', 'public');
        }

        $speciality->update([
            'name'  => $request->name,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Speciality updated successfully.');
    }
    // End Method

    public function destroy($id)
    {
        $speciality = Speciality::findOrFail($id);

        if ($speciality->image) {
            Storage::disk('public')->delete($speciality->image);
        }

        $speciality->delete();

        return back()->with('success', 'Speciality deleted successfully.');
    }
    // End Method
}
