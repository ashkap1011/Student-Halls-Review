@extends('layouts.master')



@section('title', 'Review')

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

<div class="container">
<div class="reviews_header">
   <h2>{{$uni->uni_name}}</h2>
   <h1>{{$dorm->dorm_name}}</h1>
   <div class="dorm_overall_rating">
      {{$dorm->overall_rating}}
      <!--
      make stars
      -->
   </div>

</div>

</div>



@foreach ($reviews as $review)
   {{$review}} 
@endforeach
@endsection

<!--

-->