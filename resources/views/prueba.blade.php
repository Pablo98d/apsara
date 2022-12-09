@extends('layouts.master')
@section('title', 'Estadísticas por zona')
@section('parentPageTitle', 'Estadisticas')
@section('page-style')
{{-- <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/> --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@stop
@section('content')
    
    <div class="row">
        @foreach ($zonas as $zona)
            @php
                $prestamos_suma = DB::table('tbl_prestamos')
                ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
                ->join('tbl_zona','tbl_grupos.IdZona','tbl_zona.IdZona')
                ->select(DB::raw('SUM(cantidad) as total_prestamos'))
                ->where('tbl_zona.IdZona','=',$zona->IdZona)
                ->get();

                $abonos_suma = DB::table('tbl_abonos')
                ->join('tbl_prestamos','tbl_abonos.id_prestamo','tbl_prestamos.id_prestamo')
                ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
                ->join('tbl_zona','tbl_grupos.IdZona','tbl_zona.IdZona')
                ->select(DB::raw('SUM(tbl_abonos.cantidad) as total_abonos'))
                ->whereBetween('tbl_abonos.id_tipoabono',[2,3])
                ->where('tbl_zona.IdZona','=',$zona->IdZona)
                ->get();
            @endphp
            
            <div class="col-md-12 mt-4 mb-1">
                {{-- <div class="card-body"> --}}
                    @php
                        $id=$zona->IdZona;
                        $t_zona=$zona->Zona;

                        $prestamos_zonas= DB::table('tbl_prestamos')
                        ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
                        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
                        ->select('tbl_prestamos.*')
                        ->whereNotIn('tbl_prestamos.id_status_prestamo', [8, 6])
                        ->where('tbl_zona.IdZona','=',$id)
                        ->orderby('tbl_prestamos.id_prestamo','ASC')
                        ->get();

                        $ultimos_abonos = array();
                        if(count($prestamos_zonas)==0){

                        } else {
                            foreach ($prestamos_zonas as $prestamo_z) {

                                $abono_z = DB::table('tbl_abonos')
                                ->select('tbl_abonos.id_abono')
                                ->where('id_prestamo','=',$prestamo_z->id_prestamo)
                                ->orderby('semana','ASC')
                                ->get();
                                if(count($abono_z)==0){
                                
                                } else {
                                    array_push($ultimos_abonos, array(
                                        'id_prestamo' => $prestamo_z->id_prestamo, 
                                        'grupo' => $prestamo_z->id_grupo, 
                                        'cantidad' => $prestamo_z->cantidad, 
                                        'ultimo_abono' => $abono_z->last()->id_abono, 
                                        'id_status_prestamo' => $prestamo_z->id_status_prestamo
                                    ));
                                }
                                
                            }
                        }
                        $ultimos_abonos=json_encode($ultimos_abonos);
                        $ultimos_abonos=json_decode($ultimos_abonos);
                    @endphp

                    {{-- aqui empieza --}}
                    <div class="row mb-2">
                        <div class="col-md-4 estilo-tabla">
                            @php
                            
                            $t_semana_negra=0;
                            $t_semana_morado=0;
                            $t_semana_rojo=0;
                            $t_semana_naranja=0;
                            $t_semana_amarillo=0;
                            $t_semana_verde=0;
                            $t_saldo_irrecuperable=0;
                            // $ultimos_abonos=json_decode($ultimos_abonos);
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
                            
                                    {{-- @foreach ($ultimos_abonos as $ultimos_a)
                                        @php
                                            $semana_negra = DB::table('tbl_abonos')
                                            ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                            ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                            ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                                            ->where('tbl_abonos.semana','=',14)
                                            ->get();
                            
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
                            
                                        @endphp 
                            
                                        @if (count($semana_negra)==0)
                                            
                                        @else
                                            @foreach ($semana_negra as $semana_n)
                                            
                                                @php
                                                    $dias_transcurrido = $fecha_actual->diffInDays($semana_n->fecha_pago);
                                                @endphp
                                                @if ($dias_transcurrido<45)
                                                    <!--TODOS LOS QUE ESTAN EN ROJO-->
                                                    
                                                        @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_n->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$semana_n->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                         
                                                            $t_semana_rojo+=$saldo_rojo;
                                                            
                                                        @endphp
                                                        <!--<label for="">Id p {{$semana_n->id_prestamo}} / estatus {{$semana_n->id_status_prestamo}} / cantidad {{$semana_n->cantidad}} / dias  {{$dias_transcurrido}}</label><br>-->
                                                        
                                                   
                                                    
                                                @elseif($dias_transcurrido>45)
                                                    <!--TODOS LOS QUE ESTAN EN NEGRO-->
                                                        @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_n->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$semana_n->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $semana_n->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                            
                                                            //$t_semana_negra+=$semana_n->cantidad;
                                                            $t_semana_negra+=$saldo_negro;
                                                            
                                                        @endphp
                                                        <!--<label for="">Id p {{$semana_n->id_prestamo}} / estatus {{$semana_n->id_status_prestamo}} / cantidad {{$semana_n->cantidad}} / dias  {{$dias_transcurrido}}</label><br>-->
                                                        
                                                   
                                                @endif
                                                
                                            @endforeach
                                        @endif
                            
                            
                                            
                                        @if (count($semana_morado)==0)
                                            
                                        @else
                                            @foreach ($semana_morado as $semana_m)
                                                @php
                                                    $dias_transcurrido_m = $fecha_actual->diffInDays($semana_m->fecha_pago);
                                                @endphp
                                                @if ($dias_transcurrido_m>45)
                                                <!--TODOS LOS QUE ESTAN EN MORADO-->
                                                        
                                                            @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$semana_m->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_morado=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                             
                                                                $t_semana_morado+=$saldo_morado;
                                                            @endphp
                                                        
                                                        
                                                        
                                                @elseif($dias_transcurrido_m<45)
                                                    <!--TODOS LOS QUE ESTAN EN NARANJA-->
                                                   
                                                        <!--<label for="">Id p {{$semana_m->id_prestamo}} / estatus {{$semana_m->id_status_prestamo}} / cantidad {{$semana_m->cantidad}} / dias  {{$dias_transcurrido_m}}</label><br>-->
                                                        @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$semana_m->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $semana_m->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_naranja=$sistema_total_cobrar-$cliente_pago;
                                                        
                                                            $t_semana_naranja+=$saldo_naranja;
                                                        @endphp
                                                @endif
                                                    
                                            @endforeach
                                        @endif
                            
                                        @if (count($semana_amarillo)==0)
                                            
                                        @else
                                                        
                                            @foreach ($semana_amarillo as $semana_a)
                                                @php
                                                    $abonos_incumplimiento = DB::table('tbl_abonos')
                                                    ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                                    ->select('tbl_prestamos.id_prestamo','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                                    ->where('tbl_abonos.id_prestamo','=',$semana_a->id_prestamo)
                                                    ->whereBetween('tbl_abonos.id_tipoabono', [4, 5])
                                                    ->distinct()
                                                    ->get();
                                                @endphp
                                                @if (count($abonos_incumplimiento)==0)
                                                    <!--TODOS LOS QUE ESTAN EN VERDE-->
                                                    
                                                        @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$semana_a->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $semana_a->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $semana_a->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $semana_a->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $semana_a->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $semana_a->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_verde=$sistema_total_cobrar-$cliente_pago;
                                                            
                                                            $t_semana_verde+=$saldo_verde;
                                                        @endphp
                                                    
                                                @else
                                                    @foreach ($abonos_incumplimiento as $abonos_in)
                                                        <!--TODOS LOS QUE ESTAN EN AMARILLO-->
                                                        
                                                            <!--<label for="">Id p {{$abonos_in->id_prestamo}} / estatus {{$abonos_in->id_status_prestamo}} / cantidad {{$abonos_in->cantidad}}</label> amarillo<br> -->
                                                            @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$abonos_in->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$abonos_in->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $abonos_in->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $abonos_in->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $abonos_in->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $abonos_in->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $abonos_in->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_amarillo=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                
                                                                $t_semana_amarillo+=$saldo_amarillo;
                                                                
                                                            @endphp
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                        
                                    @endforeach --}}
                               
                            @php
                            
                            $prestamos_total=0;
                            $cobrado_total=0;
                            @endphp

                            @foreach ($prestamos_suma as $p_suma)
                                @php
                                    $prestamos_total+=$p_suma->total_prestamos;
                                @endphp
                            @endforeach
                            @foreach ($abonos_suma as $a_suma)
                                @php
                                    $cobrado_total+=$a_suma->total_abonos;
                                @endphp
                            @endforeach
                            @php
                                // $vigente=$t_semana_amarillo+$t_semana_verde;
                                // $vencido=$t_semana_naranja+$t_semana_rojo+$t_semana_morado;
                                // // $vencido_t=$t_semana_naranja+$t_semana_rojo+$t_semana_morado+$t_semana_negra;
                                // $vencido_t=$t_semana_naranja+$t_semana_rojo+$t_semana_morado;
                                // // dd($vencido_t);

                                // if ($prestamos_total==0) {
                                //     $actual=0;
                                //     $teorico=0;
                                //     $incobrable=$t_semana_negra;
                                // } else {
                                    
                                    

                                //     $a= $vigente+$vencido_t + $cobrado_total;

                                //     $b=$a-$prestamos_total;

                                //     $r_teorico= (($vigente+$vencido_t + $cobrado_total -$prestamos_total)*100)/$prestamos_total;


                                //     // $a=($vigente+$vencido_t)-$vencido_t;
                                //     // $b=$vigente+$vencido_t;

                                //     // $r_teorico= ($a*100)/$b;
            
                                //     // $actual=round(((($cobrado_total-$prestamos_total)/$prestamos_total)*100),0);
                                //     $actual=round(($cobrado_total-$prestamos_total)*100/$prestamos_total,0);
                                //     // $actual=round(((($cobrado_total-$prestamos_total)/$prestamos_total)*100),0);
                                //     $teorico=round(($r_teorico),0);
                                //     $incobrable=round((($t_semana_negra/$prestamos_total)*100),0);
                                // }
                            
                            @endphp
                            @php
                                $vigente=$t_semana_amarillo+$t_semana_verde;
                                // $vencido=$t_semana_naranja+$t_semana_rojo+$t_semana_morado;
                                $vencido_t=$t_semana_naranja+$t_semana_rojo+$t_semana_morado+$t_semana_negra;

                                $irrecuperable= $t_saldo_irrecuperable;

                                if ($prestamos_total==0) {
                                    $actual=0;
                                    $teorico=0;
                                    $irrecuperable=$t_saldo_irrecuperable;
                                } else {
                                    
                                    $r_teorico= (($vigente+$vencido_t + $cobrado_total -$prestamos_total)*100)/$prestamos_total;


                                    $actual=round(($cobrado_total-$prestamos_total)*100/$prestamos_total,0);
                                    // $actual=round(((($cobrado_total-$prestamos_total)/$prestamos_total)*100),0);
                                    $teorico=round(($r_teorico),0);
                                    $irrecuperable=round((($t_saldo_irrecuperable/$prestamos_total)*100),0);

                                    // $actual=round(((($cobrado_total-$prestamos_total)/$prestamos_total)*100),0);
                                    // $teorico=round(((($vigente+$vencido+$cobrado_total-$prestamos_total)/$prestamos_total)*100),0);
                                    // $incobrable=round((($t_semana_negra/$prestamos_total)*100),0);
                                }
                            
                            @endphp
                            {{-- aqui termina --}}
                            <style>
                                .encabezado-datos{
                                    /* background: blue; */
                                    border: solid 1px black;
                                    width: 100%;
                                    margin: 0 auto;
                                    text-align: center;
                                }
                                .cuerpo-datos{
                                    /* background: blue; */
                                    border: solid 1px black;
                                    border-top: 0;
                                    width: 100%;
                                    margin: 0 auto;
                                    text-align: right;
                                    font-size: 11px;
                                }
                                .fila-2{
                                    border: solid 1px black;
                                    width: 100%;
                                    margin: 0 auto;
                                    text-align: right;
                                    font-weight: 800;
                                    font-size: 11px;
                                }
                                .col-left{
                                    text-align: left;
                                }
                            </style>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row encabezado-datos">
                                        <div class="col-md-12 fila-1">
                                            <b>
                                                Zona {{$zona->Zona}}
                                            </b> 
                                        </div>
                                    </div>
                                    <div class="row cuerpo-datos">
                                        <div style="width: 100%; background: gray" class="col-md-5"></div>
                                        <div class="col-md-7"> $ {{number_format($t_saldo_irrecuperable,2)}}</div>
                                        <div style="width: 100%; background: black" class="col-md-5"></div>
                                        <div class="col-md-7"> $ {{number_format($t_semana_negra,2)}}</div>
                                        <div style="width: 100%; background: purple" class="col-md-5"></div>
                                        <div class="col-md-7"> $ {{number_format($t_semana_morado,2)}}</div>
                                        <div style="width: 100%; background: red" class="col-md-5"></div>
                                        <div class="col-md-7"> $ {{number_format($t_semana_rojo,2)}}</div>
                                        <div style="width: 100%; background: orange" class="col-md-5"></div>
                                        <div class="col-md-7"> $ {{number_format($t_semana_naranja,2)}}</div>
                                        <div style="width: 100%; background: yellow" class="col-md-5"></div>
                                        <div class="col-md-7">$ {{number_format($t_semana_amarillo,2)}}</div>
                                        <div style="width: 100%; background: green" class="col-md-5"></div>
                                        <div class="col-md-7">$ {{number_format($t_semana_verde,2)}}</div>
                                    </div>

                                    <div class="row fila-2 mb-1">
                                        <div class="col-md-6 col-left">Vigente</div>
                                        <div class="col-md-6">$ {{number_format($vigente,2)}}</div>
                                        <div class="col-md-6 col-left">Vencido</div>
                                        <div class="col-md-6">$ {{number_format($vencido_t,2)}}</div>
                                    </div>
                                    <div class="row fila-2 mb-1">
                                        <div class="col-md-6 col-left">Préstamos</div>
                                        <div class="col-md-6">$ {{number_format($prestamos_total,2)}}</div>
                                        <div class="col-md-6 col-left">Total cobrado</div>
                                        <div class="col-md-6">$ {{number_format($cobrado_total,2)}}</div>
                                    </div>
                                    <div class="row fila-2 mb-1">
                                        <div class="col-md-6 col-left">Actual</div>
                                        <div class="col-md-6">{{$actual}}%</div>
                                        <div class="col-md-6 col-left">Teórico</div>
                                        <div class="col-md-6">{{$teorico}}%</div>
                                        <div class="col-md-6 col-left">Irrecuperable</div>
                                        <div class="col-md-6">{{$irrecuperable}}%</div>
                                    </div>
                                    
                                    <script type="text/javascript">
                                        google.charts.load('current', {'packages':['corechart']});
                                        google.charts.setOnLoadCallback(drawChart{{$id}});
                                    
                                        function drawChart{{$id}}() {
                                            var data = google.visualization.arrayToDataTable([
                                            ['Estadistica', 'general'],
                                            
                                            ['',      {{$t_saldo_irrecuperable}}],
                                            ['',      {{$t_semana_negra}}],
                                            ['',      {{$t_semana_morado}}],
                                            ['',      {{$t_semana_rojo}}],
                                            ['',      {{$t_semana_naranja}}],
                                            ['',      {{$t_semana_amarillo}}],
                                            ['',      {{$t_semana_verde}}]
                                            ]);
                                    
                                            var options = {
                                            title: 'Estadisticas zona {{$t_zona}}',
                                            colors: ['gray','black','purple','red','orange','yellow','green'],
                                            chartArea: {'width': '90%', 'height': '85%'},
                                            legend: 'none'
                                            };
                                    
                                            var chart = new google.visualization.PieChart(document.getElementById('piechart{{$id}}'));
                                            chart.draw(data, options);
                                        }
                                    </script>
                                    <div id="piechart{{$id}}" style="width: 350px; height: 300px;"></div>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <style>
                                table{
                                    background: #fff;
                                    width: 90%;
                                    margin: 0 auto;
                                }
                                table th{
                                    font-size: 10px;
                                    padding: 0;
                                    margin: 0;
                                    background: blue;
                                    color: #fff;
                                    border: 1px solid black;
                                }
                                table td{
                                    border: 1px solid black;
                                    font-size: 10px;
                                    padding: 0;
                                    margin: 0;
                                }
                            </style>
                            <div class="col-md-12">
                                <center>
                                    <label style="font-size: 14px; font-weight: bold"  for="">
                                        Imprime los reportes por grupo de la zona {{$zona->Zona}}
                                    </label>
                                </center>
                            </div>
                            <div class="col-md-12">
                                @php
                                    $grupos = DB::table('tbl_grupos')
                                    // ->join('tbl_zona','tbl_grupos.IdZona','=','tbl_zona.IdZona')
                                    ->select('tbl_grupos.*')
                                    ->where('IdZona','=',$zona->IdZona)
                                    ->orderBy('grupo','ASC')
                                    ->get();
                                    
                                @endphp
                                    @foreach ($grupos as $grupo)
                                    
                                        <a style="
                                        float: left; 
                                        width: auto; 
                                        height: 30px; 
                                        background: #fff; 
                                        border: solid rgb(180, 180, 180) 1px; 
                                        border-radius: 5px;
                                        padding: 3px; 
                                        padding-left: 7px; 
                                        padding-right: 7px; 
                                        margin: 5px;
                                        color: rgb(212, 34, 34);
                                        font-size: 14px;
                                        font-weight: bolder;"
                                        href="{{url('reporte_general_grupo/'.$grupo->id_grupo)}}" target="_reporte">
                                            {{$grupo->grupo}} <i class="far fa-file-pdf"></i>
                                        </a>
                                    
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
            <div class="col-md-12">
                {{-- <a href="#" onclick="print()">Imprimir</a> --}}
                <hr>
            </div>
        @endforeach
    </div>
    
@stop
@section('page-script')
<script>
    window.onload = function agregar_boton_atras(){
      document.getElementById('Atras').innerHTML='<a href="{{route('estadisticas')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  }
</script>

@stop

