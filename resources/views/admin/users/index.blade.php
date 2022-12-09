@extends('layouts.master')
@section('title', 'Usuarios sin completar sus datos')
@section('parentPageTitle', 'usuario')
@section('page-style')
	<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
	<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
	<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>

	<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
	<style>
	.input-group-text {
		padding: 0 .75rem;
	}
	</style>


@stop
@section('content')
	<div class="header">
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
	<div class="body">
		<div class="col-md-12"><hr></div>
		<div class="row mb-3">
			<div class="col-md-8">
				{{-- <a class="btn btn-success" type="submit" href="{{ route('users.create') }}" title="Registrar un nuevo usuario, como administrador, promotor"><i class="fa fa-user-plus"> Usuario</i> </a>
				<a class="btn btn-success" type="submit" href="{{ url('admin/prospecto') }}" title="Registrar especificamente solo para prospectos"><i class="fa fa-user-plus"> Prospecto</i></a> --}}
				{{-- <a class="btn btn-success" type="submit" href="{{ route('users.create') }}"><i class="fa fa-user-plus"> Promotor</i></a> --}}

				{{-- <a href="{{ url('/Uexportar') }}">Exportar datos</a> --}}
			</div>
			{{-- <div class="col-md-4" style="text-align: right;">
				<form id="form_id_tipo" action="{{route('users.index')}}" method="get">
					<div class="form-group">
						<label for=""><b> Buscar por tipo de usuario: </b></label>
					<select onchange="buscar_tipo();" class="show-tick ms select2 form-control" name="id_tipo_usuario" data-placeholder="Select">
						<option value="">Seleccione tipo usuario</option>
						@foreach ($tipos_usuario as $tipos_user)
						<option value="{{$tipos_user->id_tipo_usuario}}"
											{{$id_tipo==$tipos_user->id_tipo_usuario ? 'selected' : 'Seleccione un tipo'}}
											>{{$tipos_user->nombre}}</option>
						@endforeach
						
					</select>
					</div>
				</form>
			</div> --}}
			{{-- <div class="col-md-12">
				<div class="alert alert-warning" role="alert">
					<center>
						Usuarios sin completar con sus datos <a href="#" onclick="modal_nodato()" style="padding: 5px; background: blue; color: #fff; border-radius: 20px;">{{count($usersss)}}</a>
					</center>
				</div>
			</div> --}}
		</div>
    	<div class="estilo-tabla ">

    		@if (!empty($usersss))
      		<table class="js-basic-example">
                <thead>
					<tr>
						<th><small>No.U</small></th>
						<th><small>Tipo U.</small></th>
						<th><small>Usuario</small></th>
						{{-- <th><small>Nombre completo</small></th> --}}
						<th><small>Correo Electrónico</small></th>
						<!-- <th hidden=""><small>Contraseña</small></th>
						<th hidden=""><small>Verificación correo</small></th>
						<th hidden=""><small>Creado</small></th>
						<th hidden=""><small>Actualizado</small></th> -->
						<th><small>Acciones</small></th>
					</tr>
				</thead>
				<tbody id="myList">
					@foreach ($usersss as $user)
					<tr>
						<td><small>{{$user->id}}</small></td>
						<td><small>{{$user->n_tipo}}</small></td>
						<td><small>{{$user->nombre_usuario}}</small></td>
						{{-- <td><small>{{$user->nombre}} {{$user->ap_paterno}} {{$user->ap_materno}}</small></td> --}}
						<td><small>{{$user->email}}</small></td>
						<!-- <td hidden=""><small>{{$user->password}}</small></td>
						<td hidden=""><small>{{$user->verificacion_correo}}</small></td>
						<td hidden=""><small>{{$user->created_at}}</small></td>
						<td hidden=""><small>{{$user->updated_at}}</small></td> -->
						<td class="d-flex">
							<!-- <a class="btn btn-info" href="{{ route('users.create') }}"><i class="fa fa-user-plus"></i></a> -->
							<form action="{{ route('datosusuario.create')}}" method="get">
								{{ csrf_field() }}
								<input type="hidden" name="id_usuario" value="{{$user->id}}">
								<button class="btn btn-warning" type="submit" onclick="return confirm('¿Seguro de continuar?')">Completar</button>
							</form>
							<a class="btn btn-warning btn-sm" href="{{ url('admin/users/'.$user->id.'/edit ') }}" title="Editar datos del usuario"><i class="fa fa-user-edit"></i></a>
		                     	| 
							
							@php
								$datos = DB::table('tbl_datos_usuario')
								->select('tbl_datos_usuario.*')
								->where('tbl_datos_usuario.id_usuario','=',$user->id)
								->get();
								
								$prestamo = DB::table('tbl_prestamos')
								->select('tbl_prestamos.*')
								->where('tbl_prestamos.id_usuario','=',$user->id)
								->get();
								$socio = DB::table('tbl_socio_economico')
								->select('tbl_socio_economico.*')
								->where('tbl_socio_economico.id_usuario','=',$user->id)
								->get();
							@endphp	 
							@if (count($prestamo)==0)
								@if(count($socio)==0)
										@if(count($datos)==0)
											<form action="{{ action('AdminUsersController@destroy', $user->id) }}" method="post">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
											<button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')"><i class="fa fa-user-times" title="Eliminar usuario"></i></button>
											</form>
										@else
											<button class="btn btn-secondary btn-sm" type="button" onclick="return alert('¡El usuario tiene datos, no podrá eliminarlo')" title="Eliminar usuario"><i class="fa fa-user-times" ></i></button>
										@endif
								@else
									<button class="btn btn-secondary btn-sm" type="button" onclick="return alert('¡El usuario tiene socioeconómico, no puede eliminarlo')" title="Eliminar usuario"><i class="fa fa-user-times" ></i></button>
								@endif
							@else
								<button class="btn btn-secondary btn-sm" type="button" onclick="return alert('¡El usuario tiene préstamos, no puede eliminarlo')" title="Eliminar usuario"><i class="fa fa-user-times" ></i></button>
							@endif

							
						</td>
					</tr>
					@endforeach
					
				</tbody>
			</table>
			{{-- {{ $users->links() }} --}}
			@else
			<p>No hay registro en la base de datos</p>
            @endif
    	</div>
	</div>
@stop
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('home') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>
<script>
  function buscar_tipo()
  {
      document.getElementById("form_id_tipo").submit();
  }
  function modal_nodato(){
  $("#modal_nodatos").modal();
  }

</script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>

<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop