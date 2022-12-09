<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de prestamos anticipados</title>

    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
       
    <style>
        body{
            font-family: sans-serif;
        }
        hr{
            border: solid 1px #210A68;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .estilo-tabla{
            margin: 6px auto;
            width: 100%;

        }
        table {
            background-color: white;
            border-collapse: collapse;
            width: 100%;
        }

        thead{
            background-color: #3728A2;
            border-bottom: solid 2px #210A68;
            color: white;
            font-size: 8px;
            /* text-align: center; */
        }
        tbody{
            font-size: 9px;
        }
        tr:nth-child(odd){
            background-color: rgb(240, 239, 239);
        }
        th{
            padding: 1px;
        }
        td{
            padding: 1px;
        }
        .titulo-pdf{
            font-size: 12px;
            font-weight: 500;
            color: rgb(1, 52, 194);
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="contenido-text">
        <label style="font-size: 9px;float: right;margin-top: -4px;" for=""><b>Fecha:</b>{{$fecha_hoy->format('d-m-Y')}}</label> 
        <hr style="">
        @php
        @endphp
        <img style=" position: absolute; z-index: 1; top: 17px; margin-right: 30px; float: right;"  src="{{asset('img/logo/Logo Prestamos.jpg')}}" width="125px" height="70px">
        <label style="background: rgb(223, 223, 223); text-align: center; padding-bottom: 1px; width: 455px; margin-top: 10px" class="titulo-pdf">Solicitud de préstamos anticipados <br> <span style="font-size: 10px;">Director</span></label><br>
        <label style="font-size: 9px; width: 150px; margin:0px;" for=""><b>Región:</b> {{$region->Plaza}}</label>
        <label style="font-size: 9px; width: 150px; margin:0px;" for=""><b>Ruta:</b> {{$zona->Zona}}</label>
        <label style="font-size: 9px; width: 150px; margin:0px;" for=""><b>Grupo:</b> {{$grupo->grupo}}</label><br>
        @if (count($gerente_zona)==0)
            <label style="font-size: 9px; width: 550px; margin:0px;" for=""><b>Nombre de quien solicita los fondos:</b></label>
        @else
            @foreach ($gerente_zona as $gerente_z)
                <label style="font-size: 9px; width: 550px; margin:0px;" for=""><b>Nombre de quien solicita los fondos:</b> {{$gerente_z->nombre.' '.$gerente_z->ap_paterno.' '.$gerente_z->ap_materno}}</label> <br>
            @endforeach
        @endif
        

        <div class="estilo-table">
            @php
                $mp=0;
                $ae=0;
                $ea=0;
                $ah=0;
                $cm=0;
                $cen=0;
                $liquidacion=0;

                function getRedondearNumero($num) {
                    $resultado = 0; // Variable que vamos arretonar con el valor final del número
                    $nuevoNumero = intval($num); // Eliminamos las decimales dejando solo el numero entero sin redondear
                    $nuevoNumeroArray = str_split($nuevoNumero); // Separamos la cadena de numero en un array para poder manipular cada uno de sus numeros
                    $ultimaPosicion = count($nuevoNumeroArray)-1; // Obtenemos la ultima posicion de nuestro array de numeros

                    // Comparamos la ultima posición del array para detectar si el numero es mayor o igual a 5 pero menor o igual a 9
                    // Si se cumple la condición el valor se redondea a 5
                    // Si no se cumple la condición el valor se redondesa a 0
                    if ($nuevoNumeroArray[$ultimaPosicion] >= 5 && $nuevoNumeroArray[$ultimaPosicion] <= 9) { 
                        // Si se cumple actualizamos el valor de la ultima posición del array a 5
                        $nuevoNumeroArray[$ultimaPosicion] = 5; 
                    } else {
                        // Si no se cumple actualizamos el valor de la ultima posición del array a 0
                        $nuevoNumeroArray[$ultimaPosicion] = 0;
                    }

                    // Ahora vamos a recorrer el array para ir concatenando los digitos del array en el valor final
                    for ($i=0; $i < count($nuevoNumeroArray); $i++) { 
                        if ($i != 0) {
                            // Si el valor del recorrido es diferente a 0
                            // concatenamos el valor que ya tiene con el nuevo valor del recorrido del array
                            $resultado .= $nuevoNumeroArray[$i];
                        } else {
                            // Si el valor del recorrido es 0
                            // actualizamos el valor de la variable $resultado
                            $resultado = $nuevoNumeroArray[$i];
                        }
                    }

                    return $resultado; // Retornamos como resultado la variable $resultado
                }

            @endphp
            <table>
                <thead>
                    <tr>
                        <th>
                             <small>
                                 No.P
                             </small> 
                        </th>
                        <th>
                            <small>
                                Promotor
                            </small>
                        </th>
                        <th>
                            <small>
                                Cliente
                            </small>
                        </th>
                        <th>
                            <small>
                                Tipo
                            </small>
                        </th>
                        <th>
                            <small>
                                Liquida
                            </small>
                        </th>
                        <th>
                            <small>
                                Monto
                            </small>
                        </th>
                        {{-- <th>
                            <small>
                                Aport. empresa
                            </small>
                        </th> --}}
                        <th>
                            <small>
                                Efectivo entregar
                            </small>
                        </th>
                        <th>
                            <small>
                                Ahorro
                            </small>
                        </th>
                        {{-- <th>
                             <small>
                             Com.º doc.
                             </small>
                         </th> --}}
                        <th>
                            <small>
                             Com.º promotor
                            </small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prestamos as $prestamo)
                     <tr>
                        <td>
                             <small>

                                 {{$prestamo->id_prestamo}}
                             </small>   
                         </td>
                        <td>
                             <small>
                                 {{$prestamo->nombre_pro.' '.$prestamo->paterno_pro.' '.$prestamo->materno_pro}}
                             </small>   
                         </td>
                        <td>
                             <small>
                                 {{$prestamo->nombre_cliente.' '.$prestamo->paterno_cliente.' '.$prestamo->materno_cliente}}
                             </small>   
                         </td>
                             
                        <td style="font-weight: 900">

                             @php
                                 $status_press = DB::table('tbl_prestamos')
                                 // ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
                                 // ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                                 ->select('tbl_prestamos.*')
                                 ->where('tbl_prestamos.id_usuario','=',$prestamo->id_cliente)
                                 ->where('tbl_prestamos.id_status_prestamo','=',20)
                                 ->get();

                                 $contarp=count($status_press);
                             @endphp
                             @if ($contarp==0)
                                <small>
                                    <b style="font-size: 10px; font-weight: 900">R</b> 
                                </small>
                             @else
                             <small>
                                 <b style="font-size: 10px; font-weight: 900">LR</b>
                             </small>
                             @endif
                        </td>

                        <td style="text-align: right; padding-right: 7px; color:blue;">
                            $ 0.00
                         </td>
                        <td style="text-align: right; padding-right: 7px; color:blue;">
                            @php
                                $mp+=$prestamo->cantidad;
                            @endphp
                            $ {{number_format($prestamo->cantidad,2)}}</td>
                        @php
                             $monto=$prestamo->cantidad;
                            //  $aportacion=$monto*0.02;
                        @endphp
                        {{-- <td style="text-align: right; padding-right: 7px; color:blue;">
                            @php
                                $ae+=$aportacion;
                            @endphp
                            $ {{number_format($aportacion,2)}}
                        </td> --}}
                             @php
                                 $ahorro=$prestamo->cantidad*($prestamo->pago_semanal/100);
                             @endphp
                         <td style="text-align: right; padding-right: 7px; color:blue;">
                          
                                @php
                                   

                                    // $efectivo_entregar=$monto-$ahorro-$prestamo->cantidad*($prestamo->comision_promotora/100)-$liquidacion;
                                    $com_promoto=$prestamo->cantidad*($prestamo->papeleria/100);

                                    // Aplicamos la logica
                                    $p1=0;
                                    $p2=0;
                                    $subp1=getRedondearNumero($com_promoto/2);
                                    // $p2=getRedondearNumero(($com_promoto-$p1)/2);
                                    // $p3=$com_promoto-($p1+$p2);
                                    $subp2=$com_promoto-$subp1;
                                    if ($subp1>$subp2) {
                                        $p2=$subp1;
                                        $p1=$subp2;
                                    } elseif($subp2>$subp1) {
                                        $p2=$subp2;
                                        $p1=$subp1;
                                    } else {
                                        $p1=$subp1;
                                        $p2=$subp2;
                                    }
                                    
                                    $ea+=$monto-$ahorro-$prestamo->cantidad*($prestamo->papeleria/100)-$liquidacion+$p1;

                                @endphp
                                 {{-- ${{number_format(($monto+$ahorro-$prestamo->cantidad*($prestamo->comision_promotora/100)-$liquidacion),2)}} --}}
                                 $ {{number_format(($monto-$ahorro-$prestamo->cantidad*($prestamo->papeleria/100)-$liquidacion+$p1),2)}}
                            
                             </td>
                         <td style="text-align: right; padding-right: 7px; color:blue;">
                                @php
                                    $ah+=$ahorro;
                                @endphp
                             $ {{number_format($ahorro,2)}}
                         </td>
                        <td style="text-align: right; padding-right: 7px; color:blue;">
                            @php
                                $cm+=$prestamo->cantidad*($prestamo->papeleria/100);
                                $cen+=$p1;
                            @endphp
                            <center>
                                <p style="font-size: 8px; margin: 0; border-bottom: 1px solid #000; ">$ {{number_format($com_promoto,2)}} en 2 pagos</p>
                            </center>
                                <span style="font-size: 7px; margin: 0; ">P1: $ {{number_format($p1,1)}}</span>
                                <span style="font-size: 7px; margin: 0; ">P2: $ {{number_format($p2,1)}}</span>
                                {{-- <span style="font-size: 7px; margin: 0; ">P3: $ {{number_format($p3,1)}}</span> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: right; border-top: 1px solid black; padding:4px; margin-top:3px">
                    <label style="font-size: 9px; padding: 0px; margin:0px; margin-right:5px; margin-left:380px" for=""><b>Monto total:</b> <br>$ {{number_format($mp,2)}}</label>
                    <label style="font-size: 9px; padding: 0px; margin:0px; margin-right:10px;" for=""><b>Efectivo a entregar:</b> <br>$ {{number_format($ea,2)}}</label>
                    <label style="font-size: 9px; padding: 0px; margin:0px; margin-right:5px;" for=""><b>Ahorro:</b> <br>$ {{$ah}}.00</label>
            <label style="font-size: 9px; padding: 0px; margin:0px; margin-top: margin-right:5px;" for=""><b>Comisión promotor:</b> <br>$ {{number_format($cm,2)}} / $ {{number_format($cen,2)}}</label>
            </div>
            <div style="margin-top: 5px; margin-bottom: 4px; text-align: center">
                <label style="font-size: 9px; margin-left:50px" for="">________________________________ <br> Entrega</label>
                <label style="font-size: 9px; margin-left:50px" for="">________________________________ <br> Autorizó</label>
                <label style="font-size: 9px; margin-left:50px" for="">________________________________ <br> Recibe</label>
            </div>
            @php
                $salto1=count($prestamos);
                $salto2=count($prestamos);
            @endphp
            <p style="border-top:1px dashed;"></p>
            <p style="font-size: 1px;color: white">s</p>

        </div>
    </div>
    @if ($salto2>14)
        <div class="page-break"></div>
    @else
        
    @endif
    <div class="contenido-text">
        {{-- <label style="font-size: 9px;" for=""><b>Fecha:</b>{{$fecha_hoy->format('d-m-Y')}}</label>  --}}
        <label style="font-size: 9px;float: right;margin-top: -4px;" for=""><b>Fecha:</b>{{$fecha_hoy->format('d-m-Y')}}</label> 
        <hr>
        @php
        @endphp
        <img style=" position: absolute; z-index: 1; top: 17px; margin-right: 30px; float: right;"  src="{{asset('img/logo/Logo Prestamos.jpg')}}" width="125px" height="70px">
        <label style="background: rgb(223, 223, 223); text-align: center; padding-bottom: 1px; width: 455px; margin-top: 10px" class="titulo-pdf">Solicitud de préstamos anticipados <br> <span style="font-size: 10px;">Administrador</span></label><br>
        <label style="font-size: 9px; width: 150px; margin:0px;" for=""><b>Región:</b> {{$region->Plaza}}</label>
        <label style="font-size: 9px; width: 150px; margin:0px;" for=""><b>Ruta:</b> {{$zona->Zona}}</label>
        <label style="font-size: 9px; width: 150px; margin:0px;" for=""><b>Grupo:</b> {{$grupo->grupo}}</label><br>
        @if (count($gerente_zona)==0)
            <label style="font-size: 9px; width: 550px; margin:0px;" for=""><b>Nombre de quien solicita los fondos:</b></label>
        @else
            @foreach ($gerente_zona as $gerente_z)
                <label style="font-size: 9px; width: 550px; margin:0px;" for=""><b>Nombre de quien solicita los fondos:</b> {{$gerente_z->nombre.' '.$gerente_z->ap_paterno.' '.$gerente_z->ap_materno}}</label><br>
            @endforeach
        @endif
        

        <div class="estilo-table">
            @php
                $mp=0;
                $ae=0;
                $ea=0;
                $ah=0;
                $cm=0;
                $cen=0;
                $liquidacion=0;
            @endphp
            <table>
                <thead>
                    <tr>
                        <th>
                             <small>
                                 No.P
                             </small> 
                        </th>
                        <th>
                            <small>
                                Promotor
                            </small>
                        </th>
                        <th>
                            <small>
                                Cliente
                            </small>
                        </th>
                        <th>
                            <small>
                                Tipo
                            </small>
                        </th>
                        <th>
                            <small>
                                Liquida
                            </small>
                        </th>
                        <th>
                            <small>
                                Monto
                            </small>
                        </th>
                        {{-- <th>
                            <small>
                                Aport. empresa
                            </small>
                        </th> --}}
                        <th>
                            <small>
                                Efectivo entregar
                            </small>
                        </th>
                        <th>
                            <small>
                                Ahorro
                            </small>
                        </th>
                        {{-- <th>
                             <small>
                             Com.º doc.
                             </small>
                         </th> --}}
                        <th>
                            <small>
                             Com.º promotor
                            </small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prestamos as $prestamo)
                     <tr>
                        <td>
                             <small>

                                 {{$prestamo->id_prestamo}}
                             </small>   
                         </td>
                        <td>
                             <small>
                                 {{$prestamo->nombre_pro.' '.$prestamo->paterno_pro.' '.$prestamo->materno_pro}}
                             </small>   
                         </td>
                        <td>
                             <small>
                                 {{$prestamo->nombre_cliente.' '.$prestamo->paterno_cliente.' '.$prestamo->materno_cliente}}
                             </small>   
                         </td>
                             
                        <td style="font-weight: 900">

                             @php
                                 $status_press = DB::table('tbl_prestamos')
                                 // ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
                                 // ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                                 ->select('tbl_prestamos.*')
                                 ->where('tbl_prestamos.id_usuario','=',$prestamo->id_cliente)
                                 ->where('tbl_prestamos.id_status_prestamo','=',20)
                                 ->get();

                                 $contarp=count($status_press);
                             @endphp
                             @if ($contarp==0)
                                <small>
                                    <b style="font-size: 10px; font-weight: 900">R</b> 
                                </small>
                             @else
                             <small>
                                 <b style="font-size: 10px; font-weight: 900">LR</b>
                             </small>
                             @endif
                        </td>

                        <td style="text-align: right; padding-right: 7px; color:blue;">
                           $ 0.00
                         </td>
                        <td style="text-align: right; padding-right: 7px; color:blue;">
                            @php
                                $mp+=$prestamo->cantidad;
                            @endphp
                            $ {{number_format($prestamo->cantidad,2)}}</td>
                        @php
                             $monto=$prestamo->cantidad;
                            //  $aportacion=$monto*0.02;
                        @endphp
                        {{-- <td style="text-align: right; padding-right: 7px; color:blue;">
                            @php
                                $ae+=$aportacion;
                            @endphp
                            $ {{number_format($aportacion,2)}}
                        </td> --}}
                             @php
                                 $ahorro=$prestamo->cantidad*($prestamo->pago_semanal/100);
                             @endphp
                         <td style="text-align: right; padding-right: 7px; color:blue;">
                          
                                @php

                                    // $efectivo_entregar=$monto-$ahorro-$prestamo->cantidad*($prestamo->comision_promotora/100)-$liquidacion;
                                    $com_promoto=$prestamo->cantidad*($prestamo->papeleria/100);

                                    // Aplicamos la logica
                                    $p1=0;
                                    $p2=0;
                                    $subp1=getRedondearNumero($com_promoto/2);
                                    // $p2=getRedondearNumero(($com_promoto-$p1)/2);
                                    // $p3=$com_promoto-($p1+$p2);
                                    $subp2=$com_promoto-$subp1;
                                    if ($subp1>$subp2) {
                                        $p2=$subp1;
                                        $p1=$subp2;
                                    } elseif($subp2>$subp1) {
                                        $p2=$subp2;
                                        $p1=$subp1;
                                    } else {
                                        $p1=$subp1;
                                        $p2=$subp2;
                                    }
                                    
                                    $ea+=$monto-$ahorro-$prestamo->cantidad*($prestamo->papeleria/100)-$liquidacion+$p1;

                                @endphp
                                 {{-- ${{number_format(($monto+$ahorro-$prestamo->cantidad*($prestamo->comision_promotora/100)-$liquidacion),2)}} --}}
                                 $ {{number_format(($monto-$ahorro-$prestamo->cantidad*($prestamo->papeleria/100)-$liquidacion+$p1),2)}}
                            
                             </td>
                         <td style="text-align: right; padding-right: 7px; color:blue;">
                                @php
                                    $ah+=$ahorro;
                                @endphp
                             $ {{number_format($ahorro,2)}}
                         </td>
                        <td style="text-align: right; padding-right: 7px; color:blue;">
                            @php
                                $cm+=$prestamo->cantidad*($prestamo->papeleria/100);
                                $cen+=$p1;
                            @endphp
                            <center>
                                <p style="font-size: 8px; margin: 0; border-bottom: 1px solid #000; ">$ {{number_format($com_promoto,2)}} en 2 pagos</p>
                            </center>
                                <span style="font-size: 7px; margin: 0; ">P1: $ {{number_format($p1,1)}}</span>
                                <span style="font-size: 7px; margin: 0; ">P2: $ {{number_format($p2,1)}}</span>
                                {{-- <span style="font-size: 7px; margin: 0; ">P3: $ {{number_format($p3,1)}}</span> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: right; border-top: 1px solid black; padding:4px; margin-top:3px">
                    <label style="font-size: 9px; padding: 0px; margin:0px; margin-right:5px; margin-left:380px" for=""><b>Monto total:</b> <br>$ {{number_format($mp,2)}}</label>
                    <label style="font-size: 9px; padding: 0px; margin:0px; margin-right:10px;" for=""><b>Efectivo a entregar:</b> <br>$ {{number_format($ea,2)}}</label>
                    <label style="font-size: 9px; padding: 0px; margin:0px; margin-right:5px;" for=""><b>Ahorro:</b> <br>$ {{$ah}}.00</label>
            <label style="font-size: 9px; padding: 0px; margin:0px; margin-top: margin-right:5px;" for=""><b>Comisión promotor:</b> <br>$ {{number_format($cm,2)}} / $ {{number_format($cen,2)}}</label>
            </div>
            <div style="margin-top: 5px; margin-bottom: 4px; text-align: center">
                <label style="font-size: 9px; margin-left:50px" for="">________________________________ <br> Entrega</label>
                <label style="font-size: 9px; margin-left:50px" for="">________________________________ <br> Autorizó</label>
                <label style="font-size: 9px; margin-left:50px" for="">________________________________ <br> Recibe</label>
            </div>
            @php
                $salto1=count($prestamos);
                $salto2=count($prestamos);
            @endphp
            <p style="border-top:1px dashed;"></p>
            <p style="font-size: 1px;color: white">s</p>
            
        </div>
    </div>
    @if ($salto1>4)
        <div class="page-break"></div>
    @else
        
    @endif
    <div class="contenido-text">
        <label style="font-size: 9px;float: right;margin-top: -4px;" for=""><b>Fecha:</b>{{$fecha_hoy->format('d-m-Y')}}</label> 
        <hr>
        @php
        @endphp
        <img style=" position: absolute; z-index: 1; top: 17px; margin-right: 30px; float: right;"  src="{{asset('img/logo/Logo Prestamos.jpg')}}" width="125px" height="70px">
        <label style="background: rgb(223, 223, 223); text-align: center; padding-bottom: 1px; width: 455px; margin-top: 10px" class="titulo-pdf">Solicitud de préstamos anticipados <br> <span style="font-size: 10px;">Gerente de ruta</span></label><br>
        <label style="font-size: 9px; width: 150px; margin:0px;" for=""><b>Región:</b> {{$region->Plaza}}</label>
        <label style="font-size: 9px; width: 150px; margin:0px;" for=""><b>Ruta:</b> {{$zona->Zona}}</label>
        <label style="font-size: 9px; width: 150px; margin:0px;" for=""><b>Grupo:</b> {{$grupo->grupo}}</label><br>
        @if (count($gerente_zona)==0)
            <label style="font-size: 9px; width: 550px; margin:0px;" for=""><b>Nombre de quien solicita los fondos:</b></label>
        @else
            @foreach ($gerente_zona as $gerente_z)
                <label style="font-size: 9px; width: 550px; margin:0px;" for=""><b>Nombre de quien solicita los fondos:</b> {{$gerente_z->nombre.' '.$gerente_z->ap_paterno.' '.$gerente_z->ap_materno}}</label><br>
            @endforeach
        @endif
        {{-- <label style="font-size: 9px;" for=""><b>Fecha:</b>{{$fecha_hoy->format('d-m-Y')}}</label>  --}}

        <div class="estilo-table">
            @php
                $mp=0;
                $ae=0;
                $ea=0;
                $ah=0;
                $cm=0;
                $cen=0;
                $liquidacion=0;
            @endphp
            <table>
                <thead>
                    <tr>
                        <th>
                             <small>
                                 No.P
                             </small> 
                        </th>
                        <th>
                            <small>
                                Promotor
                            </small>
                        </th>
                        <th>
                            <small>
                                Cliente
                            </small>
                        </th>
                        <th>
                            <small>
                                Tipo
                            </small>
                        </th>
                        <th>
                            <small>
                                Liquida
                            </small>
                        </th>
                        <th>
                            <small>
                                Monto
                            </small>
                        </th>
                        {{-- <th>
                            <small>
                                Aport. empresa
                            </small>
                        </th> --}}
                        <th>
                            <small>
                                Efectivo entregar
                            </small>
                        </th>
                        <th>
                            <small>
                                Ahorro
                            </small>
                        </th>
                        {{-- <th>
                             <small>
                             Com.º doc.
                             </small>
                         </th> --}}
                        <th>
                            <small>
                             Com.º promotor
                            </small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prestamos as $prestamo)
                     <tr>
                        <td>
                             <small>

                                 {{$prestamo->id_prestamo}}
                             </small>   
                         </td>
                        <td>
                             <small>
                                 {{$prestamo->nombre_pro.' '.$prestamo->paterno_pro.' '.$prestamo->materno_pro}}
                             </small>   
                         </td>
                        <td>
                             <small>
                                 {{$prestamo->nombre_cliente.' '.$prestamo->paterno_cliente.' '.$prestamo->materno_cliente}}
                             </small>   
                         </td>
                             
                        <td style="font-weight: 900">

                             @php
                                 $status_press = DB::table('tbl_prestamos')
                                 // ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
                                 // ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                                 ->select('tbl_prestamos.*')
                                 ->where('tbl_prestamos.id_usuario','=',$prestamo->id_cliente)
                                 ->where('tbl_prestamos.id_status_prestamo','=',20)
                                 ->get();

                                 $contarp=count($status_press);
                             @endphp
                             @if ($contarp==0)
                                <small>
                                    <b style="font-size: 10px; font-weight: 900">R</b> 
                                </small>
                             @else
                             <small>
                                 <b style="font-size: 10px; font-weight: 900">LR</b>
                             </small>
                             @endif
                        </td>

                        <td style="text-align: right; padding-right: 7px; color:blue;">
                            $ 0.00
                         </td>
                        <td style="text-align: right; padding-right: 7px; color:blue;">
                            @php
                                $mp+=$prestamo->cantidad;
                            @endphp
                            $ {{number_format($prestamo->cantidad,2)}}</td>
                        @php
                             $monto=$prestamo->cantidad;
                            //  $aportacion=$monto*0.02;
                        @endphp
                        {{-- <td style="text-align: right; padding-right: 7px; color:blue;">
                            @php
                                $ae+=$aportacion;
                            @endphp
                            $ {{number_format($aportacion,2)}}
                        </td> --}}
                             @php
                                 $ahorro=$prestamo->cantidad*($prestamo->pago_semanal/100);
                             @endphp
                         <td style="text-align: right; padding-right: 7px; color:blue;">
                          
                                @php

                                    // $efectivo_entregar=$monto-$ahorro-$prestamo->cantidad*($prestamo->comision_promotora/100)-$liquidacion;
                                    $com_promoto=$prestamo->cantidad*($prestamo->papeleria/100);

                                    // Aplicamos la logica
                                    $p1=0;
                                    $p2=0;
                                    $subp1=getRedondearNumero($com_promoto/2);
                                    // $p2=getRedondearNumero(($com_promoto-$p1)/2);
                                    // $p3=$com_promoto-($p1+$p2);
                                    $subp2=$com_promoto-$subp1;
                                    if ($subp1>$subp2) {
                                        $p2=$subp1;
                                        $p1=$subp2;
                                    } elseif($subp2>$subp1) {
                                        $p2=$subp2;
                                        $p1=$subp1;
                                    } else {
                                        $p1=$subp1;
                                        $p2=$subp2;
                                    }
                                    
                                    $ea+=$monto-$ahorro-$prestamo->cantidad*($prestamo->papeleria/100)-$liquidacion+$p1;

                                @endphp
                                 {{-- ${{number_format(($monto+$ahorro-$prestamo->cantidad*($prestamo->comision_promotora/100)-$liquidacion),2)}} --}}
                                 $ {{number_format(($monto-$ahorro-$prestamo->cantidad*($prestamo->papeleria/100)-$liquidacion+$p1),2)}}
                            
                             </td>
                         <td style="text-align: right; padding-right: 7px; color:blue;">
                                @php
                                    $ah+=$ahorro;
                                @endphp
                             $ {{number_format($ahorro,2)}}
                         </td>
                        <td style="text-align: right; padding-right: 7px; color:blue;">
                            @php
                                $cm+=$prestamo->cantidad*($prestamo->papeleria/100);
                                $cen+=$p1;
                            @endphp
                            <center>
                                <p style="font-size: 8px; margin: 0; border-bottom: 1px solid #000; ">$ {{number_format($com_promoto,2)}} en 2 pagos</p>
                            </center>
                                <span style="font-size: 7px; margin: 0; ">P1: $ {{number_format($p1,1)}}</span>
                                <span style="font-size: 7px; margin: 0; ">P2: $ {{number_format($p2,1)}}</span>
                                {{-- <span style="font-size: 7px; margin: 0; ">P3: $ {{number_format($p3,1)}}</span> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: right; border-top: 1px solid black; padding:4px; margin-top:3px">
                    <label style="font-size: 9px; padding: 0px; margin:0px; margin-right:5px; margin-left:380px" for=""><b>Monto total:</b> <br>$ {{number_format($mp,2)}}</label>
                    <label style="font-size: 9px; padding: 0px; margin:0px; margin-right:10px;" for=""><b>Efectivo a entregar:</b> <br>$ {{number_format($ea,2)}}</label>
                    <label style="font-size: 9px; padding: 0px; margin:0px; margin-right:5px;" for=""><b>Ahorro:</b> <br>$ {{$ah}}.00</label>
            <label style="font-size: 9px; padding: 0px; margin:0px; margin-top: margin-right:5px;" for=""><b>Comisión promotor:</b> <br>$ {{number_format($cm,2)}} / $ {{number_format($cen,2)}}</label>
            </div>
            <div style="margin-top: 5px; margin-bottom: 4px; text-align: center">
                <label style="font-size: 9px; margin-left:50px" for="">________________________________ <br> Entrega</label>
                <label style="font-size: 9px; margin-left:50px" for="">________________________________ <br> Autorizó</label>
                <label style="font-size: 9px; margin-left:50px" for="">________________________________ <br> Recibe</label>
            </div>
            @php
                $salto1=count($prestamos);
                $salto2=count($prestamos);
            @endphp
            <p style="border-top:1px dashed;"></p>
        </div>
    </div>
        
</body>
</html>
