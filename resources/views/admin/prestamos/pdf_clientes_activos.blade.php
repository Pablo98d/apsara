<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de corte varias semanas</title>

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
            /*margin: 0 !important;*/
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
<body>
    <div class="contenido-general">
        <hr class="hr-1">
        <div class="contenido-text">
            {{--<img class="float-right" src="{{asset('assets/images/lf/logoHada.png')}}" width="170" height="170">--}}
            {{-- <img class="float-right" src="{{asset('assets/images/lf/logoHada.png')}}" width="170" height="170"> --}}
            <img  class="float-right" style="margin-left:105px; margin-bottom: 5px; z-index: -80; margin-top: 2px;"  src="{{asset('img/logoferiecita.png')}}" width="170px" height="80px">
            
            <div>
                <label class="label" for="">Zona</label>  <label style="margin-left: 180px" class="label" for="">Grupo</label>
                <br>
            <label class="label-2" for="">{{$zona->Zona}}</label> 
            <label style="margin-left: 150px" class="label-2"  for="">{{$grupo->grupo}}</label>
            </div>
            
            <label class="mt-1 text-grande">
                @if($estatus==2)
                    Clientes Activos / Renovados
                @elseif($estatus==6)
                    Clientes Inactivos
                @elseif($estatus==3)
                    Clientes Morosos
                @endif
                
            </label>
        </div>
        <br> 
   
            <br>
                <!--<label style="color: #000;">Corte de hace <b></b> semanas</label> <label style="color: #000; margin-left:140px;">Reporte generado </label>-->
            <div class="row mt-4">
                <!--<div class="col-md-12">-->
                    <br><br>
                <!--</div>-->
                <div class="col-md-12">
                    <table>
                        <thead>
                            <tr>
                                <th style="color: black; font-size: 11px;">Cliente</th>
                                <th style="color: black; font-size: 11px;">Detalle préstamo</th>
                                <th style="color: black; font-size: 11px;">Estatus</th>
                                <th style="color: black; font-size: 11px;">Fecha de entrega</th>
                                <th style="color: black; font-size: 11px;">último abono</th>
                                <th style="color: black; font-size: 11px;">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_cantidad=0;
                                $total_saldo=0;
                                $total_abonado=0;
                            @endphp
                            @foreach($prestamos as $prestamo)
                                <tr>
                                    <td>
                                        <small>{{$prestamo->nombre}} {{$prestamo->ap_paterno}} {{$prestamo->ap_materno}}</small>
                                    </td>
                                    <td style="text-align: right; ">
                                        <center>
                                            @php
                                                $total_cantidad+=$prestamo->cantidad;
                                            @endphp
                                            <small>#{{$prestamo->id_prestamo}}</small> /
                                            $ {{number_format($prestamo->cantidad,1)}}
                                        </center>
                                    
                                    </td>
                                    <td>
                                    
                                            @if($prestamo->id_status_prestamo==9)
                                                <span class="badge badge-primary">Renovación</span>
                                            @elseif($prestamo->id_status_prestamo==2)
                                                <span class="badge badge-success">Activo</span>
                                            @elseif($prestamo->id_status_prestamo==6)
                                                <span class="badge badge-secondary">Inactivo</span>
                                            @elseif($prestamo->id_status_prestamo==3)
                                                <span class="badge badge-dark">Moroso</span>
                                            @elseif($prestamo->id_status_prestamo==8)
                                                <span class="badge badge-danger">Pagado</span>
                                            @endif
                                    
                                    </td>
                                    <td style="text-align: right">
                                        @php
                                            $fechaEntrega = $prestamo->fecha_entrega_recurso;
                                            setlocale(LC_TIME, "spanish");
                                            $fecha_e = $fechaEntrega;
                                            $fecha_e = str_replace("/", "-", $fecha_e);
                                            $Nueva_Fecha_e = date("d-M-Y", strtotime($fecha_e));
                                        @endphp
                                           {{$Nueva_Fecha_e}}
                                    
                                    </td>
                                    <td style="text-align: right">
                                        @php
                                            $abonos = DB::table('tbl_abonos')
                                            ->select('tbl_abonos.*')
                                            ->where('tbl_abonos.id_prestamo','=',$prestamo->id_prestamo)
                                            ->whereNotIn('semana', [0])
                                            ->orderBy('fecha_pago','ASC')
                                            ->get();
                                        @endphp
                                        @if(count($abonos)==0)
                                            @php
                                                $total_abonado+=0;
                                            @endphp
                                            <smal>Ningún abono</smal> 
                                        @else
                                            @php
                                                $total_abonado+=$abonos->last()->cantidad;
                                            @endphp
                                            <smal>Semana: {{$abonos->last()->semana}}</smal> / 
                                            <smal>$ {{number_format($abonos->last()->cantidad,2)}}</smal>
                                        @endif
                                        
                                    </td>
                                    <td style="text-align: right">
                                        @php
                                            $producto = DB::table('tbl_productos')   
                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                            ->select('tbl_productos.*')
                                            ->where('tbl_prestamos.id_prestamo','=',$prestamo->id_prestamo)
                                            ->get();
                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                            ->select('cantidad')
                                            ->where('id_prestamo','=',$prestamo->id_prestamo)
                                            ->get();
                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                            ->where('id_prestamo', '=', $prestamo->id_prestamo)
                                            ->where('id_tipoabono','=',1)
                                            ->get();
                                            $tipo_abono = DB::table('tbl_abonos')
                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                            ->where('id_prestamo', '=', $prestamo->id_prestamo)
                                            ->where('id_tipoabono','=',2)
                                            ->get();
                                            $tipo_ahorro = DB::table('tbl_abonos')
                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                            ->where('id_prestamo', '=', $prestamo->id_prestamo)
                                            ->where('id_tipoabono','=',3)
                                            ->get();
                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                            ->where('id_prestamo', '=', $prestamo->id_prestamo)
                                            ->where('id_tipoabono','=',4)
                                            ->get();
                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                    $multa1=0;
                                                }else {
                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                }
                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                            ->where('id_prestamo', '=', $prestamo->id_prestamo)
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
                                            $saldo=$sistema_total_cobrar-$cliente_pago;
                                          
                                            
                                            $total_saldo+=$saldo;
                                            
                                        @endphp
                                            $ {{number_format($saldo,1)}}
                                        
                                    </td>
                                </tr>
                            @endforeach
                            
                            <tr >
                                <td style="border-top: 2px solid color:#000;">-</td>
                                <td style="border-top: 2px solid color:#000; text-align: right;"> 
                                <center>Total: 
                                    $ {{number_format($total_cantidad,1)}}</td>
                                </center> 
                                <td style="border-top: 2px solid color:#000;">-</td>
                                <td style="border-top: 2px solid color:#000;">-</td>
                                 <td style="text-align: right; border-top: 2px solid color:#000;">$ {{number_format($total_abonado,1)}}</td>
                                <td style="text-align: right; border-top: 2px solid color:#000;">$ {{number_format($total_saldo,1)}}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    
                    
                </div>
            </div>
    <br>
    

    </div>
</body>
</html>