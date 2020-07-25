@extends('master')

@section('title', 'WriteReviews')

@section('content')


<table style="table-layout: fixed ;">
    <thead>
        @foreach ($temp_review_columns as $column_name)
        <th>{{ $column_name }}<th>
        @endforeach
    </thead>
    @foreach ($reviews as $row)
        <tr>
            @foreach ($temp_review_columns as $column)
            <td>{{$row->$column}}</td>    
            @endforeach
        </tr>
    @endforeach
</table>




@endsection