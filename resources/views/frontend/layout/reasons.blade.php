@php
    $reasonsBadge   = \App\Models\SiteSetting::get('reasons_badge',   'Why Book With Us');
    $reasonsHeading = \App\Models\SiteSetting::get('reasons_heading', 'Compelling Reasons to Choose');

    $reasons = [
        [
            'icon'  => \App\Models\SiteSetting::get('reason_1_icon',  'isax isax-tag-user5 text-orange'),
            'title' => \App\Models\SiteSetting::get('reason_1_title', 'Follow-Up Care'),
            'desc'  => \App\Models\SiteSetting::get('reason_1_desc',  'We ensure continuity of care through regular follow-ups and communication, helping you stay on track with health goals.'),
        ],
        [
            'icon'  => \App\Models\SiteSetting::get('reason_2_icon',  'isax isax-voice-cricle text-purple'),
            'title' => \App\Models\SiteSetting::get('reason_2_title', 'Patient-Centered Approach'),
            'desc'  => \App\Models\SiteSetting::get('reason_2_desc',  'We prioritize your comfort and preferences, tailoring our services to meet your individual needs and Care from Our Experts'),
        ],
        [
            'icon'  => \App\Models\SiteSetting::get('reason_3_icon',  'isax isax-wallet-add-15 text-cyan'),
            'title' => \App\Models\SiteSetting::get('reason_3_title', 'Convenient Access'),
            'desc'  => \App\Models\SiteSetting::get('reason_3_desc',  'Easily book appointments online or through our dedicated customer service team, with flexible hours to fit your schedule.'),
        ],
    ];
@endphp

<section class="reason-section">
    <div class="container">
        <div class="section-header sec-header-one text-center aos" data-aos="fade-up">
            <span class="badge badge-primary">{{ $reasonsBadge }}</span>
            <h2>{{ $reasonsHeading }}</h2>
        </div>
        <div class="row row-gap-4 justify-content-center">
            @foreach($reasons as $reason)
            <div class="col-lg-4 col-md-6">
                <div class="reason-item aos" data-aos="fade-up">
                    <h6 class="mb-2 d-flex align-items-center">
                        <i class="{{ $reason['icon'] }} me-2"></i>
                        {{ $reason['title'] }}
                    </h6>
                    <p class="fs-14 mb-0">{{ $reason['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
