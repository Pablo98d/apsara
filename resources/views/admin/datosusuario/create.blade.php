@extends('layouts.master')
@section('title','Registro de nuevo usuario')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<style>
.input-group-text {
	padding: 0 .75rem;
}
</style>
<style>
	hr  {
		height: 4px !important; 
		margin-top: 20px !important;
		text-align: center !important;
		
		
	} 

	.hr1 {
		height: 1px;
		/* background: #fff; */
		border-top:solid 1px #fff;
	}
	.hr2 {
		height: 1px;
		/* background: #fff; */
		border-top:solid 1px #fff;
	}
	.hr1:after {
		content:"Datos del usuario" !important; 
		position: relative !important; 
		top: -12px !important; 
		display: inline-block !important; 
		background: #0c1729;
		width: 200px !important;
		}
	.hr2:after {
		content:"Datos del domicilio" !important; 
		position: relative !important; 
		top: -12px !important; 
		display: inline-block !important; 
		background: #0c1729;
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
<form method="POST" action="{{ route('users.store') }}" style="font-weight:600;">
	@csrf
	
	<hr class="hr1 mt-3">
	<div class="form-row">
        <div class="form-group col-md-3">
          <label for="nombre_usuario">Nombre</label>
          <input name="nombre_usuario" type="text" class="form-control" id="nombre_usuario" class="form-control @error('nombre_usuario') is-invalid @enderror" value="{{ old('nombre_usuario') }}" required autocomplete="nombre_usuario" autofocus>
          @error('nombre_usuario')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="nombre_usuario">Apellido paterno</label>
          <input name="ap_paterno" type="text" class="form-control" id="ap_paterno" class="form-control @error('ap_paterno') is-invalid @enderror" value="{{ old('ap_paterno') }}" required autocomplete="ap_paterno" autofocus>
          @error('ap_paterno')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="nombre_usuario">Apellido materno</label>
          <input name="ap_materno" type="text" class="form-control" id="ap_materno" class="form-control @error('ap_materno') is-invalid @enderror" value="{{ old('ap_materno') }}" required autocomplete="ap_materno" autofocus>
          @error('ap_materno')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
		<div class="form-group col-md-3">
			<label for="id_tipo_usuario">Tipo Usuario</label>
			<select class="form-control show-tick ms select2 @error('id_tipo_usuario') is-invalid @enderror" name="id_tipo_usuario" id="id_tipo_usuario" data-placeholder="Select">
			  <option value="">--Seleccione el tipo de usuario--</option>
			  @foreach ($tipoUsuario as $tipo)
				@if ($tipo->id_tipo_usuario==3)
					
				@elseif($tipo->id_tipo_usuario==7)
	
				@else
					<option value="{{ $tipo->id_tipo_usuario }}">{{ $tipo->nombre }}</option>
					
				@endif
  
			  @endforeach
			</select>
			@error('id_tipo_usuario')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror
		</div>
        <div class="form-group col-md-3">
          <label for="email">Correo Electrónico</label>
          <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="form-group col-md-3">
          <label for="password">Contraseña</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        
        
      </div>
	  <hr class="hr2 mt-4">
	<div class="form-row">
		<div class="col-md-3 mt-3">
			<label for="telefono_casa">Teléfono Casa</label>
			<input class="form-control"  maxlength="11" id="telefono_casa" type="text" name="telefono_casa" value="{{old('telefono_casa')}}" placeholder="Telefono Casa">
		</div>
		<div class="col-md-3 mt-3">
			<label for="telefono_celular">Teléfono Celular</label>
			<input class="form-control" maxlength="11"  id="telefono_celular" type="text" name="telefono_celular" value="{{old('telefono_celular')}}" placeholder="Telefono Celular">
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
	</div>
	<br>

	<div class="form-row">
		<div class="col-md-12">
			<button class="btn btn-primary" style="float: right;background: none; border:2px solid #007fb2;color: #fff;" type="submit">Registrar usuario</button>
		</div>
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

<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop