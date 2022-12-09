@extends('layouts.master')
@section('title', 'Listado tipos usuario')
@section('parentPageTitle', 'usuario')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')
  <div class="col-md-12">
    @if ( session('status') )
        <div class="col-md-12">
            <center>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
            </center>
        </div>
    @endif
    {{-- <a class="btn btn-success" type="submit" href="{{ route('tipousuarios.create') }}" title="Nuevo tipo de usuario"><i class="fas fa-plus-circle"> Nuevo tipo de usuario</i></a> --}}
  </div>
  <div class="body">
    <div class="estilo-tabla">
      <table class="js-basic-example">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nombre</th>
            <th>Operación</th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($tipousuario))
          @foreach ($tipousuario as $datos)
          <tr>
            <td>{{$datos->id_tipo_usuario}}</td>
            <td>{{$datos->nombre}}</td>
            <td>
              <button class="btn btn-warning btn-sm" onclick="addTipo_usuario('{{$datos->id_tipo_usuario}}')">Editar</button>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
@stop
@section('page-script')

<div class="modal fade" id="modalTipousuario" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="title" style="color: #000" id="largeModalLabel">Editando nombre de tipo de usuario</h4>
      </div>
      <div class="modal-body"> 
      <div class="row clearfix">
          <div class="col-sm-12" id="cuadro">
          <form  action="{{url('actualizar-nombre-tipousuario')}}" method="POST">
            @csrf
            <input type="hidden" value="" id="id" name="id_tipo_usuario">
            <div class="form-group">
              <label for="IdZona">Agrega nuevo nombre tipo de usuario</label>
              <input type="text" name="nombre" class="form-control">
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

<script>
$(document).ready(function () {
		$('select').selectize({
			sortField: 'text'
		});
	});


    function addTipo_usuario(id){

    document.getElementById("id").value=id;
    $("#modalTipousuario").modal();
    }




	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('home') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<!-- <script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script> -->
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop