@extends('layouts.master')

@section('title', 'Admin Panel')

@section('content')

@include('inc.navbar_admin')


<a href="/posted_reviews">Reviews </a>
<a href="/posted_reviews_with_new_dorm">New Dorm With Review </a>
<a href="/posted_reviews_with_new_uni">New UNi With Review </a>




@endsection