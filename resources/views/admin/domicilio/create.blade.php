@extends('layouts.master')
@section('title', 'Registro Domicilio')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('domicilio.store') }}">
  @csrf
  <div class="form-row">
    <div>
      <label for="id_socio_economico">Socio Economico</label>
      {{-- <input class="form-control" id="id_socio_economico" type="text" name="id_socio_economico" id="id_socio_economico" placeholder="Socio Economico" value="{{old('id_socio_economico')}}"> --}}
      <select class="form-control" name="id_socio_economico" id="id_socio_economico">
        @foreach ($soci as $econo)
          <option {{$econo->id_socio_economico == $idSocio ? 'selected="selected"' : 'Selecciona un socioeconomico'}} value="{{$econo->id_socio_economico}}">{{$econo->nombre_usuario}}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label for="calle">Calle</label>
      <input class="form-control" id="calle" type="text" name="calle" placeholder="Calle" value="{{old('calle')}}">
    </div>
    <div>
      <label for="numero_ext">Numero Exterior</label>
      <input class="form-control" id="numero_ext" type="text" name="numero_ext" placeholder="Numero Exterior">
    </div>
    <div>
      <label for="numero_int">Numero Interior</label>
      <input class="form-control" id="numero_int" type="text" name="numero_int" placeholder="Numero Interior">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="entre_calles">Entre Calles</label>
      <input class="form-control" id="entre_calles" type="text" name="entre_calles" placeholder="Entre Calles">
    </div>
    <div>
      <label for="colonia_localidad">Colonia Localidad</label>
      <input class="form-control" id="colonia_localidad" type="text" name="colonia_localidad" placeholder="Colonia Localidad">
    </div>
    <div>
      <label for="municipio">Municipio</label>
      <input class="form-control" id="municipio" type="text" name="municipio" placeholder="Municipio">
    </div>
    <div>
      <label for="estado">Estado</label>
      <input class="form-control" id="estado" type="text" name="estado" placeholder="Estado">
    </div>
    <br>
    <div class="form-row">
      <div>
        <label for="referencia_visual">Referencia Visual</label>
        <input class="form-control" id="referencia_visual" type="text" name="referencia_visual" placeholder="Referencia Visual">
      </div>
    </div>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar datos</button>
    <a class="btn" href="{{ url('admin/articuloshogar/'.$idSocio) }}">Continuar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop