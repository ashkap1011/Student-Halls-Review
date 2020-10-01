@extends('layouts.master')

@section('title', 'Homepage')

@section('content')




<div class="container">
    <h1 class="p-4 mt-5 mb-5" id="search_result_heading">Search results for "{{$searchString}}"</h1>
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
    <h2 class="" id="search_result_add_new_uni">Don't see your university? Add it <a href="/-/add/new-uni-dorm-review">here</a></h2>
    @else
        <h1>Oooh this sounds like a Uni we don't have, add it <a href="/-/add/new-uni-dorm-review">here</a></h1>

        <!--Maybe add a pic here or something--->


    @endif
</div>
@endsection