@extends('layouts.master')
@section('title', 'Registro Referencia personal personas')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('referenciappersonas.store') }}">
  @csrf
  <div class="form-row">
    <div>
      <label for="id_referencia_personal">Referencia personal</label>
      <input class="form-control" type="text" name="id_referencia_personal" id="id_referencia_personal" value="{{old('id_referencia_personal')}}">
    </div>
    <div>
      <label for="nombre">Nombre</label>
      <input class="form-control" id="nombre" type="text" name="nombre" value="{{old('nombre')}}">
    </div>
    <div>
      <label for="domicilio">Domicilio</label>
      <input class="form-control" id="domicilio" type="text" name="domicilio" value="{{old('domicilio')}}">
    </div>
    <div>
      <label for="telefono">Teléfono</label>
      <input class="form-control" id="telefono" type="text" name="telefono" value="{{old('telefono')}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="relacion">Relación</label>
      <input class="form-control" id="relacion" type="text" name="relacion" value="{{old('relacion')}}">
    </div>
    <br>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-danger" type="submit" href="{{ route('referenciappersonas.index') }}">Cancelar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop