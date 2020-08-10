@extends('layouts.master')



@section('title', 'WriteReviews')

@section('content')
@include('inc.navbar_admin')

    <h1 id='type_of_reviews'>{{$typeOfReviews}}</h1>
    <div class="table-responsive">
        <table class="table table-hover table-condensed">
            <thead class="thead-dark">
                <th>Delete</th>
                <th>Pushable</th>
                @foreach ($tempReviewColumns as $columnName)
                    <th>{{$columnName}}</th>
                @endforeach
            </thead>
                       
            @foreach ($reviews as $row)
                <tr>
                    <td><input type = "button" class="delete_btn" id="delete_btn_id_{{$row->id}}" value="Delete"></td>
                    <td><input id="chkbox_id_{{$row->id}}" name="pushables[]" type="checkbox"></td>
                    
                    @foreach ($tempReviewColumns as $column)
                        <td class="editable_cell row_{{$row->id}} {{$column}}" id="row_{{$row->id}}_col_{{$column}}">{{$row->$column}}</td> 
                    @endforeach

                </tr>
            @endforeach
            <button id="push_btn"> Push</button>
        </table>
    </div>

    @if ($typeOfReviews == 'new_uni_reviews' ||$typeOfReviews == 'new_dorm_reviews')
    <div class="container pt-5 info_table">
        <table class="table table-striped table-sm">
            <thead  class="thead-dark">
                <th>Dorm ID</th>
                <th>Dorm Name</th>
                <th>Uni ID</th>
            </thead>
            <tbody>
                @foreach ($dorms as $dorm)
                <tr>
                    <td>
                        <p>{{$dorm->dorm_id}}</p>
                    </td>
                    <td>
                        <p>{{$dorm->dorm_name}}</p>
                    </td>
                    <td>
                        <p>{{$dorm->uni_id}}</p>
                    </td>
                </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
    
        @if ($typeOfReviews == 'new_uni_reviews' )
        <div class="container pt-5 info_table">
            <table class="table table-striped table-sm">
                <thead  class="thead-dark">
                    <th>ID</th>
                    <th>University</th>
                </thead>
                <tbody>
                    @foreach ($universities as $university)
                    <tr>
                        <td>
                            <p>{{$university->uni_id}}</p>
                        </td>
                        <td>
                            <p>{{$university->uni_name}}</p>
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    @endif
    <!--
        if new uni table or dorm table, place the tables, also add check it says notifies of new intercollegiate dorm
    -->




@endsection

<!--
    https://stackoverflow.com/questions/37384949/how-to-edit-specific-table-records-with-own-admin-panel
    https://stackoverflow.com/questions/22006968/fetch-data-from-one-model-and-store-in-another-table
    https://codewithawa.com/posts/php-crud-create,-edit,-update-and-delete-posts-with-mysql-database
https://joshondesign.com/2015/05/23/csstable
https://stackoverflow.com/questions/1224729/using-jquery-to-edit-individual-table-cells
https://stackoverflow.com/questions/15926325/jquery-append-vs-appendchild
-->