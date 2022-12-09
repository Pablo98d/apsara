@extends('layoutsC.master')
@section('title', 'La Feriecita')
@section('page-style')
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/> --}}
<link rel="stylesheet" href="{{asset('css/estilo_porcentaje.css')}}">
@stop
@section('content')

<style>
	#circleBar{
		margin-top: 10px;
		text-align: center;
		font-family: tahoma;
	}
	#circleBar .round{
		min-height: 255px;
		margin-top: 30px;
		position: relative;
		margin-bottom: 20px;
	}
	#circleBar .round strong{
		position: absolute;
		top: 50%;
		left: 50%;
		margin-top: -50px;
		transform: translate(-50%);
		font-size: 30px;
		color: #212121;
		font-weight: 100;
	}

	#circleBar span{
		display: block;
		color: #999;
		font-size: 17px;
		margin-top: 10px;
	}
	.round strong{
		position: fixed;

	}
	.round strong span{
		font-size: 9px;
	}
</style>

<div class="row centro">
<div class="col-md-12">
	<hr>
</div>
	@php
		 $id_usuario=DB::table('tbl_datos_usuario')
		->select('tbl_datos_usuario.*')
		->where('id_usuario','=',auth()->user()->id)
		->get();

		$datos_usuario=count($id_usuario);
	@endphp

	@if ($datos_usuario==0)
		<div class="col-md-12">
			<div class="alert alert-danger" role="alert">
					<center>
						¡Complete sus datos por favor! <a href="#"><b>Completar datos</b></a>
					</center>
			</div>
		</div>
	@else
		
		
	@endif
		@php
			$p=count($prestamo)
		@endphp
	@if ($p==0)
		Ningun préstamo
	@else
	@php
		$multa1=0;
		$multa2=0;
	@endphp
	@foreach ($prestamo as $pres)
		
	
		@php
			$status_activo = DB::table('tbl_prestamos')
			->select('tbl_prestamos.*')
			->where('id_usuario','=',auth()->user()->id)
			->where('id_status_prestamo','=',2)
			->get();
			$status_renovado = DB::table('tbl_prestamos')
			->select('tbl_prestamos.*')
			->where('id_usuario','=',auth()->user()->id)
			->where('id_status_prestamo','=',9)
			->get();
			$status_aprobado = DB::table('tbl_prestamos')
			->select('tbl_prestamos.*')
			->where('id_usuario','=',auth()->user()->id)
			->where('id_status_prestamo','=',10)
			->get();

			$contar_renovado=count($status_renovado);
			$contarp=count($status_activo);
		@endphp
		@if (count($status_aprobado)==0)
			@if (count($status_renovado)==0)
				@if (count($status_activo)==0)
					<span class="badge badge-info">Sin préstamo activo</span>
				@else
					<div class="col-md-12">
						<center>
							PRÉSTAMO ACTIVO
						</center>
					</div>
					<div class="col-md-12" style="background: rgb(206, 206, 206);display: flex; padding: 10px;border-radius: 10px;">
					  <span ><b>Préstamo:</b> <br>&nbsp;#{{$status_activo[0]->id_prestamo}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
					  <span ><b>Monto:</b> <br> &nbsp;$ {{number_format($status_activo[0]->cantidad,2)}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
					  	@php
							$fechaEntrega = $status_activo[0]->fecha_entrega_recurso;
							setlocale(LC_TIME, "spanish");
							$fecha_ini = $fechaEntrega;
							$fecha_ini = str_replace("/", "-", $fecha_ini);
							$Nueva_Fecha_entrega = date("d-m-Y", strtotime($fecha_ini));

							
				  		@endphp
					  <span  aria-current="page"><b>Entrega de recurso:</b> <br>&nbsp;{{$Nueva_Fecha_entrega}}</span>
					  <br>
					  	@php
							$producto = DB::table('tbl_productos')   
							->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
							->select('tbl_productos.*')
							->where('tbl_prestamos.id_prestamo','=',$status_activo[0]->id_prestamo)
							->get();
							$cantidad_prestamo = DB::table('tbl_prestamos')   
							// ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
							->select('cantidad')
							->where('id_prestamo','=',$status_activo[0]->id_prestamo)
							->get();
							$tipo_liquidacion = DB::table('tbl_abonos')
							->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
							->where('id_prestamo', '=', $status_activo[0]->id_prestamo)
							->where('id_tipoabono','=',1)
							->get();
							$tipo_abono = DB::table('tbl_abonos')
							->select(DB::raw('SUM(cantidad) as tipo_abono'))
							->where('id_prestamo', '=', $status_activo[0]->id_prestamo)
							->where('id_tipoabono','=',2)
							->get();
							$tipo_ahorro = DB::table('tbl_abonos')
							->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
							->where('id_prestamo', '=', $status_activo[0]->id_prestamo)
							->where('id_tipoabono','=',3)
							->get();
							$tipo_multa_1 = DB::table('tbl_abonos')
							->select(DB::raw('count(*) as tipo_multa_1'))
							->where('id_prestamo', '=', $status_activo[0]->id_prestamo)
							->where('id_tipoabono','=',4)
							->get();
								if (empty($tipo_multa_1[0]->tipo_multa_1)) {
									$multa1=0;
								}else {
									$multa1=$tipo_multa_1[0]->tipo_multa_1;
								}
							$tipo_multa_2 = DB::table('tbl_abonos')
							->select(DB::raw('count(*) as tipo_multa_2'))
							->where('id_prestamo', '=', $status_activo[0]->id_prestamo)
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
						@endphp 
						<span  aria-current="page">&nbsp;&nbsp;&nbsp;&nbsp;<b>Total abonado:</b> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{number_format($cliente_pago,2)}}</span>
						<span  aria-current="page">&nbsp;&nbsp;&nbsp;&nbsp;<b>Saldo actual:</b> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{number_format($liquidar,2)}}</span>
						<span  aria-current="page">&nbsp;&nbsp;&nbsp;&nbsp;<b>Total a pagar:</b> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{number_format($sistema_total_cobrar,2)}}</span>
					</div>
				@endif
			@else
					<div class="col-md-12">
						<center>
							PRÉSTAMO ACTIVO
						</center><br><br>
					</div>
					<div class="col-md-12" style="background: rgb(206, 206, 206);display: flex; padding: 10px;border-radius: 10px;">
						<span ><b>Préstamo:</b> <br>&nbsp;#{{$status_renovado[0]->id_prestamo}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
						<span ><b>Monto:</b> <br> &nbsp;$ {{number_format($status_renovado[0]->cantidad,2)}}</span>&nbsp;&nbsp;&nbsp;&nbsp;
						@php
						$fechaEntrega = $status_renovado[0]->fecha_entrega_recurso;
						setlocale(LC_TIME, "spanish");
						$fecha_ini = $fechaEntrega;
						$fecha_ini = str_replace("/", "-", $fecha_ini);
						$Nueva_Fecha_entrega = date("d-m-Y", strtotime($fecha_ini));

						
						@endphp
						<span  aria-current="page"><b>Entrega de recurso:</b> <br>&nbsp;{{$Nueva_Fecha_entrega}}</span>
						<br>
						@php
						$producto = DB::table('tbl_productos')   
						->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
						->select('tbl_productos.*')
						->where('tbl_prestamos.id_prestamo','=',$status_renovado[0]->id_prestamo)
						->get();
						$cantidad_prestamo = DB::table('tbl_prestamos')   
						// ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
						->select('cantidad')
						->where('id_prestamo','=',$status_renovado[0]->id_prestamo)
						->get();
						$tipo_liquidacion = DB::table('tbl_abonos')
						->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
						->where('id_prestamo', '=', $status_renovado[0]->id_prestamo)
						->where('id_tipoabono','=',1)
						->get();
						$tipo_abono = DB::table('tbl_abonos')
						->select(DB::raw('SUM(cantidad) as tipo_abono'))
						->where('id_prestamo', '=', $status_renovado[0]->id_prestamo)
						->where('id_tipoabono','=',2)
						->get();
						$tipo_ahorro = DB::table('tbl_abonos')
						->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
						->where('id_prestamo', '=', $status_renovado[0]->id_prestamo)
						->where('id_tipoabono','=',3)
						->get();
						$tipo_multa_1 = DB::table('tbl_abonos')
						->select(DB::raw('count(*) as tipo_multa_1'))
						->where('id_prestamo', '=', $status_renovado[0]->id_prestamo)
						->where('id_tipoabono','=',4)
						->get();
							if (empty($tipo_multa_1[0]->tipo_multa_1)) {
								$multa1=0;
							}else {
								$multa1=$tipo_multa_1[0]->tipo_multa_1;
							}
						$tipo_multa_2 = DB::table('tbl_abonos')
						->select(DB::raw('count(*) as tipo_multa_2'))
						->where('id_prestamo', '=', $status_renovado[0]->id_prestamo)
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
					@endphp 
					<span  aria-current="page">&nbsp;&nbsp;&nbsp;&nbsp;<b>Total abonado:</b> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{number_format($cliente_pago,2)}}</span>
					<span  aria-current="page">&nbsp;&nbsp;&nbsp;&nbsp;<b>Saldo actual:</b> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{number_format($liquidar,2)}}</span>
					<span  aria-current="page">&nbsp;&nbsp;&nbsp;&nbsp;<b>Total a pagar:</b> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{number_format($sistema_total_cobrar,2)}}</span>
			  	</div>
			@endif
		@else
			<span class="badge badge-info">Renovación en espera de activación</span>
		@endif

	@endforeach
	@endif
</div>
<br><br><br>
@stop
@section('page-script')

@stop