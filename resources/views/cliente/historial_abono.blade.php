@extends('layoutsC.master')
@section('title','Historial abonos')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
@stop
@section('content')
    
    <div class="row mt-2">
        <div class="col-md-4 mb-3"><small>Región</small><br>
            <input type="text" class="form-control" value="{{$region_zona_grupo[0]->Plaza}}" disabled>
        </div>
        <div class="col-md-4 mb-3"><small>Zona</small><br>
            <input type="text" class="form-control" value="{{$region_zona_grupo[0]->Zona}}" disabled>
        </div>
        <div class="col-md-4 mb-3"><small>Grupo</small><br>
            <input type="text" class="form-control" value="{{$region_zona_grupo[0]->grupo}}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <small><b>Cliente</b></small><br>
            <label for="">{{$cliente[0]->id}} {{$cliente[0]->nombre}} {{$cliente[0]->ap_paterno}} {{$cliente[0]->ap_materno}}</label>
        </div>
        <div class="col-md-2">
            <small><b>Préstamo</b></small><br>
            <label for="">{{$prestamo[0]->producto}}</label>
        </div>
        <div class="col-md-3">
            @php
                $papeleo=$prestamo[0]->cantidad*0.05;
                $interes=$prestamo[0]->cantidad*($prestamo[0]->pago_semanal/100)*$prestamo[0]->semanas;
                $interes_neto=$prestamo[0]->cantidad*($prestamo[0]->reditos/100);
                $total_prestamo=$papeleo+$interes;

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
        <div class="col-md-10"></div>
        <div class="col-md-2"><a href="{{url('cliente-pdf-abono/'.$prestamo[0]->id_prestamo)}}">Imprimir en pdf</a></div>
    </div>
        
    <hr>
    @if ( session('status') )
      <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
    @endif
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
  @endif
  @php
      $t_prestamos = DB::table('tbl_abonos')
      ->select(DB::raw('count(*) as total_pres'))
      ->where('id_prestamo', '=', $prestamo[0]->id_prestamo)
      ->whereBetween('semana', [1, 14])
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
                                              {{-- <form action="{{url('renovacion-prestamo')}}" method="post">
                                                  @csrf --}}
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
                                                              ¡Felicidades por ser puntual, ya puede renovar su préstamo!. Con un incremento de $500.00 <b ><button style="border: none; background: transparent" type="button" onclick="return confirm('¿Esta seguro de continuar con la operación?')"><u>Clic aqui</u></button></b>
                                                          </center>
                                                      </div>
                                              {{-- </form> --}}
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
                                                  {{-- <form action="{{url('renovacion-prestamo')}}" method="post">
                                                      @csrf --}}
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
                                                  {{-- </form> --}}
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
                                                  {{-- <form action="{{url('renovacion-prestamo')}}" method="post">
                                                      @csrf --}}
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
                                                  {{-- </form> --}}
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
                                                  {{-- <form action="{{url('renovacion-prestamo')}}" method="post">
                                                      @csrf --}}
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
                                                  {{-- </form> --}}
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
                                                  {{-- <form action="{{url('renovacion-prestamo')}}" method="post">
                                                      @csrf --}}
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
                                                          
                                                  {{-- </form> --}}
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
@stop
@section('page-script')

@stop


















