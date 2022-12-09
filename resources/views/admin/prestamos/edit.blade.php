@extends('layouts.master')
@section('title', 'Actualizando datos de préstamo')
@section('parentPageTitle', 'préstamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>


@stop
@section('content')
<div class="row">
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
  </div>
</div>
<div class="col-md-12">
  <form id="guardarCambiosPrestamoForm" method="POST" action="{{ url('prestamo/buscar-cliente/admin/prestamos/' .$prestamo->id_prestamo) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="form-row mb-2">
        <div class="col-md-4">
          <label for="id_grupo">Grupos</label>
          <select name="id_grupo" class="form-control show-tick ms select2" id="id_grupo" required data-placeholder="Select" onchange="buscar_promotora();">
              <option value="">--Seleccione un grupo--</option>
            @foreach ($grupos as $grupo)
              <option value="{{$grupo->id_grupo}}" 
              {{$prestamo->id_grupo==$grupo->id_grupo ? 'selected' : 'Seleccione un grupo'}}
              >{{$grupo->grupo}}</option>
            @endforeach
          </select>
          {{--<input class="form-control" id="id_grupo" type="text" name="id_grupo" placeholder="Grupo">--}}
        </div>
        <div class="col-md-5">
          <label for="id_usuario">Clientes</label>
          <input type="hidden" value="{{$prestamo->id_usuario}}" name="id_usuario">
          <select class="form-control show-tick ms select2" id="id_usuario" data-placeholder="Select" disabled>
              <option value="">--Seleccione un cliente--</option>
              @foreach ($clientes as $cliente)
                <option value="{{$cliente->id}}"
                  {{$prestamo->id_usuario==$cliente->id ? 'selected' : 'Seleccione un cliente'}}
                  >{{$cliente->nombre}} {{$cliente->ap_paterno}} {{$cliente->ap_materno}}</option>
              @endforeach
          </select>
         {{--<input class="form-control" type="text" name="id_usuario" id="id_usuario" placeholder="Usuario">--}}
        </div>
        <div class="col-md-3">
          <label for="fecha_solicitud">Fecha Solicitud</label>
          @php
              $datesolicitud = date_create($prestamo->fecha_solicitud);
          @endphp
          <div class="input-group masked-input mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
            </div>
            <input type="text" name="fecha_solicitud" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59" value="{{date_format($datesolicitud, 'd-m-Y H:i:s')}}">
          </div>
  
        {{--<input class="form-control datetime" type="text" name="fecha_solicitud" placeholder="Fecha Solicitud" id="fecha_solicitud" value="{{date_format($datesolicitud, 'd-m-Y H:i:s')}}" required>--}}
        </div>
      </div>
      <div class="form-row mb-2">
        <div class="col-md-3">
          <label for="id_status_prestamo">Status Prestamo</label>
          <select name="id_status_prestamo" class="form-control show-tick ms select2" id="id_status_prestamo" required data-placeholder="Select">
              <option value="">--Seleccione un promotor--</option>
              @if ($prestamo->id_status_prestamo==2)
              {{-- Activo --}}
                  <option value="2" selected>Activo</option>
                  <option value="6">Inactivo</option>
                  <option value="18">Irrecuperable</option>
                  <option value="3">Moroso</option>
                  <option value="8">Pagado</option>

              @elseif ($prestamo->id_status_prestamo==10)
              {{-- Aprobado --}}
                  <option value="10" selected>Aprobado</option>
                  <option value="6">Inactivo</option>

              @elseif ($prestamo->id_status_prestamo==4)
              {{-- Convenio --}}
                  <option value="4" selected>Convenio</option>
                  <option value="6">Inactivo</option>
                  <option value="8">Pagado</option>
                  
              @elseif ($prestamo->id_status_prestamo==16)
              {{-- Devolucion --}}
                  <option value="16" selected>Devolución</option>
                  <option value="1">Prospecto</option>
                  <option value="2">Activo</option>
              
              @elseif ($prestamo->id_status_prestamo==6)
              {{-- Inactivo --}}
                  <option value="6" selected>Inactivo</option>
                  <option value="2">Activo</option>
                  <option value="9">Renovación</option>
                  <option value="8">Pagado</option>
                 
              @elseif ($prestamo->id_status_prestamo==18)
              {{-- Irrecuperable --}}
                  <option value="18" selected>Irrecuperable</option>
                  <option value="2">Activo</option>
              @elseif ($prestamo->id_status_prestamo==3)
              {{-- Moroso --}}
                  <option value="3" selected>Moroso</option>
                  <option value="18">Irrecuperable</option>
                  <option value="8">Pagado</option>

              @elseif ($prestamo->id_status_prestamo==11)
              {{-- Negado --}}
                  <option value="11" selected>Negado</option>
                  <option value="10">Aprobado</option>
                  
              @elseif ($prestamo->id_status_prestamo==7)
              {{-- No localizado --}}
                  <option value="7" selected>No localizado</option>

              @elseif ($prestamo->id_status_prestamo==8)
              {{-- Pagado --}}
                  <option value="8" selected>Pagado</option>
                  <option value="2" >Activo</option>
                  
              @elseif ($prestamo->id_status_prestamo==15)
              {{-- Por entregar --}}
                  <option value="15" selected>Por entregar</option>
                  <option value="17">Rechazado por el cliente</option>
              
              @elseif ($prestamo->id_status_prestamo==20)
              {{-- Por liquidar --}}
                  <option value="20" selected>Por liquidar</option>

                  @php
                      $all_prestamos=DB::table('tbl_prestamos')
                      ->select('tbl_prestamos.*')
                      ->where('id_usuario','=',$prestamo->id_usuario)
                      ->where('id_status_prestamo','=',8)
                      ->get();
                  @endphp

                  @if (count($all_prestamos)==0)
                    <option value="2">Activo</option>  
                  @else
                    <option value="9">Renovación</option>
                  @endif

                  <option value="8">Pagado</option>

              @elseif ($prestamo->id_status_prestamo==1)
              {{-- Prospecto --}}
                  <option value="1" selected>Prospecto</option>
              
              @elseif ($prestamo->id_status_prestamo==17)
              {{-- Rechazado por el cliente --}}
                      <option value="17" selected>Rechazado por el cliente</option>
                      
              @elseif ($prestamo->id_status_prestamo==9)
              {{-- Renovación --}}
                  <option value="9" selected>Renovación</option>
                  <option value="6">Inactivo</option>
                  <option value="3">Moroso</option>
                  <option value="8">Pagado</option>

              @elseif ($prestamo->id_status_prestamo==19)
              {{-- Renovación anticipada --}}
                  <option value="19" selected>Renovación anticipada</option>

              @elseif ($prestamo->id_status_prestamo==5)
              {{-- Suspendido --}}
                  <option value="5" selected>Suspendido</option>
              
              @else
                @foreach ($statusp as $status)
                  <option value="{{$status->id_status_prestamo}}"
                    {{$prestamo->id_status_prestamo==$status->id_status_prestamo ? 'selected' : 'Seleccione el estatus del préstamo'}}
                    >{{$status->status_prestamo}}
                  </option>
                @endforeach
              @endif
          </select>
          {{--<input class="form-control" id="id_status_prestamo" type="text" name="id_status_prestamo" placeholder="Status Prestamo">--}}
        </div>
        <div class="col-md-6">
          <label for="id_promotora">Promotora <small id="mensaje" style="color: rgb(128, 128, 128); font-size: 10px; position: absolute; top: 16px; left: 5px;"><b>NOTA:</b> Si ha seleccionado un grupo diferente, debe seleccionar una nueva promotora</small></label>
          <select name="id_promotora" class="form-control show-tick ms select2" id="id_promotora"  data-placeholder="Select" required>
              <option value="">--Seleccione un promotor--</option>
              @foreach ($promotoras as $promotor)
                <option value="{{$promotor->id_usuario}}"
                  {{$prestamo->id_promotora==$promotor->id_usuario ? 'selected' : 'Seleccione un promotor'}}
                  >{{$promotor->nombre}} {{$promotor->ap_paterno}} {{$promotor->ap_materno}}</option>
              @endforeach
          </select>
          {{--<input class="form-control" id="id_promotora" type="text" name="id_promotora" placeholder="Promotora">--}}
        </div>
        
        <div class="col-md-3">
          <label for="id_producto">Producto</label>
          <select name="id_producto" class="form-control show-tick ms select2" onchange="validar_cantidad(this.value)" id="id_producto" required data-placeholder="Select" required>
              <option value="">--Seleccione un producto--</option>
              @foreach ($productos as $producto)
                <option value="{{$producto->id_producto}}"
                  {{$prestamo->id_producto==$producto->id_producto ? 'selected' : 'Seleccione un producto'}}
                  >{{$producto->producto}}</option>
              @endforeach
          </select>
          {{--<input class="form-control" id="id_producto" type="text" name="id_producto" placeholder="Producto">--}}
        </div>
      </div>
      <div class="form-row mb-2">
        <div class="col-md-4 ">
          <label for="id_autorizo">Autoriza</label>
          {{-- @if ($prestamo->id_status_prestamo==10)
              <input type="hidden" name="id_autorizo" value="{{Auth::user()->id}}">
              <select class="form-control show-tick ms select2" id="id_autorizo" required data-placeholder="Select" disabled>
                  <option value="">--Seleccione quien autoriza--</option>
                  @foreach ($administradores as $administrador)
                    <option value="{{$administrador->id}}"
                      {{Auth::user()->id==$administrador->id ? 'selected' : 'Seleccione un producto'}}
                      >{{$administrador->nombre_usuario}}</option>
                  @endforeach
              </select> --}}
          {{-- @else --}}
              <input type="hidden" name="id_autorizo_actual" value="{{$prestamo->id_autorizo}}">
              <select name="id_autorizo" id="id_autoriza" class="form-control show-tick ms select2" id="id_autorizo" required data-placeholder="Select">
                  <option value="">--Seleccione su usuario para autorizar --</option>
                  @foreach ($administradores as $administrador)
                    <option value="{{$administrador->id}}"
                      {{$prestamo->id_autorizo==$administrador->id ? 'selected' : 'Seleccione un producto'}}
                      >{{$administrador->nombre_usuario}}</option>
                  @endforeach
              </select>
          {{-- @endif --}}
          
          {{--<input class="form-control" id="id_autorizo" type="text" name="id_autorizo" placeholder="">--}}
        </div>
        <div class="col-md-4">
            <label for="fecha_aprovacion">Fecha Aprobación</label>
              @php
                  $dateaprovacion = date_create($prestamo->fecha_aprovacion);
              @endphp
              <div class="input-group masked-input mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
                </div>
                <input type="text" name="fecha_aprovacion" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59" value="{{date_format($dateaprovacion, 'd-m-Y H:i:s')}}" required>
              </div>
  
          {{--<input class="form-control" id="fecha_aprovacion" type="datetime" name="fecha_aprovacion" value="{{date_format($dateaprovacion, 'd-m-Y H:i:s')}}" required>--}}
        </div>
        <div class="col-md-4">
          <label for="fecha_entrega_recurso">Fecha Entrega Recurso</label>
          @php
              $dateentrega = date_create($prestamo->fecha_entrega_recurso);
          @endphp
          <div class="input-group masked-input mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
            </div>
            @if ($prestamo->fecha_entrega_recurso==null)
                <input type="text" name="fecha_entrega_recurso" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59" value="{{date_format($dateentrega, 'd-m-Y H:i:s')}}">
                
            @else
              <input type="hidden" name="fecha_entrega_recurso" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59" value="{{date_format($dateentrega, 'd-m-Y H:i:s')}}">
              <input type="text" name="fecha_entrega_recurso_visual" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59" value="{{date_format($dateentrega, 'd-m-Y H:i:s')}}" disabled>
                
            @endif
          </div>
          
        {{--<input class="form-control" id="fecha_entrega_recurso" type="datetime" name="fecha_entrega_recurso" value="{{date_format($dateentrega, 'd-m-Y H:i:s')}}" required>--}}
        </div>
      </div>
      <div class="form-row mb-2">
        <div class="col-md-4">
          <input type="hidden" id="rango_inicial">
          <input type="hidden" id="rango_final">
          <label for="cantidad">Cantidad <small id="cantidad_rango"></small></label>
          <input type="number" onkeyup="validar_cantidad_prestamo()" class="form-control " id="cantidad" name="cantidad" value="{{$prestamo->cantidad}}" placeholder="$2000.00" required>
        </div>
      </div>
    <div class="form-row">
      
      <button type="button" class="btn btn-primary mt-3 ml-2" id="id_boton_editar" data-toggle="modal" data-target="#guardarCambiosPrestamoModel" title="Guardar cambios" >Guardar cambios</button>
      {{--<a class="btn btn-danger" type="submit" href="{{ route('prestamos.index') }}">Cancelar</a>--}}
    </div>
    
  </form>
  {{-- <form action="" method="post">
    <button class="ml-2 btn btn-success" style="margin-bottom: 2px"> Autorizar</button>
  </form> --}}
</div>
<br><br><br>

<div class="modal fade" id="guardarCambiosPrestamoModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body " >
        
        <div class="col-md-12">
          <center>
            <img src="{{asset('img/modal/info.png')}}" style="width: 50%" alt="">

          </center>
          
            <center>
              <b class="modal-title mt-2" id="exampleModalLabel"></b><br>
            </center>
          
          <center>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <a id="enlaceCorte" href="#" class="btn btn-success" style="background: #870374;" onclick="guardarCambiosPrestamo()" data-dismiss="modal">Si, continuar</a>
          </center>
        </div>
       
      </div>
      {{-- <div class="modal-footer"> --}}
      {{-- </div> --}}
    </div>
  </div>
</div> 
<input type="hidden" id="link_retroceder" value="{{$link_retroceder}}">
@stop
@section('page-script')
<script>
window.onload = function agregar_boton_atras(){
  link_atras=document.querySelector("#link_retroceder").value; 
    if (link_atras==0) {
      document.getElementById('Atras').innerHTML='<a href="{{route('prestamos.index')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
    } else {
      document.getElementById('Atras').innerHTML='<a href="{{url($link_retroceder)}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
      
    }
    
  }
</script>
<script>
  $('#guardarCambiosPrestamoModel').on('show.bs.modal', function (event) {
    console.log('Modal abierto cambiar corte')
    var button = $(event.relatedTarget)
    var id = button.data('id')

    var modal = $(this)
    modal.find('.modal-title').text('¿Esta seguro de continuar con la operación?')


  });

  function guardarCambiosPrestamo(){
    var id_promotora = document.getElementById("id_promotora").value;
    var id_autoriza = document.getElementById("id_autoriza").value;
    console.log(id_promotora);
    if (id_promotora==='') {
      document.getElementById('mensaje').innerHTML='<span style="color:red">Seleccione una nueva promomtora</span>';
    } else {
      document.getElementById('mensaje').innerHTML='<span style="color:green">Promotora encontrado</span>';
      document.getElementById("guardarCambiosPrestamoForm").submit();
    }


  }

  
  
</script>
<script>
  const id_producto = @json($prestamo->id_producto);

  


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

  function validar_cantidad(id_producto){
      var cantidad = $("#cantidad").val();

    $.ajax({
        data: {
          "_token": "{{ csrf_token() }}",
          "id_producto": id_producto
        }, //datos que se envian a traves de ajax
        url: "{{ url('buscando_producto') }}", //archivo que recibe la peticion
        type: 'post', //método de envio
        dataType: "json",
        success: function(resp) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          var rango_inicial=resp[0].rango_inicial;
          var rango_final=resp[0].rango_final;
          document.getElementById("cantidad_rango").innerHTML = '(Rango de '+rango_inicial+' a '+rango_final+')';

          document.getElementById("rango_inicial").value=rango_inicial;
          document.getElementById("rango_final").value=rango_final;

        // console.log(id_grupo);
        if(cantidad<rango_inicial){
          document.getElementById('id_boton_editar').disabled=true;
        }else if(cantidad>rango_final){
          document.getElementById('id_boton_editar').disabled=true;
        } else {
          document.getElementById('id_boton_editar').disabled=false;
        }

        }
    });



  }

  function validar_cantidad_prestamo(){

    var cantidad = $("#cantidad").val();
    var cantidad = parseFloat(cantidad);

    var rango_inicial = $("#rango_inicial").val();
    var rango_inicial = parseFloat(rango_inicial);

    var rango_final = $("#rango_final").val();
    var rango_final = parseFloat(rango_final);

  

        if(cantidad >= rango_inicial){
          if (cantidad<=rango_final) {

            document.getElementById('id_boton_editar').disabled=false;

          } else {
            document.getElementById('id_boton_editar').disabled=true;
            
          }
          
        } else {
          
          if(cantidad < rango_inicial) {
             document.getElementById('id_boton_editar').disabled=true;
          }
        } 
  }

  validar_cantidad(id_producto);
  
</script>

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>

@stop