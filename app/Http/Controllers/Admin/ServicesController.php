<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $settings = [
            'badge'   => SiteSetting::get('reasons_badge',   'Why Book With Us'),
            'heading' => SiteSetting::get('reasons_heading', 'Compelling Reasons to Choose'),

            'reason_1_icon'  => SiteSetting::get('reason_1_icon',  'isax isax-tag-user5 text-orange'),
            'reason_1_title' => SiteSetting::get('reason_1_title', 'Follow-Up Care'),
            'reason_1_desc'  => SiteSetting::get('reason_1_desc',  'We ensure continuity of care through regular follow-ups and communication, helping you stay on track with health goals.'),

            'reason_2_icon'  => SiteSetting::get('reason_2_icon',  'isax isax-voice-cricle text-purple'),
            'reason_2_title' => SiteSetting::get('reason_2_title', 'Patient-Centered Approach'),
            'reason_2_desc'  => SiteSetting::get('reason_2_desc',  'We prioritize your comfort and preferences, tailoring our services to meet your individual needs and Care from Our Experts'),

            'reason_3_icon'  => SiteSetting::get('reason_3_icon',  'isax isax-wallet-add-15 text-cyan'),
            'reason_3_title' => SiteSetting::get('reason_3_title', 'Convenient Access'),
            'reason_3_desc'  => SiteSetting::get('reason_3_desc',  'Easily book appointments online or through our dedicated customer service team, with flexible hours to fit your schedule.'),
        ];

        return view('admin.dashboard.manage_home.manage_services', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'badge'          => 'required|string|max:100',
            'heading'        => 'required|string|max:200',
            'reason_1_icon'  => 'nullable|string|max:100',
            'reason_1_title' => 'required|string|max:150',
            'reason_1_desc'  => 'required|string|max:500',
            'reason_2_icon'  => 'nullable|string|max:100',
            'reason_2_title' => 'required|string|max:150',
            'reason_2_desc'  => 'required|string|max:500',
            'reason_3_icon'  => 'nullable|string|max:100',
            'reason_3_title' => 'required|string|max:150',
            'reason_3_desc'  => 'required|string|max:500',
        ]);

        $keys = [
            'reasons_badge', 'reasons_heading',
            'reason_1_icon', 'reason_1_title', 'reason_1_desc',
            'reason_2_icon', 'reason_2_title', 'reason_2_desc',
            'reason_3_icon', 'reason_3_title', 'reason_3_desc',
        ];

        $fieldMap = [
            'reasons_badge'    => 'badge',
            'reasons_heading'  => 'heading',
            'reason_1_icon'    => 'reason_1_icon',
            'reason_1_title'   => 'reason_1_title',
            'reason_1_desc'    => 'reason_1_desc',
            'reason_2_icon'    => 'reason_2_icon',
            'reason_2_title'   => 'reason_2_title',
            'reason_2_desc'    => 'reason_2_desc',
            'reason_3_icon'    => 'reason_3_icon',
            'reason_3_title'   => 'reason_3_title',
            'reason_3_desc'    => 'reason_3_desc',
        ];

        foreach ($fieldMap as $settingKey => $fieldName) {
            SiteSetting::set($settingKey, $request->input($fieldName));
        }

        return back()->with('success', 'Services section updated successfully.');
    }
}
