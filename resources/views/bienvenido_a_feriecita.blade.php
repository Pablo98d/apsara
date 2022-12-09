<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>La Feriecita</title>
        <link rel="shortcut icon" href="{{asset("Icono_pagina/logoNombre.ico")}}" type="image/x-icon">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: sans-serif;
                background: url("assets/images/image-gallery/servicios.png");
                background-attachment: fixed;
                background-position: center;
            }
            header {
                position: absolute;
                top: 0;
                left: 0;
                padding: 0 100px;
                background: #262626;
                width: 100%;
                box-sizing: border-box;
            }
            header .logo {
                color: #fff;
                height: 50px;
                line-height: 50px;
                font-size: 24px;
                float: left;
                font-weight: bold;
            }
            header nav {
                float: right;
            }
            header nav ul {
                margin: 0;
                padding: 0;
                display: flex;
            }
            header nav ul li {
                list-style: none;
            }
            header nav ul li a {
                height: 50px;
                line-height: 50px;
                padding: 0 20px;
                color: #fff;
                text-decoration: none;
                display: block;
            }
            header nav ul li a:hover,
            header nav ul li a.active {
                color: #fff;
                background: #2196f3;

            }
            .menu-toggle {
                color: #fff;
                float: right;
                line-height: 50px;
                font-size: 24px;
                cursor: pointer;
                display: none;
            }
            @media (max-width: 991px){
                header{
                    padding: 0 20px;
                    
                }
                .menu-toggle {
                    display: block;
                }
                header nav {
                    position: absolute;
                    width: 100%;
                    height: calc(100vh - 50px);
                    background: #333;
                    top: 50px;
                    left: -100%;
                    transition: 0.5s;
                }
                header nav.active{
                    left: 0;
                }
                header nav ul {
                    display: block;
                    text-align: center;
                }
                header nav ul li a {
                    border-bottom: 1px solid rgba(0, 0, 0, .2)
                }
                header nav ul li a:hover {
                    color: #fff;
                    background: #2196f3;
                }
            }
            
            
        </style>
    </head>
    <body>
        <header>
            <div class="logo">La Feriecita</div>
            <nav class="active">
                <ul>
                    <li><a href="{{url('index')}}" class="active">Inicio</a></li>
                    <li><a href="{{url('Quienes-Somos')}}">¿Quienes somos?</a></li>
                    <li><a href="{{url('Servicios')}}">Servicios</a></li>
                    <li><a href="{{url('Mision')}}">Misión</a></li>
                    <li><a href="{{url('Vision')}}">Visión</a></li>
                    <li><a href="">Contacto</a></li>

                    @if (Route::has('login'))
                    @auth
                        <li>
                        <a href="{{url('home')}}">Usuario Logueado</a>
                        
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}">Ingreso</a>
                        </li>

                        @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}">Registro</a>
                            </li>
                            {{-- <li>
                                <a href="{{ url('form-registrar') }}">Registrarme como prospecto</a>
                            </li> --}}
                        @endif
                    @endauth
            @endif

                </ul>
            </nav>
            <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
        </header>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.menu-toggle').click(function(){
                    $('nav').toggleClass('active')
                })
            })
        </script>
        
    </body>
</html>
