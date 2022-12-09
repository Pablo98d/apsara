@extends('layouts.master')
@section('title', 'Registro Pareja')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('pareja.store') }}">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_socio_economico">Socio Economico</label>
          {{-- <input type="text" id="id_socio_economico" class="form-control" name="id_socio_economico" value="{{ old('id_socio_economico') }}"> --}}
          <select class="form-control" name="id_socio_economico" id="id_socio_economico">
            @foreach ($soci as $econo)
              <option {{$econo->id_socio_economico == $idSocio ? 'selected="selected"' : 'Selecciona un socioeconomico'}} value="{{$econo->id_socio_economico}}">{{$econo->nombre_usuario}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="nombre">Nombre</label>
          <input id="nombre" type="text" class="form-control" name="nombre" value="{{old('nombre')}}">
        </div>
        <div class="form-group col-md-6">
          <label for="ap_paterno">Apellido Paterno</label>
          <input type="text" id="ap_paterno" class="form-control" name="ap_paterno" value="{{ old('ap_paterno') }}">
        </div>
        <div class="form-group col-md-6">
          <label for="ap_materno">Apellido Materno</label>
          <input id="ap_materno" type="text" class="form-control" name="ap_materno" value="{{old('ap_materno')}}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="telefono">Teléfono</label>
          <input name="telefono" type="text" class="form-control" id="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>
        <div class="form-group col-md-6">
          <label for="edad">Edad</label>
          <input class="form-control" id="edad" type="text" name="edad" value="{{old('edad')}}">
        </div>
        <div>
          <label for="ocupacion">Ocupación</label>
          <input class="form-control" id="ocupacion" type="text" name="ocupacion" value="{{old('ocupacion')}}">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Guardar datos</button>
        <a class="btn" href="{{ url('admin/domicilio/'.$idSocio) }}">Continuar</a>
      </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop