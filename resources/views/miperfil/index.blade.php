@extends('layouts.master')
@section('title', 'Mi perfil')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />

@stop
@section('content')
<hr>
<div class="row clearfix">
    @if ( session('status') )
        <div class="col-md-12">
            <center>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
            </center>
        </div>
    @endif
    @if ( session('error') )
        <div class="col-md-12">
            <center>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"></span>
                    </button>
                </div>
            </center>
                    
        </div>
    @endif
    <div class="row">
        @if (count($mis_datos)==0)
        <div class="col-md-12">
            <center>
                No se encontraron sus datos
            </center>
        </div>
        @else
            @foreach ($mis_datos as $mi_dato)
                <div class="col-xl-4 col-lg-12 col-md-12">
                    <div class="card mcard_3">
                        <div class="body">
                            @if ($mi_dato->foto_perfil==null)
                                
                                <img width="150px" src="{{asset('assets/images/useradmin.jpg')}}" class="rounded-circle" alt="profile-image">
                            @else
                                <img width="150px" src="{{$mi_dato->foto_perfil}}" class="rounded-circle" alt="profile-image">

                            @endif
                            <div style="text-align: center">
                                    <h4 style="padding: 0 !important; margin: 0 !important" >{{ auth()->user()->nombre_usuario}}  <label style="font-size: 15px">Administrador</label></h4>
                                    
                            </div>
                            <div class="row">
                                <form action="{{url('miperfil-actualizar')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-12 mb-10">
                                        <input type="file" style="font-size: 10px;" name="foto_perfil" id="fichero-tarifas" class="input-file" value="">
                                        <input type="submit" class="mt-2 btn" style="background: #3483fa; color: #fff" value="Actualizar foto">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12 col-md-12">
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="body row" style="color:#002fc2; font-weight:600;">
                                        
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nombre_usuario">Nombre usuario</label>
                                            <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" placeholder="Tomás Carreón Casarrubias" value="{{ $mi_dato->nombre_usuario}}" disabled>
                                        </div>
                                    </div>  
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="nombre_usuario">Nombre completo</label>
                                            <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" placeholder="Tomás Carreón Casarrubias" value="{{ $mi_dato->nombre}} {{ $mi_dato->ap_paterno}} {{ $mi_dato->ap_materno}}" disabled>
                                        </div>
                                    </div>    

                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Correo electrónico</label>
                                            <input type="text" id="email" name="email" class="form-control" placeholder="tom.carreon_96@hotmail.com" value="{{$mi_dato->email}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Teléfono casa</label>
                                            <input type="text" id="telefono" name="telefono" class="form-control" value="{{ $mi_dato->telefono_casa}}" disabled>
                                        </div>
                                    </div>   
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Teléfono celular</label>
                                            <input type="text" id="telefono" name="telefono" class="form-control" value="{{ $mi_dato->telefono_celular}}" disabled>
                                        </div>
                                    </div>
                                                                
                                            
                                </div><br>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
                            
    </div>
    
</div>
@stop

@section('page-script')

<script src="{{asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/sparkline.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/c3.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/index.js')}}"></script>
@stop