@extends('layouts.master')
@section('title', 'Solicitud de devolución de préstamos')
@section('parentPageTitle', 'Préstamos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
   <div class="row">
       <div class="col-md-12">
            @if ( session('status') )
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <center>
                            {{ session('status') }}
                        </center>
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                        </div>
                    </div>
                </div>
            @endif
            @if ( session('error') )
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <center>
                            {{ session('error') }}
                        </center>
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                        </div>
                    </div>
                </div>
            @endif
           <div class="row">
               <div class="col-md-4">
                   <label for="">Región</label>
                   <input class="form-control" type="text" value="{{$region->Plaza}}" readonly>
               </div>
               <div class="col-md-4">
                   <label for="">Zona</label>
                   <input class="form-control" type="text" value="{{$zona->Zona}}" readonly>
               </div>
               <div class="col-md-4">
                   <label for="">Grupo</label>
                   <input class="form-control" type="text" value="{{$grupo->grupo}}" readonly>
               </div>
           </div>
           {{-- <div class="mb-1" style="background: darkgray; text-align: center; padding: 5px;">
               <span class="font-weight: 900;"><b>Solicitud de préstamos</b></span>
           </div> --}}
           <div class="row">
               @if (empty($gerente_zona[0]->nombre))
                   
               @else
                <div class="col-md-9 mt-4 mb-2">
                    
                    @foreach ($gerente_zona as $gerente_z)
                        <b>Gerente de ruta:</b> {{$gerente_z->nombre.' '.$gerente_z->ap_paterno.' '.$gerente_z->ap_materno}} <br>
                        
                    @endforeach
                </div>
                <div class="col-md-3 mt-2 mb-1">
                    <div class="card-header d-flex">
                        @if (count($prestamos)==0)
                            No hay nada que recibir
                        @else
                            <a id="btn-imprimir" target="_blank" href="{{url('pdf-prestamo-devolucion/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" class="btn btn-primary btn-sm" title="Imprimir recibo de préstamos de devolución"><i class="fas fa-print" ></i></a>
                            <a id="btn-aviso-imprimir" style="display:none;" class="btn btn-dark btn-sm" onclick="return alert('Tiene que verificar los préstamos antes de proseguir')" title="Imprimir recibo de préstamos"><i class="fas fa-print" ></i></a>
            <form id="recibirPrestamosRechazadosForm" action="{{url('devolucion_prestamos')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
                                    <center>
                                    <a  class="btn btn-dark btn-sm" id="btn-aviso" style="display:none;" onclick="return alert('Tiene que verificar los préstamos antes de proseguir')">Recibido</a>
                                    <button type="button" id="btn-entregar" class="btn btn-success btn-sm" data-toggle="modal" data-target="#recibirPrestamosRechazadosModel">
                                        Recibido
                                    </button>
                                    {{-- <button  class="btn btn-success btn-sm" id="btn-entregar" onclick="return confirm('Nota: debe imprimir su recibo antes de recibir la devolución de los préstamos ¿Ya guardó su recibo?')" title="Recibir los préstamos rechados por el cliente">Recibido</button> --}}
                                    </center>
                            
                        @endif
                    </div>
                </div>
               @endif
           </div>
           <div class="estilo-table">
               @php
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
                                    No.
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
                                   Efectivo a recibir
                               </small>
                           </th>
                           <th>
                               <small>
                                   Abono ajuste
                               </small>
                           </th>
                           {{-- <th>
                                <small>
                                Com.º doc.
                                </small>
                            </th> --}}
                           <th>
                               <small>
                                Liquidacion
                               </small>
                           </th>
                       </tr>
                   </thead>
                   <tbody>
                       @php
                           $liquidacion='0';
                       @endphp
                       @foreach ($prestamos as $prestamo)
                        <tr>
                           <td>
                                <small>
                                    <input type="hidden" name="id_prestamo[]" value="{{$prestamo->id_prestamo}}">
                                    <input type="hidden" name="id_cliente[]" value="{{$prestamo->id_cliente}}">
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
                                    ->select('tbl_prestamos.*')
                                    ->where('id_usuario','=',$prestamo->id_cliente)
                                    ->get();
                                    $contarp=count($status_press);
                                @endphp
                                {{-- {{$status_press}} --}}
                                @if ($contarp==1)
                                    <b style="font-size: 11px; font-weight: 900">N</b>
                                @elseif($contarp>1)
                                    <b style="font-size: 11px; font-weight: 900">R</b>
                                @endif
                           </td>
                           {{-- <td style="text-align: right; padding-right: 7px; color:blue;">
                                @if ($contarp==0)
                                    @php
                                        $liquidacion=0;
                                    @endphp
                                    $ {{number_format($liquidacion,2)}}
                                @else
                                    @php
                                        $producto = DB::table('tbl_productos')   
                                        ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                        ->select('tbl_productos.*')
                                        ->where('tbl_prestamos.id_prestamo','=',$status_press[0]->id_prestamo)
                                        ->get();
                                        $cantidad_prestamo = DB::table('tbl_prestamos')   
                                        
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
                                        $tipo_multa_1 = DB::table('tbl_abonos')
                                        ->select(DB::raw('count(*) as tipo_multa_1'))
                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
                                        ->where('id_tipoabono','=',4)
                                        ->get();
                                            if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                $multa1=0;
                                            }else {
                                                $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                            }
                                        $tipo_multa_2 = DB::table('tbl_abonos')
                                        ->select(DB::raw('count(*) as tipo_multa_2'))
                                        ->where('id_prestamo', '=', $status_press[0]->id_prestamo)
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
                                        $liquidar=$sistema_total_cobrar-$cliente_pago;
                                        $liquidacion=$liquidar;
                                    @endphp
                                    <input type="hidden" name="catidad_liquidacion[]" value="{{$liquidacion}}">
                                    $ {{number_format($liquidacion,2)}}
                                   
                                @endif
                            </td> --}}
                            <!--Monto-->
                           <td style="text-align: right; padding-right: 7px; color:blue;">
                                @if($prestamo->cantidad==null)
                                    <style>
                                        #btn-entregar{
                                            display: none;
                                        }
                                        #btn-aviso{
                                            display: block !important;
                                        }
                                        #btn-aviso-imprimir{
                                            display: block !important;
                                        }
                                        #btn-imprimir{
                                            display: none;
                                        }
                                    </style>
                                    <br>
                                    <span class="badge badge-danger">Sin cantidad</span><br>
                                    <a href="{{ url('prestamo/buscar-cliente/admin/prestamos/' .$prestamo->id_prestamo.'/edit') }}" class="badge badge-primary">Verificar</a>
                                @else
                                    $ {{number_format($prestamo->cantidad,2)}}
                                @endif
                           
                           </td>
                                @php
                                    $total_liquidación_prestamo=0;
                                    $id_abono_liquidacion=0;
                                    $id_prestamo_anterior=0;
                                    $prestamo_liquidacion = DB::table('tbl_prestamo_liquidacion_temporal')
                                    ->select('tbl_prestamo_liquidacion_temporal.*')
                                    ->where('tbl_prestamo_liquidacion_temporal.id_usuario', '=', $prestamo->id_cliente)
                                    ->orderby('tbl_prestamo_liquidacion_temporal.id_abono','ASC')
                                    ->get();


                                    if (count($prestamo_liquidacion)==0) {
                                        $total_liquidación_prestamo=0;
                                        $id_abono_liquidacion=0;
                                        $id_prestamo_anterior=0;
                                    } else {
                                            $id_prestamo_anterior=$prestamo_liquidacion->last()->id_prestamo;
                                            $id_abono_liquidacion=$prestamo_liquidacion->last()->id_abono;
                                            
                                            $abono_liquidacion = DB::table('tbl_abonos')
                                            ->select('tbl_abonos.cantidad')
                                            ->where('id_prestamo', '=', $prestamo_liquidacion->last()->id_abono)
                                            ->orderby('id_abono','ASC')
                                            ->get();
                                            if (count($abono_liquidacion)==0) {
                                                $total_liquidación_prestamo=0;
                                            } else {
                                                $total_liquidación_prestamo+=$abono_liquidacion->last()->cantidad;
                                            }
                                    }
                                    
                                    // dd($total_liquidación_prestamo);
                                    $monto=$prestamo->cantidad;
                               
                                    $ahorro=$prestamo->cantidad*($prestamo->pago_semanal/100);


                                @endphp
                                
                                <!--Efectivo a entregar-->
                            <td style="text-align: right; padding-right: 7px; color:blue;">
                                @php

                                    

                                    // $efectivo_entregar=$monto-$ahorro-$prestamo->cantidad*($prestamo->comision_promotora/100)-$liquidacion-$total_liquidación_prestamo;
                                    $com_promoto=$prestamo->cantidad*($prestamo->comision_promotora/100);

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
                                @endphp
                                    $ {{number_format(($monto-$ahorro-$prestamo->cantidad*($prestamo->comision_promotora/100)-$liquidacion+$p1-$total_liquidación_prestamo),2)}}

                            </td>
                            <!--Ahorro-->
                            <td style="text-align: right; padding-right: 7px; color:blue;">
                                @php
                                    $abonos_administracion = DB::table('tbl_abonos')
                                    ->select(DB::raw('SUM(cantidad) as total_abono'))
                                    // ->select('tbl_abonos.*')
                                    ->where('id_prestamo', '=', $prestamo->id_prestamo)
                                    ->get();
                                    // dd($abonos_administracion);
                                    if (empty($abonos_administracion[0]->total_abono)) {
                                        $abono_ajuste=0;
                                    } else {
                                        $abono_ajuste=$abonos_administracion[0]->total_abono;
                                    }
                                @endphp
                                <input type="hidden" name="cantidad_abono[]" value="{{$abono_ajuste}}">
                                $ {{number_format($abono_ajuste,2)}}
                            </td>
                            <!--Comisión promotora-->
                            <td style="text-align: right; padding-right: 7px; color:blue;">
                            <input type="hidden" name="id_prestamo_anterior[]" value="{{$id_prestamo_anterior}}">
                            <input type="hidden" name="id_abono[]" value="{{$id_abono_liquidacion}}">
                            $ {{number_format($total_liquidación_prestamo,2)}}
                                {{-- <center>
                                    <p style="font-size: 11px; margin: 0; border-bottom: 1px solid #000; ">$ {{number_format($com_promoto,2)}} en 3 pagos</p>
                                </center>
                                <span style="font-size: 9px; margin: 0; ">P1: $ {{number_format($p1,1)}}</span> --}}

                            </td>
                       </tr>
                       @endforeach
                   </tbody>
               </table>
            </form>
           </div>
       </div>
   </div>
   <div class="modal fade" id="recibirPrestamosRechazadosModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body " >
          
          <div class="col-md-12">
            <center>
              <img src="{{asset('img/modal/question.png')}}" style="width: 50%" alt="">
  
            </center>
            
              <center>
                <b class="modal-title mt-2" id="exampleModalLabel">¿Ya guardó su recibo?</b><br>
                <small>Nota: debe imprimir su recibo antes de recibir la devolución de los préstamos </small>
              </center>
            
            <center>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
              <a  href="#" class="btn btn-success" style="background: #870374;" onclick="recibirPrestamos()" data-dismiss="modal">Si, continuar</a>
            </center>
          </div>
         
        </div>
        {{-- <div class="modal-footer"> --}}
        {{-- </div> --}}
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
    function recibirPrestamos(){
      document.getElementById("recibirPrestamosRechazadosForm").submit();
    }
</script>

@stop