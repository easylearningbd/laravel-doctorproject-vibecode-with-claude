@extends('doctor.doctor_master')
@section('doctor')

<!-- Profile Settings -->
<div class="dashboard-header">
    <h3>Profile Settings</h3>
</div>

<!-- Settings List -->
<div class="setting-tab">
    <div class="appointment-tabs">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.profile') }}">Basic Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.experience') }}">Experience</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.education') }}">Education</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('doctor.clinics') }}">Clinics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.hours') }}">Business Hours</a>
            </li>
        </ul>
    </div>
</div>
<!-- /Settings List -->

<div class="dashboard-header border-0 mb-0">
    <h3>Clinics</h3>
    <ul>
        <li>
            <a href="javascript:void(0);" class="btn btn-primary prime-btn" id="addClinicBtn">Add New Clinic</a>
        </li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('doctor.clinics.post') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="accordions clinic-infos" id="clinicAccordion">

        @forelse ($clinics as $index => $clinic)
        <div class="clinic-content" id="clinicItem_{{ $index }}">
            <div class="user-accordion-item">
                <a href="#" class="accordion-wrap" data-bs-toggle="collapse"
                   data-bs-target="#clinic_{{ $index }}">
                    {{ $clinic->clinic_name }}<span class="trash">Delete</span>
                </a>
                <div class="accordion-collapse collapse show" id="clinic_{{ $index }}">
                    <div class="content-collapse">
                        <div class="add-service-info">
                            <div class="add-info">
                                <div class="row align-items-center">

                                    <input type="hidden" name="clinics[{{ $index }}][existing_logo]"
                                           value="{{ $clinic->logo }}" class="existing-logo-input">
                                    <input type="hidden" name="clinics[{{ $index }}][remove_logo]"
                                           value="0" class="remove-logo-flag">

                                    {{-- Clinic Logo --}}
                                    <div class="col-md-12">
                                        <div class="form-wrap mb-2">
                                            <div class="change-avatar img-upload">
                                                <div class="profile-img logo-preview">
                                                    @if ($clinic->logo)
                                                        <img src="{{ asset('storage/' . $clinic->logo) }}"
                                                             style="width:60px;height:60px;object-fit:cover;border-radius:4px;"
                                                             alt="Logo">
                                                    @else
                                                        <i class="fa-solid fa-file-image"></i>
                                                    @endif
                                                </div>
                                                <div class="upload-img">
                                                    <h5>Logo</h5>
                                                    <div class="imgs-load d-flex align-items-center">
                                                        <div class="change-photo">
                                                            Upload New
                                                            <input type="file"
                                                                   name="clinic_logos[{{ $index }}]"
                                                                   class="upload logo-file-input"
                                                                   accept="image/*">
                                                        </div>
                                                        <a href="javascript:void(0);" class="upload-remove remove-logo-btn">Remove</a>
                                                    </div>
                                                    <p class="form-text">Below 4 MB, jpg/png/svg</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Clinic Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                   name="clinics[{{ $index }}][clinic_name]"
                                                   value="{{ old('clinics.' . $index . '.clinic_name', $clinic->clinic_name) }}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Location</label>
                                            <input type="text" class="form-control"
                                                   name="clinics[{{ $index }}][location]"
                                                   value="{{ old('clinics.' . $index . '.location', $clinic->location) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Address</label>
                                            <input type="text" class="form-control"
                                                   name="clinics[{{ $index }}][address]"
                                                   value="{{ old('clinics.' . $index . '.address', $clinic->address) }}">
                                        </div>
                                    </div>

                                    {{-- Gallery --}}
                                    <div class="col-md-12">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Gallery</label>
                                            <div class="drop-file">
                                                <p>Drop files or Click to upload</p>
                                                <input type="file"
                                                       name="clinic_new_galleries[{{ $index }}][]"
                                                       class="gallery-file-input"
                                                       multiple
                                                       accept="image/*">
                                            </div>
                                            <div class="view-imgs gallery-preview" id="gallery_{{ $index }}">
                                                @foreach ($clinic->gallery ?? [] as $imgPath)
                                                <div class="view-img">
                                                    <img src="{{ asset('storage/' . $imgPath) }}" alt="img">
                                                    <a href="javascript:void(0);" class="remove-gallery-img">Remove</a>
                                                    <input type="hidden"
                                                           name="clinics[{{ $index }}][keep_gallery][]"
                                                           value="{{ $imgPath }}"
                                                           class="keep-gallery-input">
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            {{-- No clinics yet; JS will add rows --}}
        @endforelse

    </div>

    <div class="modal-btn text-end mt-3">
        <a href="{{ route('doctor.clinics') }}" class="btn btn-gray">Cancel</a>
        <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
    </div>

</form>
<!-- /Profile Settings -->


<script>
(function () {
    let clinicIndex = {{ $clinics->count() }};

    /* ── Build a new clinic accordion row ── */
    function buildClinicRow(i) {
        return `
        <div class="clinic-content" id="clinicItem_${i}">
            <div class="user-accordion-item">
                <a href="#" class="accordion-wrap" data-bs-toggle="collapse" data-bs-target="#clinic_${i}">
                    New Clinic<span class="trash">Delete</span>
                </a>
                <div class="accordion-collapse collapse show" id="clinic_${i}">
                    <div class="content-collapse">
                        <div class="add-service-info">
                            <div class="add-info">
                                <div class="row align-items-center">

                                    <input type="hidden" name="clinics[${i}][existing_logo]" value="" class="existing-logo-input">
                                    <input type="hidden" name="clinics[${i}][remove_logo]" value="0" class="remove-logo-flag">

                                    <div class="col-md-12">
                                        <div class="form-wrap mb-2">
                                            <div class="change-avatar img-upload">
                                                <div class="profile-img logo-preview">
                                                    <i class="fa-solid fa-file-image"></i>
                                                </div>
                                                <div class="upload-img">
                                                    <h5>Logo</h5>
                                                    <div class="imgs-load d-flex align-items-center">
                                                        <div class="change-photo">
                                                            Upload New
                                                            <input type="file" name="clinic_logos[${i}]" class="upload logo-file-input" accept="image/*">
                                                        </div>
                                                        <a href="javascript:void(0);" class="upload-remove remove-logo-btn">Remove</a>
                                                    </div>
                                                    <p class="form-text">Below 4 MB, jpg/png/svg</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Clinic Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="clinics[${i}][clinic_name]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Location</label>
                                            <input type="text" class="form-control" name="clinics[${i}][location]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Address</label>
                                            <input type="text" class="form-control" name="clinics[${i}][address]">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Gallery</label>
                                            <div class="drop-file">
                                                <p>Drop files or Click to upload</p>
                                                <input type="file" name="clinic_new_galleries[${i}][]" class="gallery-file-input" multiple accept="image/*">
                                            </div>
                                            <div class="view-imgs gallery-preview" id="gallery_${i}"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    }

    /* ── Add Clinic ── */
    document.getElementById('addClinicBtn').addEventListener('click', function () {
        document.getElementById('clinicAccordion')
            .insertAdjacentHTML('beforeend', buildClinicRow(clinicIndex));
        clinicIndex++;
    });

    /* ── Delete Clinic (delegated) ── */
    document.getElementById('clinicAccordion').addEventListener('click', function (e) {
        if (e.target.classList.contains('trash')) {
            e.preventDefault();
            e.target.closest('.clinic-content').remove();
        }
    });

    /* ── Logo preview (delegated) ── */
    document.getElementById('clinicAccordion').addEventListener('change', function (e) {
        if (e.target.classList.contains('logo-file-input')) {
            const file = e.target.files[0];
            if (!file) return;
            const reader  = new FileReader();
            const preview = e.target.closest('.change-avatar').querySelector('.logo-preview');
            reader.onload = ev => {
                preview.innerHTML = `<img src="${ev.target.result}" style="width:60px;height:60px;object-fit:cover;border-radius:4px;" alt="Logo">`;
            };
            reader.readAsDataURL(file);
            e.target.closest('.clinic-content').querySelector('.remove-logo-flag').value = '0';
        }

        /* ── Gallery preview on file select ── */
        if (e.target.classList.contains('gallery-file-input')) {
            const previewContainer = e.target.closest('.add-info').querySelector('.gallery-preview');
            Array.from(e.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = ev => {
                    previewContainer.insertAdjacentHTML('beforeend',
                        `<div class="view-img new-gallery-preview">
                            <img src="${ev.target.result}" alt="img">
                            <span class="text-muted" style="font-size:11px;">New</span>
                        </div>`
                    );
                };
                reader.readAsDataURL(file);
            });
        }
    });

    /* ── Remove Logo (delegated) ── */
    document.getElementById('clinicAccordion').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-logo-btn')) {
            e.preventDefault();
            const item    = e.target.closest('.clinic-content');
            const preview = e.target.closest('.change-avatar').querySelector('.logo-preview');
            preview.innerHTML = '<i class="fa-solid fa-file-image"></i>';
            item.querySelector('.logo-file-input').value     = '';
            item.querySelector('.existing-logo-input').value = '';
            item.querySelector('.remove-logo-flag').value    = '1';
        }

        /* ── Remove existing gallery image (delegated) ── */
        if (e.target.classList.contains('remove-gallery-img')) {
            e.preventDefault();
            e.target.closest('.view-img').remove();
        }
    });

})();
</script>

@endsection
