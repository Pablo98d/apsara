@extends('layouts.master')
@section('title', 'Registro Gastos Semanales')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('gastossemanales.store') }}">
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
      <label for="alimentos">Alimentos</label>
      <input class="form-control" type="text" id="alimentos" name="alimentos" value="{{old('alimentos')}}">
    </div>
    <div>
      <label for="transporte_publico">Transporte Publico</label>
      <input class="form-control" id="transporte_publico" type="text" name="transporte_publico" value="{{old('transporte_publico')}}">
    </div>
    <div>
      <label for="gasolina">Gasolina</label>
      <input class="form-control" id="gasolina" type="text" name="gasolina" value="{{old('gasolina')}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="educacion">Educación</label>
      <input class="form-control" id="educacion" type="text" name="educacion" value="{{old('educacion')}}">
    </div>
    <div>
      <label for="diversion">Diversión</label>
      <input class="form-control" id="diversion" type="text" name="diversion" value="{{old('diversion')}}">
    </div>
    <div>
      <label for="medicamentos">Medicamentos</label>
      <input class="form-control" id="medicamentos" type="text" name="medicamentos" value="{{old('medicamentos')}}">
    </div>
    <div>
      <label for="deportes">Deportes</label>
      <input class="form-control" id="deportes" type="text" name="deportes" value="{{old('deportes')}}">
    </div>
    <br>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar datos</button>
    <a class="btn" href="{{ url('admin/referencialaboral/'.$idSocio) }}">Continuar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop