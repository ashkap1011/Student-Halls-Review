@extends('layouts.master')

@section('title', 'Homepage')

@section('content')

<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/admin_panel') }}" hidden>Admin Panel</a>
            @else
                <a href="{{ route('login') }}" hidden>Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" hidden>Register</a>
                @endif
            @endauth
        </div>
    @endif
</div>

<nav class="navbar navbar-expand-sm navigation_bar pt-2 pb-1 pt-md-3 pb-md-2">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Active</a>
      </li>
    </ul>
    <a href="/add/new-review" class="ml-auto"><img id="write_review_button" src="/storage/icons/write_review_btn.svg" alt=""></a>

</nav>
        
        <div id="homepage_title_container" >
            <pre id="homepage_title">Let's Find your 
                    dream dorm</pre>
        </div>
        <div class="search">
            <div class="search_bar">
                <input type="text" class="form-controller" id="search" name="search" autocomplete="off" placeholder="Search for your University">
                <a id="search_button"><img id="searh_icon" src="/storage/icons/search.png" alt=""></a>
            </div>
            <div class="search_results"></div>
        </div>
            
        <div>
            <img src="/storage/homepage/welcome_1.svg" alt="illustration of Uni students"id="hompage_main_image">
        </div>              

        <div id="site_statistics">
           <p>We have <b>{{$reviewCount}}</b> reviews from <b>{{$universityCount}}</b> universities from the UK </p> 
        </div>
        
@endsection

