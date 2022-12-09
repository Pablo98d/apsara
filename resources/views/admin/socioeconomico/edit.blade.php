@extends('layouts.master')
@section('title', 'Registro Socio Economico')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ url('prestamo/socio/admin/socioeconomico/' .$socioeconomico->id_socio_economico) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_usuario">Usuario</label>
          {{-- <input type="text" id="id_usuario" class="form-control" name="id_usuario" value="{{ $socioeconomico->id_usuario }}"> --}}
          <select class="form-control show-tick ms select2" name="id_usuario" id="id_usuario" data-placeholder="Select">
            @foreach ($usuario as $user)
              <option {{$socioeconomico->id_usuario == $user->id ? 'selected="selected"' : 'Selecciona un usuario'}} value="{{$user->id}}">{{$user->nombre_usuario}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-6" hidden="si">
          <label for="fecha_registro">Fecha registro</label>
          <input type="text" id="fecha_registro" class="form-control" name="fecha_registro" value="{{ $socioeconomico->fecha_registro }}">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a type="submit" class="btn btn-danger" href="{{ route('socioeconomico.index') }}">Cancelar</a>
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