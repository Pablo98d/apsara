@extends('layouts.master')
@section('title', 'Listado gerentes de zona')
@section('parentPageTitle', 'zonas')
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <div class="body">
        <div class="row">
            <div class="col-md-12">
                @if ( session('status') )
                <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                </div>
                @endif
            </div>
            <div class="col-md-12">
                <div class="estilo-tabla">
                    <table class="js-basic-example">
                        <thead>
                            <tr>
                                <th>
                                    No.
                                </th>
                                <th>
                                    Nombre usuario gerente
                                </th>
                                <th>Zona</th>
                                <th>Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allgerentes as $gerente)
                                <tr>
                                    <td>
                                        {{$gerente->id}}
                                    </td>
                                    <td>
                                        {{$gerente->nombre_usuario}}
                                    </td>
                                    <td>
                                    <a href="{{route('admin-zona.show',$gerente->IdZona)}}">{{$gerente->Zona}}</a>
                                    </td>
                                    <td class="d-flex">
                                        <a href="#" onclick="updatezona('{{$gerente->id_zona_gerente}}')" class="btn btn-warning btn-sm" title="Cambiar la zona del gerente"><i class="fas fa-map"></i> <i class="fas fa-undo-alt"></i></a>
                                        <a href="#" onclick="updategerente('{{$gerente->id_zona_gerente}}')" class="btn btn-warning btn-sm" title="Cambiar gerente de la zona"><i class="fas fa-user"></i><i class="fas fa-undo-alt"></i></a>
                                        <form action="{{ url('deletezona/'.$gerente->id_zona_gerente) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')" title="Eliminar gerente"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modaleditarzona" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="title" id="largeModalLabel">Actualizando zona</h4>
				</div>
				<div class="modal-body"> 
				<div class="row clearfix">
						<div class="col-sm-12" id="cuadro">
						<form  action="updatezona" method="POST">
							{{ csrf_field() }}
							<input type="hidden" value="" id="id" name="id_zona_gerente">
							<div class="form-group">
								<label for="IdZona">Seleccione la nueva zona para el gerente</label>
								<select  name="id_zona" id="" class="col-sm-12 form-control" >
                                    <option value="">----seleccione un zona----</option>
                                    @foreach ($zonas as $zona)
                                        <option value="{{$zona->IdZona}}">{{$zona->Zona}}</option>
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
    </div>
    <div class="modal fade" id="modaleditargerente" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="title" id="largeModalLabel">Actualizando gerente</h4>
				</div>
				<div class="modal-body"> 
				<div class="row clearfix">
						<div class="col-sm-12" id="cuadro">
						<form  action="updatezona" method="POST">
							{{ csrf_field() }}
							<input type="hidden" value="" id="idg" name="id_zona_gerente">
							<div class="form-group">
								<label for="IdZona">Seleccione el nuevo gerente para la zona</label>
								<select  name="id_usuario" id="" class="col-sm-12 form-control" >
                                    <option value="">----seleccione un gerente----</option>
                                    @foreach ($gerenteszona as $gerente)
                                        <option value="{{$gerente->id}}">{{$gerente->nombre_usuario}}</option>
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
    </div>
@endsection
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('home') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>

<script>
  	$(document).ready(function () {
		$('select').selectize({
			sortField: 'text'
		});
	});


function updatezona(id){

document.getElementById("id").value=id;
$("#modaleditarzona").modal();
}

</script>
<script>
    $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });


function updategerente(idg){

document.getElementById("idg").value=idg;
$("#modaleditargerente").modal();
}

</script>

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>


@stop