@extends('layoutsAnalista.master')
@section('title', 'La Feriecita')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
@stop
@section('content')
<hr>
<div class="row clearfix">
    <div class="col-xl-4 col-lg-12 col-md-12">
        <div class="card mcard_3">
            <div class="body">
                <a href="javascript:void(0);"><img width="150px" src="{{asset('assets/images/useradmin.jpg')}}" class="rounded-circle" alt="profile-image"></a>
                <h4 class="m-t-10">{{ auth()->user()->nombre_usuario}}</h4>
                <div class="row">
                    <div class="col-12 mb-10">
                        <label class="m-t-10">Analista</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-12 col-md-12">
        <div class="row clearfix">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="body" style="color:#002fc2; font-weight:600;">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nombre_usuario">Nombre usuario</label>
                                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" placeholder="Tomás Carreón Casarrubias" value="{{ auth()->user()->nombre_usuario}}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input type="text" id="email" name="email" class="form-control" placeholder="tom.carreon_96@hotmail.com" value="{{ auth()->user()->email}}" disabled>
                                </div>
                            </div> 
                    </div><br>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/sparkline.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/c3.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/index.js')}}"></script>
@stop