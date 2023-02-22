<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Panel - Modeling Agency</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js'])
    @livewireStyles

</head>
<body class="antialiased bg-light" id="html_body">


<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" style="margin: 0; padding: 0;">
            @auth()
                <div class="left-sidebar">
                    <h2 class="text-capitalize fs-5 fw-bold text-light" style="margin-left: 20px;">
                        Admin Panel
                    </h2>
                    <p style="margin-top: -5px;">
                        <a class=" fs-6 fw-bold text-decoration-none text-capitalize" href="#" style="color: #d2d2d2; margin-left: 20px;">{{auth()->user()->name}} &nbsp; </a>
                    </p>

                    <ul class="mt-5 header-ul">

                        <li class="{{ (request()->is('admin/stats')) ? 'active' : '' }}"><a href="{{route('admin.stats')}}"><i class="fa-solid fa-chart-simple"></i> &nbsp; Stats</a> </li>

                        <li class="{{ (request()->is('admin/models')) ? 'active' : '' }}"><a href="{{route('admin.models')}}"><i class="fa-solid fa-person"></i> &nbsp; Models</a> </li>

                        <li class="{{ (request()->is('admin/category/contests')) ? 'active' : '' }}"><a href="{{route('admin.category.contests')}}"><i class="fa-solid fa-heart"></i> &nbsp; Contests</a> </li>

                        <li class="{{ (request()->is('admin/subscribers')) ? 'active' : '' }}"><a href="{{route('admin.subscribers')}}"><i class="fa-solid fa-dollar-sign"></i> &nbsp; Subscribers</a> </li>

                        <li class="{{ (request()->is('admin/faqs')) ? 'active' : '' }}"><a href="{{route('admin.faq')}}"><i class="fa-solid fa-person-circle-question"></i> &nbsp; Help</a> </li>

                        <li><a href=""><i class="fa-solid fa-gear"></i> &nbsp; Config</a> </li>
                        @auth()
                            <li><a href="{{route('logout')}}"><i class="fa-solid fa-arrow-right-to-bracket"></i> &nbsp; Sign Out</a> </li>
                        @else
                            <li class="active"><a href="{{route('register')}}"><i class="fa-solid fa-user-plus"></i> &nbsp; Register</a> </li>
                            <li><a href="{{route('login')}}"><i class="fa-solid fa-right-to-bracket"></i> &nbsp; Sign In</a> </li>
                        @endauth

                    </ul>

                </div>
            @endauth
        </div>

        <div class="col-md-10">
            <div class="right-sidebar mt-5">
                @include('alert')

                @yield('content')

            </div>
        </div>
    </div>
</div>

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
