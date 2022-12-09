@extends('layouts.master')
@section('title','Registro Articulos del Hogar')
@section('parentPageTitle','Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ url('admin/articuloshogar/' .$articuloshogar->id_articulo) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
    {{ method_field('PATCH') }}
	<div class="form-row">
		<div>
			<label for="id_socio_economico">Socio Economico</label>
			<input class="form-control" type="text" name="id_socio_economico" id="id_socio_economico" value="{{$articuloshogar->id_socio_economico}}" placeholder="Codigo">
		</div>
		<div>
			<label for="estufa">Estufa</label>
			<input class="form-control" type="text" id="estufa" name="estufa" value="{{$articuloshogar->estufa}}" placeholder="Estufa">
		</div>
		<div>
			<label for="refrigerador">Refrigerador</label>
			<input class="form-control" id="refrigerador" type="text" name="refrigerador" value="{{$articuloshogar->refrigerador}}" placeholder="Refrigerador">
		</div>
		<div>
			<label for="microondas">Microondas</label>
			<input class="form-control" id="microondas" type="text" name="microondas" value="{{$articuloshogar->microondas}}" placeholder="Microondas">
		</div>
	</div>
	<p></p>
	<div class="form-row">
		<div>
			<label for="lavadora">Lavadora</label>
			<input class="form-control" id="lavadora" type="text" name="lavadora" value="{{$articuloshogar->lavadora}}" placeholder="Lavadora">
		</div>
		<div>
			<label for="secadora">Secadora</label>
			<input class="form-control" id="secadora" type="text" name="secadora" value="{{$articuloshogar->secadora}}" placeholder="Secadora">
		</div>
		<div>
			<label for="computadora_escritorio">Computadora de escritorio</label>
			<input class="form-control" id="computadora_escritorio" type="text" name="computadora_escritorio" value="{{$articuloshogar->computadora_escritorio}}" placeholder="Computadora de escritorio">
		</div>
		<div>
			<label for="laptop">Laptop</label>
			<input class="form-control" id="laptop" type="text" name="laptop" value="{{$articuloshogar->laptop}}" placeholder="Laptop">
		</div>
		<br>
		<div class="form-row">
			<div>
				<label for="television">Televisión</label>
				<input class="form-control" id="television" type="text" name="television" value="{{$articuloshogar->television}}" placeholder="Televisión">
			</div>
			<div>
				<label for="pantalla">Pantalla</label>
				<input class="form-control" id="pantalla" type="text" name="pantalla" value="{{$articuloshogar->pantalla}}" placeholder="Pantalla">
			</div>
			<div>
				<label for="grabadora">Grabadora</label>
				<input class="form-control" id="grabadora" type="text" name="grabadora" value="{{$articuloshogar->grabadora}}" placeholder="Grabadora">
			</div>
			<div>
				<label for="estereo">Estereo</label>
				<input class="form-control" id="estereo" type="text" name="estereo" value="{{$articuloshogar->estereo}}" placeholder="Estereo">
			</div>
		</div>
	</div>
	<div class="form-row">
		<div>
			<label for="dvd">DvD</label>
			<input class="form-control" id="dvd" type="text" name="dvd" value="{{$articuloshogar->dvd}}" placeholder="DvD">
		</div>
		<div>
			<label for="blue_ray">Blue Ray</label>
			<input class="form-control" id="blue_ray" type="text" name="blue_ray" value="{{$articuloshogar->blue_ray}}" placeholder="Blue Ray">
		</div>
		<div>
			<label for="teatro_casa">Teatro casa</label>
			<input class="form-control" id="teatro_casa" type="text" name="teatro_casa" value="{{$articuloshogar->teatro_casa}}" placeholder="Teatro casa">
		</div>
		<div>
			<label for="bocina_portatil">Bocina portatil</label>
			<input class="form-control" id="bocina_portatil" type="text" name="bocina_portatil" value="{{ $articuloshogar->bocina_portatil}}" placeholder="Bocina portatil">
		</div>
	</div>
	<div class="form-row">
		<div>
			<label for="celular">Celular</label>
			<input class="form-control" id="celular" type="text" name="celular" value="{{$articuloshogar->celular}}" placeholder="Celular">
		</div>
		<div>
			<label for="tablet">Tablet</label>
			<input class="form-control" id="tablet" type="text" name="tablet" value="{{$articuloshogar->tablet}}" placeholder="Tablet">
		</div>
		<div>
			<label for="consola_videojuegos">Consola videojuegos</label>
			<input class="form-control" id="consola_videojuegos" type="text" name="consola_videojuegos" value="{{$articuloshogar->consola_videojuegos}}" placeholder="Consola videojuegos">
		</div>
		<div>
			<label for="instrumentos">Instrumentos</label>
			<input class="form-control" id="instrumentos" type="text" name="instrumentos" value="{{ $articuloshogar->instrumentos}}" placeholder="Instrumentos">
		</div>
	</div>
	<div class="form-row">
		<div>
			<label for="otros">Otros</label>
			<input class="form-control" id="otros" type="text" name="otros" value="{{$articuloshogar->otros}}" placeholder="Otros">
		</div>
	</div>
	<div class="form-row">
		<button class="btn btn-primary" type="submit">Actualizar</button>
		<a class="btn btn-danger" type="submit" href="{{ route('articuloshogar.index') }}">Cancelar</a>
	</div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop