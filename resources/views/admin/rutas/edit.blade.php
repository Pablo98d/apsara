@extends('layouts.master')
@section('title', 'Registro Rutas')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ url('admin/rutas/' .$rutas->id_ruta) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_usuario">Usuario</label>
          {{-- <input id="id_usuario" type="text" class="form-control" name="id_usuario" value="{{ $rutas->id_usuario }}"> --}}
          <select class="form-control" name="id_usuario" id="id_usuario">
            @foreach ($usuario as $use)
              <option {{$use->id == $rutas->id_usuario ? 'selected="selected"' : 'Selecciona un usuario'}} value="{{$use->id}}">{{$use->nombre_usuario}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_gerente">Gerente</label>
          {{-- <input id="id_gerente" type="text" class="form-control" name="id_gerente" value="{{ $rutas->id_gerente }}"> --}}
          <select class="form-control" name="id_gerente" id="id_gerente">
            @foreach ($gerente as $ger)
              <option {{$ger->id == $rutas->id_gerente ? 'selected="selected"' : 'Selecciona un gerente'}}  value="{{$ger->id}}">{{$ger->nombre_usuario}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6" hidden="si">
          <label for="fecha">Fecha</label>
          <input name="fecha" type="date" class="form-control" id="fecha" class="form-control" value="{{ $rutas->fecha }}">
        </div>
        <div class="form-group col-md-6">
          <label for="observaciones">Observaciones</label>
          <input id="observaciones" type="text" class="form-control" name="observaciones" value="{{ $rutas->observaciones }}">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a type="submit" class="btn btn-danger" href="{{ route('rutas.index') }}">Cancelar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop