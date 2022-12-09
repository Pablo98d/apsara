@extends('layouts.master')
@section('title', 'Socioeconómicos')
{{-- @section('parentPageTitle', 'Socioeconómicos') --}}
@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
  <link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>
@stop
@section('content')
<div class="row clearfix" style="margin: 0 auto"> 
  <div class="col-md-12">
    @if ( session('Guardar') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('Guardar') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
    @endif
    <hr style="padding: 0; margin:0; margin-bottom:4px;">
  </div>
  
  <div class="col-md-5 mt-1">
    {{-- <label style="font-size: 12px;color: rgb(255, 255, 255);">Buscar socioeconómicos por los datos del cliente</label><br> --}}
    <input class="form-control" style="background: transparent;color: #fff" id="myInput" type="text" placeholder="Ingresa los datos...">
  </div>
  <div class="col-md-5 mt-1">
    <form action="{{url('prestamo/socio/admin/socioeconomico')}}" method="get">
      <div class="input-group">
        <input type="text" class="form-control" name="busqueda_cliente_nombre" placeholder="Busqueda por nombre o apellidos" style="background: transparent;color: #fff">
        <div class="input-group-append">
          <button type="submit"  class="btn btn-outline-secondary" style="background: #007fb2; border: transparent;" type="button"><i class="fas fa-search"></i></button>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-2">
    
    {{-- <a href="{{route('registro_cliente')}}" class="btn btn-primary btn-block" style="background: #007fb2;" >
      + Nuevo préstamo
    </a> --}}
    <a href="{{route('nuevo_prospecto')}}" class="btn btn-primary btn-block" style="background: #007fb2;" >
      + Nuevo prospecto
    </a>
  </div>
  
  <div class="col-md-12">
    <div class="estilo-tabla" style="height: calc(65vh);  overflow-y: scroll">
      <table class="">
          <thead>
            <tr>
              {{-- <th><small>No.Socio.</small></th>
              <th><small>Zona</small></th>
              <th><small>Grupo</small></th> --}}
              <th><small>Nombre cliente</small></th>
              <th style="width: 130px"><small>Fecha registro</small></th>
              <th style="width: 180px"><small>
                <center>
                  Acciones
                </center>
              </small></th>
              {{--<th>Completar</th>--}}
            </tr>
          </thead>
      <tbody id="myList">
        @if (!empty($socioeconomico))
          @foreach ($socioeconomico as $socioe)
          <tr>
            {{-- <td><small>{{$socioe->id_socio_economico}}</small></td> --}}
            {{-- <td><small>{{$socioe->Zona}}</small></td>
            <td><small>{{$socioe->grupo}}</small></td> --}}
            <td ><small>{{$socioe->nombre.' '.$socioe->ap_paterno.' '.$socioe->ap_materno}}</small>
              @php
              // $diferencia_en_dias = $fecha_actual->diffInDays($socioe->fecha_actualizacion);
                  $interval=$fecha_actual->diff($socioe->fecha_actualizacion);
                  $intervalMeses=$interval->format("%m");
              @endphp
              @if ($intervalMeses>=6)
                  <br>
                  <span class="badge badge-warning" style="font-size: 10px">Actualización requerida. Última actualizaición hace {{$intervalMeses}} meses</span></td>
                  
              @else
                  
              @endif
            <td><small>{{$socioe->fecha_registro}}</small></td>
            {{-- <td>{{$socioe->fecha_registro}}</td> --}}
            <td class="d-flex">
                {{-- <a class="btn btn-warning btn-sm" href="{{ url('prestamo/socio/admin/socioeconomico/'.$socioe->id_socio_economico.'/edit/') }}" title="Editar datos del socioeconómico"><i class="fas fa-pencil-alt"></i></a> --}}
                
                
                
                  @if ($socioe->estatus==0)
                    <form action="{{url('create-socioeconomico')}}" method="GET">
                      <input name="id_socioeconomico" type="hidden" value="{{$socioe->id_socio_economico}}">
                      <button type="submit"  class="btn btn-info btn-sm" style="background: #007fb2" title="Está pendiente por completar datos del socioeconómico">Completar S.E</button>
                    </form>
                  @elseif($socioe->estatus==100)
                    <form action="{{url('create-socioeconomico')}}" method="GET">
                      <input name="id_socioeconomico" type="hidden" value="{{$socioe->id_socio_economico}}">
                      <button type="submit" style="width: 40px;height:30px;margin-right: 5px;" class="btn btn-success btn-sm " title="Ya ha completado el socioeconómico, solo puede revisar"><i class="fas fa-check"></i></button>
                    </form>
                  @else
                    <form action="{{url('create-socioeconomico')}}" method="GET">
                      <input name="id_socioeconomico" type="hidden" value="{{$socioe->id_socio_economico}}">
                      <button type="submit" style="width: 40px;height:30px;margin-right: 5px;" class="btn btn-primary btn-sm" title="En proceso, continuar para completar el socioeconómico">...</button>
                    </form>
                  @endif
              {{-- <a href="{{url('informacion-socioeconomico/'.$socioe->id_socio_economico)}}" class="btn btn-secondary btn-sm" style="width: 40px;height:30px; font-size: 15px;  color: #fff;margin-right: 5px;" title="Imprimir la información del socioeconómico" target="_blank"><i class="far fa-file-pdf"></i></a>
                @php
                    $familiares=DB::table('tbl_familiares')
                    ->select('tbl_familiares.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();

                    $aval=DB::table('tbl_se_aval')
                    ->select('tbl_se_aval.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();

                    $vivienda=DB::table('tbl_vivienda')
                    ->select('tbl_vivienda.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();

                    $pareja=DB::table('tbl_pareja')
                    ->select('tbl_pareja.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();

                    $domicilio=DB::table('tbl_domicilio')
                    ->select('tbl_domicilio.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();

                    $domicilio=DB::table('tbl_domicilio')
                    ->select('tbl_domicilio.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                    $finanzas=DB::table('tbl_se_finanzas')
                    ->select('tbl_se_finanzas.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                    $fecha_monto=DB::table('tbl_fecha_monto')
                    ->select('tbl_fecha_monto.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                    $gastos_mensuales=DB::table('tbl_gastos_mensuales')
                    ->select('tbl_gastos_mensuales.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                    $gastos_semanales=DB::table('tbl_gastos_semanales')
                    ->select('tbl_gastos_semanales.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                    $referencia_laboral=DB::table('tbl_se_referencia_laboral')
                    ->select('tbl_se_referencia_laboral.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                    $referencia_personal=DB::table('tbl_se_referencia_personal')
                    ->select('tbl_se_referencia_personal.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                    $articulos_hogar=DB::table('tbl_se_articulos_hogar')
                    ->select('tbl_se_articulos_hogar.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                    $datos_generales=DB::table('tbl_se_datos_generales')
                    ->select('tbl_se_datos_generales.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                    $documentos_prospecto=DB::table('tbl_se_documentos')
                    ->select('tbl_se_documentos.*')
                    ->where('id_socio_economico','=',$socioe->id_socio_economico)
                    ->get();
                @endphp
              <form action="{{ url('prestamo/socio/admin/socioeconomico/' .$socioe->id_socio_economico) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                @if (count($familiares)==0)
                    @if (count($aval)==0)
                        @if (count($vivienda)==0)
                            @if (count($pareja)==0)
                                @if (count($domicilio)==0)
                                  @if (count($finanzas)==0)
                                      @if (count($fecha_monto)==0)
                                          @if (count($gastos_mensuales)==0)
                                              @if (count($gastos_semanales)==0)
                                                  @if (count($referencia_laboral)==0)
                                                      @if (count($referencia_personal)==0)
                                                          @if (count($articulos_hogar)==0)
                                                              @if (count($datos_generales)==0)
                                                                  @if (count($documentos_prospecto)==0)
                                                                      <button class="btn btn-danger btn-sm" style="width:40px; height: 30px;" type="submit" onclick="return confirm('¿Desea borrarlo?')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                                                  @else
                                                                      <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene documentos prospecto , es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                                                      
                                                                  @endif
                                                              @else
                                                                  <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos generales , es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                                                  
                                                              @endif
                                                          @else
                                                              <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos artículos hogar , es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                                              
                                                          @endif
                                                      @else
                                                          <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos referencia personal , es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                                          
                                                      @endif
                                                  @else
                                                      <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos referencia laboral , es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>

                                                  @endif
                                              @else
                                                  <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos gastos semanales, es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                                  
                                              @endif
                                          @else
                                              <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos gastos mensuales, es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                              
                                          @endif
                                        @else
                                        <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos crédito, es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                          
                                      @endif
                                  @else
                                      <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos finanzas, es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                      
                                  @endif
                                @else
                                    <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos domicilio, es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                    
                                @endif
                            @else
                                <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos pareja, es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                                
                            @endif
                        @else
                            <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos vivienda, es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                            
                        @endif
                        
                    @else
                        <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene aval, es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                        
                    @endif
                    
                @else
                    <button class="btn btn-secondary btn-sm" style="width:40px; height: 30px;" type="button" onclick="alert('El socioeconómico tiene datos familiares, es imposible de eliminar')" title="Eliminar socioeconómico"><i class="fa fa-trash-alt"></i></button>
                    
                @endif
              </form> --}}
            </td>
            {{---<td>
              <a class="btn btn-primary" href="{{ url('admin/promotora/'.$socioe->id_socio_economico) }}"><i class="fa fa-gavel" title="Completar datos de socio económico">Pendiente</i></a>
            </td>---}}
          </tr>
          @endforeach
          @else
            <p>No hay registros</p>
          @endif
        </tbody>
        
      </table>
      <br>
      {{-- <div class="col-md-12">
        <center>
          <div style="float: right">{{ $socioeconomico->links() }}</div>
        </center>
      </div> --}}
      <br><br>
    </div>
  </div>
  <br>
</div> 
<!-- Large modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button> --}}

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      lkhgf
    </div>
  </div>
</div>
@stop
@section('page-script')
<script>
  window.onload = function agregar_boton_atras(){
    document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
    document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
}
</script>
<script>
  $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myList tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
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