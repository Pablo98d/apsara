<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de corte varias semanas</title>

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
        <label class="text-grande" style="margin-top: -20px; margin-left:150px">
            REPORTE DE CORTE DE COBRANZA
        </label>
        <div class="contenido-text">
            <img  src="{{asset('img/logo/Logo Prestamos.jpg')}}" width="170px" height="110px" style="position: absolute; right: 40px; top: -5px;">
            {{-- <img  class="float-right" style="margin-left:105px; margin-bottom: 5px; z-index: -80; margin-top: 2px;"  src="{{asset('img/logoferiecita.png')}}" width="170px" height="80px"> --}}
            <div style="margin: 0px; padding: 0px;">
                <label style="font-size: 14px; margin: 0px; margin-left: -17px;  padding: 0px; text-transform: uppercase;"><span style="font-weight: bold">RUTA:</span> {{$zona->Zona}}</label>            
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
                    <label for="" style="margin-left: -17px;">Sin gerentes de ruta</label>
                @else
                    @foreach ($gerentes_ruta as $gerente_ruta)
                    <label style="font-size: 14px; margin: 0px; margin-left: -17px; padding: 0px; text-transform: uppercase;"><span style="font-weight: bold">GERENTE DE RUTA:</span> {{$gerente_ruta->nombre}} {{$gerente_ruta->ap_paterno}} {{$gerente_ruta->ap_materno}}</label><br>
                        
                    @endforeach
                @endif
            </div>
        </div>
        <br> 
                @php
                    
                    $fechageneracion = $fecha_actual;
                    setlocale(LC_TIME, "spanish");
                    $fecha_g = $fechageneracion;
                    $fecha_g = str_replace("/", "-", $fecha_g);
                    $Nueva_Fecha_g = date("d-m-Y", strtotime($fecha_g));
                @endphp
                
        @if($semanas==0)
        
    <div class="row">
        <div class="col-md-12"><center>Sin semanas</center></div>
    </div>
    @else
        @for ($i = 0; $i < $semanas; $i++)
        @php
            $s_imprimir=$i+1;
        @endphp
            <br>
                <label style="color: #000;">Corte de hace <b>{{$s_imprimir}}</b> semanas</label> <label style="color: #000; margin-left:200px;">Reporte generado {{$Nueva_Fecha_g}}</label>
            <div class="row mt-4">
                @if ($s_imprimir>=1)
                    <br><br>
                    <div class="col-md-12">
                        <table>
                            <thead>
                                <tr>
                                    <th style="color: black; font-size: 11px;"><small>No. G</small></th>
                                    <th style="color: black; font-size: 11px;"><small>Grupo</small></th>
                                    <th style="color: black; font-size: 11px;"><small>Clientes</small></th>
                                    <th style="color: black; font-size: 11px;"><small>Monto ideal</small></th>
                                    <th style="color: black; font-size: 11px;"><small>Cobranza real</small></th>
                                    <th style="color: black; font-size: 11px;"><small>%Cobrado</small></th>
                                    <th style="color: black; font-size: 11px;"><small>Dinero colocado</small></th>
                                    <th style="color: black; font-size: 11px;"><small>% de fallas</small></th>
                                    <th style="color: black; font-size: 11px;"><small>Fallas</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_global_clientes=0;
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
                                                // $t_aportacion=0;
                                                // $t_cobranza_perfecta=0;
                                                
                                                $total_cobranza_pasada=0;
                                                $total_cobranza_ante_pasada=0;
                                            @endphp
                                            @if(count($cortes_semanas)==0)
                                                
                                            @else
                                                @foreach($cortes_semanas as $cortes_semana)
                                                    
                                                    {{-- @if ($contador>1) --}}
                                                        @if($s_imprimir==$contador)
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
                                                        @endif
                                                    {{-- @else
                                                        
                                                    @endif --}}
                                                    
                                                    @php
                                                        $contador+=1;
                                                    
                                                    // dd($s_imprimir,$semanas,$contador);
                                                    @endphp
                                                @endforeach
                                            @endif
                                    <tr>
                                            
                                        <td>
                                            <small><center>{{$grupo->id_grupo}}</center></small>
                                        </td>
                                        <td><small>{{$grupo->grupo}}</small></td>
                                        <td style="text-align: right">
                                                <small>
                                                    {{number_format($clientes_actual)}}
                                                </small>
                                        </td>
                                        <td style="text-align: right">
                                            <!--semana actual cobranza ideal-->
                                                <small>
                                                    @php
                                                        $total_global_cobranza_ideal+=$cobranza_ideal_actual;
                                                    @endphp
                                                $ {{number_format($cobranza_ideal_actual,2)}} <br>
                                                
                                            </small>
                                        </td>
                                        <td style="text-align: right">
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
                                                {{-- @if(!empty($aportacion_empresa))
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
                                                @endif --}}
                                                
                                                <!--Calculamos el total de cobranza perfecta-->
                                                {{-- @if(!empty($cobranza_perfecta))
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
                                                --}}
                                                
                                                <!--Calculamos el monto real-->
                                                @php
                                                    // $monto_real=$total_cobranza_actual-$t_aportacion-$t_cobranza_perfecta;
                                                    $monto_real=$total_cobranza_actual;
                                                    $total_global_cobranza_real+=$monto_real;
                                                @endphp
                                                $ {{number_format($monto_real,2)}}
                                            </small>
            
                                        </td>
                                        <td style="text-align: right">
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
                                        <td style="text-align: right">
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
                                        <td style="text-align: right">
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
                                        <td style="text-align: right"> 
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

                            @endphp
                                @endforeach
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
                            <label style="font-size: 9px; font-weight: bold; width: 140px; " for="">Total: </label>
                            <label style="font-size: 9px; font-weight: bold; width: 36px;  " for="">{{number_format($total_global_clientes)}}</label> 
                            <label style="font-size: 9px; font-weight: bold; width: 79px;  " for="">$ {{number_format($total_global_cobranza_ideal,1)}}</label> 
                            <label style="font-size: 9px; font-weight: bold; width: 70px;  " for="">$ {{number_format($total_global_cobranza_real)}}</label>
                            <label style="font-size: 9px; font-weight: bold; width: 74px;  " for="">{{number_format($porcentaje_cobranzareal,1)}}%</label>
                            <label style="font-size: 9px; font-weight: bold; width: 75px;  " for="">$ {{number_format($total_global_dinerocolocado,1)}}</label>
                            <label style="font-size: 9px; font-weight: bold; width: 67px;  " for="">{{number_format($porcentaje_mermas,1)}}%</label>
                            <label style="font-size: 9px; font-weight: bold; width: 60px;  " for="">$ {{number_format($total_global_mermas,1)}}</label>
                        </div>
                    </div>
                @else

                @endif
            </div>
        @endfor
    @endif
    <br>
    

    </div>
</body>
</html>
