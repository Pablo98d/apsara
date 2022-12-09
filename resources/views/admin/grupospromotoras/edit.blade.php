@extends('layouts.master')
@section('title', 'Actualizando promotora del grupo')
@section('parentPageTitle', 'Grupos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
@stop
@section('content')
    <form method="POST" action="{{ url('grupos/admin/grupospromotoras/'.$grupospromotoras->id_grupo_promotoras) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="id_grupo">Grupo</label>
          {{-- <input type="id_grupo" id="id_grupo" class="form-control" name="id_grupo" value="{{ $grupospromotoras->id_grupo }}"> --}}
          <select name="id_grupo" id="id_grupo" class="form-control show-tick ms select2" data-placeholder="Select">
            @foreach ($gruposN as $grup)
              <option {{$grupospromotoras->id_grupo == $grup->id_grupo ? 'selected="selected"' : 'Selecciona un grupo'}} value="{{$grup->id_grupo}}">{{$grup->grupo}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="id_usuario">Usuario</label>
          {{-- <input type="id_usuario" id="id_usuario" class="form-control" name="id_usuario" value="{{ $grupospromotoras->id_usuario }}"> --}}
          <select name="id_usuario" id="id_usuario" class="form-control show-tick ms select2" data-placeholder="Select" onchange="buscar_promotora_s();">
            @foreach ($usuario as $us)
              <option {{$grupospromotoras->id_usuario == $us->id ? 'selected="selected"' : 'Selecciona un usuario'}} value="{{$us->id}}">{{$us->nombre_usuario}}</option>
            @endforeach
          </select>
          <center>
            <span style="font-size: 12px;" id="id_check"></span>
          </center>
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary" id="id_aceptar">Guardar cambios</button>
        {{-- <a type="submit" class="btn btn-danger" href="{{ route('grupospromotoras.index') }}">Cancelar</a> --}}
      </div>
    </form>
@stop
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('grupospromotoras.index') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>
<script>
  function buscar_promotora_s(){
    var id_grupo = $("#id_grupo").val();
    var id_usuario = $("#id_usuario").val();
    var id_aceptar = $("#id_aceptar").val();
    // console.log(id_grupo);
    if(id_grupo!=''){
      document.getElementById('id_usuario').disabled=false;
    }



    $.ajax({
        data: {
          "_token": "{{ csrf_token() }}",
          "id_grupo": id_grupo,
          "id_usuario": id_usuario
        }, //datos que se envian a traves de ajax
        url: "{{ url('buscando_grupos_promotoras') }}", //archivo que recibe la peticion
        type: 'post', //método de envio
        dataType: "json",
        success: function(resp) { //una vez que el archivo recibe el request lo procesa y lo devuelve

            if (resp.length === 0) {
              document.getElementById('id_check').style.display = 'none';
              document.getElementById('id_aceptar').disabled=false;

            } else {
              document.getElementById('id_aceptar').disabled=true;
              document.getElementById('id_check').style.display = 'block';
              document.getElementById('id_check').style.color = 'red';
              document.getElementById('id_check').innerHTML='La promotora ya está asignado en el grupo';
            }
                          

        },
        error: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve

        }
      });

}
</script>
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop