@extends('layouts.master')
@section('title', 'Admin carrousel app')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>

@stop
@section('content')
<div class="row clearfix">
    {{-- Aqui empieza lo de accesos directo --}}
    <div class="col-md-12">

        <hr style="padding: 0; margin:0; margin-bottom:4px;">

    </div>
    <div class="col-md-12">
        @if ( session('status') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"></span>
                </button>
            </div>
        @endif
        @if ( session('danger') )
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
        </div>
    @endif
    </div>
    <div class="col-md-12">
                @if (count($imagenes_carrousel)==0)
                    
                @else
                    @php
                        $contar_c=0;
                    @endphp
                    @foreach ($imagenes_carrousel as $imagenes_carrousel)
                        
                        @if ($imagenes_carrousel->tipo_imagen==1)
                            <div class="row mb-2">
                                <div class="col-md-3">  </div>
                                <div class="col-md-6">
                                    <b>
                                        Banner principal
                                    </b>
                                    
                                    <div class="row mt-4">
                                        <div class="col-md-12 mb-3">
                                            <form action="{{url('actualizar-carrousel')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" value="{{$imagenes_carrousel->id}}" name="id_c">
                                                <input type="hidden" value="texto" name="tipo_actualizar">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" name="titulo" id="" value="{{$imagenes_carrousel->titulo}}">
                                                    </div>
                                                    <div class="col-md-12 mb-4">
                                                        @if ($imagenes_carrousel->habilitar_pdf==0)
                                                            <input type="checkbox" style="width: 15px; height:15px;"  id="habilitar_contenido" name="habilitar_pdf">
                                                            
                                                        @elseif($imagenes_carrousel->habilitar_pdf==1)
                                                            <input type="checkbox" style="width: 15px; height:15px;" checked id="habilitar_contenido" name="habilitar_pdf">
                                                            
                                                        @endif
                                                        <label for="habilitar_contenido" style="cursor: pointer;margin-top: 15px;">Contenido</label>
                                                    
                                                        <button type="submit" class="btn btn-primary btn-sm" style="float: right; margin-top: 15px;"onclick="return confirm('¿Estas seguro de cambiar el titulo y/o habilitar contenido?')">Guardar cambios de titulo</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form action="{{url('actualizar-carrousel')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" value="{{$imagenes_carrousel->id}}" name="id_c">
                                                <input type="hidden" value="{{$imagenes_carrousel->tipo_imagen}}" name="tipo_imagen">
                                                <input type="hidden" value="img" name="tipo_actualizar">
                                                <img src="https://laferiecita.com/{{$imagenes_carrousel->path_img}}" width="110px" alt=""><br>
                                                <input type="file" style="font-size: 10px;margin-top: 5px;" name="path_img" id="path_img">
                                                <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 5px;"onclick="return confirm('¿Estas seguro de cambiar la imagen?')">Guardar imagen</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form action="{{url('actualizar-carrousel')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" value="{{$imagenes_carrousel->id}}" name="id_c">
                                                <input type="hidden" value="pdf" name="tipo_actualizar">
                                                <a target="_blanck" href="https://laferiecita.com/{{$imagenes_carrousel->path_pdf}}">
                                                    <img src="icono/pdf_icono.png" width="60px" alt="">
                                                </a>
                                                <input type="file" style="font-size: 10px;margin-top: 5px;" name="path_pdf" id="path_pdf">
                                                <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 3px;" onclick="return confirm('¿Estas seguro de cambiar el archivo?')">Guardar archivo</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <hr style="border: 2px solid gray">
                                </div>
                            </div>
                        @else
                            @php
                                $contar_c+=1;
                            @endphp
                            <div class="row mb-2" >
                                <div class="col-md-3">  </div>
                                <div class="col-md-6">
                                    <b>
                                        Carrousel {{$contar_c}}
                                    </b>
                                    <div class="row mt-4">
                                        <div class="col-md-12 mb-3">
                                            <form action="{{url('actualizar-carrousel')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" value="{{$imagenes_carrousel->id}}" name="id_c">
                                                <input type="hidden" value="texto" name="tipo_actualizar">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" name="titulo" id="" value="{{$imagenes_carrousel->titulo}}">
                                                    </div>
                                                    <div class="col-md-12 mb-4">
                                                        @if ($imagenes_carrousel->habilitar_pdf==0)
                                                            <input type="checkbox" style="width: 15px; height:15px;"  id="habilitar_contenido{{$imagenes_carrousel->id}}" name="habilitar_pdf">
                                                            
                                                        @elseif($imagenes_carrousel->habilitar_pdf==1)
                                                            <input type="checkbox" style="width: 15px; height:15px;" checked id="habilitar_contenido{{$imagenes_carrousel->id}}" name="habilitar_pdf">
                                                            
                                                        @endif
                                                        <label for="habilitar_contenido{{$imagenes_carrousel->id}}" style="cursor: pointer;margin-top: 15px;">Contenido</label>
                                                    
                                                        <button type="submit" class="btn btn-primary btn-sm" style="float: right;margin-top: 15px;"onclick="return confirm('¿Estas seguro de cambiar el titulo y/o habilitar contenido?')">Guardar cambios de titulo</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form action="{{url('actualizar-carrousel')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" value="{{$imagenes_carrousel->id}}" name="id_c">
                                                <input type="hidden" value="{{$imagenes_carrousel->tipo_imagen}}" name="tipo_imagen">
                                                <input type="hidden" value="img" name="tipo_actualizar">
                                                <img src="https://laferiecita.com/{{$imagenes_carrousel->path_img}}" width="110px" alt=""><br>
                                                <input type="file" style="font-size: 10px;margin-top: 5px;" name="path_img" id="path_img">
                                                <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 3px;"onclick="return confirm('¿Estas seguro de cambiar la imagen?')">Guardar imagen</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form action="{{url('actualizar-carrousel')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" value="{{$imagenes_carrousel->id}}" name="id_c">
                                                    <input type="hidden" value="pdf" name="tipo_actualizar">
                                                <a target="_blanck" href="https://laferiecita.com/{{$imagenes_carrousel->path_pdf}}">
                                                    <img src="icono/pdf_icono.png" width="60px" alt="">
                                                </a>
                                                <input type="file" style="font-size: 10px;margin-top: 5px;" name="path_pdf" id="path_pdf">
                                                <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 3px;" onclick="return confirm('¿Estas seguro de cambiar el archivo?')">Guardar archivo</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <hr style="border: 2px solid gray">
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
    </div>
    

    
</div>
@stop

