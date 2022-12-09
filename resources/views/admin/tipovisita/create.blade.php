@extends('layouts.master')
@section('title', 'Registro Tipo Visita')
@section('parentPageTitle', 'Rutas')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ route('tipovisita.store') }}">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="tipo_visita">Tipo Visita</label>
          <input type="text" id="tipo_visita" class="form-control @error('tipo_visita') is-invalid @enderror" name="tipo_visita" value="{{ old('tipo_visita') }}" required autocomplete="tipo_visita">
          @error('tipo_visita')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Aceptar</button>
        <a type="submit" class="btn btn-danger" href="{{ route('tipovisita.index') }}">Cancelar</a>
      </div>
    </form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop