@extends('layouts.master')
@section('title', 'Grupos sin zona')
@section('parentPageTitle', 'grupos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

@stop
@section('content')
	<div class="header">
		@if ( session('status') )
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				{{ session('status') }}
				<button class="close" type="button" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
		@endif
		
    </div>
	<div class="body">
    	<div class="table-responsive">
      		<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
					<tr>
						<th>#</th>
						<th>Zona</th>
						<th>Grupos</th>
						<th>Localidad</th>
						<th>Municipio</th>
						<th>Estado</th>
						<th>Clientes</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					@if (!empty($grupos)) 
						@foreach ($grupos as $grupo)
					<tr>
						<td>{{$grupo->id_grupo}}</td>
						<td>
							@if ($grupo->IdZona=='')
								<small>
									<a  href="#" style="color:red;" onclick="addtocurse('{{$grupo->id_grupo}}')" title="Agregar a una zona">No tiene zona <span style="color:blue;">?</span></a>
								</small>
							@else
								<a  href="{{ url('admin-zona/'.$grupo->IdZona) }}">{{$grupo->Zona}}</a> 
							@endif
							
						</td>
						<td>{{$grupo->grupo}}</td>
						<td>{{$grupo->localidad}}</td>
						<td>{{$grupo->municipio}}</td>
						<td>{{$grupo->estado}}</td>
						<td>
							@php
								$clientes=DB::table('tbl_prestamos')->select(DB::raw('count(*) as totalclientes'))
										->where('id_grupo', '=',$grupo->id_grupo)
										->get();
							@endphp
							@if($clientes[0]->totalclientes==0)
								<small>No hay clientes</small>	
							@else
								{{$clientes[0]->totalclientes}}
							@endif
						</td>
						<td class="d-flex">
							<a class="btn btn-info btn-sm" href="{{ url('admin/grupos/'.$grupo->id_grupo.'/edit') }}" title="">Editar</a>
		                     | 
		                    <form action="{{ url('admin/grupos/' .$grupo->id_grupo) }}" method="post">
		                      {{ csrf_field() }}
		                      {{ method_field('DELETE') }}
		                      <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')">Eliminar</button>
		                    </form>
						</td>
					</tr>
					@endforeach
					@else
						<p>No hay registros</p>
					@endif
				</tbody>
              </table>
    	</div>
	</div>

	<div class="modal fade" id="modalcurso" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="title" id="largeModalLabel">Agregando a una zona</h4>
				</div>
				<div class="modal-body"> 
				<div class="row clearfix">
						<div class="col-sm-12" id="cuadro">
						<form  action="admin-zona-agrega" method="POST">
							{{ csrf_field() }}
							<input type="hidden" value="" id="id" name="id_grupo">
							<div class="form-group">
								<label for="IdZona">Seleccione a qué zona quiere agregar el grupo</label>
								<select  name="IdZona" id="IdZona" class="col-sm-12 form-control" >
									<option value="">----seleccione una zona----</option>
									<?php 
										foreach ($zonas as $zona) {
									?>
										<option value="<?php  echo $zona->IdZona?>"><?php  echo $zona->Zona?></option>
									<?php 
										}
									?>
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
	</div>
@stop
@section('page-script')
<script>
  	$(document).ready(function () {
		$('select').selectize({
			sortField: 'text'
		});
	});


function addtocurse(id){

document.getElementById("id").value=id;
$("#modalcurso").modal();
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