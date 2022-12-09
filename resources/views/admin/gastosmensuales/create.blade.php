@extends('layouts.master')
@section('title', 'Registro Gastos Mensuales')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('gastosmensuales.store') }}">
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
      <label for="renta_hipoteca">Renta en hipoteca</label>
      <input class="form-control" type="text" id="renta_hipoteca" name="renta_hipoteca" value="{{old('renta_hipoteca')}}">
    </div>
    <div>
      <label for="telefono_fijo">Telefono fijo</label>
      <input class="form-control" id="telefono_fijo" type="text" name="telefono_fijo" value="{{old('telefono_fijo')}}">
    </div>
    <div>
      <label for="internet">Internet</label>
      <input class="form-control" id="internet" type="text" name="internet" value="{{old('internet')}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="telefono_movil">Telefono movil</label>
      <input class="form-control" id="telefono_movil" type="text" name="telefono_movil" value="{{old('telefono_movil')}}">
    </div>
    <div>
      <label for="cable">Cable</label>
      <input class="form-control" id="cable" type="text" name="cable" value="{{old('cable')}}">
    </div>
    <div>
      <label for="luz">Luz</label>
      <input class="form-control" id="luz" type="text" name="luz" value="{{old('luz')}}">
    </div>
    <div>
      <label for="gas">Gas</label>
      <input class="form-control" id="gas" type="date" name="gas" value="{{old('gas')}}">
    </div>
    <br>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar datos</button>
    <a class="btn" href="{{ url('admin/gastossemanales/'.$idSocio) }}">Continuar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop