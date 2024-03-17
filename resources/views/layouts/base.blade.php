<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="{{route('home')}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4 ml-50">Main</span>
    </a>

    <ul class="nav nav-pills">
        @if(!auth()->user())
            <li class="nav-item"><a href="{{route('login_form')}}" class="nav-link active" aria-current="page">Login</a></li>
        @else
            <li class="nav-item"><span class="nav-link active">{{auth()->user()->name}}</span></li>

            <li class="nav-item">
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button  class="nav-link" type="submit">Logout</button>
                </form>
            </li>
        @endif
    </ul>
</header>
</div>
@yield('content')

</body>
</html>
