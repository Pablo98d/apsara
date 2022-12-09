@extends('layouts.master')
@section('title', 'Registro Penalizaciones')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ url('admin/penalizacion/' .$penalizacion->id_penalizacion) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_prestamo">Prestamo</label>
          <input type="id_prestamo" id="id_prestamo" class="form-control @error('id_prestamo') is-invalid @enderror" name="id_prestamo" value="{{ $penalizacion->id_prestamo }}" required autocomplete="id_prestamo">
          @error('id_usuariorupo')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a type="submit" class="btn btn-danger" href="{{ route('penalizacion.index') }}">Cancelar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop