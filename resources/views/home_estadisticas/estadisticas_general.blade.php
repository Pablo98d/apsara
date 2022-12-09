<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pdf estadísticas general</title>
    <style>
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    {{-- <div class="row"> --}}
        
                @php
                    $contador=0;
                @endphp
                @foreach ($zonas as $zona)
                    @php
                        $contador+=1;
                    @endphp
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
                    
                    {{-- <div class="col-md-12 mt-4 mb-1"> --}}
                        {{-- <div class="card-body"> --}}
                            @php
                                $t_semana_negra=0;
                                $t_semana_morado=0;
                                $t_semana_rojo=0;
                                $t_semana_naranja=0;
                                $t_semana_amarillo=0;
                                $t_semana_verde=0;
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
                            {{-- <div class="row mb-2"> --}}
                                {{-- <div class="col-md-4 estilo-tabla"> --}}
                                            @foreach ($ultimos_abonos as $ultimos_a)
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
                                                
                                            @endforeach
                                        </tbody>
                                    </table>
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
                                        $vigente=$t_semana_amarillo+$t_semana_verde;
                                        $vencido=$t_semana_naranja+$t_semana_rojo+$t_semana_morado;

                                        if ($prestamos_total==0) {
                                            $actual=0;
                                            $teorico=0;
                                            $incobrable=$t_semana_negra;
                                        } else {
                                            
                    
                                            $actual=round(((($cobrado_total-$prestamos_total)/$prestamos_total)*100),0);
                                            $teorico=round(((($vigente+$vencido+$cobrado_total-$prestamos_total)/$prestamos_total)*100),0);
                                            $incobrable=round((($t_semana_negra/$prestamos_total)*100),0);
                                        }
                                    
                                    @endphp
                                    {{-- aqui termina --}}
                                    
                                    {{-- <div class="row"> --}}
                                        
                                        <table>
                                            
                                            <tbody>
                                                <tr>
                                                    <td style="width: 200px">
                                                        {{-- <div > --}}
                                                            <div style="margin-top: 10px">
                                                                    
                                                                    <div style="border: solid 1px black; padding: 3px;">
                                                                        <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: black"></div>
                                                                        <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;"> $ {{number_format($t_semana_negra,2)}}</div><br>
                                                                        <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: purple"></div>
                                                                        <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;"> $ {{number_format($t_semana_morado,2)}}</div><br>
                                                                        <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: red"></div>
                                                                        <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;"> $ {{number_format($t_semana_rojo,2)}}</div><br>
                                                                        <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: orange"></div>
                                                                        <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;"> $ {{number_format($t_semana_naranja,2)}}</div><br>
                                                                        <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: yellow"></div>
                                                                        <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;">$ {{number_format($t_semana_amarillo,2)}}</div><br>
                                                                        <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: green"></div>
                                                                        <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;">$ {{number_format($t_semana_verde,2)}}</div><br>
                                                                    </div>
                                                
                                                                    <div style="padding: 2px; margin-top: 3px; border: black solid 1px">
                                                                        <div style="font-size: 12px;  width: 50%; float: left;">Vigente</div>
                                                                        <div style="font-size: 12px;  width: 50%; float: right; text-align: right">$ {{number_format($vigente,2)}}</div><br>
                                                                        <div style="font-size: 12px;  width: 50%; float: left;">Vencido</div>
                                                                        <div style="font-size: 12px;  width: 50%; float: right; text-align: right">$ {{number_format($vencido,2)}}</div><br>
                                                                    </div>
                                                                    <div style="padding: 2px; margin-top: 3px; border: solid black 1px">
                                                                        <div style="font-size: 12px;  width: 50%; float: left;">Préstamos</div>
                                                                        <div style="font-size: 12px;  width: 50%; float: right; text-align: right">$ {{number_format($prestamos_total,2)}}</div><br>
                                                                        <div style="font-size: 12px;  width: 50%; float: left;">Total cobrado</div>
                                                                        <div style="font-size: 12px;  width: 50%; float: right; text-align: right">$ {{number_format($cobrado_total,2)}}</div><br>
                                                                    </div>
                                                                    <div style="padding: 2px; margin-top: 3px; border: solid black 1px">
                                                                        <div style="font-size: 12px;  width: 50%; float: left;">Actual</div>
                                                                        <div style="font-size: 12px;  width: 50%; float: right; text-align: right">{{$actual}}%</div><br>
                                                                        <div style="font-size: 12px;  width: 50%; float: left;">Teórico</div>
                                                                        <div style="font-size: 12px;  width: 50%; float: right; text-align: right">{{$teorico}}%</div><br>
                                                                        <div style="font-size: 12px;  width: 50%; float: left;">Incobrable</div>
                                                                        <div style="font-size: 12px;  width: 50%; float: right; text-align: right">{{$incobrable}}%</div><br>
                                                                    </div>
                                                                    
                                                                    
                                                            
                                                            </div>
                                                        {{-- </div> --}}
                                                    </td>
                                                    <td style="width: 700px">
                                                        <img src="https://quickchart.io/chart?c={
                                                            type:'pie',
                                                            data:{
                                                                labels:['January','February', 'March','April', 'May'], 
                                                                datasets:[{
                                                                    backgroundColor: ['black', 'purple', 'red','orange', 'yellow', 'green'],
                                                                    data:[{{$t_semana_negra}},{{$t_semana_morado}},{{$t_semana_rojo}},{{$t_semana_naranja}},{{$t_semana_amarillo}},{{$t_semana_verde}}]
                                                                }]
                                                                
                                                            },
                                                            options: {
                                                                plugins: {
                                                                  
                                                                  
                                                                  
                                                                },
                                                                plugins: {
                                                                    legend: false,
                                                                    datalabels: {
                                                                      display: true,
                                                                      
                                                                      color: 'white',
                                                                      font: {
                                                                        size: 14,
                                                                        weight: 'bold'
                                                                      }
                                                                    },
                                                                  }
                                                            }
                                                        }" width="550">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                       
                                            
                                        
                                            
                                        

                                        




                                    {{-- </div> --}}
                                {{-- </div> --}}
                                
                            {{-- </div> --}}
                            
                            
                        {{-- </div> --}}
                    {{-- </div> --}}
                    {{-- <div class="col-md-12">
                        <a href="#" onclick="print()">Imprimir</a>
                        <hr>
                    </div> --}}
                    @if ($contador==3)
                        <div class="page-break"></div>
                    @elseif ($contador==6)
                        <div class="page-break"></div>
                    @elseif ($contador==9)
                        <div class="page-break"></div>
                    @elseif ($contador==12)
                        <div class="page-break"></div>
                    @elseif ($contador==15)
                        <div class="page-break"></div>
                    @elseif ($contador==18)
                        <div class="page-break"></div>
                    @elseif ($contador==21)
                        <div class="page-break"></div>
                    @elseif ($contador==24)
                        <div class="page-break"></div>
                    @elseif ($contador==27)
                        <div class="page-break"></div>
                    @elseif ($contador==30)
                        <div class="page-break"></div>
                    @elseif ($contador==33)
                        <div class="page-break"></div>
                    @elseif ($contador==36)
                        <div class="page-break"></div>
                    @elseif ($contador==39)
                        <div class="page-break"></div>
                    @elseif ($contador==42)
                        <div class="page-break"></div>
                    @elseif ($contador==45)
                        <div class="page-break"></div>
                    @elseif ($contador==48)
                        <div class="page-break"></div>
                    @elseif ($contador==51)
                        <div class="page-break"></div>
                    @elseif ($contador==54)
                        <div class="page-break"></div>
                    @elseif ($contador==57)
                        <div class="page-break"></div>
                    @elseif ($contador==60)
                        <div class="page-break"></div>
                    @else
                        
                    @endif
                    
            
                @endforeach
            
    {{-- </div> --}}
    


        {{-- <img src="https://quickchart.io/chart?c={type:'pie',data:{labels:['January','February', 'March','April', 'May'], datasets:[{data:[50,60,70,180,190]}]}}" width="300px"> --}}

    {{-- <img src="https://quickchart.io/chart?c={type:'bar',data:{labels:[2012,2013,2014,2015,2016],datasets:[{label:'Users',data:[120,60,50,180,120]}]}}" alt=""> --}}
</body>
</html>