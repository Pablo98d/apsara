@extends('layouts.master')
@section('title', 'Registro de usuario')
@section('parentPageTitle', 'Usuario')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<style>
.input-group-text {
	padding: 0 .75rem;
}
</style>

@stop
@section('content')
{{-- <div class="col-md-12"> --}}
  <hr>
{{-- </div> --}}
<div class="header">
  @if ( session('Guardar') )
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('Guardar') }}
      <button class="close" type="button" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"></span>
      </button>
    </div>
  @endif
  @if ( session('error') )
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button class="close" type="button" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"></span>
      </button>
    </div>
  @endif
      
  </div>
<form method="POST" action="{{ route('users.store') }}" style="font-weight:600;">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="nombre_usuario">Nombre</label>
          <input name="nombre_usuario" type="text" class="form-control" id="nombre_usuario" class="form-control @error('nombre_usuario') is-invalid @enderror" value="{{ old('nombre_usuario') }}" required autocomplete="nombre_usuario" autofocus>
          @error('nombre_usuario')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group col-md-4">
          <label for="nombre_usuario">Apellido paterno</label>
          <input name="ap_paterno" type="text" class="form-control" id="ap_paterno" class="form-control @error('ap_paterno') is-invalid @enderror" value="{{ old('ap_paterno') }}" required autocomplete="ap_paterno" autofocus>
          @error('ap_paterno')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group col-md-4">
          <label for="nombre_usuario">Apellido materno</label>
          <input name="ap_materno" type="text" class="form-control" id="ap_materno" class="form-control @error('ap_materno') is-invalid @enderror" value="{{ old('ap_materno') }}" required autocomplete="ap_materno" autofocus>
          @error('ap_materno')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group col-md-4">
          <label for="email">Correo Electrónico</label>
          <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group col-md-4">
          <label for="password">Contraseña</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        
        <div class="form-group col-md-4">
          <label for="id_tipo_usuario">Tipo Usuario</label>
          <select class="form-control show-tick ms select2 @error('id_tipo_usuario') is-invalid @enderror" name="id_tipo_usuario" id="id_tipo_usuario" data-placeholder="Select">
            <option value="">--Seleccione el tipo de usuario--</option>
            @foreach ($tipoUsuario as $tipo)
            @if ($tipo->id_tipo_usuario==3)
                
            @elseif($tipo->id_tipo_usuario==7)

            @else
              <option value="{{ $tipo->id_tipo_usuario }}">{{ $tipo->nombre }}</option>
                
            @endif

            @endforeach
          </select>
          @error('id_tipo_usuario')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Registrar usuario</button>
        {{-- <a type="submit" class="btn btn-danger" href="{{ route('users.index') }}">Cancelar</a> --}}
      </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>

<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop