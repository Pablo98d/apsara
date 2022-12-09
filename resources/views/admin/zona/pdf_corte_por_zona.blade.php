<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de corte</title>

    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
       
    <style>
        .contenido-general{
            font-family: Arial, Helvetica, sans-serif !important;
            width: 90%;
            margin-top: 20px; 
            margin: 0 auto;
        }
        .contenido-text{
            margin: 0 auto;
            width: 95%;
        }
        .hr-1{
            border: solid 2px navy;
        }
        .hr-2{
            margin-top:15px !important;
            margin-bottom: 20px !important;
        }
        .hr-3{
            margin: 0px;
            border: solid 1px;
        }
        .label{
            margin: 0;
            color: deeppink !important;
            font-weight: bold;
            font-size: 13px;
        }
        .label-2{
            font-weight: bold;
            font-size: 14px !important;
            color: navy !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 16px;
            text-align: left;
        }
        .label-2-2{
            font-weight: bold;
            font-size: 14px !important;
            color: navy !important;
            margin: 0 !important;
            padding: 0 !important;
            text-align: left;
            
        }
        .fila{
            
            width: 100%;
        }
        .text-1{
            width: 150px;

        }
        .text-1-1{
            width: 50px;
        }
        .separador-text{
            width: 140px;
            color: white;
        }
        .text-grande{
            font-size: 1.2em;
            font-weight: bold;
            color: #000;
        }
        .columna-1{
            margin: 0;
            padding: 0;
        }
        .separador-10{
            width: 10px;
        }
        .separador-20{
            width: 20px;
            color: white;
        }
        .separador-30{
            width: 30px;
        }
        .separador-40{
            width: 40;
            color: white;
        }
        .separador-50{
            width: 50;
        }
        .separador-100{
            width: 100px;
            color: white;
        }
        .label-w-10{
            width: 10px;
        }
        .label-w-20{
            width: 20px;
        }
        .label-w-40{
            width: 40px;
        }
        .label-w-50{
            width: 50px;
        }
        .label-w-75{
            width: 75px;
        }
        .label-w-100{
            width: 100px;
        }
        .label-w-150{
            width: 150px;
        }
        .label-w-200{
            width: 200px;
        }
        .label-w-300{
            width: 300px;
        }
        .estilo-tabladia{
            width: 100%;
        }
        .estilo-tabladia th,td{
            font-size: 11px;
            padding: 0;
            color: black;
        }
        .ancho-1{
            width: 200px;
        }
        .ancho-2{
            width: 200px;
        }
        .ancho-3{
            width: 200px;
        }
        .estilo-tabladia-2{
            width: 100%;
        }
        .estilo-tabladia-2 th{
            padding: 5px;
            font-size: 13px;
            color: navy;
        }
        .estilo-tabladia-2 td{
            font-size: 10px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="contenido-general">
        {{-- <hr class="hr-1"> --}}
        <label class="text-grande" style="margin-top: -20px; margin-left:280px">
            REPORTE DE CORTE DE COBRANZA
            
        </label>
        <div class="contenido-text">
            <img  src="{{asset('img/logo/Logo Prestamos.jpg')}}" width="170px" height="110px" style="position: absolute; right: 40px; top: -5px;">
            
            <div style="margin: 0px; padding: 0px;">
                <label style="font-size: 14px; margin: 0px; margin-left: -22px;  padding: 0px; text-transform: uppercase;"><span style="font-weight: bold">RUTA:</span> {{$zona->Zona}}</label>            
            </div>
            <div style="margin: 0px; padding: 0px;">
                @php
                    $gerentes_ruta=DB::table('tbl_zonas_gerentes')
                    ->join('tbl_datos_usuario','tbl_zonas_gerentes.id_usuario','tbl_datos_usuario.id_usuario')
                    ->select('tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
                    ->where('tbl_zonas_gerentes.id_zona','=',$zona->IdZona)
                    ->get();
                @endphp
                @if (count($gerentes_ruta)==0)
                    <label for="" style="margin-left: -22px;">Sin gerentes de ruta</label>
                @else
                    @php
                        $contar_gerente=0;
                    @endphp
                    @foreach ($gerentes_ruta as $gerente_ruta)
                        @php
                            $contar_gerente+=1;
                        @endphp
                        @if ($contar_gerente==1)
                            <label style="font-size: 14px; margin: 0px; margin-left: -22px; padding: 0px; text-transform: uppercase;"><span style="font-weight: bold">GERENTE DE RUTA:</span> {{$gerente_ruta->nombre}} {{$gerente_ruta->ap_paterno}} {{$gerente_ruta->ap_materno}}</label><br>
                            
                        @else
                            
                        @endif
                        
                    @endforeach
                @endif
            </div>
            <br>
            @php
                    $fecha_actual = date('d-m-Y');
                    $fechageneracion = $fecha_actual;
                    setlocale(LC_TIME, "spanish");
                    $fecha_g = $fechageneracion;
                    $fecha_g = str_replace("/", "-", $fecha_g);
                    $Nueva_Fecha_g = date("d-m-Y", strtotime($fecha_g));

                    $fecha = new DateTime($fecha_actual);
                    $semana = $fecha->format('W');
                   
            @endphp
            <label for="" style="font-size: 14px; font-weight: bold; margin-left: 390px;">SEMANA {{$semana}}</label>
            
            
        </div>
        {{-- <br> --}}
        <label style="color: #000;"><label style="color: #000; margin-top: 0px; margin-left:765px; font-size: 11px;">Reporte generado: {{$Nueva_Fecha_g}}</label>
        <div class="row mt-4">
            <div class="col-md-12">
                <table>
                <thead>
                    <tr>

                        <th style="color: black; font-size: 10px; text-align: center"><small>No. G</small></th>
                        <th style="color: black; font-size: 10px; width: 100px"><small>Grupo</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>Clientes de la semana actual</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>Corte ideal de la semana actual</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>Corte en curso</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>Cobranza real</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>%Cobrado</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>%Semana pasada</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>%Semana antepasada</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>Dinero colocado</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>% de fallas</small></th>
                        <th style="color: black; font-size: 10px; text-align: center"><small>Fallas</small></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_global_clientes=0;
                        $total_global_cobranza_proceso=0;

                        $total_global_cobranza_ideal=0;
                        $total_global_cobranza_real=0;
                        
                        
                        $cont_c_real=0;
                        $total_global_cobranza_p_cobrado=0;
                        
                        $cont_s_pasada=0;
                        $total_global_cobranza_p_pasada=0;
                        
                        $cont_s_antepasada=0;
                        $total_global_cobranza_p_antepasada=0;
                        
                        $total_global_dinerocolocado=0;
                        
                        $cont_p_mermas=0;
                        $total_global_p_merma=0;
                        $total_global_mermas=0;
                    @endphp
                    @foreach ($grupos as $grupo)
                                @php
                                    $cortes_semanas=DB::table('tbl_cortes_semanas')
                                    ->select('tbl_cortes_semanas.*')
                                    ->where('tbl_cortes_semanas.id_grupo','=',$grupo->id_grupo)
                                    ->orderBy('tbl_cortes_semanas.fecha_final','DESC')
                                    ->limit(3)
                                    ->get();
                                    
                                    $contador=0;
                                   
                                    $clientes_actual=0;
                                    $cobranza_ideal_actual=0;
                                    $cobranza_ideal_pasado=0;
                                    $cobranza_ideal_ante_pasado=0;
                                    
                                    $total_cobranza_actual=0;
                                    $total_cobranza_proceso=0;
                                    // $t_aportacion=0;
                                    // $t_cobranza_perfecta=0;
                                    
                                    
                                    $total_cobranza_pasada=0;
                                    // $t_aportacion_pasada=0;
                                    // $t_cobranza_perfecta_pasada=0;
                                    
                                    
                                    $total_cobranza_ante_pasada=0;
                                    // $t_aportacion_ante_pasada=0;
                                    // $t_cobranza_perfecta_ante_pasada=0;
                                    
                                @endphp
                                @if(count($cortes_semanas)==0)
                                    
                                @else
                                    @foreach($cortes_semanas as $cortes_semana)
                                        @php
                                            $contador+=1;
                                        @endphp
                                        @if($contador==1)

                                             <!--Semana en proceso -->
                                             @php
                                                $semanas_proceso=DB::table('v_cortes_semanas_detalles')
                                                ->join('tbl_grupos','v_cortes_semanas_detalles.id_grupo','tbl_grupos.id_grupo')
                                                ->join('tbl_grupos_promotoras','v_cortes_semanas_detalles.id_promotora','tbl_grupos_promotoras.id_usuario')
                                                ->select(DB::raw('SUM(abono_recibido) as total_recibido,v_cortes_semanas_detalles.id_promotora,v_cortes_semanas_detalles.nombre_promotora,tbl_grupos.grupo'))
                                                ->where('v_cortes_semanas_detalles.id_grupo','=',$grupo->id_grupo)
                                                ->where('id_tipoabono','=',2)
                                                ->where('id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                ->groupBy('v_cortes_semanas_detalles.id_promotora','v_cortes_semanas_detalles.nombre_promotora','tbl_grupos.grupo')
                                                ->get();
                                                
                                                // $aportacion_empresa=DB::table('v_cortes_semanas_detalles')
                                                // ->join('tbl_grupos','v_cortes_semanas_detalles.id_grupo','tbl_grupos.id_grupo')
                                                // ->join('tbl_aportacion_empresa','v_cortes_semanas_detalles.id_abono','tbl_aportacion_empresa.id_abono')
                                                // ->select(DB::raw('SUM(cantidad) as total_aportacion,v_cortes_semanas_detalles.id_promotora,v_cortes_semanas_detalles.nombre_promotora,tbl_grupos.grupo'))
                                                // ->where('v_cortes_semanas_detalles.id_grupo','=',$grupo->id_grupo)
                                                // // ->where('id_tipoabono','=',2)
                                                // ->where('id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                // ->groupBy('v_cortes_semanas_detalles.id_promotora','v_cortes_semanas_detalles.nombre_promotora','tbl_grupos.grupo')
                                                // ->get();

                                                // $cobranza_perfecta=DB::table('tbl_cobranza_perfecta')
                                                // ->select(DB::raw('SUM(cantidad) as total_cobranza_perfecta'))
                                                // ->where('tbl_cobranza_perfecta.id_grupo','=',$grupo->id_grupo)
                                                // ->where('tbl_cobranza_perfecta.id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                // ->get();
                                                
                                                
                                                // $nuevos_prestamos=DB::table('tbl_prestamos')
                                                // ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                                                // ->select('tbl_prestamos.*','tbl_productos.*')
                                                // ->where('tbl_prestamos.id_grupo','=',$grupo->id_grupo)
                                                // ->whereBetween('tbl_prestamos.fecha_entrega_recurso', [$cortes_semana->fecha_inicio.' 00:00:00', $cortes_semana->fecha_final.' 00:00:00'])
                                                // ->whereBetween('tbl_prestamos.id_status_prestamo', [2, 9])
                                                // ->distinct()
                                                // ->get();
                            
                                                
                                                // $actual_f_inicio=$cortes_semana->fecha_inicio;
                                                // $actual_f_final=$cortes_semana->fecha_final;
                                                
                                                $clientes_proceso=$cortes_semana->total_clientes;
                                                // $total_global_clientes_proceso+=$cortes_semana->total_clientes;
                                                // $total_global_clientes+=$cortes_semana->total_clientes;
                                                
                                                // $id_corte_semana=$cortes_semana->id_corte_semana;
                                                // $cobranza_ideal_actual=$cortes_semana->corte_ideal;
                                                
                                                
                                            @endphp


                                        @elseif($contador==2)
                                        <!--Semana actual -->
                                            @php
                                                $semanas_actual=DB::table('v_cortes_semanas_detalles')
                                                ->join('tbl_grupos','v_cortes_semanas_detalles.id_grupo','tbl_grupos.id_grupo')
                                                ->join('tbl_grupos_promotoras','v_cortes_semanas_detalles.id_promotora','tbl_grupos_promotoras.id_usuario')
                                                ->select(DB::raw('SUM(abono_recibido) as total_recibido,v_cortes_semanas_detalles.id_promotora,v_cortes_semanas_detalles.nombre_promotora,tbl_grupos.grupo'))
                                                ->where('v_cortes_semanas_detalles.id_grupo','=',$grupo->id_grupo)
                                                ->where('id_tipoabono','=',2)
                                                ->where('id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                ->groupBy('v_cortes_semanas_detalles.id_promotora','v_cortes_semanas_detalles.nombre_promotora','tbl_grupos.grupo')
                                                ->get();
                                                
                                                // $aportacion_empresa=DB::table('v_cortes_semanas_detalles')
                                                // ->join('tbl_grupos','v_cortes_semanas_detalles.id_grupo','tbl_grupos.id_grupo')
                                                // ->join('tbl_aportacion_empresa','v_cortes_semanas_detalles.id_abono','tbl_aportacion_empresa.id_abono')
                                                // ->select(DB::raw('SUM(cantidad) as total_aportacion,v_cortes_semanas_detalles.id_promotora,v_cortes_semanas_detalles.nombre_promotora,tbl_grupos.grupo'))
                                                // ->where('v_cortes_semanas_detalles.id_grupo','=',$grupo->id_grupo)
                                                // // ->where('id_tipoabono','=',2)
                                                // ->where('id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                // ->groupBy('v_cortes_semanas_detalles.id_promotora','v_cortes_semanas_detalles.nombre_promotora','tbl_grupos.grupo')
                                                // ->get();
                                                
                                                // $cobranza_perfecta=DB::table('tbl_cobranza_perfecta')
                                                // ->select(DB::raw('SUM(cantidad) as total_cobranza_perfecta'))
                                                // ->where('tbl_cobranza_perfecta.id_grupo','=',$grupo->id_grupo)
                                                // ->where('tbl_cobranza_perfecta.id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                // ->get();
                                                
                                                
                                                $nuevos_prestamos=DB::table('tbl_prestamos')
                                                ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                                                ->select('tbl_prestamos.*','tbl_productos.*')
                                                ->where('tbl_prestamos.id_grupo','=',$grupo->id_grupo)
                                                ->whereBetween('tbl_prestamos.fecha_entrega_recurso', [$cortes_semana->fecha_inicio, $cortes_semana->fecha_final])
                                                ->whereBetween('tbl_prestamos.id_status_prestamo', [2, 9])
                                                ->distinct()
                                                ->get();
                            
                                                
                                                $actual_f_inicio=$cortes_semana->fecha_inicio;
                                                $actual_f_final=$cortes_semana->fecha_final;
                                                
                                                $clientes_actual=$cortes_semana->total_clientes;
                                                $total_global_clientes+=$cortes_semana->total_clientes;
                                                
                                                
                                                $cobranza_ideal_actual=$cortes_semana->corte_ideal;
                                                
                                                
                                            @endphp
                                        @elseif($contador==3)
                                        <!--Semana pasada-->
                                            @php
                                                $semanas_pasada=DB::table('v_cortes_semanas_detalles')
                                                ->join('tbl_grupos','v_cortes_semanas_detalles.id_grupo','tbl_grupos.id_grupo')
                                                ->join('tbl_grupos_promotoras','v_cortes_semanas_detalles.id_promotora','tbl_grupos_promotoras.id_usuario')
                                                ->select(DB::raw('SUM(abono_recibido) as total_recibido,v_cortes_semanas_detalles.id_promotora,v_cortes_semanas_detalles.nombre_promotora,tbl_grupos.grupo'))
                                                ->where('v_cortes_semanas_detalles.id_grupo','=',$grupo->id_grupo)
                                                ->where('id_tipoabono','=',2)
                                                ->where('id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                ->groupBy('v_cortes_semanas_detalles.id_promotora','v_cortes_semanas_detalles.nombre_promotora','tbl_grupos.grupo')
                                                ->get();
                                                
                                                // $aportacion_empresa_pasada=DB::table('v_cortes_semanas_detalles')
                                                // ->join('tbl_grupos','v_cortes_semanas_detalles.id_grupo','tbl_grupos.id_grupo')
                                                // ->join('tbl_aportacion_empresa','v_cortes_semanas_detalles.id_abono','tbl_aportacion_empresa.id_abono')
                                                // ->select(DB::raw('SUM(cantidad) as total_aportacion,v_cortes_semanas_detalles.id_promotora,v_cortes_semanas_detalles.nombre_promotora,tbl_grupos.grupo'))
                                                // ->where('v_cortes_semanas_detalles.id_grupo','=',$grupo->id_grupo)
                                                // // ->where('id_tipoabono','=',2)
                                                // ->where('id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                // ->groupBy('v_cortes_semanas_detalles.id_promotora','v_cortes_semanas_detalles.nombre_promotora','tbl_grupos.grupo')
                                                // ->get();
                                                
                                                // $cobranza_perfecta_pasada=DB::table('tbl_cobranza_perfecta')
                                                // ->select(DB::raw('SUM(cantidad) as total_cobranza_perfecta'))
                                                // ->where('tbl_cobranza_perfecta.id_grupo','=',$grupo->id_grupo)
                                                // ->where('tbl_cobranza_perfecta.id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                // ->get();
                                                
                                                
                                                $pasada_f_inicio=$cortes_semana->fecha_inicio;
                                                $pasada_f_final=$cortes_semana->fecha_final;
                                                $cobranza_ideal_pasado=$cortes_semana->corte_ideal;
                                                
                                                
                                            @endphp
                                        @elseif($contador==4)
                                        <!--Semana antepasada-->
                                            @php
                                                $semanas_ante_pasada=DB::table('v_cortes_semanas_detalles')
                                                ->join('tbl_grupos','v_cortes_semanas_detalles.id_grupo','tbl_grupos.id_grupo')
                                                ->join('tbl_grupos_promotoras','v_cortes_semanas_detalles.id_promotora','tbl_grupos_promotoras.id_usuario')
                                                ->select(DB::raw('SUM(abono_recibido) as total_recibido,v_cortes_semanas_detalles.id_promotora,v_cortes_semanas_detalles.nombre_promotora,tbl_grupos.grupo'))
                                                ->where('v_cortes_semanas_detalles.id_grupo','=',$grupo->id_grupo)
                                                ->where('id_tipoabono','=',2)
                                                ->where('id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                ->groupBy('v_cortes_semanas_detalles.id_promotora','v_cortes_semanas_detalles.nombre_promotora','tbl_grupos.grupo')
                                                ->get();
                                                
                                                // $aportacion_empresa_ante_pasada=DB::table('v_cortes_semanas_detalles')
                                                // ->join('tbl_grupos','v_cortes_semanas_detalles.id_grupo','tbl_grupos.id_grupo')
                                                // ->join('tbl_aportacion_empresa','v_cortes_semanas_detalles.id_abono','tbl_aportacion_empresa.id_abono')
                                                // ->select(DB::raw('SUM(cantidad) as total_aportacion,v_cortes_semanas_detalles.id_promotora,v_cortes_semanas_detalles.nombre_promotora,tbl_grupos.grupo'))
                                                // ->where('v_cortes_semanas_detalles.id_grupo','=',$grupo->id_grupo)
                                                // // ->where('id_tipoabono','=',2)
                                                // ->where('id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                // ->groupBy('v_cortes_semanas_detalles.id_promotora','v_cortes_semanas_detalles.nombre_promotora','tbl_grupos.grupo')
                                                // ->get();
                                                
                                                // $cobranza_perfecta_ante_pasada=DB::table('tbl_cobranza_perfecta')
                                                // ->select(DB::raw('SUM(cantidad) as total_cobranza_perfecta'))
                                                // ->where('tbl_cobranza_perfecta.id_grupo','=',$grupo->id_grupo)
                                                // ->where('tbl_cobranza_perfecta.id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                // ->get();
                                                
                                                $ante_pasada_f_inicio=$cortes_semana->fecha_inicio;
                                                $ante_pasada_f_final=$cortes_semana->fecha_final;
                                                $cobranza_ideal_ante_pasado=$cortes_semana->corte_ideal;
                                            @endphp
                                        @endif
                                        
                                    @endforeach
                                @endif
                        <tr>
                                
                            <td>
                                <small><center>{{$grupo->id_grupo}}</center></small>
                            </td>
                            <td><small>{{$grupo->grupo}}</small></td>
                            
                            <td style="text-align: center;">
                                    <small>
                                        {{number_format($clientes_actual)}}
                                    </small>
                            </td>
                            
                            <td style="text-align: center;">
                                <!--semana actual cobranza ideal-->
                                    <small>
                                        @php
                                            $total_global_cobranza_ideal+=$cobranza_ideal_actual;
                                        @endphp
                                     $ {{number_format($cobranza_ideal_actual,2)}} <br>
                                    
                                </small>
                            </td>
                            <td style="text-align: center;">
                                {{-- Semana en proceso --}}
                                        @if(!empty($semanas_proceso))
                                            @if(count($semanas_proceso)==0)
                                                @php
                                                    $total_cobranza_proceso=0;
                                                @endphp
                                            
                                            @else
                                                @foreach($semanas_proceso as $semana_proceso)
                                                    @php
                                                        $total_cobranza_proceso+=$semana_proceso->total_recibido;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        @else
                                            @php
                                                $total_cobranza_proceso=0;
                                            @endphp
                                        @endif
                                    
                                    <small style="color: blue">
                                        @php
                                            $total_global_cobranza_proceso+=$total_cobranza_proceso;
                                        @endphp
                                    $ {{number_format($total_cobranza_proceso,1)}}
                                    </small>


                                    {{-- <small style="color: blue">
                                        $ 200.0
                                    </small> --}}
                            </td>
                            <td style="text-align: center;;">
                                <!--cobranza real-->
                                <small>
                                    @if(!empty($semanas_actual))
                                        @if(count($semanas_actual)==0)
                                        
                                            @php
                                                $total_cobranza_actual=0;
                                            @endphp
                                        
                                        @else
                                            
                                            @foreach($semanas_actual as $semana_actual)
                                                @php
                                                    $total_cobranza_actual+=$semana_actual->total_recibido;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $total_cobranza_actual=0;
                                        @endphp
                                    @endif
                                    <!--Calculamos el total aportación empresa-->
                                    @if(!empty($aportacion_empresa))
                                        @if(count($aportacion_empresa)==0)
                                            @php
                                                $t_aportacion=0;
                                            @endphp
                                        @else
                                            @foreach($aportacion_empresa as $aportacion_emp)
                                                @php
                                                    $t_aportacion+=$aportacion_emp->total_aportacion;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $t_aportacion=0;
                                        @endphp
                                    @endif
                                    
                                    <!--Calculamos el total de cobranza perfecta-->
                                    @if(!empty($cobranza_perfecta))
                                        @if(count($cobranza_perfecta)==0)
                                        @php
                                            $t_cobranza_perfecta=0;
                                        @endphp
                                        @else
                                            @foreach($cobranza_perfecta as $cobranza_perf)
                                                @php
                                                    $t_cobranza_perfecta+=$cobranza_perf->total_cobranza_perfecta;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $t_cobranza_perfecta=0;
                                        @endphp
                                    @endif
                                    
                                    
                                    <!--Calculamos el monto real-->
                                    @php
                                        $monto_real=$total_cobranza_actual-$t_aportacion-$t_cobranza_perfecta;
                                        $total_global_cobranza_real+=$monto_real;
                                    @endphp
                                    $ {{number_format($monto_real,2)}}
                                </small>

                            </td>
                            <td style="text-align: right;">
                                <small>
                                    <!--porcentaje cobranza real-->
                                    @php
                                        if($monto_real<=0){
                                            $real_porcentaje=0;
                                        } else {
                                            if($cobranza_ideal_actual<=0){
                                                $real_porcentaje=0;
                                            } else{
                                                $real_porcentaje=($monto_real*100)/$cobranza_ideal_actual;
                                            }
                                        }
                                        
                                        $total_global_cobranza_p_cobrado+=$real_porcentaje;
                                        
                                        if($real_porcentaje<=0){
                                            $cont_c_real+=0;
                                        } else {
                                            $cont_c_real+=1;
                                        }
                                    @endphp
                                    
                                    <small>
                                        @if(!empty($actual_f_inicio))
                                                
                                            
                                            @php
                                                
                                                $fechaActual = $actual_f_inicio;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_a = $fechaActual;
                                                $fecha_a = str_replace("/", "-", $fecha_a);
                                                $Nueva_Fecha_a = date("d-m-Y", strtotime($fecha_a));
                                                
                                                $fechaActualf = $actual_f_final;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_af = $fechaActualf;
                                                $fecha_af = str_replace("/", "-", $fecha_af);
                                                $Nueva_Fecha_af = date("d-m-Y", strtotime($fecha_af));
                                            @endphp
                                            {{$Nueva_Fecha_a}} <br>{{$Nueva_Fecha_af}}
                                        @else
                                        <span style="color: rgb(206, 0, 0);">Sin fecha de corte</span>
                                                 <br>
                                        @endif
                                    </small><br>
                                    @if ($real_porcentaje==0)
                                        
                                    @else
                                        <b>{{number_format($real_porcentaje,1)}}%</b>
                                    @endif
                                    {{-- <b>{{number_format($real_porcentaje,1)}}%</b> --}}
                                </small>
                            </td>
                            <td style="text-align: right;">
                                <small>
                                    <!--porcentaje semana pasada-->
                                    @if(!empty($semanas_pasada))
                                        @if(count($semanas_pasada)==0)
                                            @php
                                                $total_cobranza_pasada=0;
                                            @endphp
                                        
                                        @else
                                            @foreach($semanas_pasada as $semana_pasada)
                                                @php
                                                    $total_cobranza_pasada+=$semana_pasada->total_recibido;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $total_cobranza_pasada=0;
                                        @endphp
                                    @endif
                                    
                                    <!--Calculamos el total aportación empresa semana pasada-->
                                    @if(!empty($aportacion_empresa_pasada))
                                        @if(count($aportacion_empresa_pasada)==0)
                                            @php
                                                $t_aportacion_pasada=0;
                                            @endphp
                                        @else
                                            @foreach($aportacion_empresa_pasada as $aportacion_empresa_pa)
                                                @php
                                                    $t_aportacion_pasada+=$aportacion_empresa_pa->total_aportacion;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $t_aportacion_pasada=0;
                                        @endphp
                                    @endif
                                    
                                    <!--Calculamos el total de cobranza perfecta semana pasada-->
                                    @if(!empty($cobranza_perfecta_pasada))
                                        @if(count($cobranza_perfecta_pasada)==0)
                                        @php
                                            $t_cobranza_perfecta_pasada=0;
                                        @endphp
                                        @else
                                            @foreach($cobranza_perfecta_pasada as $cobranza_perfecta_pa)
                                                @php
                                                    $t_cobranza_perfecta_pasada+=$cobranza_perfecta_pa->total_cobranza_perfecta;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $t_cobranza_perfecta_pasada=0;
                                        @endphp
                                    @endif
                                    
                                    <!--Colculamos el total cobranza en semana pasada-->
                                    @php
                                        $monto_real_pasada=$total_cobranza_pasada-$t_aportacion_pasada-$t_cobranza_perfecta_pasada;
                                        if($monto_real_pasada==0){
                                            $pasada_porcentaje=0;
                                        }else{
                                            if($cobranza_ideal_pasado==0){
                                                $pasada_porcentaje=0;
                                            } else{
                                                $pasada_porcentaje=($monto_real_pasada*100)/$cobranza_ideal_pasado;
                                            
                                            }
                                        }
                                        
                                        if($pasada_porcentaje<=0){
                                            $cont_s_pasada+=0;
                                        } else {
                                            $cont_s_pasada+=1;
                                        }
                                        
                                        
                                        $total_global_cobranza_p_pasada+=$pasada_porcentaje;
                                    @endphp
                                    <small>
                                        @if(!empty($pasada_f_inicio))
                                            @php
                                                $fechaPasada = $pasada_f_inicio;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_ap = $fechaPasada;
                                                $fecha_ap = str_replace("/", "-", $fecha_ap);
                                                $Nueva_Fecha_ap = date("d-m-Y", strtotime($fecha_ap));
                                                
                                                $fechaPasadaf = $pasada_f_final;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_pf = $fechaPasadaf;
                                                $fecha_pf = str_replace("/", "-", $fecha_pf);
                                                $Nueva_Fecha_pf = date("d-m-Y", strtotime($fecha_pf));
                                                
                                                
                                            @endphp
                                            {{$Nueva_Fecha_ap}} <br>{{$Nueva_Fecha_pf}}<br>
                                        @else
                                        <span style="color: rgb(206, 0, 0);">Sin fecha de corte</span>
                                                 <br>
                                        @endif
                                    </small>
                                    <b><small>${{number_format($cobranza_ideal_pasado,1)}}</small>
                                        - <small>{{number_format($monto_real_pasada,1)}}</small><br>
                                        @if ($pasada_porcentaje==0)
                                            
                                        @else
                                            {{number_format($pasada_porcentaje,1)}}% </b>
                                        @endif
                                        {{-- {{number_format($pasada_porcentaje,1)}}% </b> --}}
                                </small>
                            </td>
                            <td style="text-align: right;">
                                <small>
                                    <!--porcentaje semana antepasada-->
                                    @if(!empty($semanas_ante_pasada))
                                        @if(count($semanas_ante_pasada)==0)
                                            @php
                                                $total_cobranza_ante_pasada=0;
                                            @endphp
                                        
                                        @else
                                            @foreach($semanas_ante_pasada as $semana_ante_pasada)
                                                @php
                                                    $total_cobranza_ante_pasada+=$semana_ante_pasada->total_recibido;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $total_cobranza_ante_pasada=0;
                                        @endphp
                                    @endif
                                    
                                    <!--Calculamos el total aportación empresa semana ante pasada-->
                                    @if(!empty($aportacion_empresa_ante_pasada))
                                        @if(count($aportacion_empresa_ante_pasada)==0)
                                            @php
                                                $t_aportacion_ante_pasada=0;
                                            @endphp
                                        @else
                                            @foreach($aportacion_empresa_ante_pasada as $aportacion_empresa_ante_pa)
                                                @php
                                                    $t_aportacion_ante_pasada+=$aportacion_empresa_ante_pa->total_aportacion;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $t_aportacion_ante_pasada=0;
                                        @endphp
                                    @endif
                                    
                                    <!--Calculamos el total de cobranza perfecta semana ante pasada-->
                                    @if(!empty($cobranza_perfecta_ante_pasada))
                                        @if(count($cobranza_perfecta_ante_pasada)==0)
                                        @php
                                            $t_cobranza_perfecta_ante_pasada=0;  
                                        @endphp
                                        @else
                                            @foreach($cobranza_perfecta_ante_pasada as $cobranza_perfecta_ante_pa)
                                                @php
                                                    $t_cobranza_perfecta_ante_pasada+=$cobranza_perfecta_ante_pa->total_cobranza_perfecta;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $t_cobranza_perfecta_ante_pasada=0;
                                        @endphp
                                    @endif
                                    
                                    @php
                                        $monto_real_ante_pasada=$total_cobranza_ante_pasada-$t_aportacion_ante_pasada-$t_cobranza_perfecta_ante_pasada;
                                        if($monto_real_ante_pasada==0){
                                            $antepasada_porcentaje=0;
                                        }else{
                                            if($cobranza_ideal_ante_pasado==0){
                                                $antepasada_porcentaje=0;
                                            } else{
                                                $antepasada_porcentaje=($monto_real_ante_pasada*100)/$cobranza_ideal_ante_pasado;
                                            
                                            }
                                        }
                                        
                                        if($antepasada_porcentaje<=0){
                                            $cont_s_antepasada+=0;    
                                        } else {
                                            $cont_s_antepasada+=1;
                                        }
                                        
                                        $total_global_cobranza_p_antepasada+=$antepasada_porcentaje;
                                        
                                        
                                    @endphp
                                        <small>
                                        @if(!empty($ante_pasada_f_inicio))
                                            @php
                                                $fechaAnte_p = $ante_pasada_f_inicio;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_aan = $fechaAnte_p;
                                                $fecha_aan = str_replace("/", "-", $fecha_aan);
                                                $Nueva_Fecha_aan = date("d-m-Y", strtotime($fecha_aan));
                                                
                                                $fechaAnte_pf = $ante_pasada_f_final;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_aan_f = $fechaAnte_pf;
                                                $fecha_aan_f = str_replace("/", "-", $fecha_aan_f);
                                                $Nueva_Fecha_aanf = date("d-m-Y", strtotime($fecha_aan_f));
                                            @endphp
                                            
                                            {{$Nueva_Fecha_aan}} <br>{{$Nueva_Fecha_aanf}}<br>
                                        @else
                                            <span style="color: rgb(206, 0, 0);">Sin fecha de corte</span>
                                                 <br>
                                        @endif
                                        </small>
                                    <b><small>${{number_format($cobranza_ideal_ante_pasado,1)}}</small>
                                        - <small>{{number_format($monto_real_ante_pasada,1)}}</small><br>
                                        @if ($antepasada_porcentaje==0)
                                            
                                        @else
                                            {{number_format($antepasada_porcentaje,1)}}% 
                                        @endif
                                        {{-- {{number_format($antepasada_porcentaje,1)}}% </b> --}}
                                </small>
                            </td>
                            <td style="text-align: right;">
                                <small>
                                    <!--total dinero colocado-->
                                    @if(!empty($nuevos_prestamos))
                                        @php
                                        $entregado=0;
                                            if(count($nuevos_prestamos)==0){
                                                $entregado=0;
                                            } else{
                                                foreach( $nuevos_prestamos as $nuevo_prestamo){
                                                    $entregado+=$nuevo_prestamo->cantidad;
                                                }
                                            }
                                            $total_global_dinerocolocado+=$entregado;
                                        @endphp
                                    @else
                                        @php
                                            $entregado=0;
                                            $total_global_dinerocolocado+=$entregado;
                                        @endphp
                                    @endif
                                    $ {{number_format($entregado,1)}}
                                </small>
                            </td>
                            <td style="text-align: right;">
                                <small>
                                    <!--calcular mermas-->
                                    @php
                                        $mermas=$cobranza_ideal_actual-$monto_real;
                                        
                                        if($cobranza_ideal_actual<=0){
                                            $merma_porcentaje=0;
                                        } else {
                                            $merma_porcentaje=($mermas*100)/$cobranza_ideal_actual;
                                        }
                                        
                                        if($merma_porcentaje<=0){
                                            $cont_p_mermas+=0;
                                        } else {
                                            $cont_p_mermas+=1;
                                        }
                                        
                                        $total_global_p_merma+=$merma_porcentaje;
                                        $total_global_mermas+=$mermas;
                                    @endphp
                                    
                                    {{number_format($merma_porcentaje,1)}}%
                                </small>
                            </td>
                            <td style="text-align: right;"> 
                                <small>
                                    $ {{number_format($mermas,1)}}
                                </small>
                            </td>
                        </tr>
                        @php
                            // variables de semana actual
                            $semanas_actual=[];
                            $aportacion_empresa=[];
                            $cobranza_perfecta=[];
                            $nuevos_prestamos=[];

                                $actual_f_inicio=null;
                                $actual_f_final=null;
                                $clientes_actual=0;                            
                                $cobranza_ideal_actual=0;



                            // variables de semana pasada

                            $semanas_pasada=[];
                            $aportacion_empresa_pasada=[];
                            $cobranza_perfecta_pasada=[];

                            $pasada_f_inicio=null;
                            $pasada_f_final=null;
                            $cobranza_ideal_pasado=0;


                            // variables de semana ante pasada

                            $semanas_ante_pasada=[];
                            $aportacion_empresa_ante_pasada=[];
                            $cobranza_perfecta_ante_pasada=[];

                            $ante_pasada_f_inicio=null;
                            $ante_pasada_f_final=null;
                            $cobranza_ideal_ante_pasado=0;

                        @endphp
                    @endforeach
                    {{-- <tr style="border-top:4px solid rgb(54, 0, 141);">
                        @php
                            
                            if($total_global_cobranza_real<=0){
                                $porcentaje_cobranzareal=0;
                            }else{
                                if($total_global_cobranza_ideal<=0){
                                    $porcentaje_cobranzareal=$total_global_cobranza_real;
                                } else {
                                    $porcentaje_cobranzareal=($total_global_cobranza_real*100)/$total_global_cobranza_ideal;
                                    
                                }
                            }
                            if($cont_s_pasada<=0){
                                $porcentaje_semana_pasada=0;
                            } else {
                                $porcentaje_semana_pasada=$total_global_cobranza_p_pasada/$cont_s_pasada;
                            }
                            if($cont_s_antepasada<=0){
                                $porcentaje_semana_antepasada=0;
                            } else {
                                $porcentaje_semana_antepasada=$total_global_cobranza_p_antepasada/$cont_s_antepasada;
                            }
                            if($total_global_mermas<=0){
                                $porcentaje_mermas=0;
                            } else {
                                if($total_global_cobranza_ideal<=0){
                                    $porcentaje_mermas=$total_global_mermas;
                                } else {
                                    $porcentaje_mermas=($total_global_mermas*100)/$total_global_cobranza_ideal;
                                }
                            }
                        @endphp
                        
                        
                    </tr> --}}
                </tbody>
            </table>
                <hr style="margin: 3px; border-top: 3px solid rgb(54, 0, 141);">
                <div style="text-align: right">
                    @php
                        
                        if($total_global_cobranza_real<=0){
                            $porcentaje_cobranzareal=0;
                        }else{
                            if($total_global_cobranza_ideal<=0){
                                $porcentaje_cobranzareal=$total_global_cobranza_real;
                            } else {
                                $porcentaje_cobranzareal=($total_global_cobranza_real*100)/$total_global_cobranza_ideal;
                                
                            }
                        }
                        if($cont_s_pasada<=0){
                            $porcentaje_semana_pasada=0;
                        } else {
                            $porcentaje_semana_pasada=$total_global_cobranza_p_pasada/$cont_s_pasada;
                        }
                        if($cont_s_antepasada<=0){
                            $porcentaje_semana_antepasada=0;
                        } else {
                            $porcentaje_semana_antepasada=$total_global_cobranza_p_antepasada/$cont_s_antepasada;
                        }
                        if($total_global_mermas<=0){
                            $porcentaje_mermas=0;
                        } else {
                            if($total_global_cobranza_ideal<=0){
                                $porcentaje_mermas=$total_global_mermas;
                            } else {
                                $porcentaje_mermas=($total_global_mermas*100)/$total_global_cobranza_ideal;
                            }
                        }
                    @endphp
                    <label style="font-size: 9px; font-weight: bold; width: 157px; " for="">Total: </label>
                    <label style="font-size: 9px; font-weight: bold; width: 70px; text-align: center;" for="">{{number_format($total_global_clientes)}}</label> 
                    <label style="font-size: 9px; font-weight: bold; width: 74px; text-align: center;" for="">$ {{number_format($total_global_cobranza_ideal,1)}}</label> 
                    <label style="font-size: 9px; font-weight: bold; width: 54; text-align: center;" for="">$ {{number_format($total_global_cobranza_proceso,1)}}</label> 
                    <label style="font-size: 9px; font-weight: bold; width: 74px; text-align: center;" for="">$ {{number_format($total_global_cobranza_real)}}</label>
                    <label style="font-size: 9px; font-weight: bold; width: 78px; text-align: right;" for="">{{number_format($porcentaje_cobranzareal,1)}}%</label>
                    <label style="font-size: 9px; font-weight: bold; width: 78px; text-align: right; " for="">{{number_format($porcentaje_semana_pasada,1)}}%</label>
                    <label style="font-size: 9px; font-weight: bold; width: 82px; text-align: right;" for="">{{number_format($porcentaje_semana_antepasada,1)}}%</label>
                    <label style="font-size: 9px; font-weight: bold; width: 72px; text-align: right;" for="">$ {{number_format($total_global_dinerocolocado,1)}}</label>
                    <label style="font-size: 9px; font-weight: bold; width: 63px; text-align: right;" for="">{{number_format($porcentaje_mermas,1)}}%</label>
                    <label style="font-size: 9px; font-weight: bold; width: 62px; text-align: right;" for="">$ {{number_format($total_global_mermas,1)}}</label>
                </div>
            </div>
        </div>    
    

    </div>
</body>
</html>
