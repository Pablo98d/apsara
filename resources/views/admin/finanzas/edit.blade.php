@extends('layouts.master')
@section('title', 'Registro Finanzas')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ url('admin/finanzas/' .$finanzas->id_finanza) }}" enctype="multipart/form-data">
  {{ csrf_field() }}
    {{ method_field('PATCH') }}
  <div class="form-row">
    <div>
      <label for="id_socio_economico">Socio Economico</label>
      <input class="form-control" type="text" name="id_socio_economico" id="id_socio_economico" value="{{$finanzas->id_socio_economico}}">
    </div>
    <div>
      <label for="deuda_tarjeta_credito">Deuda en tarjeta de credito</label>
      <input class="form-control" type="text" name="deuda_tarjeta_credito" value="{{$finanzas->deuda_tarjeta_credito}}">
    </div>
    <div>
      <label for="deuda_otras_finanzas">Deuda en otras financieras</label>
      <input class="form-control" id="deuda_otras_finanzas" type="text" name="deuda_otras_finanzas" value="{{$finanzas->deuda_otras_finanzas}}">
    </div>
    <div>
      <label for="pension_hijos">Pension para hijos</label>
      <input class="form-control" id="pension_hijos" type="text" name="pension_hijos" value="{{$finanzas->pension_hijos}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="ingresos_mensuales">Ingresos Mensuales</label>
      <input class="form-control" id="ingresos_mensuales" type="text" name="ingresos_mensuales" value="{{$finanzas->ingresos_mensuales}}">
    </div>
    <div>
      <label for="buro_credito">Cuenta en buro de credito</label>
      <input class="form-control" id="buro_credito" type="text" name="buro_credito" value="{{$finanzas->buro_credito}}">
    </div>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-danger" type="submit" href="{{ route('finanzas.index') }}">Cancelar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop