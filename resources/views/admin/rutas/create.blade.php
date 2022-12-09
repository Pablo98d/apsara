@extends('layouts.master')
@section('title', 'Registro Rutas')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ route('rutas.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_usuario">Usuario</label>
          <select class="form-control" id="id_usuario" name="id_usuario" value="{{old('id_usuario')}}">
            <option value="">--Escoja el usuario--</option>
            @foreach ($users as $datos)
              <option value="{{$datos->id_usuario}}">{{$datos->nombre_usuario}}</option>
            @endforeach
          </select>
          {{-- <input id="id_usuario" type="text" class="form-control" name="id_usuario" value="{{ old('id_usuario') }}"> --}}
        </div>
        <div>
          <label for="id_gerente">Gerente</label>
          <select class="form-control" id="id_gerente" name="id_gerente" value="{{old('id_gerente')}}">
            <option value="">--Escoja el usuario--</option>
            @foreach ($users2 as $datos2)
              <option value="{{$datos2->id_gerente}}">{{$datos2->nombre_usuario}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-6" hidden="si">
          <label for="fecha">Fecha</label>
          <input name="fecha" type="text" class="form-control" id="fecha" class="form-control" disabled="si" value="{{ old('fecha',$now->format('Y-m-d')) }}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="observaciones">Observaciones de la ruta</label>
          <input id="observaciones" type="text" class="form-control" name="observaciones" value="{{ old('observaciones') }}">
        </div>
      </div>
      {{-- <div class="form-row">
        <div>
          <label for="id_tipo_visita">Tipo visita</label>
          <select class="form-control" name="id_tipo_visita" id="id_tipo_visita">
            <option>---Seleccione el tipo de visita---</option>
            @foreach ($tipV as $tipo)
              <option value="{{$tipo->id_tipo_visita}}">{{$tipo->tipo_visita}}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="prioridad">Prioridad</label>
          <input class="form-control" id="prioridad" type="text" name="prioridad" placeholder="Prioridad">
        </div>
        <div>
          <label for="latitud">Latitud</label>
          <input class="form-control" id="latitud" type="text" name="latitud" placeholder="Latitud">
        </div>
      </div>
      <div class="form-row">
        <div>
          <label for="longitud">Longitud</label>
          <input class="form-control" id="longitud" type="text" name="longitud" placeholder="Longitud">
        </div>
        <div>
          <label for="observaciones">Observaciones del lugar</label>
          <input class="form-control" id="observaciones" type="text" name="observaciones" placeholder="Observaciones">
        </div>
        <div>
          <label for="tiempo_estimado">Tiempo estimado</label>
          <input class="form-control" id="tiempo_estimado" type="date" name="tiempo_estimado" placeholder="">
        </div>
        <br>
      </div> --}}
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Guardar datos</button>
        <a type="submit" class="btn btn-danger" href="{{ route('rutas.index') }}">Cancelar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop