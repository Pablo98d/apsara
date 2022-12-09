@extends('layouts.master')
@section('title', 'Listado de grupos promotoras')
@section('parentPageTitle', 'grupos')
@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')
<div class="row">
  <div class="col-md-12">
    @if ( session('status') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
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
    <a class="btn btn-success" type="submit" href="{{ route('grupospromotoras.create') }}" title="Nueva promotora"><i class="fas fa-plus-circle"> </i> Nueva promotora</a>
  </div>
</div>
  <div class="body">
      <div class="estilo-tabla">
          <table class="js-basic-example">
                <thead>
          <tr>
            <th>#</th>
            <th>Grupo</th>
            <th>Promotor</th>
            <th>Clientes</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($grupospromotoras))
          @foreach ($grupospromotoras as $grupoprom)
          <tr>
            <td>
              
              {{$grupoprom->id_grupo_promotoras}}</td>
            <td>
              {{$grupoprom->grupo}}</td>
            <td>{{$grupoprom->nombre}} {{$grupoprom->ap_paterno}} {{$grupoprom->ap_materno}} </td>
            <td>
              @php

              $clientes = DB::table('tbl_prestamos')
              ->select(DB::raw('count(*) as total_clientes'))
              ->where('id_promotora', '=', $grupoprom->id_usuario)
              ->where('id_grupo','=',$grupoprom->id_grupo)
              ->whereIn('id_status_prestamo',[2,9])
              ->get();

              $total = DB::table('tbl_prestamos')
              ->select(DB::raw('count(*) as total'))
              ->where('id_promotora', '=', $grupoprom->id_usuario)
              ->where('id_grupo','=',$grupoprom->id_grupo)
              ->get();
              @endphp  
              <center>
                <span style="color: green; margin-left: 10px" title="Clientes activos">  {{$clientes[0]->total_clientes}}</span>
                / 
                <span title="Total clientes">{{$total[0]->total}}</span>
              </center>
            </td>
            <td class="d-flex">
              <a class="btn btn-warning btn-sm" type="submit" href="{{ url('grupos/admin/grupospromotoras/'.$grupoprom->id_grupo_promotoras.'/edit') }}" title="Editar datos de grupo promotora"><i class="fas fa-pen"></i></a>
               | 
               @php
               $registrado_a_ruta = DB::table('tbl_rutas_zonas')
                ->select('tbl_rutas_zonas.*')
                ->where('tbl_rutas_zonas.id_grupo_promotora','=',$grupoprom->id_grupo_promotoras)
                ->get();
               @endphp
               @if(count($registrado_a_ruta)==0)
                  <form action="{{ url('grupos/admin/grupospromotoras/' .$grupoprom->id_grupo_promotoras) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                      <input type="hidden" name="id_promotora" value="{{$grupoprom->id_usuario}}">
                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')"><i class="fas fa-trash"></i></button>
                  </form>
                @else
                     <button class="btn btn-dark btn-sm" onclick="return alert('La promotora tiene asignado visitas de zona, debe eliminar primero la visita en Rutas->Visitas de zonas')"><i class="fas fa-trash"></i></button>
                @endif
                {{-- <a href="#" onclick="addgerente('{{$zona->IdZona}}')" class="btn btn-success btn-sm" title="Agregar un nuevo gerente de zona"><i class="fas fa-user-plus"></i></a> --}}
                <button class="btn btn-primary btn-sm" onclick="changePromotora('{{$grupoprom->id_usuario}}','{{$grupoprom->nombre}} {{$grupoprom->ap_paterno}} {{$grupoprom->ap_materno}}','{{$grupoprom->id_grupo}}')" title="Cambiar de promotora a los préstamos activos">
                  <i class="fas fa-exchange-alt"></i>
              </button>
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
    <div class="modal fade" id="modalPromotora" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="title" id="largeModalLabel">Cambiando promotora de préstamos activos</h5>
					</div>
					<div class="modal-body"> 
					<div class="row clearfix">
							<div class="col-sm-12" id="cuadro">
							<form  action="{{route('actualizar_promotora_de_prestamos')}}" method="POST">
								{{ csrf_field() }}
								<input type="hidden" value="" id="id" name="id_promotora_actual">
								<input type="hidden" value="" id="id_grupo" name="id_grupo">
								<small for="">Promotora actual</small><br>
								<input type="text" class="form-control" id="nombre" value="" disabled>
								<small>Nueva promotora para los préstamos activos</small><br>
						
                <select id="nueva_promotora_grupo" name="nueva_promotora" class="form-control show-tick ms select2" data-placeholder="Select" onchange="verificar_promotora()">
                  <option value="">--Seleccione--</option>
                
                </select>
                <small style="color: green" id="hecho"></small>
                <small style="color: red" id="error"></small>
								
						</div>
					</div>
				</div>
					<div class="modal-footer">
						<button type="submit" id="button" onclick="return confirm('¿Esta seguro de continuar?')" class="btn btn-default btn-round waves-effect" >Guardar cambios</button>
						<button type="button"  class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
							</form>
					</div>
				</div>
			</div>
		</div>
@stop
@section('page-script')

<script>
  function verificar_promotora(){
      let promotora_seleccionada = document.getElementById("nueva_promotora_grupo").value; 
      let id_promotora_actual = document.getElementById("id").value; 
      let button = document.querySelector("#button");
      let hecho = document.querySelector("#hecho");
      let error = document.querySelector("#error");
      if (promotora_seleccionada===id_promotora_actual) {
          button.disabled = true; 
          error.innerHTML='Error, la promotora no puede ser la misma';
          hecho.innerHTML='';

      } else if(promotora_seleccionada==='') {
          isabled = true; 
          error.innerHTML='Error, debe seleccionar una promotora';
          hecho.innerHTML='';
      }else{
          button.disabled = false;
          error.innerHTML='';
          hecho.innerHTML='!Hecho¡, puede continuar';
      }

  }
</script>
<script>
  

  $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });


function changePromotora(id,nombre,id_grupo){

document.getElementById("id").value=id;
document.getElementById("nombre").value=nombre;
document.getElementById('id_grupo').value = id_grupo;
$("#modalPromotora").modal();

    // console.log(id_grupo);
    if(id_grupo!=''){
      // document.getElementById('id_promotora').disabled=false;
    }

    $.ajax({
        data: {
          "_token": "{{ csrf_token() }}",
          "id_grupo": id_grupo
        }, //datos que se envian a traves de ajax
        url: "{{ url('buscando_promotora') }}", //archivo que recibe la peticion
        type: 'post', //método de envio
        dataType: "json",
        success: function(resp) { //una vez que el archivo recibe el request lo procesa y lo devuelve

        // console.log(resp);
        $('#nueva_promotora_grupo').empty();
            trHTML = '';
                          trHTML = '<option value="">--Seleccione una promotora--</option>';
                          $.each(resp, function (i, userData) {
                                  
                                  var promotora=resp[i].nombre;
                              
                                  promotora=promotora.replace(/\s/g, ',')
                                
                                  trHTML +=
                                      '<option value="'
                                      + resp[i].id_usuario 
                                      +'">'
                                      + resp[i].nombre 
                                      + resp[i].ap_paterno 
                                      + resp[i].ap_materno 
                                      + '</option>';
                              
                          });
                      
                          $('#nueva_promotora_grupo').append(trHTML);


        },
        error: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve

        // alert("Ha ocurrido un error, intente de nuevo.");
          // console.log(response);
        }
    });

}






</script>

<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('home') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
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