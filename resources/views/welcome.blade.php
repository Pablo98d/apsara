<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>La Feriecita</title>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background: url("assets/images/image-gallery/servicios.png");
                background-size: cover;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                font-weight: 600;
                color: #f8d838;
                text-transform: uppercase;
            }

            .sub {
                font-size: 30px;
                color: #d21cf6;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 17px;
                font-weight: bold;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links" style="background-color: #fcffcc; opacity:0.9; border-radius:25px">
                    @auth
                    
                    Usuario Logueado
                        <a href="{{ url('/home') }}">Inicio</a>
                    @else
                        <a href="{{ route('login') }}">Ingreso</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Registro</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content" style="background-color: #fcffcc; opacity:0.9; border-radius:25px">
                <div class="title m-b-md">
                   
                </div>
                <div class="sub" style="font-weight:bold">
                    <img src="assets/images/image-gallery/Splash.gif" style="width: 380px;height: 500px" />
                                   </div>

                <div class="links">
                    <a href="{{url('/')}}">Inicio</a>
                    <a href="{{url('Quienes-Somos')}}">¿Quiénes Somos?</a>
                    <a href="{{url('Servicios')}}">Servicios</a>
                    <a href="{{url('Mision')}}">Misión</a>
                    <a href="{{url('Vision')}}">Visión</a>
                    <a href="{{route('register')}}">Contacto</a>
                </div>
            </div>
        </div>
    </body>
</html>
