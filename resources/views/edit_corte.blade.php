@extends('layouts.master')
@section('title', 'La Feriecita')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>

@stop
@section('content')
<form action="{{url('corte-update/'.$fecha_corte->id_corte)}}" method="post">
    @csrf
<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-4">
        <label for="">Grupo</label><br>
        <select name="id_grupo" class="form-control show-tick ms select2" id="" data-placeholder="Select">
            <option value="">--seleccione un grupo--</option>
            @foreach ($grupos as $grupo)
                <option value="{{$grupo->id_grupo}}" {{$grupo->id_grupo==$fecha_corte->id_grupo ? 'selected="selected"' : 'Seleccione un grupo'}}>{{$grupo->grupo}}</option>
            @endforeach
        </select></div>
    <div class="col-md-4">
        <label for="">Día</label><br>
        <select name="nombre_dia" id="" class="form-control show-tick ms select2" data-placeholder="Select">
            @include('admin.dias_options',['val'=>$fecha_corte->nombre_dia])
        </select>
    </div>
    <div class="col-md-4">
        <label for="">Hora</label><br>
        <input type="text" name="hora" class="form-control" value="{{$fecha_corte->hora}}">
    </div>
    <div class="col-md-4"><br>
        <button type="submit" onclick="return confirm('¿Esta seguro de continuar?')" class="btn btn-primary">Actualizar datos</button>
    </div>
    
</div>
</form>

@stop
@section('page-script')
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop