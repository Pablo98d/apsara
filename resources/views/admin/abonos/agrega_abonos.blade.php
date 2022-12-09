@extends('layouts.master')
@section('title', 'Agregando abonos')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <hr class="hr-2">
        </div>
        <div class="col-md-4">
            <small><b>Región</b></small><br>
            <a href="{{url('operacion/buscar_prestamos1?id_region='.$region->IdPlaza)}}" class="form-control" title="Clic para ir a las zonas de esta región">{{$region->Plaza}}</a>
        </div>
        <div class="col-md-4">
            <small><b>Zona</b></small><br>
            <a href="{{url('operacion/buscar-grupo/'.$zona->IdZona.'/'.$region->IdPlaza)}}" class="form-control" title="Clic para ir a los grupos de esta zona">{{$zona->Zona}}</a>
        </div>
        <div class="col-md-4">
            <small><b>Grupo</b></small><br>
            <input type="hidden" id="id_grupo" value="{{$grupo->id_grupo}}">
            <a href="{{url('prestamo/buscar-cliente/'.$zona->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo)}}" class="form-control" title="Clic para ir a los clientes de este grupo">{{$grupo->grupo}}</a>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            
            <small><b>Cliente</b></small><br>
            <form id="formPrest" action="{{url('prestamo/abono/agregar-abono-c/'.$zona->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo.'/0')}}" method="get">
                <select name="id_presta" class="form-control show-tick ms select2" data-placeholder="Select" onchange="buscar_prestamo()">
                    
                    @foreach ($clientesp as $client)
                        <option value="{{$client->id_prestamo}}" 
                            {{$cliente[0]->id==$client->id ? 'selected' : 'Seleccione un cliente'}}
                            >{{$client->id}} {{$client->nombre}} {{$client->ap_paterno}} {{$client->ap_materno}}</option>
                    @endforeach
                </select>
            </form>
            
        </div>
        <div class="col-md-2">
            <small><b>Préstamo</b></small><br>
            <label for="">{{$prestamo[0]->producto}}</label>
        </div>
        <div class="col-md-3">
            @php
                $papeleo=$prestamo[0]->cantidad*($prestamo[0]->papeleria/100);

                
                $interes=$prestamo[0]->cantidad*($prestamo[0]->pago_semanal/100)*$prestamo[0]->semanas;
                
                $interes_neto=$prestamo[0]->cantidad*($prestamo[0]->reditos/100);
                $total_prestamo=$papeleo+$interes;
                $minimo=$prestamo[0]->cantidad*($prestamo[0]->pago_semanal/100);
            @endphp
            <small><b>Monto</b></small><br>
            <label for="">$ {{$prestamo[0]->cantidad}}.00</label>
        </div>
        
        <div class="col-md-3">
            <small><b>Fecha de entrega de recurso</b></small>
            @php
                $datee = date_create($prestamo[0]->fecha_entrega_recurso);
            @endphp
            <label for="">{{date_format($datee, 'd-m-Y H:i:s')}}</label>
        </div>
    </div>
        
    <hr>
    @if ( session('status') )
      <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
        <center>
            {{ session('status') }}
        </center>
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
    @endif
    @if ( session('error') )
      <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
        <center>
            {{ session('error') }}
        </center>
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
    @endif
    @if ($prestamo[0]->id_status_prestamo==8)
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
          <span class="badge badge-danger">Préstamo pagado</span>
        </div>
    </div>
    @elseif ($prestamo[0]->id_status_prestamo==16)
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
          <span class="badge badge-danger">Préstamo devuelto</span>
        </div>
    </div>
    @elseif ($prestamo[0]->id_status_prestamo==6)
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
          <span class="badge badge-dark">Préstamo inactivo</span>
        </div>
    </div>
    @elseif ($prestamo[0]->id_status_prestamo==10)
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
          <span class="badge badge-success">Préstamo aprobado</span>
        </div>
    </div>
    @elseif ($prestamo[0]->id_status_prestamo==15)
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
          <span class="badge badge-info">Préstamo por entregarse</span>
        </div>
    </div>
    @elseif ($prestamo[0]->id_status_prestamo==5)
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
          <span class="badge badge-dark">Préstamo suspendido</span>
        </div>
    </div>
    @else
    <div class="col-md-12">
            <b> Sección para agregar abonos</b>
            <br><span class="badge badge-pill badge-warning"><strong>Nota:</strong> Para cambiar un abono a multa 1, primero verificar si no hay uno de ese tipo, si hay, entonces se debe de modiificar a otro tipo.</span>
    </div>
    <div class="row mt-4 mb-4">
            <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <select class="form-control" name="semana" id="semana_s">
                            <option value="">-Semana-</option>
                            <option value="0">Semana 0</option>
                            <option value="1">Semana 1</option>
                            <option value="2">Semana 2</option>
                            <option value="3">Semana 3</option>
                            <option value="4">Semana 4</option>
                            <option value="5">Semana 5</option>
                            <option value="6">Semana 6</option>
                            <option value="7">Semana 7</option>
                            <option value="8">Semana 8</option>
                            <option value="9">Semana 9</option>
                            <option value="10">Semana 10</option>
                            <option value="11">Semana 11</option>
                            <option value="12">Semana 12</option>
                            <option value="13">Semana 13</option>
                            <option value="14">Semana 14</option>
                            <option value="15">Semana 15</option>
                            <option value="16">Semana 16</option>
                            <option value="17">Semana 17</option>
                            <option value="18">Semana 18</option>
                            <option value="19">Semana 19</option>
                            <option value="20">Semana 20</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select class="form-control" name="id_tipoabono" id="id_tipoabono_s">
                            <option value="">-Tipo abono-</option>
                            @foreach ($tipoabono as $tipoab)
                                @if (empty($multa1[0]->id_tipoabono))
                                    <option value="{{$tipoab->id_tipoabono}}">{{$tipoab->tipoAbono}}</option>
                                @else
                                    <option value="{{$tipoab->id_tipoabono}}"
                                        {{$multa1[0]->id_tipoabono==$tipoab->id_tipoabono ? 'disabled':''}}
                                        >{{$tipoab->tipoAbono}}
                                    </option>
                                    
                                @endif
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="col-md-2">
                        <button type="button" onclick="agregar_abono()" style="font-size: 15px" class="btn-success btn-sm"><i class="fas fa-arrow-circle-right"></i>
                            
                        </i></button>
                    </div>
                    <div class="col-md-5 mt-2">
                        <input type="number" id="cantidad_s" class="form-control" name="cantidad" placeholder="min. $ {{$minimo}}.00" required>
                    </div>
                    <div class="col-md-5 mt-2">
                        <input type="date" id="fecha_pago_s" class="form-control" name="fecha_pago" required>
                    </div>
                    <div class="col-md-10 mt-2" id="select-corte">
                        
                        <select class="form-control show-tick ms select2" data-placeholder="Select" id="corte_s" >
                            <option value="">-Seleccione corte-</option>

                            @foreach ($cortes_semanas as $cortes_s)
                                             @php
                                                
                                                $fechaActual = $cortes_s->fecha_inicio;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_a = $fechaActual;
                                                $fecha_a = str_replace("/", "-", $fecha_a);
                                                $Nueva_Fecha_a = date("d-m-Y", strtotime($fecha_a));
                                                
                                                $fechaActualf = $cortes_s->fecha_final;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_af = $fechaActualf;
                                                $fecha_af = str_replace("/", "-", $fecha_af);
                                                $Nueva_Fecha_af = date("d-m-Y", strtotime($fecha_af));
                                            @endphp
                            <option value="{{$cortes_s->id_corte_semana}}">No. {{$cortes_s->id_corte_semana}} Fecha: {{$Nueva_Fecha_a}} a {{$Nueva_Fecha_af}}</option>
                            @endforeach
                            
                        </select>
                        @php
                                    $fecha_buscar1='2021-02-07';
                                    $fecha_buscar2='2021-02-14';

                                    $fechas_corte=DB::table('tbl_cortes_semanas')
                                    ->select('tbl_cortes_semanas.*')
                                    ->where('id_grupo','=',101)
                                    ->whereBetween('fecha_final', [$fecha_buscar1, $fecha_buscar2])
                                    ->get();
                   

                        @endphp
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                        <form id="guardarAbonosLista" action="{{url('abonos-guardar-varios')}}" method="post">
                            @csrf
                            <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
                            <input type="hidden" name="id_prestamo" value="{{$prestamo[0]->id_prestamo}}">
                            <input type="hidden" name="ultima_semana" value="{{$prestamo[0]->ultima_semana}}">
                        <table>
                            <thead>
                                <tr>
                                    <th><small>Corte</small></th>
                                    <th><small>Semana</small></th>
                                    <th><small>Tipo</small></th>
                                    <th><small>Cantidad</small></th>
                                    <th><small>Fecha</small></th>
                                    <th><small>Acción</small></th>
                                </tr>
                            </thead>
                            <tbody id="tblAbonos">

                            </tbody>
                        </table>
                        <center>
                            <div>
                                <button style="display:none; font-size: 15px" class="btn btn-primary btn-sm btn-block mt-1" type="button" id="boton" data-toggle="modal" data-target="#guardarAbonosModel" title="Guardar abonos" data-mensaje="Nota: Revise bien los datos del abono" title="Eliminar abono">Guardar abonos</button>
                                
                            </div>
                        </center>
                        </form>
            </div>
    </div> 
    <hr>
    @endif
    @php
        $t_prestamos = DB::table('tbl_abonos')
        ->select(DB::raw('count(*) as total_pres'))
        ->where('id_prestamo', '=', $prestamo[0]->id_prestamo)
        ->whereBetween('semana', [1, 12])
        ->whereNotIn('id_tipoabono', [4,5,6])
        ->where('cantidad', '>',0)
        ->get();
    @endphp
    @if (!empty($datosabonos))
        <div class="row mt-3">
            @php
                $saldo=0;
                $saldototal=0;
                $saldo_abonado=0;
                $multa1=0;
                $multa2=$prestamo[0]->penalizacion;
                $monto_prestamo=$total_prestamo;
            @endphp
            <div class="col-md-12">
                <div class="estilo-tabla">
                    <table >
                        <thead>
                            <tr>
                                
                                <th class="">No. Abono</th>
                                <th class="">No. Prést.</th>
                                <th class="en-1">Semanas</th>
                                <th class="en-1">Cantidad</th>
                                <th class="">Tipo abono</th>
                                <th class="">Saldo</th>
                                <th class="">Fecha de pago</th>
                                <th class="">Fec. Corte</th>
                                <th class="">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="myList">
                            @foreach ($datosabonos as $abono)
                            @php
                                $corte_semana = DB::table('tbl_cortes_semanas')
                                ->select('tbl_cortes_semanas.fecha_final')
                                ->where('id_corte_semana', '=',$abono->id_corte_semana)
                                ->get();
                            @endphp
                            <tr>
                                
                                <td class="td-1">
                                    {{$abono->id_abono}}
                                </td>
                                <td class="td-1">
                                    {{$abono->id_prestamo}}
                                </td>
                                <td class="td-1">
                                    <small>
                                        Semana {{$abono->semana}}
                                    </small>
                                <td class="td-1">
                                    @if ($abono->id_tipoabono==4)
                                        @php
                                            $multa1=$abono->cantidad;

                                            $saldo+=0;

                                            $monto_prestamo+=$multa1;

                                            $saldototal=$monto_prestamo-$saldo;

                                        @endphp
                                        <span class="badge badge-pill badge-danger">$ {{number_format($multa1,2)}}</span>
                                    @elseif($abono->id_tipoabono==5)
                                        @php
                                            $multa2=$abono->cantidad;
                                            $saldo+=0;
                                            $monto_prestamo+=$multa2;
                                            $saldototal=$monto_prestamo-$saldo;

                                        @endphp
                                        <span class="badge badge-pill badge-danger">$ {{number_format($multa2)}}</span>
                                    @elseif($abono->id_tipoabono==6)
                                        @php
                                            $abono_ajuste=$abono->cantidad;
                                            $saldo-=$abono_ajuste;
                                            $monto_prestamo+=$abono_ajuste;
                                            $saldototal=$monto_prestamo-$saldo;

                                        @endphp
                                        <span class="badge badge-pill badge-primary">$ {{number_format($abono_ajuste,2)}}</span>
                                    @else
                                        <small>
                                            @php
                                                $saldo+=$abono->cantidad;
                                                $saldototal=$monto_prestamo-$saldo;
                                            @endphp
                                            $ {{number_format($abono->cantidad,2)}}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <center>
                                        <small>{{$abono->tipoAbono}}</small>
                                    </center>
                                </td>
                                <td class="td-1">
                                    <small>
                                        $ {{number_format($saldototal,2)}}
                                    </small>
                                </td>
                                <td>
                                    @php
                                        $datep = date_create($abono->fecha_pago);
                                    @endphp
                                    <small>
                                        {{date_format($datep, 'd-m-Y H:i:s')}}
                                    </small>
                                </td>
                                <td class="">
                                    @if (count($corte_semana)==0)
                                        <span class="badge badge-pill badge-info">Sin fecha de corte</span>
                                    @else
                                        @foreach ($corte_semana as $corte_s)
                                        @php
                                            $fechaCorte = $corte_s->fecha_final;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_cr = $fechaCorte;
                                                $fecha_cr = str_replace("/", "-", $fecha_cr);
                                                $Nueva_fecha_c = date("d-m-Y", strtotime($fecha_cr));
                                        @endphp
                                           <small> {{$Nueva_fecha_c}}</small>
                                        @endforeach
                                    @endif
                                    
                                </td>
                                <td class="d-flex">
                                    @php
                                        $penalizacion = DB::table('tbl_penalizacion')
                                        ->join('tbl_abonos','tbl_penalizacion.id_abono','tbl_abonos.id_abono')
                                        ->select(DB::raw('count(*) as total_penalizacion'))
                                        ->where('tbl_abonos.id_abono', '=', $abono->id_abono)
                                        ->get();

                                        $aportacion = DB::table('tbl_aportacion_empresa')
                                        ->select(DB::raw('count(*) as total_aportacion'))
                                        ->where('id_abono', '=', $abono->id_abono)
                                        ->get();

                                    @endphp
                                            <form action="{{ url('admin/abonos/'.$abono->id_abono.'/edit/') }}" method="get">
                                                <input type="hidden" name="link" value="prestamo/abono/agregar-abono-c/{{$zona->IdZona}}/{{$region->IdPlaza}}'/{{$grupo->id_grupo}}/{{$abono->id_prestamo}}">
                                                <button class="btn btn-warning btn-sm" title="Editar datos del préstamo"  ><i class="fas fa-pen"></i></button>
                                            </form>

                                            @if ($penalizacion[0]->total_penalizacion>0)
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarAbonoPenalizacionModel" title="Eliminar abono con penalización" data-mensaje="¡El abono tiene penalización, se eliminará la penalización y el abono!" data-id="{{$abono->id_abono}}"><i class="fas fa-trash"></i></button>
                                            @elseif($aportacion[0]->total_aportacion>0)
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarAbonoPenalizacionModel" title="Eliminar abono con aportación empresa" data-mensaje="¡El abono tiene aportación empresa, se eliminará la aportación y el abono!" data-id="{{$abono->id_abono}}"><i class="fas fa-trash"></i></button>
                                                
                                            @else
                                                <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#eliminarAbonoPenalizacionModel" title="Eliminar abono con aportación empresa" data-mensaje="¡El abono se eliminará permanentemente!" data-id="{{$abono->id_abono}}" title="Eliminar abono"><i class="fas fa-trash"></i></button>
                                            @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-2"></div>
                        <div class="col-md-3"><b>Total abonado: </b><span class="badge badge-primary">$ {{number_format($saldo,2)}}</span></div>
                        <div class="col-md-3"><b>Saldo actual: </b><span class="badge badge-danger">$ {{number_format($monto_prestamo-$saldo,2)}}</span><input type="hidden" name="saldo_liq" id="saldo_liq" value="{{$monto_prestamo-$saldo}}"></div>
                        <div class="col-md-3" style="text-align: right">
                            <b>Total a pagar: </b><span class="badge badge-success">$ {{number_format($monto_prestamo,2)}}</span><br>
                            <small>Préstamo: $ {{number_format($prestamo[0]->cantidad,2)}}</small><br>
                            <small>Papeleo: $ {{number_format($papeleo,2)}}</small><br>
                            <small>Interés: $ {{number_format($interes_neto,2)}}</small>
                        </div>
                        @php
                            $total_saldo_actual=$monto_prestamo-$saldo;
                            
                            $t_porentregar = DB::table('tbl_prestamos')
                            ->select(DB::raw('count(*) as t_porentregar'))
                            ->where('tbl_prestamos.id_status_prestamo', '=',15)
                            ->where('tbl_prestamos.id_usuario', '=',$prestamo[0]->id_usuario)
                            ->get();
                        @endphp
                        @if ($t_porentregar[0]->t_porentregar>=1)
                            <div class="col-md-12 mt-2">
                                <div class="alert alert-info" role="alert">
                                    <center>
                                        ¡Su siguiente préstamo está por entregarse!
                                    </center>
                                </div>
                            </div>
                        @else
                            
                            @php
                                $pre_estatus = DB::table('tbl_prestamos')
                                ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                ->select(DB::raw('count(*) as total_pre'))
                                ->where('tbl_prestamos.id_status_prestamo', '=',9)
                                ->where('tbl_abonos.id_tipoabono', '=',1)
                                ->where('tbl_prestamos.id_prestamo', '=',$prestamo[0]->id_prestamo)
                                ->get();

                                $fallas = DB::table('tbl_abonos')
                                ->select(DB::raw('count(*) as total_falla'))
                                ->where('id_prestamo', '=', $prestamo[0]->id_prestamo)
                                ->whereIn('id_tipoabono', [4,5])
                                ->where('cantidad', '>',0)
                                ->get();

                            @endphp
                            @if ($t_prestamos[0]->total_pres==12)

                                @if ($prestamo[0]->id_status_prestamo==9)
                                    @php
                                        $pre_aprobados = DB::table('tbl_prestamos')
                                        ->select(DB::raw('count(*) as total_pre_10'))
                                        ->where('id_usuario', '=',$cliente[0]->id)
                                        ->where('id_status_prestamo', '=',10)
                                        ->get();
                                    @endphp
                                    @if ($pre_aprobados[0]->total_pre_10>0)
                                        <div class="col-md-12">
                                            <div class="alert alert-warning mt-3" role="alert">
                                                <center>
                                                    ¡Renovación en espera de aprobación!  <b ></b>
                                                </center>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <div class="alert alert-success mt-3" role="alert">
                                                <center>
                                                    ¡Renovación activo!  <b ></b>
                                                </center>
                                            </div>
                                        </div>
                                    @endif
                                @elseif($prestamo[0]->id_status_prestamo==8)
                                        @php
                                            $pre_estatus_9 = DB::table('tbl_prestamos')
                                            ->select(DB::raw('count(*) as total_pre_9'))
                                            ->where('id_usuario', '=',$cliente[0]->id)
                                            ->where('id_status_prestamo', '=',9)
                                            ->get();
                                        @endphp
                                        @if ($pre_estatus_9[0]->total_pre_9>0)
                                            <div class="col-md-12">
                                                <div class="alert alert-success mt-3" role="alert">
                                                    <center>
                                                        ¡Renovación activo!  <b ></b>
                                                    </center>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12 mt-3">
                                                <form action="{{url('renovacion-prestamo')}}" method="post">
                                                    @csrf
                                                        <input type="hidden" name="id_pre" value="{{$prestamo[0]->id_prestamo}}">
                                                        <input type="hidden" name="id_usuario" value="{{$cliente[0]->id}}">
                                                        <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
                                                        <input type="hidden" name="id_promotora" value="{{$prestamo[0]->id_promotora}}">
                                                        <input type="hidden" name="id_producto" value="{{$prestamo[0]->id_producto}}">
                                                        <input type="hidden" name="id_autorizo" value="{{$prestamo[0]->id_autorizo}}">
                                                        @php
                                                            $sal_restante=$monto_prestamo-$saldo;
                                                        @endphp
                                                        <input type="hidden" name="cantidad" value="{{$prestamo[0]->cantidad+500}}">
                                                        <div class="alert alert-success" role="alert">
                                                            <center>
                                                                ¡Felicidades por ser puntual, ya puede renovar su préstamo!. Con un incremento de $500.00 <b ><button style="border: none; background: transparent" type="submit" onclick="return confirm('¿Esta seguro de continuar con la operación?')"><u>Clic aqui</u></button></b>
                                                            </center>
                                                        </div>
                                                </form>
                                            </div>
                                        @endif

                                @endif
                                    
                            @elseif($fallas[0]->total_falla==1)
                                @if ($total_saldo_actual==0)
                                    @if ($prestamo[0]->id_status_prestamo==9)
                                            @php
                                                $pre_aprobados = DB::table('tbl_prestamos')
                                                ->select(DB::raw('count(*) as total_pre_10'))
                                                ->where('id_usuario', '=',$cliente[0]->id)
                                                ->where('id_status_prestamo', '=',10)
                                                ->get();
                                            @endphp
                                            @if ($pre_aprobados[0]->total_pre_10>0)
                                                <div class="col-md-12">
                                                    <div class="alert alert-warning mt-3" role="alert">
                                                        <center>
                                                            ¡Renovación en espera de aprobación!  <b ></b>
                                                        </center>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <div class="alert alert-success mt-3" role="alert">
                                                        <center>
                                                            ¡Renovación activo!  <b ></b>
                                                        </center>
                                                    </div>
                                                </div>
                                            @endif
                                    @elseif($prestamo[0]->id_status_prestamo==8)
                                            @php
                                                $pre_estatus_9 = DB::table('tbl_prestamos')
                                                ->select(DB::raw('count(*) as total_pre_9'))
                                                ->where('id_usuario', '=',$cliente[0]->id)
                                                ->where('id_status_prestamo', '=',9)
                                                ->get();
                                            @endphp
                                            @if ($pre_estatus_9[0]->total_pre_9>0)
                                                <div class="col-md-12">
                                                    <div class="alert alert-success mt-3" role="alert">
                                                        <center>
                                                            ¡Renovación activo!  <b ></b>
                                                        </center>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-12 mt-3">
                                                    <form action="{{url('renovacion-prestamo')}}" method="post">
                                                        @csrf
                                                            <input type="hidden" name="id_pre" value="{{$prestamo[0]->id_prestamo}}">
                                                            <input type="hidden" name="id_usuario" value="{{$cliente[0]->id}}">
                                                            <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
                                                            <input type="hidden" name="id_promotora" value="{{$prestamo[0]->id_promotora}}">
                                                            <input type="hidden" name="id_producto" value="{{$prestamo[0]->id_producto}}">
                                                            <input type="hidden" name="id_autorizo" value="">
                                                            @php
                                                                $sal_restante=$monto_prestamo-$saldo;
                                                            @endphp
                                                            <input type="hidden" name="cantidad" value="{{$prestamo[0]->cantidad}}">
                                                            <div class="alert alert-success" role="alert">
                                                                <center>
                                                                    ¡Ya puede renovar su préstamo!. Sin incremento por una falla. <b ><button style="border: none; background: transparent" type="submit" onclick="return confirm('¿Esta seguro de continuar con la operación?')"><u>Clic aqui</u></button></b>
                                                                </center>
                                                            </div>
                                                    </form>
                                                </div>
                                            @endif

                                    @endif
                                @else
                                    <div class="col-md-12 mt-2">
                                        <div class="alert alert-info" role="alert">
                                            <center>
                                                ¡Solo falta {{number_format($total_saldo_actual,2)}} para poder renovar!
                                            </center>
                                        </div>
                                    </div>
                                @endif
                            @elseif($fallas[0]->total_falla==2)
                                @if ($total_saldo_actual==0)
                                    @if ($prestamo[0]->id_status_prestamo==9)
                                        @php
                                            $pre_aprobados = DB::table('tbl_prestamos')
                                            ->select(DB::raw('count(*) as total_pre_10'))
                                            ->where('id_usuario', '=',$cliente[0]->id)
                                            ->where('id_status_prestamo', '=',10)
                                            ->get();
                                        @endphp
                                        @if ($pre_aprobados[0]->total_pre_10>0)
                                            <div class="col-md-12">
                                                <div class="alert alert-warning mt-3" role="alert">
                                                    <center>
                                                        ¡Renovación en espera de aprobación!  <b ></b>
                                                    </center>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="alert alert-success mt-3" role="alert">
                                                    <center>
                                                        ¡Renovación activo!  <b ></b>
                                                    </center>
                                                </div>
                                            </div>
                                        @endif
                                    @elseif($prestamo[0]->id_status_prestamo==8)
                                            @php
                                                $pre_estatus_9 = DB::table('tbl_prestamos')
                                                ->select(DB::raw('count(*) as total_pre_9'))
                                                ->where('id_usuario', '=',$cliente[0]->id)
                                                ->where('id_status_prestamo', '=',9)
                                                ->get();
                                            @endphp
                                            @if ($pre_estatus_9[0]->total_pre_9>0)
                                                <div class="col-md-12">
                                                    <div class="alert alert-success mt-3" role="alert">
                                                        <center>
                                                            ¡Renovación activo!  <b ></b>
                                                        </center>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-12 mt-3">
                                                    <form action="{{url('renovacion-prestamo')}}" method="post">
                                                        @csrf
                                                            <input type="hidden" name="id_pre" value="{{$prestamo[0]->id_prestamo}}">
                                                            <input type="hidden" name="id_usuario" value="{{$cliente[0]->id}}">
                                                            <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
                                                            <input type="hidden" name="id_promotora" value="{{$prestamo[0]->id_promotora}}">
                                                            <input type="hidden" name="id_producto" value="{{$prestamo[0]->id_producto}}">
                                                            <input type="hidden" name="id_autorizo" value="">
                                                            @php
                                                                $sal_restante=$monto_prestamo-$saldo;
                                                            @endphp
                                                            <input type="hidden" name="cantidad" value="{{$prestamo[0]->cantidad-500}}">
                                                            <div class="alert alert-success" role="alert">
                                                                <center>
                                                                    ¡Ya puede renovar su préstamo!. Con decremento de $500.00 por dos fallas. <b ><button style="border: none; background: transparent" type="submit" onclick="return confirm('¿Esta seguro de continuar con la operación?')"><u>Clic aqui</u></button></b>
                                                                </center>
                                                            </div>
                                                    </form>
                                                </div>
                                            @endif

                                    @endif
                                @else
                                    <div class="col-md-12 mt-2">
                                        <div class="alert alert-info" role="alert">
                                            <center>
                                                ¡Solo falta {{number_format($total_saldo_actual,2)}} para poder renovar!
                                            </center>
                                        </div>
                                    </div>
                                @endif
                            @elseif($fallas[0]->total_falla>=3)
                                @if ($total_saldo_actual==0)
                                    @if ($prestamo[0]->id_status_prestamo==9)
                                        @php
                                            $pre_aprobados = DB::table('tbl_prestamos')
                                            ->select(DB::raw('count(*) as total_pre_10'))
                                            ->where('id_usuario', '=',$cliente[0]->id)
                                            ->where('id_status_prestamo', '=',10)
                                            ->get();
                                        @endphp
                                        @if ($pre_aprobados[0]->total_pre_10>0)
                                            <div class="col-md-12">
                                                <div class="alert alert-warning mt-3" role="alert">
                                                    <center>
                                                        ¡Renovación en espera de aprobación!  <b ></b>
                                                    </center>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="alert alert-success mt-3" role="alert">
                                                    <center>
                                                        ¡Renovación activo!  <b ></b>
                                                    </center>
                                                </div>
                                            </div>
                                        @endif
                                    @elseif($prestamo[0]->id_status_prestamo==8)
                                            @php
                                                $pre_estatus_9 = DB::table('tbl_prestamos')
                                                ->select(DB::raw('count(*) as total_pre_9'))
                                                ->where('id_usuario', '=',$cliente[0]->id)
                                                ->where('id_status_prestamo', '=',9)
                                                ->get();
                                            @endphp
                                            @if ($pre_estatus_9[0]->total_pre_9>0)
                                                <div class="col-md-12">
                                                    <div class="alert alert-success mt-3" role="alert">
                                                        <center>
                                                            ¡Renovación activo!  <b ></b>
                                                        </center>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-12 mt-3">
                                                    <form action="{{url('renovacion-prestamo')}}" method="post">
                                                        @csrf
                                                            <input type="hidden" name="id_pre" value="{{$prestamo[0]->id_prestamo}}">
                                                            <input type="hidden" name="id_usuario" value="{{$cliente[0]->id}}">
                                                            <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
                                                            <input type="hidden" name="id_promotora" value="{{$prestamo[0]->id_promotora}}">
                                                            <input type="hidden" name="id_producto" value="{{$prestamo[0]->id_producto}}">
                                                            <input type="hidden" name="id_autorizo" value="">
                                                            @php
                                                                $sal_restante=$monto_prestamo-$saldo;
                                                            @endphp
                                                            <input type="hidden" name="cantidad" value="{{$prestamo[0]->cantidad-500}}">
                                                            <div class="alert alert-success" role="alert">
                                                                <center>
                                                                    ¡Lo sentimos pero está en la lista negra!. <b ><button style="border: none; background: transparent" type="submit" onclick="return confirm('¿Esta seguro de continuar con la operación?')"><u>Clic aqui</u></button></b>
                                                                </center>
                                                            </div>
                                                    </form>
                                                </div>
                                            @endif

                                    @endif
                                @else
                                    <div class="col-md-12 mt-2">
                                        <div class="alert alert-info" role="alert">
                                            <center>
                                                ¡Solo falta {{number_format($total_saldo_actual,2)}} para poder renovar!
                                            </center>
                                        </div>
                                    </div>
                                @endif
                            @else
                                @if ($total_saldo_actual==0)
                                    @if ($prestamo[0]->id_status_prestamo==8)
                                        @if ($pre_estatus[0]->total_pre==0)
                                            @php
                                                $pre_r_activo = DB::table('tbl_prestamos')
                                                ->select(DB::raw('count(*) as total_ativo'))
                                                ->where('id_status_prestamo', '=',9)
                                                ->where('id_usuario','=',$cliente[0]->id)
                                                ->get();
                                            @endphp

                                            @if ($pre_r_activo[0]->total_ativo==0)
                                                <div class="col-md-12 mt-3">
                                                    <form action="{{url('renovacion-prestamo')}}" method="post">
                                                        @csrf
                                                            <input type="hidden" name="id_pre" value="{{$prestamo[0]->id_prestamo}}">
                                                            <input type="hidden" name="id_usuario" value="{{$cliente[0]->id}}">
                                                            <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
                                                            <input type="hidden" name="id_promotora" value="{{$prestamo[0]->id_promotora}}">
                                                            <input type="hidden" name="id_producto" value="{{$prestamo[0]->id_producto}}">
                                                            <input type="hidden" name="id_autorizo" value="">
                                                            @php
                                                                $sal_restante=$monto_prestamo-$saldo;
                                                            @endphp
                                                            <input type="hidden" name="cantidad" value="{{$prestamo[0]->cantidad+500}}">
                                                            
                                                            <div class="alert alert-success" role="alert">
                                                                <center>
                                                                    ¡Felicidades por la puntualidad, ya puede renovar su préstamo con incremento de $500.00!  <b ><u><button style="border: none; background: transparent" type="submit" onclick="return confirm('¿Esta seguro de continuar con la operación?')">Clic aqui</button></u></b>
                                                                </center>
                                                            </div>
                                                            
                                                    </form>
                                                </div>    
                                            @else
                                            <div class="col-md-12 mt-2">
                                                <div class="alert alert-info" role="alert">
                                                    <center>
                                                        ¡Renovado!
                                                    </center>
                                                </div>
                                            </div>
                                            @endif
                                        @else
                                            <div class="col-md-12">
                                                <div class="alert alert-warning" role="alert">
                                                    <center>
                                                        ¡Renovación en espera de aprobación!
                                                    </center>
                                                </div>
                                            </div>
                                        @endif
                                    @elseif($prestamo[0]->id_status_prestamo==9)
                                        @php
                                            $pre_estatus_1 = DB::table('tbl_prestamos')
                                            ->select(DB::raw('count(*) as total_pre_1'))
                                            ->where('id_usuario', '=',$cliente[0]->id)
                                            ->where('id_status_prestamo', '=',10)
                                            ->get();
                                        @endphp
                                        @if ($pre_estatus_1[0]->total_pre_1==0)
                                            <div class="col-md-12 mt-2">
                                                <div class="alert alert-success" role="alert">
                                                    <center>
                                                        ¡Renovación activo!
                                                    </center>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="alert alert-warning" role="alert">
                                                    <center>
                                                        ¡Renovación en espera de aprobación!
                                                    </center>
                                                </div>
                                            </div>
                                        @endif 
                                    @elseif($prestamo[0]->id_status_prestamo==3)

                                    @else
                                        @if ($pre_estatus[0]->total_pre==0)
                                            <div class="col-md-12 mt-2">
                                                <div class="alert alert-success" role="alert">
                                                    <center>
                                                        ¡Préstamo activo!
                                                    </center>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="alert alert-warning" role="alert">
                                                    <center>
                                                        ¡Renovación en espera de aprobación!
                                                    </center>
                                                </div>
                                            </div>
                                        @endif 
                                    @endif
                                @else
                                    <div class="col-md-12 mt-2">
                                        <div class="alert alert-info" role="alert">
                                            <center>
                                                ¡Solo falta {{number_format($total_saldo_actual,2)}} para poder renovar!
                                            </center>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                    <br>
                </div>
            </div>
        </div>
    @else
        
    @endif
    <div class="modal fade" id="eliminarAbonoPenalizacionModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body " >
              
              <div class="col-md-12">
                <center>
                  <img src="{{asset('img/modal/question.png')}}" style="width: 50%" alt="">
      
                </center>
                
                  <center>
                    <b class="modal-title mt-2" id="exampleModalLabel"></b><br>
                    <span class="text_mensaje"></span>
                  </center>
                <br>
                <center>
                  <form id="formEliminarAbono" action="{{ url('admin/abonos/0') }}" data-action="{{ url('admin/abonos/0') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Si eliminar</button>
                  </form>
                </center>
              </div>
             
            </div>
          </div>
        </div>
    </div> 
    <div class="modal fade" id="avisoCamposVaciosModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body " >
              
              <div class="col-md-12">
                <center>
                  <img src="{{asset('img/modal/info.png')}}" style="width: 50%" alt="">
      
                </center>
                
                  <center>
                    <b class="modal-title mt-2" id="exampleModalLabel">¡Error!</b><br>
                    <span class="text_mensaje">Por favor, seleccione semana, tipo de abono, cantidad, fecha de pago y fecha de corte</span>
                  </center>
                <br>
                <center>
                  
                    <button type="button" class="btn btn-secondary" style="background: #870374" data-dismiss="modal">¡ OK !</button>
                  
                </center>
              </div>
             
            </div>
          </div>
        </div>
    </div> 
    <div class="modal fade" id="guardarAbonosModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body " >
              
              <div class="col-md-12">
                <center>
                  <img src="{{asset('img/modal/info.png')}}" style="width: 50%" alt="">
      
                </center>
                
                  <center>
                    <b class="modal-title mt-2" id="exampleModalLabel">¡Error!</b><br>
                    <span class="text_mensaje">Por favor, seleccione semana, tipo de abono, cantidad, fecha de pago y fecha de corte</span>
                  </center>
                <br>
                <center>
                  
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-secondary" style="background: #870374" onclick="guardarAbonosLista()">Si, continuar</button>
                </center>
              </div>
             
            </div>
          </div>
        </div>
    </div> 
@stop
@section('page-script')
<script>
    window.onload = function agregar_boton_atras(){
  
      document.getElementById('Atras').innerHTML='<a href="{{url('prestamo/buscar-cliente/'.$zona->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo)}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  }
</script>
<script>
    $(function(){
        $("#fecha_pago_s").change(function(){
        // var fechahoy=$('#fecha_hoy').val();
            var fecha_automatico = $('#fecha_pago_s').val();
            if (fecha_automatico.length<=9) {
                
            } else {
            setTimeout(buscar_fecha_corte,200);
            }
        });
    });

    function buscar_fecha_corte(){
        var fecha_automatico1 = $('#fecha_pago_s').val();
        id_grupo= $('#id_grupo').val();
                $('#select-corte').empty();


            const cortes_semanas = @json($cortes_semanas);
                trHTML = '';
                contar_seleccionado=0;
                $('#corte_s').empty()
                trHTML ='<option value="" >--Seleccione una fecha de corte</option>';
                cortes_semanas.forEach(function(item, index) {
                    fecha_inicio_for=convertirFecha(String(item.fecha_inicio));
                    fecha_final_for=convertirFecha(String(item.fecha_final));

                    if (fecha_automatico1 >= item.fecha_inicio && fecha_automatico1<=item.fecha_final) {
                        contar_seleccionado+=1;
                        trHTML +='<option value="'+item.id_corte_semana+'" selected>No.'+item.id_corte_semana+' Fecha: '+fecha_inicio_for+' a '+fecha_final_for+'</option>';
                    } else {
                        trHTML +='<option value="'+item.id_corte_semana+'" >No.'+item.id_corte_semana+' Fecha: '+fecha_inicio_for+' a '+fecha_final_for+'</option>';
                    }            
                    // fecha_corte_convertido=convertirFecha(item.fecha_final.toUTCString())
                
                });
                
                if (contar_seleccionado===0) {
                    $('#select-corte').append(`
                    <select class="form-control show-tick ms select2" data-placeholder="Select" id="corte_s" >
                        ${trHTML}
                    </select>
                    <center>
                        <small style="color:gray">Nota: Sin resultados, seleccione una de la lista</small>
                    </center>
                    `);
                } else {
                    $('#select-corte').append(`
                    <select class="form-control show-tick ms select2" data-placeholder="Select" id="corte_s" >
                        ${trHTML}
                    </select>
                    `);
                }


        
    }



function convertirFecha(fecha){
    //Objeto javascript que vamos a utilizar como tabla hash para
    //La conversion de los meses a su representacion numerica

    let conversorMeses = {
        '01' : '01',
        '02' : '02',
        '03' : '03',
        '04' : '04',
        '05' : '05',
        '06' : '06',
        '07' : '07',
        '08' : '08',
        '09' : '09',
        '10' : '10',
        '11' : '11',
        '12' : '12'
    };
 año

    let paramFecha = fecha.split("-");

    //Una vez tenemos los datos montamos el string resultante 
    let fechaRes =   paramFecha[2]+ "/" + conversorMeses[paramFecha[1]] + "/" +paramFecha[0];

    return fechaRes;

}
</script>
    <script>
        $('#guardarAbonosModel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var mensaje = button.data('mensaje')

            var modal = $(this)
            modal.find('.modal-title').text('¿Está seguro de continuar con la operación?')
            modal.find('.text_mensaje').text(mensaje)
            
        });

        function guardarAbonosLista(){
            document.getElementById("guardarAbonosLista").submit();
        }

        $('#eliminarAbonoPenalizacionModel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var mensaje = button.data('mensaje')

            action = $('#formEliminarAbono').attr('data-action').slice(0,-1) 
            action += id
            // console.log(action)

            $('#formEliminarAbono').attr('action',action)

            var modal = $(this)
            modal.find('.modal-title').text('¿Está seguro de eliminar el abono #' + id +' ?')
            modal.find('.text_mensaje').text(mensaje)
            
        });
        
    </script>
    <script>
        
        function buscar_prestamo()
        {
            document.getElementById("formPrest").submit();
        }
    </script>

    <script>
        function agregar_semana1(){
            let semana1=$("#semana1 option:selected").val();
            $("#in_semana1").val(semana1);
        }
        function agregar_semana2(){
            let semana2=$("#semana2 option:selected").val();
            $("#in_semana2").val(semana2);
        }
        function a_tipoabono1(){
            let tipo_a1=$("#id_tipoabono1 option:selected").val();
            $("#in_tipo_abono1").val(tipo_a1);
        }
        function a_tipoabono2(){
            let tipo_a2=$("#id_tipoabono2 option:selected").val();
            $("#in_tipo_abono2").val(tipo_a2);
        }

        
        function agregar_abono(){
            let corte = $("#corte_s option:selected").val();
            let semana = $("#semana_s option:selected").val();
            let id_tipoabono = $("#id_tipoabono_s option:selected").val();
            let cantidad = $("#cantidad_s").val();
            let fecha_pago = $("#fecha_pago_s").val();
            let saldo_liq = $("#saldo_liq").val();

            
            
            if (corte=='' || semana=='' || id_tipoabono=='' || cantidad=='' || fecha_pago=='') {
                aviso_de_campos_vacios();
                // alert('Seleccione semana, tipo de abono, cantidad y la fecha de pago');
            } else {
                if (id_tipoabono=='1') {
                    $("#tblAbonos").append(`
                    
                        <tr id="tr-${semana}">
                            <td>
                                <input type="hidden" name="corte_e[]" value="${corte}">
                                <input type="hidden" name="semana_e[]" value="${semana}">
                                <input type="hidden" name="id_tipoabono_e[]" value="${id_tipoabono}">
                                <input type="hidden" name="cantidad_e[]" value="${saldo_liq}">
                                <input type="hidden" name="fecha_pago_e[]" value="${fecha_pago}">
                                <center>
                                    ${corte}    
                                </center>
                            </td>
                            <td>
                                <center>
                                    ${semana}    
                                </center>
                            </td>
                            <td>
                                <center>
                                    ${id_tipoabono}    
                                </center>
                            </td>
                            <td>
                                <center>
                                    $ ${saldo_liq}
                                </center>
                            </td>
                            <td>
                                <center>
                                    ${fecha_pago}
                                </center>
                            </td>
                            <td>
                                <center>
                                    <button type="button" onclick="eliminar_abono(${semana})" class="btn btn-danger btn-sm">X</button>
                                </center>
                            </td>
                        </tr>

                    `);
                document.getElementById("boton").style.display = "block";
                } else {
                    $("#tblAbonos").append(`
                        
                            <tr id="tr-${semana}">
                                <td>
                                    <input type="hidden" name="corte_e[]" value="${corte}">
                                    <input type="hidden" name="semana_e[]" value="${semana}">
                                    <input type="hidden" name="id_tipoabono_e[]" value="${id_tipoabono}">
                                    <input type="hidden" name="cantidad_e[]" value="${cantidad}">
                                    <input type="hidden" name="fecha_pago_e[]" value="${fecha_pago}">
                                    <center>
                                        ${corte}    
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        ${semana}    
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        ${id_tipoabono}    
                                    </center>
                                </td>
                                <td>
                                    <center>
                                       $ ${cantidad}
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        ${fecha_pago}
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <button type="button" onclick="eliminar_abono(${semana})" class="btn btn-danger btn-sm">X</button>
                                    </center>
                                </td>
                            </tr>

                    `);
                    document.getElementById("boton").style.display = "block";
                    
                }
                
            }
        }

        function eliminar_abono(id){
            $("#tr-"+id).remove();
        }

        function aviso_de_campos_vacios(){
            $('#avisoCamposVaciosModel').modal('show');
        }
    </script>
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop