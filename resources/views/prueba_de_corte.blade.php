@extends('layouts.master')
@section('title', 'La Feriecita')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>

@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <hr>
        @if ( session('status') )
            <div class="col-md-12">
                <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <a href="#" class="btn btn-success btn-sm" onclick="addfecha();" title="Agregar nueva fecha"><i class="fas fa-plus-circle"></i> Nueva fecha</a>
        <div class="estilo-tabla">
            <table class="js-basic-example">
                <thead>
                    <tr>
                        <th>No. Corte</th>
                        <th>Grupo</th>
                        <th>Día</th>
                        <th>Hora</th>
                        <th>Operación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fecha_corte as $fecha_c)
                        <tr>
                            <td>{{$fecha_c->id_corte}}</td>
                            <td>{{$fecha_c->grupo}}</td>
                            <td>{{$fecha_c->nombre_dia}}</td>
                            <td>{{$fecha_c->hora}}</td>
                            <td class="d-flex">
                                <a href="{{url('corte-edit/'.$fecha_c->id_corte)}}" class="btn btn-warning btn-sm" title="Editar fecha de corte"><i class="fas fa-pen"></i></a>
                                <form method="POST" action="{{url('corte-delete/'.$fecha_c->id_corte)}}">
                                   @csrf
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea eliminar la fecha de corte?')" title="Eliminar fecha de corte"><i class="fas fa-trash"></i></button>
                                  </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_fecha" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="title" id="largeModalLabel">Agregando a una fecha de corte</h4>
            </div>
            <div class="modal-body"> 
            <div class="row clearfix">
                    <div class="col-sm-12" id="cuadro">
                    <form  action="{{url('corte-store')}}" method="POST">

                        {{ csrf_field() }}
                        <input type="hidden" value="" id="id" name="id_grupo">
                        <div class="form-group">
                            <label for="id_grupo">Grupo</label>
                            <select  name="id_grupo" id="id_grupo" class="col-sm-12 form-control show-tick ms select2" data-placeholder="Select">
                                <option value="">--seleccione un grupo--</option>
                                    @foreach ($grupos as $grupo) {
                                        <option value="{{$grupo->id_grupo}}">{{$grupo->grupo}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="nombre_dia">Día</label>
                                <select  name="nombre_dia" id="nombre_dia" class="col-sm-12 form-control show-tick ms select2" data-placeholder="Select">
                                        @include('admin.dias_options',['val'=>''])
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="id_grupo">Hora</label><br>
                                <input type="text" name="hora" class="form-control" placeholder="10:20:00">
                                <center>
                                    <span class="badge badge-warning"><i>Formato 24 horas</i></span>
                                </center>
                            </div>
                        </div>

                        <br>
                </div>
            </div>
        </div>
            <div class="modal-footer">
                <button type="submit" onclick="return confirm('¿Esta seguro de continuar?')" class="btn btn-default btn-round waves-effect" >Guardar fecha</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
                    </form>
            </div>
        </div>
    </div>
</div>

@stop
@section('page-script')
<script>
    function addfecha(){

    document.getElementById("id").value=id;
    $("#modal_fecha").modal();
    }
</script>



<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop