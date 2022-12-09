<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de abono pdf</title>

    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/> --}}
       
    <style>
        body{
            font-family: sans-serif;
        }
        hr{
            border: solid 1px #210A68;
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
            border-bottom: solid 5px #210A68;
            color: white;
            font-size: 11px;
            /* text-align: center; */
        }
        tbody{
            font-size: 10px;
        }
        tr:nth-child(odd){
            background-color: rgb(240, 239, 239);
        }
        th{
            padding: 3px;
        }
        td{
            padding: 1px;
        }
        .titulo-pdf{
            font-size: 20px;
            font-weight: 700;
            color: rgb(1, 52, 194);
        }
    </style>
</head>
@php
$fechaActual = $fecha_hoy;
setlocale(LC_TIME, "spanish");
$fecha_a = $fechaActual;
$fecha_a = str_replace("/", "-", $fecha_a);
$Nueva_Fecha_a = date("d-m-Y H:i", strtotime($fecha_a));
@endphp
{{-- <header> --}}
<label for="" style="margin-left:1px">
    <span style="font-size: 10px; ">Reporte generado {{$Nueva_Fecha_a}}</span>
</label>
<body>
        <div class="contenido-text">
            <hr>
            @php
                $fecha_1 = date_create($fecha1);
                $fecha_2 = date_create($fecha2);
            @endphp
            {{--<img class="float-right" src="{{asset('assets/images/lf/logoHada.png')}}" width="170" height="170">--}}
            <label class="titulo-pdf">Lista de abonos en los últimos 7 dias </label>
            <img style="margin-left:165px;  z-index: -10;" src="{{asset('img/logoNombre.png')}}" width="170px" height="50px"><br>
            <label><b>Fecha de</b> <u><small>{{date_format($fecha_1, 'd-M-Y H:i:s')}}</small></u> <b>a</b> <u><small>{{date_format($fecha_2, 'd-M-Y H:i:s')}}</small></u></label><br>
            <div class="tabla-datos">
                @php
                    $total=0;
                @endphp
                <table>
                    <thead>
                        <tr>
                            <th>No. A</th>
                            <th>Región</th>
                            <th>Zona</th>
                            <th>Grupo</th>
                            <th>Cliente</th>
                            <th>Semana</th>
                            <th>Tipo A.</th>
                            <th>Cant.</th>
                            <th>F. Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($abonos_semana as $abonos_s)
                        @php
                            $total+=$abonos_s->cantidad;
                        @endphp
                        <tr>
                            <td>{{$abonos_s->id_abono}}</td>
                            <td>{{$abonos_s->Plaza}}</td>
                            <td>{{$abonos_s->Zona}}</td>
                            <td>{{$abonos_s->grupo}}</td>
                            <td>{{$abonos_s->nombre.' '.$abonos_s->ap_paterno.' '.$abonos_s->ap_materno}}</td>
                            <td>{{$abonos_s->semana}}</td>
                            <td>{{$abonos_s->tipoAbono}}</td>
                            <td>{{$abonos_s->cantidad}}</td>
                            <td>{{$abonos_s->fecha_pago}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                @php
                    $cantregistros=count($abonos_semana);
                @endphp
                <div style="text-align: right">
                    <b>Registros:</b> {{$cantregistros}} <br>
                    <b>Total:</b> $ {{$total}}.00
                </div>
                
            </div>
        </div>
</body>
</html>
