@extends('layouts.master')
@section('page-style')
@section('title', 'Nueva zona')
@section('parentPageTitle', 'zonas')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<style>
.input-group-text {
	padding: 0 .75rem;
}
</style>
@stop
@section('content')
    <div class="body">
        <form method="POST" action="{{ route('admin-zona.store') }}" style="color:#c29000; font-weight:600;">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="Zona">Zona</label>
                <input type="text" id="Zona" class="form-control @error('Zona') is-invalid @enderror" name="Zona" required>
                
              </div>
              <div class="form-group col-md-6">
                <label for="Fecha_apertura">Fecha de apertura</label>
                <input id="Fecha_apertura" type="date" class="form-control @error('Fecha_apertura') is-invalid @enderror" name="Fecha_apertura" required>
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="IdPlaza">Región</label>
                    <select class="form-control show-tick ms select2" name="IdPlaza" id="IdPlaza" data-placeholder="Select">
                        <option value="">--Escoja una región--</option>
                        @foreach ($plazas as $plaza)
                            <option value="{{ $plaza->IdPlaza }}">{{ $plaza->Plaza }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex">
              <button type="submit" class="btn btn-primary">Guardar</button>
              {{-- <a type="submit" class="btn btn-danger" href="{{ route('admin-zona.index') }}">Cancelar</a> --}}
            </div>
          </form>
    </div>
    
@endsection
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('admin-zona.index') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop