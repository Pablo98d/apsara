@extends('layouts.master')
@section('title', 'Estudios socioeconómicos')
@section('parentPageTitle', 'Operaciones')
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<style>
    .estilo{
        background: red; 
        color: #fff; 
        padding-left: 7px; 
        padding-right: 7px; 
        padding-bottom: 3px; 
        padding-top: 3px; 
        margin-left: 3px; 
        border-radius: 20px 20px 20px 0;
    }
</style>
@stop
@section('content')
<div class="row">
    {{-- <div class="col-md-12">
        <a href="" class=""><-Atras</a>
    </div> --}}
    {{-- <div class="col-md-4"><small for="">Región</small><input class="form-control" type="text" readonly value="{{$region->Plaza}}"></div>
    <div class="col-md-4"><small for="">Zona</small><a href="{{url('operacion/buscar-grupo/'.$zona->IdZona.'/'.$region->IdPlaza)}}" class="form-control" title="Clic para ir a los grupos de esta zona">{{$zona->Zona}}</a></div> --}}
    <div class="col-md-4"><small for="">Grupo</small>
        <form id="fmr_grupo" action="{{url('operacion/socio/admin-operaciones-socio_eco/'.$region->IdPlaza.'/'.$zona->IdZona.'/0')}}" method="get">
            <select name="id_grupo" class="form-control show-tick ms select2" id="" data-placeholder="Select" onchange="buscar_grupo()">
                <option value="">--Seleccione un grupo--</option>
                @foreach ($grupos as $grup)
                    <option value="{{$grup->id_grupo}}" 
                        {{$grupo->id_grupo==$grup->id_grupo ? 'selected' : 'Seleccione un grupo'}}
                        >{{$grup->grupo}}</option>
                @endforeach
            </select>
        
    </div>
    
    <div class="col-md-8 mt-3 mb-4">
        <div class="card-header d-flex">
            @php
                $soc_p = DB::table('v_socioeco_pendiente')
                ->select(DB::raw('count(*) as total_soc_p'))
                ->where('v_socioeco_pendiente.id_grupo','=',$grupo->id_grupo)
                ->get();

                $soc_ep = DB::table('v_socioeco_en_proceso')
                ->select(DB::raw('count(*) as total_soc_ep'))
                ->where('v_socioeco_en_proceso.id_grupo','=',$grupo->id_grupo)
                ->get();

                $soc_co = DB::table('v_socioeco_completado')
                ->select(DB::raw('count(*) as total_soc_co'))
                ->where('v_socioeco_completado.id_grupo','=',$grupo->id_grupo)
                ->get();

                $soc_a = DB::table('v_socioeco_aprobado')
                ->select(DB::raw('count(*) as total_soc_a'))
                ->where('v_socioeco_aprobado.id_grupo','=',$grupo->id_grupo)
                ->get();

                $soc_n = DB::table('v_socioeco_negado')
                ->select(DB::raw('count(*) as total_soc_n'))
                ->where('v_socioeco_negado.id_grupo','=',$grupo->id_grupo)
                ->get();
                

            @endphp
            <form id="form_estatus_prospecto_p" action="{{url('operacion/socio/admin-operaciones-socio_eco/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="get">
                <input name="id_estatus_p" type="hidden" value="1">
                @if ($id_status==1)
                    <button class="btn btn-dark ml-2 mt-3" onclick="buscarstatus_p()">Pendientes <span class="estilo">{{$soc_p[0]->total_soc_p}}</span></button>
                @else
                    <button class="btn btn-warning ml-2 mt-3" onclick="buscarstatus_p()">Pendientes <span class="estilo">{{$soc_p[0]->total_soc_p}}</span></button>
                @endif
            </form>
            {{-- <form id="form_estatus_prospecto_pr" action="{{url('operacion/socio/admin-operaciones-socio_eco/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="get">
                <input name="id_estatus_p" type="hidden" value="2">
                @if ($id_status==2)
                    <button class="btn btn-dark ml-2 mt-3" onclick="buscarstatus_pr()">En proceso <span class="estilo">{{$soc_ep[0]->total_soc_ep}}</span></button>
                @else
                    <button class="btn btn-info ml-2 mt-3" onclick="buscarstatus_pr()">En proceso <span class="estilo">{{$soc_ep[0]->total_soc_ep}}</span></button>
                @endif
            </form> --}}
            <form id="form_estatus_prospecto_co" action="{{url('operacion/socio/admin-operaciones-socio_eco/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="get">
                <input name="id_estatus_p" type="hidden" value="3">
                @if ($id_status==3)
                    <button class="btn btn-dark ml-2 mt-3" onclick="buscarstatus_co()">Completados <span class="estilo">{{$soc_co[0]->total_soc_co}}</span></button>
                @else
                    <button class="btn btn-primary ml-2 mt-3" onclick="buscarstatus_co()">Completados <span class="estilo">{{$soc_co[0]->total_soc_co}}</span></button>
                @endif
            </form>

            <form id="form_estatus_prospecto_a" action="{{url('operacion/socio/admin-operaciones-socio_eco/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="get">
                <input name="id_estatus_p" type="hidden" value="10">
                @if ($id_status==10)
                    <button class="btn btn-dark ml-1 mt-3"  onclick="buscarstatus_a()" >Aprobados <span class="estilo">{{$soc_a[0]->total_soc_a}}</span></button>
                @else
                    <button class="btn btn-success ml-1 mt-3"  onclick="buscarstatus_a()" >Aprobados <span class="estilo">{{$soc_a[0]->total_soc_a}}</span></button>
                @endif
            </form>
            <form id="form_estatus_prospecto_n" action="{{url('operacion/socio/admin-operaciones-socio_eco/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="get">
                <input name="id_estatus_p" type="hidden" value="11">
                @if ($id_status==11)
                    <button class="btn btn-dark ml-1 mt-3" onclick="buscarstatus_n()">Negados <span class="estilo">{{$soc_n[0]->total_soc_n}}</span></button>
                @else
                    <button class="btn btn-danger ml-1 mt-3" onclick="buscarstatus_n()">Negados <span class="estilo">{{$soc_n[0]->total_soc_n}}</span></button>
                @endif
                
            </form>
        </div>
    </div>
</form>
</div>
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
                                <form action="{{url('create-socioeconomico')}}" method="GET">
                                    <input name="id_socioeconomico" type="hidden" value="{{$socioeconomico->id_socio_economico}}">
                                    {{-- <span class="">Info</span> --}}
                                    <button type="submit" class="badge badge-pill badge-primary">Revisar</button>
                                </form>
                            @elseif($id_status==10)
                                <a href="#" onclick="return alert('¡Ya puede entregar el préstamo->dirigese en la parte de préstamos y en el boton de préstamos aprobados!')">Entregar préstamo</a>
                            @elseif($id_status==11)
                            <form action="{{url('create-socioeconomico')}}" method="GET">
                                <input name="id_socioeconomico" type="hidden" value="{{$socioeconomico->id_socio_economico}}">
                                {{-- <span class="">Info</span> --}}
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
    <br><br>
@endsection
@section('page-script')
<script>
    

    window.onload = function agregar_boton_atras(){
  
      document.getElementById('Atras').innerHTML='<a href="{{url('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
    
  }
</script>
<script>
    function buscarstatus_p()
    {
        document.getElementById("form_estatus_prospecto_p").submit();
    }
    function buscarstatus_pr()
    {
        document.getElementById("form_estatus_prospecto_pr").submit();
    }
    function buscarstatus_co()
    {
        document.getElementById("form_estatus_prospecto_co").submit();
    }
    function buscarstatus_er()
    {
        document.getElementById("form_estatus_prospecto_er").submit();
    }


    function buscarstatus_a()
    {
        document.getElementById("form_estatus_prospecto_a").submit();
    }
    function buscarstatus_n()
    {
        document.getElementById("form_estatus_prospecto_n").submit();
    }

    function buscar_grupo()
    {
        document.getElementById("fmr_grupo").submit();
    }
    
</script>
    <script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop
