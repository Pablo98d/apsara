@extends('layouts.master')
@section('title', 'Registro Familiares')
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
      <a class="btn btn-success" type="submit" href="{{ route('familiares.create') }}" title="Nuevo Usuario">Nuevo Registro</a>
      <a href="{{ url('/familiaresexportar') }}">Exportar datos</a>
  </div>
  <div class="body">
      <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
          <tr>
            <th>#</th>
            <th>Socio Economico</th>
            <th>Numero Personas</th>
            <th>Numero Personas trabajando</th>
            <th>Aportación de dinero</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($familiares))
            @foreach ($familiares as $familiar)
          <tr>
            <td>{{$familiar->id_familiar}}</td>
            <td>{{$familiar->id_socio_economico}}</td>
            <td>{{$familiar->numero_personas}}</td>
            <td>{{$familiar->numero_personas_trabajando}}</td>
            <td>{{$familiar->aportan_dinero_mensual}}</td>
            <td class="d-flex">
              <a class="btn btn-info" href="{{ url('admin/familiares/'.$familiar->id_familiar.'/edit/') }}">Editar</a>
                         | 
                        <form action="{{ url('admin/familiares/' .$familiar->id_familiar) }}" method="post">
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