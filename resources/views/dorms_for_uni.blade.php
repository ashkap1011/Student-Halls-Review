@extends('layouts.master')

@section('title', 'Homepage')

@section('content')
hii
{{$uniName}}
@foreach ($dorms as $dorm)
    <p>{{$dorm->dorm_name}}</p>
@endforeach
@endsection