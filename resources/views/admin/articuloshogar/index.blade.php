@extends('layouts.master')
@section('title', 'Registro Articulos del hogar')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
  <div class="header">
    @if ( session('Guardar') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('Guardar') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
    @endif
        <a class="btn btn-success" type="submit" href="{{ route('articuloshogar.create') }}" title="Nuevo Registro">Nuevo Registro</a>
        <a href="{{ url('/articuloshogarexportar') }}">Exportar datos</a>
    </div>
	<div class="body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Socio Economico</th>
            <th>Estufa</th>
            <th>Refrigerador</th>
            <th>Microondas</th>
            <th>Lavadora</th>
            <th>Secadora</th>
            <th>Computadora escritorio</th>
            <th>Laptop</th>
            <th>Televisión</th>
            <th>Pantalla</th>
            <th>Grabadora</th>
            <th>Estereo</th>
            <th>Dvd</th>
            <th>Blue ray</th>
            <th>Teatro casa</th>
            <th>Bocina portatil</th>
            <th>Celular</th>
            <th>Tablet</th>
            <th>Consola videojuegos</th>
            <th>Instrumentos</th>
            <th>Otros</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($articuloshogar))
          @foreach ($articuloshogar as $articulosdelhogar)
          <tr>
            <td>{{$articulosdelhogar->id_articulo}}</td>
            <td>{{$articulosdelhogar->id_usuario}}</td>
            <td>{{$articulosdelhogar->estufa}}</td>
            <td>{{$articulosdelhogar->refrigerador}}</td>
            <td>{{$articulosdelhogar->microondas}}</td>
            <td>{{$articulosdelhogar->lavadora}}</td>
            <td>{{$articulosdelhogar->secadora}}</td>
            <td>{{$articulosdelhogar->computadora_escritorio}}</td>
            <td>{{$articulosdelhogar->laptop}}</td>
            <td>{{$articulosdelhogar->television}}</td>
            <td>{{$articulosdelhogar->pantalla}}</td>
            <td>{{$articulosdelhogar->grabadora}}</td>
            <td>{{$articulosdelhogar->estereo}}</td>
            <td>{{$articulosdelhogar->dvd}}</td>
            <td>{{$articulosdelhogar->blue_ray}}</td>
            <td>{{$articulosdelhogar->teatro_casa}}</td>
            <td>{{$articulosdelhogar->bocina_portatil}}</td>
            <td>{{$articulosdelhogar->celular}}</td>
            <td>{{$articulosdelhogar->tablet}}</td>
            <td>{{$articulosdelhogar->consola_videojuegos}}</td>
            <td>{{$articulosdelhogar->instrumentos}}</td>
            <td>{{$articulosdelhogar->otros}}</td>
            <td class="d-flex">
              <a class="btn btn-info" href="{{ url('admin/articuloshogar/'.$articulosdelhogar->id_articulo.'/edit') }}" title="">Editar</a>
                | 
              <form method="POST" action="{{ url('admin/articuloshogar/'.$articulosdelhogar->id_articulo) }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger" type="submit" onclick="return confirm('¿Desea borrarlo?')">Borrar</button>
              </form>
            </td>
          </tr>
          @endforeach
          @else
            <p>No hay registros</p>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop