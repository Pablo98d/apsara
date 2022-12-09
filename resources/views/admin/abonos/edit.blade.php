@extends('layouts.master')
@section('title', 'Editar datos de abono')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
  <div class="row mb-4">
      <div class="col-md-3">
          <small><b>Región</b></small><br>
          <input type="text" class="form-control" value="{{$datos_prestamo[0]->Plaza}}" readonly>
          {{-- <a href="{{url('prestamo/abono/agregar-abono-c/'.$datos_prestamo[0]->IdZona.'/'.$datos_prestamo[0]->IdPlaza.'/'.$datos_prestamo[0]->id_grupo.'/'.$datos_prestamo[0]->id_prestamo)}}">atras</a> --}}
      </div>
      <div class="col-md-3">
          <small><b>Zona</b></small><br>
          <input type="text" class="form-control" value="{{$datos_prestamo[0]->Zona}}" readonly>
      </div>
      <div class="col-md-3">
          <small><b>Grupo</b></small><br>
          <input type="text" class="form-control" value="{{$datos_prestamo[0]->grupo}}" readonly>
      </div>
      <div class="col-md-3">
        <small><b>No. Préstamo</b></small><br>
        <input type="text" class="form-control" value="{{$datos_prestamo[0]->id_prestamo}}" readonly>
      </div>
      <div class="col-md-12">
        <hr class="hr-2">
    </div>
  </div>
  <div class="row mb-3 mt-3">
    <div class="col-md-12">
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
    </div>
  </div>
  <form id="guardarCambiosAbonosForm" method="POST" action="{{ url('admin/abonos/' .$abonos->id_abono) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
      <div class="form-row">
        @if ( session('status') )
        <div class="col-md-12">
          <div class="mt-3 mb-3 alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">x</span>
            </button>
          </div>
        </div>
        @endif
        {{--<div class="form-group col-md-6">
          <label for="id_prestamo">Prestamo</label>
          <input type="number" id="id_prestamo" name="id_prestamo" class="form-control" value="{{$abonos->id_prestamo}}"> 
        </div>--}}
        <input type="hidden" name="idZona" value="{{$datos_prestamo[0]->IdZona}}">
        <input type="hidden" name="idPlaza" value="{{$datos_prestamo[0]->IdPlaza}}">
        <input type="hidden" name="idGrupo" value="{{$datos_prestamo[0]->id_grupo}}">
        <input type="hidden" name="idPrestamo" value="{{$datos_prestamo[0]->id_prestamo}}">

        <div class="form-group col-md-2">
          <label for="semana">Semana</label>
          <input id="semana" name="semana" type="text" class="form-control" value="{{$abonos->semana}}">
        </div>
      
        <div class="form-group col-md-3">
          <label for="tipoabono">Tipo abono</label>
          <select class="form-control" name="id_tipoabono" id="tipoabono">
              <option value="">-Tipo abono-</option>
              @foreach ($tipoabono as $tipoab)
                <option value="{{$tipoab->id_tipoabono}}"
                  {{$abonos->id_tipoabono==$tipoab->id_tipoabono ? 'selected' : 'Seleccione un tipo'}}
                  >{{$tipoab->tipoAbono}}</option>
              @endforeach
          </select>
            @if (count($penalizacion)==0)
              <span class="badge badge-warning"><b>Nota:</b>
                  <i>
                    Al cambiar el tipo de abono, la penalización <br>
                    se registrará de acuerdo al tipo de abono. 
                  </i> 
              </span>
              <input type="hidden" name="tipo" value="ninguno">
            @else
                <span class="badge badge-danger"><b>Nota:</b>
                <i>
                  Al cambiar el tipo de abono, la penalización <br>
                  se registrará de acuerdo al tipo de abono. 
                </i> 
                @foreach ($penalizacion as $multa)
                  <input type="hidden" name="tipo" value="{{$multa->id_penalizacion}}">
                  <b>No. Multa {{$multa->id_penalizacion}}</b>
                @endforeach
                </span>
            @endif
        </div>
        <div class="form-group col-md-2">
          <label for="cantidad">Cantidad</label>
          <input name="cantidad" type="number" class="form-control" id="cantidad" class="form-control" value="{{$abonos->cantidad}}">
        </div>
        <div class="form-group col-md-2">
          @php
              $fechaPago = $abonos->fecha_pago;
              setlocale(LC_TIME, "spanish");
              $fecha_p = $fechaPago;
              $fecha_p = str_replace("/", "-", $fecha_p);
              $Nueva_Fecha_p = date("d-m-Y", strtotime($fecha_p));
          @endphp
          <label for="fecha_pago">Fecha de pago</label>
          <input id="fecha_pago" name="fecha_pago" type="datetime"  class="form-control" value="{{$Nueva_Fecha_p}}"><br>
          <span id="message_error" class="text-danger"></span>
          <span id="message_correcto" class="text-success"></span>
        </div>
        <div class="form-group col-md-3">
          <label for="fecha_pago">Corte</label>
          <div id="select-corte">
            <select class="form-control" name="id_corte_semana" id="id_corte_semana">
              @foreach ($cortes_semanas as $cortes_s)
                    @php
                                                          
                        $fechaActual = $cortes_s->fecha_inicio;
                        setlocale(LC_TIME, "spanish");
                        $fecha_a = $fechaActual;
                        $fecha_a = str_replace("/", "-", $fecha_a);
                        $Nueva_Fecha_a = date("d-m-Y", strtotime($fecha_a));
                        
                        $fechaActualf = $cortes_s->fecha_final;
                        setlocale(LC_TIME, "spanish");
                        $fecha_af = $fechaActualf;
                        $fecha_af = str_replace("/", "-", $fecha_af);
                        $Nueva_Fecha_af = date("d-m-Y", strtotime($fecha_af));
                    @endphp
                    <option value="{{$cortes_s->id_corte_semana}}"
                      {{$abonos->id_corte_semana==$cortes_s->id_corte_semana ? 'selected' : 'Seleccione un corte'}}
                      >No. {{$cortes_s->id_corte_semana}}  Fecha: {{$Nueva_Fecha_a}} a {{$Nueva_Fecha_af}}</option>
              @endforeach
            </select>
          </div>
          
        </div>
      </div>
      <div class="d-flex">
            @if (count($penalizacion)==0)
        {{-- <button type="submit" class="btn btn-primary">Guardar cambios</button>         --}}
            <button class="btn btn-primary mt-1" type="button"  data-toggle="modal" data-target="#guardarCambiosAbonosModel"  data-mensaje="Nota: Revise bien los datos del abono" title="Guardar cambios">Guardar cambios</button>
            @else
              {{-- <button type="submit" class="btn btn-primary" onclick="return confirm('El abono que editará tiene multa, por lo tanto, se eliminará y se generará uno nuevo de acuerdo al tipo de abono')">Guardar cambios</button> --}}
              <button class="btn btn-primary mt-1" type="button"  data-toggle="modal" data-target="#guardarCambiosAbonosModel"  data-mensaje="Nota: El abono que editará tiene multa, por lo tanto, se eliminará y se generará uno nuevo de acuerdo al tipo de abono" title="Guardar cambios y eliminar multa ">Guardar cambios</button>
            @endif
      </div>
    </form>

</div> 
<div class="modal fade" id="guardarCambiosAbonosModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body " >
        
        <div class="col-md-12">
          <center>
            <img src="{{asset('img/modal/info.png')}}" style="width: 50%" alt="">

          </center>
          
            <center>
              <b class="modal-title mt-2" id="exampleModalLabel"></b><br>
              <span class="text_mensaje"></span>
            </center>
          <br>
          <center>
            
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-secondary" style="background: #870374" onclick="guardarCambiosAbonosLista()">Si, continuar</button>
          </center>
        </div>
       
      </div>
      {{-- <div class="modal-footer"> --}}
      {{-- </div> --}}
    </div>
  </div>
</div> 
<input type="hidden" id="link_retroceder" value="{{$link}}">
@stop
@section('page-script')
<script>
  window.onload = function agregar_boton_atras(){
    link_atras=document.querySelector("#link_retroceder").value; 
      if (link_atras==0) {
        document.getElementById('Atras').innerHTML='<a href="{{url('prestamo/abono/abonos-clientes')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
      } else {
        document.getElementById('Atras').innerHTML='<a href="{{url($link)}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
        
      }
      
    }
  </script>
<script>
      $(function(){
        $("#fecha_pago").keyup(function(){
          var fecha_automatico = $('#fecha_pago').val();
          if (fecha_automatico.length<=9) {
            
          } else {
            setTimeout(buscar_fecha_corte,200);
          }
        

        });
    });

    function buscar_fecha_corte(){
        var fecha_automatico = $('#fecha_pago').val();
                $('#select-corte').empty();
                

                fecha_automatico1 = convertirFecha2(String(fecha_automatico));

            const cortes_semanas = @json($cortes_semanas);
                trHTML = '';
                contar_seleccionado=0;
                $('#corte_s').empty()
                trHTML ='<option value="" >--Seleccione una fecha de corte</option>';
                cortes_semanas.forEach(function(item, index) {
                    fecha_inicio_for=convertirFecha(String(item.fecha_inicio));
                    fecha_final_for=convertirFecha(String(item.fecha_final));

                    if (fecha_automatico1 >= item.fecha_inicio && fecha_automatico1<=item.fecha_final) {
                        contar_seleccionado+=1;
                        trHTML +='<option value="'+item.id_corte_semana+'" selected>No.'+item.id_corte_semana+' Fecha: '+fecha_inicio_for+' a '+fecha_final_for+'</option>';
                    } else {
                        trHTML +='<option value="'+item.id_corte_semana+'" >No.'+item.id_corte_semana+' Fecha: '+fecha_inicio_for+' a '+fecha_final_for+'</option>';
                    }            
                    // fecha_corte_convertido=convertirFecha(item.fecha_final.toUTCString())
                
                });
                
                if (contar_seleccionado===0) {
                    $('#select-corte').append(`
                    <select class="form-control" name="id_corte_semana" id="id_corte_semana">
                        ${trHTML}
                    </select>
                    <center>
                        <small style="color:gray">Nota: Sin resultados, seleccione una de la lista</small>
                    </center>
                    `);
                } else {
                    $('#select-corte').append(`
                    <select class="form-control" name="id_corte_semana" id="id_corte_semana">
                        ${trHTML}
                    </select>
                    `);
                }

     
        
    }



function convertirFecha(fecha){
    //Objeto javascript que vamos a utilizar como tabla hash para
    //La conversion de los meses a su representacion numerica

    let conversorMeses = {
        '01' : '01',
        '02' : '02',
        '03' : '03',
        '04' : '04',
        '05' : '05',
        '06' : '06',
        '07' : '07',
        '08' : '08',
        '09' : '09',
        '10' : '10',
        '11' : '11',
        '12' : '12'
    };

    //Obtenemos el dia mes y año de la fecha original
    //Tal y como has puesto:
    //paramFecha[0] -> dia
    //paramFecha[1] -> mes
    //paramFecha[2] -> año

    let paramFecha = fecha.split("-");

    //Una vez tenemos los datos montamos el string resultante 
    let fechaRes =   paramFecha[2]+ "/" + conversorMeses[paramFecha[1]] + "/" +paramFecha[0];

    return fechaRes;

}

function convertirFecha2(fecha){
    //Objeto javascript que vamos a utilizar como tabla hash para
    //La conversion de los meses a su representacion numerica

    let conversorMeses = {
        '01' : '01',
        '02' : '02',
        '03' : '03',
        '04' : '04',
        '05' : '05',
        '06' : '06',
        '07' : '07',
        '08' : '08',
        '09' : '09',
        '10' : '10',
        '11' : '11',
        '12' : '12'
    };

    //Obtenemos el dia mes y año de la fecha original
    //Tal y como has puesto:
    //paramFecha[0] -> dia
    //paramFecha[1] -> mes
    //paramFecha[2] -> año

    let paramFecha = fecha.split("-");

    //Una vez tenemos los datos montamos el string resultante 
    let fechaRes =   paramFecha[2]+ "-" + conversorMeses[paramFecha[1]] + "-" +paramFecha[0];

    return fechaRes;

}
</script>
<script>
  $('#guardarCambiosAbonosModel').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var mensaje = button.data('mensaje')

                var modal = $(this)
                modal.find('.modal-title').text('¿Está seguro de continuar con la operación?')
                modal.find('.text_mensaje').text(mensaje)
                
            });
  
  function guardarCambiosAbonosLista(){
    document.getElementById("guardarCambiosAbonosForm").submit();
  }

</script>






<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop