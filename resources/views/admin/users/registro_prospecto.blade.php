@extends('layouts.master')
@section('title', 'Registro de prospecto')
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>

    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
    <style>
        hr  {
            height: 4px !important; 
            margin-top: 20px !important;
            text-align: center !important;
            
        } 
        .hr1 {
            height: 1px;
            border-top:solid 1px #fff;
        }
        .hr2 {
            height: 1px;
            border-top:solid 1px #fff;
        }
        .hr3 {
            height: 1px;
            border-top:solid 1px #fff;
        }
        .hr1:after {
            content:"Nombre del prospecto" !important; 
            position: relative !important; 
            top: -12px !important; 
            display: inline-block !important; 
            background: #0c1729;
            width: 200px !important;
            }
        .hr2:after {
            content:"Fecha de nacimiento/Edad" !important; 
            position: relative !important; 
            top: -12px !important; 
            display: inline-block !important; 
            background: #0c1729;
            width: 230px !important;
            }
        .hr3:after {
            content:"Otros" !important; 
            position: relative !important; 
            top: -12px !important; 
            display: inline-block !important; 
            background: #0c1729;
            width: 55px !important;
            }
    </style>

@stop
@section('content')

    {{-- <div class="row"> --}}
        {{-- <div class="col-md-12"> --}}
            <hr style="padding: 0; margin:0; margin-bottom:4px;">
                    @if ( session('error') )
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <center>
                                {{ session('error') }}
                            </center>
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"></span>
                            </button>
                        </div>
                    @endif
                    @if ( session('status') )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <center>
                                {{ session('status') }}
                            </center>
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"></span>
                            </button>
                        </div>
                    @endif
                    <form method="POST" action="{{ url('registrar-prospecto') }}">
                        @csrf
                        @php
                            $promotoras = DB::table('tbl_grupos_promotoras')
                            ->Join('tbl_grupos', 'tbl_grupos_promotoras.id_grupo', '=', 'tbl_grupos.id_grupo')
                            ->Join('tbl_usuarios', 'tbl_grupos_promotoras.id_usuario', '=', 'tbl_usuarios.id')
                            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                            ->select('tbl_datos_usuario.*','tbl_grupos.*','tbl_usuarios.*')
                            ->get();
                        @endphp
                        <div class=" row ">
                            
                            <div class="col-md-12 mb-2">
                                <label for="email" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Promotor / grupo') }}</label>
                                <select class="text-fondo form-control show-tick ms select2 @error('email') is-invalid @enderror" name="id_promotora" id="mySelect" required autofocus data-placeholder="Select">
                                    <option value="">--Seleccione su promotor--</option>
                                    @foreach ($promotoras as $promotora)
                                        <option data-idgrupo="{{$promotora->id_grupo}}" value="{{$promotora->id_usuario}}">{{$promotora->nombre}} {{$promotora->ap_paterno}} / {{$promotora->grupo}} </option>
                                        
                                    @endforeach
                                </select>
                                {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> --}}

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="hidden" name="id_grupo" id="nombre2" value="">
                            </div>
                        
                            
                            <div class="col-md-4">
                                <label for="curp" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('CURP') }}</label>
                                <input id="curp" type="text" class="form-control @error('curp') is-invalid @enderror" name="curp" value="{{ old('curp') }}" required autocomplete="curp" autofocus>

                                @error('curp')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                      
                        <div class="form-group row mb-2">
                            <div class="col-md-12 mt-2 mb-2">
                                <hr class="hr1">
                            </div>
                            <div class="col-md-4">
                                <label for="name" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Nombre(s)') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                            
                            <div class="col-md-4">
                                <label for="ap_paterno" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Apellido Paterno') }}</label>
                                <input id="ap_paterno" type="text" class="form-control @error('ap_paterno') is-invalid @enderror" name="ap_paterno" value="{{ old('ap_paterno') }}" required autocomplete="ap_paterno" autofocus>

                                @error('ap_paterno')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                            
                            <div class="col-md-4">
                                <label for="ap_materno" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Apellido Materno') }}</label>
                                <input id="ap_materno" type="text" class="form-control @error('ap_materno') is-invalid @enderror" name="ap_materno" value="{{ old('ap_materno') }}" required autocomplete="ap_materno" autofocus>

                                @error('ap_materno')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-2">
                            <div class="col-md-12 mt-2 mb-2">
                                <hr class="hr2">
                            </div>
                            
                            <div class="col-md-4">
                                <label for="fecha_nacimiento" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Fecha de nacimiento') }}</label>
                                <input id="fecha_nacimiento" type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required autocomplete="fecha_nacimiento" autofocus>

                                @error('fecha_nacimiento')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                            
                            <div class="col-md-4">
                                <label for="edad" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Edad') }}</label>
                                <input id="edad" type="text" class="form-control @error('edad') is-invalid @enderror" name="edad" value="{{ old('edad') }}" required autocomplete="edad" autofocus>

                                @error('edad')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 mt-2 mb-2">
                                <hr class="hr3" >
                            </div>
                            <div class="col-md-4">
                                <label for="ocupacion" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Ocupación') }}</label>
                                <input id="ocupacion" type="text" class="form-control @error('ocupacion') is-invalid @enderror" name="ocupacion" value="{{ old('ocupacion') }}" required autocomplete="ocupacion" autofocus>

                                @error('ocupacion')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="genero" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Genero') }}</label>
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
                            <div class="col-md-4">
                                <label for="estado_civil" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Estado civil') }}</label>
                                <select class="form-control @error('estado_civil') is-invalid @enderror" id="estado_civil" name="estado_civil" required autocomplete="estado_civil" autofocus>
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
                        
                            
                            <div class="col-md-4 mt-2">
                                <label for="enfermedad_cronica" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Enfermedad crónica') }}</label>
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
                        
                            
                            <div class="col-md-4 mt-2">
                                <label for="tiempo_vivienda" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Tiempo viviendo en el domicilio') }}</label>
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
                        
                            
                            <div class="col-md-4 mt-2">
                                <label for="tiempo_trabajo" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Tiempo que lleva en su trabajo') }}</label>
                                <input id="tiempo_trabajo" type="text" class="form-control @error('tiempo_trabajo') is-invalid @enderror" name="tiempo_trabajo" value="{{ old('tiempo_trabajo') }}" required autocomplete="tiempo_trabajo" autofocus>

                                @error('tiempo_trabajo')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                       
                            
                            <div class="col-md-4 mt-2">
                                <label for="password" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Contraseña') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                            
                            <div class="col-md-4 mt-2">
                                <label for="password-confirm" class="col-form-label text-md-right" style="font-weight:bold; font-size:15px">{{ __('Confirmar Contraseña') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary" style="float: right;background: none; border:2px solid #007fb2;color: #fff;">
                                    {{ __('Registrar prospecto') }}
                                </button>
                            </div>
                        </div>
                    </form>
        {{-- </div> --}}
    {{-- </div> --}}
    
    <br>
@stop
@section('page-script')
<script>
    window.onload = function agregar_boton_atras(){
  
      document.getElementById('Atras').innerHTML='<a href="{{ route('datosusuario.index') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';

  }
</script>
    <script>
        var selection = document.getElementById("mySelect");

            selection.onchange = function(event){
            var idgrupo = event.target.options[event.target.selectedIndex].dataset.idgrupo;
            document.getElementById("nombre2").value = idgrupo;
            };

    </script>
    <script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>

    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop

