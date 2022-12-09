@extends('layouts.master')
@section('title', 'Visita de zonas')
@section('parentPageTitle', 'Visitas')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<style>
.input-group-text {
	padding: 0 .75rem;
}
</style>
@stop
@section('content')
    @if ( session('status') )
    <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">x</span>
    </button>
    </div>
    @endif
    @if ( session('warning') )
      <div class="mt-3 alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
    @endif
    <form action="{{url('rutas/visitas/visitas-ruta')}}" id="formvi" method="get">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-success" href="{{url('prestamo/buscar_prestamos1') }}" title="Asignar nueva visita"><i class="fas fa-plus"> Nueva visita</i></a>
            {{-- <a href="#" class="btn btn-success" title="Ayuda en cómo utilizar visitas de zonas" onclick="ayudamodal()"><i class="fas fa-question"></i></a> --}}
        </div>
        <div class="col-md-6">
            <label for="">Busca por gerente de zona</label>
            <select class="form-control show-tick ms select2" name="id_gerente" id="" onchange="buscarv()" data-placeholder="Select">
                <option value="">-Busca un gerente-</option>
                <option value="">Todos</option>
                @foreach ($gerenteszonas as $gerentezona)
                    <option {{$id_gerente==$gerentezona->id ? 'selected="selected"' : 'Selecciona un gerente'}} value="{{$gerentezona->id}}">{{$gerentezona->nombre.' '.$gerentezona->ap_paterno.' '.$gerentezona->ap_materno}}</option>                    
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
                <label for="">Busca por grupo</label>
                <select class="form-control show-tick ms select2" name="id_grupo" id="" onchange="buscarv()" data-placeholder="Select">
                    <option value="">-Busca un grupo-</option>
                    <option value="">Todos</option>
                    @foreach ($grupos as $grupo)
                        <option {{$id_grupo== $grupo->id_grupo ? 'selected="selected"' : 'Selecciona un grupo'}} value="{{$grupo->id_grupo}}">{{$grupo->grupo}}</option>                    
                    @endforeach
                </select>
        </div>
    </form>
    <div class="col-md-12 mt-3">
        <form action="{{url('delete-varias-visitas')}}" method="post">
            @csrf
            {{ method_field('DELETE') }}

            <span class="badge badge-warning" style="float: right">Seleccione las casillas de las visitas que desea eliminar</span> <br><button style="float: right" class="btn btn-danger" title="Elimina las visitas seleccionadas" onclick="return confirm('Se eliminarán las visitas seleccionadas. ¿Esta seguro de continuar?')">Eliminar visitas</button>
    </div>
        <div class="col-md-12">
            
            <div class="estilo-tabla mt-4">
                <table>
                    <thead>
                        <tr>
                            <th><small>Región </small></th>
                            <th><small>Gerente zona </small></th>
                            <th><small>Zona </small></th>
                            <th><small>Promotor </small></th>
                            <th><small>Lun </small></th>
                            <th><small>Mar </small></th>
                            <th><small>Mie </small></th>
                            <th><small>Jue </small></th>
                            <th><small>Vie </small></th>
                            <th><small>Sab </small></th>
                            <th><small>Dom </small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitas as $visita)
                        <tr>
                            <td><small>{{$visita->Plaza}}</small></td>
                            <td><small>{{$visita->id_gerente_zona}} / {{$visita->nombre.' '.$visita->ap_paterno.' '.$visita->ap_materno}}</small></td>
                            {{-- <td>{{$visita->id_gerente_zona}}</td> --}}
                            <td><small>{{$visita->Zona}}</small></td>
                            {{-- <td>{{$visita->id_zona}}</td> --}}
                        <td><small>{{$visita->id_grupo_promotora}} / {{$visita->nombre_promotora}} / {{$visita->grupo}}</small></td>
                            <td><small>
                                <center>
                                    @if ($visita->nombre_dia=='Lunes')
                                    <div style="whith: 100%; background: rgb(48, 194, 60);">
                                        {{-- <form action="{{url('delete-visita/'.$visita->id_ruta_zona)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }} --}}
                                            <i style="background: rgb(48, 194, 60); padding: 5px; margin: 3px; font-size: 15px; color: white" class="fas fa-check"></i>
                                     
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button> --}}
                                            
                                              
                                                <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">    
                                            
                                        {{-- </form> --}}
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
                                     
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button> --}}
                                            <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                        {{-- </form> --}}
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
                                       
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button> --}}
                                            <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                        {{-- </form> --}}
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
                                       
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button> --}}
                                            <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                        {{-- </form> --}}
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
                                        
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button> --}}
                                            <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                        {{-- </form> --}}
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
                                       
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button> --}}
                                            <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                        {{-- </form> --}}
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
                                       
                                            {{-- <button style="padding: 0px; border: 0px; background: transparent; color: rgb(68, 68, 68); font-size: 12px;" title="Eliminar visita" onclick="return confirm('¿Desea eliminar?')"><i class="fas fa-trash"></i></button> --}}
                                            <input class="fas fa-trash" style=" font-size: 13px; width: 20px; height: 20px;" type="checkbox" name="id_ruta_zona[]" value="{{$visita->id_ruta_zona}}" title="Clic para seleccionar y eliminar">
                                        {{-- </form> --}}
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
        </div>
    </form>
        <div class="modal fade" id="modalayuda" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Utilizando el interfaz de visitas de zonas</h4>
                    </div>
                    <div class="modal-body">
                        <video src="videos/tuto.mp4" width="700" height="400" controls></video>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@stop
@section('page-script')
<script>
    window.onload = function agregar_boton_atras(){
      document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  }
  </script>
<script>
    function buscarv()
    {
        document.getElementById("formvi").submit();
    }
    function ayudamodal(){
    $("#modalayuda").modal();
    }
  </script>
  <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
  <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop