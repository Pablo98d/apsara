@extends('layouts.master')
@section('title', 'Corte semanal por zonas')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}
@stop
@section('content')
    <div class="row">
        @if ( session('status') )
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<center>
					{{ session('status') }}
				</center>
				<button class="close" type="button" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
		@endif
        @if ( session('error') )
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<center>
					{{ session('error') }}
				</center>
				<button class="close" type="button" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
		@endif
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-4">
            {{-- <small><b>Región</b></small><br>
            <a href="{{url('operacion/buscar_prestamos1?id_region='.$region->IdPlaza)}}" class="form-control" title="Clic para ir a las zonas de esta región">{{$region->Plaza}}</a> --}}
        </div>
        <div class="col-md-3">
            {{-- <small><b>Zona</b></small><br>
            <a href="#" class="form-control" title="Clic para ir a los grupos de esta zona">{{$zona->Zona}}</a> --}}
        </div>
        <div class="col-md-2">
            <small>
                <center>
                    <b>Imprimir reporte</b></small><br>
                </center>
            <a href="{{url('grupos/zona/reporte_corte_zona/'.$region->IdPlaza.'/'.$zona->IdZona)}}" class="btn btn-secondary btn-block" title="Imprimir reporte de corte" target="_blank"><i class="fas fa-print"></i></a>
        </div>
    
        <div class="col-md-3">
            <form id="form_semana" onsubmit="return validar_semanas();" action="{{url('grupos/zona/corte_zona_semana/'.$region->IdPlaza.'/'.$zona->IdZona)}}" method="get">
                {{-- @csrf --}}
                <div class="row">
                    <div class="col-md-12">
                            <small>
                               <b>Reporte por semanas pasadas</b></small>
                            </small> 
                    </div>
                    <div class="col-md-8 ">
                        <div class="d-flex">
                            <input name="txf_semanas" id="tx_semanas" style="margin-right: 5px; margin-top: 6px; width: 100px; height: 25px;" type="number" required>
                        
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-search"></i></button>
                        </div><span class="badge badge-warning">Ingrese la cantidad de semanas</span>
                    </div>
                    
                   
                </div>            
                
                {{-- <a href="{{url('grupos/zona/pdf_corte_zona/'.$region->IdPlaza.'/'.$zona->IdZona.'/'..'/')}}" class="btn btn-primary " title="Imprimir reporte de corte por fechas" target="_blank"><i class="fas fa-search"></i></a> --}}
            </form>
        </div>
        
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12">
            <table>
                <thead>
                    <tr>
                        <th><center><small>No. G</small></center></th>
                        <th><center><small>Grupo</small></center></th>
                        <th><center><small>Clientes de la semana actual</small></center></th>
                        <th><center><small>Corte ideal de la semana actual</small></center></th>
                        <th><center><small>Corte en curso</small></center></th>
                        <th><center><small>Cobranza real</small></center></th>
                        <th><center><small>%Cobrado</small></center></th>
                        <th><center><small>%Semana pasada</small></center></th>
                        <th><center><small>%Semana antepasada</small></center></th>
                        <th><center><small>Dinero colocado</small></center></th>
                        <th><center><small>% de fallas</small></center></th>
                        <th><center><small>Fallas</small></center></th>
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
                                   
                                    $clientes_proceso=0;
                                    $clientes_actual=0;
                                    $cobranza_ideal_actual=0;
                                    $cobranza_ideal_pasado=0;
                                    $cobranza_ideal_ante_pasado=0;
                                    
                                    $total_cobranza_proceso=0;
                                    $total_cobranza_actual=0;
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
                                                ->whereBetween('tbl_prestamos.fecha_entrega_recurso', [$cortes_semana->fecha_inicio.' 00:00:00', $cortes_semana->fecha_final.' 00:00:00'])
                                                ->whereBetween('tbl_prestamos.id_status_prestamo', [2, 9])
                                                ->distinct()
                                                ->get();
                            
                                                
                                                $actual_f_inicio=$cortes_semana->fecha_inicio;
                                                $actual_f_final=$cortes_semana->fecha_final;
                                                
                                                $clientes_actual=$cortes_semana->total_clientes;
                                                $total_global_clientes+=$cortes_semana->total_clientes;
                                                
                                                $id_corte_semana=$cortes_semana->id_corte_semana;
                                                $cobranza_ideal_actual=$cortes_semana->corte_ideal;
                                                
                                                
                                            @endphp
                                            
                                        @elseif($contador==3)
                                        
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


                                                // $corte_pasado=$cortes_semana->id_corte_semana;
                                                
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


                                                // $corte_antepasado=$cortes_semana->id_corte_semana;
                                            @endphp
                                        @endif
                                        
                                    @endforeach
                                @endif
                        <tr>
                                
                            <td>
                                <small><center>{{$grupo->id_grupo}}</center></small>
                            </td>
                            <td>
                                {{-- <form action="{{url('actualizar_datos_corte')}}" method="post">
                                    @csrf
                                     <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
                                     <input type="hidden" name="id_corte" value="{{$id_corte_semana}}">
                                     <div class="d-flex">
                                        <small>{{$grupo->grupo}}</small>
                                         <button type="submit" style="border: 0; background: transparent"> 
                                             <i class="fas fa-redo-alt"></i>
                                         </button>
                                     </div>
                                 </form> --}}
                                 <small>{{$grupo->grupo}}</small>
                            </td>
                            
                            <td style="text-align: center">
                                <small>
                                    {{number_format($clientes_actual)}}
                                </small>
                            </td>
                            
                            <td style="text-align: center">
                                <!--semana actual cobranza ideal-->
                                    <small>
                                        @php
                                            $total_global_cobranza_ideal+=$cobranza_ideal_actual;
                                        @endphp
                                     $ {{number_format($cobranza_ideal_actual,2)}} <br>
                                     
                                    
                                </small>
                            </td>
                            <td style="text-align: center">
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
                            </td>
                            <td style="text-align: center">
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
                                    <!--Calculamos el total aportaci��n empresa-->
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
                                    @endif --}}
                                    
                                    
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
                                </small>
                            </td>
                            <td style="text-align: right">
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
                                    
                                    <!--Calculamos el total aportaci��n empresa semana pasada-->
                                    {{-- @if(!empty($aportacion_empresa_pasada))
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
                                    @endif --}}
                                    
                                    <!--Calculamos el total de cobranza perfecta semana pasada-->
                                    {{-- @if(!empty($cobranza_perfecta_pasada))
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
                                    @endif --}}
                                    
                                    <!--Colculamos el total cobranza en semana pasada-->
                                    @php
                                        // $monto_real_pasada=$total_cobranza_pasada-$t_aportacion_pasada-$t_cobranza_perfecta_pasada;
                                        $monto_real_pasada=$total_cobranza_pasada;
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
                                        - <small>${{number_format($monto_real_pasada,1)}}</small><br>
                                        @if ($pasada_porcentaje==0)
                                        {{-- Corte pasada{{$corte_pasado}} --}}
                                        @else
                                            {{number_format($pasada_porcentaje,1)}}% </b>
                                        @endif
                                </small>
                            </td>
                            <td style="text-align: right">
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
                                    
                                    <!--Calculamos el total aportaci��n empresa semana ante pasada-->
                                    {{-- @if(!empty($aportacion_empresa_ante_pasada))
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
                                    @endif --}}
                                    
                                    <!--Calculamos el total de cobranza perfecta semana ante pasada-->
                                    {{-- @if(!empty($cobranza_perfecta_ante_pasada))
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
                                    @endif --}}
                                    
                                    @php
                                        // $monto_real_ante_pasada=$total_cobranza_ante_pasada-$t_aportacion_ante_pasada-$t_cobranza_perfecta_ante_pasada;
                                        $monto_real_ante_pasada=$total_cobranza_ante_pasada;
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
                                        - <small>${{number_format($monto_real_ante_pasada,1)}}</small><br>
                                        @if ($antepasada_porcentaje==0)
                                        @else
                                            {{number_format($antepasada_porcentaje,1)}}% <br>
                                            
                                        @endif
                                        </b>
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
                    <tr style="border-top:2px solid rgb(54, 0, 141);">
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
                        
                        <td>-</td>
                        <td style="text-align: right">Total:</td>
                        <td style="text-align: center">{{number_format($total_global_clientes)}}</td>
                        <td style="text-align: center">$ {{number_format($total_global_cobranza_ideal,1)}}</td>
                        <td style="text-align: center">$ {{number_format($total_global_cobranza_proceso,1)}}</td>
                        <td style="text-align: center">$ {{number_format($total_global_cobranza_real)}}</td>
                        <td style="text-align: right">{{number_format($porcentaje_cobranzareal,1)}}%</td>
                        <td style="text-align: right">{{number_format($porcentaje_semana_pasada,1)}}%</td>
                        <td style="text-align: right">{{number_format($porcentaje_semana_antepasada,1)}}%</td>
                        <td style="text-align: right">$ {{number_format($total_global_dinerocolocado,1)}}</td>
                        <td style="text-align: right">{{number_format($porcentaje_mermas,1)}}%</td>
                        <td style="text-align: right">$ {{number_format($total_global_mermas,1)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <br><br>
   
    
@stop
@section('page-script')
<script>
    

    window.onload = function agregar_boton_atras(){
  
      document.getElementById('Atras').innerHTML='<a href="{{url('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
    
  }
</script>

<script>
        
        function validar_semanas(){
            let semanas = $("#tx_semanas").val();
            if (semanas<=0) {
                alert('Por favor la cantidad de semanas debe ser mayor a cero');
                return false;
            } else {
                formulario.submit();
                return true;
            }
            
        }
    </script>

    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop