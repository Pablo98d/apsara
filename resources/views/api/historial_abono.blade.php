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
            font-size: 13px;
        }
        .fila{
            
            width: 100%;
        }
        .text-1{
            width: 70px;
            p

        }
        .separador-text{
            width: 150px;
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
            font-size: 13px;
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
            {{--<img class="float-right" src="{{asset('assets/images/lf/logoHada.png')}}" width="170" height="170">--}}
            {{-- <img class="float-right" src="{{asset('assets/images/lf/logoHada.png')}}" width="170" height="170"> --}}
            <img  class="float-right" style="margin-left:105px; margin-bottom: 5px; z-index: -80; margin-top: 2px;"  src="{{asset('img/logoferiecita.png')}}" width="170px" height="80px">
            
            <div>
                <label class="label" for="">GRUPO</label>
                <br>
            <label class="label-2" for="">{{$region_zona[0]->grupo}}</label>
            </div>
            
            <label class="mt-1 text-grande">
                Relación de pagos
                
            </label>
            <br>
            <label for="" class="text-1 label"><b>Monto:</b></label>
            <label for="" class="mr-4 label-2"><b>${{$prestamo[0]->cantidad}}.00</b></label>
            <label class="separador-text">h</label>
                @php
                    $datee = date_create($prestamo[0]->fecha_entrega_recurso);
                @endphp
            <label for="" class="text-1 label"><b>Fecha:</b></label>
            <label for="" class="label-2"><b>{{date_format($datee, 'd-m-Y H:i:s')}}</b></label>
            
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
                        <td><small> Dir.: {{$cliente[0]->direccion}} No.Ex.: {{$cliente[0]->numero_exterior}} No.In. {{$cliente[0]->numero_interior}} Col.: {{$cliente[0]->colonia}} CP: {{$cliente[0]->codigo_postal}} Loc.: {{$cliente[0]->localidad}} Mun.: {{$cliente[0]->municipio}} Edo.:{{$cliente[0]->estado}} </small> </td>
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
        {{-- <div class="col-md-4">
            <small><b>Cliente</b></small><br>
            <label for="">{{$cliente[0]->id}} {{$cliente[0]->nombre}} {{$cliente[0]->ap_paterno}} {{$cliente[0]->ap_materno}}</label>
        </div>
        <div class="col-md-2">
            <small><b>Préstamo</b></small><br>
            <label for="">{{$prestamo[0]->producto}}</label>
        </div> --}}
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
                                    @if ($abono->id_tipoabono==4)
                                        @php
                                            $multa1=$abono->cantidad;
                                            $saldo+=0;
                                            $monto_prestamo+=$multa1;
                                            $saldototal=$monto_prestamo-$saldo;

                                        @endphp
                                        <small><span class="badge badge-pill badge-danger"> $ {{$multa1}}.00</span></small>
                                    @elseif($abono->id_tipoabono==5)
                                        @php
                                            $multa2=$abono->cantidad;
                                            $saldo+=0;
                                            $monto_prestamo+=$multa2;
                                            $saldototal=$monto_prestamo-$saldo;

                                        @endphp
                                        <small><span class="badge badge-pill badge-danger"> $ {{$multa2}}.00</span></small>
                                    @else
                                        <small>
                                            @php
                                                $saldo+=$abono->cantidad;
                                                $saldototal=$monto_prestamo-$saldo;
                                            @endphp
                                            <small> $ {{$abono->cantidad}}.00</small>
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
                                        ${{$saldototal}}.00
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
                            <label style="width: 200px"><small><b>Total abonado: </b>$ {{$saldo}}.00</small></label>
                            <label style="width: 200px"><small><b>Saldo actual: </b>$ {{$monto_prestamo-$saldo}}.00</small></label>
                            <label style="width: 190px"><small><b>Total a pagar: </b>$ {{$monto_prestamo}}.00</small></label><br>
                            <br>
                        <label style="width: 250px; text-align: center">Firma</label>
                        <label style="width: 100px; text-align: center; color: #fff">d</label>
                        <label style="width: 250px; text-align: center">Fecha</label><br>
                        <label style="width: 250px; text-align: center">_____________________________</label>
                        <label style="width: 100px; text-align: center; color: #fff">d</label>
                        <label style="width: 250px; text-align: center">________________________</label>
                        </div>
                        @php
                            $pre_estatus = DB::table('tbl_prestamos')
                            ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                            ->select(DB::raw('count(*) as total_pre'))
                            ->where('tbl_prestamos.id_status_prestamo', '=',9)
                            ->where('tbl_abonos.id_tipoabono', '=',1)
                            ->where('tbl_prestamos.id_prestamo', '=',$prestamo[0]->id_prestamo)
                            ->get();
                        @endphp
                        @if ($t_prestamos[0]->total_pres==12)

                            @if ($prestamo[0]->id_status_prestamo==9)
                            <div class="col-md-12">
                                <br>
                                <label style="width: 600px; color:rgb(255, 178, 13); 12px; text-align: right;"><small>
                                        !Renovación en espera de aprobación! 
                                  </small>
                                </label>
                            </div>
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
                                            <label style="width: 600px; color:green; 12px; text-align: right;"><small>
                                                    ¡Renovación activo!
                                                    </small>
                                            </label>  
                                            
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            <br>
                                            <label style="width: 600px; color:green; 12px; text-align: right;"><small>
                                                ¡Felicidades por ser puntual, ya puede renovar su préstamo!
                                            </small>
                                        </div>
                                    @endif

                            @endif
                                
                        @else
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
                                            <label style="width: 600px; color:green; 12px; text-align: right;"><small>
                                                ¡Ya puedes renovar tu préstamo!
                                            </small>
                                            </label>
                                        </div>    
                                    @else
                                    <div class="col-md-12 mt-2">
                                        <br>
                                                <label style="width: 600px; color:rgb(13, 90, 255); 12px; text-align: right;"><small>
                                                    ¡Renovado!
                                                </small>
                                                </label>
                                    </div>
                                    @endif
                                @else
                                    <div class="col-md-12">
                                        <br>
                                                <label style="width: 600px; color:rgb(255, 178, 13); 12px; text-align: right;"><small>
                                                    ¡Renovación en espera de aprobación!
                                                </small>
                                                </label>
                                                
                                         
                                    </div>
                                @endif
                            @elseif($prestamo[0]->id_status_prestamo==9)
                                @php
                                    $pre_estatus_1 = DB::table('tbl_prestamos')
                                    ->select(DB::raw('count(*) as total_pre_1'))
                                    ->where('id_usuario', '=',$cliente[0]->id)
                                    ->where('id_status_prestamo', '=',1)
                                    ->get();
                                @endphp
                                @if ($pre_estatus_1[0]->total_pre_1==0)
                                    <div class="col-md-12 mt-2">
                                        <br>
                                                <label style="width: 600px; color:green; 12px; text-align: right;"><small>
                                                    ¡Renovación activo!
                                                </small>
                                                </label>
                                            
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <br>
                                                <label style="width: 600px; color:rgb(255, 178, 13); 12px; text-align: right;"><small>
                                                    ¡Renovación en espera de aprobación!
                                                </small>
                                                </label>
                                         
                                    </div>
                                @endif 
                            @elseif($prestamo[0]->id_status_prestamo==3)

                            @else
                                @if ($pre_estatus[0]->total_pre==0)
                                    <div class="col-md-12 mt-2"><br>
                                                <label style="width: 600px; color:green; 12px; text-align: right;"><small>
                                                    ¡Préstamo activo!
                                                </small>
                                                </label>
                                                    
                                         
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <br>
                                                <label style="width: 600px; color:rgb(255, 178, 13); 12px; text-align: right;"><small>
                                                    ¡Renovación en espera de aprobación!
                                                </small>
                                                </label>
                                    </div>
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
