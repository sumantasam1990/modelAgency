<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Modeling Agency</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @vite(['resources/js/app.js'])

        <style>
            html {
                height: 100%;
            }
            body {
                font-family: 'Nunito', sans-serif;
                height: 100%;
            }

            label {
                font-weight: 600;
            }

            .btn-light {
                background-color: #C0C0C0;
                color: #1a1e21;
                font-weight: bold;
            }

            .hero {
                background-image: url("{{asset('images/login-bg.jpeg')}}");
                background-position: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                height: 100%;
            }

            .box {
                border: 4px solid #000000;
                padding-top: 30px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .left-sidebar {
                text-align: center;
                /*border: 3px solid #000000;*/
                padding: 15px;
                min-height: 100vh;
                background-color: #f0f0f0;
            }

            ul {
                padding: 0;
                margin: 0;
            }

            ul li {
                list-style: none;
                margin-bottom: 10px;
                width: 100%;
                text-align: center;
                background-color: #C0C0C0;
                padding: 5px;
            }

            ul li a {
                text-decoration: none;
                color: #000000;
                font-weight: 600;
            }

            .active {
                background-color: #000000;
            }

            .active a {
                color: #ffffff;
            }

            .sec-box {
                border: 2px solid #000000;
                padding: 12px;
            }
        </style>
    </head>
    <body class="antialiased">


