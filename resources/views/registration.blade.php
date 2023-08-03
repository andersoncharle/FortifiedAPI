@extends('Layouts.layout')
@section('title','Registration')
@section('content')
    <div class="container">
        <h1>Registration page</h1>

        <div class="mt5">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            @endif
        </div>
        @if(session()->has('$error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        @if(session()->has('$success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif
        <form style="margin: auto;display: flex;justify-content: center;flex-direction: column;
      max-width: 900px;" action="{{route('register.user')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="my">
                <input type="text" name="name" placeholder="username"/>
            </div>
            <div class="my">
                <input type="email" name="email" placeholder="email"/>
            </div>
            <div class="my">
                <input type="password" name="password" placeholder="password"/>
            </div>
            <div class="my">

                <button class="my" type="submit"> submit</button>
            </div>


        </form>
    </div>


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
