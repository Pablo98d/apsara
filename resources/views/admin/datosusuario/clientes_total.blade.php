@extends('layouts.master')
@section('title', 'Total de clientes')
{{-- @section('parentPageTitle', 'usuario') --}}
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>
@stop
@section('content')
  {{-- <div class="header"> --}}
    @if ( session('Guardar') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('Guardar') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
    @endif
        
  {{-- </div> --}}
  <div class="row">
    <div class="col-md-12">
      <hr style="padding: 0; margin:0; margin-bottom:4px;">
    </div>
    <hr style="padding: 0; margin:0; margin-bottom:4px;">
  </div>
  <div class="col-md-12">
    
    <div class="estilo-tabla">
      <table class="js-basic-example dataTable no-footer">
        <thead>
          <tr>
            <th><small>No.</small></th>
            <th><small>Usuario</small></th>
            <th><small>Tipo</small></th>
            <th><small>Nombre completo</small></th>
            <th><small>Dirección</small></th>
            <th><small>Latitud</small></th>
            <th><small>Longitud</small></th>
            <th><small>Acciones</small></th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($datosusu))
          @foreach ($datosusu as $datosUs)
          <tr>
            <td><small>{{$datosUs->id_usuario}}</small></td>
            <td><small>{{$datosUs->nombre_usuario}}</small></td>
            <td><small>{{$datosUs->tipou}}</small></td>
            <td><small>{{$datosUs->nombre}} {{$datosUs->ap_paterno}} {{$datosUs->ap_materno}}</small></td>
            
            <td><small>{{$datosUs->direccion}} {{$datosUs->numero_exterior}} {{$datosUs->numero_interior}} {{$datosUs->colonia}} {{$datosUs->codigo_postal}} {{$datosUs->localidad}} {{$datosUs->municipio}} {{$datosUs->estado}}</small></td>
            
            <td><small>{{$datosUs->latitud}}</small></td>
            <td><small>{{$datosUs->longitud}}</small></td>
            <td class="d-flex">
              
                <a class="btn btn-warning btn-sm" href="{{ url('admin/datosusuario/'.$datosUs->id_usuario.'/edit') }}" title="Editar datos del usuario"><i class="fa fa-user-edit"></i></a>
                  | 
                  @php
                  $prestamo = DB::table('tbl_prestamos')
                  ->select('tbl_prestamos.*')
                  ->where('tbl_prestamos.id_usuario','=',$datosUs->id_usuario)
                  ->get();
                  $socio = DB::table('tbl_socio_economico')
                  ->select('tbl_socio_economico.*')
                  ->where('tbl_socio_economico.id_usuario','=',$datosUs->id_usuario)
                  ->get();
                @endphp	 
                @if (count($prestamo)==0)
                  @if(count($socio)==0)
                    <form action="{{ url('admin/datosusuario/'.$datosUs->id_usuario) }}" method="post">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')"><i class="fa fa-user-times" title="Eliminar usuario"></i></button>
                    </form>
                  @else
                    <button class="btn btn-secondary btn-sm" type="button" onclick="return alert('¡El usuario tiene socioeconómico, no puede eliminarlo')" title="Eliminar usuario"><i class="fa fa-user-times" ></i></button>
                  @endif
                @else
                  <button class="btn btn-secondary btn-sm" type="button" onclick="return alert('¡El usuario tiene préstamos, no puede eliminarlo')" title="Eliminar usuario"><i class="fa fa-user-times" ></i></button>
                @endif
                <a class="btn btn-primary btn-sm" href="{{ url('admin/users/'.$datosUs->id_usuario.'/edit ') }}" title="Cambiar contraseña del usuario"><i class="fas fa-unlock-alt"></i></a>
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
  function buscar_tipo()
  {
      document.getElementById("form_id_tipo").submit();
  }
  function modal_nodato(){
  $("#modal_nodatos").modal();
  }

</script>
<script>
  window.onload = function agregar_boton_atras(){
    document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
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