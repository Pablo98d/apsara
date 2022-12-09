@extends('layouts.master')
@section('title', 'Registro Vivienda')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('vivienda.store') }}">
  @csrf
  <div class="form-row">
    <div>
      <label for="id_socio_economico">Socio Economico</label>
      {{-- <input class="form-control" type="text" name="id_socio_economico" id="id_socio_economico" value="{{old('id_socio_economico')}}"> --}}
      <select class="form-control" name="id_socio_economico" id="id_socio_economico">
        @foreach ($soci as $econo)
          <option {{$econo->id_socio_economico == $idSocio ? 'selected="selected"' : 'Selecciona un socioeconomico'}} value="{{$econo->id_socio_economico}}">{{$econo->nombre_usuario}}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label for="tipo_vivienda">Tipo vivienda</label>
      <input class="form-control" id="tipo_vivienda" type="text" name="tipo_vivienda" value="{{old('tipo_vivienda')}}">
    </div>
    <div>
      <label for="tiempo_viviendo_domicilio">Tiempo viviendo</label>
      <input class="form-control" id="tiempo_viviendo_domicilio" type="text" name="tiempo_viviendo_domicilio" value="{{old('tiempo_viviendo_domicilio')}}">
    </div>
    <div>
      <label for="telefono_casa">Telefono Casa</label>
      <input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{old('telefono_casa')}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="telefono_celular">Telefono celular</label>
      <input class="form-control" id="telefono_celular" type="text" name="telefono_celular" value="{{old('telefono_celular')}}">
    </div>
    <br>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar datos</button>
    <a class="btn" type="submit" href="{{ url('admin/pareja/'.$idSocio) }}">Continuar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop