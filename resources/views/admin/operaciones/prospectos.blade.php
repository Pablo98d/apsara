@extends('layouts.master')
@section('title', 'Prospectos')
@section('parentPageTitle', 'Operaciones')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
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
    {{-- <div class="col-md-4"><small for="">Región</small><a href="{{url('operacion/buscar_prestamos1?id_region='.$region->IdPlaza)}}" class="form-control" title="Clic para ir a las zonas de esta región">{{$region->Plaza}}</a></div>
    <div class="col-md-4"><small for="">Zona</small> <a href="{{url('operacion/buscar-grupo/'.$zona->IdZona.'/'.$region->IdPlaza)}}" class="form-control" title="Clic para ir a los grupos de esta zona">{{$zona->Zona}}</a></div> --}}
    <div class="col-md-6"><small for="">Grupo</small>
        <form id="fmr_grupo" action="{{url('operacion/prospecto/admin-operaciones-prospectos/'.$region->IdPlaza.'/'.$zona->IdZona.'/0')}}" method="get">
            <select name="id_grupo" class="form-control show-tick ms select2" id="" data-placeholder="Select" onchange="buscar_grupo()">
                {{-- <option value="">--Seleccione un grupo--</option> --}}
                @foreach ($grupos as $grup)
                    <option value="{{$grup->id_grupo}}" 
                        {{$grupo->id_grupo==$grup->id_grupo ? 'selected' : 'Seleccione un grupo'}}
                        >{{$grup->grupo}}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="col-md-6 mt-3 mb-4">
        <center>
            <div class="card-header d-flex">
                
                <form id="form_estatus_prospecto_p" action="{{url('operacion/prospecto/admin-operaciones-prospectos/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="get">
                    @php
                        $pro_p = DB::table('v_prospectos_pendientes')
                        ->select(DB::raw('count(*) as total_pendiente'))
                        ->where('v_prospectos_pendientes.id_grupo','=',$grupo->id_grupo)
                        ->get();
                    @endphp
                    <input name="id_estatus_p" type="hidden" value="1">
                    @if ($id_status==1)
                        <button class="btn btn-dark ml-2 mt-3" onclick="buscarstatus_p()">Pendientes <span class="estilo">{{$pro_p[0]->total_pendiente}}</span></button>
                    @else
                        <button class="btn btn-warning ml-2 mt-3" onclick="buscarstatus_p()">Pendientes <span class="estilo">{{$pro_p[0]->total_pendiente}}</span> </button>
                    @endif
                </form>
                <form id="form_estatus_prospecto_a" action="{{url('operacion/prospecto/admin-operaciones-prospectos/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="get">
                    @php
                        $pro_a = DB::table('v_prospectos_aprobados')
                        ->select(DB::raw('count(*) as total_aprobado'))
                        ->where('v_prospectos_aprobados.id_grupo','=',$grupo->id_grupo)
                        ->get();
                    @endphp
                    <input name="id_estatus_p" type="hidden" value="10">
                    @if ($id_status==10)
                        <button class="btn btn-dark  ml-1 mt-3"  onclick="buscarstatus_a()" >Aprobados <span class="estilo">{{$pro_a[0]->total_aprobado}}</span></button>
                    @else
                        <button class="btn btn-success ml-1 mt-3"  onclick="buscarstatus_a()" >Aprobados <span class="estilo">{{$pro_a[0]->total_aprobado}}</span></button>
                    @endif
                </form>
                <form id="form_estatus_prospecto_n" action="{{url('operacion/prospecto/admin-operaciones-prospectos/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="get">
                    @php
                        $pro_n = DB::table('v_prospectos_negados')
                        ->select(DB::raw('count(*) as total_negado'))
                        ->where('v_prospectos_negados.id_grupo','=',$grupo->id_grupo)
                        ->get();
                    @endphp
                    <input name="id_estatus_p" type="hidden" value="11">
                    @if ($id_status==11)
                        <button class="btn btn-dark ml-1 mt-3" onclick="buscarstatus_n()">Negados <span class="estilo">{{$pro_n[0]->total_negado}}</span></button>
                    @else
                    
                        <button class="btn btn-danger ml-1 mt-3" onclick="buscarstatus_n()">Negados <span class="estilo">{{$pro_n[0]->total_negado}}</span></button>
                    @endif
                </form>
            </div>
        </center>
    </div>
</div>
    @if (empty($prospectos))
        <label for="">Seleccione un estatus del prospecto</label>         
    @else
    <table class="estilo-tabla">
        <thead>
           <tr>
               <th><small>No. Prospecto   </small></th>
               <th><small>Nombre completo </small></th>
               <th><small>Curp            </small></th>
               <th><small>Fecha nacimiento</small></th>
               <th><small>Edad            </small></th>
               <th><small>Ocupacion       </small></th>
               <th><small>Género          </small></th>
               <th><small>Estado civil    </small></th>
               <th><small>Grupo    </small></th>
               <th><small>Estatus prestamo</small></th>
           </tr>
        </thead>
        <tbody>  
            @foreach ($prospectos as $prospecto)
            <tr>
                <td><small>{{$prospecto->id}}              </small></td>
                <td><small>{{$prospecto->nombre.' '.$prospecto->ap_paterno.' '.$prospecto->ap_materno}} </small></td>
                <td><small>{{$prospecto->curp}}            </small></td>
                <td><small>{{$prospecto->fecha_nacimiento}}</small></td>
                <td><small>{{$prospecto->edad}}            </small></td>
                <td><small>{{$prospecto->ocupacion}}       </small></td>
                <td><small>{{$prospecto->genero}}          </small></td>
                <td><small>{{$prospecto->estado_civil}}    </small></td>
                <td><small>{{$prospecto->grupo}}          </small></td>
                <td>
                    @if ($prospecto->id_status_prestamo==1)
                            <form action="{{url('create-socioeconomico')}}" method="GET">
                                <input name="id_socioeconomico" type="hidden" value="{{$prospecto->id_socio_economico}}">
                                {{-- <span class="">Info</span> --}}
                                <button type="submit" class="badge badge-pill badge-warning">Pendiente</button>
                            </form>
                    @elseif ($prospecto->id_status_prestamo==10)
                            @php
                                $link_para_entrega_recurso=DB::table('tbl_plaza')
                                ->join('tbl_zona','tbl_plaza.IdPlaza','tbl_zona.IdPlaza')
                                ->join('tbl_grupos','tbl_zona.IdZona','tbl_grupos.IdZona')
                                ->select('tbl_plaza.IdPlaza','tbl_zona.IdZona','tbl_grupos.id_grupo')
                                ->where('tbl_grupos.id_grupo','=',$prospecto->id_grupo)
                                ->get();
                                // dd($link_para_entrega_recurso);
                            @endphp
                            @if (count($link_para_entrega_recurso)==0)
                                No se ecnotró link
                            @else
                            @foreach ($link_para_entrega_recurso as $link_para_entrega_r)
                                <a href="{{url('prestamo/buscar-cliente/prestamos-nuevos/'.$link_para_entrega_r->IdPlaza.'/'.$link_para_entrega_r->IdZona.'/'.$link_para_entrega_r->id_grupo)}}" class="badge badge-success">Aprobado</a>
                                
                            @endforeach
                            @endif
                    @elseif ($prospecto->id_status_prestamo==11)
                        <form action="{{url('create-socioeconomico')}}" method="GET">
                            <input name="id_socioeconomico" type="hidden" value="{{$prospecto->id_socio_economico}}">
                            {{-- <span class="">Info</span> --}}
                            <button type="submit" class="badge badge-pill badge-danger">Negado</button>
                        </form>
                        
                    @endif
                </td>
            </tr>
            @endforeach
        @endif  
        </tbody>
    </table>
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
    

    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop

