@extends('layouts.master')
@section('title', 'Registro Fecha de monto')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ url('admin/fechamonto/' .$fechamonto->id_referencia) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_socio_economico">Socio Economico</label>
          <input id="id_socio_economico" type="id_socio_economico" class="form-control" name="id_socio_economico" value="{{ $fechamonto->id_socio_economico }}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="fecha_credito">Fecha Credito</label>
          <input name="fecha_credito" type="date" class="form-control" id="fecha_credito" class="form-control" value="{{ $fechamonto->fecha_credito }}">
        </div>
        <div class="form-group col-md-6">
          <label for="monto_credito">Monto de credito</label>
          <input id="monto_credito" type="text" class="form-control" name="monto_credito" value="{{ $fechamonto->monto_credito }}">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a type="submit" class="btn btn-danger" href="{{ route('fechamonto.index') }}">Cancelar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop