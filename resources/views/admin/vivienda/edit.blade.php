@extends('layouts.master')
@section('title', 'Registro Vivienda')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ url('admin/vivienda/' .$vivienda->id_vivienda) }}" enctype="multipart/form-data">
  {{ csrf_field() }}
    {{ method_field('PATCH') }}
  <div class="form-row">
    <div>
      <label for="id_socio_economico">Socio Economico</label>
      <input class="form-control" type="text" name="id_socio_economico" id="id_socio_economico" value="{{$vivienda->id_socio_economico}}">
    </div>
    <div>
      <label for="tipo_vivienda">Tipo vivienda</label>
      <input class="form-control" type="text" name="tipo_vivienda" value="{{$vivienda->tipo_vivienda}}">
    </div>
    <div>
      <label for="tiempo_viviendo_domicilio">Tiempo viviendo</label>
      <input class="form-control" id="tiempo_viviendo_domicilio" type="text" name="tiempo_viviendo_domicilio" value="{{$vivienda->tiempo_viviendo_domicilio}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="telefono_casa">Telefono casa</label>
      <input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{$vivienda->telefono_casa}}">
    </div>
    <div>
      <label for="telefono_celular">Telefono celular</label>
      <input class="form-control" id="telefono_celular" type="text" name="telefono_celular" value="{{$vivienda->telefono_celular}}">
    </div>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-danger" type="submit" href="{{ route('vivienda.index') }}">Cancelar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop