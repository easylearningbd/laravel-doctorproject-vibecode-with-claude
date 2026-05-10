@extends('doctor.doctor_master')
@section('doctor')


 
    <div class="doc-review">

        <div class="dashboard-header">
            <div class="header-back">
                <h3>Reviews</h3>
            </div>
        </div>
    
        <!-- Review Listing -->
        <ul class="comments-list">

            <li class="over-all-review">
                <div class="review-content">
                    <div class="review-rate">
                        <h6>Overall Rating</h6>
                        <div class="star-rated">
                            <span>4.0</span>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                     
                </div>
            </li>
            <li>
                <div class="comments">
                    <div class="comment-head">
                        <div class="patinet-information">
                            <a href="javascript:void(0);">
                                <img src="assets/img/doctors-dashboard/profile-01.jpg" alt="User Image">
                            </a>
                            <div class="patient-info">
                                <h6><a href="javascript:void(0);">Adrian</a></h6>
                                <span>15 Mar 2024</span>
                            </div>
                        </div>
                        <div class="star-rated">
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star filled"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <div class="review-info">
                        <p> Dr. Edalin Hendry has been my family's trusted doctor for years. 
                            Their genuine care and thorough approach to our health concerns make every visit reassuring. 
                            Dr. Edalin Hendry's ability to listen and explain complex health issues in understandable terms
                            is exceptional. We are grateful to have such a dedicated physician by our side
                        </p>
                        <div class="comment-reply">
                            <a href="#" class="d-inline-flex align-items-center"><i class="fa-solid fa-reply me-2"></i> Reply</a>
                        </div>
                    </div>
                </div>
                
            </li>
            
        </ul>
        <!-- /Comment List -->

        <!-- Pagination -->
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li>
                    <a href="#" class="page-link">1</a>
                </li>
                <li>
                    <a href="#" class="page-link active">2</a>
                </li>
                <li>
                    <a href="#" class="page-link">3</a>
                </li>
                <li>
                    <a href="#" class="page-link">4</a>
                </li>
                <li>
                    <a href="#" class="page-link">...</a>
                </li>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->
        
    </div>
 



@endsection