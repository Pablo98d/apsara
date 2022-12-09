@extends('layouts.master')
@section('title', 'Registro Socio Economico')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<style>
.input-group-text {
	padding: 0 .75rem;
}
</style>
@stop
@section('content')
    <form method="POST" action="{{ route('socioeconomico.store') }}">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="id_usuario">Usuario</label>
          <select class="form-control show-tick ms select2" id="id_usuario" name="id_usuario" value="{{old('id_usuario')}}" data-placeholder="Select">
            <option value="">--Seleccione el usuario--</option>
            @foreach ($user as $datos)
            <option value="{{$datos->id}}">{{$datos->nombre}} {{$datos->ap_paterno}} {{$datos->ap_materno}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="id_promotora">Promotor</label>
          <select class="form-control show-tick ms select2" id="id_promotora" name="id_promotora" value="{{old('id_promotora')}}" data-placeholder="Select">
            <option value="">--Seleccione el promotor--</option>
            @foreach ($promotores as $promotor)
          <option value="{{$promotor->id}}">{{$promotor->nombre}} {{$promotor->ap_paterno}} {{$promotor->ap_materno}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="id_promotora">Estatus</label>
          <select class="form-control" id="estatus" name="estatus" value="{{old('estatus')}}">
            <option value="">--Seleccione el estatus--</option>
            <option value="0">0</option>
            <option value="1">1</option>
          </select>
        </div>

        <div class="form-group col-md-6" hidden="si">
          <label for="fecha_registro">Fecha Registro</label>
          <input type="text" id="fecha_registro" class="form-control" name="fecha_registro" value="{{ old('fecha_registro',$now->format('Y-m-d')) }}">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a type="submit" class="btn btn-dark" href="{{ route('socioeconomico.index') }}">Cancelar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>


<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop