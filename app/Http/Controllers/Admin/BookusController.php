<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BookusController extends Controller
{
    public function index()
    {
        $settings = [
            'badge'             => SiteSetting::get('bookus_badge',             'Why Book With Us'),
            'heading_before'    => SiteSetting::get('bookus_heading_before',    'We are committed to understanding your'),
            'heading_gradient'  => SiteSetting::get('bookus_heading_gradient',  'unique needs and delivering care.'),
            'description'       => SiteSetting::get('bookus_description',       'As a trusted healthcare provider in our community, we are passionate about promoting health and wellness beyond the clinic. We actively engage in community outreach programs, health fairs, and educational workshop.'),
            'faq_1_title'       => SiteSetting::get('bookus_faq_1_title',       'Our Vision'),
            'faq_1_content'     => SiteSetting::get('bookus_faq_1_content',     'We envision a community where everyone has access to high-quality healthcare and the resources they need to lead healthy, fulfilling lives.'),
            'faq_2_title'       => SiteSetting::get('bookus_faq_2_title',       'Our Mission'),
            'faq_2_content'     => SiteSetting::get('bookus_faq_2_content',     'We envision a community where everyone has access to high-quality healthcare and the resources they need to lead healthy, fulfilling lives.'),
            'image_1'           => SiteSetting::get('bookus_image_1',           null),
            'image_2'           => SiteSetting::get('bookus_image_2',           null),
            'image_3'           => SiteSetting::get('bookus_image_3',           null),
        ];

        return view('admin.dashboard.manage_home.manage_bookus', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'badge'            => 'required|string|max:100',
            'heading_before'   => 'required|string|max:300',
            'heading_gradient' => 'required|string|max:200',
            'description'      => 'required|string|max:1000',
            'faq_1_title'      => 'required|string|max:150',
            'faq_1_content'    => 'required|string|max:1000',
            'faq_2_title'      => 'required|string|max:150',
            'faq_2_content'    => 'required|string|max:1000',
            'image_1'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'image_2'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'image_3'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
        ]);

        // Save text fields
        $textMap = [
            'bookus_badge'            => 'badge',
            'bookus_heading_before'   => 'heading_before',
            'bookus_heading_gradient' => 'heading_gradient',
            'bookus_description'      => 'description',
            'bookus_faq_1_title'      => 'faq_1_title',
            'bookus_faq_1_content'    => 'faq_1_content',
            'bookus_faq_2_title'      => 'faq_2_title',
            'bookus_faq_2_content'    => 'faq_2_content',
        ];

        foreach ($textMap as $key => $field) {
            SiteSetting::set($key, $request->input($field));
        }

        Storage::disk('public')->makeDirectory('bookus');

        $manager = new ImageManager(new Driver());

        // image_1 → 1060 × 516
        if ($request->hasFile('image_1')) {
            $this->deleteOld('bookus_image_1');
            $path = 'bookus/book_1_' . time() . '.jpg';
            $manager->decodePath($request->file('image_1')->getPathname())
                    ->cover(1060, 516)
                    ->encodeUsingMediaType('image/jpeg', 90)
                    ->save(storage_path('app/public/' . $path));
            SiteSetting::set('bookus_image_1', $path);
        }

        // image_2 → 512 × 516
        if ($request->hasFile('image_2')) {
            $this->deleteOld('bookus_image_2');
            $path = 'bookus/book_2_' . time() . '.jpg';
            $manager->decodePath($request->file('image_2')->getPathname())
                    ->cover(512, 516)
                    ->encodeUsingMediaType('image/jpeg', 90)
                    ->save(storage_path('app/public/' . $path));
            SiteSetting::set('bookus_image_2', $path);
        }

        // image_3 → 512 × 516
        if ($request->hasFile('image_3')) {
            $this->deleteOld('bookus_image_3');
            $path = 'bookus/book_3_' . time() . '.jpg';
            $manager->decodePath($request->file('image_3')->getPathname())
                    ->cover(512, 516)
                    ->encodeUsingMediaType('image/jpeg', 90)
                    ->save(storage_path('app/public/' . $path));
            SiteSetting::set('bookus_image_3', $path);
        }

        return back()->with('success', 'Book Us section updated successfully.');
    }

    private function deleteOld(string $settingKey): void
    {
        $old = SiteSetting::get($settingKey);
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
    }
}
