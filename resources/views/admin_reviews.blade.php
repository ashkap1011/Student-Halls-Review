@extends('master')



@section('title', 'WriteReviews')

@section('content')
    <h1 id='type_of_reviews'>{{$type_of_review}}</h1>
<table>
    <th>Delete</th>
    <th>Pushable</th>
    @foreach ($temp_review_columns as $column_name)
        <th>{{$column_name }}</th>
    @endforeach
   
    @foreach ($reviews as $row)
        <tr>
            
            <td><input type = "button" class="delete_btn" id="delete_btn_id_{{$row->id}}" value="Delete"></td>
            <td><input id="chkbox_id_{{$row->id}}" name="pushables[]" type="checkbox"></td>
            @foreach ($temp_review_columns as $column)
                
                <td class="editable_cell row_{{$row->id}} {{$column}}">{{$row->$column}}</td> 
            
            @endforeach
        </tr>
    @endforeach
    <button id="push_btn"> Push</button>
</table>





@endsection

<!--
    https://stackoverflow.com/questions/37384949/how-to-edit-specific-table-records-with-own-admin-panel
    https://stackoverflow.com/questions/22006968/fetch-data-from-one-model-and-store-in-another-table
    https://codewithawa.com/posts/php-crud-create,-edit,-update-and-delete-posts-with-mysql-database
https://joshondesign.com/2015/05/23/csstable
https://stackoverflow.com/questions/1224729/using-jquery-to-edit-individual-table-cells
https://stackoverflow.com/questions/15926325/jquery-append-vs-appendchild
-->