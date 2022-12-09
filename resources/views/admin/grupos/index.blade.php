@extends('layouts.master')
@section('title', 'Listado de grupos')
@section('parentPageTitle', 'Grupos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>

@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<hr style="padding: 0; margin:0; margin-bottom:4px;">
	</div>
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
		
		@php
			$grups=DB::table('tbl_grupos')->select(DB::raw('count(*) as zona'))
			->where('IdZona', '=',null)
			->get();
		@endphp
		<a class="btn btn-success btn-sm" type="submit" href="{{ route('grupos.create') }}" title="Nuevo Registro"><i class="fas fa-plus-circle"></i> Nuevo grupo</a>
		{{-- <a class="btn btn-success btn-sm" type="submit" href="{{url('grupos/gerentes/excluir')}}" title="Excluir grupos"><i class="fas fa-plus-circle"></i> Excluir grupos</a>
		<a class="btn btn-success btn-sm" type="submit" href="{{route('grupospromotoras.index')}}" title="Grupos promotoras"><i class="fas fa-plus-circle"></i> Grupos Promotoras</a> --}}

		{{-- <li class="{{ Request::segment(2) === 'excluir' ? 'active' : null }}"><a href="{{url('grupos/gerentes/excluir')}}">Excluir grupos</a></li>
                            <li class="{{ Request::segment(2) === 'admin' ? 'active' : null }}"><a href="{{route('grupospromotoras.index')}}">Grupos Promotoras</a></li> --}}
		@if ($grups[0]->zona==0)
			
		@else
			<a class="btn btn-warning btn-sm" type="submit" href="{{ url('gsinzona') }}" title="Nuevo Registro">Grupos sin zona 
			
			
				<small 
				
				style="border-radius:25px; 
					background: blue; 
					font-size: 9px;
					padding:4px;
				">{{$grups[0]->zona}}</small></a>
			
		@endif
		 
		{{-- <a class="btn btn-warning btn-sm" type="submit" href="{{ route('imppdf') }}" title="Nuevo Registro" target="_blank">Imprimir prueba pdf</a> --}}
    </div>
</div>
	<div class="body">
    	<div class="estilo-tabla">
      		<table class="js-basic-example">
                <thead>
					<tr>
						<th>#</th>
						<th>Grupo</th>
						<th>Zona</th>
						<th>Localidad</th>
						<th>Municipio</th>
						<th>Estado</th>
						<th>Promotoras</th>
						<th>Clientes</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					@if (!empty($grupos)) 
						@foreach ($grupos as $grupo)
					<tr>
						<td>{{$grupo->id_grupo}}</td>
						<td>{{$grupo->grupo}}</td>
						<td>
							@if ($grupo->IdZona=='')
								<small>
									<b style="color:red;">No tiene sona</b>
								</small>
							@else
							<a  href="{{route('admin-zona.edit',$grupo->IdZona)}}">{{$grupo->Zona}}</a> 
							@endif
							
						</td>
						<td>{{$grupo->localidad}}</td>
						<td>{{$grupo->municipio}}</td>
						<td>{{$grupo->estado}}</td>
						<td>
							@php
								$clientes=DB::table('tbl_prestamos')->select(DB::raw('count(*) as totalclientes'))
								->where('id_grupo', '=',$grupo->id_grupo)
								->get();

								$promotoras=DB::table('tbl_grupos_promotoras')
								->select(DB::raw('count(*) as totalpromotora'))
								->where('tbl_grupos_promotoras.id_grupo','=',$grupo->id_grupo)
								->get();

								$region=DB::table('tbl_zona')
								->select('tbl_zona.IdPlaza')
								->where('tbl_zona.IdZona','=',$grupo->IdZona)
								->get();
							@endphp
							<center>
								@if($promotoras[0]->totalpromotora==0)
									<small>Sin promotoras</small>	
								@else
									@if (count($region)==0)
										Sin región | {{$clientes[0]->totalclientes}}
									@else
										<a href="{{url('grupos/admin/grupospromotoras')}}" title="Clic para ir a la vista de clientes" title="Clic para ir a la vista de grupos promotoras">
											{{$promotoras[0]->totalpromotora }} ver
										</a>
									@endif
								@endif
							</center>
						</td>
						<td>
							<center>
								@if($clientes[0]->totalclientes==0)
									<small>Sin clientes</small>	
								@else
									@if (count($region)==0)
										Sin región | {{$clientes[0]->totalclientes}}
									@else
										<a href="{{url('prestamo/buscar-cliente/'.$grupo->IdZona.'/'.$region[0]->IdPlaza.'/'.$grupo->id_grupo)}}" title="Clic para ir a la vista de clientes">
											{{$clientes[0]->totalclientes}} ver
										</a>
									@endif
								@endif

							</center>
						</td>
						<td class="d-flex">
							<a class="btn btn-warning btn-sm" href="{{ url('grupos/grupo/admin/grupos/'.$grupo->id_grupo.'/edit') }}" title=""><i class="fas fa-pen"></i></a>
		                   
							 	@if($clientes[0]->totalclientes==0)
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarGrupoModel" title="Eliminar fecha de corte semana" data-id="{{$grupo->id_grupo}}"><i class="fas fa-trash"></i></button>
								@elseif($clientes[0]->totalclientes>=1)
									@if ($promotoras[0]->totalpromotora>=1)
										<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#aviso2GrupoModel" title="El grupo tiene promotoras" data-id="{{$grupo->id_grupo}}"><i class="fas fa-trash"></i></button>
									@else
										<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#avisoGrupoModel" title="El grupo tiene clientes" data-id="{{$grupo->id_grupo}}"><i class="fas fa-trash"></i></button>
										
									@endif
								@endif
								<a href="#" onclick="addsupervisora('{{$grupo->id_grupo}}')" class="btn btn-success btn-sm" title="Agregar nueva supervisora"><i class="fas fa-user-plus"></i></a>
						</td>
					</tr>
					@endforeach
					@else
						<p>No hay registros</p>
					@endif
				</tbody>
            </table>
		</div>
		<div class="modal fade" id="modalSupervisora" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="title" style="color: #333333" id="largeModalLabel">Agregando nueva supervisora</h4>
					</div>
					<div class="modal-body"> 
					<div class="row clearfix">
							<div class="col-sm-12" id="cuadro">
							<form  action="agregar_gerente_z" method="POST">
								{{ csrf_field() }}
								<input type="hidden" value="" id="id" name="idGrupo">
								<div class="form-group">
									<label for="IdZona">Seleccione un gerente para esta zona</label>
									<select  name="id_usuario_g" id="" class="col-sm-12 form-control show-tick ms select2" data-placeholder="Select">
										<option value="">----seleccione supervisora----</option>
										@foreach ($supervisoras as $supervisor)
											<option value="{{$supervisor->id}}">{{$supervisor->nombre_usuario}}</option>
										@endforeach						
									</select>
								</div>
						</div>
					</div>
				</div>
					<div class="modal-footer">
						<button type="submit" onclick="return confirm('¿Esta seguro de continuar?')" class="btn btn-primary btn-round waves-effect" >Guardar cambios</button>
						<button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cerrar</button>
							</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="avisoGrupoModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
			  <div class="modal-content">
				<div class="modal-body " >
				  
				  <div class="col-md-12">
					<center>
					  <img src="{{asset('img/modal/info.png')}}" style="width: 50%" alt="">
		  
					</center>
					
					  <center>
						<b class="modal-title mt-2" id="exampleModalLabel"></b><br>
						<small>NOTA: para eliminarlo, es necesario que cambie de grupo los clientes</small>
					  </center>
					
					<center>
					  {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">¡ Ok !</button> --}}
					  <a id="enlaceCorte" href="#" class="btn btn-success" style="background: #870374;" data-dismiss="modal">¡ OK !</a>
					</center>
				  </div>
				 
				</div>
			  </div>
			</div>
		</div> 

		<div class="modal fade" id="aviso2GrupoModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
			  <div class="modal-content">
				<div class="modal-body " >
				  
				  <div class="col-md-12">
					<center>
					  <img src="{{asset('img/modal/info.png')}}" style="width: 50%" alt="">
		  
					</center>
					
					  <center>
						<b class="modal-title mt-2" id="exampleModalLabel"></b><br>
						<small>NOTA: para eliminarlo, es necesario que cambie de grupo las promotoras</small>
					  </center>
					
					<center>
					  {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">¡ Ok !</button> --}}
					  <a id="enlaceCorte" href="#" class="btn btn-success" style="background: #870374;" data-dismiss="modal">¡ OK !</a>
					</center>
				  </div>
				 
				</div>
			  </div>
			</div>
		</div> 

		  <div class="modal fade" id="eliminarGrupoModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
			  <div class="modal-content">
				<div class="modal-body " >
				  
				  <div class="col-md-12">
					<center>
					  <img src="{{asset('img/modal/question.png')}}" style="width: 50%" alt="">
		  
					</center>
					
					  <center>
						<b class="modal-title mt-2" id="exampleModalLabel"></b>
						
					  </center>
					<br>
					<center>
					  <form id="formEliminarGrupo" action="{{ url('grupos/grupo/admin/grupos/0') }}" data-action="{{ url('grupos/grupo/admin/grupos/0') }}" method="post">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger">Si eliminar</button>
					  </form>
					</center>
				  </div>
				 
				</div>
				{{-- <div class="modal-footer"> --}}
				{{-- </div> --}}
			  </div>
			</div>
		  </div>

		{{-- <div class="modal fade" id="modalgrupo" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h4 class="title" id="largeModalLabel">Agregando cliente</h4>
					</div>
					<div class="modal-body"> 
					
					<div class="row clearfix">
							<div class="col-sm-12" id="cuadro">
							<form  action="admin-grupo-agrega" method="POST">
								@csrf
								<input type="hidden" value="" id="id" name="id_grupo">
								<div class="form-group">
									<label for="IdZona">Seleccione el cliente que se agregará al grupo</label>
									<select  name="id" id="IdZona" class="col-sm-12 form-control" >
										<option value="">--seleccione una cliente--</option>
										@foreach ($tclientes as $tcliente) 
										<option value="{{$tcliente->id}}">{{$tcliente->nombre}} {{$tcliente->ap_paterno}} {{$tcliente->id}}</option>
										@endforeach
									</select>
								</div>
						</div>
					</div>
				</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-default btn-round waves-effect" >Guardar cambios</button>
						<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
							</form>
					</div>
				</div>
			</div>
		</div> --}}
    </div>
@stop
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('home') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }

  $(document).ready(function () {
		$('select').selectize({
			sortField: 'text'
		});
	});


    function addsupervisora(id){

    document.getElementById("id").value=id;
    $("#modalSupervisora").modal();
    }
  </script>
<script>
  $(document).ready(function () {
	$('select').selectize({
		sortField: 'text'
	});
});

$('#avisoGrupoModel').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget)
    var id = button.data('id')

    // action = $('#enlaceCorte').attr('data-href').slice(0,-1) 
    // action += id
    // console.log(action)

    // $('#enlaceCorte').attr('href',action)

    var modal = $(this)
    modal.find('.modal-title').text('Lo sentimos, el grupo #' + id +', tiene clientes')

  });

  $('#aviso2GrupoModel').on('show.bs.modal', function (event) {
    
    var button = $(event.relatedTarget)
    var id = button.data('id')

    // action = $('#enlaceCorte').attr('data-href').slice(0,-1) 
    // action += id
    // console.log(action)

    // $('#enlaceCorte').attr('href',action)

    var modal = $(this)
    modal.find('.modal-title').text('Lo sentimos, el grupo #' + id +', tiene promotoras')

  });

  

  $('#eliminarGrupoModel').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')

    action = $('#formEliminarGrupo').attr('data-action').slice(0,-1) 
    action += id
    // console.log(action)

    $('#formEliminarGrupo').attr('action',action)

    var modal = $(this)
    modal.find('.modal-title').text('¿Está seguro de eliminar el grupo #' + id +' ?')

   

  });


function actualizar(id){

	document.getElementById("id").value=id;
	$("#modalgrupo").modal();
}

</script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop