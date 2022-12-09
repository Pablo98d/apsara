@extends('layouts.master')
@section('title', 'Actualizando datos de zona')
@section('parentPageTitle', 'zonas')
@section('content')
<div class="row">
  <div class="col-md-12">
    <hr style="padding: 0; margin:0; margin-bottom:4px;">

  </div>
</div>
    <div class="body mt-4">
        <form method="POST" action="{{ route('admin-zona.update',$zona->IdZona) }}" >
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="Zona">Zona</label>
                <input type="text" id="Zona" class="form-control @error('Zona') is-invalid @enderror" name="Zona" value="{{$zona->Zona}}">
                
              </div>
              <div class="form-group col-md-6">
                <label for="Fecha_apertura">Fecha de apertura</label>
                <input id="Fecha_apertura" type="date" class="form-control @error('Fecha_apertura') is-invalid @enderror" name="Fecha_apertura" value="{{$zona->Fecha_apertura}}">
              </div>
            </div>
            <div class="d-flex">
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
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

@stop