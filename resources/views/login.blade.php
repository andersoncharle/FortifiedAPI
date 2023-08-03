@extends('Layouts.layout')
@section('title','Login')
@section('content')

    <div class="container">
        <h1>Login page</h1>

        <div class="mt5">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            @endif
        </div>
        <form style="margin: auto;display: flex;justify-content: center;flex-direction: column;
max-width: 900px;" action="{{route('login.user')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="my">
                <input type="email" name="email" placeholder="email"/>
            </div>
            <div class="my">
                <input type="password" name="password" placeholder="password"/>
            </div>
            <div class="my">

                <button class="my" type="submit"> submit</button>
            </div>

            <div style="margin: 10px auto;">
                <a href="{{url(route('registration'))}}">registration</a>
            </div>
        </form>

        <style>
            .my {
                margin: 10px auto;
            }

            input {
                padding: 10px;
                border-radius: 20px;
                border: none;
                width: 500px;
            }

            button {
                padding: 10px 30px;
                border: none;
                border-radius: 20px;
                background-color: darkgrey;
                font-size: 15px;
                font-weight: bold;

            }

            button:hover {
                cursor: pointer;
                background-color: #9ca3af;
                transition: .2s ease-in-out;
                color: ghostwhite;
            }

        </style>

@endsection
