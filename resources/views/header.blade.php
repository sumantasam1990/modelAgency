<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Modeling Agency</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @vite(['resources/js/app.js'])
    </head>
    <body class="antialiased bg-light">

    @auth()
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="margin: 0; padding: 0;">
                <div class="left-sidebar">
                    <h2 class="text-capitalize fs-5 fw-bold text-light" style="margin-left: 20px;">Maria Doe</h2>
                    <p style="margin-top: -5px;">
                        <a class=" fs-6 fw-bold text-decoration-none text-capitalize" href="" style="color: #d2d2d2; margin-left: 20px;">My profile &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
                    </p>

                    <ul class="mt-5">
                        <li><a href=""><i class="fa-solid fa-heart"></i> &nbsp; Contest</a> </li>

                        <li class="{{ (request()->is('model/portfolio')) ? 'active' : '' }}"><a href=""><i class="fa-solid fa-camera-retro"></i> &nbsp; Portfolio</a> </li>

{{--                        <div class="dropdown">--}}
{{--                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                Dropdown link--}}
{{--                            </a>--}}

{{--                            <ul class="dropdown-menu">--}}
{{--                                <li><a class="dropdown-item" href="#">Action</a></li>--}}
{{--                                <li><a class="dropdown-item" href="#">Another action</a></li>--}}
{{--                                <li><a class="dropdown-item" href="#">Something else here</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}

                        <li><a href=""><i class="fa-solid fa-person-circle-question"></i> &nbsp; Help</a> </li>
                        <li><a href=""><i class="fa-solid fa-credit-card"></i> &nbsp; Subscription</a> </li>
                        @if(Auth::check())
                            <li><a href="{{route('logout')}}"><i class="fa-solid fa-arrow-right-to-bracket"></i> &nbsp; Sign Out</a> </li>
                        @else
                            <li class="active"><a href="{{route('register')}}"><i class="fa-solid fa-user-plus"></i> &nbsp; Register</a> </li>
                            <li><a href="{{route('login')}}"><i class="fa-solid fa-right-to-bracket"></i> &nbsp; Sign In</a> </li>
                        @endif

                    </ul>

                </div>
            </div>

            <div class="col-md-10">
                <div class="right-sidebar mt-5">
                    @include('alert')

                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    @endauth

    </body>
</html>
