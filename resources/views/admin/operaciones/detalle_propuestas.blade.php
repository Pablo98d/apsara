@extends('layouts.master')
@section('title', 'Clientes - propuesta')
@section('parentPageTitle', 'Operaciones')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')
    <ul>
        @foreach ($propuesta as $prop)
        <li>{{$prop->id_usuario}}</li>
        <li>{{$prop->nombre}} {{$prop->ap_paterno}} {{$prop->ap_materno}}</li>
        <li>{{$prop->id_prestamo}}</li>
        <li>{{$prop->cantidad}}</li>
        <li>{{$prop->fecha_entrega_recurso}}</li>
        <li>{{$prop->id_negociacion}}</li>
        <li>{{$prop->cantidad_propuesta}}</li>
        <li>{{$prop->fecha_registro}}</li>
        <li>{{$prop->estatus}}</li>
        

            
        @endforeach
    </ul>
@stop
@section('page-script')

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop