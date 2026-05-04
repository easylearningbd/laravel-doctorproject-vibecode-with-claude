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
                <a class="nav-link active" href="{{ route('doctor.education') }}">Education</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.clinics') }}">Clinics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.hours') }}">Business Hours</a>
            </li>
        </ul>
    </div>
</div>
<!-- /Settings List -->

<div class="dashboard-header border-0 mb-0">
    <h3>Education</h3>
    <ul>
        <li>
            <a href="javascript:void(0);" class="btn btn-primary prime-btn" id="addEducationBtn">Add New Education</a>
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

<form action="{{ route('doctor.education.post') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="accordions education-infos" id="educationAccordion">

        @forelse ($educations as $index => $edu)
        <div class="education-content" id="eduItem_{{ $index }}">
            <div class="user-accordion-item">
                <a href="#" class="accordion-wrap" data-bs-toggle="collapse"
                   data-bs-target="#edu_{{ $index }}">
                    {{ $edu->institution_name }}<span class="trash">Delete</span>
                </a>
                <div class="accordion-collapse collapse show" id="edu_{{ $index }}">
                    <div class="content-collapse">
                        <div class="add-service-info">
                            <div class="add-info">
                                <div class="row align-items-center">

                                    <input type="hidden" name="educations[{{ $index }}][existing_logo]"
                                           value="{{ $edu->logo }}" class="existing-logo-input">
                                    <input type="hidden" name="educations[{{ $index }}][remove_logo]"
                                           value="0" class="remove-logo-flag">

                                    {{-- Institution Logo --}}
                                    <div class="col-md-12">
                                        <div class="form-wrap mb-2">
                                            <div class="change-avatar img-upload">
                                                <div class="profile-img logo-preview">
                                                    @if ($edu->logo)
                                                        <img src="{{ asset('storage/' . $edu->logo) }}"
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
                                                                   name="education_logos[{{ $index }}]"
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

                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Name of the Institution <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                   name="educations[{{ $index }}][institution_name]"
                                                   value="{{ old('educations.' . $index . '.institution_name', $edu->institution_name) }}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Course</label>
                                            <input type="text" class="form-control"
                                                   name="educations[{{ $index }}][course]"
                                                   value="{{ old('educations.' . $index . '.course', $edu->course) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Start Date</label>
                                            <div class="form-icon">
                                                <input type="date" class="form-control"
                                                       name="educations[{{ $index }}][start_date]"
                                                       value="{{ old('educations.' . $index . '.start_date', $edu->start_date?->format('Y-m-d')) }}">
                                                <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">End Date</label>
                                            <div class="form-icon">
                                                <input type="date" class="form-control"
                                                       name="educations[{{ $index }}][end_date]"
                                                       value="{{ old('educations.' . $index . '.end_date', $edu->end_date?->format('Y-m-d')) }}">
                                                <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">No of Years</label>
                                            <input type="text" class="form-control"
                                                   name="educations[{{ $index }}][no_of_years]"
                                                   value="{{ old('educations.' . $index . '.no_of_years', $edu->no_of_years) }}"
                                                   placeholder="e.g. 4">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Description</label>
                                            <textarea class="form-control" rows="3"
                                                      name="educations[{{ $index }}][description]">{{ old('educations.' . $index . '.description', $edu->description) }}</textarea>
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
            {{-- No educations yet; JS will add rows --}}
        @endforelse

    </div>

    <div class="modal-btn text-end mt-3">
        <a href="{{ route('doctor.education') }}" class="btn btn-gray">Cancel</a>
        <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
    </div>

</form>
<!-- /Profile Settings -->


<script>
(function () {
    let eduIndex = {{ $educations->count() }};

    /* ── Build a new accordion row ── */
    function buildEduRow(i) {
        return `
        <div class="education-content" id="eduItem_${i}">
            <div class="user-accordion-item">
                <a href="#" class="accordion-wrap" data-bs-toggle="collapse" data-bs-target="#edu_${i}">
                    New Education<span class="trash">Delete</span>
                </a>
                <div class="accordion-collapse collapse show" id="edu_${i}">
                    <div class="content-collapse">
                        <div class="add-service-info">
                            <div class="add-info">
                                <div class="row align-items-center">

                                    <input type="hidden" name="educations[${i}][existing_logo]" value="" class="existing-logo-input">
                                    <input type="hidden" name="educations[${i}][remove_logo]" value="0" class="remove-logo-flag">

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
                                                            <input type="file" name="education_logos[${i}]" class="upload logo-file-input" accept="image/*">
                                                        </div>
                                                        <a href="javascript:void(0);" class="upload-remove remove-logo-btn">Remove</a>
                                                    </div>
                                                    <p class="form-text">Below 4 MB, jpg/png/svg</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Name of the Institution <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="educations[${i}][institution_name]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Course</label>
                                            <input type="text" class="form-control" name="educations[${i}][course]">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Start Date</label>
                                            <div class="form-icon">
                                                <input type="date" class="form-control" name="educations[${i}][start_date]">
                                                <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">End Date</label>
                                            <div class="form-icon">
                                                <input type="date" class="form-control" name="educations[${i}][end_date]">
                                                <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">No of Years</label>
                                            <input type="text" class="form-control" name="educations[${i}][no_of_years]" placeholder="e.g. 4">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Description</label>
                                            <textarea class="form-control" rows="3" name="educations[${i}][description]"></textarea>
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

    /* ── Add Education ── */
    document.getElementById('addEducationBtn').addEventListener('click', function () {
        document.getElementById('educationAccordion')
            .insertAdjacentHTML('beforeend', buildEduRow(eduIndex));
        eduIndex++;
    });

    /* ── Delete Education (delegated) ── */
    document.getElementById('educationAccordion').addEventListener('click', function (e) {
        if (e.target.classList.contains('trash')) {
            e.preventDefault();
            e.target.closest('.education-content').remove();
        }
    });

    /* ── Logo preview (delegated) ── */
    document.getElementById('educationAccordion').addEventListener('change', function (e) {
        if (e.target.classList.contains('logo-file-input')) {
            const file = e.target.files[0];
            if (!file) return;
            const reader  = new FileReader();
            const preview = e.target.closest('.change-avatar').querySelector('.logo-preview');
            reader.onload = ev => {
                preview.innerHTML = `<img src="${ev.target.result}" style="width:60px;height:60px;object-fit:cover;border-radius:4px;" alt="Logo">`;
            };
            reader.readAsDataURL(file);
            e.target.closest('.education-content').querySelector('.remove-logo-flag').value = '0';
        }
    });

    /* ── Remove Logo (delegated) ── */
    document.getElementById('educationAccordion').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-logo-btn')) {
            e.preventDefault();
            const item    = e.target.closest('.education-content');
            const preview = e.target.closest('.change-avatar').querySelector('.logo-preview');
            preview.innerHTML = '<i class="fa-solid fa-file-image"></i>';
            item.querySelector('.logo-file-input').value    = '';
            item.querySelector('.existing-logo-input').value = '';
            item.querySelector('.remove-logo-flag').value   = '1';
        }
    });

})();
</script>

@endsection
