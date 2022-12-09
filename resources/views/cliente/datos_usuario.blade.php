@extends('layoutsC.master')
@section('title','Registro Datos Usuario')
@section('parentPageTitle','usuario')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<hr>
		@if ( session('status') )
      	<div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
			{{ session('status') }}
			<button class="close" type="button" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">x</span>
			</button>
      	</div>
    @endif
	</div>
</div>
	<div class="accordion" id="accordionExample">
		<div class="card">
			<div class="card-header" id="headingOne">
				<h5 class="mb-0">
				<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					Mis datos
				</button>
				</h5>
			</div>
	
			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
				<div class="card-body">
					@php
						$id_usuario=DB::table('tbl_datos_usuario')
						->select('tbl_datos_usuario.*')
						->where('id_usuario','=',auth()->user()->id)
						->get();

						$datos_usuario=count($id_usuario);
					@endphp
					@if ($datos_usuario==0)
						{{--  --}}
							<div class="form-row">
								<div class="col-md-3 mt-3"> 
								<input type="hidden" name="id_usuario" value="{{auth()->user()->id}}"> 
									<label for="nombre">Nombre</label>
									<input class="form-control" type="text" id="nombre" name="nombre" value="{{old('nombre')}}" placeholder="Nombre">
								</div>
								<div class="col-md-3 mt-3">
									<label for="ap_paterno">Apellido Paterno</label>
									<input class="form-control" id="ap_paterno" type="text" name="ap_paterno" value="{{old('ap_paterno')}}" placeholder="Apellido Paterno">
								</div>
								<div class="col-md-3 mt-3">
									<label for="ap_materno">Apellido Materno</label>
									<input class="form-control" id="ap_materno" type="text" name="ap_materno" value="{{old('ap_materno')}}" placeholder="Apellido Materno">
								</div>
								<div class="col-md-3 mt-3">
									<label for="telefono_casa">Teléfono Casa</label>
									<input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{old('telefono_casa')}}" placeholder="Telefono Casa">
								</div>
								<div class="col-md-3 mt-3">
									<label for="telefono_celular">Teléfono Celular</label>
									<input class="form-control" id="telefono_celular" type="text" name="telefono_celular" value="{{old('telefono_celular')}}" placeholder="Telefono Celular">
								</div>
								<div class="col-md-3 mt-3">
									<label for="direccion">Dirección</label>
									<input class="form-control" id="direccion" type="text" name="direccion" value="{{old('direccion')}}" placeholder="">
								</div>
								<div class="col-md-3 mt-3">
									<label for="numero_exterior">Numero Exterior</label>
									<input class="form-control" id="numero_exterior" type="text" name="numero_exterior" value="{{old('numero_exterior')}}" placeholder="Numero Exterior">
								</div>
									<div class="col-md-3 mt-3">
										<label for="numero_interior">Numero Interior</label>
										<input class="form-control" id="numero_interior" type="text" name="numero_interior" value="{{old('numero_interior')}}" placeholder="Numero Interior">
									</div>
									<div class="col-md-3 mt-3">
										<label for="colonia">Colonia</label>
										<input class="form-control" id="colonia" type="text" name="colonia" value="{{old('colonia')}}" placeholder="Colonia">
									</div>
									<div class="col-md-3 mt-3">
										<label for="codigo_postal">Código Postal</label>
										<input class="form-control" id="codigo_postal" type="text" name="codigo_postal" value="{{old('codigo_postal')}}" placeholder="Codigo Postal">
									</div>
									<div class="col-md-3 mt-3">
										<label for="localidad">Localidad</label>
										<input class="form-control" id="localidad" type="text" name="localidad" value="{{old('localidad')}}" placeholder="Localidad">
									</div>
								<div class="col-md-3 mt-3">
									<label for="municipio">Municipio</label>
									<input class="form-control" id="municipio" type="text" name="municipio" value="{{old('municipio')}}" placeholder="Municipio">
								</div>
								<div class="col-md-3 mt-3">
									<label for="estado">Estado</label>
									<input class="form-control" id="estado" type="text" name="estado" value="{{old('estado')}}" placeholder="Estado">
								</div>
								<div class="col-md-3 mt-3">
									<label for="latitud">Latitud</label>
									<input class="form-control" id="latitud" type="text" name="latitud" value="{{old('latitud')}}" placeholder="Latitud">
								</div>
								<div class="col-md-3 mt-3">
									<label for="longitud">Longitud</label>
									<input class="form-control" id="longitud" type="text" name="longitud" value="{{old('longitud')}}" placeholder="Longitud">
								</div>
							</div><p></p>
							
					
					@else
						
							<div class="form-row">
								<div class="col-md-3 mt-3"> 
								<input type="hidden" name="id_usuario" value="{{auth()->user()->id}}"> 
								{{-- <input type="hidden" name="id_datos_usuario" value="{{$id_usuario[0]->id_datos_usuario}}">  --}}
									<label for="nombre">Nombre</label>
									<input class="form-control" type="text" id="nombre" name="nombre" value="{{$id_usuario[0]->nombre}}" placeholder="Nombre">
								</div>
								<div class="col-md-3 mt-3">
									<label for="ap_paterno">Apellido Paterno</label>
									<input class="form-control" id="ap_paterno" type="text" name="ap_paterno" value="{{$id_usuario[0]->ap_paterno}}" placeholder="Apellido Paterno">
								</div>
								<div class="col-md-3 mt-3">
									<label for="ap_materno">Apellido Materno</label>
									<input class="form-control" id="ap_materno" type="text" name="ap_materno" value="{{$id_usuario[0]->ap_materno}}" placeholder="Apellido Materno">
								</div>
								<div class="col-md-3 mt-3">
									<label for="telefono_casa">Teléfono Casa</label>
									<input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{$id_usuario[0]->telefono_casa}}" placeholder="Telefono Casa">
								</div>
								<div class="col-md-3 mt-3">
									<label for="telefono_celular">Teléfono Celular</label>
									<input class="form-control" id="telefono_celular" type="text" name="telefono_celular" value="{{$id_usuario[0]->telefono_celular}}" placeholder="Telefono Celular">
								</div>
								<div class="col-md-3 mt-3">
									<label for="direccion">Dirección</label>
									<input class="form-control" id="direccion" type="text" name="direccion" value="{{$id_usuario[0]->direccion}}" placeholder="">
								</div>
								<div class="col-md-3 mt-3">
									<label for="numero_exterior">Numero Exterior</label>
									<input class="form-control" id="numero_exterior" type="text" name="numero_exterior" value="{{$id_usuario[0]->numero_exterior}}" placeholder="Numero Exterior">
								</div>
									<div class="col-md-3 mt-3">
										<label for="numero_interior">Numero Interior</label>
										<input class="form-control" id="numero_interior" type="text" name="numero_interior" value="{{$id_usuario[0]->numero_interior}}" placeholder="Numero Interior">
									</div>
									<div class="col-md-3 mt-3">
										<label for="colonia">Colonia</label>
										<input class="form-control" id="colonia" type="text" name="colonia" value="{{$id_usuario[0]->colonia}}" placeholder="Colonia">
									</div>
									<div class="col-md-3 mt-3">
										<label for="codigo_postal">Código Postal</label>
										<input class="form-control" id="codigo_postal" type="text" name="codigo_postal" value="{{$id_usuario[0]->codigo_postal}}" placeholder="Codigo Postal">
									</div>
									<div class="col-md-3 mt-3">
										<label for="localidad">Localidad</label>
										<input class="form-control" id="localidad" type="text" name="localidad" value="{{$id_usuario[0]->localidad}}" placeholder="Localidad">
									</div>
								<div class="col-md-3 mt-3">
									<label for="municipio">Municipio</label>
									<input class="form-control" id="municipio" type="text" name="municipio" value="{{$id_usuario[0]->municipio}}" placeholder="Municipio">
								</div>
								<div class="col-md-3 mt-3">
									<label for="estado">Estado</label>
									<input class="form-control" id="estado" type="text" name="estado" value="{{$id_usuario[0]->estado}}" placeholder="Estado">
								</div>
								<div class="col-md-3 mt-3">
									<label for="latitud">Latitud</label>
									<input class="form-control" id="latitud" type="text" name="latitud" value="{{$id_usuario[0]->latitud}}" placeholder="Latitud">
								</div>
								<div class="col-md-3 mt-3">
									<label for="longitud">Longitud</label>
									<input class="form-control" id="longitud" type="text" name="longitud" value="{{$id_usuario[0]->longitud}}" placeholder="Longitud">
								</div>
							</div><p></p>
							
					@endif
				</div>
			</div>
		</div>
	</div>
	
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop