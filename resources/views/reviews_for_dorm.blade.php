@extends('layouts.master')

@section('link')
<script src="https://kit.fontawesome.com/242d15205f.js" crossorigin="anonymous"></script>
<link href="{{ asset('css/odometer-theme-minimal.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ asset('js/odometer.min.js') }}"></script>

@endsection

@section('title', 'Reviews')

@section('content')


<h5 id="reviews_for_dorms" hidden></h5>

<div class="reivew_content_container">
   <div class="row reviews_header">
      <h1 id="dorm_heading_reviews">{{$dorm->dorm_name}}</h1>
      <div class="dorm_overall_rating">
         <span id="dorm_overall_rating_value">{{$dorm->overall_rating}}</span>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-2" id="dorm_reviews_side_panel" >
         <div id="reviews_side_panel_header">
            <div id="back_button">
               <img id="back_button_arrow_img" src="/storage/icons/double_line_arrow.svg" alt="Go Back">
               <h2 id="back_button_uni_name">Go Back</h2>
            </div>
         </div>
         <div class="row" id="reviews_side_panel">
            <div class="col-7 col-lg-12">
               <div id="ratings_breakdown">
                  <h3 class="review_side_panel_title">Rating Breakdown</h3><hr>
                  @for ($i = 0; $i < sizeOf($STARRATINGS); $i++)
                     <div class="star_rating_container pb-2">
                        <div style="" class="star_rating_name">{{$STARRATINGS[$i]}}:  </div>
                        <div style="" class="star_rating_stars"><span class="star_rating_star_integer" hidden>{{substr($dorm->overall_star_ratings[$i], 0, -1)}}</span></div>
                     </div>
                  @endfor
               </div> <br>
            </div>
            <div class="col-5 col-lg-12">
               <div id="amenities_breakdown">
                  <h3 class="review_side_panel_title">Amenities</h3>
                  <p id="filter_sidenote">(From our Reviews)</p><hr>
                  @foreach ($dormHasAmenities as $amenities)
                     <p>{{$amenities}}</p>             
                  @endforeach
               </div>
            </div>
         </div>
         <div >
            
            
         </div>
      </div>
      <div class="col-lg-10" id="dorm_reviews_main_panel">
            @foreach ($reviews as $review)
            <div class="row review_row">
            <div class="col-8 h-100 review_row_speech_box">
               <div class="card bg-light mb-3 review_card">
                  <div class="card-body review_card_body">
                     <div class="review_card_body_header">
                        <div class="review_overall_rating_container">
                           <b class="review_rating_integer">{{$review->overall_rating}}</b>
                        </div> 
                        <div class="clap_feature_container">
                           <img class="clap_icons" id="review_id_{{$review->id}}" src="/storage/icons/clap_neutral.svg">
                           <div id="odometer_id_{{$review->id}}" class="odometer">0</div>
                        </div>
                        <div class="review_recommends_container">
                           @if ($review->is_recommended == 1)
                              <img class="review_recommend_icon" src="/storage/icons/recommended.svg" alt="thumbs up">
                           @else
                              <img class="review_recommend_icon" src="/storage/icons/not_recommended.svg" alt="thumbs down">
                           @endif
                           <b>Recommends</b>
                        </div>
                        
                     </div>
                     <div class="review_informational_line_container">
                        <p class="review_information_line">
                           @php 
                           $studentType = $review->year_of_study;
                           $studentYear = $studentType != 'postgraduate'? $studentType . ' year ' : ' Postgraduate ';
                           $isItCatered = $review->is_catered;
                           $isCatered = $isItCatered == 1 ? ' Catered ' : ' Self-Catered ';
                           $cateringRatingName = $isItCatered == 1? 'Food Rating: ': 'Kitchen Rating: ';
                           @endphp
                           <b>{{$studentYear}}</b>
                           student living in a 
                           <b> <span class="catering_rating_parent_span">{{$isCatered}}<span class="catering_rating_child_span" id="popup_for_review_{{$review->id}}">{{$cateringRatingName}}</span></span> {{$review->room_type}}</b>
                           room in 
                           <b>{{$review->year_of_residence}}</b>
                        </p>
                     </div> 
                     <div class="review_text" >
                        {{$review}}
                     </div>
                     
                  </div>
               </div>
            </div></div>
            @endforeach
         
      </div>
   </div>

</div>



@if (Cookie::has('review_claps'))
   @php ($cookie = Cookie::get('review_claps'))
   <script>
      var reviewClaps = {!! json_encode($cookie, JSON_HEX_TAG) !!}
      console.log(reviewClaps)
   </script>
@else
   <script>
      var reviewClaps = null;
   </script>
@endif


<script>
   var dorm = {!! json_encode($dorm, JSON_HEX_TAG) !!}
   var reviews = {!! json_encode($reviews, JSON_HEX_TAG) !!}
</script>



@endsection

<!--

-->