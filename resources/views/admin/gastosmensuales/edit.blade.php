@extends('layouts.master')
@section('title', 'Registro Gastos Mensuales')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ url('admin/gastosmensuales/' .$gastosmensuales->id_gasto_mensual) }}" enctype="multipart/form-data">
  {{ csrf_field() }}
    {{ method_field('PATCH') }}
  <div class="form-row">
    <div>
      <label for="id_socio_economico">Socio Economico</label>
      <input class="form-control" type="text" name="id_socio_economico" id="id_socio_economico" value="{{$gastosmensuales->id_socio_economico}}">
    </div>
    <div>
      <label for="renta_hipoteca">Renta Hipoteca</label>
      <input class="form-control" type="text" name="renta_hipoteca" value="{{$gastosmensuales->renta_hipoteca}}">
    </div>
    <div>
      <label for="telefono_fijo">Telefono fijo</label>
      <input class="form-control" id="telefono_fijo" type="text" name="telefono_fijo" value="{{$gastosmensuales->telefono_fijo}}">
    </div>
    <div>
      <label for="internet">Internet</label>
      <input class="form-control" id="internet" type="text" name="internet" value="{{$gastosmensuales->internet}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="telefono_movil">Telefono movil</label>
      <input class="form-control" id="telefono_movil" type="text" name="telefono_movil" value="{{$gastosmensuales->telefono_movil}}">
    </div>
    <div>
      <label for="cable">Cable</label>
      <input class="form-control" id="cable" type="text" name="cable" value="{{$gastosmensuales->cable}}">
    </div>
    <div>
      <label for="luz">Luz</label>
      <input class="form-control" id="luz" type="text" name="luz" value="{{$gastosmensuales->luz}}">
    </div>
    <div>
      <label for="gas">Gas</label>
      <input class="form-control" id="gas" type="text" name="gas" value="{{$gastosmensuales->gas}}">
    </div>
    <br>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-danger" type="submit" href="{{ route('gastosmensuales.index') }}">Cancelar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop