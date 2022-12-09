@extends('layouts.master')
@section('title', 'Lista de préstamos')
@section('parentPageTitle', 'prestamos')
@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
      <hr>
    @if ( session('Guardar') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('Guardar') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
    @endif
    
    </div>
  </div>
    <div class="body">

      <div class="form-group">
        <a class="btn btn-success" href="{{ route('prestamos.create') }}"><i class="fas fa-plus-circle"> Nuevo Registro</i></a>
        <a class="btn btn-outline-info" href="{{url('prestamo/buscar_prestamos1') }}" title="Préstamos por región"></i> <i class="fas fa-map-marked-alt"></i></a>
        <a href="#" class="btn btn-success" title="Ayuda en cómo renovar los prestamos" onclick="ayudamodal()"><i class="fas fa-question"></i></a>
      </div>
      
      <div class="estilo-tabla">
        <table class="js-basic-example">
          <thead>
            <tr>
              <th><small>No.</small></th>
              <th><small>Cliente</small></th>
              <th><small>Estatus</small></th>
              <th><small>Grupo</small></th>
              <th><small>Producto</small></th>
              <th><small>Cantidad</small></th>
              <th><small>Acciones</small></th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($prestamos))
            @foreach ($prestamos as $prestamo)
            <tr>
              <td><small>{{$prestamo->id_prestamo}}</small></td>
              <td><small>{{$prestamo->cli_nombre.' '.$prestamo->cli_paterno.' '.$prestamo->cli_materno}}</small></td>
                @php
                    $dates = date_create($prestamo->fecha_solicitud);
                @endphp
              
              <td><small>{{$prestamo->status_prestamo}}</small></td>
              <td><small>{{$prestamo->grupo}}</small></td>
              
              <td><small>{{$prestamo->producto}}</small></td>
              
              <td><small>$ {{number_format($prestamo->cantidad,2)}}</small></td>
              <td class="d-flex">
                <a class="btn btn-warning btn-sm" type="submit" href="{{ url('prestamo/buscar-cliente/admin/prestamos/' .$prestamo->id_prestamo.'/edit') }}"><i class="fas fa-pen"></i></a>
                 | 
                <form action="{{ url('prestamo/buscar-cliente/admin/prestamos/' .$prestamo->id_prestamo) }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')"><i class="fas fa-trash"></i></button>
                </form>
                <a href="{{url('detalle-prestamo/'.$prestamo->id_prestamo)}}" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-eye"></i></a>
              </td>
            </tr>
            @endforeach
            
            @else
              <p>No hay Registros</p>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal fade" id="modalayuda" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Utilizando el interfaz prestamos de como renovar los mismos</h4>
                </div>
                <div class="modal-body">
                  <iframe width="760" height="400" src="https://www.youtube.com/embed/CotBKVb3xiQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
    


@stop
@section('page-script')
<script>
    

  window.onload = function agregar_boton_atras(){

    document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
}
</script>
<script>
  function ayudamodal(){
  $("#modalayuda").modal();
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

<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop