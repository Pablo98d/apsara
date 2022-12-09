@extends('layouts.master')
@section('title', 'Cambiando contraseña del usuario')
@section('parentPageTitle', 'usuario')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ url('admin/datosusuario/' .$user->id) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{-- action="{{ url('admin/datosusuario/'.$datosUs->id_usuario) }}" --}}
      {{ method_field('PATCH') }}
      <div class="form-row">
          <div class="form-group col-md-4">
            <label for="nombre_usuario">Usuario</label>
            <input name="nombre_usuario" type="text" class="form-control" id="nombre_usuario" class="form-control @error('nombre_usuario') is-invalid @enderror" value="{{ $user->nombre_usuario }}" autocomplete="nombre_usuario"  disabled>
            @error('nombre_usuario')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="password">Contraseña nueva</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" value="" autofocus>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
      </div>
      <br>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        {{-- <a type="submit" class="btn btn-dark" href="{{ route('datosusuario.index') }}">Regresar</a> --}}
      </div>
      <br>
    </form>
@stop
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('datosusuario.index') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop