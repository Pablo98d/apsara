@extends('layouts.master')
@section('title', 'Nuevo grupo')
@section('parentPageTitle', 'grupos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>

@stop
@section('content')
    @if ( session('status') )
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <center>
            {{ session('status') }}
          </center>
          <button class="close" type="button" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
      </div>
    </div>
      
    @endif
    <form id="guardarGrupoForm" method="POST" action="{{ route('grupos.store') }}" enctype="multipart/form-data" >
      @csrf
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="grupo">Grupo</label>
          <input type="text" id="grupo" class="form-control" name="grupo" value="{{ old('grupo') }}" required>
        </div>
        <div class="form-group col-md-6">
          <label for="localidad">Zona</label>
         <select name="IdZona" class="form-control show-tick ms select2" data-placeholder="Select" required>
           <option value="">--Seleccione una zona--</option>
           @foreach ($zonas as $zona)
              <option value="{{$zona->IdZona}}">{{$zona->Zona}}</option>
           @endforeach
         </select>
        </div>
        <div class="form-group col-md-6">
          <label for="localidad">Localidad</label>
          <input id="localidad" type="text" class="form-control" name="localidad" value="{{ old('localidad') }}">
        </div>
      
        <div class="form-group col-md-6">
          <label for="municipio">Municipio</label>
          <input name="municipio" type="text" class="form-control" id="municipio" class="form-control" value="{{ old('municipio') }}">
        </div>
        <div class="form-group col-md-6">
          <label for="estado">Estado</label>
          <input id="estado" type="text" class="form-control" name="estado" value="{{ old('estado') }}">
        </div>
      </div>
      <div class="d-flex">
        {{-- <button type="submit" class="btn btn-primary">Aceptar</button> --}}
        {{-- <a type="submit" class="btn btn-dark" href="{{ route('grupos.index') }}"><i class="fas fa-chevron-left"></i> Regresar </a> --}}
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#guardarGrupoModel" title="Guardar grupo">Registrar grupo</button>
      </div>
    </form>


    <div class="modal fade" id="guardarGrupoModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm" role="document">
			  <div class="modal-content">
				<div class="modal-body " >
				  
				  <div class="col-md-12">
					<center>
					  <img src="{{asset('img/modal/question.png')}}" style="width: 50%" alt="">
		  
					</center>
					
					  <center>
						<b class="modal-title mt-2" id="exampleModalLabel">¿Esta seguro de continuar con la operación?</b><br>
						<br>
					  </center>
					
					<center>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					  <a id="enlaceCorte" href="#" class="btn btn-success" onclick="guardarGrupoForm()" style="background: #870374;" data-dismiss="modal" data-dismiss="modal">Si, continuar</a>
					</center>
				  </div>
				 
				</div>
			  </div>
			</div>
		</div> 
@stop
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('grupos.index') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
</script>
<script>
  $('#guardarEditarGrupoModel').on('show.bs.modal', function (event) {

  });
  function guardarGrupoForm(){
    document.getElementById("guardarGrupoForm").submit();
  }
</script>
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>


<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop