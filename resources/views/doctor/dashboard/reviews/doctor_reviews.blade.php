@extends('doctor.doctor_master')
@section('doctor')

<div class="doc-review">

    <div class="dashboard-header">
        <div class="header-back">
            <h3>Reviews</h3>
        </div>
    </div>

    <ul class="comments-list">

        {{-- Overall rating --}}
        <li class="over-all-review">
            <div class="review-content">
                <div class="review-rate">
                    <h6>Overall Rating</h6>
                    <div class="star-rated">
                        <span>{{ $reviewCount > 0 ? number_format($avgRating, 1) : '0.0' }}</span>
                        @for($s = 1; $s <= 5; $s++)
                            <i class="fa-solid fa-star {{ $s <= round($avgRating) ? 'filled' : '' }}"></i>
                        @endfor
                    </div>
                    <p class="text-muted fs-13 mt-1">
                        Based on {{ $reviewCount }} review{{ $reviewCount != 1 ? 's' : '' }}
                    </p>
                </div>
            </div>
        </li>

        {{-- Individual reviews --}}
        @forelse($reviews as $review)
        @php
            $photo = $review->patient?->profile_photo
                ? asset('storage/' . $review->patient->profile_photo)
                : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
            $name  = trim(($review->patient?->first_name ?? '') . ' ' . ($review->patient?->last_name ?? '')) ?: 'Patient';
        @endphp
        <li>
            <div class="comments">
                <div class="comment-head">
                    <div class="patinet-information">
                        <a href="javascript:void(0);">
                            <img src="{{ $photo }}" alt="{{ $name }}">
                        </a>
                        <div class="patient-info">
                            <h6><a href="javascript:void(0);">{{ $name }}</a></h6>
                            <span>{{ $review->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="star-rated">
                        @for($s = 1; $s <= 5; $s++)
                            <i class="fa-solid fa-star {{ $s <= $review->rating ? 'filled' : '' }}"></i>
                        @endfor
                        <span class="ms-1 fs-13">{{ number_format($review->rating, 1) }}</span>
                    </div>
                </div>
                <div class="review-info">
                    @if($review->comment)
                        <p>{{ $review->comment }}</p>
                    @else
                        <p class="text-muted fst-italic">No comment provided.</p>
                    @endif
                    @if($review->recommend)
                        <p class="text-success fs-13 mb-1">
                            <i class="fa-regular fa-thumbs-up me-1"></i>Recommends this doctor
                        </p>
                    @endif
                </div>
            </div>
        </li>
        @empty
        <li>
            <div class="text-center py-5">
                <i class="isax isax-star-1 fs-1 text-muted mb-3 d-block"></i>
                <p class="text-muted">No reviews yet.</p>
            </div>
        </li>
        @endforelse

    </ul>

    @if($reviews->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $reviews->links() }}
    </div>
    @endif

</div>

@endsection
