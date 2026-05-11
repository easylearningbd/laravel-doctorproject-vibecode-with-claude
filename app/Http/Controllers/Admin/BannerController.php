<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BannerController extends Controller
{
    public function index()
    {
        $settings = [
            'heading_before'  => SiteSetting::get('banner_heading_before',  'Discover Health: Find Your Trusted'),
            'gradient_word'   => SiteSetting::get('banner_gradient_word',   'Doctors'),
            'heading_after'   => SiteSetting::get('banner_heading_after',   'Today'),
            'image'           => SiteSetting::get('banner_image',           null),
        ];

        return view('admin.dashboard.manage_home.manage_banner', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'heading_before' => 'required|string|max:200',
            'gradient_word'  => 'required|string|max:100',
            'heading_after'  => 'required|string|max:100',
            'banner_image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        SiteSetting::set('banner_heading_before', $request->heading_before);
        SiteSetting::set('banner_gradient_word',  $request->gradient_word);
        SiteSetting::set('banner_heading_after',  $request->heading_after);

        if ($request->hasFile('banner_image')) {
            // Delete old uploaded banner if any
            $oldPath = SiteSetting::get('banner_image');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $file    = $request->file('banner_image');
            $manager = new ImageManager(new Driver());

            // Resize & cover to exactly 464 × 606 px
            $img = $manager->decodePath($file->getPathname())
                           ->cover(464, 606);

            $filename  = 'banner/banner_image_' . time() . '.jpg';
            $fullPath  = storage_path('app/public/' . $filename);

            // Ensure directory exists
            Storage::disk('public')->makeDirectory('banner');

            $img->encodeUsingMediaType('image/jpeg', 90)->save($fullPath);

            SiteSetting::set('banner_image', $filename);
        }

        return back()->with('success', 'Banner updated successfully.');
    }
}
