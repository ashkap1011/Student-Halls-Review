@extends('layouts.master')

@section('link')
<script src="https://kit.fontawesome.com/242d15205f.js" crossorigin="anonymous"></script>
<link href="{{ asset('css/odometer-theme-minimal.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ asset('js/odometer.min.js') }}"></script>

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
      <div class="col-lg-2" id="dorm_reviews_side_panel" >
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
      <div class="col-lg-10" id="dorm_reviews_main_panel">

            @foreach ($reviews as $review)
            <div class="row review_row">
            <div class="col-8 h-100 review_row_speech_box">
               <div class="card bg-light mb-3 review_card">
                  <div class="card-body review_card_body">
                     <div class="review_card_body_header">
                        <div class="review_overall_rating_container">
                           <b>{{$review->overall_rating}}</b>
                        </div> 
                        <img class="clap_icons" id="review_id_{{$review->id}}" src="/storage/icons/clap.svg">
                        <div id="odometer" class="odometer">125</div>
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
   var reviews = {{!! json_encode($reviews, JSON_HEX_TAG)}}
</script>



@endsection

<!--

-->