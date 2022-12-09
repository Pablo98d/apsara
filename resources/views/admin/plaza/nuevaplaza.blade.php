@extends('layouts.master')
@section('content')
@section('title', 'Nueva región')
@section('parentPageTitle', 'Region')
@section('content')
    <div class="body">
        <form method="POST" action="{{ route('admin-region.store') }}" style="color:#c29000; font-weight:600;">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="Plaza">Región</label>
                <input type="text" id="Plaza" class="form-control @error('Plaza') is-invalid @enderror" name="Plaza" required placeholder="Ej. Occidente">
                
              </div>
              <div class="form-group col-md-6">
                <label for="Fecha_apertura">Fecha de apertura</label>
                <input id="Fecha_apertura" type="date" class="form-control @error('Fecha_apertura') is-invalid @enderror" name="Fecha_apertura" required>
              </div>
            </div>
            <div class="d-flex">
              <button type="submit" class="btn btn-primary">Guardar</button>
              {{-- <a type="submit" class="btn btn-danger" href="{{ route('admin-region.index') }}">Cancelar</a> --}}
            </div>
          </form>
    </div>
@endsection
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{route('admin-region.index')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>

@stop