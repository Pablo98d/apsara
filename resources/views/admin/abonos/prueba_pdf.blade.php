<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de abono pdf</title>

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
    @php
        $fechaActual = $fecha_de_hoy;
        setlocale(LC_TIME, "spanish");
        $fecha_a = $fechaActual;
        $fecha_a = str_replace("/", "-", $fecha_a);
        $Nueva_Fecha_a = date("d-m-Y H:i", strtotime($fecha_a));
    @endphp
    {{-- <header> --}}
        <label for="" style="margin-left:37px">
            <span style="font-size: 10px; ">Reporte generado {{$Nueva_Fecha_a}}</span>
        </label>
        {{-- <img src="{{asset('img/logoferiecita.png')}}" width="70px" style="position: fixed; margin-left: 645px; margin-top: 15px" alt=""> --}}
        
    {{-- </header> --}}
<body>
    <div class="contenido-general">
        <hr class="hr-1">
        <div class="contenido-text">
            {{--<img class="float-right" src="{{asset('assets/images/lf/logoHada.png')}}" width="170" height="170">--}}
            {{-- <img class="float-right" src="{{asset('assets/images/lf/logoHada.png')}}" width="170" height="170"> --}}
            <img  class="float-right" style="margin-left:105px; margin-bottom: 5px; z-index: -80; margin-top: 2px;"  src="{{asset('img/logoferiecita.png')}}" width="170px" height="80px">
            
            <div>
                <label class="label" for="">Grupo</label>
                <br>
            <label class="label-2" for="">{{$region_zona[0]->grupo}}</label>
            </div>
            
            <label class="mt-1 text-grande">
                Relación de pagos
                
            </label>
            <br>
            <label for="" class="text-1-1 label"><b>Monto:</b></label>
            <label for="" class="mr-4 label-2-2"><b>{{$prestamo[0]->producto}}</b></label>
            <label class="separador-text">h</label>
                @php
                    $datee = date_create($prestamo[0]->fecha_entrega_recurso);
                @endphp
            <label for="" class="text-1 label"><b>Fecha entrega recurso:</b></label>
            <label for="" class="label-2-2"><b>{{date_format($datee, 'd-m-Y H:i:s')}}</b></label>
           
            
            <div class="estilo-tabladia">
                <table>
                    
                        <tr>
                            <th class="ancho-1">Cliente</th>
                            <th class="ancho-2">Teléfono</th>
                            <th class="ancho-3">Dirección</th>
                        </tr>
                    
                    
                    <tr>
                        <td>{{$cliente[0]->nombre}} {{$cliente[0]->ap_paterno}} {{$cliente[0]->ap_materno}}</td>
                        <td>Tel.: {{$cliente[0]->telefono_casa}} Cel.: {{$cliente[0]->telefono_celular}}  </td>
                        <td><small> Calle.: {{$cliente[0]->calle}} No.Ex.: {{$cliente[0]->numero_ext}} No.In. {{$cliente[0]->numero_int}} Entre calles: {{$cliente[0]->entre_calles}} Loc.: {{$cliente[0]->colonia_localidad}} Mun.: {{$cliente[0]->municipio}} Edo.:{{$cliente[0]->estado}} Referencia:{{$cliente[0]->referencia_visual}} </small> </td>
                    </tr>
                </table>
            </div>
            <div class="estilo-tabladia">
                <table>
                    
                        <tr>
                            <th class="ancho-1">Aval</th>
                            <th class="ancho-2">Teléfono</th>
                            <th class="ancho-3">Dirección</th>
                        </tr>
                    
                    
                    <tr>
                        @if (count($aval)==0)
                            <td>
                                No tiene aval
                            </td>
                        @else
                            <td>{{$aval[0]->nombre}} {{$aval[0]->ap_paterno}} {{$aval[0]->ap_materno}}</td>
                            <td>Tel.: {{$aval[0]->telefono_casa}} Cel.: {{$aval[0]->telefono_movil}}  </td>
                            <td><small> Calle.: {{$aval[0]->calle}} Entre calles: {{$aval[0]->entre_calles}} No.Ex.: {{$aval[0]->numero_ext}} No.In. {{$aval[0]->numero_int}} Col.: {{$aval[0]->colonia}} Mun.: {{$aval[0]->municipio}} Edo.:{{$aval[0]->estado}} </small> </td>
                            
                        @endif
                    </tr>
                </table>
            </div>
            <br>

    
    <div class="row mt-2">
        <div class="col-md-3">
            @php
                $papeleo=$prestamo[0]->cantidad*0.05;
                $interes=$prestamo[0]->cantidad*($prestamo[0]->pago_semanal/100)*$prestamo[0]->semanas;
                $interes_neto=$prestamo[0]->cantidad*($prestamo[0]->reditos/100);
                $total_prestamo=$papeleo+$interes;

            @endphp
        </div>
    </div>
        
    {{-- <hr> --}}
    @php
        $t_prestamos = DB::table('tbl_abonos')
        ->select(DB::raw('count(*) as total_pres'))
        ->where('id_prestamo', '=', $prestamo[0]->id_prestamo)
        ->whereBetween('semana', [1, 12])
        ->where('cantidad', '>',0)
        ->get();
    @endphp
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
    @elseif ($prestamo[0]->id_status_prestamo==2)
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
          <span class="badge badge-dark">Préstamo activo</span>
        </div>
    </div>
    @elseif ($prestamo[0]->id_status_prestamo==9)
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
          <span class="badge badge-primary">Préstamo renovado</span>
        </div>
    </div>
    @endif
    @if (!empty($datosabonos))
        <div class="row mt-1">
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
                    <table>
                        <thead>
                            <tr>
                                <th style="color: black; font-size: 11px; margin-left: 30px">No.A</th>
                                <th style="color: black; font-size: 11px">No.P</th>
                                <th style="color: black; font-size: 11px">Semanas</th>
                                <th style="color: black; font-size: 11px">Cantidad</th>
                                <th style="color: black; font-size: 11px">Tipo abono</th>
                                <th style="color: black; font-size: 11px">Saldo</th>
                                <th style="color: black; font-size: 11px">Fecha de pago</th>
                                
                            </tr>
                        </thead>
                        <tbody id="myList">
                            @foreach ($datosabonos as $abono)
                            <tr>
                                <td>
                                    <small> {{$abono->id_abono}}</small>
                                </td>
                                <td>
                                    <small> {{$abono->id_prestamo}}</small>
                                </td>
                                <td>
                                    <small>
                                        <small> Semana {{$abono->semana}}</small>
                                    </small>
                                <td>
                                    {{-- @php --}}
                                        {{-- $saldo+=$abono->cantidad;
                                        $multa1=$prestamo[0]->cantidad*0.1+50; --}}
                                    {{-- @endphp --}}

                                    @if ($abono->id_tipoabono==4)
                                        @php
                                            $multa1=$prestamo[0]->cantidad*($prestamo[0]->pago_semanal/100)+$prestamo[0]->penalizacion;

                                            $saldo+=$abono->cantidad;

                                            $monto_prestamo+=$multa1;

                                            $saldototal=$monto_prestamo-$saldo;

                                        @endphp
                                        <small><span class="badge badge-pill badge-danger"> $ {{number_format($multa1,2)}}</span></small>
                                    @elseif($abono->id_tipoabono==5)
                                        @php
                                            $multa2=$prestamo[0]->penalizacion;
                                            $saldo+=$abono->cantidad;
                                            $monto_prestamo+=$multa2;
                                            $saldototal=$monto_prestamo-$saldo;

                                        @endphp
                                        <small><span class="badge badge-pill badge-danger"> $ {{number_format($multa2,2)}}</span></small>
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
                                            <small> $ {{number_format($abono->cantidad,2)}}</small>
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <center>
                                        <small>{{$abono->tipoAbono}}</small>
                                    </center>
                                </td>
                                <td>
                                    <small>
                                        ${{number_format($saldototal,2)}}
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
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr class="hr-3">
                    
                    <div class="row">
                        <div class="col-md-3" style="text-align: right">
                            <label style="width: 200px"><small><b>Total abonado: </b>$ {{number_format($saldo,2)}}</small></label>
                            <label style="width: 200px"><small><b>Saldo actual: </b>$ {{number_format($monto_prestamo-$saldo,2)}}</small></label>
                            <label style="width: 190px"><small><b>Total a pagar: </b>$ {{number_format($monto_prestamo,2)}}</small></label><br>
                            <br>
                        <label style="width: 250px; text-align: center">Firma</label>
                        <label style="width: 100px; text-align: center; color: #fff">d</label>
                        <label style="width: 250px; text-align: center">Fecha</label><br>
                        <label style="width: 250px; text-align: center">_____________________________</label>
                        <label style="width: 100px; text-align: center; color: #fff">d</label>
                        <label style="width: 250px; text-align: center">________________________</label>
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
                                <br>
                                                        <center>
                                                            <span class="badge badge-info" style="margin-top: 5px; float: right;">
                                                                ¡Su siguiente préstamo está por entregarse!
                                                            </span>
                                                        </center>
                                
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
                            @if ($t_prestamos[0]->total_pres==14)

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
                                            <br>
                                            <center>
                                                <span class="badge badge-warning" style="margin-top: 5px; float: right;">
                                                    ¡Renovación en espera de aprobación! 
                                                </span>
                                            </center>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <br>
                                            <center>
                                                <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                    ¡Renovación activo! 
                                                </span>
                                            </center>
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
                                                <br>
                                                        <center>
                                                            <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                                ¡Renovación activo!  
                                                            </span>
                                                        </center>
                                                
                                            </div>
                                        @else
                                            <div class="col-md-12 mt-3">
                                                <br>
                                                        <center>
                                                            <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                                ¡Felicidades por ser puntual, ya puede renovar su préstamo!. Con un incremento de $500.00
                                                            </span>
                                                        </center>
                                                        
                                            </div>
                                        @endif

                                @endif
                                    
                            @elseif($fallas[0]->total_falla==1)
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
                                            <br>
                                            <center>
                                                <span class="badge badge-warning" style="margin-top: 5px; float: right;">
                                                    ¡Renovación en espera de aprobación! 
                                                </span>
                                            </center>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <br>
                                            <center>
                                                <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                    ¡Renovación activo! 
                                                </span>
                                            </center>
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
                                                <br>
                                                        <center>
                                                            <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                                ¡Renovación activo! 
                                                            </span>
                                                        </center>
                                        
                                            </div>
                                        @else
                                            <div class="col-md-12 mt-3">
                                            
                                                        @php
                                                            $sal_restante=$monto_prestamo-$saldo;
                                                        @endphp
                                                        <br>
                                                        <center>
                                                            <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                                ¡Ya puede renovar su préstamo!. Sin incremento por una falla
                                                            </span>
                                                        </center>
                                                        
                                            </div>
                                        @endif

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
                                                <br>
                                                <center>
                                                    <span class="badge badge-warning" style="margin-top: 5px; float: right;">
                                                        ¡Renovación en espera de aprobación! 
                                                    </span>
                                                </center>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <br>
                                                <center>
                                                    <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                        ¡Renovación activo! 
                                                    </span>
                                                </center>
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
                                                    <br>
                                                            <center>
                                                                <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                                    ¡Renovación activo! 
                                                                </span>
                                                            </center>
                                                    
                                                </div>
                                            @else
                                                <div class="col-md-12 mt-3">
                                                    
                                                            @php
                                                                $sal_restante=$monto_prestamo-$saldo;
                                                            @endphp
                                                            <br>
                                                            <center>
                                                                <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                                    ¡Ya puede renovar su préstamo!. Con decremento de $500.00 por dos fallas
                                                                </span>
                                                            </center>
                                                            
                                                </div>
                                            @endif

                                    @endif
                                @else
                                    <div class="col-md-12 mt-2">
                                        <br>
                                                            <center>
                                                                <span class="badge badge-info" style="margin-top: 5px; float: right;">
                                                                    ¡Solo falta {{number_format($total_saldo_actual,2)}} para poder renovar!
                                                                </span>
                                                            </center>
                                        
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
                                                <br>
                                                <center>
                                                    <span class="badge badge-warning" style="margin-top: 5px; float: right;">
                                                        ¡Renovación en espera de aprobación! 
                                                    </span>
                                                </center>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <br>
                                                <center>
                                                    <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                        ¡Renovación activo! 
                                                    </span>
                                                </center>
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
                                                    <br>
                                                            <center>
                                                                <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                                    ¡Renovación activo! 
                                                                </span>
                                                            </center>
                                                    
                                                </div>
                                            @else
                                                <div class="col-md-12 mt-3">
                                                    
                                                            @php
                                                                $sal_restante=$monto_prestamo-$saldo;
                                                            @endphp
                                                            <br>
                                                            <center>
                                                                <span class="badge badge-dark" style="margin-top: 5px; float: right;">
                                                                    ¡Lo sentimos pero está en la lista negra!
                                                                </span>
                                                            </center>
                                                            
                                                </div>
                                            @endif

                                    @endif
                                @else
                                    <div class="col-md-12 mt-2">
                                        <br>
                                                            <center>
                                                                <span class="badge badge-info" style="margin-top: 5px; float: right;">
                                                                    ¡Solo falta {{number_format($total_saldo_actual,2)}} para poder renovar!
                                                                </span>
                                                            </center>
                                        
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
                                                <div class="col-md-12">
                                                
                                                    @php
                                                        $sal_restante=$monto_prestamo-$saldo;
                                                    @endphp
                                                    <br>
                                                    <center>
                                                        <span class="badge badge-success" style="margin-top: 5px; float: right;">¡Felicidades por la puntualidad, ya puede renovar su préstamo con un incremento de $500.00! </span>
                                                    </center>
                                                            
                                                </div> 
                                            @else
                                            <div class="col-md-12 mt-2">
                                                <br>
                                                <center>
                                                    <span class="badge badge-info" style="margin-top: 5px; float: right;">¡Renovado! </span>
                                                </center>
                                            </div>
                                            @endif
                                        @else
                                            <div class="col-md-12">

                                                <br>
                                                <center>
                                                    <span class="badge badge-warning" style="margin-top: 5px; float: right;">¡Renovación en espera de aprobación!</span>
                                                </center>
                                                
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
                                                <br>
                                                <center>
                                                    <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                        ¡Renovación activo!
                                                    </span>
                                                </center>
                                                
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <br>
                                                <center>
                                                    <span class="badge badge-warning" style="margin-top: 5px; float: right;">
                                                        ¡Renovación en espera de aprobación!
                                                    </span>
                                                </center>
                                    
                                            </div>
                                        @endif 
                                    @elseif($prestamo[0]->id_status_prestamo==3)

                                    @else
                                        @if ($pre_estatus[0]->total_pre==0)
                                            <div class="col-md-12 mt-2">
                                                <br>
                                                <center>
                                                    <span class="badge badge-success" style="margin-top: 5px; float: right;">
                                                        ¡Préstamo activo!
                                                    </span>
                                                </center>
                                                
                                                
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <br>
                                                <center>
                                                    <span class="badge badge-warning" style="margin-top: 5px; float: right;">
                                                        ¡Renovación en espera de aprobación!
                                                    </span>
                                                </center>
                                            </div>
                                        @endif 
                                    @endif
                                @else
                                    @if ($prestamo[0]->id_status_prestamo==16)
                                        <div class="col-md-12 mt-2">
                                            <br>
                                            <center>
                                                <span class="badge badge-danger" style="margin-top: 5px; float: right;">
                                                    ¡El préstamo se devolvió!
                                                </span>
                                            </center>
                                            
                                        </div>
                                    @else
                                        <div class="col-md-12 mt-2">
                                            <br>
                                            <center>
                                                <span class="badge badge-info" style="margin-top: 5px; float: right;">
                                                    ¡Solo falta {{number_format($total_saldo_actual,2)}} para poder renovar!
                                                </span>
                                            </center>
                                        
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        
    @else
        
    @endif
        </div>
    </div>
</body>
</html>
