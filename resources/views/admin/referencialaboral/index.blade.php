@extends('layouts.master')
@section('title', 'Registro Referencia Laboral')
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
    <a class="btn btn-success" type="submit" href="{{ route('referencialaboral.create') }}">Nuevo Registro</a>
    <a href="{{ url('/referencialaboralexportar') }}">Exportar datos</a>
  </div>
    <div class="body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Socio Economico</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($referencialaboral))
            @foreach ($referencialaboral as $referencialab)
            <tr>
              <td>{{$referencialab->id_referencia_laboral}}</td>
              <td>{{$referencialab->id_socio_economico}}</td>
              <td class="d-flex">
                <a class="btn btn-info" href="{{ url('admin/referencialaboral/'.$referencialab->id_referencia_laboral.'/edit/') }}" title="">Editar</a>
                 | 
                <form action="{{ url('admin/referencialaboral/' .$referencialab->id_referencia_laboral) }}" method="post">
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