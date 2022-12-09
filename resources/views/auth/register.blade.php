<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Crear cuenta</title>

    {{-- <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}"> --}}

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}" defer></script>



    <link rel="stylesheet" href="css/estilos_personalizado.css">

    <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.13.0-web/css/all.css')}}">

    <link rel="shortcut icon" href="{{asset('estilo_v2/img/logo/LogoPrestamos.png')}}" type="image/x-icon">

    

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

            background: #f7f7f7;



        }



        .header {

            background-color: #181a27;

            height: 56px;

            position: fixed;

            width: 100%;

            top: 0;

            left: 0;

            z-index: 1;

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

            color: rgb(112, 112, 112);

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

            left: 154px;;

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

       

      

        .mensaje-alerta-success{

            background: rgba(5, 189, 75, 0.829);

            color: rgb(241, 241, 241);

            padding: 10px;

            border-radius: 5px;

            text-align: center;

            margin: 0 auto;

            width: 100%;

        }

        .mensaje-alerta-danger{

            background: rgba(255, 3, 3, 0.829);

            color: rgb(241, 241, 241);

            padding: 10px;

            border-radius: 5px;

            text-align: center;

            margin: 0 auto;

            width: 100%;

        }

    </style>

</head>

<body>

  

    <div class="col-md-7 mt-3" style="margin: 0 auto;position: relative;">

        <h4 class="mb-4" style="margin-left:-15px; font-weight: 500;color: #333333; font-family: 'Montserrat', sans-serif;"> 

            

                Completa tus datos

            

        </h4>

        <a href="{{url('login')}}" style="position: absolute;bottom: 0;right: 0;color: #181a27">Ya tengo cuenta ></a>

    </div>

    <div class="col-md-7" style="margin: 0 auto;background: #fff;border: 1px solid rgb(202, 202, 202);border-radius: 6px;">

        

        <div class="row">

            @if ( session('status') )

                <div class="col-md-12 mt-3">

                    <div class="mensaje-alerta-success" role="alert">

                        {{ session('status') }}

                    </div>

                </div>

            @endif

            @if ( session('Error') )

                <div class="col-md-12 mt-3">

                    <div class="mensaje-alerta-danger" role="alert">

                        {{ session('Error') }}

                    </div>

                </div>

            @endif

            



        </div>

            

            <form method="POST" action="{{ url('registrar-prospecto') }}">

                @csrf

                @php

                    $promotoras = DB::table('tbl_grupos_promotoras')

                    ->Join('tbl_grupos', 'tbl_grupos_promotoras.id_grupo', '=', 'tbl_grupos.id_grupo')

                    ->Join('tbl_usuarios', 'tbl_grupos_promotoras.id_usuario', '=', 'tbl_usuarios.id')

                    ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')

                    ->select('tbl_datos_usuario.*','tbl_grupos.*','tbl_usuarios.*')

                    ->orderBy('tbl_datos_usuario.nombre','ASC')

                    ->get();

                @endphp

            

                <style>

                    .contenido-caja-texto{

                        position: relative;

                        height: 50px;

                    }

                    .caja-texto{

                        /* background: red; */

                        width: 100%;

                        height: 30px;

                        position: absolute;

                        left: 0;

                        bottom: 0;

                        padding: 0;

                        font-size: 18px;

                        border: 0;

                        border-bottom: 1px solid rgb(190, 190, 190);

                        /* outline: #2968c8; */



                    }

                    .contenido-caja-texto input:focus, input[type]:focus {

                        /* border-color: #3483fa; */

                        border-bottom: 2px solid #181a27;

                        /* box-shadow: 2px 2px 9px #3483fa; */

                        /* outline-style: inset #3483fa !important; */

                        outline: 0 none;

                    }

                    .contenido-caja-texto small {

                        left: 0;

                        bottom: -20px;

                        position: absolute;

                        color: gray;

                    }

                </style>

            <div class="row " style="margin: 0 auto">

                <div class="col-md-12 mt-4">

                    <div class="contenido-caja-texto">

                        <label for="email" style="color: gray" >{{ __('Promotor / grupo') }}</label>

                        <select class="caja-texto @error('email') is-invalid @enderror" name="id_promotora" id="mySelect" required autofocus>

                            <option value="">--Seleccione su promotor--</option>

                            @foreach ($promotoras as $promotora)

                                <option data-idgrupo="{{$promotora->id_grupo}}" value="{{$promotora->id_usuario}}">{{$promotora->nombre}} {{$promotora->ap_paterno}} / {{$promotora->grupo}} </option>

                                

                            @endforeach

                        </select>

                        @error('email')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror



                    </div>

                    <input type="hidden" name="id_grupo" id="nombre2" value="">

                </div>



                <div class="col-md-12 mt-4">

                    <div class="contenido-caja-texto">

                        <label for="curp" style="color: gray">{{ __('CURP') }}</label>

                        <input id="curp" type="text" class="caja-texto @error('curp') is-invalid @enderror" name="curp" value="{{ old('curp') }}" required autocomplete="curp" autofocus>



                        @error('curp')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                        <small>Copia como esta en su documento</small>

                    </div>

                </div>

                <div class="col-md-12 mt-4">

                    <hr class="hr1">

                </div>

            

                <style>

                    hr  {

                        height: 4px !important; 

                        margin-top: 20px !important;

                        text-align: center !important;

                        

                    } 



                    .hr1:after {

                        content:"Nombre del prospecto" !important;

                        color: rgb(117, 117, 117); 

                        position: relative !important; 

                        top: -12px !important; 

                        display: inline-block !important; 

                        background: #fff;

                        width: 160px !important;

                        }

                    .hr2:after {

                        content:"Fecha de nacimiento/Edad" !important; 

                        position: relative !important; 

                        top: -12px !important; 

                        display: inline-block !important; 

                        background: #fff;

                        width: 180px !important;

                        }

                    .hr3:after {

                        content:"Otros" !important; 

                        position: relative !important; 

                        top: -12px !important; 

                        display: inline-block !important; 

                        background: #fff;

                        width: 50px !important;

                        }

                </style>

                



                <div class="col-md-4 mt-3">

                    <div class="contenido-caja-texto">

                        <label for="name" style="color:gray">{{ __('Nombre(s)') }}</label>

                        <input id="name" type="text" class="caja-texto @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>



                        @error('name')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-4 mt-3">

                    <div class="contenido-caja-texto">

                        <label for="ap_paterno" style="color: gray">{{ __('Apellido Paterno') }}</label>

                        <input id="ap_paterno" type="text" class="caja-texto @error('ap_paterno') is-invalid @enderror" name="ap_paterno" value="{{ old('ap_paterno') }}" required autocomplete="ap_paterno" autofocus>



                        @error('ap_paterno')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-4 mt-3">

                    <div class="contenido-caja-texto">

                        <label for="ap_materno"  style="color: gray ">{{ __('Apellido Materno') }}</label>

                        <input id="ap_materno" type="text" class="caja-texto @error('ap_materno') is-invalid @enderror" name="ap_materno" value="{{ old('ap_materno') }}" required autocomplete="ap_materno" autofocus>



                        @error('ap_materno')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-12 mt-4">

                    <hr class="hr2">

                </div>

                

                <div class="col-md-6 mt-3">

                    <div class="contenido-caja-texto">

                        <label for="fecha_nacimiento" style="color: gray;">{{ __('Fecha de nacimiento') }}</label>

                        <input id="fecha_nacimiento" type="date" class="caja-texto @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required autocomplete="fecha_nacimiento" autofocus>



                        @error('fecha_nacimiento')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-6 mt-3">

                    <div class="contenido-caja-texto">

                        <label for="edad" style="color: gray;">{{ __('Edad') }}</label>

                        <input id="edad" type="text" class="caja-texto @error('edad') is-invalid @enderror" name="edad" value="{{ old('edad') }}" required autocomplete="edad" autofocus>



                        @error('edad')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-12 mt-4">

                    <hr class="hr3">

                </div>



                

                <div class="col-md-6 mt-3">

                    <div class="contenido-caja-texto">

                    <label for="ocupacion" style="color: gray;">{{ __('Ocupación') }}</label>

                        <input id="ocupacion" type="text" class="caja-texto @error('ocupacion') is-invalid @enderror" name="ocupacion" value="{{ old('ocupacion') }}" required autocomplete="ocupacion" autofocus>



                        @error('ocupacion')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-6 mt-3">

                    <div class="contenido-caja-texto">

                        <label for="genero" style="color: gray;">{{ __('Genero') }}</label>

                        <select id="genero" class="caja-texto @error('genero') is-invalid @enderror" name="genero"  required autocomplete="genero" autofocus>

                            <option value="">--Seleccione su genero--</option>

                            <option value="Hombre">Hombre</option>

                            <option value="Mujer">Mujer</option>

                            <option value="Otro">Otro</option>

                        </select>



                        @error('genero')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-6 mt-4">

                    <div class="contenido-caja-texto">

                        <label for="estado_civil" style="color: gray;">{{ __('Estado civil') }}</label>

                        <select class="caja-texto @error('estado_civil') is-invalid @enderror" id="estado_civil" name="estado_civil" required autocomplete="estado_civil" autofocus>

                            <option value="">--Seleccione su estado civil--</option>

                            <option value="Soltero(a)">Soltero(a)</option>

                            <option value="Union Libre">Union Libre</option>

                            <option value="Casado(a)">Casado(a)</option>

                            <option value="Divorciado(a)">Divorciado(a)</option>

                            <option value="Viudo(a)">Viudo(a)</option>

                        </select>



                        @error('estado_civil')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-6 mt-4">

                    <div class="contenido-caja-texto">

                        <label for="enfermedad_cronica" style="color: gray;">{{ __('Enfermedad crónica') }}</label>

                        <select class="caja-texto @error('enfermedad_cronica') is-invalid @enderror" name="enfermedad_cronica" id="enfermedad_cronica" name="enfermedad_cronica" required autocomplete="enfermedad_cronica" autofocus>

                            <option value="">--Seleccione su respuesta--</option>

                            <option value="Si">Si</option>

                            <option value="No">No</option>

                        </select>



                        @error('enfermedad_cronica')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-6 mt-4">

                    <div class="contenido-caja-texto">

                        <label for="tiempo_vivienda" style="color: gray;">{{ __('Tiempo viviendo en el domicilio') }}</label>

                        <select class="caja-texto @error('tiempo_vivienda') is-invalid @enderror" name="tiempo_vivienda" id="tiempo_vivienda" name="tiempo_vivienda" required autocomplete="tiempo_vivienda" autofocus>

                            <option value="">--Seleccione tiempo--</option>

                            <option value="0 a 3 meses">0 a 3 meses</option>

                            <option value="3 meses a 1 año">3 meses a 1 año</option>

                            <option value="1 a 3 años">1 a 3 años</option>

                            <option value="3 a 5 años">3 a 5 años</option>

                            <option value="Más de 5 años">Más de 5 años</option>



                        </select>



                        @error('tiempo_vivienda')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-6 mt-4">

                    <div class="contenido-caja-texto">

                        <label for="tiempo_trabajo" style="color: gray;">{{ __('Tiempo que lleva en su trabajo') }}</label>

                        <input id="tiempo_trabajo" type="text" class="caja-texto @error('tiempo_trabajo') is-invalid @enderror" name="tiempo_trabajo" value="{{ old('tiempo_trabajo') }}" required autocomplete="tiempo_trabajo" autofocus>



                        @error('tiempo_trabajo')

                        <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>

                <div class="col-md-6 mt-4">

                    <div class="contenido-caja-texto">

                        <label for="password" style="color: gray;">{{ __('Contraseña') }}</label>

                        <input id="password" type="password" class="caja-texto @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">



                        @error('password')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>

                </div>



                <div class="col-md-6 mt-4 mb-4">

                    <div class="contenido-caja-texto">

                        <label for="password-confirm" style="color: gray;">{{ __('Confirmar Contraseña') }}</label>

                        <input id="password-confirm" type="password" class="caja-texto" name="password_confirmation" required autocomplete="new-password">

                    </div>

                </div>

            </div>

            

            

        

    </div>

    <style>

        .buton-continuar-l{

                padding: 13px;

                background: #181a27;

                width: 30%;

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

    </style>

    <div class="col-md-7 mb-4 mt-4" style="margin: 0 auto;">

        <button type="submit" style="margin-left: -15px" class="buton-continuar-l" style="font-weight:bold; font-size:15px">

            {{ __('Continuar') }}

        </button>

        <br><br><br>

    </div>

    </form>

    

<script>

    var selection = document.getElementById("mySelect");



        selection.onchange = function(event){

        var idgrupo = event.target.options[event.target.selectedIndex].dataset.idgrupo;

        document.getElementById("nombre2").value = idgrupo;

        };



</script>

</body>

</html>