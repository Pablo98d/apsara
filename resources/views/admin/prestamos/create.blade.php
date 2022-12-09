@extends('layouts.master')
@section('title', 'Registro préstamos')
@section('parentPageTitle', 'préstamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>

  <link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/multi-select/css/multi-select.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-spinner/css/bootstrap-spinner.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/nouislider/nouislider.min.css')}}"/>

  <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<style>
.input-group-text {
	padding: 0 .75rem;
}
</style>

@stop
@section('content')
 @if ( session('error') )
      <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
        <center>
            {{ session('error') }}
        </center>
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
    @endif
<form method="POST" action="{{ route('prestamos.store') }}">
  @csrf
  <div class="form-row mb-2">
    <div class="col-md-4">
      <label for="id_prestamo">Grupos</label>
      <select name="id_grupo" class="form-control show-tick ms select2" id="id_grupo" required data-placeholder="Select" onchange="buscar_promotora()">
          <option value="">--Seleccione un grupo--</option>
        @foreach ($grupos as $grupo)
          <option value="{{$grupo->id_grupo}}">{{$grupo->grupo}}</option>
        @endforeach
      </select>
      {{--<input class="form-control" id="id_grupo" type="text" name="id_grupo" placeholder="Grupo">--}}
    </div>
    <div class="col-md-4">
      <label for="id_usuario">Clientes</label>
      <select name="id_usuario" class="form-control show-tick ms select2" id="id_usuario" data-placeholder="Select" required>
          <option value="">--Seleccione un cliente--</option>
          @foreach ($clientes as $cliente)
            <option value="{{$cliente->id}}">{{$cliente->nombre}} {{$cliente->ap_paterno}} {{$cliente->ap_materno}} {{$cliente->n_tipo}}</option>
          @endforeach
      </select>
     {{--<input class="form-control" type="text" name="id_usuario" id="id_usuario" placeholder="Usuario">--}}
    </div>
    <div class="col-md-4">
      <label for="fecha_solicitud">Fecha Solicitud</label>
      <div class="input-group masked-input mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
        </div>
        <input type="text" name="fecha_solicitud" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59">
      </div>
      {{--<input class="form-control" type="date" name="fecha_solicitud" placeholder="Fecha Solicitud" id="fecha_solicitud" required>--}}
    </div>
  </div>
  <div class="form-row mb-2">
    <div class="col-md-3">
      <label for="id_status_prestamo">Status Prestamo</label>
      <select name="id_status_prestamo" class="form-control show-tick ms select2" id="id_status_prestamo" data-placeholder="Select" required>
          <option value="">--Seleccione un promotor--</option>
          @foreach ($statusp as $status)
            <option value="{{$status->id_status_prestamo}}">{{$status->status_prestamo}}</option>
          @endforeach
      </select>
      {{--<input class="form-control" id="id_status_prestamo" type="text" name="id_status_prestamo" placeholder="Status Prestamo">--}}
    </div>
    <div class="col-md-6">
      <label for="id_promotora">Promotora <small style="color: red; font-size: 10px; position: absolute; top: 17px; left: 5px;">Nota: Debe seleccionar primero el grupo y despues la promotora</small></label>
      <select name="id_promotora" class="form-control show-tick ms select2" id="id_promotora" data-placeholder="Select" required>
          <option value="">--Seleccione un promotor--</option>
          
      </select>
      {{--<input class="form-control" id="id_promotora" type="text" name="id_promotora" placeholder="Promotora">--}}
    </div>
    <div class="col-md-3">
      <label for="id_producto">Producto</label>
      <select name="id_producto" class="form-control show-tick ms select2" id="id_producto" data-placeholder="Select" required>
          <option value="">--Seleccione un producto--</option>
          @foreach ($productos as $producto)
            <option value="{{$producto->id_producto}}">{{$producto->producto}}</option>
          @endforeach
      </select>
      {{--<input class="form-control" id="id_producto" type="text" name="id_producto" placeholder="Producto">--}}
    </div>
  </div>
  <div class="form-row mb-2">
    <div class="col-md-4">
      <label for="id_autorizo">Autoriza</label>
      <select name="id_autorizo" class="form-control show-tick ms select2" id="id_autorizo" data-placeholder="Select" required >
          <option value="">--Seleccione quien autoriza--</option>
          @foreach ($administradores as $administrador)
            <option value="{{$administrador->id}}">{{$administrador->nombre_usuario}}</option>
          @endforeach
      </select>
      {{--<input class="form-control" id="id_autorizo" type="text" name="id_autorizo" placeholder="">--}}
    </div>
    <div class="col-md-4">
      <label for="fecha_aprovacion">Fecha Aprobación</label>
      {{--<input class="form-control" id="fecha_aprovacion" type="date" name="fecha_aprovacion" placeholder="Numero Exterior" required>--}}
      <div class="input-group masked-input mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
        </div>
          <input type="text" name="fecha_aprovacion" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59">
      </div>
    </div>
    <div class="col-md-4">
      <label for="fecha_entrega_recurso">Fecha Entrega Recurso</label>
      <div class="input-group masked-input mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
        </div>
        <input type="text" name="fecha_entrega_recurso" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59">
      </div>
      {{--<input class="form-control datepicker" id="fecha_entrega_recurso" type="date" name="fecha_entrega_recurso" placeholder="" required>--}}
    </div>
  </div>
  <div class="form-row mb-2">
    <div class="col-md-4">
      <label for="cantidad">Cantidad</label>
      <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="$2000.00" required>
    </div>
  </div>
  <div class="form-row">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-danger" type="submit" href="{{ route('prestamos.index') }}">Cancelar</a>
  </div>
</form>

@stop
@section('page-script')
<script>
    

  window.onload = function agregar_boton_atras(){

    document.getElementById('Atras').innerHTML='<a href="{{route('prestamos.index')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
}
</script>
<script>
  function buscar_promotora(){
    var id_grupo = $("#id_grupo").val();
    // console.log(id_grupo);
    if(id_grupo!=''){
      document.getElementById('id_promotora').disabled=false;
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
        $('#id_promotora').empty();
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
                      
                          $('#id_promotora').append(trHTML);


        },
        error: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve

        // alert("Ha ocurrido un error, intente de nuevo.");
          // console.log(response);
        }
      });

}
</script>
  <script src="{{asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
  <script src="{{asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
  <script src="{{asset('assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
  <script src="{{asset('assets/plugins/jquery-spinner/js/jquery.spinner.js')}}"></script>
  <script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
  <script src="{{asset('assets/plugins/nouislider/nouislider.js')}}"></script>
  <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
  <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>



<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>

@stop