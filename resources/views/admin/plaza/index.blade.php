@extends('layouts.master')
@section('content')
@section('title', 'Listado de regiones')
@section('parentPageTitle', 'Grupos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

@stop
<div class="body">
    <div> 
        {{--<h4>
        Listado de regiones
        </h4>--}}
        @if ( session('Guardar') )
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				{{ session('Guardar') }}
				<button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" >x</span>
				</button>
			</div>
		@endif
        <a class="btn btn-success btn-sm" href="{{route('admin-region.create')}}" title="Agregar una nueva región"><i class="fas fa-plus-circle"> Nueva región</i></a>
    </div>
    <div class="estilo-tabla">
        @if (!empty($plazas))
          <table class="js-basic-example">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Región</th>
                    <th>Fecha de apertura</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                
                    @foreach ($plazas as $plaza)
                <tr>
                    <td>{{$plaza->IdPlaza}}</td>
                    <td>{{$plaza->Plaza}}</td>
                    <td>{{$plaza->Fecha_apertura}}</td>
                    <td class="d-flex">
                        @php
                            $zonas=DB::table('tbl_zona')
                            ->select('tbl_zona.*')
                            ->where('IdPlaza','=',$plaza->IdPlaza)
                            ->get();
                        @endphp
                        <a class="btn btn-warning btn-sm" href="{{route('admin-region.edit',$plaza->IdPlaza)}}" title="Editar datos de la región"><i class="fas fa-pen"></i></a>
                    
                        <form action="{{ route('admin-region.destroy',$plaza->IdPlaza) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            @if (count($zonas)==0)
                                <button class="btn btn-danger btn-sm " type="submit" onclick="return confirm('¿Desea eliminar el registro?')" title="Eliminar región"><i class="fas fa-trash"></i></button>
                            @else
                                <button class="btn btn-secondary btn-sm " type="button" onclick="alert('La región tiene zonas, es imposible de eliminar. NOTA: Elimine las zonas o cambie de región')" title="Eliminar región"><i class="fas fa-trash"></i></button>
                            @endif
                          </form>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
          </table>
        @else
        <p>No hay registros</p>
        @endif
    </div>
</div>
    
@endsection
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('home') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>

@stop