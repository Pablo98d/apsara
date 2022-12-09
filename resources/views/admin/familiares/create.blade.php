@extends('layouts.master')
@section('title', 'Registro Familiares')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ route('familiares.store') }}">
      {{ csrf_field() }}
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_socio_economico">Socio Economico</label>
          {{-- <input type="number" id="id_socio_economico" name="id_socio_economico" class="form-control" value="{{old('id_socio_economico')}}">  --}}
          <select class="form-control" name="id_socio_economico" id="id_socio_economico">
            @foreach ($soci as $econo)
              <option {{$econo->id_socio_economico == $idSocio ? 'selected="selected"' : 'Selecciona un socioeconomico'}} value="{{$econo->id_socio_economico}}">{{$econo->nombre_usuario}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="numero_personas">Numero de Personas</label>
          <input id="numero_personas" name="numero_personas" type="text" class="form-control" value="{{old('numero_personas')}}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="numero_personas_trabajando">Numero de personas que trabajan</label>
          <input name="numero_personas_trabajando" type="text" class="form-control" id="numero_personas_trabajando" class="form-control" value="{{old('numero_personas_trabajando')}}">
        </div>
        <div class="form-group col-md-6">
          <label for="aportan_dinero_mensual">Cuantos aportan dinero mensual</label>
          <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="text" class="form-control" value="{{old('aportan_dinero_mensual')}}">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Guardar datos</button>
        <a class="btn" href="{{ url('admin/aval/'.$idSocio) }}">Continuar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop