@extends('layouts.master')
@section('title', 'REGISTRO DE MOVIMIENTOS DE LAS OPERACIONES')
{{-- @section('parentPageTitle', '') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    {{-- <div class="col-lg-12"> --}}
        <div class="col-md-12">
            <style>
                th{
                    font-size: 12px;
                }
                td{
                    font-size: 12px; 
                }
            </style>
            <hr>
            <form id="buscarForm" action="{{url('logs-feriecita')}}" method="get">
            <div class="row mb-1">
                <div class="col-md-3">
                    <label for="" style="font-size: 12px;color: rgb(60, 57, 238);">Fecha inicio</label><br>
                    <input type="date" name="fecha_inicio" value="" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="" style="font-size: 12px;color: rgb(60, 57, 238);">Fecha final</label>
                    <input type="date" value="" name="fecha_final" id="fecha_final" class="form-control">
                </div>
                <div class="col-md-6">
                    <label style="font-size: 12px;color: rgb(60, 57, 238);">Buscar movimientos por datos</label><br>
                    <input class="form-control" id="myInput" type="text" placeholder="Búsqueda rápida por nombre, apellido,descripcion,tipo movimiento">
                  </div>
            </div>
            </form>
            <div class="col-md-12" style="max-height: calc(65vh);  overflow-y: scroll;margin-bottom: 20px">
                <table >
                    <thead>
                        <th>No.Log</th>
                        <th>Consulta</th>
                        <th>Plataforma</th>
                        <th>Usuario</th>
                        <th>Tipo usuario</th>
                        <th>Nombre</th>
                        <th>Tipo movimiento</th>
                        <th>Id movimiento</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                    </thead>
                    <tbody id="myList">
                        @if (count($logs)==0)
                            <center>
                                Sin movimientos
                            </center>
                        @else
                            @foreach ($logs as $log)
                                 <tr>
                                     <td>#{{$log->id_log}}</td>
                                     <td>{{$log->consulta}}</td>
                                     <td>{{$log->plataforma}}</td>
                                     <td>#{{$log->id_usuario}}</td>
                                     <td>{{$log->tipo_usuario}}</td>
                                     <td>{{$log->nombre}}</td>
                                     <td>{{$log->tipo_movimiento}}</td>
                                     <td>#{{$log->id_movimiento}}</td>
                                     <td>{{$log->descripcion}}</td>
                                     
                                     <td>
                                         @php
                                             $fechaLog = $log->fecha_registro;
                                             setlocale(LC_TIME, "spanish");
                                             $fecha_a = $fechaLog;
                                             $fecha_a = str_replace("/", "-", $fecha_a);
                                             $Nueva_Fecha_a = date("d-m-Y H:i:s", strtotime($fecha_a));
                                         @endphp
                                         {{$Nueva_Fecha_a}}
                                     </td>
                                 </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    {{-- </div> --}}
    

</div>
@stop
@section('page-script')
<script>
    
    window.onload = function agregar_boton_atras(){
      document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
    }
    window.onload = function agregar_boton_atras(){
      document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
    }
</script>
<script>
    $('#fecha_final').change( function(){
        document.getElementById('buscarForm').submit();
    })
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

<script src="{{asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/sparkline.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/c3.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/index.js')}}"></script>

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop
