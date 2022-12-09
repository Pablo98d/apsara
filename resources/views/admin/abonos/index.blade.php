@extends('layouts.master')
@section('title', 'Registro Abonos')
@section('parentPageTitle', 'Prestamos')
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
      <a class="btn btn-success" type="submit" href="{{ route('abonos.create') }}" title="Nuevo Usuario">Nuevo Registro</a>
  </div>
  <div class="body">
      <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
          <tr>
            <th>#</th>
            <th>Prestamo</th>
            <th>Semana</th>
            <th>Cantidad</th>
            <th>Fecha de Pago</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($abonos))
            @foreach ($abonos as $abono)
          <tr>
            <td>{{$abono->id_abono}}</td>
            <td>{{$abono->id_prestamo}}</td>
            <td>{{$abono->semana}}</td>
            <td>{{$abono->cantidad}}</td>
            <td>{{$abono->fecha_pago}}</td>
            <td class="d-flex">
              <a class="btn btn-info" href="{{ url('admin/abonos/'.$abono->id_abono.'/edit/') }}">Editar</a>
                         | 
                        <form action="{{ url('admin/abonos/' .$abono->id_abono) }}" method="post">
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
<script>
    
  window.onload = function agregar_boton_atras(){

    document.getElementById('Atras').innerHTML='<a href="{{rounte('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
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