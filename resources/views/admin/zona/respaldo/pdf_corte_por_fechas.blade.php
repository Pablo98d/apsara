<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte por fechas</title>
    <link rel="shortcut icon" href="{{asset("icono/pdf.png")}}" type="image/x-icon">
    
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
            color: navy;
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
        <hr class="hr-1">
        <div class="contenido-text">
            <img  class="float-right" style="margin-left:105px; margin-bottom: 5px; z-index: -80; margin-top: 2px;"  src="{{asset('img/logoferiecita.png')}}" width="170px" height="80px">
            
            <div>
                <label class="label" for="">Zona</label>
                <br>
                <label class="label-2" for="">{{$zona->Zona}}</label>
            </div>
            
            <label class="mt-1 text-grande">
                Corte de cobranza
            </label><br>
        <p>Ha consultado <b>{{$semanas}}</b> semanas pasadas</p>
        </div>
        <br>
        <div class="row mt-4">
            <div class="col-md-12">
                
            @php
                // $semanas=2;

                // fechas de semana actual
                $f1=$f_actual;
                $f2=date("Y-m-d",strtotime($f_actual."- ".$cant_dias." days")); 

                // fechas de semana pasada
                $p_cant_dias_i=$cant_dias+7;
                $f1p=date("Y-m-d",strtotime($f_actual."- ".$p_cant_dias_i." days")); 

                $p_cant_dias_f=$cant_dias+1;
                $f2p=date("Y-m-d",strtotime($f_actual."- ".$p_cant_dias_f." days")); 

                // fechas de semanas antepasadas
                $a_cant_dias_i=$cant_dias+14;
                $f2a=date("Y-m-d",strtotime($f_actual."- ".$a_cant_dias_i." days")); 
                $a_cant_dias_f=$cant_dias+8;
                $f1a=date("Y-m-d",strtotime($f_actual."- ".$a_cant_dias_f." days")); 


            @endphp
            @for ($i = 0; $i < $semanas; $i++)
                @php
                    $semana=$i+1;
                    $cantidad_dias=$semana*7;

                    $p_cant_dia=$cant_dias+$cantidad_dias;
                    $f1_pasada=date("Y-m-d",strtotime($f_actual."- ".$p_cant_dia." days")); 
                    // $cant_dias_f2=$cantidad_dias-1;
                    $f2_pasada=date("Y-m-d",strtotime($f1_pasada."+ 6 days")); 

                    $total_cobranza_ideal=0;
                    $total_cobranza_real=0;


                    $total_merma=0;

                            $f1_arr = explode('-', $f1_pasada);
                            $fecha_inicial = $f1_arr[2].'-'.$f1_arr[1].'-'.$f1_arr[0];

                            $f2_arr = explode('-', $f2_pasada);
                            $fecha_final = $f2_arr[2].'-'.$f2_arr[1].'-'.$f2_arr[0];

                @endphp
                {{-- <b>{{$semana}}</b><br>
                <label for="">cant dias: {{$cant_dias}}</label><br>
                <label for="">semana * 7: {{$cantidad_dias}}</label><br>

                <label for="">cant mas semana: {{$p_cant_dia}}</label> --}}
                <label style=" font-size: 13px;" for="">Corte de hace </label>
                <label style=" font-size: 13px;" for=""> <b style=" font-size: 13px;"> {{$semana}} </b> semana(s) pasada: </label>
                <label style=" font-size: 13px;" for=""> fecha inicio: <b style=" font-size: 13px;"> {{$fecha_inicial}}</b> </label>
                <label style=" font-size: 13px;" for=""> fecha fin: <b style=" font-size: 13px;"> {{$fecha_final}}</b> </label><br><br>

                <table>
                    <thead>
                        <tr>
                            <th style="color: black; font-size: 10px;">No.G</th>
                            <th style="color: black; font-size: 10px;">Grupo</th>
                            <th style="color: black; font-size: 10px;">Cobranza ideal</th>
                            <th style="color: black; font-size: 10px;">Cobranza real</th>
                            <th style="color: black; font-size: 10px;">%Cobrado</th>
                            <th style="color: black; font-size: 10px;">Dinero colocado</th>
                            <th style="color: black; font-size: 10px;">%Mermas</th>
                            <th style="color: black; font-size: 10px;">Mermas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grupos as $grupo)
                            <tr>
                                    @php
                                        $total_cobrado=0;

                                        $total_nocobrado=0;
                                            
                                        $t_p_entregados=0;
                                        $total_dinero_colocado=0;
                                            
                                        $prestamos_entregados=DB::table('tbl_prestamos')
                                        ->select('tbl_prestamos.*')
                                        ->where('id_grupo','=',$grupo->id_grupo)
                                        ->whereIn('id_status_prestamo', [2, 9])
                                        ->whereBetween('fecha_entrega_recurso', [$f1_pasada, $f2_pasada])
                                        ->get();

                                    @endphp

                                    
                                <td>
                                    {{-- {{$prestamos_entregados}} --}}
                                    @if (count($prestamos_entregados)==0)
                                        @php
                                            $t_p_entregados+=0;
                                        @endphp
                                    @else
                                        @foreach ($prestamos_entregados as $prestamos_en)
                                            @php
                                                $suma_admin=0;
                                                $administracion=DB::table('tbl_abonos')
                                                ->select('tbl_abonos.*')
                                                ->where('id_prestamo','=',$prestamos_en->id_prestamo)
                                                ->whereIn('id_tipoabono', [2, 3])
                                                ->whereIn('semana', [0])
                                                ->get();

                                                // $t_p_entregados+=
                                            @endphp
                                            @if (count($administracion)==0)
                                                @php
                                                    $t_p_entregados+=0;
                                                @endphp
                                            @else
                                                @foreach ($administracion as $admin)
                                                        @php
                                                            $suma_admin+=$admin->cantidad;
                                                            
                                                        @endphp
                                                    {{-- <label for="">{{$admin->id_prestamo}}/ {{$admin->cantidad}} / {{$admin->id_tipoabono}}</label> <br> --}}
                                                @endforeach
                                                @php
                                                    $t_p_entregados+=$prestamos_en->cantidad-$suma_admin;
                                                @endphp
                                            @endif
                                            {{-- Prestamo: {{$prestamos_en->id_prestamo}} /cantidad: {{$prestamos_en->cantidad}} / {{$prestamos_en->fecha_entrega_recurso}}</li> <br>
                                        <br> <label for=""><b>Total: {{$t_p_entregados}}</b></label><br> --}}
                                        @endforeach
                                    @endif
                                    <small><center>{{$grupo->id_grupo}}</center></small></td>
                                <td>
                                    <small>{{$grupo->grupo}}</small>
                                </td>
                                <td style="text-align: right">
                                    <small>
                                        @php
                                            $total_recibido_cobrado=DB::table('tbl_abonos')
                                            ->join('tbl_prestamos','tbl_abonos.id_prestamo','tbl_prestamos.id_prestamo')
                                            ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                                            ->select('tbl_abonos.*','tbl_prestamos.cantidad as monto','tbl_productos.*')
                                            ->where('tbl_prestamos.id_grupo','=',$grupo->id_grupo)
                                            ->whereBetween('tbl_abonos.fecha_pago', [$f1_pasada, $f2_pasada])
                                            ->whereNotBetween('tbl_abonos.id_tipoabono', [3, 5])
                                            ->whereNotIn('tbl_abonos.semana', [0])
                                            ->get();

                                            $total_no_recibido=DB::table('tbl_abonos')
                                            ->join('tbl_prestamos','tbl_abonos.id_prestamo','tbl_prestamos.id_prestamo')
                                            ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                                            ->select('tbl_abonos.*','tbl_prestamos.cantidad as monto','tbl_productos.*')
                                            ->where('tbl_prestamos.id_grupo','=',$grupo->id_grupo)
                                            ->whereBetween('tbl_abonos.fecha_pago', [$f1_pasada, $f2_pasada])
                                            ->whereNotBetween('tbl_abonos.id_tipoabono', [1, 3])
                                            ->whereNotIn('tbl_abonos.semana', [0])
                                            ->get();

                                            
                                        @endphp
                                        @if (count($total_recibido_cobrado)==0)
                                            @php
                                                $total_cobrado+=0;
                                            @endphp
                                        @else
                                            @foreach ($total_recibido_cobrado as $total_r_c)
                                                @php
                                                    $total_cobrado+=$total_r_c->monto*($total_r_c->pago_semanal/100);
                                                @endphp
                                            @endforeach
                                        @endif
                                        @if (count($total_no_recibido)==0)
                                            @php
                                                $total_nocobrado+=0;
                                            @endphp
                                        @else
                                            @foreach ($total_no_recibido as $total_n_r)
                                                @php
                                                    $total_nocobrado+=$total_n_r->monto*($total_n_r->pago_semanal/100);
                                                @endphp
                                            @endforeach
                                        @endif

                                    
                                        @php
                                            $total_nuevos_p=0;
                                        @endphp
                                        @if (empty($p_ingresaron_pasado))
                                            @php
                                                $total_nuevos_p+=0;
                                            @endphp
                                        @else
                                            @foreach ($p_ingresaron_pasado as $p_i_pa)
                                                @php
                                                    $total_nuevos_p+=$p_i_pa->cantidad*($p_i_pa->pago_semanal/100);
                                                @endphp
                                            @endforeach
                                        @endif
                                        @php
                                            $total_ideal_new=$total_cobrado+$total_nocobrado;
                                            $total_cobranza_ideal+= $total_ideal_new;
                                        @endphp

                                        $ {{number_format($total_ideal_new,2)}} <br>
                                    </small>
                                </td>
                                <td style="text-align: right">
                                    <small>
                                       @php
                                           $total_cobranza_real+=$total_cobrado;
                                       @endphp
                                        $ {{number_format($total_cobrado,2)}} n<br>
                                    </small>
                                </td>
                                <td style="text-align: right">
                                    <small>
                                        
                                        
                                        @php
                                            
                                            if ($total_cobrado==0) {
                                                $porcentaje_pasada=0;
                                            } else {
                                                $porcentaje_pasada=($total_cobrado*100)/$total_ideal_new;
                                            }
                                            
                                        @endphp
                                        Ideal: {{$total_ideal_new}} -> 
                                        $ {{number_format($total_cobrado,2)}} <br>
                                        <b>{{number_format($porcentaje_pasada,2)}}%</b>
                                    </small>
                                </td>
                                
                                <td style="text-align: right">
                                    <small>
                                        @php
                                            $total_dinero_colocado+=$t_p_entregados;
                                        @endphp
                                        $ {{number_format($t_p_entregados,2)}}
                                    </small>
                                </td>
                                <td style="text-align: right">
                                    <small>
                                        @php
                                            
                                            if ($total_cobrado==0) {
                                                $mermas=0;
                                            } else {
                                                $mermas=$total_ideal_new-$total_cobrado;
                                            }

                                            if ($total_cobrado==0) {
                                                $mermas_porcentaje=0;
                                            } else {
                                                $mermas_porcentaje=($mermas*100)/$total_ideal_new;
                                            }
                                            
                                        @endphp
                                        {{number_format($mermas_porcentaje,2)}}%
                                    </small>
                                </td>
                                <td style="text-align: right"> 
                                    <small>
                                        @php
                                            $total_merma+=$mermas;
                                        @endphp
                                        $ {{number_format($mermas,2)}}
                                    </small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr style="margin: 3px">
                <div style="text-align: right">
                    @php
                         $t_actual_porcentaje=($total_cobranza_real*100)/$total_cobranza_ideal;
                         $t_merma_porcentaje=($total_merma*100)/$total_cobranza_ideal;
                    @endphp
                    <label style="font-size: 10px; font-weight: bold; width: 156px; " for="">Total: </label>
                    <label style="font-size: 10px; font-weight: bold; width: 63px;  " for="">$ {{number_format($total_cobranza_ideal,1)}}</label> 
                    <label style="font-size: 10px; font-weight: bold; width: 79px;  " for="">$ {{number_format($total_cobranza_real,1)}}</label>
                    <label style="font-size: 10px; font-weight: bold; width: 82px;  " for="">{{number_format($t_actual_porcentaje,1)}}%</label>
                    <label style="font-size: 10px; font-weight: bold; width: 84px;  " for="">$ {{number_format($total_dinero_colocado,1)}}</label>
                    <label style="font-size: 10px; font-weight: bold; width: 72px;  ">{{number_format($t_merma_porcentaje,1)}}%</label>
                    <label style="font-size: 10px; font-weight: bold; width: 65px;  ">$ {{number_format($total_merma,1)}}</label>
                </div>
                <br><br>




            @endfor


                @php
                            // $total_cobranza_ideal=0;
                            // $total_cobranza_real=0;

                            // $total_actual_porcentaje=0;

                            // $total_pasado_porcentaje=0;
                            // $total_antepasado_porcentaje=0;

                            // $total_dinero_colocado=0;
                            // $total_merma_porcentaje=0;

                            // $total_merma=0;
                            // $total_registro=count($grupos);

                            // $t_actual_porcentaje=($total_cobranza_real*100)/$total_cobranza_ideal;

                            
                            // $t_merma_porcentaje=($total_merma*100)/$total_cobranza_ideal;
                            // $t_actual_porcentaje=$total_actual_porcentaje/$total_registro;


                @endphp
                
               
            </div>
        </div>    
    

    </div>
</body>
</html>
