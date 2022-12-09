@extends('layouts.master')
@section('title', 'Configuración de corte semana')
@section('parentPageTitle', 'Corte')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
@stop
@section('content')

@if (empty($vista_editar))
    

  <div class="body">
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
    <div class="row">
        <br>
        {{-- <div class="col-md-4">
            <label for="">Región</label>
            <a href="{{url('operacion/buscar_prestamos1?id_region='.$region->IdPlaza)}}" class="form-control" title="Clic para ir a las zonas de esta región">{{$region->Plaza}}</a>
        </div>
        <div class="col-md-4">
            <label for="">Zona</label>
            <a href="{{url('operacion/buscar-grupo/'.$zona->IdZona.'/'.$region->IdPlaza)}}" class="form-control" title="Clic para ir a los grupos de esta zona">{{$zona->Zona}}</a>
        </div> --}}
        <div class="col-md-4">
            <label for="">Grupo</label>
            {{-- <input class="form-control" type="text" value="{{$grupo->grupo}}" readonly> --}}
            <form id="formGrupos" action="{{url('configurar-corte-semana/'.$region->IdPlaza.'/'.$zona->IdZona.'/0')}}" method="get">
                <select name="id_grupo" class="form-control show-tick ms select2" id="" data-placeholder="Select" onchange="buscar_grupo()">
                    {{-- <option value="">--Seleccione un grupo--</option> --}}
                    @foreach ($grupos as $grup)
                        <option value="{{$grup->id_grupo}}" 
                            {{$grupo->id_grupo==$grup->id_grupo ? 'selected' : 'Seleccione un grupo'}}
                            >{{$grup->grupo}}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="col-md-8">
            <br>
            {{-- <input class="form-control" type="text" value="{{$grupo->grupo}}" readonly> --}}
            <form action="{{url('edit-corte-semana/0')}}" method="get">
              <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
              <input type="hidden" id="link" name="link" value="configurar-corte-semana/{{$region->IdPlaza}}/{{$zona->IdZona}}/{{$grupo->id_grupo}}">
               <button class="btn btn-primary mt-2" style="float: right">Generar nueva fecha</button>
            </form>
        </div>
        <div class="col-md-12">
          <hr>
        </div>
        
    </div>
    
      @if(count($cortes_semana)==0)
      
        <br>
        <form action="{{url('guardar-corte-semana')}}" method="post">
            @csrf
          <div class="row mb-4 mt-3">
              <div class="col-md-12">
                  <div class="alert alert-warning alert-sm" role="alert">
                    Ingrese todos los datos para configurar el corte de semana de este grupo. La configuración se hace una única vez.
                  </div>
                  <hr>
              </div>
              
              <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}" required>
              <div class="col-md-3">
                @php
                    $fecha_hoy=date("Y/m/d");

                @endphp
                <input id="fecha_hoy" type="hidden" value="{{$fecha_hoy}}">
                  <label for="">Fecha Inicio</label>
                  <input class="form-control" id="fecha" type="date" min="" name="fecha_inicio" required><small><span style="color: red" id="mensaje"></span></small>
              </div>
              <div class="col-md-2">
                  <label for="">Fecha Final</label>
                  <input class="form-control" type="text" id="fecha_fin" name="fecha_final" required>
              </div>
              <div class="col-md-2">
                  <label for="">Corte ideal</label>
                  <input class="form-control" type="number" id="fecha_fin" name="corte_ideal" required>
              </div>
              <div class="col-md-2">
                  <label for="">Clientes</label>
                  <input class="form-control" type="number" name="total_clientes" value="" required>
              </div>
              <div class="col-md-2">
                  <br>
                  <input class="btn btn-primary mt-2" type="submit" value="Guardar configuracíón">
              </div>
          </div>
        </form>
        <br>
        <br>
      @else
        <div class="estilo-tabla" style="height: calc(65vh);  overflow-y: scroll">
          <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
          <tr>
            <th><small>No.C semana</small></th>
            <th><small>Año</small></th>
            <th><small>Fechas</small></th>
            <th><small>Semana corte</small></th>
            <th><small>Corte ideal</small></th>
            <th><small>Clientes</small></th>
            <th><small>Estatus</small></th>
            <th><small>Operación</small></th>
          </tr>
        </thead>
        <tbody>
            @php
                $contador=0;
            @endphp
          @if (count($cortes_semana)==0)
          
          @else
                @foreach ($cortes_semana as $corte_semana)
                @php
                    $contador+=1;
                @endphp
                  <tr>
                    <td>{{$corte_semana->id_corte_semana}}</td>
                    <td>
                          {{$corte_semana->año}}
                    </td>
                    <td>
                      @php
                          $fechaInicio = $corte_semana->fecha_inicio;
                          setlocale(LC_TIME, "spanish");
                          $fecha_ini = $fechaInicio;
                          $fecha_ini = str_replace("/", "-", $fecha_ini);
                          $Nueva_Fecha_Ini = date("d-m-Y", strtotime($fecha_ini));

                          $fechaFinal = $corte_semana->fecha_final;
                          setlocale(LC_TIME, "spanish");
                          $fecha_fin = $fechaFinal;
                          $fecha_fin = str_replace("/", "-", $fecha_fin);
                          $Nueva_Fecha_Fin = date("d-m-Y", strtotime($fecha_fin));
                      @endphp

                            {{$Nueva_Fecha_Ini}} - {{$Nueva_Fecha_Fin}}
                        
                    </td>
                    <td style="text-align: right; margin-right:15px;">
                        
                            {{number_format($corte_semana->numero_semana_corte)}}
                        
                    </td>
                    <td style="text-align: right; margin-right:15px;">
                        
                            $ {{number_format($corte_semana->corte_ideal,2)}}
                        
                    </td>
                    <td style="text-align: right; margin-right:15px;">
                        
                            {{number_format($corte_semana->total_clientes)}}
                        
                    </td>
                    <td style="text-align: right; margin-right:15px;">
                        @if ($contador==1)
                          <span class="badge badge-warning">
                            En proceso
                          </span>
                        @else
                        <span class="badge badge-success">
                          Finalizado
                        </span>
                            
                        @endif
                      
                  </td>
                  <td style="text-align: right; margin-right:15px; d-flex">
                      
                        @php
                          $abonos = DB::table('tbl_abonos')
                          ->select('tbl_abonos.*')
                          ->where('id_corte_semana', '=',$corte_semana->id_corte_semana)
                          ->get();
                        @endphp
                        {{-- <a href="{{url('edit-corte-semana/'.$corte_semana->id_corte_semana)}}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a> --}}
                        <form action="{{url('edit-corte-semana/'.$corte_semana->id_corte_semana)}}" method="get">
                            <input type="hidden" id="link" name="link" value="configurar-corte-semana/{{$region->IdPlaza}}/{{$zona->IdZona}}/{{$grupo->id_grupo}}/">
                            <button class="btn btn-warning btn-sm" title="Editar configuración semana" type="submit"><i class="fas fa-pen"></i></button>
                          

                            @if (count($abonos)>0)
                                {{-- <button class="btn btn-secondary btn-sm" type="button" onclick="return avisoEliminarCorte()" title="La fecha de corte tiene abonos"><i class="fas fa-trash"></i></button> --}}
                                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#cambiarCorteModel" title="La fecha de corte tiene abonos" data-id="{{$corte_semana->id_corte_semana}}"><i class="fas fa-trash"></i></button>
                                
                            @else
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarCorteModel" title="Eliminar fecha de corte semana" data-id="{{$corte_semana->id_corte_semana}}"><i class="fas fa-trash"></i></button>
                                
                            @endif
                        </form>
                    
                
                  </td>
                    
                  </tr>
                @endforeach
          @endif
        </tbody>
              </table>
      </div>
      <script>
        window.onload = function agregar_boton_atras(){
          
          document.getElementById('Atras').innerHTML='<a href="{{url('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
          document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
          }
      </script>
      @endif
  </div>
  
@else
  @if ( session('status') )
    <div class="col-md-12">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>

    </div>
  @endif
  <hr>
  
    @if ($vista_editar=='editar')
    
      <form action="{{url('update-corte-semana')}}" method="post">
        @csrf
          <div class="row mb-4 mt-3">
            <div class="col-md-4">
              <label for="">Grupo</label>
              <input type="text" class="form-control" name="" value="{{$corte_semana[0]->grupo}}" disabled>
            
            </div>
            <div class="col-md-2">
              <label for="">No. Corte</label>
              <input type="text" class="form-control" name="" value="{{$corte_semana[0]->id_corte_semana}}" disabled>
              <input type="hidden" class="form-control" name="id_corte_semana" value="{{$corte_semana[0]->id_corte_semana}}" >
            </div>
            <div class="col-md-2">
                <label for="numero_semana_corte">No. Semana</label>
                <input class="form-control" type="number" min="0" id="numero_semana_corte" name="numero_semana_corte" value="{{$corte_semana[0]->numero_semana_corte}}" required>
            </div>
          </div>
          <div class="row mb-4 mt-3">
              
              <div class="col-md-3">
                @php
                    $fecha_hoy=date("Y/m/d");
                @endphp
                <input id="fecha_hoy" type="hidden" value="{{$fecha_hoy}}">
                  <label for="">Fecha Inicio</label>
                  <input class="form-control" id="fechaeditar" type="date" min="" name="fecha_inicio" value="{{$corte_semana[0]->fecha_inicio}}" required><small><span style="color: red" id="mensaje"></span></small>
              </div>
              <div class="col-md-2">
                @php
                  $date = date_create($corte_semana[0]->fecha_final);
                  $fecha_fin_corte= date_format($date,"d/m/Y");
                @endphp 
                  <label for="">Fecha Final</label>
                  <input class="form-control" type="text" id="fecha_fin" name="fecha_final" value="{{$fecha_fin_corte}}" required>
              </div>
              
              <div class="col-md-2">
                  <label for="">Corte ideal</label>
                  <input class="form-control" type="number" id="fecha_fin" name="corte_ideal" value="{{$corte_semana[0]->corte_ideal}}" required>
              </div>
              <div class="col-md-2">
                  <label for="">Clientes</label>
                  <input class="form-control" type="number" name="total_clientes"  value="{{$corte_semana[0]->total_clientes}}" required>
              </div>
              <div class="col-md-2">
                  <br>
                  <input class="btn btn-primary mt-2" type="submit" onclick="return confirm('¿Está seguro de continuar con la operación?')" value="Guardar cambios">
              </div>
          </div>
      </form>

    
      <script>
        window.onload = function agregar_boton_atras(){
          link_atras=document.querySelector("#link_retroceder").value;
      
            if (link_atras==0) {
              
              
            } else {
              document.getElementById('Atras').innerHTML='<a href="{{url($link)}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
              document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
            }
            
          }
      </script>
    @elseif($vista_editar=='nuevo')
    {{-- @php
          dd(',m,m,m,m,m,m');
      @endphp --}}
      <form action="{{url('guardar-corte-semana')}}" method="post">
          @csrf
        <div class="row mb-4 mt-3">
            <div class="col-md-12">
                <div class="alert alert-warning alert-sm" role="alert">
                  Ingrese todos los datos para configurar la nueva fecha de corte semana de este grupo.
                </div>
                <hr>
            </div>
            <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}" required>
            <div class="col-md-3">
              @php
                  $fecha_hoy=date("Y/m/d");

              @endphp
              <input id="fecha_hoy" type="hidden" value="{{$fecha_hoy}}">
                <label for="">Fecha Inicio</label>
                <input class="form-control" id="fecha" type="date" min="" name="fecha_inicio" required><small><span style="color: red" id="mensaje"></span></small>
            </div>
            <div class="col-md-2">
                <label for="">Fecha Final</label>
                <input class="form-control" type="text" id="fecha_fin" name="fecha_final" required>
            </div>
            <div class="col-md-2">
                <label for="">Corte ideal</label>
                <input class="form-control" type="number" id="fecha_fin" name="corte_ideal" required>
            </div>
            <div class="col-md-2">
                <label for="">Clientes</label>
                <input class="form-control" type="number" name="total_clientes" value="" required>
            </div>
            <div class="col-md-2">
                <br>
                <input class="btn btn-primary mt-2" type="submit" value="Guardar configuracíón">
            </div>
        </div>
      </form>
      <br>
      <br>
      <script>
        window.onload = function agregar_boton_atras(){
          link_atras=document.querySelector("#link_retroceder").value;
      
            if (link_atras==0) {
              
              
            } else {
              document.getElementById('Atras').innerHTML='<a href="{{url($link)}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
              document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
            }
            
          }
      </script>
    @else
    
    @endif

@endif
    <input type="hidden" id="link_retroceder" value="{{$link}}">
      

{{-- Route::get('cambiar-corte-abono/{id_corte}', 'HomeController@cambiar_corte_abono'); --}}
<div class="modal fade" id="cambiarCorteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body " >
        
        <div class="col-md-12">
          <center>
            <img src="{{asset('img/modal/info.png')}}" style="width: 50%" alt="">

          </center>
          
            <center>
              <b class="modal-title mt-2" id="exampleModalLabel"></b><br>
              <small>NOTA: para eliminarlo, es necesario que cambie de fecha de corte los abonos</small>
            </center>
          
          <center>
            <button type="button" class="btn btn-primary" data-dismiss="modal">¡ Ok !</button>
            <a id="enlaceCorte" href="{{url('cambiar-corte-abono/0')}}" class="btn btn-success" style="background: #870374;" data-href="{{url('cambiar-corte-abono/0')}}">Ver abonos</a>
          </center>
        </div>
       
      </div>
      {{-- <div class="modal-footer"> --}}
      {{-- </div> --}}
    </div>
  </div>
</div> 

<div class="modal fade" id="eliminarCorteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body " >
        
        <div class="col-md-12">
          <center>
            <img src="{{asset('img/modal/question.png')}}" style="width: 50%" alt="">

          </center>
          
            <center>
              <b class="modal-title mt-2" id="exampleModalLabel"></b>
              
            </center>
          <br>
          <center>
            <form id="formEliminarCorte" action="{{ url('delete-corte-semana/0') }}" data-action="{{ url('delete-corte-semana/0') }}" method="post">
              {{ csrf_field() }}
              <button type="button" class="btn btn-secondary" data-dismiss="modal">No eliminar</button>
              <button type="submit" class="btn btn-danger">Si eliminar</button>
            </form>
          </center>
        </div>
       
      </div>
      {{-- <div class="modal-footer"> --}}
      {{-- </div> --}}
    </div>
  </div>
</div> 

@stop
@section('page-script')
<script>
  $('#eliminarCorteModel').on('show.bs.modal', function (event) {
    console.log('Modal abierto')
    var button = $(event.relatedTarget)
    var id = button.data('id')

    action = $('#formEliminarCorte').attr('data-action').slice(0,-1) 
    action += id
    console.log(action)

    $('#formEliminarCorte').attr('action',action)

    var modal = $(this)
    modal.find('.modal-title').text('¿Está seguro de eliminar la fecha de corte #' + id +' ?')

   

  });

  $('#cambiarCorteModel').on('show.bs.modal', function (event) {
    console.log('Modal abierto cambiar corte')
    var button = $(event.relatedTarget)
    var id = button.data('id')

    action = $('#enlaceCorte').attr('data-href').slice(0,-1) 
    action += id
    console.log(action)

    $('#enlaceCorte').attr('href',action)

    var modal = $(this)
    modal.find('.modal-title').text('Lo sentimos, la fecha de corte #' + id +', tiene abonos')


  });
</script>
<script>
  $(function(){
    $("#fecha").change(function(){
        var fechahoy=$('#fecha_hoy').val();
        
        var fecha = new Date($('#fecha').val());
        fecha_inicio=fecha.toUTCString();
        // fecha_inicio_convertido=convertirFecha(fecha_inicio);
        var dias = 7; // Número de días a agregar
        fecha.setDate(fecha.getDate() + dias);
        fecha_fin_convertida=convertirFecha(fecha.toUTCString());
        // comparar fechas
        fecha_inicio_convertido=convertirFechaComparar(fecha_inicio);

        if(fecha_inicio_convertido<fechahoy){
          // $("#fecha_fin").val();
          $("#mensaje").html('La fecha no es válido');
          $("#fecha_fin").val(null);
        } else {
          $("#mensaje").empty();
          $("#fecha_fin").val(fecha_fin_convertida);
        }
    })
})
$(function(){
    $("#fechaeditar").change(function(){
        var fechahoy=$('#fecha_hoy').val();
        
        var fecha = new Date($('#fechaeditar').val());
        fecha_inicio=fecha.toUTCString();
        // fecha_inicio_convertido=convertirFecha(fecha_inicio);
        var dias = 7; // Número de días a agregar
        fecha.setDate(fecha.getDate() + dias);
        fecha_fin_convertida=convertirFecha(fecha.toUTCString());
        // comparar fechas
        fecha_inicio_convertido=convertirFechaComparar(fecha_inicio);

        // if(fecha_inicio_convertido<fechahoy){
        //   // $("#fecha_fin").val();
        //   $("#mensaje").html('La fecha no es válido');
        //   $("#fecha_fin").val(null);
        // } else {
          $("#mensaje").empty();
          $("#fecha_fin").val(fecha_fin_convertida);
        // }
    })
})

function convertirFecha(fecha){
    //Objeto javascript que vamos a utilizar como tabla hash para
    //La conversion de los meses a su representacion numerica

    let conversorMeses = {
        'Jan' : '01',
        'Feb' : '02',
        'Mar' : '03',
        'Apr' : '04',
        'May' : '05',
        'Jun' : '06',
        'Jul' : '07',
        'Aug' : '08',
        'Sep' : '09',
        'Oct' : '10',
        'Nov' : '11',
        'Dec' : '12'
    };

    //Obtenemos el dia mes y año de la fecha original
    //Tal y como has puesto:
    //paramFecha[0] -> dia
    //paramFecha[1] -> mes
    //paramFecha[2] -> año

    let paramFecha = fecha.split(" ");

    //Una vez tenemos los datos montamos el string resultante 
    let fechaRes = paramFecha[1] + "/" + conversorMeses[paramFecha[2]] + "/" + paramFecha[3];

    return fechaRes;

}
function convertirFechaComparar(fecha){
    //Objeto javascript que vamos a utilizar como tabla hash para
    //La conversion de los meses a su representacion numerica

    let conversorMeses = {
        'Jan' : '01',
        'Feb' : '02',
        'Mar' : '03',
        'Apr' : '04',
        'May' : '05',
        'Jun' : '06',
        'Jul' : '07',
        'Aug' : '08',
        'Sep' : '09',
        'Oct' : '10',
        'Nov' : '11',
        'Dec' : '12'
    };

    //Obtenemos el dia mes y año de la fecha original
    //Tal y como has puesto:
    //paramFecha[0] -> dia
    //paramFecha[1] -> mes
    //paramFecha[2] -> año

    let paramFecha = fecha.split(" ");

    //Una vez tenemos los datos montamos el string resultante 
    let fechaRes = paramFecha[3] + "/" + conversorMeses[paramFecha[2]] + "/" + paramFecha[1];

    return fechaRes;

}
</script>
<script>
  function buscar_grupo()
  {
      document.getElementById("formGrupos").submit();
  }

</script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop