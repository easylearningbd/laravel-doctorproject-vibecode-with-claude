@extends('doctor.doctor_master')
@section('doctor')

<div class="dashboard-header">
    <h3>Speciality &amp; Services</h3>
    <ul>
        <li>
            <a href="javascript:void(0);" class="btn btn-primary prime-btn" id="addSpecialityBtn">
                Add New Speciality
            </a>
        </li>
    </ul>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Pass specialities as JSON for use in JS template --}}
@php
    $specialitiesJson = $specialities->map(fn($s) => ['id' => $s->id, 'name' => $s->name])->values()->toJson();
@endphp

<form action="{{ route('specialities.services.post') }}" method="POST" id="servicesForm">
    @csrf

    <div class="accordions" id="specialityAccordion">

        @forelse ($grouped as $specialityId => $services)
            @php $i = $loop->index; @endphp

            <div class="user-accordion-item speciality-item" id="specItem_{{ $i }}">
                <a href="#" class="accordion-wrap" data-bs-toggle="collapse"
                   data-bs-target="#spec_collapse_{{ $i }}">
                    {{ $services->first()->speciality->name ?? 'Speciality' }}
                    <span class="delete-speciality" style="cursor:pointer;">Delete</span>
                </a>

                <div class="accordion-collapse collapse show" id="spec_collapse_{{ $i }}">
                    <div class="content-collapse">
                        <div class="add-service-info">
                            <div class="add-info">

                                {{-- Speciality Dropdown --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-wrap">
                                            <label class="form-label">Speciality <span class="text-danger">*</span></label>
                                            <select class="select form-control speciality-select"
                                                    name="items[{{ $i }}][speciality_id]"
                                                    required>
                                                <option value="">-- Select Speciality --</option>
                                                @foreach ($specialities as $sp)
                                                    <option value="{{ $sp->id }}"
                                                        {{ $sp->id == $specialityId ? 'selected' : '' }}>
                                                        {{ $sp->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Service Rows --}}
                                <div class="service-rows-wrapper">
                                    @foreach ($services as $j => $service)
                                    <div class="row service-row">
                                        <div class="col-md-3">
                                            <div class="form-wrap">
                                                <label class="form-label">Service <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                       name="items[{{ $i }}][services][{{ $j }}][service_name]"
                                                       value="{{ old("items.$i.services.$j.service_name", $service->service_name) }}"
                                                       placeholder="e.g. General Checkup"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-wrap">
                                                <label class="form-label">Price ($)</label>
                                                <input type="number" step="0.01" min="0" class="form-control"
                                                       name="items[{{ $i }}][services][{{ $j }}][price]"
                                                       value="{{ old("items.$i.services.$j.price", $service->price) }}"
                                                       placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex align-items-center">
                                                <div class="form-wrap w-100">
                                                    <label class="form-label">About Service</label>
                                                    <input type="text" class="form-control"
                                                           name="items[{{ $i }}][services][{{ $j }}][about]"
                                                           value="{{ old("items.$i.services.$j.about", $service->about) }}"
                                                           placeholder="Brief description">
                                                </div>
                                                <div class="form-wrap ms-2">
                                                    <label class="col-form-label d-block">&nbsp;</label>
                                                    <a href="javascript:void(0);" class="trash-icon trash delete-service">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                {{-- End Service Rows --}}

                            </div>
                            <div class="text-end">
                                <a href="javascript:void(0);" class="more-item mb-0 add-service-btn">
                                    Add New Service
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            {{-- No services yet; doctor can add via button --}}
        @endforelse

    </div>

    <div class="modal-btn text-end mt-3">
        <a href="{{ route('specialities.services') }}" class="btn btn-gray">Cancel</a>
        <button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
    </div>

</form>


<script>
(function () {
    const specialities = {!! $specialitiesJson !!};
    let specIndex = {{ $grouped->count() }};

    /* ── Build speciality dropdown HTML ── */
    function buildOptions(selectedId) {
        let opts = '<option value="">-- Select Speciality --</option>';
        specialities.forEach(s => {
            opts += `<option value="${s.id}" ${s.id == selectedId ? 'selected' : ''}>${s.name}</option>`;
        });
        return opts;
    }

    /* ── Build one service row ── */
    function buildServiceRow(i, j) {
        return `
        <div class="row service-row">
            <div class="col-md-3">
                <div class="form-wrap">
                    <label class="form-label">Service <span class="text-danger">*</span></label>
                    <input type="text" class="form-control"
                           name="items[${i}][services][${j}][service_name]"
                           placeholder="e.g. General Checkup" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-wrap">
                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" min="0" class="form-control"
                           name="items[${i}][services][${j}][price]"
                           placeholder="0.00">
                </div>
            </div>
            <div class="col-md-7">
                <div class="d-flex align-items-center">
                    <div class="form-wrap w-100">
                        <label class="form-label">About Service</label>
                        <input type="text" class="form-control"
                               name="items[${i}][services][${j}][about]"
                               placeholder="Brief description">
                    </div>
                    <div class="form-wrap ms-2">
                        <label class="col-form-label d-block">&nbsp;</label>
                        <a href="javascript:void(0);" class="trash-icon trash delete-service">Delete</a>
                    </div>
                </div>
            </div>
        </div>`;
    }

    /* ── Build a full speciality accordion item ── */
    function buildSpecialityItem(i) {
        return `
        <div class="user-accordion-item speciality-item" id="specItem_${i}">
            <a href="#" class="accordion-wrap" data-bs-toggle="collapse" data-bs-target="#spec_collapse_${i}">
                New Speciality
                <span class="delete-speciality" style="cursor:pointer;">Delete</span>
            </a>
            <div class="accordion-collapse collapse show" id="spec_collapse_${i}">
                <div class="content-collapse">
                    <div class="add-service-info">
                        <div class="add-info">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-wrap">
                                        <label class="form-label">Speciality <span class="text-danger">*</span></label>
                                        <select class="select form-control speciality-select"
                                                name="items[${i}][speciality_id]" required>
                                            ${buildOptions(null)}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="service-rows-wrapper">
                                ${buildServiceRow(i, 0)}
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="javascript:void(0);" class="more-item mb-0 add-service-btn">Add New Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    }

    /* ── Update accordion header when speciality is selected ── */
    document.getElementById('specialityAccordion').addEventListener('change', function (e) {
        if (e.target.classList.contains('speciality-select')) {
            const selected = e.target.options[e.target.selectedIndex];
            const header   = e.target.closest('.speciality-item').querySelector('.accordion-wrap');
            // Update the visible text (keep the Delete span)
            const deleteSpan = header.querySelector('.delete-speciality');
            header.childNodes[0].textContent = selected.value ? selected.text + ' ' : 'New Speciality ';
            if (!header.contains(deleteSpan)) header.appendChild(deleteSpan);
        }
    });

    /* ── Add New Speciality ── */
    document.getElementById('addSpecialityBtn').addEventListener('click', function () {
        document.getElementById('specialityAccordion')
            .insertAdjacentHTML('beforeend', buildSpecialityItem(specIndex));
        specIndex++;
    });

    /* ── Delegated: Delete Speciality ── */
    document.getElementById('specialityAccordion').addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-speciality')) {
            e.preventDefault();
            e.target.closest('.speciality-item').remove();
        }

        /* ── Delegated: Add Service within a speciality ── */
        if (e.target.classList.contains('add-service-btn')) {
            e.preventDefault();
            const item    = e.target.closest('.speciality-item');
            const wrapper = item.querySelector('.service-rows-wrapper');
            const i       = item.id.replace('specItem_', '');
            const j       = wrapper.querySelectorAll('.service-row').length;
            wrapper.insertAdjacentHTML('beforeend', buildServiceRow(i, j));
        }

        /* ── Delegated: Delete Service row ── */
        if (e.target.classList.contains('delete-service')) {
            e.preventDefault();
            const row = e.target.closest('.service-row');
            const wrapper = row.closest('.service-rows-wrapper');
            // Keep at least one service row per speciality
            if (wrapper.querySelectorAll('.service-row').length > 1) {
                row.remove();
            }
        }
    });

})();
</script>

@endsection
