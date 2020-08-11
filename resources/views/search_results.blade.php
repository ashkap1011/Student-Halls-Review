@extends('layouts.master')

@section('title', 'Homepage')

@section('content')

<nav class="navbar navbar-expand-sm bg-light navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Active</a>
      </li>
      <li class="nav-item">
        <a href="/add/new-review">
            <!--
            <div id="write_review_button">
                <img src="/storage/icons/review_write.svg" id="write_icon">    
                <p id="write_review_text">write a review</p> 
                <img src="/storage/icons/review_arrow.svg" id="arrow_icon"> 
            </div>--->
        </a>
      </li>
    </ul>
</nav>



<div class="container">
    @if (sizeof($universities)>0)
    <div id="uni_cards_panel mt-5">
        @foreach ($universities as $uni)
            <div class="col-12 h-100 mb-3" style="cursor: pointer;">
                <div class="card bg-light">
                <a href="/{{$uni->uni_name}}/dorms">
                    <div class="card-body">
                        <img src=""><!--Use uni's image if availble otherwise use thing's image-->
                        <div class="uni_card_right_panel">
                            <h2>{{$uni->uni_name}}</h2>
                        </div>
                    </div>
                </a>    
                </div>
            </div>
        @endforeach
    </div>
    @else
        <h1>We don't have a uni with that name, add it here</h1>
    @endif
</div>
@endsection