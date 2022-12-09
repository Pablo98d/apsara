@extends('layouts.master')
@section('title', 'Registro Detalle ruta')
@section('parentPageTitle', 'Rutas')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('detalleruta.store') }}">
  @csrf
  <div class="form-row">
    <div>
      <label for="id_ruta">Ruta</label>
      {{-- <input class="form-control" id="id_ruta" type="text" name="id_ruta" id="id_ruta"> --}}
      <select class="form-control" name="id_ruta" id="id_ruta">
        <option>--- Seleccione una ruta ---</option>
        @foreach ($rutaO as $ruta)
          <option value="{{$ruta->id_ruta}}">{{$ruta->observaciones}}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label for="id_tipo_visita">Tipo visita</label>
      {{-- <input class="form-control" id="id_tipo_visita" type="text" name="id_tipo_visita"> --}}
      <select class="form-control" name="id_tipo_visita" id="id_tipo_visita">
        <option>---Seleccione el tipo de visita---</option>
        @foreach ($tipV as $tipo)
          <option value="{{$tipo->id_tipo_visita}}">{{$tipo->tipo_visita}}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label for="prioridad">Cantidad</label>
      <input class="form-control" id="cantidad" type="text" name="cantidad" placeholder="Unidades de visita">
    </div>
  </div>
  <p></p>
  <div class="form-row">
     <div>
      <label for="latitud">Latitud</label>
      <input class="form-control" id="latitud" type="text" name="latitud" placeholder="Latitud">
    </div>
     <div>
      <label for="longitud">Longitud</label>
      <input class="form-control" id="longitud" type="text" name="longitud" placeholder="Longitud">
    </div>
    <div>
      <label for="prioridad">Prioridad</label>
      <input class="form-control" id="prioridad" type="text" name="prioridad" placeholder="Prioridad">
    </div>
    <br>
  </div>

  <div class="=form-row">

      <label for="observaciones">Observaciones</label>
      <input class="form-control" id="observaciones" type="text" name="observaciones" placeholder="Observaciones">
    </div>
    <div>
      <label for="tiempo_estimado">Tiempo estimado</label>
      <input class="form-control" id="tiempo_estimado" type="date" name="tiempo_estimado" placeholder="">
    </div>
    <br>
  </div>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar datos</button>
    <a class="btn btn-danger" type="submit" href="{{ route('detalleruta.index') }}">Cancelar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop