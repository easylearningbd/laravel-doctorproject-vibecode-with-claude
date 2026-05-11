@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Manage Book Us Section</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Manage Home</li>
                    <li class="breadcrumb-item active">Manage Book Us</li>
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

    <form action="{{ route('agent.manage.bookus.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ── Images ─────────────────────────────────────────── --}}
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">Section Images</h4>
                <p class="text-muted fs-13 mb-0 mt-1">Leave any field blank to keep the current image.</p>
            </div>
            <div class="card-body">
                <div class="row g-4">

                    {{-- Image 1 — wide (1060×516) --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">
                            Main Image (top)
                            <small class="text-muted fw-normal">— will be resized to exactly 1060 × 516 px</small>
                        </label>
                        @if($settings['image_1'])
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $settings['image_1']) }}"
                                 alt="Current main image"
                                 style="max-height:120px;border-radius:6px;border:1px solid #dee2e6;">
                            <p class="text-muted fs-12 mt-1">Current image (1060 × 516)</p>
                        </div>
                        @else
                        <p class="text-muted fs-13 mb-2">Current: <em>default (book-01.jpg)</em></p>
                        @endif
                        <input type="file" name="image_1" class="form-control preview-trigger"
                               data-target="#prev1" accept="image/jpeg,image/png,image/webp">
                        <div id="prev1" class="mt-2 d-none">
                            <img src="#" alt="Preview"
                                 style="max-height:120px;border-radius:6px;border:1px solid #dee2e6;">
                        </div>
                    </div>

                    {{-- Images 2 & 3 — small (512×516) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Bottom Left Image
                            <small class="text-muted fw-normal">— 512 × 516 px</small>
                        </label>
                        @if($settings['image_2'])
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $settings['image_2']) }}"
                                 alt="Current image 2"
                                 style="max-height:100px;border-radius:6px;border:1px solid #dee2e6;">
                        </div>
                        @else
                        <p class="text-muted fs-13 mb-2">Current: <em>default (book-02.jpg)</em></p>
                        @endif
                        <input type="file" name="image_2" class="form-control preview-trigger"
                               data-target="#prev2" accept="image/jpeg,image/png,image/webp">
                        <div id="prev2" class="mt-2 d-none">
                            <img src="#" alt="Preview"
                                 style="max-height:100px;border-radius:6px;border:1px solid #dee2e6;">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Bottom Right Image
                            <small class="text-muted fw-normal">— 512 × 516 px</small>
                        </label>
                        @if($settings['image_3'])
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $settings['image_3']) }}"
                                 alt="Current image 3"
                                 style="max-height:100px;border-radius:6px;border:1px solid #dee2e6;">
                        </div>
                        @else
                        <p class="text-muted fs-13 mb-2">Current: <em>default (book-03.jpg)</em></p>
                        @endif
                        <input type="file" name="image_3" class="form-control preview-trigger"
                               data-target="#prev3" accept="image/jpeg,image/png,image/webp">
                        <div id="prev3" class="mt-2 d-none">
                            <img src="#" alt="Preview"
                                 style="max-height:100px;border-radius:6px;border:1px solid #dee2e6;">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Section Heading ─────────────────────────────────── --}}
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">Section Heading</h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Badge Text <span class="text-danger">*</span></label>
                        <input type="text" name="badge" class="form-control"
                               value="{{ old('badge', $settings['badge']) }}"
                               placeholder="e.g. Why Book With Us" required maxlength="100">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">
                            Heading — Normal Text <span class="text-danger">*</span>
                            <small class="text-muted fw-normal">(white part)</small>
                        </label>
                        <input type="text" name="heading_before" class="form-control"
                               value="{{ old('heading_before', $settings['heading_before']) }}"
                               placeholder="e.g. We are committed to understanding your"
                               required maxlength="300">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">
                            Heading — Gradient Text <span class="text-danger">*</span>
                            <small class="text-muted fw-normal">(highlighted part in colour gradient)</small>
                        </label>
                        <input type="text" name="heading_gradient" class="form-control"
                               value="{{ old('heading_gradient', $settings['heading_gradient']) }}"
                               placeholder="e.g. unique needs and delivering care."
                               required maxlength="200">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description Paragraph <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3"
                                  required maxlength="1000"
                                  placeholder="Short description text...">{{ old('description', $settings['description']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── FAQ / Accordion Items ────────────────────────────── --}}
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">Accordion Items</h4>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    @foreach([1,2] as $i)
                    <div class="col-md-6">
                        <div class="p-3 border rounded">
                            <h6 class="fw-semibold mb-3">Item {{ $i }}</h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <input type="text" name="faq_{{ $i }}_title" class="form-control"
                                       value="{{ old('faq_'.$i.'_title', $settings['faq_'.$i.'_title']) }}"
                                       placeholder="e.g. Our Vision" required maxlength="150">
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                                <textarea name="faq_{{ $i }}_content" class="form-control" rows="4"
                                          required maxlength="1000"
                                          placeholder="Accordion content...">{{ old('faq_'.$i.'_content', $settings['faq_'.$i.'_content']) }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 mb-5">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fe fe-save me-2"></i>Save Changes
            </button>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">
                <i class="fe fe-eye me-2"></i>Preview Frontend
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
$(function () {
    // Instant image preview on file select
    $(document).on('change', '.preview-trigger', function () {
        var target = $($(this).data('target'));
        var file   = this.files[0];
        if (!file) { target.addClass('d-none'); return; }
        var reader = new FileReader();
        reader.onload = function (e) {
            target.find('img').attr('src', e.target.result);
            target.removeClass('d-none');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
