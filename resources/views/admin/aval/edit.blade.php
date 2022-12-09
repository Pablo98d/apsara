@extends('layouts.master')
@section('title','Registro Aval')
@section('parentPageTitle','Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ url('admin/aval/' .$aval->id_aval) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
    {{ method_field('PATCH') }}
	<div class="form-row">
		<div>
			<label for="id_socio_economico">Socio Economico</label>
			<input class="form-control" type="text" name="id_socio_economico" id="id_socio_economico" value="{{$aval->id_socio_economico}}" placeholder="Codigo">
		</div>
		<div>
			<label for="nombre">Nombre</label>
			<input class="form-control" type="text" id="nombre" name="nombre" value="{{$aval->nombre}}" placeholder="Nombre">
		</div>
		<div>
			<label for="ap_paterno">Apellido Paterno</label>
			<input class="form-control" id="ap_paterno" type="text" name="ap_paterno" value="{{$aval->ap_paterno}}" placeholder="Apellido Paterno">
		</div>
		<div>
			<label for="ap_materno">Apellido Materno</label>
			<input class="form-control" id="ap_materno" type="text" name="ap_materno" value="{{$aval->ap_materno}}" placeholder="Apellido Materno">
		</div>
	</div>
	<p></p>
	<div class="form-row">
		<div>
			<label for="fecha_nacimiento">Fecha de Nacimiento</label>
			<input class="form-control" id="fecha_nacimiento" type="text" name="fecha_nacimiento" value="{{$aval->fecha_nacimiento}}" placeholder="Fecha de Nacimiento">
		</div>
		<div>
			<label for="ocupacion">Ocupación</label>
			<input class="form-control" id="ocupacion" type="text" name="ocupacion" value="{{$aval->ocupacion}}" placeholder="Ocupación">
		</div>
		<div>
			<label for="genero">Genero</label>
			<input class="form-control" id="genero" type="text" name="genero" value="{{$aval->genero}}" placeholder="Genero">
		</div>
		<div>
			<label for="estado_civil">Estado Civil</label>
			<input class="form-control" id="estado_civil" type="text" name="estado_civil" value="{{$aval->estado_civil}}" placeholder="Estado Civil">
		</div>
		<br>
		<div class="form-row">
			<div>
				<label for="calle">Calle</label>
				<input class="form-control" id="calle" type="text" name="calle" value="{{$aval->calle}}" placeholder="Calle">
			</div>
			<div>
				<label for="numero_ext">Numero Exterior</label>
				<input class="form-control" id="numero_ext" type="text" name="numero_ext" value="{{$aval->numero_ext}}" placeholder="Numero Exterior">
			</div>
			<div>
				<label for="numero_int">Numero Interior</label>
				<input class="form-control" id="numero_int" type="text" name="numero_int" value="{{$aval->numero_int}}" placeholder="Numero Interior">
			</div>
			<div>
				<label for="entre_calles">Entre Calles</label>
				<input class="form-control" id="entre_calles" type="text" name="entre_calles" value="{{$aval->entre_calles}}" placeholder="Entre Calles">
			</div>
		</div>
	</div>
	<div class="form-row">
		<div>
			<label for="colonia">Colonia</label>
			<input class="form-control" id="colonia" type="text" name="colonia" value="{{$aval->colonia}}" placeholder="Colonia">
		</div>
		<div>
			<label for="municipio">Municipio</label>
			<input class="form-control" id="municipio" type="text" name="municipio" value="{{$aval->municipio}}" placeholder="Municipio">
		</div>
		<div>
			<label for="estado">Estado</label>
			<input class="form-control" id="estado" type="text" name="estado" value="{{$aval->estado}}" placeholder="Estado">
		</div>
		<div>
			<label for="referencia_visual">Referencia Visual</label>
			<input class="form-control" id="referencia_visual" type="text" name="referencia_visual" value="{{ $aval->referencia_visual}}" placeholder="Referencia Visual">
		</div>
	</div>
	<div class="form-row">
		<div>
			<label for="vivienda">Vivienda</label>
			<input class="form-control" id="vivienda" type="text" name="vivienda" value="{{$aval->vivienda}}" placeholder="Vivienda">
		</div>
		<div>
			<label for="tiempo_viviendo_domicilio">Tiempo viviendo en el domicilio</label>
			<input class="form-control" id="tiempo_viviendo_domicilio" type="text" name="tiempo_viviendo_domicilio" value="{{$aval->tiempo_viviendo_domicilio}}" placeholder="Tiempo viviendo en el domicilio">
		</div>
		<div>
			<label for="telefono_casa">Teléfono Casa</label>
			<input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{$aval->telefono_casa}}" placeholder="Telefono Casa">
		</div>
		<div>
			<label for="telefono_movil">Teléfono Movil</label>
			<input class="form-control" id="telefono_movil" type="text" name="telefono_movil" value="{{ $aval->telefono_movil}}" placeholder="Telefono Movil">
		</div>
	</div>
	<div class="form-row">
		<div>
			<label for="telefono_trabajo">Teléfono del Trabajo</label>
			<input class="form-control" id="telefono_trabajo" type="text" name="telefono_trabajo" value="{{$aval->telefono_trabajo}}" placeholder="Telefono del Trabajo">
		</div>
		<div>
			<label for="relacion_solicitante">Relación con el solicitante</label>
			<input class="form-control" id="relacion_solicitante" type="text" name="relacion_solicitante" value="{{$aval->relacion_solicitante}}" placeholder="Relación Solicitante">
		</div>
	</div>
	<div class="form-row">
		<button class="btn btn-primary" type="submit">Actualizar</button>
		<a class="btn btn-danger" type="submit" href="{{ route('aval.index') }}">Cancelar</a>
	</div>
</form>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop