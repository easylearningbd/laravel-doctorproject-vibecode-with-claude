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
                <a class="nav-link active" href="{{ route('doctor.profile') }}">Basic Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctor.experience') }}">Experience</a>
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

<div class="setting-title">
    <h5>Profile</h5>
</div>

<form action="{{ route('doctor.profile.post') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Profile Photo -->
    <div class="setting-card">
        <div class="change-avatar img-upload">
            <div class="profile-img" id="photoPreview">
                @if ($doctor->profile_photo)
                    <img src="{{ asset('storage/' . $doctor->profile_photo) }}"
                         alt="Profile Photo"
                         style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                @else
                    <i class="fa-solid fa-file-image"></i>
                @endif
            </div>
            <div class="upload-img">
                <h5>Profile Image</h5>
                <div class="imgs-load d-flex align-items-center">
                    <div class="change-photo">
                        Upload New
                        <input type="file" class="upload" name="profile_photo" id="profilePhotoInput" accept="image/*">
                    </div>
                    <a href="javascript:void(0);" class="upload-remove" id="removePhotoBtn">Remove</a>
                </div>
                <p class="form-text">Your Image should Below 4 MB, Accepted format jpg, png, svg</p>
                <input type="hidden" name="remove_photo" id="removePhotoFlag" value="0">
            </div>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="setting-title">
        <h5>Information</h5>
    </div>
    <div class="setting-card">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-wrap">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                           value="{{ old('first_name', $doctor->first_name) }}" required>
                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-wrap">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                           value="{{ old('last_name', $doctor->last_name) }}" required>
                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-wrap">
                    <label class="form-label">Display Name</label>
                    <input type="text" name="display_name" class="form-control @error('display_name') is-invalid @enderror"
                           value="{{ old('display_name', $doctor->display_name) }}">
                    @error('display_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-wrap">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror"
                           value="{{ old('designation', $doctor->designation) }}">
                    @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-wrap">
                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $doctor->phone) }}" required>
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-wrap">
                    <label class="form-label">Email Address</label>
                    <input type="text" class="form-control" value="{{ $doctor->email }}" readonly>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-wrap">
                    <label class="form-label">Known Languages</label>
                    <div class="input-block input-block-new mb-0">
                        <input class="input-tags form-control"
                               id="inputBox3"
                               type="text"
                               data-role="tagsinput"
                               placeholder="Type and press enter"
                               name="known_languages"
                               value="{{ old('known_languages', implode(',', $doctor->known_languages ?? [])) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Memberships -->
    <div class="setting-title">
        <h5>Memberships</h5>
    </div>
    <div class="setting-card">
        <div class="add-info membership-infos" id="membershipContainer">

            @forelse ($memberships as $index => $membership)
            <div class="row membership-content" data-index="{{ $index }}">
                <div class="col-lg-3 col-md-6">
                    <div class="form-wrap">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                               name="memberships[{{ $index }}][title]"
                               value="{{ old('memberships.' . $index . '.title', $membership->title) }}"
                               placeholder="Add Title">
                    </div>
                </div>
                <div class="col-lg-9 col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="form-wrap w-100">
                            <label class="form-label">About Membership</label>
                            <input type="text" class="form-control"
                                   name="memberships[{{ $index }}][about]"
                                   value="{{ old('memberships.' . $index . '.about', $membership->about) }}">
                        </div>
                        <div class="form-wrap ms-2">
                            <label class="col-form-label d-block">&nbsp;</label>
                            <a href="javascript:void(0);" class="trash-icon trash">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            {{-- No existing memberships — container is empty, JS will add rows --}}
            @endforelse

        </div>
        <div class="text-end">
            <a href="javascript:void(0);" class="more-item" id="addMembershipBtn">Add New</a>
        </div>
    </div>

    <div class="modal-btn text-end">
        <a href="{{ route('doctor.profile') }}" class="btn btn-gray">Cancel</a>
        <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
    </div>

</form>
<!-- /Profile Settings -->

<script>
(function () {
    let membershipIndex = {{ $memberships->count() }};

    // Photo preview on file select
    document.getElementById('profilePhotoInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('photoPreview').innerHTML =
                '<img src="' + e.target.result + '" style="width:80px;height:80px;border-radius:50%;object-fit:cover;" alt="Preview">';
        };
        reader.readAsDataURL(file);
        document.getElementById('removePhotoFlag').value = '0';
    });

    // Remove photo
    document.getElementById('removePhotoBtn').addEventListener('click', function () {
        document.getElementById('photoPreview').innerHTML = '<i class="fa-solid fa-file-image"></i>';
        document.getElementById('profilePhotoInput').value = '';
        document.getElementById('removePhotoFlag').value = '1';
    });

    function buildMembershipRow(index, title, about) {
        return `<div class="row membership-content" data-index="${index}">
            <div class="col-lg-3 col-md-6">
                <div class="form-wrap">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="memberships[${index}][title]" value="${title}" placeholder="Add Title">
                </div>
            </div>
            <div class="col-lg-9 col-md-6">
                <div class="d-flex align-items-center">
                    <div class="form-wrap w-100">
                        <label class="form-label">About Membership</label>
                        <input type="text" class="form-control" name="memberships[${index}][about]" value="${about}">
                    </div>
                    <div class="form-wrap ms-2">
                        <label class="col-form-label d-block">&nbsp;</label>
                        <a href="javascript:void(0);" class="trash-icon trash">Delete</a>
                    </div>
                </div>
            </div>
        </div>`;
    }

    // Add new membership row — profile-settings.js is NOT involved (class removed from button)
    document.getElementById('addMembershipBtn').addEventListener('click', function () {
        const container = document.getElementById('membershipContainer');
        container.insertAdjacentHTML('beforeend', buildMembershipRow(membershipIndex, '', ''));
        membershipIndex++;
    });
})();
</script>

@endsection
