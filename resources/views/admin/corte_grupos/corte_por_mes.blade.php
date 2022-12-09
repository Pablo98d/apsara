@extends('layouts.master')
@section('title', 'Listado de multas - haciendo corte')
@section('parentPageTitle', 'Abonos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estilo_ayuda.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
@stop
@section('content')
<hr>
    <div class="row">
        @if ( session('status') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"></span>
                </button>
            </div>
        @endif
        <div class="col-md-12">
                <h4><b>
                    Corte en general
                    </b>
                </h4> 
                <hr>
                {{-- @php
                
                @endphp --}}
            <form action="{{url('guardar-multas')}}" method="post">
                @csrf
                @foreach ($dias_corte as $key => $value)
                    {{-- cambiar despues --}}
                        @php
                            $dia_de_corte=$value;
                            $hoy_dia= $f_actual->format('D');
                        @endphp

                        @if ($hoy_dia=='Mon')

                            

                            {{-- cambiar despues --}}

                            {{-- @if($value=='Domingo') 
                                @php
                                    
                                    $fecha=$f_actual->subDay(1);    
                                @endphp
                            @endif  --}}


                            @if ($value=='Sabado')
                                @php
                                    $fecha=$f_actual->subDay(1);
                                @endphp    
                                
                            @elseif ($value=='Viernes')
                                @php
                                    $fecha=$f_actual->subDay(2);
                                @endphp    
                                
                            @elseif ($value=='Jueves')
                                @php
                                    $fecha=$f_actual->subDay(3);
                                @endphp    
                                
                            @elseif($value=='Miercoles')
                                @php
                                    $fecha=$f_actual->subDay(4);
                                @endphp    

                            @elseif($value=='Martes')
                                @php
                                    $fecha=$f_actual->subDay(5);
                                @endphp    

                            @elseif($value=='Lunes')
                                @php
                                    $fecha=$f_actual->subDay(6);
                                @endphp    
                            
                            @elseif($value=='Domingo')
                                @php
                                    $fecha=$f_actual->subDay(7);
                                @endphp    

                            @endif 
                    
                        @elseif ($hoy_dia=='Tue')

                            @if($value=='Lunes')
                                @php
                                    $fecha=$f_actual->subDay(1);
                                @endphp
                            @elseif($value=='Domingo')
                                @php
                                    $fecha=$f_actual->subDay(2);
                                @endphp
                            @endif 
                            
                        @elseif ($hoy_dia=='Wed') 

                            @if($value=='Martes') 
                                @php
                                    $fecha=$f_actual->subDay(1);
                                @endphp
                            @elseif($value=='Lunes') 
                                @php
                                    $fecha=$f_actual->subDay(2);
                                @endphp
                            @elseif($value=='Domingo') 
                                @php
                                    $fecha=$f_actual->subDay(3);
                                @endphp
                            @endif 
                            
                        @elseif ($hoy_dia=='Thu')

                            @if($value=='Miercoles')
                                @php
                                    $fecha=$f_actual->subDay(1);
                                @endphp    
                            @elseif($value=='Martes')
                                @php
                                    $fecha=$f_actual->subDay(2);
                                @endphp    
                            @elseif($value=='Lunes')
                                @php
                                    $fecha=$f_actual->subDay(3); 
                                @endphp    
                            @elseif($value=='Domingo')
                                @php
                                    $fecha=$f_actual->subDay(4);
                                @endphp    
                            @endif 
                            
                        @elseif ($hoy_dia=='Fri')

                            @if ($value=='Jueves')
                                @php
                                    $fecha=$f_actual->subDay(1);
                                @endphp    
                            @elseif($value=='Miercoles')
                                @php
                                    $fecha=$f_actual->subDay(2);
                                @endphp    
                            @elseif($value=='Martes')
                                @php
                                    $fecha=$f_actual->subDay(3);
                                @endphp    
                            @elseif($value=='Lunes')
                                @php
                                    $fecha=$f_actual->subDay(4);
                                @endphp    
                            @elseif($value=='Domingo')
                                @php
                                    $fecha=$f_actual->subDay(5);
                                @endphp    
                            @endif 
                            
                        @elseif($hoy_dia=='Sat')
                            @if ($value=='Viernes')
                                @php
                                    $fecha=$f_actual->subDay(1);
                                @endphp    
                                
                            @elseif ($value=='Jueves')
                                @php
                                    $fecha=$f_actual->subDay(2);
                                @endphp    
                                
                            @elseif($value=='Miercoles')
                                @php
                                    $fecha=$f_actual->subDay(3);
                                @endphp    
                            @elseif($value=='Martes')
                                @php
                                    $fecha=$f_actual->subDay(4);
                                @endphp    
                            @elseif($value=='Lunes')
                                @php
                                    $fecha=$f_actual->subDay(5);
                                @endphp    
                            
                            @elseif($value=='Domingo')
                                @php
                                    $fecha=$f_actual->subDay(6);
                                @endphp    
                            @endif 
                        @elseif($hoy_dia=='Sun')
                            
                            @if ($value=='Sabado')
                                @php
                                    $fecha=$f_actual->subDay(1);
                                @endphp    
                                
                            @elseif ($value=='Viernes')
                                @php
                                    $fecha=$f_actual->subDay(2);
                                @endphp    
                                
                            @elseif ($value=='Jueves')
                                @php
                                    $fecha=$f_actual->subDay(3);
                                @endphp    
                                
                            @elseif($value=='Miercoles')
                                @php
                                    $fecha=$f_actual->subDay(4);
                                @endphp    

                            @elseif($value=='Martes')
                                @php
                                    $fecha=$f_actual->subDay(5);
                                @endphp    

                            @elseif($value=='Lunes')
                                @php
                                    $fecha=$f_actual->subDay(6);
                                @endphp    
                            
                            @elseif($value=='Domingo')
                                @php
                                    $fecha=$f_actual->subDay(7);
                                @endphp    

                            @endif 
                        @endif

                        @php
                            $fecha_pasado= $fecha->format('Y-m-d');

                            $corte = DB::table('tbl_corte')
                            ->select('tbl_corte.*')
                            ->where('nombre_dia','=',$value)
                            ->get();
                        @endphp
                        

                        {{-- <b>dia de corte: {{$value}}</b><br>
                        <label for="">fecha del mismo dia: {{$fecha_pasado}}</label><br><br> --}}
                        {{-- {{$corte}} --}}
                        @if (count($corte)==0)
                        {{-- return back()->with('status', '¡No hay corte para este dia!'); --}}
                        {{-- return back()->with('status', '¡No hay corte para este dia!'); --}}
                        <div class="row mt-2 mb-2">
                            <div class="col-md-11">
                                <hr>
                                <span class="badge badge-pill badge-warning">No hay corte para el día pasado {{$value}} {{$fecha_pasado}}</span>
                                
                                <hr>
                            </div>
                        </div>

                        @else
                            {{-- {{$corte}} --}}
                                @php
                                    $saldo_a_favor=0;
                                    $multa1=0;
                                @endphp
                                <div class="row">
                                    <div class="col-md-11" style="background: blue;">
                                        <input style="font-size: 10px; background: transparent; border: transparent; color: #fff; text-align: center;  width: auto;" type="text" value="Grupo" readonly>
                                        <input style="font-size: 10px; background: transparent; border: transparent; color: #fff; text-align: center;  width: auto;" type="text" value="Día" readonly>
                                        <input style="font-size: 10px; background: transparent; border: transparent; color: #fff; text-align: center;  width: auto;" type="text" value="No. Préstamo" readonly>
                                        <input style="font-size: 10px; background: transparent; border: transparent; color: #fff; text-align: center;  width: auto;" type="text" value="Status" readonly>
                                        <input style="font-size: 10px; background: transparent; border: transparent; color: #fff; text-align: center;  width: auto;" type="text" value="Semana" readonly>
                                        <input style="font-size: 10px; background: transparent; border: transparent; color: #fff; text-align: center;  width: auto;" type="text" value="Fecha" readonly>
                                        <input style="font-size: 10px; background: transparent; border: transparent; color: #fff; text-align: center;  width: auto;" type="text" value="T. Abono" readonly>
                                        <hr style="margin: 3px; padding: 0">
                                    </div>
                                </div>
                                @foreach ($corte as $cor)
                                        @php
                                        $ultimos_abonoac = DB::table('v_estadisticas')
                                        ->select('v_estadisticas.*')
                                        ->where('grupo','=',$cor->id_grupo)
                                        ->get();
                                            
                                        @endphp
                                        {{-- <b>{{$ultimos_abonoac}}</b> --}}
                                        @if (count($ultimos_abonoac)==0)
                                            <center>
                                                No hay datos de préstamos y abonos. <br><br><hr>
                                            </center>
                                        @else
                                            @php
                                                $grupo = DB::table('tbl_grupos')
                                                ->select('tbl_grupos.grupo')
                                                ->where('id_grupo','=',$cor->id_grupo)
                                                ->get();
                                            @endphp
                                            
                                            @foreach ($ultimos_abonoac as $value)
                                                @php
                                                    $prestamo_activo = DB::table('tbl_prestamos')
                                                    ->join('tbl_abonos','tbl_prestamos.id_prestamo','tbl_abonos.id_prestamo')
                                                    ->select('tbl_prestamos.*','tbl_abonos.*')
                                                    ->where('tbl_abonos.id_abono','=',$value->ultimo_abono)
                                                    ->where('tbl_prestamos.id_status_prestamo','=',2)
                                                    ->get();
                                                @endphp
                                                {{-- <br><b>kkk {{$prestamo_activo}}</b><br> --}}
                                                @if (count($prestamo_activo)==0)
                                                    {{-- // dd('no hay datos'); --}}
                                                @else
                                                    @foreach ($prestamo_activo as $p_activo)
                                                    {{-- <br><b>Fecha de ultimo pago{{$p_activo->fecha_pago}}</b><br>
                                                        <br><label for="">fecha del mismo dia: {{$fecha}}</label> --}}
                                                        @php
                                                            $fecha_a_existente = $p_activo->fecha_pago;
                                                            $array = str_split($fecha_a_existente);
                                                            $fecha_listo = $array[0].$array[1].$array[2].$array[3].$array[4].$array[5].$array[6].$array[7].$array[8].$array[9];
                                                            $dias_pasados = $fecha->diffInDays($fecha_listo);
                                                            $cantidad_semanas=round(($dias_pasados/7),0);
                                                            $cantidad_semanas_mostrar=round(($dias_pasados/7),1);

                                                            $semana=$p_activo->semana;
                                                            // $promedioGeneral = round($promedioGeneral,2);
                                                        @endphp
                                                            {{-- <br><label for="">Cantidad de semanas: {{$cantidad_semanas}}</label><br> --}}
                                                            {{-- <br>{{$cantidad_semanas_mostrar}}<br> --}}
                                                                @php
                                                                    $cantidad_dias=$cantidad_semanas*7;
                                                                    
                                                                    $fecha_menos_dias=date("Y-m-d",strtotime($fecha_pasado."-".$cantidad_dias." days"));
                                                                @endphp
                                                                {{-- <br><label for="">fecha mesnos dias: {{$fecha_menos_dias}}</label><br>
                                                                <label for="">fecha de hoy: {{$fecha_pasado}}</label><br> --}}
                                                                {{-- Aqui buscamos si ya abonaron en la fecha que le tocaba --}}
                                                                @if ($fecha_menos_dias==$fecha_listo)
                                                                    {{-- <br><b>ya encontre el abono</b> --}}
                                                                @else

                                                                    {{-- aqui buscamos en los dias de la semana para ver si anticiparon el abono --}}
                                                                    @php
                                                                        $fecha_de_pago='0000-00-00';
                                                                    @endphp

                                                                    @for ($i = 1; $i <= $cant_dias; $i++)
                                                                        @php
                                                                            $dia_a_buscar=date("Y-m-d",strtotime($fecha_menos_dias."-".$i." days"));
                                                                        @endphp
                                                                        @if ($dia_a_buscar==$fecha_listo)
                                                                            {{-- <label for="">ya encontre la fecha que se pagó {{$dia_a_buscar}}</label> --}}
                                                                            @php
                                                                                $fecha_de_pago=$dia_a_buscar;
                                                                            @endphp
                                                                        @else

                                                                        @endif
                                                                    @endfor
                                                                    {{-- --------------- --}}

                                                                    {{-- aqui verificamos si hay saldo a favor --}}
                                                                    @if ($fecha_de_pago=='0000-00-00')
                                                                        @for ($i = 0; $i <$cantidad_semanas; $i++)
                                                                            {{-- <br>fecha listo: {{$fecha_listo}}<br> --}}
                                                                            @php
                                                                                $cantidad_dias=$i*7;
                                                                                $fecha_actualizado=date("Y-m-d",strtotime($fecha_menos_dias."+ ".$cantidad_dias." days"));
                                                                                $semana=$p_activo->semana+1+$i;

                                                                                $status_press = DB::table('tbl_prestamos')
                                                                                ->select('tbl_prestamos.*')
                                                                                ->where('id_prestamo','=',$p_activo->id_prestamo)
                                                                                ->where('id_status_prestamo','=',2)
                                                                                ->get();
                                                                                $contarp=count($status_press);

                                                                            @endphp

                                                                            {{-- <label for="">fecha actualizado3: {{$fecha_actualizado}}</label><br> --}}

                                                                            @if ($contarp==0)
                                                                                $ {{$saldo_a_favor=0}}.00
                                                                            {{-- $ 0.00 --}}
                                                                            @else
                                                                                @php
                                                                                    $producto = DB::table('tbl_productos')   
                                                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                                    ->select('tbl_productos.*')
                                                                                    ->where('tbl_prestamos.id_prestamo','=',$status_press[0]->id_prestamo)
                                                                                    ->get();
                                                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                                    ->select('cantidad')
                                                                                    ->where('id_prestamo','=',$status_press[0]->id_prestamo)
                                                                                    ->get();
                                                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                                    ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                    ->where('id_tipoabono','=',1)
                                                                                    ->get();
                                                                                    $tipo_abono = DB::table('tbl_abonos')
                                                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                                    ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                    ->where('id_tipoabono','=',2)
                                                                                    ->get();
                                                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                                    ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                    ->where('id_tipoabono','=',3)
                                                                                    ->get();

                                                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                                

                                                                                    
                                                                                        $c_liquidacion = DB::table('tbl_abonos')
                                                                                        ->select(DB::raw('count(*) as c_liquidacion'))
                                                                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                        ->where('id_tipoabono','=',1)
                                                                                        ->get();

                                                                                        $c_abono = DB::table('tbl_abonos')
                                                                                        ->select(DB::raw('count(*) as c_abono'))
                                                                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                        ->where('id_tipoabono','=',2)
                                                                                        ->get();
                                                                                        $c_ahorro = DB::table('tbl_abonos')
                                                                                        ->select(DB::raw('count(*) as c_ahorro'))
                                                                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                        ->where('id_tipoabono','=',3)
                                                                                        ->get();

                                                                                        $c_papeleo = DB::table('tbl_abonos')
                                                                                        ->select(DB::raw('count(*) as c_papeleo'))
                                                                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                        ->where('id_tipoabono','=',2)
                                                                                        ->where('semana','=',0)
                                                                                        ->get();

                                                                                        $minimo_pago=($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad;
                                                                                        $papeleria=($producto[0]->papeleria/100)*$cantidad_prestamo[0]->cantidad;

                                                                                        $st_papeleo=$c_papeleo[0]->c_papeleo*$papeleria;
                                                                                        $st_liquidacion=$c_liquidacion[0]->c_liquidacion*$minimo_pago;
                                                                                        $st_abono=($c_abono[0]->c_abono-$c_papeleo[0]->c_papeleo)*$minimo_pago;
                                                                                        $st_ahorro=$c_ahorro[0]->c_ahorro*$minimo_pago;

                                                                                        $calculo_sistema=$st_liquidacion+$st_abono+$st_ahorro+$st_papeleo;

                                                                                        $saldo_a_favor=$cliente_pago-$calculo_sistema;

                                                                                @endphp

                                                                                {{-- Aqui preguntamos si hay saldo a favor --}}
                                                                                @if ($saldo_a_favor>=$minimo_pago)
                                                                                    {{-- ya se abonó --}}
                                                                                @else
                                                                                    @php
                                                                                        $productor = DB::table('tbl_productos')
                                                                                        ->select('tbl_productos.ultima_semana')
                                                                                        ->where('id_producto','=',$p_activo->id_producto)
                                                                                        ->get();
                                        
                                                                                        $multasr = DB::table('tbl_penalizacion')
                                                                                        ->select('tbl_penalizacion.*')
                                                                                        ->where('id_prestamo','=',$p_activo->id_prestamo)
                                                                                        ->get();
                                                                                    @endphp
                                                                                    @if ($semana>$productor[0]->ultima_semana)
                                                                                
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$p_activo->id_prestamo}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Activo">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{2}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    
                                                                                    @else
                                                                                        @if (count($multasr)==0)
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$p_activo->id_prestamo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Activo">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{4}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        
                                                                                        @else
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$p_activo->id_prestamo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Activo">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{5}}">
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                        @endif
                                                                                        
                                                                                    @endif

                                                                                @endif
                                                                                {{-- --------- --}}
                                                                            
                                                                            @endif


                                                                        @endfor
                                                                    @else
                                                                        @php
                                                                            
                                                                        @endphp
                                                                        {{-- <br><h3>Ya pagaron {{$fecha_de_pago}}</h3><br> --}}
                                                                        {{-- <b>{{$cantidad_semanas}}</b> --}}
                                                                        @if ($cantidad_semanas>0)
                                                                            @for ($i = 0; $i <$cantidad_semanas; $i++)
                                                                                {{-- <br>fecha listo: {{$fecha_listo}}<br> --}}
                                                                                @php
                                                                                    $cantidad_dias=$i*7;
                                                                                    $fecha_actualizado=date("Y-m-d",strtotime($fecha_menos_dias."+ ".$cantidad_dias." days"));
                                                                                    $semana=$p_activo->semana+1+$i;

                                                                                @endphp

                                                                                    {{-- <label for="">fecha actualizado3: {{$fecha_actualizado}}</label><br> --}}

                                                                        
                                                                                    @php
                                                                                        $productor = DB::table('tbl_productos')
                                                                                        ->select('tbl_productos.ultima_semana')
                                                                                        ->where('id_producto','=',$p_activo->id_producto)
                                                                                        ->get();
                                        
                                                                                        $multasr = DB::table('tbl_penalizacion')
                                                                                        ->select('tbl_penalizacion.*')
                                                                                        ->where('id_prestamo','=',$p_activo->id_prestamo)
                                                                                        ->get();
                                                                                    @endphp
                                                                                    @if ($semana>$productor[0]->ultima_semana)
                                                                                
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$p_activo->id_prestamo}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Activo">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{2}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    
                                                                                    @else
                                                                                        @if (count($multasr)==0)
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$p_activo->id_prestamo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Activo">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{4}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        
                                                                                        @else
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$p_activo->id_prestamo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Activo">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{5}}">
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                        @endif
                                                                                        
                                                                                    @endif

                                                                                    {{-- --------- --}}
                                                                                
                                                                                


                                                                            @endfor
                                                                        @else
                                                                            {{-- pago anticipado --}}
                                                                        @endif
                                                                            

                                                                        {{-- <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$p_activo->id_prestamo}}">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}"><br> --}}
                                                                    @endif
                                                                @endif
                                                        
                                                    @endforeach
                                                @endif

                                                
                                                
                                            @endforeach
                                            
                                        @endif
                                        
                                        {{-- verificando abonos de renovaciones --}}
                                        @php
                                        $ultimos_abonore = DB::table('v_estadisticas')
                                        ->select('v_estadisticas.*')
                                        ->where('grupo','=',$cor->id_grupo)
                                        ->get();
                                        @endphp

                                        @foreach ($ultimos_abonore as $abono_re)
                                            @php
                                                // aqui empieza los de renovados
                                                $prestamo_renovados = DB::table('tbl_prestamos')
                                                ->join('tbl_abonos','tbl_prestamos.id_prestamo','tbl_abonos.id_prestamo')
                                                ->select('tbl_prestamos.*','tbl_abonos.*')
                                                ->where('tbl_abonos.id_abono','=',$abono_re->ultimo_abono)
                                                ->where('tbl_prestamos.id_status_prestamo','=',9)
                                                ->get();
                                            @endphp

                                            @if (count($prestamo_renovados)==0)
                                            {{-- <label for="">no hay datos prestamos renovados</label><br> --}}
                                            @else
                                                @foreach ($prestamo_renovados as $prestamo_r)
                                                    @php
                                                        $prestamo_en_espera = DB::table('tbl_prestamos')
                                                        ->select('tbl_prestamos.*')
                                                        ->where('id_usuario','=',$prestamo_r->id_usuario)
                                                        ->whereBetween('tbl_prestamos.id_status_prestamo', [9, 10])
                                                        ->distinct()
                                                        ->get();
                                                        $pr=count($prestamo_en_espera);
                                                    @endphp
                                                    @if ($pr>=2)
                                                    @elseif($pr==1)
                                                            @php
                                                                $pr_status=$prestamo_en_espera[0]->id_status_prestamo;
                                                            @endphp

                                                        @if ($pr_status==9)
                                                            {{-- aqui es donde se genera una multa --}}
                                                            @php
                                                                $fecha_a_existente = $prestamo_r->fecha_pago;
                                                                $array = str_split($fecha_a_existente);
                                                                $fecha_listo = $array[0].$array[1].$array[2].$array[3].$array[4].$array[5].$array[6].$array[7].$array[8].$array[9];
                                                                $dias_pasados = $fecha->diffInDays($fecha_listo);
                                                                $cantidad_semanas=round(($dias_pasados/7),0);

                                                                $semana=$prestamo_r->semana;
                                                                // $promedioGeneral = round($promedioGeneral,2);
                                                            @endphp

                                                                @php
                                                                    $cantidad_dias=$cantidad_semanas*7;
                                                                    $fecha_menos_dias=date("Y-m-d",strtotime($fecha."-".$cantidad_dias." days"));
                                                                @endphp
                                                                
                                                                {{-- Aqui buscamos si ya abonaron en la fecha que le tocaba --}}
                                                                @if ($fecha_menos_dias==$fecha_listo)
                                                                    {{-- <br><b>ya encontre el abono</b> --}}
                                                                @else

                                                                    {{-- aqui buscamos en los dias de la semana para ver si anticiparon el abono --}}
                                                                    @php
                                                                        $fecha_de_pago='0000-00-00';
                                                                    @endphp

                                                                    @for ($i = 1; $i <= $cant_dias; $i++)
                                                                        @php
                                                                            $dia_a_buscar=date("Y-m-d",strtotime($fecha_menos_dias."-".$i." days"));
                                                                        @endphp
                                                                        @if ($dia_a_buscar==$fecha_listo)
                                                                            {{-- <label for="">ya encontre la fecha que se pagó {{$dia_a_buscar}}</label> --}}
                                                                            @php
                                                                                $fecha_de_pago=$dia_a_buscar;
                                                                            @endphp
                                                                        @else

                                                                        @endif
                                                                    @endfor
                                                                    {{-- --------------- --}}

                                                                    {{-- aqui verificamos si hay saldo a favor --}}
                                                                    @if ($fecha_de_pago=='0000-00-00')
                                                                        @for ($i = 0; $i <$cantidad_semanas; $i++)
                                                                            @php
                                                                                $cantidad_dias=$i*7;
                                                                                $fecha_actualizado=date("Y-m-d",strtotime($fecha_menos_dias."+ ".$cantidad_dias." days"));
                                                                                $semana=$p_activo->semana+1+$i;
                                                                                $status_press = DB::table('tbl_prestamos')
                                                                                ->select('tbl_prestamos.*')
                                                                                ->where('id_prestamo','=',$prestamo_r->id_prestamo)
                                                                                ->where('id_status_prestamo','=',9)
                                                                                ->get();
                                                                                $contarp=count($status_press);

                                                                            @endphp

                                                                            {{-- <label for="">fecha para registrars: {{$fecha_actualizado}}</label><br> --}}

                                                                            @if ($contarp==0)
                                                                                $ {{$saldo_a_favor=0}}.00
                                                                            {{-- $ 0.00 --}}
                                                                            @else
                                                                                @php
                                                                                    $producto = DB::table('tbl_productos')   
                                                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                                    ->select('tbl_productos.*')
                                                                                    ->where('tbl_prestamos.id_prestamo','=',$status_press[0]->id_prestamo)
                                                                                    ->get();
                                                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                                    ->select('cantidad')
                                                                                    ->where('id_prestamo','=',$status_press[0]->id_prestamo)
                                                                                    ->get();
                                                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                                    ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                    ->where('id_tipoabono','=',1)
                                                                                    ->get();
                                                                                    $tipo_abono = DB::table('tbl_abonos')
                                                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                                    ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                    ->where('id_tipoabono','=',2)
                                                                                    ->get();
                                                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                                    ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                    ->where('id_tipoabono','=',3)
                                                                                    ->get();

                                                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                                

                                                                                    
                                                                                        $c_liquidacion = DB::table('tbl_abonos')
                                                                                        ->select(DB::raw('count(*) as c_liquidacion'))
                                                                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                        ->where('id_tipoabono','=',1)
                                                                                        ->get();

                                                                                        $c_abono = DB::table('tbl_abonos')
                                                                                        ->select(DB::raw('count(*) as c_abono'))
                                                                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                        ->where('id_tipoabono','=',2)
                                                                                        ->get();
                                                                                        $c_ahorro = DB::table('tbl_abonos')
                                                                                        ->select(DB::raw('count(*) as c_ahorro'))
                                                                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                        ->where('id_tipoabono','=',3)
                                                                                        ->get();

                                                                                        $c_papeleo = DB::table('tbl_abonos')
                                                                                        ->select(DB::raw('count(*) as c_papeleo'))
                                                                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                                                                        ->where('id_tipoabono','=',2)
                                                                                        ->where('semana','=',0)
                                                                                        ->get();

                                                                                        $minimo_pago=($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad;
                                                                                        $papeleria=($producto[0]->papeleria/100)*$cantidad_prestamo[0]->cantidad;

                                                                                        $st_papeleo=$c_papeleo[0]->c_papeleo*$papeleria;
                                                                                        $st_liquidacion=$c_liquidacion[0]->c_liquidacion*$minimo_pago;
                                                                                        $st_abono=($c_abono[0]->c_abono-$c_papeleo[0]->c_papeleo)*$minimo_pago;
                                                                                        $st_ahorro=$c_ahorro[0]->c_ahorro*$minimo_pago;

                                                                                        $calculo_sistema=$st_liquidacion+$st_abono+$st_ahorro+$st_papeleo;

                                                                                        $saldo_a_favor=$cliente_pago-$calculo_sistema;

                                                                                @endphp

                                                                                {{-- Aqui preguntamos si hay saldo a favor --}}
                                                                                @if ($saldo_a_favor>=$minimo_pago)
                                                                                    {{-- ya se abonó --}}
                                                                                @else
                                                                                    @php
                                                                                        $productor = DB::table('tbl_productos')
                                                                                        ->select('tbl_productos.ultima_semana')
                                                                                        ->where('id_producto','=',$prestamo_r->id_producto)
                                                                                        ->get();
                                                                                        
                                                                                        $multasr = DB::table('tbl_penalizacion')
                                                                                        ->select('tbl_penalizacion.*')
                                                                                        ->where('id_prestamo','=',$prestamo_r->id_prestamo)
                                                                                        ->get();
                                                                                    @endphp
                                                                                    @if ($semana>$productor[0]->ultima_semana)
                                                                                
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$prestamo_r->id_prestamo}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Renovado">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{2}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    
                                                                                    @else
                                                                                        @if (count($multasr)==0)
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$prestamo_r->id_prestamo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Renovado">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{4}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        
                                                                                        @else
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$prestamo_r->id_prestamo}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Renovado">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{5}}">
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                        @endif
                                                                                        
                                                                                    @endif
                                                                                @endif
                                                                                {{-- --------- --}}
                                                                            
                                                                            @endif


                                                                        @endfor
                                                                    @else
                                                                        {{-- <br><h3>Ya pagaron {{$fecha_de_pago}}</h3><br> --}}
                                                                        @if ($cantidad_semanas>0)
                                                                            @for ($i = 0; $i <$cantidad_semanas; $i++)
                                                                                @php
                                                                                    $cantidad_dias=$i*7;
                                                                                    $fecha_actualizado=date("Y-m-d",strtotime($fecha_menos_dias."+ ".$cantidad_dias." days"));
                                                                                    $semana=$p_activo->semana+1+$i;
                                                                                @endphp

                                                                                {{-- <label for="">fecha para registrars: {{$fecha_actualizado}}</label><br> --}}

                                                                                    @php
                                                                                        $productor = DB::table('tbl_productos')
                                                                                        ->select('tbl_productos.ultima_semana')
                                                                                        ->where('id_producto','=',$prestamo_r->id_producto)
                                                                                        ->get();
                                                                                        
                                                                                        $multasr = DB::table('tbl_penalizacion')
                                                                                        ->select('tbl_penalizacion.*')
                                                                                        ->where('id_prestamo','=',$prestamo_r->id_prestamo)
                                                                                        ->get();
                                                                                    @endphp
                                                                                    @if ($semana>$productor[0]->ultima_semana)
                                                                                
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$prestamo_r->id_prestamo}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Renovado">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{2}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    
                                                                                    @else
                                                                                            @if (count($multasr)==0)
                                                                                                
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$prestamo_r->id_prestamo}}">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Renovado">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{4}}">
                                                                                                    </div>
                                                                                                </div>
                                                                                            
                                                                                            @else
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$prestamo_r->id_prestamo}}">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Renovado">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_actualizado.' '.$hora.':00'}}">
                                                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{5}}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                            @endif
                                                                                    @endif
                                                                                    {{-- --------- --}}
                                                                                    
                                                                            @endfor
                                                                        @else
                                                                            {{-- pago anticipado --}}
                                                                        @endif
                                                                    @endif
                                                                @endif

                                                        @else
                                                            {{-- <label for="">no es igual</label><br> --}}
                                                        @endif
                                                        
                                                    @endif
                                                    {{-- @endif --}}
                                                @endforeach
                                            @endif
                                        @endforeach
                                        
                                            
                                       
                
                                        {{-- // aqui termina el primer grupo --}}
                
                                    {{-- @else --}}
                                        {{-- // return back()->with('status', '¡aun no es la hora!'); --}}
                                    {{-- @endif --}}
                                @endforeach

                        @endif


                @endforeach
                <div class="row">
                    <div class="col-md-11" >
                        <hr>
                        <button type="submit" onclick="return confirm('¿Esta seguro de realizar el corte?')" style="float: right" class="btn btn-primary btn-lg">Hacer corte y generar multas</button>
                    </div>
                    <br><br>
                </div>
            </form>
        </div>

    </div>
    
@endsection
@section('page-script')
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop