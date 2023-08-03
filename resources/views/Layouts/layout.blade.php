<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','anderson lara')</title>
</head>
<body>
@include('include.header')
<h2>yo buddy whats uppp.</h2>
@auth()
    am authenticated buddy
@else
    <div style="margin: 10px auto;">
        <a href="{{url(route('login'))}}">login</a>
    </div>
@endauth

<div class="container" style="background-color: rgba(215,105,255,0.7)">
    @yield('content')
</div>
</body>
</html>
