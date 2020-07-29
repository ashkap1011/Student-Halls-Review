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

    <div class="content">
        <div class="title m-b-md">
            <a href="/add/new-review"> write a review</a><br>
            
            <div class="search">
                <div class="search_bar">
                    <input type="text" class="form-controller" id="search" name="search">
                </div>
                <div class="search_results">

                </div>

            <!----
        <table class="table table-bordered table-hover">
        <thead>
        <tr>
        <th>name</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
    -->

            Laravelhi
        </div>
    </div>
    </div>
    
@endsection

