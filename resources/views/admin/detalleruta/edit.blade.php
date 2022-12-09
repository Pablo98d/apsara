@extends('layouts.master')
@section('title', 'Registro Detalle ruta')
@section('parentPageTitle', 'Rutas')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ url('admin/detalleruta/' .$detalleruta->id_detalle_ruta) }}" enctype="multipart/form-data">
  {{ csrf_field() }}
    {{ method_field('PATCH') }}
  <div class="form-row">
    <div>
      <label for="id_ruta">Ruta</label>
      {{-- <input class="form-control" type="text" name="id_ruta" id="id_ruta" value="{{$detalleruta->id_ruta}}"> --}}
      <select class="form-control" name="id_ruta" id="id_ruta">
        @foreach ($rutaN as $rut)
          <option {{$detalleruta->id_ruta == $rut->id_ruta ? 'selected="selected"' : 'Selecciona una ruta'}} value="{{$rut->id_ruta}}">{{$rut->observaciones}}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label for="id_tipo_visita">Tipo visita</label>
      {{-- <input class="form-control" type="text" name="id_tipo_visita" value="{{$detalleruta->id_tipo_visita}}"> --}}
      <select class="form-control" name="id_tipo_visita" id="id_tipo_visita">
        @foreach ($tipoV as $visi)
          <option {{$detalleruta->id_tipo_visita == $rut->id_tipo_visita ? 'selected="selected"' : 'Selecciona el tipo de visita'}} value="{{$visi->id_tipo_visita}}">{{$visi->tipo_visita}}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label for="prioridad">Prioridad</label>
      <input class="form-control" id="prioridad" type="text" name="prioridad" value="{{$detalleruta->prioridad}}" placeholder="Prioridad">
    </div>
    <div>
      <label for="latitud">Latitud</label>
      <input class="form-control" id="latitud" type="text" name="latitud" value="{{$detalleruta->latitud}}" placeholder="Latitud">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="longitud">Longitud</label>
      <input class="form-control" id="longitud" type="text" name="longitud" value="{{$detalleruta->longitud}}" placeholder="Longitud">
    </div>
    <div>
      <label for="observaciones">Observaciones</label>
      <input class="form-control" id="observaciones" type="text" name="observaciones" value="{{$detalleruta->observaciones}}" placeholder="Observaciones">
    </div>
    <div>
      <label for="tiempo_estimado">Tiempo estimado</label>
      <input class="form-control" id="tiempo_estimado" type="date" name="tiempo_estimado" value="{{$detalleruta->tiempo_estimado}}" placeholder="">
    </div>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-danger" type="submit" href="{{ route('detalleruta.index') }}">Cancelar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop