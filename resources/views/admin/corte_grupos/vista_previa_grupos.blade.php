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

        <form action="{{url('guardar-multas')}}" method="post">
            @csrf
                
                @foreach ($dias_corte as $key => $value)

                    @php
                        $dia_de_corte=$value;
                        $hoy_dia= $f_actual->format('D');
                    @endphp
        
                    @if ($hoy_dia=='Mon')
        
                        @if($value=='Domingo') 
                            @php
                                $fecha=$f_actual->subDay(1);    
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
                        
                        {{-- <b>dia pasado: {{$value}} fecha: {{$fecha_pasado}}</b><br> --}}


                        @if (count($corte)==0)
                                {{-- return back()->with('status', '¡No hay corte para este dia!'); --}}
                                {{-- return back()->with('status', '¡No hay corte para este dia!'); --}}
                                <div class="row mt-2 mb-2">
                                    <div class="col-md-6">
                                        <div class="alert alert-warning" role="alert">
                                            <label for="">No hay corte para el día pasado {{$value}} {{$fecha_pasado}}</label><br>
                                        </div>
                                    </div>
                                </div>
                        
                        @else
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
                                    
                                    {{-- @if ($hora>=$cor->hora) --}}
                                        @php
                                            // dd($cor->hora,$cor->nombre_dia);
                                        // dd('ya es hora');
                                        $ultimos_abonoac = DB::table('v_estadisticas')
                                        ->select('v_estadisticas.*')
                                        ->where('grupo','=',$cor->id_grupo)
                                        ->get();
                                            
                                        @endphp
                
                                        {{-- // return view('prueba_de_corte',['ultimos_abono'=>$ultimos_abono]); --}}
                                        @if (count($ultimos_abonoac)==0)
                                            <center>
                                                No hay datos de préstamos y abonos. <br>
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
                                                
                                                @if (count($prestamo_activo)==0)
                    
                                                    {{-- // dd('no hay datos'); --}}
                                                    
                                                @else
                    
                                                    @foreach ($prestamo_activo as $p_activo)
                                                        @php
                                                            $fecha_a_existente = $p_activo->fecha_pago;
                                                            $array = str_split($fecha_a_existente);
                                                            $fecha_listo = $array[0].$array[1].$array[2].$array[3].$array[4].$array[5].$array[6].$array[7].$array[8].$array[9];
                                                            
                                                        @endphp
                    
                                                        {{-- // dd($fecha_listo,$hoy,$p_activo->id_prestamo,$hora); --}}
                                                        @if ($fecha_listo==$fecha)
                                                            ya abonaron <br>
                                                        @else
                                                            {{-- // dd('creo que se merecen una multa'); --}}
                                                            @php
                                                                $producto = DB::table('tbl_productos')
                                                                ->select('tbl_productos.ultima_semana')
                                                                ->where('id_producto','=',$p_activo->id_producto)
                                                                ->get();
                        
                                                                $semana=$p_activo->semana+1;
                        
                                                                $multas = DB::table('tbl_penalizacion')
                                                                ->select('tbl_penalizacion.*')
                                                                ->where('id_prestamo','=',$p_activo->id_prestamo)
                                                                ->get();
                                                                
                                                            @endphp
                    
                                                            @if ($semana>$producto[0]->ultima_semana)

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$p_activo->id_prestamo}}">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="" value="Activo">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_pasado.' '.$hora.':00'}}">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{2}}">
                                                                    </div>
                                                                </div>
                    
                                        
                                                            @else
                                                                @if (count($multas)==0)

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="text" value="{{$grupo[0]->grupo}}">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$p_activo->id_prestamo}}">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="" value="Activo">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semana}}">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_pasado.' '.$hora.':00'}}">
                                                                        <input style="font-size: 10px;  width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{4}}">
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
                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_pasado.' '.$hora.':00'}}">
                                                                        <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{5}}">
                                                                    </div>
                                                                </div>
                                                                    
                                                                @endif
                                                                
                                                            @endif
                    
                                                        @endif
                                                        
                                                    @endforeach
                                                @endif
                    
                                            @endforeach
                                            
                                        @endif
                                        @php
                                            $ultimos_abonore = DB::table('v_estadisticas')
                                            ->select('v_estadisticas.*')
                                            ->where('grupo','=',$cor->id_grupo)
                                            ->get();
                                        @endphp

                                        
                                            @foreach ($ultimos_abonore as $value)
                                                @php
                                                    // aqui empieza los de renovados
                                                    $prestamo_renovados = DB::table('tbl_prestamos')
                                                    ->join('tbl_abonos','tbl_prestamos.id_prestamo','tbl_abonos.id_prestamo')
                                                    ->select('tbl_prestamos.*','tbl_abonos.*')
                                                    ->where('tbl_abonos.id_abono','=',$value->ultimo_abono)
                                                    ->where('tbl_prestamos.id_status_prestamo','=',9)
                                                    ->get();
                                                @endphp
                    
                                                @if (count($prestamo_renovados)==0)
                                                    {{-- <label for="">no hay datos prestamos renovados</label><br> --}}
                                                @else
                                                    @foreach ($prestamo_renovados as $prestamo_r)
                                                        @php
                                                            $fecha_a_existente = $prestamo_r->fecha_pago;
                                                            $array = str_split($fecha_a_existente);
                                                            $fecha_listo = $array[0].$array[1].$array[2].$array[3].$array[4].$array[5].$array[6].$array[7].$array[8].$array[9];
                        
                                                            // dd($fecha_listo,$hoy,$p_activo->id_prestamo,$hora);
                                                        @endphp
                                                        {{-- @if ($fecha_listo==$hoy) --}}
                                                            {{-- // dd('ya abonaron'); --}}
                                                        {{-- @else --}}
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
                                                                {{-- // <label for="">total es {{$pr}} {{$prestamo_r->id_prestamo}}</label> <br> --}}
                                                            @elseif($pr==1)
                                                             
                                                                    
                                                                    @php
                                                                        $pr_status=$prestamo_en_espera[0]->id_status_prestamo;
                                                    
                                                                    @endphp
                    
                                                                @if ($pr_status==9)
                                                                    {{-- // <label for="">es igual a uno {{$pr_status}}=renovacion y  {{$prestamo_r->id_prestamo}}</label><br> --}}
                    
                    
                                                                    {{-- aqui es donde se genera una multa --}}
                                                                    @php
                                                                        $productor = DB::table('tbl_productos')
                                                                        ->select('tbl_productos.ultima_semana')
                                                                        ->where('id_producto','=',$prestamo_r->id_producto)
                                                                        ->get();
                                                                        
                                                                        $semanr=$prestamo_r->semana+1;
                        
                                                                        $multasr = DB::table('tbl_penalizacion')
                                                                        ->select('tbl_penalizacion.*')
                                                                        ->where('id_prestamo','=',$prestamo_r->id_prestamo)
                                                                        ->get();
                                                                    @endphp
                    
                                                                    @if ($semanr>$productor[0]->ultima_semana)
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$grupo[0]->grupo}}">
                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="{{$dia_de_corte}}" readonly>
                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_prestamo[]" value="{{$prestamo_r->id_prestamo}}">
                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="" value="Renovado">
                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semanr}}">
                                                                                <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_pasado.' '.$hora.':00'}}">
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
                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semanr}}">
                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_pasado.' '.$hora.':00'}}">
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
                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="semana[]" value="{{$semanr}}">
                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="fecha_pago[]" value="{{$fecha_pasado.' '.$hora.':00'}}">
                                                                                    <input style="font-size: 10px; width: auto;" readonly="readonly" type="text" name="id_tipoabono[]" value="{{5}}">
                                                                                </div>
                                                                            </div>
                                                                            
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
                
                                {{-- return back()->with('status', '¡Operacion se ejecutó con éxito!'); --}}
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