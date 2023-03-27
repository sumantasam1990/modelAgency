<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Modeling Agency</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @vite(['resources/js/app.js'])
        @livewireStyles

    </head>
    <body class="antialiased bg-light" id="html_body">

    @auth()
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" style="margin: 0; padding: 0;">

                <div class="left-sidebar">
                    <h2 class="text-capitalize fs-5 fw-bold text-light" style="margin-left: 20px;">
                        {{auth()->user()->name}}
                    </h2>
                    <p class="mb-2" style="margin-top: -5px;">
                        <a class="fs-6 fw-bold text-decoration-none text-capitalize" href="{{route('profile', [auth()->user()->username])}}" style="color: #d2d2d2; margin-left: 20px;">My profile &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
                    </p>
                    <p class="d-grid gap-2 col-12">
                        <a class="btn btn-info btn-sm fw-bold" href="{{route('edit.profile')}}"><i class="fa-solid fa-user-pen"></i> Edit profile</a>
                    </p>

                    <ul class="mt-5 header-ul">

{{--                        <div class="dropdown mb-3 {{ request()->is('model/contests/vote') ? 'active' : (request()->is('model/winners') ? 'active' : (request()->is('model/my/contest') ? 'active' : '')) }}">--}}
{{--                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                <i class="fa-solid fa-heart"></i> &nbsp; Contests--}}
{{--                            </a>--}}

{{--                            <ul class="dropdown-menu">--}}
{{--                                <li><a class="dropdown-item" href="{{route('contest.vote')}}">Vote</a></li>--}}
{{--                                <li><a class="dropdown-item" href="{{route('my.contests')}}">My Contests</a></li>--}}
{{--                                <li><a class="dropdown-item" href="{{route('my.results')}}">My Results</a></li>--}}
{{--                                <li><a class="dropdown-item" href="{{route('winners')}}">Winners</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}



                        <li class="{{ (request()->is('model/contests/vote')) ? 'vote' : '' }} vote"><a href="{{route('contest.vote')}}"><i class="fa-solid fa-heart"></i> &nbsp; Vote</a> </li>

                        <li class="{{ (request()->is('model/portfolio')) ? 'active' : '' }}"><a href="{{route('portfolio')}}"><i class="fa-solid fa-camera-retro"></i> &nbsp; Photos</a> </li>

                        <li class="{{ (request()->is('model/my/contest')) ? 'active' : '' }}"><a href="{{route('my.contests')}}"><i class="fa-solid fa-list"></i> &nbsp; My Contests</a> </li>
                        <li class="{{ (request()->is('model/my/results')) ? 'active' : '' }}"><a href="{{route('my.results')}}"><i class="fa-solid fa-bell"></i> &nbsp; Notifications</a> </li>
                        <li class="{{ (request()->is('model/winners')) ? 'active' : '' }}"><a href="{{route('winners')}}"><i class="fa-sharp fa-solid fa-trophy"></i> &nbsp; Winners</a> </li>

{{--                        <div class="dropdown mb-3 {{ (request()->is('model/portfolio')) ? 'active' : '' }}">--}}
{{--                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                <i class="fa-solid fa-camera-retro"></i> &nbsp; Portfolio--}}
{{--                            </a>--}}

{{--                            <ul class="dropdown-menu">--}}
{{--                                <li><a class="dropdown-item" href="{{route('portfolio')}}">Photos</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}

                        <li class="{{ (request()->is('model/subscription/now') || request()->is('model/subscription')) ? 'active' : '' }}"><a href="{{route('subscription.now')}}"><i class="fa-solid fa-wallet"></i> &nbsp; Subscription</a> </li>

                        <li class="{{ (request()->is('model/help')) ? 'active' : '' }}"><a href="{{route('help')}}"><i class="fa-solid fa-person-circle-question"></i> &nbsp; Help</a> </li>

                        @auth()
                            <li><a href="{{route('logout')}}"><i class="fa-solid fa-arrow-right-to-bracket"></i> &nbsp; Sign Out</a> </li>
                        @else
                            <li class="active"><a href="{{route('register')}}"><i class="fa-solid fa-user-plus"></i> &nbsp; Register</a> </li>
                            <li><a href="{{route('login')}}"><i class="fa-solid fa-right-to-bracket"></i> &nbsp; Sign In</a> </li>
                        @endauth

                    </ul>

                    <div class="d-flex flex-column justify-content-center align-content-center align-items-center mt-5">
                        <h5 class="fs-5 fw-semibold text-black-50">EUMODELO</h5>
                        <p class="mt-3 text-black-50">
                            <i class="fa-brands fa-facebook fs-4 mr-3"></i>
                            <i class="fa-brands fa-instagram fs-4 mr-3"></i>
                            <i class="fa-brands fa-tiktok fs-4"></i>
                        </p>
                    </div>

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
    @livewireScripts

    <script>
        let thing;

        // Livewire.hook('message.sent', () => {
        //     thing.animate([
        //         {opacity: 1, transform: 'scale(1)'},
        //         {opacity: 0.5, transform: 'scale(0.5)'},
        //         {opacity: 0, transform: 'scale(0)'},
        //     ], {duration: 850, easing: 'ease-out'});
        // });

        Livewire.hook('message.received', () => {
            thing = document.querySelector('[vote-anim]');

        });

        Livewire.hook('message.processed', () => {
            thing.animate([
                {opacity: 0, transform: 'scale(0)'},
                {opacity: 0.5, transform: 'scale(0.5)'},
                {opacity: 1, transform: 'scale(1)'},
            ], {duration: 1000, easing: 'ease-in'});
        });

        function voteup(str)
        {
            document.getElementById('overlay_'+str).style.display = "block";
        }
    </script>



    </body>
</html>
