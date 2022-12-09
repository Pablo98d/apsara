@extends('layouts.master')
@section('title', 'Actualizando datos región')
@section('parentPageTitle', 'grupos')
@section('content')
    <div class="body">
        {{-- <div>
            <a href="{{route('admin-region.index')}}" class="btn btn-outline-dark btn-sm">Regresar</a>
        </div> --}}
        <form method="POST" class="mt-3" action="{{ route('admin-region.update',$plaza->IdPlaza) }}" style="color:#c29000; font-weight:600;">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="Plaza">Región</label>
                <input type="text" id="Plaza" class="form-control @error('Plaza') is-invalid @enderror" name="Plaza" value="{{$plaza->Plaza}}">
                
              </div>
              <div class="form-group col-md-6">
                <label for="Fecha_apertura">Fecha de apertura</label>
                <input id="Fecha_apertura" type="date" class="form-control @error('Fecha_apertura') is-invalid @enderror" name="Fecha_apertura" value="{{$plaza->Fecha_apertura}}">
              </div>
            </div>
            <div class="d-flex">
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
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