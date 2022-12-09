@extends('layouts.master')
@section('title', 'Corte - Corte varias semanas')
@section('parentPageTitle', 'Corte')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}
@stop
@section('content')
    <div class="row">
        
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-3">
            {{-- <small><b>Región</b></small><br>
            <a href="{{url('operacion/buscar_prestamos1?id_region='.$region->IdPlaza)}}" class="form-control" title="Clic para ir a las zonas de esta región">{{$region->Plaza}}</a> --}}
        </div>
        <div class="col-md-3">
            {{-- <small><b>Zona</b></small><br>
            <a href="#" class="form-control" title="Clic para ir a los grupos de esta zona">{{$zona->Zona}}</a> --}}
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
                        
                            <button class="btn btn-primary btn-sm" type="submit" title="Consultar corte por la cantidad de semanas que desea"><i class="fas fa-search"></i></button>
                            
                        </div>
                        <span class="badge badge-warning">Ingrese la cantidad de semanas</span>
                    </div>
                    
                   
                </div>            
                
                {{-- <a href="{{url('grupos/zona/pdf_corte_zona/'.$region->IdPlaza.'/'.$zona->IdZona.'/'..'/')}}" class="btn btn-primary " title="Imprimir reporte de corte por fechas" target="_blank"><i class="fas fa-search"></i></a> --}}
            </form>
        </div>
        <div class="col-md-3 d-flex">
            <small style="margin: 20px; margin-top: 30px">    
                <small><b>Imprimir reporte</b></small>
            </small>
            <a href="{{url('grupos/zona/pdf_corte_zona/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$semanas)}}" title="Imprimir reporte de corte" target="_blank"><span class="btn" style="background: #ffff; font-size: 50px; padding: 3px, 3px,3px,3px; margin: 3px, 3px, 3px, 3px;"><i style="color:  rgb(201, 6, 6); font-size: 50px; padding: 0px; margin: 0px;" class="fas fa-file-pdf"></i></span></a>
            {{-- grupos/zona/pdf_corte_zona/{idregion}/{idzona} --}}
                {{-- </center> --}}
        </div>
        
    </div>
    @if($semanas==0)
    <div class="row">
        <div class="col-md-12"><center>Sin semanas</center></div>
    </div>
    @else
        @for ($i = 0; $i < $semanas; $i++)
            @php
                $s_imprimir=$i+1;
            @endphp
                <div class="row mt-4">
                    @if ($s_imprimir>=1)
                        <div class="col-md-12">
                            <p>Ha consultado <b>{{$semanas}}</b> semanas pasadas</p>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <table>
                                <thead>
                                    <tr>
                                        <th><small>No. G</small></th>
                                        <th><small>Grupo</small></th>
                                        <th><small>Clientes</small></th>
                                        <th><small>Monto ideal</small></th>
                                        <th><small>Cobranza real</small></th>
                                        <th><small>%Cobrado</small></th>
                                        <th><small>Dinero colocado</small></th>
                                        <th><small>% de fallas</small></th>
                                        <th><small>Fallas</small></th>
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
                                                                    
                                                                    $aportacion_empresa=DB::table('v_cortes_semanas_detalles')
                                                                    ->join('tbl_grupos','v_cortes_semanas_detalles.id_grupo','tbl_grupos.id_grupo')
                                                                    ->join('tbl_aportacion_empresa','v_cortes_semanas_detalles.id_abono','tbl_aportacion_empresa.id_abono')
                                                                    ->select(DB::raw('SUM(cantidad) as total_aportacion,v_cortes_semanas_detalles.id_promotora,v_cortes_semanas_detalles.nombre_promotora,tbl_grupos.grupo'))
                                                                    ->where('v_cortes_semanas_detalles.id_grupo','=',$grupo->id_grupo)
                                                                    // ->where('id_tipoabono','=',2)
                                                                    ->where('id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                                    ->groupBy('v_cortes_semanas_detalles.id_promotora','v_cortes_semanas_detalles.nombre_promotora','tbl_grupos.grupo')
                                                                    ->get();
                                                                    
                                                                    $cobranza_perfecta=DB::table('tbl_cobranza_perfecta')
                                                                    ->select(DB::raw('SUM(cantidad) as total_cobranza_perfecta'))
                                                                    ->where('tbl_cobranza_perfecta.id_grupo','=',$grupo->id_grupo)
                                                                    ->where('tbl_cobranza_perfecta.id_corte_semana','=',$cortes_semana->id_corte_semana)
                                                                    ->get();
                                                                    
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
                                                {{-- @if ($contador>1) --}}
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
                                                {{-- @else

                                                @endif --}}
                                        
                                    @endforeach
                                    {{-- @if ($contador>1) --}}
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
                                            <td style="text-align: right">{{number_format($total_global_clientes)}}</td>
                                            <td style="text-align: right">$ {{number_format($total_global_cobranza_ideal,1)}}</td>
                                            <td style="text-align: right">$ {{number_format($total_global_cobranza_real)}}</td>
                                            <td style="text-align: right">{{number_format($porcentaje_cobranzareal,1)}}%</td>
                                            <td style="text-align: right">$ {{number_format($total_global_dinerocolocado,1)}}</td>
                                            <td style="text-align: right">{{number_format($porcentaje_mermas,1)}}%</td>
                                            <td style="text-align: right">$ {{number_format($total_global_mermas,1)}}</td>
                                        </tr>
                                    {{-- @else

                                    @endif --}}
                                
                                </tbody>
                            </table>
                        </div>
                    @else
                    
                    @endif
                </div>
                    
                    
        @endfor
    @endif
    <br>
   
    
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