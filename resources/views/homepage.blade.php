@extends('layouts.master')

@section('title', 'Homepage')

@section('content')

<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/admin_panel') }}">Admin Panel</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
</div>

<nav class="navbar navbar-expand-sm bg-light navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Active</a>
      </li>
      <li class="nav-item">
        <a href="/add/new-review"> write a review</a><br>
      </li>
    </ul>
</nav>
        
        <div id="homepage_title_container" >
            <pre id="homepage_title">Let's Find your 
                    dream dorm</pre>
        </div>
        <div class="search">
            <div class="search_bar">
                <input type="text" class="form-controller" id="search" name="search" autocomplete="off">
                <a id="search_button"><img id="searh_icon" src="/storage/icons/search.png" alt=""></a>
            </div>
            <div class="search_results"></div>
        </div>
            
        <div>
            <img src="/storage/homepage/welcome.svg" alt="illustration of Uni students"id="hompage_main_image">
        </div>              

        <div id="site_statistics">
           <p>We have <b>{{$reviewCount}}</b> reviews from {{$universityCount}} universities from the UK </p> 
        </div>
@endsection

