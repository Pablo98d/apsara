@extends('layouts.master')
@section('title', 'Visita de zona por grupo')
@section('parentPageTitle', 'Visitas')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
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
                <div class="col-md-4">
                    <p style="margin: 2px">Región</p>
                    <a href="{{url('operacion/buscar_prestamos1?id_region='.$region->IdPlaza)}}" class="form-control" title="Clic para ir a las zonas de esta región">{{$region->Plaza}}</a>
                </div>
                <div class="col-md-4">
                    <p style="margin: 2px">Zona</p>
                    {{-- <input type="text" class="form-control" name="" readonly id="" value="{{$zona->Zona}}"> --}}
                    <a href="{{url('operacion/buscar-grupo/'.$zona->IdZona.'/'.$region->IdPlaza)}}" class="form-control" title="Clic para ir a los grupos de esta zona">{{$zona->Zona}}</a>
                </div>
                <div class="col-md-4">
                    <p style="margin: 2px">Grupo</p>
                    {{-- <input type="text" class="form-control" name="" readonly id="" value="{{$grupo->grupo}}"> --}}
                    <form id="formGrupos" action="{{url('rutas/visitas/visitas-porgrupo/'.$region->IdPlaza.'/'.$zona->IdZona.'/0')}}" method="get">
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
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            <form action="{{url('guardar_visita')}}" method="POST">
            <div class="row">
                    <div class="col-md-2">
                    
                        @csrf
                        {{-- {{$dias_sin_visita}} --}}
                        <label style="margin: 3px" for="">Día</label>
                        <select class="form-control" name="id_dia" id="" required>
                            <option value="">-Seleccione dia-</option>
                            @foreach ($dias_sin_visita as $dia)
                                <option value="{{$dia->id_dia}}">{{$dia->nombre_dia}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label style="margin: 3px" for="">Gerente de zona</label>
                        <select class="form-control" name="id_gerente_zona" id="" required>
                            <option value="">-Seleccione gerente-</option>
                            @foreach ($gerenteszonas as $gerentezona)
                                <option value="{{$gerentezona->id}}">{{$gerentezona->id}} {{$gerentezona->nombre.' '.$gerentezona->ap_paterno.' '.$gerentezona->ap_materno}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label style="margin: 3px" for="">Promotor</label>
                        <select class="form-control" name="id_grupo_promotora" id="" required>
                            <option value="">-Seleccione promotor-</option>
                            @foreach ($promotoras as $promotor)
                                <option value="{{$promotor->id_grupo_promotoras}}">{{$promotor->id_grupo_promotoras}} {{$promotor->nombre.' '.$promotor->ap_paterno.' '.$promotor->ap_materno}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" style="margin-top:32px" class="btn btn-primary">Guardar visita</button>
                    
                    </div>
            </div>
        </form>
        <div class="col-md-12 mt-3">
            <form action="{{url('delete-varias-visitas')}}" method="post">
                @csrf
                {{ method_field('DELETE') }}
    
                <span class="badge badge-warning" style="float: right">Seleccione las casillas de las visitas que desea eliminar</span> <br><button style="float: right" class="btn btn-danger" title="Elimina las visitas seleccionadas" onclick="return confirm('Se eliminarán las visitas seleccionadas. ¿Esta seguro de continuar?')">Eliminar visitas</button>
        </div>
            <div class="estilo-tabla mt-4">
                <table>
                    <thead>
                        <tr>
                            <th><small>Gerente zona </small></th>
                            {{-- <th><small>Zona </small></th> --}}
                            <th><small>Promotor </small></th>
                            <th><small>Lunes </small></th>
                            <th><small>Martes </small></th>
                            <th><small>Miércoles </small></th>
                            <th><small>Jueves </small></th>
                            <th><small>Viernes </small></th>
                            <th><small>Sábado </small></th>
                            <th><small>Domingo </small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitas as $visita)
                        <tr>
                            <td><small>{{$visita->id_gerente_zona}} / {{$visita->nombre.' '.$visita->ap_paterno.' '.$visita->ap_materno}}</small></td>
                            {{-- <td><small>{{$visita->Zona}}</small></td> --}}
                            <td><small>{{$visita->id_grupo_promotora}} / {{$visita->nombre_promotora}}</small></td>
                            <td><small>
                                <center>
                                    @if ($visita->nombre_dia=='Lunes')
                                    <div style="whith: 100%; background: rgb(48, 194, 60);">
                                        {{-- <form action="{{url('delete-visita/'.$visita->id_ruta_zona)}}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }} --}}
                                            <i style="background: rgb(48, 194, 60); padding: 5px; margin: 3px; font-size: 15px; color: white" class="fas fa-check"></i>
                                        <a href="{{url('rutas/visitas/update-visitas/'.$visita->id_ruta_zona.'/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" style="color: rgb(68, 68, 68); font-size: 12px;" title="Editar visita">
                                            {{-- <i class="fas fa-ellipsis-v" title="Opciones"></i> --}}
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                    @else
                                    @endif
                                </center>
                            </small></td>
                            <td><small>
                                <center>
                                    @if ($visita->nombre_dia=='Martes')
                                    <div style="whith: 100%; background: rgb(48, 194, 60);">
                                        {{-- <form action="{{url('delete-visita/'.$visita->id_ruta_zona)}}" method="post">
                                            {{ csrf_field() }}
                                        {{ method_field('DELETE') }} --}}
                                            <i style="background: rgb(48, 194, 60); padding: 5px; margin: 3px; font-size: 15px; color: white" class="fas fa-check"></i>
                                            <a href="{{url('rutas/visitas/update-visitas/'.$visita->id_ruta_zona.'/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" style="color: rgb(68, 68, 68); font-size: 12px;" title="Editar visita">
                                            {{-- <i class="fas fa-ellipsis-v" title="Opciones"></i> --}}
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                    @else
                                    @endif
                                </center>
                            </small></td>
                            <td><small>
                                <center>
                                    @if ($visita->nombre_dia=='Miércoles')
                                    <div style="whith: 100%; background: rgb(48, 194, 60);">
                                        {{-- <form action="{{url('delete-visita/'.$visita->id_ruta_zona)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }} --}}
                                            <i style="background: rgb(48, 194, 60); padding: 5px; margin: 3px; font-size: 15px; color: white" class="fas fa-check"></i>
                                            <a href="{{url('rutas/visitas/update-visitas/'.$visita->id_ruta_zona.'/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" style="color: rgb(68, 68, 68); font-size: 12px;" title="Editar visita">
                                            {{-- <i class="fas fa-ellipsis-v" title="Opciones"></i> --}}
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                    @else
                                    @endif
                                </center>
                            </small></td>
                            <td><small>
                                <center>
                                    @if ($visita->nombre_dia=='Jueves')
                                    <div style="whith: 100%; background: rgb(48, 194, 60);">
                                        {{-- <form action="{{url('delete-visita/'.$visita->id_ruta_zona)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }} --}}
                                            <i style="background: rgb(48, 194, 60); padding: 5px; margin: 3px; font-size: 15px; color: white" class="fas fa-check"></i>
                                            <a href="{{url('rutas/visitas/update-visitas/'.$visita->id_ruta_zona.'/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" style="color: rgb(68, 68, 68); font-size: 12px;" title="Editar visita">
                                            {{-- <i class="fas fa-ellipsis-v" title="Opciones"></i> --}}
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                    @else
                                    @endif
                                </center>
                            </small></td>
                            <td><small>
                                <center>
                                    @if ($visita->nombre_dia=='Viernes')
                                    <div style="whith: 100%; background: rgb(48, 194, 60);">
                                        {{-- <form action="{{url('delete-visita/'.$visita->id_ruta_zona)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }} --}}
                                            <i style="background: rgb(48, 194, 60); padding: 5px; margin: 3px; font-size: 15px; color: white" class="fas fa-check"></i>
                                            <a href="{{url('rutas/visitas/update-visitas/'.$visita->id_ruta_zona.'/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" style="color: rgb(68, 68, 68); font-size: 12px;" title="Editar visita">
                                            {{-- <i class="fas fa-ellipsis-v" title="Opciones"></i> --}}
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                    @else
                                    @endif
                                </center>
                            </small></td>
                            <td><small>
                                <center>
                                    @if ($visita->nombre_dia=='Sábado')
                                    <div style="whith: 100%; background: rgb(48, 194, 60);">
                                        {{-- <form action="{{url('delete-visita/'.$visita->id_ruta_zona)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }} --}}
                                            <i style="background: rgb(48, 194, 60); padding: 5px; margin: 3px; font-size: 15px; color: white" class="fas fa-check"></i>
                                            <a href="{{url('rutas/visitas/update-visitas/'.$visita->id_ruta_zona.'/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" style="color: rgb(68, 68, 68); font-size: 12px;" title="Editar visita">
                                            {{-- <i class="fas fa-ellipsis-v" title="Opciones"></i> --}}
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                    @else
                                    @endif
                                </center>
                            </small></td>
                            <td><small>
                                <center>
                                    @if ($visita->nombre_dia=='Domingo')
                                    <div style="whith: 100%; background: rgb(48, 194, 60);">
                                        {{-- <form action="{{url('delete-visita/'.$visita->id_ruta_zona)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }} --}}
                                            <i style="background: rgb(48, 194, 60); padding: 5px; margin: 3px; font-size: 15px; color: white" class="fas fa-check"></i>
                                            <a href="{{url('rutas/visitas/update-visitas/'.$visita->id_ruta_zona.'/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" style="color: rgb(68, 68, 68); font-size: 12px;" title="Editar visita">
                                            {{-- <i class="fas fa-ellipsis-v" title="Opciones"></i> --}}
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button>
                                        </form> --}}
                                    </div>
                                    @else
                                    @endif
                                </center>
                            </small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
        </div>
    </div>

@stop
@section('page-script')
<script>
    

    window.onload = function agregar_boton_atras(){
  
      document.getElementById('Atras').innerHTML='<a href="{{url('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
    
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