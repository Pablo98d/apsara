@extends('layouts.master')
@section('title', 'Listado de abonos')
@section('parentPageTitle', 'Abonos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estilo_ayuda.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <hr>
            @if ( session('Guardar') )
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('Guardar') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"></span>
                    </button>
                </div>
            @endif
            @php
                $abonos_buscar = DB::table('tbl_grupos')
                ->join('tbl_zona','tbl_grupos.IdZona','tbl_zona.IdZona')
                ->join('tbl_plaza','tbl_zona.IdPlaza','tbl_plaza.IdPlaza')
                ->select('tbl_zona.IdZona','tbl_plaza.IdPlaza','tbl_grupos.id_grupo')
                ->where('tbl_grupos.id_grupo','=',$idgrupo)
                ->get();
            @endphp
            <a href="{{url('prestamo/buscar_prestamos1') }}" title="Registrar abonos y buscar desde regiones para agregar abono" class="btn btn-info"><i class="fas fa-search"> Buscar desde región</i></a>
            @foreach ($abonos_buscar as $abonos_b)
                <a href="{{url('prestamo/buscar-cliente/'.$abonos_b->IdZona.'/'.$abonos_b->IdPlaza.'/'.$abonos_b->id_grupo)}}"  class="btn btn-success" title="Buscar cliente desde el grupo seleccionado para agregar abono" ><i class="fas fa-search"> Buscar desde el grupo</i></a>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-2">
            
            <form class="" action="{{url('prestamo/abono/abonos-clientes')}}" method="GET" id="formregion">
                <div class="row">
                    <div class="col-md-6">
                        <label for=""><b>Busca por grupo</b></label>
                        <select class="form-control show-tick ms select2" name="idgrupo" id="" onchange="buscarac()" data-placeholder="Select">
                            <option value="">--Seleccione un grupo--</option>
                            <option value="">Ninguno</option>
                            @foreach ($grupos as $grupo)
                                <option value="{{$grupo->id_grupo}}"
                                    {{$idgrupo==$grupo->id_grupo ? 'selected' : 'Seleccione una region'}}
                                    >{{$grupo->grupo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-4">
                        <label for=""><b>Mostrar abonos por:</b></label>
                        <div class="card-header">
                            <center>
                                @if ($ultimasemana=='1')
                                    <input style="width: 14px; height: 14px;" type="checkbox" name="ultimasemana" checked value="1"><label class="mr-2 ml-2" for=""> Última semana</label> 
                                @else
                                    <input style="width: 14px; height: 14px;" type="checkbox" name="ultimasemana" value="1"><label class="mr-2 ml-2" for=""> Últimos 7 días</label> 
                                @endif
                                <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-search"></i></button>
                            <a href="{{url('pdf-abono-semana')}}" class="btn btn-dark btn-sm" title="Imprimir reporte de los ultimos 7 dias" target="_blank"><i class="fas fa-print"></i></a>
                            </center>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12" style="max-height: calc(65vh);  overflow-y: scroll;margin-bottom: 20px">
            <div class="estilo-tabla">
                <table>
                    <thead class="encabezado-table">
                        <tr>
                            <th class="pading-p">
                                <small>
                                    No.A
                                </small>
                            </th>
                            <th>
                                <small>
                                    Cliente
                                </small>
                            </th>
                            <th>
                                <small>
                                    Grupo
                                </small>
                            </th>
                            <th class="pading-p ">
                                <small>
                                    Semana
                                </small>
                            </th>
                            <th class="pading-p">
                                <small>
                                    Tipo abono
                                </small>
                            </th>
                            <th class="pading-p">
                                <small>
                                    Cantidad
                                </small>
                            </th>
                            <th class="pading-p">
                                <small>
                                    Fecha de pago
                                </small>
                            </th>
                            <th class="pading-p">
                                <small>
                                    Operación
                                </small>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @if (!empty($abonos_region))
                        @foreach ($abonos_region as $abonos_reg)
                            <tr>
                                <td class="pading-p">
                                    <small>
                                        {{$abonos_reg->id_abono}}
                                    </small>
                                </td>
                                <td class="pading-p">
                                    <small>
                                        {{$abonos_reg->nombre}} {{$abonos_reg->ap_paterno}} {{$abonos_reg->ap_materno}}
                                    </small>
                                </td>
                                <td class="pading-p">
                                    <small>
                                        {{$abonos_reg->grupo}}
                                    </small>
                                </td>
                                <td class="pading-p">
                                    <small>
                                        {{$abonos_reg->semana}}
                                    </small>
                                </td>
                                <td class="pading-p">
                                    <small>
                                        @if ($abonos_reg->tipoAbono=='Abono')
                                            <span style="background: rgb(18, 168, 50); color: white; padding-top: 1px; padding-bottom: 1px; padding-left: 5px; padding-right: 5px; font-size: 11px; font-weight: 400; border-radius: 5px;" >
                                                {{$abonos_reg->tipoAbono}}
                                            </span>
                                        @elseif($abonos_reg->tipoAbono=='Multa 1')
                                            <span style="background: rgb(80, 87, 105); color: white; padding-top: 1px; padding-bottom: 1px; padding-left: 5px; padding-right: 5px; font-size: 11px; font-weight: 400; border-radius: 5px;" >
                                                {{$abonos_reg->tipoAbono}}
                                            </span>
                                        @elseif($abonos_reg->tipoAbono=='Multa 2')
                                            <span style="background: rgb(33, 35, 41); color: white; padding-top: 1px; padding-bottom: 1px; padding-left: 5px; padding-right: 5px; font-size: 11px; font-weight: 400; border-radius: 5px;" >
                                                {{$abonos_reg->tipoAbono}}
                                            </span>
                                        @elseif($abonos_reg->tipoAbono=='Liquidación')
                                            <span style="background: rgb(219, 21, 21); color: white; padding-top: 1px; padding-bottom: 1px; padding-left: 5px; padding-right: 5px; font-size: 11px; font-weight: 400; border-radius: 5px;" >
                                                {{$abonos_reg->tipoAbono}}
                                            </span>
                                        @elseif($abonos_reg->tipoAbono=='Ahorro')
                                        <span style="background: rgb(55, 75, 255); color: white; padding-top: 1px; padding-bottom: 1px; padding-left: 5px; padding-right: 5px; font-size: 11px; font-weight: 400; border-radius: 5px;" >
                                                {{$abonos_reg->tipoAbono}}
                                            </span>
                                        @endif
                                    </small>
                                </td>
                                <td class="pading-p">
                                    <small>
                                        {{$abonos_reg->cantidad}}
                                    </small>
                                </td>
                                <td class="pading-p">
                                    <small>
                                        {{$abonos_reg->fecha_pago}}
                                    </small>
                                </td>
                                <td class="">
                                    <small class="d-flex">
                                        
                                        <a href="{{ url('admin/abonos/'.$abonos_reg->id_abono.'/edit/') }}" class="btn btn-warning btn-sm" title="Editar abono"><i class="fas fa-pen"></i></a>
                                            <form action="{{ url('admin/abonos/'.$abonos_reg->id_abono) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')" title="Eliminar abono"><i class="fas fa-trash"></i></button>
                                            </form>
                                        {{-- <a href="{{url('pdf-abono/'.$abonos_reg->id_abono)}}" target="_blank" class="btn btn-dark btn-sm" title="Imprimir recibo"><i class="fas fa-print"></i></a> --}}
                                        <a href="{{url('pdf-historial-abono/'.$abonos_reg->id_grupo.'/'.$abonos_reg->id_abono)}}" class="btn btn-dark btn-sm" target="_blank"><i class="fas fa-print"></i></a>
                                        
                                        @php
                                            $idsocioeco=DB::table('tbl_socio_economico')
                                            ->select('id_socio_economico')
                                            ->where('id_usuario','=',$abonos_reg->id)
                                            ->get();
                                        @endphp
                                            @if (empty($idsocioeco[0]->id_socio_economico))
                                                ...
                                            @else
                                                <form action="{{url('create-socioeconomico')}}" method="GET">
                                                    <input name="id_socioeconomico" type="hidden" value="{{$idsocioeco[0]->id_socio_economico}}">
                                                    <button type="submit" class="btn btn-info btn-sm" title="Editar socioeconómico"><i class="fas fa-user-edit"></i></button>
                                                    
                                                </form>
                                            @endif
                                    </small>
                                </td>
                            </tr>
                        @endforeach  
                    @else
                            
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <br>
    </div>
@endsection
@section('page-script')
<script>
    
    window.onload = function agregar_boton_atras(){
  
      document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
    
  }
  </script>
<script>
  function buscarac()
  {
      document.getElementById("formregion").submit();
  }

</script>
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop