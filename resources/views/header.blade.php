<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/fav.png')}}">

        <title>Eumodelo</title>

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

                <div class="left-sidebar" id="left-sidebar-id" style="height: 100vh;">

                    @php
                    $img = \App\Models\portfolio::where('user_id', auth()->user()->id)->where('profile_photo', '1')->first();
                    @endphp

                    <div class="d-flex flex-row justify-content-start align-items-center mb-3 mt-2">
                        @if($img)
                            <img class="img-fluid rounded-circle w-25 h-25" src="{{asset('storage/image/' . $img->file_name . '.' . $img->ext)}}" alt="profile photo">
                        @else
                            <img class="img-fluid rounded-circle w-25 h-25" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Default_pfp.svg/1200px-Default_pfp.svg.png" alt="profile photo">
                        @endif
                        <h2 class="text-capitalize fs-5 fw-bold text-light" style="margin-left: 20px;">
                            {{auth()->user()->name}}
                        </h2>
                    </div>


                    <p class="d-grid gap-2 col-12">
                        <a class="btn btn-outline-light btn-sm fw-bold" href="{{route('profile', [auth()->user()->username])}}"><i class="fa-solid fa-user"></i> {{__('main.my_profile')}}</a>
                    </p>


                    <ul class="mt-4 header-ul">

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



                            <li class="{{ (request()->is('model/contests/vote')) ? 'vote' : '' }} vote"><a href="{{route('contest.vote')}}"><i class="fa-solid fa-heart"></i> &nbsp; {{__('main.vote')}}</a> </li>

                            <li class="{{ (request()->is('model/my/contest')) ? 'active' : '' }}"><a href="{{route('my.contests')}}"><i class="fa-solid fa-list"></i> &nbsp; {{__('main.my_contests')}}</a> </li>
                            <li class="{{ (request()->is('model/my/results')) ? 'active' : '' }}"><a href="{{route('my.results')}}"><i class="fa-solid fa-bell"></i> &nbsp; {{__('main.notifications')}}</a> </li>
                            <li class="{{ (request()->is('model/winners')) ? 'active' : '' }}"><a href="{{route('winners')}}"><i class="fa-sharp fa-solid fa-trophy"></i> &nbsp; {{__('main.winners')}}</a> </li>
                            <li class="{{ (request()->is('model/portfolio')) ? 'active' : '' }}"><a href="{{route('portfolio')}}"><i class="fa-solid fa-camera-retro"></i> &nbsp; {{__('main.photos')}}</a> </li>
                            <li class="{{ (request()->is('model/about/me')) ? 'active' : '' }}"><a href="{{route('about.me')}}"><i class="fa-solid fa-user-check"></i> &nbsp; {{__('main.about_me')}}</a> </li>



                        <li class="{{ (request()->is('model/edit/profile')) ? 'active' : '' }}"><a href="{{route('edit.profile')}}"><i class="fa-solid fa-user-pen"></i> &nbsp; {{__('main.edit_profile')}}</a> </li>



                        <li class="{{ (request()->is('model/help')) ? 'active' : '' }}"><a href="{{route('help')}}"><i class="fa-solid fa-person-circle-question"></i> &nbsp; {{__('main.help')}}</a> </li>

                        <li class="{{ (request()->is('model/subscription/now') || request()->is('model/subscription')) ? 'active' : '' }}"><a href="{{route('subscription.now')}}"><i class="fa-solid fa-wallet"></i> &nbsp; {{__('main.subscription')}}</a> </li>

                        @auth()
                            <li><a href="{{route('logout')}}"><i class="fa-solid fa-arrow-right-to-bracket"></i> &nbsp; {{__('main.sign_out')}}</a> </li>
                        @else
                            <li class="active"><a href="{{route('register')}}"><i class="fa-solid fa-user-plus"></i> &nbsp; {{__('main.register')}}</a> </li>
                            <li><a href="{{route('login')}}"><i class="fa-solid fa-right-to-bracket"></i> &nbsp; {{__('main.signin')}}</a> </li>
                        @endauth



                    </ul>

                    <div class="d-flex flex-column justify-content-center align-content-center align-items-center mt-2">
{{--                        <h5 class="fs-5 fw-semibold text-black-50">--}}
{{--                            <img src="{{asset('images/logo.png')}}" alt="Eumodelo" class="img-fluid" style="width: 150px;">--}}
{{--                        </h5>--}}

{{--                        <p class="mt-3 text-black-50">--}}
{{--                            <a class="text-dark" href="https://www.facebook.com/agenciaeumodelo"><i class="fa-brands fa-facebook fs-6 mr-3"></i></a>--}}
{{--                            <a class="text-dark" target="_blank" href="https://www.instagram.com/eumodelo"><i class="fa-brands fa-instagram fs-6 mr-3"></i></a>--}}
{{--                            <a class="text-dark" target="_blank" href="https://www.tiktok.com/@eumodelo"><i class="fa-brands fa-tiktok fs-6"></i></a>--}}
{{--                        </p>--}}

{{--                        <a class="text-light mb-3" href="{{route('logout')}}">Sign out</a>--}}
                        <a class="text-light" href="{{route('privacy')}}">{{__('main.privacy')}}</a>
                        <a class="text-light" href="{{route('terms')}}">{{__('main.terms')}}</a>


                    </div>

                </div>

            </div>

            <div class="col-md-10">
                <div class="right-sidebar mt-5">

                    <div class="mb-3">
                        <button type="button" onclick="menu();" id="men_u" class="menu_btn">Menu</button>
                        <button style="float: right; display: none; z-index: 2000;
    position: relative;" type="button" class="menu_btn" onclick="menu_off();" id="men_u_off"><i class="fa-solid fa-xmark text-light"></i></button>
                    </div>

                    @include('alert')

                    @yield('content')

                </div>
            </div>
        </div>
    </div>

        <div class="mb-5">&nbsp;</div>
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


    <script>
        function menu() {
            var left = document.getElementById('left-sidebar-id');
            var menu_btn = document.getElementById('men_u');
            var menuOffBtn = document.getElementById('men_u_off');

            left.style.display = 'block';
            menu_btn.style.display = 'none';
            menuOffBtn.style.display = 'block';
        }

        function menu_off() {
            var left = document.getElementById('left-sidebar-id');
            var menu_btn = document.getElementById('men_u');
            var menuOffBtn = document.getElementById('men_u_off');

            left.style.display = 'none';
            menu_btn.style.display = 'block';
            menuOffBtn.style.display = 'none';
        }
    </script>


    </body>
</html>
