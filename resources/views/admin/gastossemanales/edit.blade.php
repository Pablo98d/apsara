@extends('layouts.master')
@section('title', 'Registro Gastos Semanales')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ url('admin/gastossemanales/' .$gastossemanales->id_gasto_mensual) }}" enctype="multipart/form-data">
  {{ csrf_field() }}
    {{ method_field('PATCH') }}
  <div class="form-row">
    <div>
      <label for="id_socio_economico">Socio Economico</label>
      <input class="form-control" type="text" name="id_socio_economico" id="id_socio_economico" value="{{$gastossemanales->id_socio_economico}}">
    </div>
    <div>
      <label for="alimentos">Alimentos</label>
      <input class="form-control" type="text" name="alimentos" value="{{$gastossemanales->alimentos}}">
    </div>
    <div>
      <label for="transporte_publico">Transporte publico</label>
      <input class="form-control" id="transporte_publico" type="text" name="transporte_publico" value="{{$gastossemanales->transporte_publico}}">
    </div>
    <div>
      <label for="gasolina">Gasolina</label>
      <input class="form-control" id="gasolina" type="text" name="gasolina" value="{{$gastossemanales->gasolina}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="educacion">Educación</label>
      <input class="form-control" id="educacion" type="text" name="educacion" value="{{$gastossemanales->educacion}}">
    </div>
    <div>
      <label for="diversion">Diversión</label>
      <input class="form-control" id="diversion" type="text" name="diversion" value="{{$gastossemanales->diversion}}">
    </div>
    <div>
      <label for="medicamentos">Medicamentos</label>
      <input class="form-control" id="medicamentos" type="text" name="medicamentos" value="{{$gastossemanales->medicamentos}}">
    </div>
    <div>
      <label for="deportes">Deportes</label>
      <input class="form-control" id="deportes" type="text" name="deportes" value="{{$gastossemanales->deportes}}">
    </div>
    <br>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-danger" type="submit" href="{{ route('gastossemanales.index') }}">Cancelar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop