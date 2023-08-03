@extends('Layouts.layout')
@section('title','Home Page')
@section('content')
    <h1>welcome to home page</h1>

    {{auth()->user()}}

    <a href="{{url(route('logout'))}}"
       style="padding: 20px;border-radius: 20px;background-color: #2d3748;margin: 20px auto;">logout</a>

@endsection
