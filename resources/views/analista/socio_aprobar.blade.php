@extends('layoutsAnalista.master')
@section('title', 'Análisis del socioeconómico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')

<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
    
    <div class="col-md-12">
        
        <div class="estilo-tabla">

            @if (empty($socioeconomicos))
                <label for="">Seleccione un estatus del prospecto</label>         
            @else
            <table class="js-basic-example">
                <thead>
                <tr>
                    <th><small>No.Socio.E.  </small></th>
                    <th><small>Nombre completo </small></th>
                    <th><small>Promotora            </small></th>
                    <th><small>Fecha registro</small></th>
                    <th><small>Operaciones           </small></th>
                </tr>
                </thead>
                <tbody>  
                    @foreach ($socioeconomicos as $socioeconomico)
                    <tr>
                        <td><small>{{$socioeconomico->id_socio_economico}}              </small></td>
                        <td><small>{{$socioeconomico->n_cliente.' '.$socioeconomico->p_cliente.' '.$socioeconomico->m_cliente}} </small></td>
                        <td><small>{{$socioeconomico->n_promotora.' '.$socioeconomico->p_promotora.' '.$socioeconomico->m_promotora}} </small></td>
                        <td><small>{{$socioeconomico->fecha_registro}}</small></td>
                        <td>
                            <center>
                                @if ($id_status==1)
                                    <form action="{{url('create-socioeconomico')}}" method="GET">
                                        <input name="id_socioeconomico" type="hidden" value="{{$socioeconomico->id_socio_economico}}">
                                        {{-- <span class="">Info</span> --}}
                                        <button type="submit" class="badge badge-pill badge-primary">Completar</button>
                                    </form>
                                @elseif($id_status==2)
                                    <form action="{{url('create-socioeconomico')}}" method="GET">
                                        <input name="id_socioeconomico" type="hidden" value="{{$socioeconomico->id_socio_economico}}">
                                        {{-- <span class="">Info</span> --}}
                                        <button type="submit" class="badge badge-pill badge-primary">Terminar</button>
                                    </form>
                                @elseif($id_status==3)
                                    <form action="{{url('crear-socioeco-analista')}}" method="GET">
                                        <input name="id_socioeconomico" type="hidden" value="{{$socioeconomico->id_socio_economico}}">
                                        {{-- <span class="">Info</span> --}}
                                        <button type="submit" class="badge badge-pill badge-primary">Revisar</button>
                                    </form>
                                @elseif($id_status==4)
                                    <a href="#">Terminar de revisar</a>
                                @endif
                            </center>
                            <a href="#"></a>
                        </td>
                    </tr>
                    @endforeach
                @endif  
                </tbody>
            </table>
        </div>
    </div>
</div>
<br><br>
@stop
@section('page-script')

@stop