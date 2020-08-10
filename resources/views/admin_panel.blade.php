@extends('layouts.master')

@section('title', 'Admin Panel')

@section('content')

@include('inc.navbar_admin')
<div class="container admin_container">
    <div class="col-12 h-100 mt-5">
        <div class="card bg-light mb-3 ">
          <div class="card-body">
            <a href="/posted_reviews">Reviews </a>
          </div>
        </div>
        <div class="card bg-light mb-3 ">
          <div class="card-body">
            <a href="/posted_reviews_with_new_dorm">New Dorm With Review </a>
            </div>
        </div>
        <div class="card bg-light mb-3 ">
            <div class="card-body">
                <a href="/posted_reviews_with_new_uni">New UNi With Review </a>
            </div>
        </div>
    </div>  
</div>





@endsection