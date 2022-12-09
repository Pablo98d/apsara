@extends('layouts.master')
@section('title', 'Registro Referencia Personal')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('referenciapersonal.store') }}">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_socio_economico">Socio Economico</label>
          {{-- <input type="id_socio_economico" id="id_socio_economico" class="form-control" name="id_socio_economico" value="{{ old('id_socio_economico') }}"> --}}
          <select class="form-control" name="id_socio_economico" id="id_socio_economico">
            @foreach ($soci as $econo)
              <option {{$econo->id_socio_economico == $idSocio ? 'selected="selected"' : 'Selecciona un socioeconomico'}} value="{{$econo->id_socio_economico}}">{{$econo->nombre_usuario}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-row">
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
        <input class="form-control" id="telefono" type="number" name="telefono" value="{{old('telefono')}}">
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
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Guardar datos</button>
        <a class="btn" href="{{ route('socioeconomico.index') }}">Finalizar</a>
      </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop