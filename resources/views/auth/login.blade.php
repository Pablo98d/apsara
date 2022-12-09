<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>¡Hola! ingresa tu correo y contraseña</title>

    <link rel="shortcut icon" href="{{asset('estilo_v2/img/logo/logo.png')}}" type="image/x-icon">

    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.13.0-web/css/all.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

<style>

        *{

    margin: 0;

    box-sizing: border-box;



}

        



body {

    font-family: sans-serif;

    padding: 90px 60px 0;

    justify-content: space-between;

    max-width: 1350px;

    margin: 0 auto;

    background: #ededed;



}



.header {

    /* background-color: #ffdb0f; */
    /* background-color: #000000; */
    background-color: #181a27;
    

    height: 240px;

    position: fixed;

    width: 100%;

    top: 0;

    left: 0;

    z-index: -1;

}



.nav {

    display: flex;

    justify-content: space-between;

    max-width: 992px;

    margin: 0 130px;

    /* background: red; */

    position: absolute;

    bottom: 10px;

    left: 50px;

}



.nav-link {

    color: rgb(238, 238, 238);

    text-decoration: none;



}



.logo {

    font-size: 30px;

    font-weight: bold;

    padding: 0 20px 0 75px;

    /* line-height: 20px; */

    /* position: relative; */

}



.logo span{

    color: #343975;

    position: absolute;

    font-size: 18px;

    top: 5px;

    left: 154px;

}



.logo img {

    width: 60px;

    margin-left: 14px;

}



.nav-menu {

    display: flex;

    margin-right: 40px;

    list-style: none;

}



.nav-menu-item {

    font-size: 15px;

    margin: 0 3px;

    /* line-height: 30px; */

    /* text-transform: uppercase; */

    width: max-content;

}

.nav-menu-link{

    padding: 8px 12px;

}

.nav-menu-link:hover,

.nav-menu-link_active {

    /* background-color: teal; */

    color: rgb(65, 65, 65);

}

.nav-menu-link i {

    font-size: 12px;

    /* color: rgb(112, 112, 112); */

}



.nav-toggle {

    color: white;

    background: none;

    border: none;

    font-size: 30px;

    padding: 0 20px;

    line-height: 60px;

    cursor: pointer;



    display: none;

}



.menu-buscar {

    /* background: red;s */

    padding: 9px;

    color: rgb(139, 139, 139);

    /* width: 80%; */

    width: 560px;

    margin-top: 10px;

    border-radius: 2px;

    border: 1px solid rgba(20, 20, 20, 0.212);

    font-size: 15px;

    box-shadow: 2px 1px 0px rgba(99, 99, 99, 0.377);

    outline: none;

}



.buscador-logo {

    /* display: flex; */

}

/* .contenido{

    max-width: 1350px;

} */





/* menu desplegable para las rutas */

.desplegable-menu{

    position: absolute; 

    background: rgb(78, 78, 78);  

    display: flex; 

    width: max-content; 

    padding: 8px;

    border-radius: 5px; 

    color: rgb(224, 224, 224); 

    font-size: 14px;

}

/* #lista-rutas li {

    background: #ffdb13;

    



} */

    </style>

</head>

<body>

    <header class="header">

    

        <style>

            

            .region-perfil{

                /* font-size: 15px;*/

                margin-left:3%; 

                line-height: 60px;

                /* text-transform: uppercase; */

                /* width: max-content; */

            }

            .lista-region{

                font-size: 14px;

                color: rgb(65, 170, 255);

                /* text-transform: uppercase; */

                font-weight: bold;

                border-bottom: 1px solid #000;

    

            }

            .contenido-menu2{

                position: relative;

            }

            .desplegable-menu2{

                position: absolute; 

                background: rgb(78, 78, 78);  

                display: flex; 

                width: max-content; 

                width: 200px;

                padding: 8px;

                border-radius: 5px; 

                color: rgb(224, 224, 224); 

                font-size: 14px; 

                margin: 0;

                line-height: 20px;

                top: 42px;

                display: none;

            }

            

            .contenido-menu2:hover .desplegable-menu2{

                /* left: 10px; */

                /* background: red; */

                display: block;

                transition: .1s;

            }

            .notificación-contenido{

                position: relative;

            }

            .notificaciones{

                background: red;

                padding: 2px 5px 2px 5px;

                font-size: 10px;

                border-radius: 10px;

                color: #fff;

                width: 15px;

                height: 15px;

                position: absolute;

                top: 2px;

                left: 20px;

                outline: none;

                border: 0;

                text-align: center;

                cursor: pointer;

            }

            .cotenido-login{

                background: rgb(255, 255, 255);

                margin-top: 20px;

                z-index: 300;

                width: 35%;

                margin: 40px auto;

                border-radius: 5px;

                padding: 65px;

            }



            .cotenido-login h1 {

                color:  #5b5b5a;

                font-size: 24px;

            }

            

            .cotenido-login input {

                padding: 10px;

                font-size: 20px;

                margin: 0px 10px 15px 0px;

                width: 100%;

                border-radius: 5px;

                border: 1px solid #b9b9b9;

            }

            

            .cotenido-login input:focus, input[type]:focus {

                /* border-color: #3483fa;

                border: 2px solid #3483fa; */

                /* box-shadow: 2px 2px 9px #3483fa; */

                outline-style: inset #3483fa !important;

                /* outline: 0 none; */

            }

            /* .cotenido-login input:focus{

                outline: #ffdb13;

            } */

            .contenido-formulario {

                margin-top: 30px;

            }

            .contenido-formulario label {

                padding: 0px 0px 3px 7px;

                font-size: 13px;

                /* margin-bottom: 60px; */

                width: 100%;

                border-radius: 5px;

                /* border: 1px solid #b9b9b9; */

                color: #4c4c4c;

                /* background: #000; */

                /* margin-top: 90px; */

                display: block;

            }



            

        </style>

        

        <div class="buscador-logo">

            <a href="{{url('/')}}" class=" nav-link" >

                {{-- <img src="landing/assets/img/Logo-apsara-png.png" class="img-fluid" style="margin-left: 50px;margin-top: 50px"> --}}

                {{-- <img src="{{asset('estilo_v2/img/logo/LogoPrestamos.png')}}" width="10px"  alt="LogoTipo" > --}}

                {{-- <span style="font-family: 'Baloo 2', cursive; ">La</span>

                <span style="font-family: 'Baloo 2', cursive;margin-top:18px  ">Feriecita</span> --}}

            </a>

            

        </div>

        <div>

            

        </div>

        <style>

            .lista-rutas{

                list-style: none; text-align: left; padding: 0;

            }

            .lista-rutas li {

                /* background: #ffdb13; */

                cursor: pointer;

                margin-left: 5px; padding: 3px

            }

            .lista-rutas li a {

                color: rgb(224, 224, 224); 

                text-decoration: none;

            }

            .lista-rutas li a:hover  {

                /* background: #ffdb13; */

                color: rgb(184, 184, 184); 

            }

            

            .contenido-menu{

                position: relative;

            }

            .contenido-menu:hover .desplegable-menu{

                /* left: 10px; */

                /* background: red; */

                display: block;

                transition: .1s;

            }

            .desplegable-menu {

                position: absolute; 

                background: rgb(78, 78, 78);  

                display: flex; 

                /* width: max-content;  */

                width: 300px;

                padding: 8px;

                border-radius: 5px; 

                color: rgb(224, 224, 224); 

                font-size: 14px; 

    

                display: none;

                /* left:-500px; */

            }

            .buton-continuar-l{

                padding: 13px;

                background: #181a27;

                width: 100%;

                /* margin: 5px; */

                /* height: 0px; */

                border: 0;

                border-radius: 5px;

                font-size: 20px;

                cursor: pointer;

                color: #fff;



            }

            .buton-continuar-l:hover{

                background: #404040;



            }



            .buton-crear-l{

                padding: 13px;

                /* background: #636364; */

                

                border-radius: 5px;

                font-size: 20px;

                cursor: pointer;

                color: #404040;

                margin-top: 15px;
                text-decoration: none;



            }

            .buton-crear-l:hover{

                background: #e4e4e4;

                transition-duration: .5s, 2s, 2s, 2s;



            }

            .mensaje-alerta{

                background: rgba(255, 3, 3, 0.829);

                color: rgb(241, 241, 241);

                padding: 10px;

                border-radius: 5px;

                text-align: center;

                margin: 0 auto;

                width: 35%;

            }

            .mensaje-alerta-success{

                background: rgba(5, 189, 75, 0.829);

                color: rgb(241, 241, 241);

                padding: 10px;

                border-radius: 5px;

                text-align: center;

                margin: 0 auto;

                width: 35%;

            }

            

    

            

        </style>

    </header>

    <section>

            @if ( session('Error') )

                <div class="mensaje-alerta" role="alert">

                    {{ session('Error') }}

                    

                </div>

            @endif

            @if ( session('status') )

                <div class="mensaje-alerta-success" role="alert">

                    {{ session('Error') }}

                    

                </div>

            @endif

            <div class="cotenido-login">

                

                <form method="POST" action="{{ route('login') }}">

                    @csrf

                   

                    <h1 style="color: #333333; font-family: 'Montserrat', sans-serif;">¡Hola! ingresa tu correo y contraseña</h1>

                    

                    {{-- <div class="header"> --}}

                    {{-- <a href="{{url('/')}}">

                            <img src="{{asset('assets/images/lf/LogoPrestamos.png')}}" width="50%" alt="LaFeriecita">

                            <h5>Iniciar Sesión</h5>

                        </a>

                    </div> --}}

                    <div class="contenido-formulario">

                            <label for=""style="color: #333333" >Email</label>

                            <input id="email" type="email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" >

                            <div class="input-group-append">

                                <span class="input-group-text" role="alert"><i class="zmdi zmdi-account-circle">

                                </i></span>

                            </div>

                            <label for="" style="color: #333333">Contraseña</label>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}">

                            <div class="input-group-append">

                                <span class="input-group-text" role="alert"><i class="zmdi zmdi-lock">

                                </i></span>

                            </div>                            

                            <br><br>

                            {{-- <button class="buton-continuar-l">Continuar</button> --}}

                            <button type="submit" class="buton-continuar-l">

                                {{ __('Continuar') }}

                            </button><br><br>

                            <center>

                                <a href="{{url('register')}}" class="buton-crear-l" >Crear cuenta</a>

                            </center>



                                {{-- @if (Route::has('password.request'))

                                    <a class="btn btn-link" href="{{ route('password.request') }}">

                                    {{ __('¿Olvidaste tu contraseña?') }}

                                    </a>

                                @endif

                                    <a class="btn btn-link" href="{{ route('register') }}">

                                    {{ __('No tengo cuenta') }}

                                    </a> --}}

                                                  

                    </div>

                </form>

                {{-- <div class="copyright text-center">

                    &copy;

                    <script>document.write(new Date().getFullYear())</script>,

                    <span>Diseñado por <a href="http://pice-software.com/" target="_blank">Pice Software</a></span>

                </div> --}}

            </div>

            {{-- <div class="col-lg-8 col-sm-12">

                <div class="card">

                    <img src="{{asset('assets/images/signin.svg')}}" alt="Sign In"/>

                </div>

            </div> --}}

        {{-- </div> --}}

    </section>

</body>

</html>

