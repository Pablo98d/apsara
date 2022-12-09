@extends('layouts.master')
@section('title', 'Nuevo estatus préstamo')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ route('statusprestamo.store') }}">
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="status_prestamo">Estatus Prestamo</label>
          <input type="text" id="status_prestamo" class="form-control @error('status_prestamo') is-invalid @enderror" name="status_prestamo" value="{{ old('status_prestamo') }}" required autocomplete="status_prestamo">
          @error('status_prestamo')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary">Guardar estatus préstamo</button>
        {{-- <a type="submit" class="btn btn-danger" href="{{ route('statusprestamo.index') }}">Cancelar</a> --}}
      </div>
    </form>
@stop
@section('page-script')
<script>
  window.onload = function agregar_boton_atras(){
    document.getElementById('Atras').innerHTML='<a href="{{route('statusprestamo.index')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
}
</script>
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop