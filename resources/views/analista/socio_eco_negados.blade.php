@extends('layoutsAnalista.master')
@section('title', 'Socioeconómicos negados')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')

<div class="row">
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
                            @if($id_status==3)
                                <form action="{{url('crear-socioeco-analista')}}" method="GET">
                                    <input name="id_socioeconomico" type="hidden" value="{{$socioeconomico->id_socio_economico}}">
                                    <button type="submit" class="badge badge-pill badge-primary">Revisar</button>
                                </form>
                            @elseif($id_status==10)
                                <a href="#" onclick="return alert('¡Ya puede entregar el préstamo->dirigese en la parte de préstamos y en el boton de préstamos aprobados!')">Entregar préstamo</a>
                            @elseif($id_status==11)
                            <form action="{{url('crear-socioeco-analista')}}" method="GET">
                                <input name="id_socioeconomico" type="hidden" value="{{$socioeconomico->id_socio_economico}}">
                                <button type="submit" class="badge badge-pill badge-primary">Revisar</button>
                            </form>
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
<br><br>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop