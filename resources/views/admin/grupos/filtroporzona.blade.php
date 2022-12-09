@extends('layouts.master')
@section('title', 'Grupos por zona')
@section('parentPageTitle', 'grupos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
<div class="body">
    <h5>
        Todos los grupos de la zona: {{$zona->Zona}}
    </h5>
    <div class="accordion" id="accordionExample">
        @foreach ($gruposfiltrado as $resutado)
            <div class="card mb-0">
            <div class="card-header" id="headingOne">
                <div class="row">
                    <div class="col-md-6">
                        <small>Grupo</small> - <small>Localidad</small> - <small>Municipio</small> - <small>Estado</small> <br>
                        {{$resutado->grupo}} {{$resutado->localidad}} {{$resutado->municipio}} {{$resutado->estado}}
                    </div>
                    
                    <div class="col-md-2">
                        <br>
                        <a href="#" type="button" data-toggle="collapse" data-target="#collapse{{$resutado->id_grupo}}" aria-expanded="true" aria-controls="">Ver mas</a>

                    </div>
                </div>
            </div>
            <div id="collapse{{$resutado->id_grupo}}" class="collapse" aria-labelledby="" data-parent="#accordionExample">
                <div class="card-body">

                </div>
            </div>
            </div>
        @endforeach

    </div>
</div>
@endsection