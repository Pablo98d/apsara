@extends('layouts.master')
@section('title', 'Registro Pareja')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ url('admin/pareja/' .$pareja->id_pareja) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_socio_economico">Socio Economico</label>
          <input type="text" id="id_socio_economico" class="form-control" name="id_socio_economico" value="{{ $pareja->id_socio_economico }}">
        </div>
        <div class="form-group col-md-6">
          <label for="nombre">Nombre</label>
          <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $pareja->nombre }}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="ap_paterno">Apellido Paterno</label>
          <input name="ap_paterno" type="text" class="form-control" id="ap_paterno" class="form-control" value="{{ $pareja->ap_paterno }}">
        </div>
        <div class="form-group col-md-6">
          <label for="ap_materno">Apellido Materno</label>
          <input class="form-control" id="ap_materno" type="text" name="ap_materno" value="{{ $pareja->ap_materno}}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="telefono">Teléfono</label>
          <input class="form-control" id="telefono" type="text" name="telefono" value="{{ $pareja->telefono}}" >
        </div>
        <div class="form-group col-md-6">
          <label for="edad">Edad</label>
          <input class="form-control" id="edad" type="text" name="edad" value="{{ $pareja->edad}}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="ocupacion">Ocupación</label>
          <input class="form-control" id="ocupacion" type="text" name="ocupacion" value="{{ $pareja->ocupacion}}">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a type="submit" class="btn btn-danger" href="{{ route('pareja.index') }}">Cancelar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop