@extends('layouts.master')
@section('title', 'Listado de estatus préstamo')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')
    <div class="col-md-12">
    @if ( session('Guardar') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('Guardar') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
    @endif
        {{-- <a class="btn btn-success" type="submit" href="{{ route('statusprestamo.create') }}" title="Nuevo Registro"><i class="fas fa-plus-circle"> Nuevo estatus préstamo</i></a> --}}
    </div>
    <div class="body">
      <div class="estilo-tabla">
        <table class=" js-basic-example ">
          <thead>
            <tr>
              <th>#</th>
              <th>Estatus del Prestamo</th>
              {{-- <th>Acciones</th> --}}
            </tr>
          </thead>
          <tbody>
            @if (!empty($statusprestamo))
            @foreach ($statusprestamo as $stprestamo)
            <tr>
              <td>{{$stprestamo->id_status_prestamo}}</td>
              <td>{{$stprestamo->status_prestamo}}</td>
              {{-- <td class="d-flex">
                
                <a class="btn btn-warning btn-sm" type="submit" href="{{ url('admin/statusprestamo/'.$stprestamo->id_status_prestamo.'/edit/') }}"><i class="fas fa-pen"></i></a>
                 | 
                <form action="{{ url('admin/statusprestamo/' .$stprestamo->id_status_prestamo) }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')"><i class="fas fa-trash"></i></button>
                </form>
              </td> --}}
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
<script>
  window.onload = function agregar_boton_atras(){
    document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
}
</script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop