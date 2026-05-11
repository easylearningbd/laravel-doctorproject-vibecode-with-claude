@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Manage Services</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('agent.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Manage Home</li>
                    <li class="breadcrumb-item active">Manage Services</li>
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

    <form action="{{ route('agent.manage.services.update') }}" method="POST">
        @csrf

        {{-- Section Heading --}}
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title mb-0">Section Heading</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Badge Text <span class="text-danger">*</span></label>
                            <input type="text" name="badge" class="form-control"
                                   value="{{ old('badge', $settings['badge']) }}"
                                   placeholder="e.g. Why Book With Us" required maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Section Heading <span class="text-danger">*</span></label>
                            <input type="text" name="heading" class="form-control"
                                   value="{{ old('heading', $settings['heading']) }}"
                                   placeholder="e.g. Compelling Reasons to Choose" required maxlength="200">
                        </div>
                    </div>
                </div>

                {{-- Live section preview --}}
                <div class="p-3 rounded text-center" style="background:#f8f9fa;">
                    <small class="text-muted d-block mb-1">Live heading preview</small>
                    <span id="prevBadge" class="badge bg-primary mb-2 d-inline-block">
                        {{ $settings['badge'] }}
                    </span>
                    <h4 id="prevHeading" class="mb-0">{{ $settings['heading'] }}</h4>
                </div>
            </div>
        </div>

        {{-- Icon Reference --}}
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title mb-0">Icon Reference</h4>
                <small class="text-muted">Copy an icon class into any Icon Class field below</small>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3">
                    @php
                        $iconOptions = [
                            ['isax isax-tag-user5',       'Tag User',       'text-orange'],
                            ['isax isax-voice-cricle',    'Voice Circle',   'text-purple'],
                            ['isax isax-wallet-add-15',   'Wallet Add',     'text-cyan'],
                            ['isax isax-heart-circle5',   'Heart Circle',   'text-danger'],
                            ['isax isax-shield-tick5',    'Shield Tick',    'text-success'],
                            ['isax isax-clock5',          'Clock',          'text-primary'],
                            ['isax isax-people5',         'People',         'text-warning'],
                            ['isax isax-star-15',         'Star',           'text-orange'],
                            ['isax isax-calendar-15',     'Calendar',       'text-purple'],
                            ['isax isax-security-safe5',  'Security Safe',  'text-success'],
                            ['isax isax-message-question5','Message',       'text-cyan'],
                            ['isax isax-award5',          'Award',          'text-danger'],
                        ];
                        $colorOptions = [
                            'text-orange', 'text-purple', 'text-cyan',
                            'text-primary', 'text-success', 'text-danger',
                            'text-warning', 'text-pink',
                        ];
                    @endphp
                    @foreach($iconOptions as [$iconClass, $label, $color])
                    <div class="text-center icon-ref-item" style="cursor:pointer;min-width:80px;"
                         title="Click to copy: {{ $iconClass }} {{ $color }}">
                        <i class="{{ $iconClass }} {{ $color }}" style="font-size:1.8rem;"></i>
                        <p class="mb-0 fs-12 text-muted mt-1">{{ $label }}</p>
                        <code class="fs-11">{{ $iconClass }}</code>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <label class="form-label fw-semibold fs-13">Colour Classes:</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($colorOptions as $c)
                        <span class="badge p-2 {{ $c }}" style="background:rgba(0,0,0,.06);cursor:pointer;"
                              onclick="navigator.clipboard.writeText('{{ $c }}');this.textContent='✓ Copied!'">
                            {{ $c }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Three Reason Items --}}
        @foreach([1, 2, 3] as $i)
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title mb-0">Service Item {{ $i }}</h4>
                {{-- Live icon preview --}}
                <span class="icon-live-preview-{{ $i }}" style="font-size:1.5rem;">
                    <i class="{{ $settings['reason_'.$i.'_icon'] ?? 'isax isax-tag-user5 text-orange' }}"></i>
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Icon Class
                                <small class="text-muted fw-normal">(from the reference above, include colour class)</small>
                            </label>
                            <input type="text" name="reason_{{ $i }}_icon"
                                   class="form-control icon-input-{{ $i }}"
                                   value="{{ old('reason_'.$i.'_icon', $settings['reason_'.$i.'_icon']) }}"
                                   placeholder="e.g. isax isax-tag-user5 text-orange"
                                   maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="reason_{{ $i }}_title"
                                   class="form-control"
                                   value="{{ old('reason_'.$i.'_title', $settings['reason_'.$i.'_title']) }}"
                                   placeholder="e.g. Follow-Up Care" required maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea name="reason_{{ $i }}_desc"
                                      class="form-control" rows="3"
                                      maxlength="500" required
                                      placeholder="Short description for this service item...">{{ old('reason_'.$i.'_desc', $settings['reason_'.$i.'_desc']) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

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

    // Live badge + heading preview
    $('input[name="badge"]').on('input', function () {
        $('#prevBadge').text($(this).val());
    });
    $('input[name="heading"]').on('input', function () {
        $('#prevHeading').text($(this).val());
    });

    // Live icon preview for each reason item
    [1, 2, 3].forEach(function (i) {
        $('input.icon-input-' + i).on('input', function () {
            var classes = $(this).val().trim() || 'isax isax-tag-user5 text-orange';
            $('.icon-live-preview-' + i + ' i').attr('class', classes);
        });
    });

    // Click icon-ref-item → copy icon class to clipboard and show feedback
    $(document).on('click', '.icon-ref-item', function () {
        var code   = $(this).attr('title').replace('Click to copy: ', '');
        var $item  = $(this);
        navigator.clipboard.writeText(code).then(function () {
            $item.find('code').text('✓ Copied!');
            setTimeout(function () {
                $item.find('code').text(code.split(' ').slice(0, 2).join(' '));
            }, 1500);
        });
    });

});
</script>
@endpush
