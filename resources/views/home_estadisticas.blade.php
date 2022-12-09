@extends('layouts.master')
@section('title', 'Estadísticas general')
@section('parentPageTitle', 'Estadisticas')
@section('page-style')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@stop
@section('content')
    
    <div class="col-md-12">
        @php
            $t_semana_negra=0;
            $s_semana_negra=0;
            $t_semana_morado=0;
            $s_semana_morado=0;
            $t_semana_rojo=0;
            $s_semana_rojo=0;
            $t_semana_naranja=0;
            $s_semana_naranja=0;
            $t_semana_amarillo=0;
            $s_semana_amarillo=0;
            $t_semana_verde=0;
            $s_semana_verde=0;
            $t_saldo_irrecuperable=0;
            $s_saldo_irrecuperable=0;
            
            $ultimos_abonos=json_decode($ultimos_abonos);
        @endphp
                    @foreach ($ultimos_abonos as $ultimos_a)
                        @php
                            // Para decir vencido, la ultima semana debe estar en 14 y despues preguntar si tiene saldo o noo?
                            $semana_negra = DB::table('tbl_abonos')
                            ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                            ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                            ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                            ->where('tbl_abonos.semana','=',14)
                            ->distinct()
                            ->get();
                        
                            // Su ultima semana debe ser mayor de 14 semanas, 
                            // preguntar si la semana es 15 entonces preguntamos si el tipo de abono no es multa
                            // si la semana es mayor de 15 entonces preguntamos si el abono tiene alguna cantidad
                            $semana_morado = DB::table('tbl_abonos')
                            ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                            ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                            ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                            ->where('tbl_abonos.semana','>',14)
                            ->get();

                            $semana_amarillo = DB::table('tbl_abonos')
                            ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                            ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                            ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                            ->where('tbl_abonos.semana','<',14)
                            ->get();
                            
                            
                            $prestamos_irrecuperable = DB::table('tbl_abonos')
                            ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                            ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                            ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                            ->get();
                            
                            
                        @endphp 

                        @if ($ultimos_a->id_status_prestamo==18)
                            @if (count($prestamos_irrecuperable)==0)
                                
                            @else
                                @foreach ($prestamos_irrecuperable as $prestamo_irrecuperable)
                                    {{-- Se coloca en estatus rojo --}}
                                    @php
                                        $cliente = DB::table('tbl_prestamos')
                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                            ->where('tbl_prestamos.id_prestamo','=',$prestamo_irrecuperable->id_prestamo)
                                            ->distinct()
                                            ->get();
                                    @endphp
                                    {{-- <tr><td> roja{{$semana_n->cantidad}}</td> <td>{{$semana_n->id_prestamo}}</td></tr> --}}
                                    @foreach ($cliente as $cli)
                                        {{-- calculamos el saldo --}}
                                        @php
                                            $producto = DB::table('tbl_productos')   
                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                            ->select('tbl_productos.*')
                                            ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                            ->get();
                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                            ->select('cantidad')
                                            ->where('id_prestamo','=',$cli->id_prestamo)
                                            ->get();
                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                            ->where('id_tipoabono','=',1)
                                            ->get();
                                            $tipo_abono = DB::table('tbl_abonos')
                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                            ->where('id_tipoabono','=',2)
                                            ->get();
                                            $tipo_ahorro = DB::table('tbl_abonos')
                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                            ->where('id_tipoabono','=',3)
                                            ->get();
                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                            ->where('id_tipoabono','=',4)
                                            ->get();
                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                    $multa1=0;
                                                }else {
                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                }
                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                            ->where('id_tipoabono','=',5)
                                            ->get();
                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                    $multa2=0;
                                                }else {
                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                }
                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                            // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                            $saldo_irrecuperable=$sistema_total_cobrar-$cliente_pago;
                                            
                                            //$t_semana_rojo+=$semana_n->cantidad;
                                            $s_saldo_irrecuperable+=$prestamo_irrecuperable->cantidad;
                                            $t_saldo_irrecuperable+=$saldo_irrecuperable;
                                        @endphp
                                        
                                    @endforeach
                                @endforeach
                            @endif
                        @else

                        


                            @if (count($semana_negra)==0)
                                
                            @else
                                {{-- Estado negro y rojo solucionado---}}
                                @foreach ($semana_negra as $semana_n)
                                    @php
                                        $dias_transcurrido = $fecha_actual->diffInDays($semana_n->fecha_pago);
                                        
                                    @endphp
                                    @if ($dias_transcurrido<45)
                                    
                                        {{-- Se coloca en estatus rojo --}}
                                            @php
                                                $cliente = DB::table('tbl_prestamos')
                                                    ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                    ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                    ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$semana_n->id_prestamo)
                                                    ->distinct()
                                                    ->get();
                                            @endphp
                                            {{-- <tr><td> roja{{$semana_n->cantidad}}</td> <td>{{$semana_n->id_prestamo}}</td></tr> --}}
                                            @foreach ($cliente as $cli)
                                                {{-- calculamos el saldo --}}
                                                @php
                                                    $producto = DB::table('tbl_productos')   
                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                    ->select('tbl_productos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                    ->get();
                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                    ->select('cantidad')
                                                    ->where('id_prestamo','=',$cli->id_prestamo)
                                                    ->get();
                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',1)
                                                    ->get();
                                                    $tipo_abono = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',2)
                                                    ->get();
                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',3)
                                                    ->get();
                                                    $tipo_multa_1 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_1'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',4)
                                                    ->get();
                                                        if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                            $multa1=0;
                                                        }else {
                                                            $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                        }
                                                    $tipo_multa_2 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_2'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',5)
                                                    ->get();
                                                        if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                            $multa2=0;
                                                        }else {
                                                            $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                        }
                                                    $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                    $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                    // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa2=$producto[0]->penalizacion*$multa2;
                                                    $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                    $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                    
                                                    //$t_semana_rojo+=$semana_n->cantidad;
                                                    $t_semana_rojo+=$saldo_rojo;
                                                    $s_semana_rojo+=$semana_n->cantidad;
                                                @endphp
                                                {{-- @if ($saldo_rojo==0)
                                                    
                                                @else
                                                    <tr>
                                                        <td style="color: red; background:red ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                        <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                        <td>{{$cli->id_prestamo}}</td>
                                                        <td>
                                                            @php
                                                                $originalDate = $cli->fecha_entrega_recurso;
                                                                $newDate = date("d/m/Y", strtotime($originalDate));
                                                            @endphp
                                                            {{$newDate}}
                                                        </td>
                                                        <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                        <td style="color:red;">
                                                                $ {{number_format($saldo_rojo,1)}}
                                                        </td>
                                                    </tr>
                                                    
                                                @endif --}}
                                            @endforeach
                                        
                                        {{-- menos de 45 dias : d: {{$dias_transcurrido}} s:{{$semana_n->semana}} c:{{$semana_n->cantidad}}  <br> --}}
                                    @elseif($dias_transcurrido>45)
                                        {{-- Se coloca ne estatus negro --}}
                                            @php
                                                $clienten = DB::table('tbl_prestamos')
                                                    ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                    ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                    ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$semana_n->id_prestamo)
                                                    ->distinct()
                                                    ->get();
                                            @endphp
                                            @foreach ($clienten as $clin)
                                                {{-- calculamos el saldo --}}
                                                @php
                                                    $producto = DB::table('tbl_productos')   
                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                    ->select('tbl_productos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$clin->id_prestamo)
                                                    ->get();
                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                    ->select('cantidad')
                                                    ->where('id_prestamo','=',$clin->id_prestamo)
                                                    ->get();
                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',1)
                                                    ->get();
                                                    $tipo_abono = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',2)
                                                    ->get();
                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',3)
                                                    ->get();
                                                    $tipo_multa_1 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_1'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',4)
                                                    ->get();
                                                        if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                            $multa1=0;
                                                        }else {
                                                            $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                        }
                                                    $tipo_multa_2 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_2'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',5)
                                                    ->get();
                                                        if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                            $multa2=0;
                                                        }else {
                                                            $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                        }
                                                    $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                    $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                    // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa2=$producto[0]->penalizacion*$multa2;
                                                    $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                    $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                    
                                                    
                                                    //$t_semana_negra+=$semana_n->cantidad;
                                                    $t_semana_negra+=$saldo_negro;
                                                    $s_semana_negra+=$semana_n->cantidad;
                                                    
                                                @endphp
                                                {{-- @if ($saldo_negro==0)
                                                    
                                                @else
                                                    <tr>
                                                        <td style="color: #000; background:black ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                        <td>{{$clin->nombre}} {{$clin->ap_paterno}} {{$clin->ap_materno}}</td>
                                                        <td>{{$clin->id_prestamo}}</td>
                                                        <td>
                                                            @php
                                                                $originalDate = $clin->fecha_entrega_recurso;
                                                                $newDate = date("d/m/Y", strtotime($originalDate));
                                                            @endphp
                                                            {{$newDate}}
                                                        </td>
                                                        <td>$ {{number_format($clin->cantidad,1)}}</td>
                                                        <td style="color:red;">
                                                                
                                                                $ {{number_format($saldo_negro,1)}}
                                                        </td>
                                                    </tr>
                                                @endif --}}
                                            @endforeach 
                                    @else
                                        {{-- <label>no hay datos</label> --}}
                                    @endif
                                @endforeach
                            @endif

                            @if (count($semana_morado)==0)
                                
                            @else
                                @foreach ($semana_morado as $semana_m)
                                    {{-- Se coloca en estatus morado  --}}
                                    @php
                                        $dias_transcurrido_m = $fecha_actual->diffInDays($semana_m->fecha_pago);
                                    @endphp
                                    @if ($dias_transcurrido_m>45)
                                        {{-- Consultamos las semanas despues de 14 --}}
                                        @php
                                            $abono_buscar=0;
                                            $verificar_semanas=DB::table('tbl_abonos')
                                            ->select('tbl_abonos.*')
                                            ->where('semana','>',14)
                                            ->where('id_prestamo','=',$semana_m->id_prestamo)
                                            ->get();
                                        @endphp
                                        {{-- Preguntamos si hay elementos en la consulta --}}
                                        @if (count($verificar_semanas)==0)
                                            
                                        @else
                                            {{-- Si hay elementos entonces recorremos y preguntamos si el tipo de abono
                                            no es multa  --}}
                                            @foreach ($verificar_semanas as $verificar_semana)
                                                @if ($verificar_semana->id_tipoabono==4)
                                                    
                                                @elseif ($verificar_semana->id_tipoabono==5)

                                                @else
                                                    @php
                                                        $abono_buscar+=$verificar_semana->cantidad;
                                                    @endphp
                                                @endif
                                                
                                            @endforeach
                                        @endif
                                        @if ($abono_buscar==0)
                                        {{-- Preguntamos si no hay cantidad de abono, para pasarlo a estado negro  --}}
                                            @php
                                                $clienten = DB::table('tbl_prestamos')
                                                    ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                    ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                    ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                    ->distinct()
                                                    ->get();
                                            @endphp
                                            @foreach ($clienten as $clin)
                                                {{-- calculamos el saldo --}}
                                                @php
                                                    $producto = DB::table('tbl_productos')   
                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                    ->select('tbl_productos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$clin->id_prestamo)
                                                    ->get();
                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                    ->select('cantidad')
                                                    ->where('id_prestamo','=',$clin->id_prestamo)
                                                    ->get();
                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',1)
                                                    ->get();
                                                    $tipo_abono = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',2)
                                                    ->get();
                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',3)
                                                    ->get();
                                                    $tipo_multa_1 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_1'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',4)
                                                    ->get();
                                                        if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                            $multa1=0;
                                                        }else {
                                                            $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                        }
                                                    $tipo_multa_2 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_2'))
                                                    ->where('id_prestamo', '=', $clin->id_prestamo)
                                                    ->where('id_tipoabono','=',5)
                                                    ->get();
                                                        if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                            $multa2=0;
                                                        }else {
                                                            $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                        }
                                                    $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                    $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                    // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa2=$producto[0]->penalizacion*$multa2;
                                                    $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                    $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                    
                                                    
                                                    //$t_semana_negra+=$semana_n->cantidad;
                                                    $t_semana_negra+=$saldo_negro;
                                                    $s_semana_negra+=$semana_m->cantidad;
                                                    
                                                @endphp
                                                {{-- @if ($saldo_negro==0)
                                                    
                                                @else
                                                    <tr>
                                                        <td style="color: #000; background:black ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                        <td>{{$clin->nombre}} {{$clin->ap_paterno}} {{$clin->ap_materno}}</td>
                                                        <td>{{$clin->id_prestamo}}</td>
                                                        <td>
                                                            @php
                                                                $originalDate = $clin->fecha_entrega_recurso;
                                                                $newDate = date("d/m/Y", strtotime($originalDate));
                                                            @endphp
                                                            {{$newDate}}
                                                        </td>
                                                        <td>$ {{number_format($clin->cantidad,1)}}</td>
                                                        <td style="color:red;">
                                                                
                                                                $ {{number_format($saldo_negro,1)}}
                                                        </td>
                                                    </tr>
                                                @endif --}}
                                            @endforeach
                                        @else
                                            {{-- Si hay cantidad abono entonces lo pasamos a estado morado porque  --}}
                                            @php
                                                //$t_semana_morado+=$semana_m->cantidad;
                                                $clientem = DB::table('tbl_prestamos')
                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                ->distinct()
                                                ->get();
                                            @endphp
                                            @foreach ($clientem as $clim)
                                                {{-- calculamos el saldo --}}
                                                @php
                                                    $producto = DB::table('tbl_productos')   
                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                    ->select('tbl_productos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$clim->id_prestamo)
                                                    ->get();
                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                    ->select('cantidad')
                                                    ->where('id_prestamo','=',$clim->id_prestamo)
                                                    ->get();
                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                    ->where('id_prestamo', '=', $clim->id_prestamo)
                                                    ->where('id_tipoabono','=',1)
                                                    ->get();
                                                    $tipo_abono = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                    ->where('id_prestamo', '=', $clim->id_prestamo)
                                                    ->where('id_tipoabono','=',2)
                                                    ->get();
                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                    ->where('id_prestamo', '=', $clim->id_prestamo)
                                                    ->where('id_tipoabono','=',3)
                                                    ->get();
                                                    $tipo_multa_1 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_1'))
                                                    ->where('id_prestamo', '=', $clim->id_prestamo)
                                                    ->where('id_tipoabono','=',4)
                                                    ->get();
                                                        if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                            $multa1=0;
                                                        }else {
                                                            $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                        }
                                                    $tipo_multa_2 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_2'))
                                                    ->where('id_prestamo', '=', $clim->id_prestamo)
                                                    ->where('id_tipoabono','=',5)
                                                    ->get();
                                                        if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                            $multa2=0;
                                                        }else {
                                                            $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                        }
                                                    $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                    $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                    // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa2=$producto[0]->penalizacion*$multa2;
                                                    $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                    $saldo_morado=$sistema_total_cobrar-$cliente_pago;
                                                    
                                                    
                                                    //$t_semana_morado+=$semana_m->cantidad;
                                                    $t_semana_morado+=$saldo_morado;
                                                    $s_semana_morado+=$semana_m->cantidad;
                                                    
                                                @endphp
                                                {{-- @if ($saldo_morado==0)
                                                    
                                                @else
                                                    <tr>
                                                        <td style="color: purple; background:purple ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                        <td>{{$clim->nombre}} {{$clim->ap_paterno}} {{$clim->ap_materno}}</td>
                                                        <td>{{$clim->id_prestamo}}</td>
                                                        <td>
                                                            @php
                                                                $originalDate = $clim->fecha_entrega_recurso;
                                                                $newDate = date("d/m/Y", strtotime($originalDate));
                                                            @endphp
                                                            {{$newDate}}
                                                        </td>
                                                        <td>$ {{number_format($clim->cantidad,1)}}</td>
                                                        <td style="color:red;">
                                                            
                                                            $ {{number_format($saldo_morado,1)}}    
                                                        </td>
                                                    </tr>
                                                @endif --}}
                                            @endforeach
                                            
                                        @endif
                                    

                                    @elseif($dias_transcurrido_m<45)
                                        {{-- Se coloca en estatus naranja --}}
                                        @php
                                            $abono_buscar=0;
                                            $verificar_semanas=DB::table('tbl_abonos')
                                            ->select('tbl_abonos.*')
                                            ->where('semana','>',14)
                                            ->where('id_prestamo','=',$semana_m->id_prestamo)
                                            ->get();
                                        @endphp
                                        {{-- Preguntamos si hay elementos en la consulta --}}
                                        @if (count($verificar_semanas)==0)
                                            
                                        @else
                                            {{-- Si hay elementos entonces recorremos y preguntamos si el tipo de abono
                                            no es multa  --}}
                                            @foreach ($verificar_semanas as $verificar_semana)
                                                @if ($verificar_semana->id_tipoabono==4)
                                                    
                                                @elseif ($verificar_semana->id_tipoabono==5)

                                                @else
                                                    @php
                                                        $abono_buscar+=$verificar_semana->cantidad;
                                                    @endphp
                                                @endif
                                                
                                            @endforeach

                                        @endif

                                        @if ($abono_buscar==0)
                                            {{-- Se coloca en estatus rojo --}}
                                            @php
                                                $cliente = DB::table('tbl_prestamos')
                                                    ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                    ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                    ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                    ->distinct()
                                                    ->get();
                                            @endphp
                                            {{-- <tr><td> roja{{$semana_n->cantidad}}</td> <td>{{$semana_n->id_prestamo}}</td></tr> --}}
                                            @foreach ($cliente as $cli)
                                                {{-- calculamos el saldo --}}
                                                @php
                                                    $producto = DB::table('tbl_productos')   
                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                    ->select('tbl_productos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                    ->get();
                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                    ->select('cantidad')
                                                    ->where('id_prestamo','=',$cli->id_prestamo)
                                                    ->get();
                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',1)
                                                    ->get();
                                                    $tipo_abono = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',2)
                                                    ->get();
                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',3)
                                                    ->get();
                                                    $tipo_multa_1 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_1'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',4)
                                                    ->get();
                                                        if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                            $multa1=0;
                                                        }else {
                                                            $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                        }
                                                    $tipo_multa_2 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_2'))
                                                    ->where('id_prestamo', '=', $cli->id_prestamo)
                                                    ->where('id_tipoabono','=',5)
                                                    ->get();
                                                        if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                            $multa2=0;
                                                        }else {
                                                            $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                        }
                                                    $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                    $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                    // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa2=$producto[0]->penalizacion*$multa2;
                                                    $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                    $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                    
                                                    //$t_semana_rojo+=$semana_n->cantidad;
                                                    $t_semana_rojo+=$saldo_rojo;
                                                    $s_semana_rojo+=$semana_m->cantidad;

                                                
                                                @endphp
                                                {{-- @if ($saldo_rojo==0)
                                                    
                                                @else
                                                    <tr>
                                                        <td style="color: red; background:red ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                        <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                        <td>{{$cli->id_prestamo}}</td>
                                                        <td>
                                                            @php
                                                                $originalDate = $cli->fecha_entrega_recurso;
                                                                $newDate = date("d/m/Y", strtotime($originalDate));
                                                            @endphp
                                                            {{$newDate}}
                                                        </td>
                                                        <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                        <td style="color:red;">
                                                                $ {{number_format($saldo_rojo,1)}}
                                                        </td>
                                                    </tr>
                                                    
                                                @endif --}}
                                            @endforeach
                                        @else
                                            {{-- Si tiene movimiento entonces lo pasamos al color naranja --}}
                                            @php
                                                $clientena = DB::table('tbl_prestamos')
                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                ->distinct()
                                                ->get();
                                            @endphp
                                            @foreach ($clientena as $clina)
                                                {{-- calculamos el saldo --}}
                                                @php
                                                    $producto = DB::table('tbl_productos')   
                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                    ->select('tbl_productos.*')
                                                    ->where('tbl_prestamos.id_prestamo','=',$clina->id_prestamo)
                                                    ->get();
                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                    ->select('cantidad')
                                                    ->where('id_prestamo','=',$clina->id_prestamo)
                                                    ->get();
                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                    ->where('id_prestamo', '=', $clina->id_prestamo)
                                                    ->where('id_tipoabono','=',1)
                                                    ->get();
                                                    $tipo_abono = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                    ->where('id_prestamo', '=', $clina->id_prestamo)
                                                    ->where('id_tipoabono','=',2)
                                                    ->get();
                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                    ->where('id_prestamo', '=', $clina->id_prestamo)
                                                    ->where('id_tipoabono','=',3)
                                                    ->get();
                                                    $tipo_multa_1 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_1'))
                                                    ->where('id_prestamo', '=', $clina->id_prestamo)
                                                    ->where('id_tipoabono','=',4)
                                                    ->get();
                                                        if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                            $multa1=0;
                                                        }else {
                                                            $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                        }
                                                    $tipo_multa_2 = DB::table('tbl_abonos')
                                                    ->select(DB::raw('count(*) as tipo_multa_2'))
                                                    ->where('id_prestamo', '=', $clina->id_prestamo)
                                                    ->where('id_tipoabono','=',5)
                                                    ->get();
                                                        if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                            $multa2=0;
                                                        }else {
                                                            $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                        }
                                                    $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                    $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                    $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                    $s_multa2=$producto[0]->penalizacion*$multa2;
                                                    $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                    $saldo_naranja=$sistema_total_cobrar-$cliente_pago;
                                                    
                                                    $t_semana_naranja+=$saldo_naranja;
                                                    $s_semana_naranja+=$semana_m->cantidad;
                                                @endphp
                                                {{-- @if ($saldo_naranja==0)
                                                    
                                                @else
                                                    <tr>
                                                        <td style="color: orange; background:orange ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                        <td>{{$clina->nombre}} {{$clina->ap_paterno}} {{$clina->ap_materno}}</td>
                                                        <td>{{$clina->id_prestamo}}</td>
                                                        <td>
                                                            @php
                                                                $originalDate = $clina->fecha_entrega_recurso;
                                                                $newDate = date("d/m/Y", strtotime($originalDate));
                                                            @endphp
                                                            {{$newDate}}
                                                        </td>
                                                        <td>$ {{number_format($clina->cantidad,1)}}</td>
                                                        <td style="color:red;">
                                                            
                                                            $ {{number_format($saldo_naranja,1)}}
                                                        
                                                        </td>
                                                    </tr>
                                                    
                                                @endif --}}
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            @endif

                            @if (count($semana_amarillo)==0)
                                
                            @else         
                                @foreach ($semana_amarillo as $semana_a)
                                    @php
                                        $dias_transcurrido_am = $fecha_actual->diffInDays($semana_a->fecha_pago);

                                        $semanas_restantes=(14-$semana_a->semana)*7;
                                        $vencido=$semanas_restantes+45;
                                        
                                    @endphp
                                    
                                    @if ($dias_transcurrido_am>$vencido)
                                        {{-- Estado negro --}}
                                        @php
                                            $clienten = DB::table('tbl_prestamos')
                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                ->distinct()
                                                ->get();
                                        @endphp
                                        @foreach ($clienten as $clin)
                                            {{-- calculamos el saldo --}}
                                            @php
                                                $producto = DB::table('tbl_productos')   
                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                ->select('tbl_productos.*')
                                                ->where('tbl_prestamos.id_prestamo','=',$clin->id_prestamo)
                                                ->get();
                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                ->select('cantidad')
                                                ->where('id_prestamo','=',$clin->id_prestamo)
                                                ->get();
                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                ->where('id_tipoabono','=',1)
                                                ->get();
                                                $tipo_abono = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                ->where('id_tipoabono','=',2)
                                                ->get();
                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                ->where('id_tipoabono','=',3)
                                                ->get();
                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                ->where('id_tipoabono','=',4)
                                                ->get();
                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                        $multa1=0;
                                                    }else {
                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                    }
                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                ->where('id_tipoabono','=',5)
                                                ->get();
                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                        $multa2=0;
                                                    }else {
                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                    }
                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                
                                                
                                                //$t_semana_negra+=$semana_n->cantidad;
                                                $t_semana_negra+=$saldo_negro;
                                                $s_semana_negra+=$semana_a->cantidad;
                                                
                                            @endphp
                                            {{-- @if ($saldo_negro==0)
                                                
                                            @else
                                                <tr>
                                                    <td style="color: #000; background:black ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                    <td>{{$clin->nombre}} {{$clin->ap_paterno}} {{$clin->ap_materno}}</td>
                                                    <td>{{$clin->id_prestamo}}</td>
                                                    <td>
                                                        @php
                                                            $originalDate = $clin->fecha_entrega_recurso;
                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                        @endphp
                                                        {{$newDate}}
                                                    </td>
                                                    <td>$ {{number_format($clin->cantidad,1)}}</td>
                                                    <td style="color:red;">
                                                            
                                                            $ {{number_format($saldo_negro,1)}}
                                                    </td>
                                                </tr>
                                            @endif --}}
                                        @endforeach
                                        
                                    @elseif($dias_transcurrido_am<$vencido && $dias_transcurrido_am>=$semanas_restantes)
                                        {{-- Estado rojo --}}
                                        
                                        @php

                                            $cliente = DB::table('tbl_prestamos')
                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                ->distinct()
                                                ->get();
                                                // dd($dias_transcurrido_am);
                                        @endphp
                                        @foreach ($cliente as $cli)
                                            {{-- calculamos el saldo --}}
                                            @php
                                                $producto = DB::table('tbl_productos')   
                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                ->select('tbl_productos.*')
                                                ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                ->get();
                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                ->select('cantidad')
                                                ->where('id_prestamo','=',$cli->id_prestamo)
                                                ->get();
                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                ->where('id_tipoabono','=',1)
                                                ->get();
                                                $tipo_abono = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                ->where('id_tipoabono','=',2)
                                                ->get();
                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                ->where('id_tipoabono','=',3)
                                                ->get();
                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                ->where('id_tipoabono','=',4)
                                                ->get();
                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                        $multa1=0;
                                                    }else {
                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                    }
                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                ->where('id_tipoabono','=',5)
                                                ->get();
                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                        $multa2=0;
                                                    }else {
                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                    }
                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                
                                                //$t_semana_rojo+=$semana_n->cantidad;
                                                $t_semana_rojo+=$saldo_rojo;
                                                $s_semana_rojo+=$semana_a->cantidad;
                                                
                                            @endphp
                                            {{-- @if ($saldo_rojo==0)
                                                
                                            @else
                                                <tr>
                                                    <td style="color: red; background:red; margin: 3px; width: 20px; height: 15px;" >{{$dias_transcurrido_am}}</td>
                                                    <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                    <td>{{$cli->id_prestamo}}</td>
                                                    <td>
                                                        @php
                                                            $originalDate = $cli->fecha_entrega_recurso;
                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                        @endphp
                                                        {{$newDate}}
                                                    </td>
                                                    <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                    <td style="color:red;">
                                                            $ {{number_format($saldo_rojo,1)}}
                                                    </td>
                                                </tr>
                                                
                                            @endif --}}
                                        @endforeach
                                    @elseif($dias_transcurrido_am<$semanas_restantes && $dias_transcurrido_am>7)
                                            {{-- estatus a amarillo --}}
                                        @php
                                            //$t_semana_amarillo+=$abonos_in->cantidad;
                                            $clienteam = DB::table('tbl_prestamos')
                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                            ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                            ->distinct()
                                            ->get();
                                        @endphp
                                        @foreach ($clienteam as $cliam)
                                            {{-- calculamos el saldo --}}
                                            @php
                                                $producto = DB::table('tbl_productos')   
                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                ->select('tbl_productos.*')
                                                ->where('tbl_prestamos.id_prestamo','=',$cliam->id_prestamo)
                                                ->get();
                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                ->select('cantidad')
                                                ->where('id_prestamo','=',$cliam->id_prestamo)
                                                ->get();
                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                ->where('id_tipoabono','=',1)
                                                ->get();
                                                $tipo_abono = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                ->where('id_tipoabono','=',2)
                                                ->get();
                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                ->where('id_tipoabono','=',3)
                                                ->get();
                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                ->where('id_tipoabono','=',4)
                                                ->get();
                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                        $multa1=0;
                                                    }else {
                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                    }
                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                ->where('id_tipoabono','=',5)
                                                ->get();
                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                        $multa2=0;
                                                    }else {
                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                    }
                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                $saldo_amarillo=$sistema_total_cobrar-$cliente_pago;
                                                
                                                $t_semana_amarillo+=$saldo_amarillo;
                                                $s_semana_amarillo+=$semana_a->cantidad;
                                                
                                            @endphp
                                            {{-- @if ($saldo_amarillo==0)
                                                
                                            @else
                                                <tr>
                                                    <td style="color: yellow; background:yellow ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                    <td>{{$cliam->nombre}} {{$cliam->ap_paterno}} {{$cliam->ap_materno}}</td>
                                                    <td>{{$cliam->id_prestamo}}</td>
                                                    <td>
                                                        @php
                                                            $originalDate = $cliam->fecha_entrega_recurso;
                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                        @endphp
                                                        {{$newDate}}
                                                    </td>
                                                    <td>$ {{number_format($cliam->cantidad,1)}}</td>
                                                    <td style="color:red;">
                                                        
                                                        $ {{number_format($saldo_amarillo,1)}}
                                                    </td>
                                                </tr>
                                            @endif --}}
                                        @endforeach


                                    @elseif($dias_transcurrido_am<=7)
                                        @php
                                            $abonos_incumplimiento = DB::table('tbl_abonos')
                                            ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                            ->select('tbl_prestamos.id_prestamo as pp','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                            ->where('tbl_abonos.id_prestamo','=',$semana_a->id_prestamo)
                                            ->whereBetween('tbl_abonos.id_tipoabono', [4, 5])
                                            ->distinct()
                                            ->get();
                                        @endphp
                                        @if (count($abonos_incumplimiento)==0)
                                            
                                                @php
                                                    //$t_semana_verde+=$semana_a->cantidad;
                                                    $clientev = DB::table('tbl_prestamos')
                                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                            ->distinct()
                                                            ->get();
                                                @endphp
                                                @foreach ($clientev as $cliv)
                                                    {{-- calculamos el saldo --}}
                                                    @php
                                                        $producto = DB::table('tbl_productos')   
                                                        ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                        ->select('tbl_productos.*')
                                                        ->where('tbl_prestamos.id_prestamo','=',$cliv->id_prestamo)
                                                        ->get();
                                                        $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                        ->select('cantidad')
                                                        ->where('id_prestamo','=',$cliv->id_prestamo)
                                                        ->get();
                                                        $tipo_liquidacion = DB::table('tbl_abonos')
                                                        ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                        ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                        ->where('id_tipoabono','=',1)
                                                        ->get();
                                                        $tipo_abono = DB::table('tbl_abonos')
                                                        ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                        ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                        ->where('id_tipoabono','=',2)
                                                        ->get();
                                                        $tipo_ahorro = DB::table('tbl_abonos')
                                                        ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                        ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                        ->where('id_tipoabono','=',3)
                                                        ->get();
                                                        $tipo_multa_1 = DB::table('tbl_abonos')
                                                        ->select(DB::raw('count(*) as tipo_multa_1'))
                                                        ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                        ->where('id_tipoabono','=',4)
                                                        ->get();
                                                            if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                $multa1=0;
                                                            }else {
                                                                $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                            }
                                                        $tipo_multa_2 = DB::table('tbl_abonos')
                                                        ->select(DB::raw('count(*) as tipo_multa_2'))
                                                        ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                        ->where('id_tipoabono','=',5)
                                                        ->get();
                                                            if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                $multa2=0;
                                                            }else {
                                                                $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                            }
                                                        $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                        $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                        // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                        $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                        $s_multa2=$producto[0]->penalizacion*$multa2;
                                                        $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                        $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                        $saldo_verde=$sistema_total_cobrar-$cliente_pago;
                                                        
                                                        $t_semana_verde+=$saldo_verde;
                                                        $s_semana_verde+=$semana_a->cantidad;

                                                        
                                                    @endphp
                                                    {{-- @if ($saldo_verde==0)
                                                        
                                                    @else
                                                        <tr>
                                                            <td style="color: green; background:green ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                            <td>{{$cliv->nombre}} {{$cliv->ap_paterno}} {{$cliv->ap_materno}}</td>
                                                            <td>{{$cliv->id_prestamo}}</td>
                                                            <td>
                                                                @php
                                                                    $originalDate = $cliv->fecha_entrega_recurso;
                                                                    $newDate = date("d/m/Y", strtotime($originalDate));
                                                                @endphp
                                                                {{$newDate}}
                                                            </td>
                                                            <td>$ {{number_format($cliv->cantidad,1)}}</td>
                                                            <td style="color:red;">
                                                                
                                                                $ {{number_format($saldo_verde,1)}}
                                                                
                                                            </td>
                                                        </tr>
                                                    @endif --}}
                                                @endforeach
                                        @else
                                        
                                            @foreach ($abonos_incumplimiento as $abonos_in)
                                                
                                                    @php
                                                        //$t_semana_amarillo+=$abonos_in->cantidad;
                                                        $clienteam = DB::table('tbl_prestamos')
                                                        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                        ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                        ->where('tbl_prestamos.id_prestamo','=',$abonos_in->pp)
                                                        ->distinct()
                                                        ->get();
                                                    @endphp
                                                    @foreach ($clienteam as $cliam)
                                                        {{-- calculamos el saldo --}}
                                                        @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$cliam->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$cliam->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_amarillo=$sistema_total_cobrar-$cliente_pago;
                                                            
                                                            $t_semana_amarillo+=$saldo_amarillo;
                                                            $s_semana_amarillo+=$abonos_in->cantidad;
                                                            
                                                        @endphp
                                                        {{-- @if ($saldo_amarillo==0)
                                                            
                                                        @else
                                                            <tr>
                                                                <td style="color: yellow; background:yellow ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                <td>{{$cliam->nombre}} {{$cliam->ap_paterno}} {{$cliam->ap_materno}}</td>
                                                                <td>{{$cliam->id_prestamo}}</td>
                                                                <td>
                                                                    @php
                                                                        $originalDate = $cliam->fecha_entrega_recurso;
                                                                        $newDate = date("d/m/Y", strtotime($originalDate));
                                                                    @endphp
                                                                    {{$newDate}}
                                                                </td>
                                                                <td>$ {{number_format($cliam->cantidad,1)}}</td>
                                                                <td style="color:red;">
                                                                    
                                                                    $ {{number_format($saldo_amarillo,1)}}
                                                                </td>
                                                            </tr>
                                                        @endif --}}
                                                    @endforeach
                                                
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    @endforeach

                    @php
                        $prestamos=0;
                        $cobrado=0;
                        $vigente=$t_semana_verde+$t_semana_amarillo;
                        $vencido=$t_semana_morado+$t_semana_rojo+$t_semana_naranja;
                    @endphp
                   @foreach ($abonos_suma as $cobrado_total)
                       @php
                           $cobrado=$cobrado_total->total_abonos;
                       @endphp
                   
                   @endforeach
                   @foreach ($prestamos_suma as $p)
                       @php
                           $prestamoss=$p->total_prestamos;
                       @endphp
                   
                    @endforeach
        
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
        
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Estadística', 'general saldo'],
                ['',      {{$t_saldo_irrecuperable}}],
                ['',      {{$t_semana_negra}}],
                ['',      {{$t_semana_morado}}],
                ['',      {{$t_semana_rojo}}],
                ['',      {{$t_semana_naranja}}],
                ['',      {{$t_semana_amarillo}}],
                ['',      {{$t_semana_verde}}]
                ]);
        
                var options = {
                title: 'Gráfica general saldo',
                width: 370,
                colors: ['gray','black','purple','red','orange','yellow','green'],
                };
        
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
        
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Estadística', 'general préstamos'],
                
                ['',      {{$s_saldo_irrecuperable}}],
                ['',      {{$s_semana_negra}}],
                ['',      {{$s_semana_morado}}],
                ['',      {{$s_semana_rojo}}],
                ['',      {{$s_semana_naranja}}],
                ['',      {{$s_semana_amarillo}}],
                ['',      {{$s_semana_verde}}]
                ]);
        
                var options = {
                title: 'Gráfica general préstamos',
                width: 370,
                // bar: {groupWidth: "95%"},
                colors: ['gray','black','purple','red','orange','yellow','green'],
                };
        
                var chart = new google.visualization.PieChart(document.getElementById('piechart_prestamos'));
                chart.draw(data, options);
            }
        </script>
        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart1);
            function drawChart1() {
              var data = google.visualization.arrayToDataTable([
                ["Saldo", "Cantidad", { role: "style" } ],
                ["", {{$t_saldo_irrecuperable}}, "gray"],
                ["", {{$t_semana_negra }}, "black"],
                ["", {{ $t_semana_morado}}, "purple"],
                ["", {{$t_semana_rojo}}, "red"],
                ["", {{ $t_semana_naranja}}, "orange"],
                ["", {{$t_semana_amarillo}}, "yellow"],
                ["", {{ $t_semana_verde}}, "green"],
              ]);
        
              var view = new google.visualization.DataView(data);
              view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" },
                               2]);
        
              var options = {
                title: "Cantidades saldo",
                
                // bar: {groupWidth: "95%"},
                legend: { position: "none" },
              };
              var chart = new google.visualization.BarChart(document.getElementById("barchart_values1"));
              chart.draw(view, options);
          }
        </script>
        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart1);
            function drawChart1() {
              var data = google.visualization.arrayToDataTable([
                ["Préstamos", "Cantidad", { role: "style" } ],
                
                ["", {{$s_saldo_irrecuperable }}, "gray"],
                ["", {{$s_semana_negra }}, "black"],
                ["", {{$s_semana_morado}}, "purple"],
                ["", {{$s_semana_rojo}}, "red"],
                ["", {{$s_semana_naranja}}, "orange"],
                ["", {{$s_semana_amarillo}}, "yellow"],
                ["", {{$s_semana_verde}}, "green"],
              ]);
        
              var view = new google.visualization.DataView(data);
              view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" },
                               2]);
        
              var options = {
                title: "Cantidades préstamos",
                
                // bar: {groupWidth: "95%"},
                legend: { position: "none" },
              };
              var chart = new google.visualization.BarChart(document.getElementById("barchart_values_prestamos"));
              chart.draw(view, options);
          }
        </script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart2);
        
            function drawChart2() {
                var data = google.visualization.arrayToDataTable([
                ['Estadistica', 'general'],
                ['Vigente',      {{$vigente}}],
                ['Vencido',      {{$vencido}}]
                ]);
        
                var options = {
                title: 'Estadisticas general saldo',
                // width: 300,
                // height: 200,
                colors: ['#1F76FC','#B1B1B1'],
                };
        
                var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                chart.draw(data, options);
            }
        </script>
        
        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawCharts2);
            function drawCharts2() {
              var data = google.visualization.arrayToDataTable([
                ["Préstamos", "Cantidad", { role: "style" } ],
                ["Vigente",{{$vigente }}, "#1F76FC"],
                ["Vencido", {{ $vencido}}, "#B1B1B1"],
              ]);
        
              var view = new google.visualization.DataView(data);
              view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" },
                               2]);
        
              var options = {
                title: "Cantidades saldo",
                
                // bar: {groupWidth: "95%"},
                legend: { position: "none" },
              };
              var chart = new google.visualization.BarChart(document.getElementById("barchart_values2"));
              chart.draw(view, options);
          }
        </script>

        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ["Préstamos", "Cantidad", { role: "style" } ],
                    ["Préstamos",{{$prestamoss }}, "#008D8D"],
                    ["Cobrado", {{ $cobrado}}, "#00BF3D"],
                    // ["Incobrable", {{$t_semana_negra}}, "#DE1100"],
                    ["Irrecuperable", {{$s_saldo_irrecuperable}}, "gray"],
                    
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                { calc: "stringify",
                                    sourceColumn: 1,
                                    type: "string",
                                    role: "annotation" },
                                2]);

                var options = {
                    title: "Cantidades",
                    legend: { position: "none" },
                };
                var chart = new google.visualization.BarChart(document.getElementById("barchart_values3"));
                chart.draw(view, options);
            }
        </script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart3);
        
            function drawChart3() {
                var data = google.visualization.arrayToDataTable([
                ['Estadistica', 'general'],
                ['Préstamos',      {{$prestamoss}}],
                ['Cobrado',      {{$cobrado}}],
                // ['Incobrable',      {{$t_semana_negra}}]
                ['Irrecuperable',      {{$s_saldo_irrecuperable}}]
                
                ]);
        
                var options = {
                title: 'Estadisticas general',
               
                colors: ['#008D8D','#00BF3D','gray'],
                };
        
                var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
                chart.draw(data, options);
            }
        </script>
        {{-- <div class="row">
            <div class="col-md-12">
                <a href="{{url('pdf_estadisticas_general')}}">Imprimir PDF</a>
            </div>
        </div> --}}
        <div class="row">
            <div style="background: #fff; margin: 15px auto" class="col-md-11 mb-4">
                <div class="row">
                    <div class="col-md-12 mt-2" style="font-size: 11px; font-weight: 800">
                        <center>
                            <b>Significado</b>
                        </center>
                    </div>
                    <div class="col-md-6" style="font-size: 12px; margin-top: 5px"><span><i style="font-size: 18px; color: gray"  class="fas fa-dot-circle"></i></span> Irrecuperable.</div>
                    <div class="col-md-6" style="font-size: 12px; margin-top: 5px"><span><i style="font-size: 18px; color: orange" class="fas fa-dot-circle"></i></span> Menos de 45 días vencido con movimiento.</div>
                    <div class="col-md-6" style="font-size: 12px; margin-top: 5px"><span><i style="font-size: 18px; color: black"  class="fas fa-dot-circle"></i></span> Más de 45 días vencido sin movimiento.</div>
                    <div class="col-md-6" style="font-size: 12px; margin-top: 5px"><span><i style="font-size: 18px; color: purple" class="fas fa-dot-circle"></i></span> Más de 45 días vencido con movimiento.</div>
                    <div class="col-md-6" style="font-size: 12px; margin-top: 5px"><span><i style="font-size: 18px; color: yellow" class="fas fa-dot-circle"></i></span> Vigente con multas.</div>
                    <div class="col-md-6" style="font-size: 12px; margin-top: 5px"><span><i style="font-size: 18px; color: red"    class="fas fa-dot-circle"></i></span> Menos de 45 días vencido sin movimiento.</div>
                    <div class="col-md-6" style="font-size: 12px; margin-top: 5px"><span><i style="font-size: 18px; color: green"  class="fas fa-dot-circle"></i></span> Vigente todo bien.</div>

                </div>
                <br>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-5" id="piechart_prestamos" style="width: 100%; height: 100%;"></div>
            <div class="col-md-7" id="barchart_values_prestamos" style="width: 100%; height: 100%;"></div>
        </div>
        <div class="row">
            
            <div class="col-md-5" id="piechart" style="width: 100%; height: 100%;"></div>
            <div class="col-md-7" id="barchart_values1" style="width: 100%; height: 100%;"></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-5" id="piechart2" style="width: 100%; height: 100%;"></div>
            <div class="col-md-7" id="barchart_values2" style="width: 100%; height: 100%;"></div>

        </div>
        <div class="row mt-3">
            <div class="col-md-5" id="piechart3" style="width: 100%; height: 100%;"></div>
            <div class="col-md-7" id="barchart_values3" style="width: 100%; height: 100%;"></div>

        </div>
        <div class="row mt-3 mb-4">
            <div class="col-md-12">
                <a href="{{url('estadistica-zona')}}" class="btn btn-primary btn-block">Estadísticas por zona</a>
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
{{-- <script src="{{asset('assets/bundles/c3.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/charts/c3.js')}}"></script> --}}
@stop

