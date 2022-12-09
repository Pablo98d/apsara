@extends('layouts.master')
@section('title', 'Mejor panorama')
@section('parentPageTitle', 'préstamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>

@stop
@section('content')
<div class="row">
  <div class="col-md-12">
    @if ( session('status') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <center>
          {{ session('status') }}
        </center>
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
    @endif
  </div>
</div>
<div class="col-md-12">
  <div class="estilo-tabla">
    <table>
      <thead>
        
        <tr>
          <th style="border:1px solid rgb(238, 238, 238); background: #3783fa;">RUTA</th>
          <th style="border:1px solid rgb(238, 238, 238); background: #3783fa; text-align: center;" colspan="2">{{$zona->Zona}}</th>
          <th style="border:1px solid rgb(238, 238, 238); background: #3783fa; text-align: center" rowspan="3">25 JULIO</th>
          <th style="border:1px solid rgb(238, 238, 238); background: #3783fa; text-align: center;" rowspan="3">COMISION</th>   
          {{-- <th style="border:1px solid rgb(238, 238, 238); background: #3783fa;"></th> --}}
        </tr>
        <tr>
          <th style="border:1px solid rgb(238, 238, 238); background: #3783fa;">GERENTE</th>
          <th style="border:1px solid rgb(238, 238, 238); background: #3783fa; text-align: center;" colspan="2">
            @if (count($gerentes_de_zona)==0)
                
            @else
                @foreach ($gerentes_de_zona as $gerente_de_zona)
                    {{$gerente_de_zona->nombre}} {{$gerente_de_zona->ap_paterno}} <br>  
                @endforeach
            @endif
          </th>
          {{-- <th style="border:1px solid rgb(238, 238, 238); background: #3783fa;"></th> --}}
        </tr>
        <tr>
          <th style="border:1px solid rgb(238, 238, 238); background: #3783fa;">SUPERVISORA</th>
          <th style="border:1px solid rgb(238, 238, 238); background: #3783fa; text-align: center;" colspan="2">CINTHIA AVALOS</th>
          {{-- <th style="border:1px solid rgb(238, 238, 238); background: #3783fa;"></th> --}}
        </tr>
        <tr>
          {{-- <th style="border:1px solid rgb(238, 238, 238); background: #3783fa;">SEMANA</th> --}}
          {{-- <th style="border:1px solid rgb(238, 238, 238); background: #3783fa; text-align: center;" colspan="2">30</th> --}}
          
        </tr>
        <tr>
          <th style="border:1px solid rgb(238, 238, 238); background: #2775f2; text-align: center; padding: 10px;"><strong>GRUPO</strong></th>
          <th style="border:1px solid rgb(238, 238, 238); background: #2775f2; text-align: center; padding: 10px;"><strong>CLIENTES</strong></th>
          <th style="border:1px solid rgb(238, 238, 238); background: #2775f2; text-align: center; padding: 10px;"><strong>MONTO IDEAL</strong></th>
          <th style="border:1px solid rgb(238, 238, 238); background: #2775f2; text-align: center; padding: 10px;"><strong>CORTE DINERO</strong></th>
          <th style="border:1px solid rgb(238, 238, 238); background: #2775f2; text-align: center; padding: 10px;"><strong>MONTO RECUPERABLE IDEAL</strong></th>
        </tr>
      </thead>
      <tbody>
        @if (count($grupos)==0)
            
        @else
        @foreach ($grupos as $grupo)
          @php
              $semana_corte = DB::table('tbl_cortes_semanas')
                ->select('tbl_cortes_semanas.numero_semana_corte')
                ->where('id_grupo','=',$grupo->id_grupo)
                ->orderBy('tbl_cortes_semanas.fecha_final','ASC')->get();

              $total_clientes=DB::table('tbl_prestamos')
                ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                ->select('tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_productos.pago_semanal')
                // ->where('tbl_prestamos.id_promotora','=',$promotora->id_usuario)
                ->where('tbl_prestamos.id_grupo','=',$grupo->id_grupo)
                ->whereIn('tbl_prestamos.id_status_prestamo',[9,2])
                ->get();
                
                $clientes_activos=count($total_clientes);
                $monto_ideal=0;
                $monto_recuperable_ideal=0;

                if ($clientes_activos==0) {
                    $monto_ideal+=0;
                } else {
                    foreach ($total_clientes as $total_cliente) {

                      $cliente = DB::table('tbl_prestamos')
                        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                        ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                        ->where('tbl_prestamos.id_prestamo','=',$total_cliente->id_prestamo)
                        ->distinct()
                        ->get();
                                    
                      
                      
                      foreach ($cliente as $cli){
                            $saldo=0;        

                            $producto = DB::table('tbl_productos')   
                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                            ->select('tbl_productos.*')
                            ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                            ->get();
                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                            ->select('cantidad')
                            ->where('id_prestamo','=',$cli->id_prestamo)
                            ->get();
                            $tipo_liquidacion = DB::table('tbl_abonos')
                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                            ->where('id_prestamo', '=', $cli->id_prestamo)
                            ->where('id_tipoabono','=',1)
                            ->get();
                            $tipo_abono = DB::table('tbl_abonos')
                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                            ->where('id_prestamo', '=', $cli->id_prestamo)
                            ->where('id_tipoabono','=',2)
                            ->get();
                            $tipo_ahorro = DB::table('tbl_abonos')
                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                            ->where('id_prestamo', '=', $cli->id_prestamo)
                            ->where('id_tipoabono','=',3)
                            ->get();
                            $tipo_multa_1 = DB::table('tbl_abonos')
                            ->select(DB::raw('count(*) as tipo_multa_1'))
                            ->where('id_prestamo', '=', $cli->id_prestamo)
                            ->where('id_tipoabono','=',4)
                            ->get();
                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                    $multa1=0;
                                }else {
                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                }
                            $tipo_multa_2 = DB::table('tbl_abonos')
                            ->select(DB::raw('count(*) as tipo_multa_2'))
                            ->where('id_prestamo', '=', $cli->id_prestamo)
                            ->where('id_tipoabono','=',5)
                            ->get();
                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                    $multa2=0;
                                }else {
                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                }
                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                            // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                            $s_multa2=$producto[0]->penalizacion*$multa2;
                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                            $saldo=$sistema_total_cobrar-$cliente_pago;
                            
                            //$t_semana_rojo+=$semana_n->cantidad;
                            
                            // $s_semana_rojo+=$semana_n->cantidad;
                            $monto_recuperable_ideal+=$saldo;
                            
                      }
                      

                      $monto_ideal+=$total_cliente->cantidad*($total_cliente->pago_semanal/100);
                    }
                }
          @endphp
          <tr>
            <td>
              {{$grupo->grupo}} 
               <small style="float: right;padding-right: 15px">
                semana(
                  @if (empty($semana_corte->last()->numero_semana_corte))
                      no encontrado
                  @else
                      {{$semana_corte->last()->numero_semana_corte}}
                      
                  @endif
                )</small>
            </td>
            <td style="text-align: right;padding-right: 15px;">
              <b>{{number_format($clientes_activos)}}</b>
            </td>
            <td style="text-align: right;padding-right: 15px;"><b> $ {{number_format($monto_ideal,2)}}</b></td>
            <td style="text-align: right">
              
            </td>
            <td style="text-align: right;padding-right: 15px;">
              <b>
                $ {{number_format($monto_recuperable_ideal,2)}}  
              </b>
            </td>
          </tr>
        @endforeach
            
        @endif
        
      </tbody>
    </table>
  </div>
</div>
<br><br><br>
@stop
@section('page-script')
<script>
window.onload = function agregar_boton_atras(){
  
      document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
      document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
  }
</script>

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>

@stop