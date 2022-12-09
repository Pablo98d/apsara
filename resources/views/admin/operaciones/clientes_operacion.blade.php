@extends('layouts.master')
@section('title', 'Clientes - operación')
@section('parentPageTitle', 'Clientes')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<style>
    .tarjeta-propuesta{
        width: 95%;
        height: auto;
        border: 3px solid blue;
        margin: 0 auto;
        border-radius: 30px 0 30px 30px;
    }
    .estatus{
        float: right;
        /* margin: 10px; */
        background: rgb(255, 166, 0);
        border-radius: 0 0 0 20px;
        padding: 6px;
        font-size: 17px;
        font-weight: bold;
    }
    .Pendiente{
        background: rgb(255, 187, 0);
        float: right;
        padding-left: 7px;
        padding-right: 7px;
        color: white;
        border-radius: 20px;
        font-size: 12px;
        margin: 7px;
        font-weight: bold;
    }
    .Aprobado{
        background: rgb(55, 207, 41);
        float: right;
        padding-left: 7px;
        padding-right: 7px;
        color: white;
        border-radius: 20px;
        font-size: 12px;
        margin: 7px;
        font-weight: bold;
    }
    .Negado{
        background: #ff0000;
        float: right;
        padding-left: 7px;
        padding-right: 7px;
        color: white;
        border-radius: 20px;
        font-size: 12px;
        margin: 7px;
        font-weight: bold;
    }
    .padd{
        padding: 12px;
    }
</style>
@stop
@section('content')
    <div class="row">
       <div class="col-md-12">
           <h5>Negociaciones</h5>
           <hr>
       </div>
       @if ( session('status') )
       <div class="col-md-12">
           <div class="alert alert-success alert-dismissible fade show" role="alert">
               {{ session('status') }}
               <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true"></span>
               </button>
           </div>
       </div>
		@endif
       <div class="col-md-12 mt-3">

        @php
            $liquidacion=0;
        @endphp
            
           @if (count($negociaciones_pendinte)==0)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Notificación!</strong> No hay solicitudes de negociación pendientes.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
           @else
                <div class="col-md-12 mb-2">
                    <center>
                        <b>
                            Solicitudes de negociación
                        </b>
                    </center>
                </div>
                @foreach ($negociaciones_pendinte as $prop_p)
                    <div class="tarjeta-propuesta">
                        <div class="estatus">{{$prop_p->estatus}}</div>
                        <div class="row mt-3">
                            <div class="col-md-2 mb-2">
                                <small>No.C</small><br>
                                <b for="">{{$prop_p->id_usuario}}</b>
                            </div>
                            <div class="col-md-4 mb-2">
                                <small>Cliente</small><br>
                                <b for="">{{$prop_p->nombre}} {{$prop_p->ap_paterno}} {{$prop_p->ap_materno}}</b>
                            </div>
                            <div class="col-md-3 mb-2">
                                <small>Zona</small><br>
                                <b for="">{{$prop_p->Zona}}</b>
                            </div>
                            <div class="col-md-3 mb-2">
                                <small>Grupo</small><br>
                                <b for="">{{$prop_p->grupo}}</b>
                            </div>
                            <div class="col-md-2 mb-2">
                                <small>No.Préstamo</small><br>
                                <b for="">{{$prop_p->id_prestamo}}</b>
                            </div>    
                            <div class="col-md-4 mb-2">
                                <small>Producto</small><br>
                                <b for="">{{$prop_p->n_producto}}</b>
                            </div>
                            <div class="col-md-2 mb-2">
                                <small>Monto</small><br>
                                <b for="">$ {{number_format($prop_p->cantidad,2)}}</b>
                            </div>
                            <div class="col-md-4 mb-2">
                                <small>Fecha entregado</small><br>
                                <b for="">{{$prop_p->fecha_entrega_recurso}}</b>
                            </div>
                            <div class="col-md-2 mb-2">
                                <small>No. Propuesta</small><br>
                                <b for="">{{$prop_p->id_negociacion}}</b>
                            </div>
                            <div class="col-md-2 mb-2">
                                @php
                                                $producto = DB::table('tbl_productos')   
                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                ->select('tbl_productos.*')
                                                ->where('tbl_prestamos.id_prestamo','=',$prop_p->id_prestamo)
                                                ->get();
                                                // $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                // // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                // ->select('cantidad')
                                                // ->where('id_prestamo','=',$status_press[0]->id_prestamo)
                                                // ->get();
                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                ->where('id_prestamo', '=', $prop_p->id_prestamo)
                                                ->where('id_tipoabono','=',1)
                                                ->get();
                                                $tipo_abono = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                ->where('id_prestamo', '=', $prop_p->id_prestamo)
                                                ->where('id_tipoabono','=',2)
                                                ->get();
                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                ->where('id_prestamo', '=', $prop_p->id_prestamo)
                                                ->where('id_tipoabono','=',3)
                                                ->get();
                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                ->where('id_prestamo', '=', $prop_p->id_prestamo)
                                                ->where('id_tipoabono','=',4)
                                                ->get();
                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                        $multa1=0;
                                                    }else {
                                                        $multa2=$tipo_multa_1[0]->tipo_multa_1;
                                                    }
                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                ->where('id_prestamo', '=', $prop_p->id_prestamo)
                                                ->where('id_tipoabono','=',5)
                                                ->get();
                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                        $multa2=0;
                                                    }else {
                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                    }
                                                $interes=$prop_p->cantidad*($producto[0]->reditos/100);
                                                $papeleo=$prop_p->cantidad*($producto[0]->papeleria/100);
                                                $s_multa1=($prop_p->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                $sistema_total_cobrar=$prop_p->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                $liquidar=$sistema_total_cobrar-$cliente_pago;
                                                $liquidacion=$liquidar;
                                        @endphp
                                <small>Saldo</small><br>
                                <b for="">$ {{number_format($liquidacion,2)}}</b>
                            </div>
                            <div class="col-md-4 mb-2">
                                <form action="{{url('negociacion-guardar')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_negociacion" value="{{$prop_p->id_negociacion}}">
                                    <small>Liquidar con: </small><br>
                                    $ <input name="cantidad_propuesta" style="width: 100px; border: 0; border-bottom:1px #000 solid;" type="text" value="{{$prop_p->cantidad_propuesta}}">
                                    <button class="btn btn-primary btn-sm" type="submit" onclick="return confirm('¿Esta seguro de cambiar la cantidad de la propuesta?')">Editar</button>
                                </form>
                            </div>
                            <div class="col-md-4 mb-2">
                                <small>Fecha solicitado</small><br>
                                <b for="">{{$prop_p->fecha_registro}}</b>
                            </div>  
                            <div class="col-md-12">
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 d-flex">
                                        <form action="{{url('negociacion-guardar')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_negociacion" value="{{$prop_p->id_negociacion}}">
                                            <input name="estatus" type="hidden" value="Aprobado">
                                            <button class="btn btn-success btn-sm" onclick="return confirm('¿Esta seguro de aprobar la propuesta?')">Aprobar</button>
                                        </form>
                                        <form action="{{url('negociacion-guardar')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_negociacion" value="{{$prop_p->id_negociacion}}">
                                            <input name="estatus" type="hidden" value="Negado">
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Esta seguro de negar la propuesta?')">No aprobado</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <br><br>
                    </div>
                    <br>
                @endforeach
           @endif
       </div>
       <div class="col-md-12 mt-4">
           <b>Historial de negociaciones</b>
        <table class="mt-2">
            <thead>
                <tr class="row">
                    <th class="col-md-1">No.N</th>
                    <th class="col-md-1">No.C</th>
                    <th class="col-md-2">Cliente</th>
                    <th class="col-md-1">Zona</th>
                    <th class="col-md-1">Grupo</th>
                    
                </tr>
            </thead>
        </table>
        <div id="accordion">
            @foreach ($negociaciones as $prop)
            <div class="card">
                <div class="" id="headingOne" style="background:rgba(68, 19, 158, 0.171);">
                <h5 class="mb-0">
                    <button style="color: #000;" class="btn btn-link row" data-toggle="collapse" data-target="#collapse{{$prop->id_negociacion}}" aria-expanded="true" aria-controls="collapseOne">
                        <b class="col-md-1" >{{$prop->id_negociacion}}</b> <b class="col-md-1" >{{$prop->id_usuario}}</b> <b class="col-md-3" >{{$prop->nombre}} {{$prop->ap_paterno}} {{$prop->ap_materno}}</b> <b class="col-md-1" >{{$prop->Zona}}</b><b class="col-md-1" >{{$prop->grupo}}</b><i class="fas fa-angle-right"></i>
                    </button>
                    <span class="{{$prop->estatus}}">{{$prop->estatus}}</span>
                </h5>
                </div>
                <div id="collapse{{$prop->id_negociacion}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div style="border: rgba(68, 19, 158, 0.171) 1px solid;" class="card-body" >
                    <div class="tarjeta-propuesta">
                        <div class="row mt-3 padd">
                            <div class="col-md-2 mb-2">
                                <small>No.Préstamo</small><br>
                                <b for="">{{$prop->id_prestamo}}</b>
                            </div>    
                            <div class="col-md-4 mb-2">
                                <small>Producto</small><br>
                                <b for="">{{$prop->n_producto}}</b>
                            </div>
                            <div class="col-md-2 mb-2">
                                <small>Monto</small><br>
                                <b for="">$ {{number_format($prop->cantidad,2)}}</b>
                            </div>
                            <div class="col-md-4 mb-2">
                                <small>Fecha entregado</small><br>
                                <b for="">{{$prop->fecha_entrega_recurso}}</b>
                            </div>
                            <div class="col-md-2 mb-2">
                                <small>No. Propuesta</small><br>
                                <b for="">{{$prop->id_negociacion}}</b>
                            </div>
                            <div class="col-md-2 mb-2">
                                
                                @php
                                        $producto = DB::table('tbl_productos')   
                                        ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                        ->select('tbl_productos.*')
                                        ->where('tbl_prestamos.id_prestamo','=',$prop->id_prestamo)
                                        ->get();
                                        // $cantidad_prestamo = DB::table('tbl_prestamos')   
                                        // // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                        // ->select('cantidad')
                                        // ->where('id_prestamo','=',$status_press[0]->id_prestamo)
                                        // ->get();
                                        $tipo_liquidacion = DB::table('tbl_abonos')
                                        ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                        ->where('id_prestamo', '=', $prop->id_prestamo)
                                        ->where('id_tipoabono','=',1)
                                        ->get();
                                        $tipo_abono = DB::table('tbl_abonos')
                                        ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                        ->where('id_prestamo', '=', $prop->id_prestamo)
                                        ->where('id_tipoabono','=',2)
                                        ->get();
                                        $tipo_ahorro = DB::table('tbl_abonos')
                                        ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                        ->where('id_prestamo', '=', $prop->id_prestamo)
                                        ->where('id_tipoabono','=',3)
                                        ->get();
                                        $tipo_multa_1 = DB::table('tbl_abonos')
                                        ->select(DB::raw('count(*) as tipo_multa_1'))
                                        ->where('id_prestamo', '=', $prop->id_prestamo)
                                        ->where('id_tipoabono','=',4)
                                        ->get();
                                            if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                $multa1=0;
                                            }else {
                                                $multa2=$tipo_multa_1[0]->tipo_multa_1;
                                            }
                                        $tipo_multa_2 = DB::table('tbl_abonos')
                                        ->select(DB::raw('count(*) as tipo_multa_2'))
                                        ->where('id_prestamo', '=', $prop->id_prestamo)
                                        ->where('id_tipoabono','=',5)
                                        ->get();
                                            if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                $multa2=0;
                                            }else {
                                                $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                            }
                                        $interes=$prop->cantidad*($producto[0]->reditos/100);
                                        $papeleo=$prop->cantidad*($producto[0]->papeleria/100);
                                        $s_multa1=($prop->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                        $s_multa2=$producto[0]->penalizacion*$multa2;
                                        $sistema_total_cobrar=$prop->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                        $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                        $liquidar=$sistema_total_cobrar-$cliente_pago;
                                        $liquidacion=$liquidar;
                                @endphp
                                <small>Saldo</small><br>
                                <b for="">$ {{number_format($liquidacion,2)}}</b>
                            </div>
                            <div class="col-md-3 mb-2">
                                <small>Liquidar con: </small><br>
                                <b for="">$ {{number_format($prop->cantidad_propuesta,2)}}</b>
                                {{-- $ <input style="width: 100px; border: 0; border-bottom:1px #000 solid;" type="text" value="{{$prop->cantidad_propuesta}}"> --}}
                                {{-- <a href="#" class="btn btn-primary btn-sm">Editar</a> --}}
                            </div>
                            <div class="col-md-3 mb-2">
                                <small>Fecha solicitado</small><br>
                                <b for="">{{$prop->fecha_registro}}</b>
                            </div>  
                        </div>
                        <br><br>
                    </div>
                </div>
                </div>
            </div>
            @endforeach
        </div>
        <br><br><br>
    </div>
    
    </div>
@stop
@section('page-script')

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop