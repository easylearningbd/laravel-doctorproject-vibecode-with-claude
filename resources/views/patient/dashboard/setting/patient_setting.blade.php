@extends('patient.patient_master')
@section('patient')

<div class="col-lg-8 col-xl-9">
    <nav class="settings-tab mb-1">
        <ul class="nav nav-tabs-bottom" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="{{ route('patient.setting') }}">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('patient.change.password') }}">Change Password</a>
            </li>
        </ul>
    </nav>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="border-bottom pb-3 mb-3">
                <h5>Profile Settings</h5>
            </div>

            <form action="{{ route('patient.setting.post') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Profile Photo --}}
                <div class="setting-card">
                    <label class="form-label mb-2">Profile Photo</label>
                    <div class="change-avatar img-upload">
                        <div class="profile-img" id="photoPreview">
                            @if ($patient->profile_photo)
                                <img src="{{ asset('storage/' . $patient->profile_photo) }}"
                                     alt="Profile"
                                     style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                            @else
                                <i class="fa-solid fa-file-image"></i>
                            @endif
                        </div>
                        <div class="upload-img">
                            <div class="imgs-load d-flex align-items-center">
                                <div class="change-photo">
                                    Upload New
                                    <input type="file" class="upload" name="profile_photo"
                                           id="profilePhotoInput" accept="image/*">
                                </div>
                                <a href="javascript:void(0);" class="upload-remove" id="removePhotoBtn">Remove</a>
                            </div>
                            <p>Your Image should Below 4 MB, Accepted format jpg, png, svg</p>
                            <input type="hidden" name="remove_photo" id="removePhotoFlag" value="0">
                        </div>
                    </div>
                </div>

                {{-- Information --}}
                <div class="setting-title">
                    <h6>Information</h6>
                </div>
                <div class="setting-card">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name"
                                       class="form-control @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name', $patient->first_name) }}"
                                       required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name"
                                       class="form-control @error('last_name') is-invalid @enderror"
                                       value="{{ old('last_name', $patient->last_name) }}"
                                       required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="date" name="date_of_birth"
                                           class="form-control @error('date_of_birth') is-invalid @enderror"
                                           value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d')) }}"
                                           required>
                                    <span class="icon"><i class="isax isax-calendar-1"></i></span>
                                </div>
                                @error('date_of_birth')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $patient->phone) }}"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control"
                                       value="{{ $patient->email }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Blood Group <span class="text-danger">*</span></label>
                                <select name="blood_group"
                                        class="select form-control @error('blood_group') is-invalid @enderror"
                                        required>
                                    <option value="">-- Select --</option>
                                    @foreach (['A+ve','A-ve','B+ve','B-ve','AB+ve','AB-ve','O+ve','O-ve'] as $bg)
                                        <option value="{{ $bg }}"
                                            {{ old('blood_group', $patient->blood_group) === $bg ? 'selected' : '' }}>
                                            {{ $bg }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('blood_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Address --}}
                <div class="setting-title">
                    <h6>Address</h6>
                </div>
                <div class="setting-card">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" name="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address', $patient->address) }}"
                                       required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="city"
                                       class="form-control @error('city') is-invalid @enderror"
                                       value="{{ old('city', $patient->city) }}"
                                       required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" name="state"
                                       class="form-control @error('state') is-invalid @enderror"
                                       value="{{ old('state', $patient->state) }}"
                                       required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" name="country"
                                       class="form-control @error('country') is-invalid @enderror"
                                       value="{{ old('country', $patient->country) }}"
                                       required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                <input type="text" name="pincode"
                                       class="form-control @error('pincode') is-invalid @enderror"
                                       value="{{ old('pincode', $patient->pincode) }}"
                                       required>
                                @error('pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-btn text-end">
                    <a href="{{ route('patient.setting') }}" class="btn btn-md btn-light rounded-pill">Cancel</a>
                    <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Changes</button>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
(function () {
    // Photo preview
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
})();
</script>

@endsection
