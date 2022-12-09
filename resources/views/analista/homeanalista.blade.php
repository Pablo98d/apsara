@extends('layoutsAnalista.master')
@section('title', 'La Feriecita')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')

<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-8" style="background: #3728A2; color: #fff; padding: 3px; margin: 15px;">
       Grupos de los socioeconómicos completados y pendientes de revisar
        
        <hr style="padding: 0; margin: 0">
    </div>
    <div class="col-md-12 mb-4">
        @foreach ($grupo_socio as $grupo)
            <div style="padding: 10px; float: left;">
            <a href="{{url('analisis-socio-economico/'.$grupo->id_grupo)}}" class="btn btn-primary" >
                    {{$grupo->grupo}}
                </a>
            </div>
        @endforeach
    </div>
    <div class="col-md-12">
        <div class="estilo-tabla">
            <table class="js-basic-example">
                <thead>
                    <tr>
                        <th>No.R</th>
                        <th>Región</th>
                        <th>No.Z</th>
                        <th>Zona</th>
                        <th>No.Grupo</th>
                        <th>Grupo</th>
                        <th>
                            <center>
                                socioeconómicos
                            </center>
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filtro_grupos as $filtro_grupo)
                    <tr>
                        <td>{{$filtro_grupo->IdPlaza}}</td>
                        <td>{{$filtro_grupo->Plaza}}</td>
                        <td>{{$filtro_grupo->IdZona}}</td>
                        <td>{{$filtro_grupo->Zona}}</td>
                        <td>{{$filtro_grupo->id_grupo}}</td>
                        <td>{{$filtro_grupo->grupo}}</td>
                        <td>
                            @php
                                $socio_pendientes=DB::table('v_socioeco_completado')
                                ->join('tbl_datos_usuario as cliente','v_socioeco_completado.id_usuario','=','cliente.id_usuario')
                                ->join('tbl_datos_usuario as promotora','v_socioeco_completado.id_promotora','=','promotora.id_usuario')
                                ->select('v_socioeco_completado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
                                ->where('v_socioeco_completado.id_grupo','=',$filtro_grupo->id_grupo)
                                ->get();

                                $socio_aprobados=DB::table('v_socioeco_aprobado')
                                ->join('tbl_datos_usuario as cliente','v_socioeco_aprobado.id_usuario','=','cliente.id_usuario')
                                ->join('tbl_datos_usuario as promotora','v_socioeco_aprobado.id_promotora','=','promotora.id_usuario')
                                ->select('v_socioeco_aprobado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
                                ->where('v_socioeco_aprobado.id_grupo','=',$filtro_grupo->id_grupo)
                                ->get();

                                $socio_negados=DB::table('v_socioeco_negado')
                                ->join('tbl_datos_usuario as cliente','v_socioeco_negado.id_usuario','=','cliente.id_usuario')
                                ->join('tbl_datos_usuario as promotora','v_socioeco_negado.id_promotora','=','promotora.id_usuario')
                                ->select('v_socioeco_negado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
                                ->where('v_socioeco_negado.id_grupo','=',$filtro_grupo->id_grupo)
                                ->get();

                            @endphp     



                            <a href="{{url('socio-pendientes-analista/'.$filtro_grupo->id_grupo)}}" class="badge badge-pill badge-warning">
                                Pendientes 
                                @if (count($socio_pendientes)==0)
                                    
                                @else
                                    <span style="width: 10px; height: 10; background: red; padding: 5px; border-radius: 5px;">
                                        {{count($socio_pendientes)}}
                                    </span>
                                @endif
                            </a>
                            <a href="{{url('socio-aprobados-analista/'.$filtro_grupo->id_grupo)}}" class="badge badge-pill badge-success">
                                Aprobados
                                @if (count($socio_aprobados)==0)
                                    
                                @else
                                    <span style="width: 10px; height: 10; background: red; padding: 5px; border-radius: 5px;">
                                        {{count($socio_aprobados)}}
                                    </span>
                                @endif
                            </a>
                            <a href="{{url('socio-negados-analista/'.$filtro_grupo->id_grupo)}}" class="badge badge-pill badge-danger">
                                Negados
                                @if (count($socio_negados)==0)
                                    
                                @else
                                    <span style="width: 10px; height: 10; background: blue; padding: 5px; border-radius: 5px;">
                                        {{count($socio_negados)}}
                                    </span>
                                @endif
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
    
            </table>
        </div>
    </div>
</div>
<br><br>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop