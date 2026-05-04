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
                <a class="nav-link active" href="{{ route('doctor.experience') }}">Experience</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.education') }}">Education</a>
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
    <h3>Experience</h3>
    <ul>
        <li>
            <a href="javascript:void(0);" class="btn btn-primary prime-btn" id="addExperienceBtn">Add New Experience</a>
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

<form action="{{ route('doctor.experience.post') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="accordions experience-infos" id="experienceAccordion">

        @forelse ($experiences as $index => $exp)
        <div class="experience-content" id="expItem_{{ $index }}">
            <div class="user-accordion-item">
                <a href="#" class="accordion-wrap" data-bs-toggle="collapse"
                   data-bs-target="#exp_{{ $index }}">
                    {{ $exp->hospital_name }}<span class="trash">Delete</span>
                </a>
                <div class="accordion-collapse collapse show" id="exp_{{ $index }}">
                    <div class="content-collapse">
                        <div class="add-service-info">
                            <div class="add-info">
                                <div class="row align-items-center">

                                    {{-- Hidden: keep existing logo path --}}
                                    <input type="hidden" name="experiences[{{ $index }}][existing_logo]"
                                           value="{{ $exp->logo }}"
                                           class="existing-logo-input">
                                    <input type="hidden" name="experiences[{{ $index }}][remove_logo]"
                                           value="0"
                                           class="remove-logo-flag">

                                    {{-- Hospital Logo --}}
                                    <div class="col-md-12">
                                        <div class="form-wrap mb-2">
                                            <div class="change-avatar img-upload">
                                                <div class="profile-img logo-preview">
                                                    @if ($exp->logo)
                                                        <img src="{{ asset('storage/' . $exp->logo) }}"
                                                             style="width:60px;height:60px;object-fit:cover;border-radius:4px;"
                                                             alt="Logo">
                                                    @else
                                                        <i class="fa-solid fa-file-image"></i>
                                                    @endif
                                                </div>
                                                <div class="upload-img">
                                                    <h5>Hospital Logo</h5>
                                                    <div class="imgs-load d-flex align-items-center">
                                                        <div class="change-photo">
                                                            Upload New
                                                            <input type="file"
                                                                   name="experience_logos[{{ $index }}]"
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

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Title</label>
                                            <input type="text" class="form-control"
                                                   name="experiences[{{ $index }}][title]"
                                                   value="{{ old('experiences.' . $index . '.title', $exp->title) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Hospital <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                   name="experiences[{{ $index }}][hospital_name]"
                                                   value="{{ old('experiences.' . $index . '.hospital_name', $exp->hospital_name) }}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Year of Experience</label>
                                            <input type="text" class="form-control"
                                                   name="experiences[{{ $index }}][years_of_experience]"
                                                   value="{{ old('experiences.' . $index . '.years_of_experience', $exp->years_of_experience) }}"
                                                   placeholder="e.g. 5">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Location</label>
                                            <input type="text" class="form-control"
                                                   name="experiences[{{ $index }}][location]"
                                                   value="{{ old('experiences.' . $index . '.location', $exp->location) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Employment</label>
                                            <select class="select form-control"
                                                    name="experiences[{{ $index }}][employment_type]">
                                                <option value="Full Time" {{ old('experiences.' . $index . '.employment_type', $exp->employment_type) === 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                                <option value="Part Time" {{ old('experiences.' . $index . '.employment_type', $exp->employment_type) === 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Job Description</label>
                                            <textarea class="form-control" rows="3"
                                                      name="experiences[{{ $index }}][description]">{{ old('experiences.' . $index . '.description', $exp->description) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Start Date</label>
                                            <div class="form-icon">
                                                <input type="date" class="form-control"
                                                       name="experiences[{{ $index }}][start_date]"
                                                       value="{{ old('experiences.' . $index . '.start_date', $exp->start_date?->format('Y-m-d')) }}">
                                                <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 end-date-wrap">
                                        <div class="form-wrap">
                                            <label class="col-form-label">End Date</label>
                                            <div class="form-icon">
                                                <input type="date" class="form-control end-date-input"
                                                       name="experiences[{{ $index }}][end_date]"
                                                       value="{{ old('experiences.' . $index . '.end_date', $exp->end_date?->format('Y-m-d')) }}"
                                                       {{ $exp->currently_working ? 'disabled' : '' }}>
                                                <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label d-block">&nbsp;</label>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input currently-working-chk"
                                                           type="checkbox"
                                                           name="experiences[{{ $index }}][currently_working]"
                                                           value="1"
                                                           {{ old('experiences.' . $index . '.currently_working', $exp->currently_working) ? 'checked' : '' }}>
                                                    I Currently Work Here
                                                </label>
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
            {{-- No experiences yet; JS will add rows --}}
        @endforelse

    </div>

    <div class="modal-btn text-end mt-3">
        <a href="{{ route('doctor.experience') }}" class="btn btn-gray">Cancel</a>
        <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
    </div>

</form>
<!-- /Profile Settings -->


<script>
(function () {
    let expIndex = {{ $experiences->count() }};

    /* ── Build a new accordion row ── */
    function buildExpRow(i) {
        return `
        <div class="experience-content" id="expItem_${i}">
            <div class="user-accordion-item">
                <a href="#" class="accordion-wrap" data-bs-toggle="collapse" data-bs-target="#exp_${i}">
                    New Experience<span class="trash">Delete</span>
                </a>
                <div class="accordion-collapse collapse show" id="exp_${i}">
                    <div class="content-collapse">
                        <div class="add-service-info">
                            <div class="add-info">
                                <div class="row align-items-center">

                                    <input type="hidden" name="experiences[${i}][existing_logo]" value="" class="existing-logo-input">
                                    <input type="hidden" name="experiences[${i}][remove_logo]" value="0" class="remove-logo-flag">

                                    <div class="col-md-12">
                                        <div class="form-wrap mb-2">
                                            <div class="change-avatar img-upload">
                                                <div class="profile-img logo-preview">
                                                    <i class="fa-solid fa-file-image"></i>
                                                </div>
                                                <div class="upload-img">
                                                    <h5>Hospital Logo</h5>
                                                    <div class="imgs-load d-flex align-items-center">
                                                        <div class="change-photo">
                                                            Upload New
                                                            <input type="file" name="experience_logos[${i}]" class="upload logo-file-input" accept="image/*">
                                                        </div>
                                                        <a href="javascript:void(0);" class="upload-remove remove-logo-btn">Remove</a>
                                                    </div>
                                                    <p class="form-text">Below 4 MB, jpg/png/svg</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Title</label>
                                            <input type="text" class="form-control" name="experiences[${i}][title]">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Hospital <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="experiences[${i}][hospital_name]" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Year of Experience</label>
                                            <input type="text" class="form-control" name="experiences[${i}][years_of_experience]" placeholder="e.g. 5">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Location</label>
                                            <input type="text" class="form-control" name="experiences[${i}][location]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Employment</label>
                                            <select class="select form-control" name="experiences[${i}][employment_type]">
                                                <option value="Full Time">Full Time</option>
                                                <option value="Part Time">Part Time</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Job Description</label>
                                            <textarea class="form-control" rows="3" name="experiences[${i}][description]"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label">Start Date</label>
                                            <div class="form-icon">
                                                <input type="date" class="form-control" name="experiences[${i}][start_date]">
                                                <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 end-date-wrap">
                                        <div class="form-wrap">
                                            <label class="col-form-label">End Date</label>
                                            <div class="form-icon">
                                                <input type="date" class="form-control end-date-input" name="experiences[${i}][end_date]">
                                                <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-wrap">
                                            <label class="col-form-label d-block">&nbsp;</label>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input currently-working-chk" type="checkbox"
                                                           name="experiences[${i}][currently_working]" value="1">
                                                    I Currently Work Here
                                                </label>
                                            </div>
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

    /* ── Add Experience ── */
    document.getElementById('addExperienceBtn').addEventListener('click', function () {
        document.getElementById('experienceAccordion')
            .insertAdjacentHTML('beforeend', buildExpRow(expIndex));
        expIndex++;
    });

    /* ── Delete Experience (delegated) ── */
    document.getElementById('experienceAccordion').addEventListener('click', function (e) {
        if (e.target.classList.contains('trash')) {
            e.preventDefault();
            e.target.closest('.experience-content').remove();
        }
    });

    /* ── Logo preview + remove (delegated) ── */
    document.getElementById('experienceAccordion').addEventListener('change', function (e) {
        if (e.target.classList.contains('logo-file-input')) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            const preview = e.target.closest('.change-avatar').querySelector('.logo-preview');
            reader.onload = ev => {
                preview.innerHTML = `<img src="${ev.target.result}" style="width:60px;height:60px;object-fit:cover;border-radius:4px;" alt="Logo">`;
            };
            reader.readAsDataURL(file);
            // clear remove flag
            e.target.closest('.experience-content').querySelector('.remove-logo-flag').value = '0';
        }
    });

    document.getElementById('experienceAccordion').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-logo-btn')) {
            e.preventDefault();
            const item    = e.target.closest('.experience-content');
            const preview = e.target.closest('.change-avatar').querySelector('.logo-preview');
            preview.innerHTML = '<i class="fa-solid fa-file-image"></i>';
            item.querySelector('.logo-file-input').value = '';
            item.querySelector('.existing-logo-input').value = '';
            item.querySelector('.remove-logo-flag').value = '1';
        }
    });

    /* ── Currently Working toggle (delegated) ── */
    document.getElementById('experienceAccordion').addEventListener('change', function (e) {
        if (e.target.classList.contains('currently-working-chk')) {
            const endDateWrap  = e.target.closest('.row').querySelector('.end-date-wrap');
            const endDateInput = endDateWrap.querySelector('.end-date-input');
            if (e.target.checked) {
                endDateInput.disabled = true;
                endDateInput.value    = '';
            } else {
                endDateInput.disabled = false;
            }
        }
    });

})();
</script>

@endsection
