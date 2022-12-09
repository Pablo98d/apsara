@extends('layouts.master')
@section('title', 'Resultados de búsqueda')
@section('parentPageTitle', 'Búsqueda')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
  <div class="col-md-12">
    @if ( session('Guardar') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('Guardar') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
    @endif
      <!--<a class="btn btn-success" type="submit" href="{{ route('abonos.create') }}" title="Nuevo Usuario">Nuevo Registro</a>-->
  </div>
  <div class="body">
      {{-- <button type="submit" onclick="imprimit_clientes()">Imprimir</button> --}}
      <div class="estilo-tabla">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
            <thead>
                <tr>
                    <th><small>No</small></th>
                    <th><small>Usuario</small></th>
                    <th><small>Nombre cliente</small></th>
                    <th><small>Grupo</small></th>
                    <th><small>Tipo usuario</small></th>
                </tr>
            </thead>
        <form action="{{url('pdf_clientes')}}" id="formimprimir" method="post">
            @csrf
            <tbody>
                @if (!empty($resultado_cliente))
                        @foreach ($resultado_cliente as $resultado_c)
                        <tr>
                            <td><small><input type="hidden" name="id_usuario[]" value="{{$resultado_c->id}}">{{$resultado_c->id}}</small></td>
                            <td><small><input type="hidden" name="nombre_usuario[]" value="{{$resultado_c->nombre_usuario}}">{{$resultado_c->nombre_usuario}}</small></td>
                            <td><small>
                                @php
                                    $datos_usuario=DB::table('tbl_datos_usuario')
                                    ->select('tbl_datos_usuario.*')
                                    ->where('id_usuario','=',$resultado_c->id)
                                    ->get();
                                @endphp
                                
                                @if (count($datos_usuario)==0)
                                    <input type="hidden" name="datos_usuario[]" value="Sin datos de usuario"> 
                                    <span class="badge badge-warning">Sin datos de usuario</span>
                                @else
                                    <input type="hidden" name="datos_usuario[]" value="{{$datos_usuario->last()->nombre}} {{$datos_usuario->last()->ap_paterno}} {{$datos_usuario->last()->ap_materno}}"> 
                                    {{$datos_usuario->last()->nombre}} {{$datos_usuario->last()->ap_paterno}} {{$datos_usuario->last()->ap_materno}}
                                @endif
                                
                            </small>
                            </td>
                            <td><small>
                            @php
                                $detalles_prestamo=DB::table('tbl_prestamos')
                                    ->join('tbl_usuarios','tbl_prestamos.id_promotora','=','tbl_usuarios.id')
                                    ->join('tbl_grupos','tbl_prestamos.id_grupo','=','tbl_grupos.id_grupo')
                                    ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','=','tbl_status_prestamo.id_status_prestamo')
                                    ->join('tbl_zona','tbl_grupos.IdZona','=','tbl_zona.IdZona')
                                    ->join('tbl_plaza','tbl_zona.IdPlaza','=','tbl_plaza.IdPlaza')
                                    ->select('tbl_prestamos.*','tbl_grupos.*','tbl_zona.*','tbl_plaza.*','tbl_status_prestamo.status_prestamo as nstatus')
                                    ->where('tbl_prestamos.id_usuario','=',$resultado_c->id)
                                    ->distinct()
                                    ->orderBy('tbl_prestamos.id_prestamo','ASC')
                                    ->get();
                                    
                            @endphp
                            
                            @if (count($detalles_prestamo)==0)
                                <input type="hidden" name="detalle_prestamo[]" value="Sin grupo/Sin préstamo">
                                <span class="badge badge-warning">Sin grupo</span>
                                {{$resultado_c->id}}
                            @else
                                <input type="hidden" name="detalle_prestamo[]" value="#{{$detalles_prestamo->last()->id_prestamo}} / ${{number_format($detalles_prestamo->last()->cantidad,2)}} / {{$detalles_prestamo->last()->nstatus}}">
                                <span title="Nombre de grupo">
                                        <a href="{{url('prestamo/buscar-cliente/'.$detalles_prestamo->last()->IdZona.'/'.$detalles_prestamo->last()->IdPlaza.'/'.$detalles_prestamo->last()->id_grupo)}}">{{$detalles_prestamo->last()->grupo}}</a>
                                        / #{{$detalles_prestamo->last()->id_prestamo}} / ${{number_format($detalles_prestamo->last()->cantidad,2)}} / {{$detalles_prestamo->last()->nstatus}}
                                        <br>
                                        
                                        
                                </span>
                            @endif
                            </small></td>
                            <td><small>
                                @php
                                    $tipos_usuario=DB::table('tbl_tipo_usuario')
                                        ->select('tbl_tipo_usuario.*')
                                        ->where('tbl_tipo_usuario.id_tipo_usuario','=',$resultado_c->id_tipo_usuario)
                                        ->distinct()
                                        ->get();
                                @endphp
                                
                                @if (count($tipos_usuario)==0)
                                    <input type="hidden" name="tipo_usuario[]" value="Sin tipo de usuario">
                                    <span class="badge badge-warning">Sin tipo de usuario</span>
                                @else
                                    <input type="hidden" name="tipo_usuario[]" value="{{$tipos_usuario->last()->nombre}}">
                                    {{$tipos_usuario->last()->nombre}}
                                @endif
                                </small></td>
                            
                        </tr>
                        @endforeach
                @endif
                @if (!empty($resultado_ap_paterno))
                    @foreach ($resultado_ap_paterno as $resultado_ap_p)
                    <tr>
                        <td><small>{{$resultado_ap_p->id}}</small></td>
                        <td><small>{{$resultado_ap_p->nombre_usuario}}</small></td>
                        <td><small>
                            @php
                                $datos_usuario=DB::table('tbl_datos_usuario')
                                ->select('tbl_datos_usuario.*')
                                ->where('id_usuario','=',$resultado_ap_p->id)
                                ->get();
                            @endphp
                            
                            @if (count($datos_usuario)==0)
                                <span class="badge badge-warning">Sin datos de usuario</span>
                                {{$resultado_ap_p->id}}
                            @else
                                @foreach ($datos_usuario as $dato_usuario)
                                    {{$dato_usuario->nombre}} {{$dato_usuario->ap_paterno}} {{$dato_usuario->ap_materno}}
                                @endforeach
                            @endif
                            
                        </small>
                        </td>
                        <td><small>
                            @php
                                $detalles_prestamo=DB::table('tbl_prestamos')
                                    ->join('tbl_usuarios','tbl_prestamos.id_promotora','=','tbl_usuarios.id')
                                    ->join('tbl_grupos','tbl_prestamos.id_grupo','=','tbl_grupos.id_grupo')
                                    ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','=','tbl_status_prestamo.id_status_prestamo')
                                    ->join('tbl_zona','tbl_grupos.IdZona','=','tbl_zona.IdZona')
                                    ->join('tbl_plaza','tbl_zona.IdPlaza','=','tbl_plaza.IdPlaza')
                                    ->select('tbl_prestamos.*','tbl_grupos.*','tbl_zona.*','tbl_plaza.*','tbl_status_prestamo.status_prestamo as nstatus')
                                    ->where('tbl_prestamos.id_usuario','=',$resultado_ap_p->id)
                                    ->distinct()
                                    ->orderBy('tbl_prestamos.id_prestamo','ASC')
                                    ->get();
                                    
                            @endphp
                            
                            @if (count($detalles_prestamo)==0)
                                <span class="badge badge-warning">Sin grupo</span>
                            @else
                                <span title="Nombre de grupo">
                                        <a href="{{url('prestamo/buscar-cliente/'.$detalles_prestamo->last()->IdZona.'/'.$detalles_prestamo->last()->IdPlaza.'/'.$detalles_prestamo->last()->id_grupo)}}">{{$detalles_prestamo->last()->grupo}}</a>
                                        {{$detalles_prestamo->last()->id_prestamo}} {{$detalles_prestamo->last()->nstatus}}
                                        <br>
                                        
                                        
                                </span>
                            @endif
                            </small></td>
                        <td><small>
                            @php
                                $tipos_usuario=DB::table('tbl_tipo_usuario')
                                    ->select('tbl_tipo_usuario.*')
                                    ->where('tbl_tipo_usuario.id_tipo_usuario','=',$resultado_ap_p->id_tipo_usuario)
                                    ->distinct()
                                    ->get();
                            @endphp
                            
                            @if (count($tipos_usuario)==0)
                                <span class="badge badge-warning">Sin tipo de usuario</span>
                            @else
                                @foreach ($tipos_usuario as $tipo_usuario)
                                    
                                    {{$tipo_usuario->nombre}}
                                @endforeach
                            @endif
                            </small></td>
                        
                    </tr>
                    @endforeach
                @endif
                @if (!empty($resultado_ap_materno))
                    @foreach ($resultado_ap_materno as $resultado_ap_m)
                    <tr>
                        <td><small>{{$resultado_ap_m->id}}</small></td>
                        <td><small>{{$resultado_ap_m->nombre_usuario}}</small></td>
                        <td><small>
                            @php
                                $datos_usuario=DB::table('tbl_datos_usuario')
                                ->select('tbl_datos_usuario.*')
                                ->where('id_usuario','=',$resultado_ap_m->id)
                                ->get();
                            @endphp
                            
                            @if (count($datos_usuario)==0)
                                <span class="badge badge-warning">Sin datos de usuario</span>
                                {{$resultado_ap_m->id}}
                            @else
                                @foreach ($datos_usuario as $dato_usuario)
                                    {{$dato_usuario->nombre}} {{$dato_usuario->ap_paterno}} {{$dato_usuario->ap_materno}}
                                @endforeach
                            @endif
                            
                        </small>
                        </td>
                        <td><small>
                            @php
                                $detalles_prestamo=DB::table('tbl_prestamos')
                                    ->join('tbl_usuarios','tbl_prestamos.id_promotora','=','tbl_usuarios.id')
                                    ->join('tbl_grupos','tbl_prestamos.id_grupo','=','tbl_grupos.id_grupo')
                                    ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','=','tbl_status_prestamo.id_status_prestamo')
                                    ->join('tbl_zona','tbl_grupos.IdZona','=','tbl_zona.IdZona')
                                    ->join('tbl_plaza','tbl_zona.IdPlaza','=','tbl_plaza.IdPlaza')
                                    ->select('tbl_prestamos.*','tbl_grupos.*','tbl_zona.*','tbl_plaza.*','tbl_status_prestamo.status_prestamo as nstatus')
                                    ->where('tbl_prestamos.id_usuario','=',$resultado_ap_m->id)
                                    ->distinct()
                                    ->orderBy('tbl_prestamos.id_prestamo','ASC')
                                    ->get();
                            @endphp
                            
                            @if (count($detalles_prestamo)==0)
                                <span class="badge badge-warning">Sin grupo</span>
                            @else
                                
                                    
                                    <span title="Nombre de grupo">
                                        <a href="{{url('prestamo/buscar-cliente/'.$detalles_prestamo->last()->IdZona.'/'.$detalles_prestamo->last()->IdPlaza.'/'.$detalles_prestamo->last()->id_grupo)}}">{{$detalles_prestamo->last()->grupo}}</a>
                                        {{$detalles_prestamo->last()->id_prestamo}} {{$detalles_prestamo->last()->nstatus}}
                                        <br>
                                        
                                        
                                    </span>
                            @endif
                            </small></td>
                        <td><small>
                            @php
                                $tipos_usuario=DB::table('tbl_tipo_usuario')
                                    ->select('tbl_tipo_usuario.*')
                                    ->where('tbl_tipo_usuario.id_tipo_usuario','=',$resultado_ap_m->id_tipo_usuario)
                                    ->distinct()
                                    ->get();
                            @endphp
                            
                            @if (count($tipos_usuario)==0)
                                <span class="badge badge-warning">Sin tipo de usuario</span>
                            @else
                                @foreach ($tipos_usuario as $tipo_usuario)
                                    
                                    {{$tipo_usuario->nombre}}
                                @endforeach
                            @endif
                            </small></td>
                        
                    </tr>
                    @endforeach
                @endif
                @if (!empty($datelle_prestamo_estatus))
                    @foreach ($datelle_prestamo_estatus as $datelle_prestamo_e)
                    <tr>
                        <td><small><input type="hidden" name="id_usuario[]" value="{{$datelle_prestamo_e->id}}">{{$datelle_prestamo_e->id}}</small></td>
                        <td><small><input type="hidden" name="nombre_usuario[]" value="{{$datelle_prestamo_e->nombre_usuario}}">{{$datelle_prestamo_e->nombre_usuario}}</small></td>
                        <td><small>
                            @php
                                $datos_usuario=DB::table('tbl_datos_usuario')
                                ->select('tbl_datos_usuario.*')
                                ->where('id_usuario','=',$datelle_prestamo_e->id)
                                ->get();
                            @endphp
                            
                            @if (count($datos_usuario)==0)
                                <input type="hidden" name="datos_usuario[]" value="Sin datos de usuario"> 
                                <span class="badge badge-warning">Sin datos de usuario</span>
                            
                            @else
                                <input type="hidden" name="datos_usuario[]" value="{{$datos_usuario->last()->nombre}} {{$datos_usuario->last()->ap_paterno}} {{$datos_usuario->last()->ap_materno}}"> 
                                {{$datos_usuario->last()->nombre}} {{$datos_usuario->last()->ap_paterno}} {{$datos_usuario->last()->ap_materno}}
                            @endif
                            
                        </small>
                        </td>
                        <td><small>
                            @php
                                $detalles_prestamo=DB::table('tbl_prestamos')
                                    ->join('tbl_usuarios','tbl_prestamos.id_promotora','=','tbl_usuarios.id')
                                    ->join('tbl_grupos','tbl_prestamos.id_grupo','=','tbl_grupos.id_grupo')
                                    ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','=','tbl_status_prestamo.id_status_prestamo')
                                    ->join('tbl_zona','tbl_grupos.IdZona','=','tbl_zona.IdZona')
                                    ->join('tbl_plaza','tbl_zona.IdPlaza','=','tbl_plaza.IdPlaza')
                                    ->select('tbl_prestamos.*','tbl_grupos.*','tbl_zona.*','tbl_plaza.*','tbl_status_prestamo.status_prestamo as nstatus')
                                    ->where('tbl_prestamos.id_prestamo','=',$datelle_prestamo_e->id_prestamo)
                                    ->distinct()
                                    ->orderBy('tbl_prestamos.id_prestamo','ASC')
                                    ->get();
                            @endphp
                            
                            @if (count($detalles_prestamo)==0)
                                <input type="hidden" name="detalle_prestamo[]" value="Sin grupo/Sin préstamo">
                                <span class="badge badge-warning">Sin grupo/Sin préstamo</span>
                            @else
                                <input type="hidden" name="detalle_prestamo[]" value="#{{$detalles_prestamo->last()->id_prestamo}} / ${{number_format($detalles_prestamo->last()->cantidad,2)}} / {{$detalles_prestamo->last()->nstatus}}">
                                <span title="Nombre de grupo">
                                    <a href="{{url('prestamo/buscar-cliente/'.$detalles_prestamo->last()->IdZona.'/'.$detalles_prestamo->last()->IdPlaza.'/'.$detalles_prestamo->last()->id_grupo)}}">{{$detalles_prestamo->last()->grupo}}</a>
                                    / #{{$detalles_prestamo->last()->id_prestamo}} / ${{number_format($detalles_prestamo->last()->cantidad,2)}} / {{$detalles_prestamo->last()->nstatus}}
                                    <br>
                                </span>
                            @endif
                            </small></td>
                        <td><small>
                            @php
                                $tipos_usuario=DB::table('tbl_tipo_usuario')
                                    ->select('tbl_tipo_usuario.*')
                                    ->where('tbl_tipo_usuario.id_tipo_usuario','=',$datelle_prestamo_e->id_tipo_usuario)
                                    ->distinct()
                                    ->get();
                            @endphp
                            
                            @if (count($tipos_usuario)==0)
                                <input type="hidden" name="tipo_usuario[]" value="{{$tipos_usuario->last()->nombre}}">
                                <span class="badge badge-warning">Sin tipo de usuario</span>
                            @else
                                <input type="hidden" name="tipo_usuario[]" value="{{$tipos_usuario->last()->nombre}}">
                                {{$tipos_usuario->last()->nombre}}
                            @endif
                            </small></td>
                        
                    </tr>
                    @endforeach
                @endif
            
            </tbody>
        </form>
        </table>
      </div>
    </div>
@stop
@section('page-script')
<script>
    function imprimit_clientes()
    {
        document.getElementById("formimprimir").submit();
    }
</script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop