@extends('layouts.master')
@section('title', 'Validaciones SMS')
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
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
                
                        <table>
                            <thead>
                                <th>#</th>
                                <th>Número cel.</th>
                                <th>Código</th>
                                <th>
                                    Validado
                                </th>
                            </thead>
                            <tbody>
                                @if (count($validaciones)==0)
                    
                                @else
                                    @foreach ($validaciones as $validacion)
                                        <tr>
                                            <td>{{$validacion->id_validacion}}</td>
                                            <td>{{$validacion->telefono}}</td>
                                            <td>{{$validacion->codigo_generado}}
                                                <div class="d-flex">
                                                    @if ($validacion->codigo_generado==null)
                                                    <p style="font-size: 11px;padding:1px 5px;margin-top: 7px; border-radius: 10px; width: 100px;">
                                                        <i>
                                                            Enviado
                                                        </i>
                                                    </p>
                                                    @else
                                                        
                                                    @endif
                                                    <form action="{{route('enviar_de_nuevo')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id_validacion" value="{{$validacion->id_validacion}}">
                                                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('¿Esta seguro de enviar de nuevo el código de validación?')">Enviar de nuevo</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($validacion->validado==0)
                                                    <center>
                                                        <div class="d-flex">
                                                            <p style="font-size: 11px;padding:1px 5px;margin-top: 7px; background: rgb(255, 187, 0);border-radius: 10px; width: 100px;">
                                                                <i>
                                                                    Pendiente
                                                                </i>
                                                            </p>
                                                            
                                                            <form action="{{route('validar_sms')}}" method="post">
                                                                @csrf
                                                                
                                                                <input type="hidden" name="codigo_generado" value="{{$validacion->codigo_generado}}">
                                                                <input type="hidden" name="id_validacion" value="{{$validacion->id_validacion}}">
                                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Esta seguro de validar el número?')">Validar</button>
                                                            </form>
                                                        </div>
                                                    </center>
                                                @elseif ($validacion->validado==1)
                                                    <center>
                                                        <p style="font-size: 11px;padding:1px 5px;background: rgb(29, 173, 0);color: #fff;border-radius: 10px; width: 100px;">
                                                            <i>
                                                                Validado
                                                            </i>
                                                        </p>
                                                    </center>
                                                @endif
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    
                @endif
    </div>
    

    
</div>
@stop

