@extends('layouts.master')
@section('title','Actualizando datos del usuario')
@section('parentPageTitle','usuario')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<style>
	hr  {
		height: 4px !important; 
		margin-top: 20px !important;
		text-align: center !important;
		
	} 

	.hr1:after {
		content:"Datos del usuario" !important; 
		position: relative !important; 
		top: -12px !important; 
		display: inline-block !important; 
		background: rgb(245, 245, 245);
		width: 200px !important;
		}
	.hr2:after {
		content:"Datos del domicilio" !important; 
		position: relative !important; 
		top: -12px !important; 
		display: inline-block !important; 
		background: rgb(245, 245, 245);
		width: 230px !important;
		}
	
</style>
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		@if ( session('Guardar') )
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('Guardar') }}
			<button class="close" type="button" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true"></span>
			</button>
			</div>
		@endif
		@if ( session('error') )
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session('error') }}
			<button class="close" type="button" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true"></span>
			</button>
			</div>
		@endif
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<hr>
	</div>
</div>
<form method="POST" action="{{ url('admin/users/' .$datosusuario[0]->id) }}" enctype="multipart/form-data">
	{{-- <form method="POST" action="{{ url('admin/datosusuario/' .$datosusuario->id_datos_usuario) }}" enctype="multipart/form-data"> --}}
	{{ csrf_field() }}
    {{ method_field('PATCH') }}
	<hr class="hr1 mt-3">
	<div class="form-row">
        <div class="form-group col-md-3">
          <label for="email">Nombre</label>
          <input class="form-control" type="text" id="nombre" name="nombre" value="{{$datosusuario[0]->nombre}}" placeholder="Nombre">
          @error('nombre')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
		<div class="form-group col-md-3">
			<label for="ap_paterno">Apellido Paterno</label>
			<input class="form-control" id="ap_paterno" type="text" name="ap_paterno" value="{{$datosusuario[0]->ap_paterno}}" placeholder="Apellido Paterno">
			@error('ap_paterno')
			  <span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			  </span>
			@enderror
		  </div>
		  <div class="form-group col-md-3">
			<label for="ap_materno">Apellido Materno</label>
			<input class="form-control" id="ap_materno" type="text" name="ap_materno" value="{{$datosusuario[0]->ap_materno}}" placeholder="Apellido Materno">
			@error('ap_materno')
			  <span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			  </span>
			@enderror
		  </div>
		  <div class="form-group col-md-3">
			
			<label for="id_tipo_usuario">Tipo Usuario</label>
			<select class="form-control" name="id_tipo_usuario" id="id_tipo_usuario">

				
				@if ($datosusuario[0]->id_tipo_usuario==4)
					@php
						$promotora = DB::table('tbl_prestamos')
						->select(DB::raw('count(*) as total_clientes'))
						->where('id_promotora', '=', $datosusuario[0]->id)
						->get();
					@endphp
					@if ($promotora[0]->total_clientes==0)
						@foreach ($tipUs as $tu)
							<option {{$tu->id_tipo_usuario == $datosusuario[0]->id_tipo_usuario ? 'selected="selected"' : 'Selecciona un tipo de usuario'}}  value="{{$tu->id_tipo_usuario}}">{{$tu->nombre}}</option>
						@endforeach
					@else
						<option value="4" selected>Promotora</option>
						{{-- <option value="">Imposible cambiar de tipo de usuario</option> --}}
					@endif
				@else
					<option value="">Seleccione tipo de usuario</option>
					@foreach ($tipUs as $tu)
						<option {{$tu->id_tipo_usuario == $datosusuario[0]->id_tipo_usuario ? 'selected="selected"' : 'Selecciona un tipo de usuario'}}  value="{{$tu->id_tipo_usuario}}">{{$tu->nombre}}</option>
					@endforeach
				@endif
				
				
				
			</select>
		  </div>
		  <div class="form-group col-md-4">
			<label for="email">Correo Electrónico</label>
			<input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $datosusuario[0]->email }}" required autocomplete="email">
			@error('email')
			  <span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			  </span>
			@enderror
		  </div>
        {{-- <div class="form-group col-md-4">
          <label for="password">Contraseña</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" value="{{ $datosusuario[0]->password }}">
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div> --}}
      </div>
      {{-- <div class="form-row">
        <div class="form-group col-md-6">
          <label for="nombre_usuario">Usuario</label>
          <input name="nombre_usuario" type="text" class="form-control" id="nombre_usuario" class="form-control @error('nombre_usuario') is-invalid @enderror" value="{{ $datosusuario[0]->nombre_usuario }}" required autocomplete="nombre_usuario" autofocus>
          @error('nombre_usuario')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        
      </div> --}}
	  <hr class="hr2 mt-4">
	<div class="form-row">
		
		{{-- <div class="col-md-3 mb-2">
			<label for="id_usuario">Usuario</label>
			@if (empty($usuario[0]->nombre_usuario))
				Ningun usuario
			@else
			<input type="hidden" id="id_usuario" name="id_usuario">
			<input class="form-control" type="text"  value="{{$usuario[0]->nombre_usuario}}" readonly>
			@endif
		</div> --}}
		{{-- <div class="col-md-3 mb-2">
			<label for="nombre">Nombre</label>
			<input class="form-control" type="text" id="nombre" name="nombre" value="{{$datosusuario[0]->nombre}}" placeholder="Nombre">
		</div> --}}
		{{-- <div class="col-md-3 mb-2">
			<label for="ap_paterno">Apellido Paterno</label>
			<input class="form-control" id="ap_paterno" type="text" name="ap_paterno" value="{{$datosusuario[0]->ap_paterno}}" placeholder="Apellido Paterno">
		</div> --}}
		{{-- <div class="col-md-3 mb-2">
			<label for="ap_materno">Apellido Materno</label>
			<input class="form-control" id="ap_materno" type="text" name="ap_materno" value="{{$datosusuario[0]->ap_materno}}" placeholder="Apellido Materno">
		</div> --}}
		
		<div class="col-md-3 mb-2">
			<label for="telefono_casa">Teléfono Casa</label>
			<input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{$datosusuario[0]->telefono_casa}}" placeholder="Telefono Casa">
		</div>
		<div class="col-md-3 mb-2">
			<label for="telefono_celular">Teléfono Celular</label>
			<input class="form-control" id="telefono_celular" type="text" name="telefono_celular" value="{{$datosusuario[0]->telefono_celular}}" placeholder="Telefono Celular">
		</div>
		<div class="col-md-3 mb-2">
			<label for="direccion">Dirección</label>
			<input class="form-control" id="direccion" type="text" name="direccion" value="{{$datosusuario[0]->direccion}}" placeholder="">
		</div>
		<div class="col-md-3 mb-2">
			<label for="numero_exterior">Número Exterior</label>
			<input class="form-control" id="numero_exterior" type="text" name="numero_exterior" value="{{$datosusuario[0]->numero_exterior}}" placeholder="Numero Exterior">
		</div>
		
			<div class="col-md-3 mb-2">
				<label for="numero_interior">Número Interior</label>
				<input class="form-control" id="numero_interior" type="text" name="numero_interior" value="{{$datosusuario[0]->numero_interior}}" placeholder="Numero Interior">
			</div>
			<div class="col-md-3 mb-2">
				<label for="colonia">Colonia</label>
				<input class="form-control" id="colonia" type="text" name="colonia" value="{{$datosusuario[0]->colonia}}" placeholder="Colonia">
			</div>
			<div class="col-md-3 mb-2">
				<label for="codigo_postal">Código Postal</label>
				<input class="form-control" id="codigo_postal" type="text" name="codigo_postal" value="{{$datosusuario[0]->codigo_postal}}" placeholder="Codigo Postal">
			</div>
			<div class="col-md-3 mb-2">
				<label for="localidad">Localidad</label>
				<input class="form-control" id="localidad" type="text" name="localidad" value="{{$datosusuario[0]->localidad}}" placeholder="Localidad">
			</div>
		<div class="col-md-3 mb-2">
			<label for="municipio">Municipio</label>
			<input class="form-control" id="municipio" type="text" name="municipio" value="{{$datosusuario[0]->municipio}}" placeholder="Municipio">
		</div>
		<div class="col-md-3 mb-2">
			<label for="estado">Estado</label>
			<input class="form-control" id="estado" type="text" name="estado" value="{{$datosusuario[0]->estado}}" placeholder="Estado">
		</div>
		<div class="col-md-3 mb-2">
			<label for="latitud">Latitud</label>
			<input style="border: solid 2px red" class="form-control" id="latitud" type="text" name="latitud" value="{{$datosusuario[0]->latitud}}" placeholder="Latitud">
		</div>
		<div class="col-md-3 mb-2">
			<label for="longitud">Longitud</label>
			<input style="border: solid 2px red" class="form-control" id="longitud" type="text" name="longitud" value="{{ $datosusuario[0]->longitud}}" placeholder="Longitud">
		</div>
	</div>
	<br>
	<div class="form-row">
		<button class="btn btn-primary" type="submit">Actualizar</button>
		{{-- <a class="btn btn-danger" type="submit" href="{{ route('datosusuario.index') }}">Cancelar</a> --}}
	</div>
	<br><br>
</form>
@stop
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('datosusuario.index') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop