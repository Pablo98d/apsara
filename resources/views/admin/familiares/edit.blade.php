@extends('layouts.master')
@section('title', 'Registro Familiares')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
  <form method="POST" action="{{ url('admin/familiares/' .$familiares->id_familiar) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_socio_economico">Socio Economico</label>
          <input type="number" id="id_socio_economico" name="id_socio_economico" class="form-control" value="{{$familiares->id_socio_economico}}"> 
        </div>
        <div class="form-group col-md-6">
          <label for="numero_personas">Numero de personas</label>
          <input id="numero_personas" name="numero_personas" type="text" class="form-control" value="{{$familiares->numero_personas}}">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="numero_personas_trabajando">Numero de personas que trabajan</label>
          <input name="numero_personas_trabajando" type="text" class="form-control" id="numero_personas_trabajando" class="form-control" value="{{$familiares->numero_personas_trabajando}}">
        </div>
        <div class="form-group col-md-6">
          <label for="aportan_dinero_mensual">¿Cuantos Aportan dinero mensual?</label>
          <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="date" class="form-control" value="{{$familiares->aportan_dinero_mensual}}">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a type="submit" class="btn btn-danger" href="{{ route('familiares.index') }}">Cancelar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop