@extends('layouts.master')
@section('title', 'Registro Referencia laboral personas')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ url('admin/referencialbpersonas/' .$referencialbpersonas->id_rl_persona) }}" enctype="multipart/form-data">
  {{ csrf_field() }}
    {{ method_field('PATCH') }}
  <div class="form-row">
    <div>
      <label for="id_referencia_laboral">Referencia laboral</label>
      <input class="form-control" type="text" name="id_referencia_laboral" id="id_referencia_laboral" value="{{$referencialbpersonas->id_referencia_laboral}}">
    </div>
    <div>
      <label for="nombre_empresa">Nombre empresa</label>
      <input class="form-control" type="text" name="nombre_empresa" value="{{$referencialbpersonas->nombre_empresa}}">
    </div>
    <div>
      <label for="actividad_empresa">Actividad empresa</label>
      <input class="form-control" id="actividad_empresa" type="text" name="actividad_empresa" value="{{$referencialbpersonas->actividad_empresa}}">
    </div>
    <div>
      <label for="cargo_empresa">Cargo empresa</label>
      <input class="form-control" id="cargo_empresa" type="text" name="cargo_empresa" value="{{$referencialbpersonas->cargo_empresa}}">
    </div>
  </div>
  <p></p>
  <div class="form-row">
    <div>
      <label for="direccion">Dirección</label>
      <input class="form-control" id="direccion" type="text" name="direccion" value="{{$referencialbpersonas->direccion}}">
    </div>
    <div>
      <label for="numero_ext">Numero exterior</label>
      <input class="form-control" id="numero_ext" type="text" name="numero_ext" value="{{$referencialbpersonas->numero_ext}}">
    </div>
    <div>
      <label for="numero_int">Numero interior</label>
      <input class="form-control" id="numero_int" type="text" name="numero_int" value="{{$referencialbpersonas->numero_int}}">
    </div>
    <div>
      <label for="entre_calles">Entre calles</label>
      <input class="form-control" id="entre_calles" type="text" name="entre_calles" value="{{$referencialbpersonas->entre_calles}}">
    </div>
    <br>
    <div class="form-row">
      <div>
        <label for="telefono_empresa">Teléfono empresa</label>
        <input class="form-control" id="telefono_empresa" type="text" name="telefono_empresa" value="{{$referencialbpersonas->telefono_empresa}}">
      </div>
      <div>
        <label for="tiempo_empresa">Tiempo empresa</label>
        <input class="form-control" id="tiempo_empresa" type="text" name="tiempo_empresa" value="{{$referencialbpersonas->tiempo_empresa}}">
      </div>
      <div>
        <label for="jefe_inmediato">Jefe inmediato</label>
        <input class="form-control" id="jefe_inmediato" type="text" name="jefe_inmediato" value="{{$referencialbpersonas->jefe_inmediato}}">
      </div>
    </div>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-danger" type="submit" href="{{ route('referencialbpersonas.index') }}">Cancelar</a>
  </div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop