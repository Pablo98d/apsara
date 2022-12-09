@extends('layouts.master')
@section('title', 'Registro Fecha de monto')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ route('fechamonto.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_socio_economico">Socio Economico</label>
          {{-- <input id="id_socio_economico" type="text" class="form-control" name="id_socio_economico" value="{{ old('id_socio_economico') }}"> --}}
          <select class="form-control" name="id_socio_economico" id="id_socio_economico">
            @foreach ($soci as $econo)
              <option {{$econo->id_socio_economico == $idSocio ? 'selected="selected"' : 'Selecciona un socioeconomico'}} value="{{$econo->id_socio_economico}}">{{$econo->nombre_usuario}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="fecha_credito">Fecha Credito</label>
          <input name="fecha_credito" type="text" class="form-control" id="fecha_credito" class="form-control" value="{{ old('fecha_credito') }}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="monto_credito">Monto de credito</label>
          <input id="monto_credito" type="text" class="form-control" name="monto_credito" value="{{ old('monto_credito') }}">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Guardar datos</button>
        <a class="btn" href="{{ url('admin/gastosmensuales/'.$idSocio) }}">Continuar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop