@extends('layouts.master')
@section('title', 'Registro Finanzas')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('finanzas.store') }}">
  @csrf
  <div class="form-row">
    <div>
      <label for="id_socio_economico">Socio Economico</label>
      {{-- <input class="form-control" id="id_socio_economico" type="text" name="id_socio_economico" id="id_socio_economico" value="{{old('id_socio_economico')}}"> --}}
      <select class="form-control" name="id_socio_economico" id="id_socio_economico">
            @foreach ($soci as $econo)
              <option {{$econo->id_socio_economico == $idSocio ? 'selected="selected"' : 'Selecciona un socioeconomico'}} value="{{$econo->id_socio_economico}}">{{$econo->nombre_usuario}}</option>
            @endforeach
          </select>
    </div>
    <div>
      <label for="deuda_tarjeta_credito">Deuda en tarjeta de credito</label>
      <input class="form-control" id="deuda_tarjeta_credito" type="text" name="deuda_tarjeta_credito" value="{{old('deuda_tarjeta_credito')}}">
    </div>
    <div>
      <label for="deuda_otras_finanzas">Deuda en otras finanzas</label>
      <input class="form-control" id="deuda_otras_finanzas" type="text" name="deuda_otras_finanzas" value="{{old('deuda_otras_finanzas')}}">
    </div>
    <div>
      <label for="pension_hijos">Pensión para hijos</label>
      <input class="form-control" id="pension_hijos" type="text" name="pension_hijos" value="{{old('pension_hijos')}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="ingresos_mensuales">Ingresos mensuales</label>
      <input class="form-control" id="ingresos_mensuales" type="text" name="ingresos_mensuales" value="{{old('ingresos_mensuales')}}">
    </div>
    <div>
      <label for="buro_credito">Cuenta en buro credito</label>
      <input class="form-control" id="buro_credito" type="text" name="buro_credito" value="{{old('buro_credito')}}">
    </div>
    <br>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar datos</button>
    <a class="btn" href="{{ url('admin/fechamonto/'.$idSocio) }}">Continuar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop