@extends('layoutsP.master')
@section('title', 'La Feriecita')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
@stop
@section('content')
<div class="row clearfix">
    <div class="col-xl-4 col-lg-12 col-md-12">
        <div class="card mcard_3">
            <div class="body">
                <a href="javascript:void(0);"><img src="{{asset('assets/images/profile_av.jpg')}}" class="rounded-circle" alt="profile-image"></a>
                <h4 class="m-t-10">{{ auth()->user()->nombre_usuario}}</h4>
                <div class="row">
                    <div class="col-12 mb-10">
                        <div class="form-group">
                            <label for="foto" class="btn btn-primary"><b> Cambiar foto de perfil</b></label>
                            <input type="file" class="form-control" id="foto" value="cambiar foto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-12 col-md-12">
        <div class="row clearfix">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <form action="{{ url('promotora/promotoramiperfil/'.auth()->user()->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nombre_usuario">Nombre completo</label>
                                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" placeholder="Tomás Carreón Casarrubias" value="{{ auth()->user()->nombre_usuario}}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="id_tipo_usuario">Tipo de usuario</label>
                                    <input type="text" id="id_tipo_usuario" class="form-control" placeholder="Administrador" value="{{ auth()->user()->id_tipo_usuario}}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input type="text" id="email" name="email" class="form-control" value="{{ auth()->user()->email}}">
                                </div>
                            </div>              
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="text" id="password" name="password" class="form-control" value="{{ auth()->user()->password}}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <a type="reset" class="btn btn-light btn-lg" href="{{ route('homepromotora') }}">Cancelar</a>
                                <input type="submit" class="btn btn-primary btn-lg" value="Actualizar datos">
                            </div>
                        </form>
                    </div>
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