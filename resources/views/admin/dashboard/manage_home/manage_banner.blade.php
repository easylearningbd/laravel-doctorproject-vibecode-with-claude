@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Manage Banner</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('agent.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Manage Home</li>
                    <li class="breadcrumb-item active">Manage Banner</li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Banner Heading Text</h4>
                    <p class="text-muted fs-13 mb-0 mt-1">
                        The heading renders as:
                        <em>[Before Text]</em>
                        <img src="{{ asset('backend/assets/img/icons/video.svg') }}" alt="icon" style="height:22px;vertical-align:middle;"> ← fixed icon
                        <em class="text-primary">[Gradient Word]</em>
                        <em>[After Text]</em>
                    </p>
                </div>
                <div class="card-body">
                    <form action="{{ route('agent.manage.banner.update') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        {{-- Heading Before --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Text Before Icon <span class="text-danger">*</span>
                                <small class="text-muted fw-normal">(appears before the video icon)</small>
                            </label>
                            <input type="text" name="heading_before" class="form-control"
                                   value="{{ old('heading_before', $settings['heading_before']) }}"
                                   placeholder="e.g. Discover Health: Find Your Trusted"
                                   required maxlength="200">
                        </div>

                        {{-- Gradient Word --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Gradient Highlight Word <span class="text-danger">*</span>
                                <small class="text-muted fw-normal">(shown in colour gradient after the icon)</small>
                            </label>
                            <input type="text" name="gradient_word" class="form-control"
                                   value="{{ old('gradient_word', $settings['gradient_word']) }}"
                                   placeholder="e.g. Doctors"
                                   required maxlength="100">
                        </div>

                        {{-- Heading After --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Text After Gradient Word <span class="text-danger">*</span>
                                <small class="text-muted fw-normal">(appears after the gradient word)</small>
                            </label>
                            <input type="text" name="heading_after" class="form-control"
                                   value="{{ old('heading_after', $settings['heading_after']) }}"
                                   placeholder="e.g. Today"
                                   required maxlength="100">
                        </div>

                        <hr class="my-4">

                        {{-- Banner Image --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Banner Doctor Image
                                <small class="text-muted fw-normal">(will be resized to exactly 464 × 606 px · JPEG/PNG/WebP · max 5 MB)</small>
                            </label>

                            {{-- Current image preview --}}
                            @if($settings['image'])
                            <div class="mb-3">
                                <p class="text-muted fs-13 mb-1">Current image:</p>
                                <img src="{{ asset('storage/' . $settings['image']) }}"
                                     alt="Current banner"
                                     style="width:116px;height:151px;object-fit:cover;border-radius:6px;border:1px solid #dee2e6;">
                                <p class="text-muted fs-12 mt-1">Displayed at 464 × 606 (shown here at ¼ size)</p>
                            </div>
                            @else
                            <div class="mb-3">
                                <p class="text-muted fs-13">Current image: <em>default SVG (banner-doctor.svg)</em></p>
                            </div>
                            @endif

                            <input type="file" name="banner_image" class="form-control"
                                   accept="image/jpeg,image/png,image/webp"
                                   id="bannerImageInput">
                            <small class="text-muted">Leave blank to keep the current image.</small>

                            {{-- Preview on select --}}
                            <div id="newPreviewWrap" class="mt-3 d-none">
                                <p class="text-muted fs-13 mb-1">New image preview (will be cropped to 464 × 606):</p>
                                <img id="newPreviewImg" src="#" alt="Preview"
                                     style="width:116px;height:151px;object-fit:cover;border-radius:6px;border:1px solid #dee2e6;">
                            </div>
                        </div>

                        {{-- Live heading preview --}}
                        <div class="mb-4 p-3 rounded" style="background:#f8f9fa;">
                            <p class="text-muted fs-13 mb-2">Live heading preview:</p>
                            <h4 id="headingPreview" class="mb-0">
                                <span id="prevBefore">{{ $settings['heading_before'] }}</span>
                                <img src="{{ asset('backend/assets/img/icons/video.svg') }}" alt="icon"
                                     style="height:24px;vertical-align:middle;margin:0 4px;">
                                <span id="prevGradient" style="background:linear-gradient(90deg,#4f46e5,#0ea5e9);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                                    {{ $settings['gradient_word'] }}
                                </span>
                                <span id="prevAfter"> {{ $settings['heading_after'] }}</span>
                            </h4>
                        </div>

                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fe fe-save me-2"></i>Save Banner
                        </button>
                        <a href="{{ route('home') }}" target="_blank"
                           class="btn btn-outline-secondary ms-2">
                            <i class="fe fe-eye me-2"></i>Preview Frontend
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
$(function () {
    // Live heading preview
    function updatePreview() {
        $('#prevBefore').text($('input[name="heading_before"]').val());
        $('#prevGradient').text($('input[name="gradient_word"]').val());
        $('#prevAfter').text(' ' + $('input[name="heading_after"]').val());
    }

    $('input[name="heading_before"], input[name="gradient_word"], input[name="heading_after"]')
        .on('input', updatePreview);

    // Image preview on file select
    $('#bannerImageInput').on('change', function () {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#newPreviewImg').attr('src', e.target.result);
            $('#newPreviewWrap').removeClass('d-none');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
