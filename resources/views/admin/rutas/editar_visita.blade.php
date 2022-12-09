@extends('layouts.master')
@section('title', 'Actualizando visita')
@section('parentPageTitle', 'Visitas')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
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
                    <input type="text" class="form-control" name="" readonly id="" value="{{$region->Plaza}}">
                </div>
                <div class="col-md-4">
                    <p style="margin: 2px">Zona</p>
                    <input type="text" class="form-control" name="" readonly id="" value="{{$zona->Zona}}">
                </div>
                <div class="col-md-4">
                    <p style="margin: 2px">Grupo</p>
                    <input type="text" class="form-control" name="" readonly id="" value="{{$grupo->grupo}}">
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        <form action="{{url('rutas/visitas/update-fin-v/'.$visita->id_ruta_zona.'/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="POST">
            <div class="row">
                    <div class="col-md-2">
                    
                        @csrf
                        <label style="margin: 3px" for="">Día</label>
                        <select class="form-control" name="id_dia" id="" required>
                            <option value="">-Seleccione dia-</option>
                            @foreach ($dias as $dia)
                            <option {{$visita->id_dia == $dia->id_dia ? 'selected="selected"' : 'Selecciona un dia'}} value="{{$dia->id_dia}}">{{$dia->nombre_dia}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label style="margin: 3px" for="">Gerente de zona</label>
                        <select class="form-control" name="id_gerente_zona" id="" required>
                            <option value="">-Seleccione gerente-</option>
                            @foreach ($gerenteszonas as $gerentezona)
                            <option {{$visita->id_gerente_zona == $gerentezona->id ? 'selected="selected"' : 'Selecciona un gerente'}} value="{{$gerentezona->id}}">{{$gerentezona->nombre.' '.$gerentezona->ap_paterno.' '.$gerentezona->ap_materno}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label style="margin: 3px" for="">Promotor</label>
                        <select class="form-control" name="id_grupo_promotora" id="" required>
                            <option value="">-Seleccione promotor-</option>
                            @foreach ($promotoras as $promotor)
                            <option {{$visita->id_grupo_promotora == $promotor->id_grupo_promotoras ? 'selected="selected"' : 'Selecciona un promotor'}} value="{{$promotor->id_grupo_promotoras}}">{{$promotor->id_grupo_promotoras}} {{$promotor->nombre.' '.$promotor->ap_paterno.' '.$promotor->ap_materno}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" style="margin-top:32px" class="btn btn-primary">Guardar</button>
                    
                    </div>
            </div>
            <br><br><br>
        </form>
        </div>
    </div>

@stop
@section('page-script')
<script>
    

    window.onload = function agregar_boton_atras(){
  
      document.getElementById('Atras').innerHTML='<a href="{{url('rutas/visitas/visitas-porgrupo/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
    
  }
</script>
@stop