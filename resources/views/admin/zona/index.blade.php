@extends('layouts.master')
@section('title', 'Listado zonas')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<style>
.input-group-text {
	padding: 0 .75rem;
}
</style>
@stop
@section('content')

<div class="body">
    <hr style="padding: 0; margin:0; margin-bottom:4px;">
    <div> 
        @if ( session('Guardar') )
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				{{ session('Guardar') }}
				<button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" >x</span>
				</button>
			</div>
        @endif
        @if ( session('error') )
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				{{ session('error') }}
				<button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" >x</span>
				</button>
			</div>
		@endif
        <a class="btn btn-success btn-sm" href="{{route('admin-zona.create')}}" title="Agregar una nueva zona"><i class="fas fa-plus-circle"> Nueva zona</i></a>
    </div>
    <div class="table table-sm">
        @if (!empty($zonas))
        <div class="estilo-tabla">
            <table class="col-md-12">
              <thead>
                  <tr>
                      <th>Región</th>
                      <th>Zona</th>
                      <th>Grupos</th>
                      <th>Gerentes</th>
                      <th>Fecha de apertura</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
              <tbody>
                      @foreach ($zonas as $zona)
                  <tr>
                      <td>
                          {{$zona->Plaza}}
                          {{-- <a href="{{route('admin-region.show',$zona->IdPlaza)}}">{{$zona->Plaza}}</a> --}}
                      </td>
                      {{--<td>{{$zona->IdZona}}</td>--}}
                      <td>{{$zona->Zona}}</td>
                      <td>
                          @php
                              $total=DB::table('tbl_grupos')->select(DB::raw('count(*) as total'))
                                      ->where('IdZona', '=', $zona->IdZona)
                                      ->get();
                          @endphp
                              
                              @if ($total[0]->total == 0)
                                  <small>No hay grupos</small>
                              @else
                                  {{-- <a href="{{url('ver-grupos/'.$zona->IdZona)}}" class="btn btn-info btn-sm">  --}}
                                  <a href="#" class="btn btn-info btn-sm" style="width: 100px;"> 

                                    
                                      <span>
                                          {{$total[0]->total}}
                                      </span> 
                                      grupos
                                  </a>
                              @endif
                      </td>
                      <td>
                          @php
                              $totalger=DB::table('tbl_zonas_gerentes')->select(DB::raw('count(*) as totalger'))
                                      ->where('id_zona', '=', $zona->IdZona)
                                      ->get();
                          @endphp
                          @if ($totalger[0]->totalger == 0)
                              <small>No hay gerentes</small>
                          @else
                              <a href="{{url('show-gerentes-zona/'.$zona->IdZona)}}" class="btn btn-info btn-sm" style="width: 100px;"> 
                                  <span>
                                      {{$totalger[0]->totalger}}
                                  </span> 
                                  gerente(s)
                              </a>
                          @endif
  
                      </td>
                      <td>{{$zona->Fecha_apertura}}</td>
                      <td class="d-flex">
                          <a class="btn btn-warning btn-sm" href="{{route('admin-zona.edit',$zona->IdZona)}}" title="Editar zona"><i class="fas fa-pen"></i></a>
                      
                          <form action="{{ route('admin-zona.destroy',$zona->IdZona) }}" method="post">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}

                              @if ($total[0]->total == 0)
                                    @if ($totalger[0]->totalger == 0)
                                        <button class="btn btn-danger btn-sm " type="submit" onclick="return confirm('¿Desea eliminar el registro?')" title="Eliminar zona"><i class="fas fa-trash"></i></button>
                                        
                                    @else
                                        <button class="btn btn-secondary btn-sm " type="button" onclick=" alert('La zona tiene gerentes, es imposible de eliminar. NOTA: elimine o cambie de zona los gerentes')" title="Eliminar zona"><i class="fas fa-trash"></i></button>
                                        
                                    @endif
                                  
                              @else
                                    <button class="btn btn-secondary btn-sm " type="button" onclick=" alert('La zona tiene grupos, es imposible de eliminar. NOTA: elimine o cambie de zona los grupos')" title="Eliminar zona"><i class="fas fa-trash"></i></button>
                                  
                              @endif
                          </form>
                          <a href="#" onclick="addgerente('{{$zona->IdZona}}')" class="btn btn-success btn-sm" title="Agregar un nuevo gerente de zona"><i class="fas fa-user-plus"></i></a>
                      </td>
                  </tr>
                  @endforeach
                  
              </tbody>
            </table>
        </div>
          {{ $zonas->links() }}
        @else
        <p>No hay registros</p>
        @endif
    </div>
</div>
    <div class="modal fade" id="modalgerente" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="title" style="color: #333333" id="largeModalLabel">Agregando un nuevo gerente</h4>
				</div>
				<div class="modal-body"> 
				<div class="row clearfix">
						<div class="col-sm-12" id="cuadro">
						<form  action="agregar_gerente_z" method="POST">
							{{ csrf_field() }}
							<input type="hidden" value="" id="id" name="IdZona">
							<div class="form-group">
								<label for="IdZona">Seleccione un gerente para esta zona</label>
								<select  name="id_usuario_g" id="" class="col-sm-12 form-control show-tick ms select2" data-placeholder="Select">
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
					<button type="submit" onclick="return confirm('¿Esta seguro de continuar?')" class="btn btn-primary btn-round waves-effect" >Guardar cambios</button>
					<button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Cerrar</button>
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


    function addgerente(id){

    document.getElementById("id").value=id;
    $("#modalgerente").modal();
    }

</script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop