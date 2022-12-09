<style>

    body {

    background: url("assets/images/image-gallery/12.jpg");

    background-repeat: no-repeat;

    background-position: center;

    background-size: cover;

    } 

</style>



@extends('layouts.authentication')



@section('content')

<br><br>

<div class="container" style="opacity:0.8;">

    <div class="row justify-content-center">

        <div class="col-md-9">

            <div class="card">

                <div class="card-header" style="color:#181a27; font-weight:bold; font-size:20px">{{ __('Registro') }}</div>



                <div class="card-body">

                    <form method="POST" action="{{ url('registrar-prospecto') }}">

                        @csrf

                        



                        <div class="form-group row">

                            <label for="email" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Correo electrónico') }}</label>



                            <div class="col-md-6">

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">



                                @error('email')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="curp" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('CURP') }}</label>



                            <div class="col-md-6">

                                <input id="curp" type="text" class="form-control @error('curp') is-invalid @enderror" name="curp" value="{{ old('curp') }}" required autocomplete="curp" autofocus>



                                @error('curp')

                                <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>

                        <style>

                            hr  {

                                height: 4px !important; 

                                margin-top: 20px !important;

                                text-align: center !important;

                                

                            } 



                            .hr1:after {

                                content:"Nombre del prospecto" !important; 

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

                        <hr class="hr1">



                        <div class="form-group row">

                            <label for="name" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Nombre(s)') }}</label>



                            <div class="col-md-6">

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>



                                @error('name')

                                <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="ap_paterno" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Apellido Paterno') }}</label>



                            <div class="col-md-6">

                                <input id="ap_paterno" type="text" class="form-control @error('ap_paterno') is-invalid @enderror" name="ap_paterno" value="{{ old('ap_paterno') }}" required autocomplete="ap_paterno" autofocus>



                                @error('ap_paterno')

                                <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="ap_materno" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Apellido Materno') }}</label>



                            <div class="col-md-6">

                                <input id="ap_materno" type="text" class="form-control @error('ap_materno') is-invalid @enderror" name="ap_materno" value="{{ old('ap_materno') }}" required autocomplete="ap_materno" autofocus>



                                @error('ap_materno')

                                <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>

                        <hr class="hr2">

                        

                        <div class="form-group row">

                            <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Fecha de nacimiento') }}</label>



                            <div class="col-md-6">

                                <input id="fecha_nacimiento" type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required autocomplete="fecha_nacimiento" autofocus>



                                @error('fecha_nacimiento')

                                <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="edad" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Edad') }}</label>



                            <div class="col-md-6">

                                <input id="edad" type="text" class="form-control @error('edad') is-invalid @enderror" name="edad" value="{{ old('edad') }}" required autocomplete="edad" autofocus>



                                @error('edad')

                                <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <hr class="hr3">

                        

                        <div class="form-group row">

                            <label for="ocupacion" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Ocupación') }}</label>



                            <div class="col-md-6">

                                <input id="ocupacion" type="text" class="form-control @error('ocupacion') is-invalid @enderror" name="ocupacion" value="{{ old('ocupacion') }}" required autocomplete="ocupacion" autofocus>



                                @error('ocupacion')

                                <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="genero" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Genero') }}</label>



                            <div class="col-md-6">

                                <select id="genero" class="form-control @error('genero') is-invalid @enderror" name="genero"  required autocomplete="genero" autofocus>

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

                        <div class="form-group row">

                            <label for="estado_civil" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Estado civil') }}</label>



                            <div class="col-md-6">

                                <select class="form-control @error('estado_civil') is-invalid @enderror" name="" id="estado_civil" name="estado_civil" required autocomplete="estado_civil" autofocus>

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

                        <div class="form-group row">

                            <label for="enfermedad_cronica" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Enfermedad crónica') }}</label>



                            <div class="col-md-6">

                                <select class="form-control @error('enfermedad_cronica') is-invalid @enderror" name="enfermedad_cronica" id="enfermedad_cronica" name="enfermedad_cronica" required autocomplete="enfermedad_cronica" autofocus>

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

                        <div class="form-group row">

                            <label for="tiempo_vivienda" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Tiempo viviendo en el domicilio') }}</label>



                            <div class="col-md-6">

                                <select class="form-control @error('tiempo_vivienda') is-invalid @enderror" name="tiempo_vivienda" id="tiempo_vivienda" name="tiempo_vivienda" required autocomplete="tiempo_vivienda" autofocus>

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

                        <div class="form-group row">

                            <label for="tiempo_trabajo" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Tiempo que lleva en su trabajo') }}</label>



                            <div class="col-md-6">

                                <input id="tiempo_trabajo" type="text" class="form-control @error('tiempo_trabajo') is-invalid @enderror" name="tiempo_trabajo" value="{{ old('tiempo_trabajo') }}" required autocomplete="tiempo_trabajo" autofocus>



                                @error('tiempo_trabajo')

                                <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>































                        <div class="form-group row">

                            <label for="password" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Contraseña') }}</label>



                            <div class="col-md-6">

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">



                                @error('password')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Confirmar Contraseña') }}</label>



                            <div class="col-md-6">

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                            </div>

                        </div>



                        <div class="form-group row mb-0">

                            <div class="col-md-6 offset-md-4">

                                <button type="submit" class="btn btn-primary btn-block" style="font-weight:bold; font-size:15px">

                                    {{ __('Registrarme') }}

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <br><br><br>

</div>

@endsection