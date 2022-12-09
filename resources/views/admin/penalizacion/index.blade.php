@extends('layouts.master')
@section('title', 'Listado penalizaciones')
@section('parentPageTitle', 'Préstamos')
@section('page-style')

<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
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
    <!-- <a class="btn btn-success" type="submit" href="{{ route('penalizacion.create') }}" title="Nuevo Registro"><i class="fas fa-plus-circle"> Nuevo registro </i></a> -->
  </div>
  <div class="col-md-12">
    <hr>
  </div>
    <div class="body">
      <div class="table-responsive">
        <table class="js-basic-example">
          <thead>
            <tr>
              <th>#</th>
              <th>Cliente</th>
              <th>Préstamo</th>
              <th title="Número abono">No.A</th>
              <th>Penalización</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($penalizacion))
            @foreach ($penalizacion as $penali)
            <tr>
              <td>{{$penali->id_penalizacion}}</td>
              <td>{{$penali->nombre}} {{$penali->ap_paterno}} {{$penali->ap_materno}}</td>
              <td>{{$penali->id_prestamo}}</td>
              <td>{{$penali->id_abono}}</td>
              <td>{{$penali->tipoAbono}}</td>

              <td class="d-flex">
                <a class="btn btn-warning btn-sm" href="{{ url('admin/penalizacion/'.$penali->id_penalizacion.'/edit/') }}" title="Editar datos penalización"><i class="fas fa-pen"></i></a>
                 | 
                <form action="{{ url('admin/penalizacion/' .$penali->id_penalizacion) }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')"><i class="fas fa-trash"></i></button>
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
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop