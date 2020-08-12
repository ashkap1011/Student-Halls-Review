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
   <div class="col-3" id="dorm_reviews_side_panel" >
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
   <div class="col-9" id="dorm_reviews_main_panel">
      <div class="col-12 h-100">
      @foreach ($reviews as $review)
         <div class="card bg-light mb-3">
             <div class="card-body">
                <p>{{$review}}</p>
                <img class="clap_icons" id="review_id_{{$review->id}}" src="/storage/icons/clap.svg">
            </div>
         </div>
      @endforeach
   </div>

   </div>
</div>

</div>

<script>
   var dorm = {!! json_encode($dorm, JSON_HEX_TAG) !!}
   var reviewClaps = {{Cookies::get('review_claps')}} 
</script>

@endsection

<!--

-->