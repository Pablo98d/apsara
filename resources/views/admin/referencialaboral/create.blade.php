@extends('layouts.master')
@section('title', 'Registro Referencia Laboral')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ route('referencialaboral.store') }}">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_socio_economico">Socio Economico</label>
          {{-- <input type="id_socio_economico" id="id_socio_economico" class="form-control" name="id_socio_economico" value="{{ old('id_socio_economico') }}"> --}}
          <select class="form-control" name="id_socio_economico" id="id_socio_economico">
            @foreach ($soci as $econo)
              <option {{$econo->id_socio_economico == $idSocio ? 'selected="selected"' : 'Selecciona un socioeconomico'}} value="{{$econo->id_socio_economico}}">{{$econo->nombre_usuario}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-row">
      <div>
        <label for="nombre_empresa">Nombre empresa</label>
        <input class="form-control" id="nombre_empresa" type="text" name="nombre_empresa" value="{{old('nombre_empresa')}}">
      </div>
      <div>
        <label for="actividad_empresa">Actividad empresa</label>
        <input class="form-control" id="actividad_empresa" type="text" name="actividad_empresa" value="{{old('actividad_empresa')}}">
      </div>
      <div>
        <label for="cargo_empresa">Cargo empresa</label>
        <input class="form-control" id="cargo_empresa" type="text" name="cargo_empresa" value="{{old('cargo_empresa')}}">
      </div>
    </div>
    <p></p>
      <div class="form-row">
      <div>
      <label for="direccion">Dirección</label>
      <input class="form-control" id="direccion" type="text" name="direccion" value="{{old('direccion')}}">
    </div>
    <div>
      <label for="numero_ext">Numero exterior</label>
      <input class="form-control" id="numero_ext" type="text" name="numero_ext" value="{{old('numero_ext')}}">
    </div>
    <div>
      <label for="numero_int">Numero interior</label>
      <input class="form-control" id="numero_int" type="text" name="numero_int" value="{{old('numero_int')}}">
    </div>
    <div>
      <label for="entre_calles">Entre calles</label>
      <input class="form-control" id="entre_calles" type="text" name="entre_calles" value="{{old('entre_calles')}}">
    </div>
    <br>
    <div class="form-row">
      <div>
        <label for="telefono_empresa">Teléfono empresa</label>
        <input class="form-control" id="telefono_empresa" type="number" name="telefono_empresa" value="{{old('telefono_empresa')}}">
      </div>
      <div>
        <label for="tiempo_empresa">Tiempo empresa</label>
        <input class="form-control" id="tiempo_empresa" type="text" name="tiempo_empresa" value="{{old('tiempo_empresa')}}">
      </div>
      <div>
        <label for="jefe_inmediato">Jefe inmediato</label>
        <input class="form-control" id="jefe_inmediato" type="text" name="jefe_inmediato" value="{{old('jefe_inmediato')}}">
      </div>
    </div>
  </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Guardar datos</button>
        <a class="btn" href="{{ url('admin/referenciapersonal/'.$idSocio) }}">Continuar</a>
      </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop