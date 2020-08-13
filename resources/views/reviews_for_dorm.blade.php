@extends('layouts.master')

@section('link')
<script src="https://kit.fontawesome.com/242d15205f.js" crossorigin="anonymous"></script>
@endsection

@section('title', 'Reviews')

@section('content')
<nav class="navbar navbar-expand-sm bg-light navbar-light">
   <ul class="navbar-nav">
     <li class="nav-item active">
       <a class="nav-link" href="#">Active</a>
     </li>
     <li class="nav-item">
       <a class="nav-link" href="#">Link</a>
     </li>
     
   </ul>
</nav>
<h5 id="reviews_for_dorms" hidden></h5>

<div class="container-fluid">
   <div class="row reviews_header">
      <h2>{{$uni->uni_name}}</h2>
      <h1>{{$dorm->dorm_name}}</h1>
      <div class="dorm_overall_rating">
         <span id="dorm_overall_rating_value">{{$dorm->overall_rating}}</span>
      </div>
   </div>
   <div class="row">
      <div class="col-2" id="dorm_reviews_side_panel" >
         <div id="ratings_breakdown">
            <h3>Rating Breakdown</h3><hr>
            @for ($i = 0; $i < sizeOf($STARRATINGS); $i++)
            @if ($STARRATINGS[$i]=='catered_or_selfcatered_rating')
               @continue;
            @endif
               <div class="star_ratings">{{$STARRATINGS[$i]}}:  {{substr($dorm->overall_star_ratings[$i], 0, -1)}}</div>
            @endfor
         </div>
         <div id="amenities_breakdown">
            <h3>Amenities</h3><hr>
            @foreach ($dormHasAmenities as $amenities)
               <p>{{$amenities}}</p>             
            @endforeach
         </div>
      </div>
      <div class="col-10" id="dorm_reviews_main_panel">

            @foreach ($reviews as $review)
            <div class="row review_row">
            
            <div class="col-9 h-100 review_row_speech_box">
               <div class="card bg-light mb-3 review_card">
                  <div class="card-body review_card_body">
                     <div class="review_card_body_header">
                        <div class="review_overall_rating_container">
                           <b>{{$review->overall_rating}}</b>
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
                     <div class="review_informational_line">
                        <p>
                           @php 
                           $studentType = $review->year_of_study;
                           $studentYear = $studentType != 'postgraduate'? $studentType . ' year ' : ' Postgraduate ';
                           $isItCatered = $review->is_catered;
                           $isCatered = $isItCatered == 1 ? ' Catered ' : ' Self-Catered ';
                           @endphp
                           <b>{{$studentYear}}</b>
                           student living in a 
                           <b>{{$isCatered . $review->room_type}}</b>
                           room in 
                           <b>{{$review->year_of_residence}}</b>
                        </p>
                     </div>
                     <p class="pb-4">{{$review}}</p><hr style="height:1px;border:none;color:#333;background-color:#333;">
                     <img class="clap_icons" id="review_id_{{$review->id}}" src="/storage/icons/clap.svg">
                     <img class="double_line_arrow" src="/storage/icons/double_line_arrow.svg" alt="">
                     @if ($isItCatered == 1)
                        <b class="catering_rating">Kitchen Rating: {{$review->catered_or_selfcatered_rating}}/5</b>
                     @else
                        <b class="catering_rating">Food Rating: {{$review->catered_or_selfcatered_rating}} /5</b>
                     @endif
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
</script>

@endsection

<!--

-->