@extends('layouts.master')
@section('title', 'Listado de clientes')
@section('parentPageTitle', 'Préstamos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> --}}
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
        
        @if ( session('status') )
            {{-- <div class="row"> --}}
                <div class="col-md-12 mt-3">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            {{-- </div> --}}
        @endif
        @if ( session('error') )
            {{-- <div class="row"> --}}
                <div class="col-md-12 mt-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            {{-- </div> --}}
        @endif
        <div class="col-md-4">
            <label for="">Grupo</label>
            {{-- <input class="form-control" type="text" value="{{$grupo->grupo}}" readonly> --}}
            <form id="formGrupos" action="{{url('prestamo/buscar-cliente/'.$zona->IdZona.'/'.$region->IdPlaza.'/0')}}" method="get">
                <select name="id_grupo" class="form-control show-tick ms select2" data-placeholder="Select" onchange="buscar_grupo()">
                    {{-- <option value="">--Seleccione un grupo--</option> --}}
                    @foreach ($grupos as $grup)
                        <option value="{{$grup->id_grupo}}" 
                            {{$grupo->id_grupo==$grup->id_grupo ? 'selected' : 'Seleccione un grupo'}}
                            >{{$grup->grupo}}</option>
                    @endforeach
                </select>
            </form>
        </div>
    
    
    
    
        <div class="col-md-3 ">
            <form target="_blank" action="{{url('exportar-clientes-activos/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" method="get" id="formClientes">
                @csrf
                <label style="font-size: 12px;color: rgb(60, 57, 238);">Exportar clientes por estatus</label><br>
                <select class="form-control show-tick ms select2"  name="id_estatus_prestamo" id="id_estatus_prestamo" data-placeholder="Select" onchange="buscar_clientes()" required>
                    <option value="">--Selecciona un estatus--</option>
                    <option value="2">Activos</option>
                    <option value="6">Inactivos</option>
                    <option value="3">Morosos</option>
                </select>
            </form>
        </div>
        <div class="col-md-5">
            <center>
                <label for=""><b>Mostrando</b></label><br>
            </center>
            <form id="formStatusC" action="{{url('prestamo/buscar-cliente/'.$zona->IdZona.'/'.$region->IdPlaza.'/0')}}" method="get">
                @csrf
                <input type="hidden" name="id_grupo" value="{{$grupo->id_grupo}}">
                <select name="id_estatus_buscar" class="form-control show-tick ms select2" data-placeholder="Select" onchange="buscar_clientesCStatus();" >
                    @if ($id_status=='todo')
                        <option value="todo" selected>Todo los clientes</option>
                        <option value="2" >Clientes con préstamo activo/renovación</option>
                        <option value="6">Clientes con préstamo inactivo</option>
                        <option value="3">Clientes con préstamo moroso</option>
                        <option value="8" >Clientes con préstamo pagado</option>
                    @elseif ($id_status==2)
                        <option value="todo" >Todo los clientes</option>
                        <option value="2" selected>Clientes con préstamo activo/renovación</option>
                        <option value="6">Clientes con préstamo inactivo</option>
                        <option value="3">Clientes con préstamo moroso</option>
                        <option value="8" >Clientes con préstamo pagado</option>
                   
                    @elseif ($id_status==6)
                        <option value="todo" >Todo los clientes</option>
                        <option value="2" >Clientes con préstamo activo/renovación</option>
                        <option value="6" selected>Clientes con préstamo inactivo</option>
                        <option value="3">Clientes con préstamo moroso</option>
                        <option value="8" >Clientes con préstamo pagado</option>
                    @elseif ($id_status==3)
                        <option value="todo" >Todo los clientes</option>
                        <option value="2" >Clientes con préstamo activo/renovación</option>
                        <option value="6" >Clientes con préstamo inactivo</option>
                        <option value="3" selected>Clientes con préstamo moroso</option>
                        <option value="8" >Clientes con préstamo pagado</option>
                    @elseif ($id_status==8)
                        <option value="todo" >Todo los clientes</option>
                        <option value="2" >Clientes con préstamo activo/renovación</option>
                        <option value="6" >Clientes con préstamo inactivo</option>
                        <option value="3" >Clientes con préstamo moroso</option>
                        <option value="8" selected>Clientes con préstamo pagado</option>
                        
                    @endif
                    
                </select>
            </form>
        </div>
    </div>
            <!--<a class="btn btn-info btn-sm" href="{{url('exportar-clientes-activos/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" target="_blank"> Exportar clientes activos</a>-->
        
        <div class="row">
        <div class="col-md-8 mt-3">
            <label style="font-size: 12px;color: rgb(60, 57, 238);">Buscar clientes por sus datos</label><br>
            <input class="form-control" id="myInput" type="text" placeholder="Busca por el nombre del cliente...">
        </div>
        <div class="col-md-4 mt-3">
                <div class="card-header">
                    <style>
                        .buton-entrega{
                            position: relative;
                        }
                        .buton-entrega img{
                            background: #fff;
                            width: 50px;
                            height: 50px;
                            border-radius: 50%;
                            padding: 5px;
                            box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
                        }
                        .buton-entrega span{
                            background: red;
                            position: absolute;
                            padding-left: 5px; 
                            padding-right: 5px; 
                            padding-bottom: 2px; 
                            padding-top: 2px; 
                            color: #fff; 
                            font-size: 9px; 
                            border-radius: 50px;
                            right: 5px; 
                        }
                    </style>
                    <center>
                        @if (count($prestamos_sin_producto)==0)
                            <a href="{{url('prestamo/buscar-cliente/prestamos-nuevos/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" class="buton-entrega mr-2" title="Préstamos aprobados y pendientes por entregar">
                                <img src="{{asset('img/icons-rojos/entrega-recursos.png')}}" alt="">
                                @if (empty($prestamos_aprobados))
                                    
                                @else
                                    <span style="  ">{{count($prestamos_aprobados)}}</span>
                                @endif
                            </a>
                        @else
                            <a href="#" onclick="return alert('Revise los préstamos a entregar, probablemente necesiten datos importantes para proseguir, en ¡NOTIFICACIÓN! -> Ver')" class="btn btn-secondary btn-sm" title="Préstamos aprobados y pendientes por entregar">
                                <img src="{{asset('img/icons-rojos/entrega-recursos.png')}}" alt="">
                                <span>Devolución</span>
                                @if (empty($prestamos_aprobados))
                                    
                                @else
                                    <span style="background: rgb(59, 26, 206); padding-left: 5px; padding-right: 5px; padding-bottom: 2px; padding-top: 2px; color: #fff; font-size: 9px; border-radius: 50px; margin-left: 3px; position: ; ">{{count($prestamos_aprobados)}}</span>
                                @endif
                            </a>
                            {{-- <a style="background: red; padding-left: 5px; padding-right: 5px; padding-bottom: 2px; padding-top: 2px; color: #fff; font-size: 9px; border-radius: 50px; margin-left: 3px; position: ; " href="#" ></a> --}}
                        @endif
                        <a href="{{url('prestamo/buscar-cliente/prestamos-devolucion/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" class="buton-entrega mr-2" title="Devolución de préstamos">
                            <img src="{{asset('img/icons-rojos/devolucion-recursos.png')}}" alt="">
                            @if (empty($prestamos_devolucion))
                                
                            @else
                                <span style="background: blue; padding-left: 5px; padding-right: 5px; padding-bottom: 2px; padding-top: 2px; color: #fff; font-size: 9px; border-radius: 50px; margin-left: 3px; position: ; ">{{count($prestamos_devolucion)}}</span>
                            @endif
                        </a>
                        {{-- @if (auth::user()->id==68) --}}
                        <a href="{{url('prestamo/buscar-cliente/prestamos-anticipados/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" class="buton-entrega mr-2" title="Entrega de préstamos aticipados">
                            {{-- <img src="{{asset('img/icons-rojos/devolucion-recursos.png')}}" alt=""> --}}
                            <label style="padding: 13px; background: #fff; border-radius: 30px; margin-left:5px; cursor: pointer; font-weight: bold ">
                                R L
                            </label >
                            @if (empty($prestamos_liquidacion_renovacion))
                                
                            @else
                                <span style="background: blue; padding-left: 5px; padding-right: 5px; padding-bottom: 2px; padding-top: 2px; color: #fff; font-size: 9px; border-radius: 50px; margin-left: 3px; position: ; ">{{count($prestamos_liquidacion_renovacion)}}</span>
                            @endif
                        </a>
                        {{-- @elseif (auth::user()->id==6)
                        <a href="{{url('prestamo/buscar-cliente/prestamos-anticipados/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" class="buton-entrega mr-2" title="Entrega de préstamos aticipados"> --}}
                            {{-- <img src="{{asset('img/icons-rojos/devolucion-recursos.png')}}" alt=""> --}}
                            {{-- <label style="padding: 13px; background: #fff; border-radius: 30px; margin-left:5px; cursor: pointer; font-weight: bold ">
                                R L
                            </label >
                            @if (empty($prestamos_liquidacion_renovacion))
                                
                            @else
                                <span style="background: blue; padding-left: 5px; padding-right: 5px; padding-bottom: 2px; padding-top: 2px; color: #fff; font-size: 9px; border-radius: 50px; margin-left: 3px; position: ; ">{{count($prestamos_liquidacion_renovacion)}}</span>
                            @endif
                        </a>
                        @else
                            
                        @endif --}}
                        
                        {{-- <a href="" class="btn btn-danger btn-sm" title="Préstamos negados"><i class="fas fa-comment-dollar">-</i></a>
                        <a href="" class="btn btn-info btn-sm" title="Préstamos pendientes"><i class="fas fa-comment-dollar">..</i></a> --}}
                    </center>

                </div>
        </div>
        <div class="col-md-12 mt-3">
            @php
                $promotoras = DB::table('tbl_grupos_promotoras')
                ->join('tbl_usuarios','tbl_grupos_promotoras.id_usuario','tbl_usuarios.id')
                ->Join('tbl_datos_usuario', 'tbl_grupos_promotoras.id_usuario', '=', 'tbl_datos_usuario.id_usuario')
                ->join('tbl_tipo_usuario','tbl_usuarios.id_tipo_usuario','tbl_tipo_usuario.id_tipo_usuario')
                ->select('tbl_grupos_promotoras.*','tbl_datos_usuario.*','tbl_usuarios.id_tipo_usuario','tbl_tipo_usuario.nombre as tipo_usuario')
                ->where('tbl_grupos_promotoras.id_grupo','=',$grupo->id_grupo)
                ->distinct()
                ->get();
            @endphp
            <label for=""><b>Promotoras</b></label>
            @if (count($promotoras)==0)
                Ninguna promotora
            @else
                @foreach ($promotoras as $promotora)
                    @php
                        $total_clientes=DB::table('tbl_prestamos')
                        ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                        ->select('tbl_prestamos.cantidad','tbl_productos.pago_semanal')
                        ->where('tbl_prestamos.id_promotora','=',$promotora->id_usuario)
                        ->where('tbl_prestamos.id_grupo','=',$grupo->id_grupo)
                        ->whereIn('tbl_prestamos.id_status_prestamo',[9,2])
                        ->get();
                        
                        $clientes_activos=count($total_clientes);
                        $monto_ideal=0;

                        if ($clientes_activos==0) {
                            $monto_ideal+=0;
                        } else {
                            foreach ($total_clientes as $total_cliente) {
                                $monto_ideal+=$total_cliente->cantidad*($total_cliente->pago_semanal/100);
                            }
                        }
                        
                    @endphp

                    <label  class="form-control" title="Tipo usuario: # {{$promotora->id_grupo_promotoras}} | {{$promotora->id_usuario}} {{$promotora->tipo_usuario}} ">
                        {{$promotora->nombre}} {{$promotora->ap_paterno}} {{$promotora->ap_materno}}   
                        | monto ideal: <b> $ {{number_format($monto_ideal,2)}}   | clientes: <b>{{number_format($clientes_activos)}}</b></b> 
                        
                    </label>
                @endforeach
                
            @endif
        </div>
        <style>
            .icons-botones{
                width: 45px;
                height: 45px;
                /* border: 1px solid #000; */
                border-radius: 50%;
                padding: 4px;
                background: #fff;
                box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
                color: rgb(116, 38, 168);
                font-size: 45px;
            }
        </style>
        {{-- <div class="col-md-2"></div> --}}
        
    </div>
    
    @if (count($prestamos_sin_producto)==0)
        
    @else
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="alert alert-warning" role="alert">
                    <strong>¡NOTIFICACIÓN!</strong>
                    Hay préstamos sin producto, es posible que requiera agregar otros campos más
                    <a href="#" onclick="modal_noproducto();" class="btn btn-info btn-sm">Ver</a>
                  </div>
            </div>
        </div>
    @endif
    @if (!empty($clientes))
        <div class="row mt-3">
            @php
                
            @endphp
            @if (count($ultimos_abonos)==0)
                
            @else
            <style>
                .morosidad{
                    display: none;
                }
            </style>
                <div  class="col-md-12 morosidad" style="border: 1px solid #000"><br>
                    <span class="badge badge-warning">Se ha detectado la siguiente lista de préstamos que deben pasar a morosidad</span>
        
                    <hr>
                    <form action="{{url('morosidad')}}" method="post">
                    @csrf
                            @foreach ($ultimos_abonos as $ultimos_ab)
                                
                                @php
                                    $prestamos_morosidad=DB::table('tbl_prestamos')
                                    ->join('tbl_abonos','tbl_prestamos.id_prestamo','tbl_abonos.id_prestamo')
                                    ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                                    ->select('tbl_abonos.*','tbl_prestamos.*','tbl_productos.*')
                                    ->where('tbl_abonos.id_abono','=',$ultimos_ab->ultimo_abono)
                                    ->whereIn('tbl_prestamos.id_status_prestamo',[2,9])
                                    ->get();
                                @endphp
                                @if (count($prestamos_morosidad)==0)
                                    
                                @else
                                    
                                    @foreach ($prestamos_morosidad as $prestamos_m)
                                        @php
                                            $semana_faltante=$prestamos_m->ultima_semana-$prestamos_m->semana;
                                            $dias_habiles=$semana_faltante*7;
                                            $dias_cant=$fecha_actual->diffInDays($prestamos_m->fecha_pago);


                                        @endphp
                                        @if ($dias_cant>$dias_habiles)
                                        <style>
                                            .morosidad{
                                                display: block;
                                            }
                                        </style>
                                            {{-- <label for="">esta en morosidad {{$prestamos_m->id_prestamo}} , {{$prestamos_m->id_status_prestamo}}</label> --}}
                                            @php
                                                 $dates = date_create($prestamos_m->fecha_pago);
                                            @endphp
                                            {{-- semana faltante {{$semana_faltante}}-{{$dias_habiles}} / {{$dias_cant}}<br> --}}
                                            <span style="font-size: 12px; margin-left: 10px;">No. Préstamo </span> <input style="font-size: 12px; font-weight: bold; background: transparent; border: transparent; width: 50px; text-align: center" type="text" name="id_prestamo[]" value="{{$prestamos_m->id_prestamo}}"> <span style="font-size: 12px; font-weight: bold;">último abono {{date_format($dates, 'd/m/Y')}}</span> <span style="font-size: 12px; font-weight: bold;"> semana {{$prestamos_m->semana}}</span> <span style="font-size: 12px; font-weight: bold;">{{$prestamos_m->producto}}</span><br>
                                            
                                        
                                        @else
                                            {{-- <label for="">va bien {{$prestamos_m->id_prestamo}} , {{$prestamos_m->id_status_prestamo}}</label> --}}
                                            
                                        @endif
                                    @endforeach
                                @endif

                                {{-- <label for="">Ya han pasado {{$dias_cant}} / {{$ultimos_ab->id_prestamo}} - </label> --}}
                            @endforeach
                            <br>
                            <button style="float: right;background: #3483fa;" type="submit" onclick="return confirm('¿Esta seguro de pasar a morosidad los préstamos?')" class="btn btn-primary btn-sm">Continuar y pasar los préstamos a morosidad</button>
                    </form>
                </div>
                <br>
            @endif
            
            <div class="col-md-12">
               
                <div class="estilo-tabla">
                    <table class="js-basic-example">
                        <thead>
                            <tr>
                                <th class="en-1">No.C</th>
                                <th class="en-3">Cliente</th>
                                <th class="en-1">No.P</th>
                                <th class="">Préstamo</th>
                                <th class="">Fecha</th>
                                <th class="en-2">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="myList">
                            @foreach ($clientes as $cliente)
                            <tr id="{{$cliente->id_promotora}}">
                                <td class="td-1">
                                    <small>
                                        {{$cliente->id}}</td>
                                    </small>
                                <td>
                                    <small>
                                        {{$cliente->nombre.' '.$cliente->ap_paterno.' '.$cliente->ap_materno}} 
                                    </small>
                                </td>
                                <td class="td-1">
                                    <small >
                                        <span title="Número de préstamo">
                                            {{$cliente->id_prestamo}}</td>
                                        </span>
                                    </small>
                                <td>
                                    
                                     @if (empty($cliente->id_prestamo))
                                        no hay datos
                                    @else
                                    <small>
                                            <span title="Producto">
                                                {{$cliente->producto}} / $ {{number_format($cliente->cantidad,2)}}
                                            </span>
                                        
                                        @if ($cliente->id_status_prestamo==8)
                                            <span style="background: rgb(243, 33, 33); border-radius:7px; padding:4px; color:white; margin-left:6px;" title="Estatus del préstamo">
                                                {{$cliente->status_prestamo}}
                                            </span>
                                        @elseif ($cliente->id_status_prestamo==2)
                                            <span style="background: rgb(15, 209, 47); border-radius:7px; padding:4px; color:white; margin-left:6px;" title="Estatus del préstamo">
                                                {{$cliente->status_prestamo}}
                                            </span>
                                        @elseif ($cliente->id_status_prestamo==9)
                                            <span style="background: rgb(57, 36, 245); border-radius:7px; padding:4px; color:white; margin-left:6px;" title="Estatus del préstamo">
                                                {{$cliente->status_prestamo}}
                                            </span>
                                        @elseif ($cliente->id_status_prestamo==1)
                                            <span style="background: rgb(52, 61, 90); border-radius:7px; padding:4px; color:white; margin-left:6px;" title="Estatus del préstamo">
                                                Nuevo
                                            </span>
                                        @else
                                        <span style="background: rgb(22, 3, 3); border-radius:7px; padding:4px; color:white; margin-left:6px;" title="Estatus del préstamo">
                                            {{$cliente->status_prestamo}}
                                        </span>
                                        @endif
                                    </small>
                                    @endif
                                    
                                </td>
                                <td>
                                    <small>
                                        <span style="margin:7px;" title="Fecha de entrega de recurso">
                                        @php
                                            $dates = date_create($cliente->fecha_entrega_recurso);
                                        @endphp
                                            {{date_format($dates, 'd/m/Y')}}
                                        </span>    
                                    </small> 
                                </td>
                                <td class="d-flex">
                                    <form action="{{url('nuevo_prestamo_extra')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id_prestamo" value="{{$cliente->id_prestamo}}">
                                        <button class="btn btn-primary btn-sm" onclick="return confirm('¿Está seguro de continuar?')"><i class="fas fa-plus-circle"></i></button>
                                    </form>
                                    <form action="{{ url('prestamo/buscar-cliente/admin/prestamos/' .$cliente->id_prestamo.'/edit') }}" method="get">
                                        <input type="hidden" name="link" value="prestamo/buscar-cliente/{{$zona->IdZona}}/{{$region->IdPlaza}}/{{$grupo->id_grupo}}">
                                        <button class="btn btn-warning btn-sm" title="Editar datos del préstamo"  ><i class="fas fa-pen"></i></button>
                                    </form>

                                    @if (empty($cliente->id_status_prestamo))
                                        Sin operaciones
                                    @else
                                    
                                    @if ($cliente->id_status_prestamo==2)
                                        <a href="{{url('prestamo/abono/agregar-abono-c/'.$zona->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo.'/'.$cliente->id_prestamo)}}"  class="btn btn-success btn-sm" title="Ver historial y registrar abono"><i class="fas fa-plus-circle"> Abono</i></a>
                                        <a href="{{url('historial-abono/'.$cliente->id_prestamo)}}" class="btn btn-dark btn-sm" target="_blank" title="Imprimir en PDF historial de abonos"><i class="fas fa-print"></i></a>
                                        @if (auth::user()->id==68)
                                        <form action="{{url('liquidacion-renovacion')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_prestamo" value="{{$cliente->id_prestamo}}">
                                            <button class="btn btn-primary btn-sm" onclick="return confirm('¿Está seguro de continuar?')">L R</button>
                                    
                                        </form>
                                        @elseif(auth::user()->id==6)
                                            <form action="{{url('liquidacion-renovacion')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="id_prestamo" value="{{$cliente->id_prestamo}}">
                                                <button class="btn btn-primary btn-sm" onclick="return confirm('¿Está seguro de continuar?')">L R</button>
                                        
                                            </form>
                                        @else

                                        @endif
                                       

                                    @elseif($cliente->id_status_prestamo==8)
                                        <a href="{{url('prestamo/abono/agregar-abono-c/'.$zona->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo.'/'.$cliente->id_prestamo)}}"  class="btn btn-info btn-sm" title="Ver historial"><i class="far fa-eye"> Historial</i></a>
                                        <a href="{{url('historial-abono/'.$cliente->id_prestamo)}}" class="btn btn-dark btn-sm" target="_blank" title="Imprimir en PDF historial de abonos"><i class="fas fa-print"></i></a>

                                    @elseif($cliente->id_status_prestamo==9)
                                        <a href="{{url('prestamo/abono/agregar-abono-c/'.$zona->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo.'/'.$cliente->id_prestamo)}}"  class="btn btn-success btn-sm" title="Ver historial y registrar abono"><i class="fas fa-plus-circle"> Abono</i></a>
                                        <a href="{{url('historial-abono/'.$cliente->id_prestamo)}}" class="btn btn-dark btn-sm" target="_blank" title="Imprimir en PDF historial de abonos"><i class="fas fa-print"></i></a>
                                        
                                   
                                        <form action="{{url('liquidacion-renovacion')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_prestamo" value="{{$cliente->id_prestamo}}">
                                            <button class="btn btn-primary btn-sm" onclick="return confirm('¿Está seguro de continuar?')">L R</button>
                                    
                                        </form>
                                        
                                        
                                        

                                    @elseif($cliente->id_status_prestamo==1)
                                        <a href="#" onclick="return alert('Se necesita aprobacion del préstamo, esta pendiente')" class="btn btn-secondary btn-sm" title="No hay abonos"><i class="fas fa-exclamation-circle"></i> Pendiente</i></a>
                                    
                                    @elseif($cliente->id_status_prestamo==6)
                                        <a href="#" onclick="return alert('Inactivo')" class="btn btn-secondary btn-sm" title="No hay abonos"><i class="fas fa-exclamation-circle"></i> Inactivo</i></a>
                                    @else
                                        <a href="{{url('prestamo/abono/agregar-abono-c/'.$zona->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo.'/'.$cliente->id_prestamo)}}"  class="btn btn-success btn-sm" title="Ver historial"><i class="fas fa-plus-circle"> Abono</i></a>
                                        <a href="{{url('historial-abono/'.$cliente->id_prestamo)}}" class="btn btn-dark btn-sm" target="_blank" title="Imprimir en PDF historial de abonos"><i class="fas fa-print"></i></a>

                                    @endif
                                    {{--<a href="{{ url('admin/abonos/'.$cliente->id_prestamo.'/edit/') }}" class="btn btn-warning btn-sm" title="Editar abono"><i class="fas fa-pen"></i></a>--}}
                                    @endif
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
        
    @else
        
    @endif
    <div class="modal fade" id="modal_noproducto" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
				<div class="col-md-12 mt-3">
					<center>
						<label for="">Préstamos sin producto</label>
					</center>
                    <hr>
					<table class="js-basic-example">
						<thead>
						<tr>
							<th><small>No.C</small></th>
							<th><small>Cliente</small></th>
							<th><small>No.P</small></th>
                            <th><small>Préstamos</small></th>
                            <th><small>Estatus</small></th>
							<th><small>Operación</small></th>
						</tr>
						</thead>
						<tbody>
							@foreach ($prestamos_sin_producto as $p_producto)
							<tr>
								<td><small>{{$p_producto->id_usuario}}</small></td>
								<td><small>{{$p_producto->nombre}} {{$p_producto->ap_paterno}} {{$p_producto->ap_materno}}</small></td>
								<td><small>{{$p_producto->id_prestamo}}</small></td>
								<td><small><span>Monto: </span>{{$p_producto->cantidad}} <span>F. Solicitado: </span>{{$p_producto->fecha_solicitud}}</small></td>
                                <td><small>{{$p_producto->status_prestamo}}</small></td>
                                <td>
                                    <a class="btn btn-warning btn-sm" type="submit" href="{{ url('prestamo/buscar-cliente/admin/prestamos/' .$p_producto->id_prestamo.'/edit') }}">Actualizar</a>
									
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
					</form>
				</div>
			</div>
        </div>
    </div>
    
@stop
@section('page-script')

<script>
    window.onload = function agregar_boton_atras(){
  
        document.getElementById('Atras').innerHTML='<a href="{{url('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
        document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
    
  }
</script>
<script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myList tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

  function buscar_grupo()
  {
      document.getElementById("formGrupos").submit();
  }
  function buscar_clientesCStatus()
  {
      document.getElementById("formStatusC").submit();
  }
  function buscar_clientes()
  {
      var id_estatus = document.getElementById("id_estatus_prestamo").value;
      
      if(id_estatus==''){
          
      } else {
        document.getElementById("formClientes").submit();
      }
  }

  function modal_noproducto(){
  $("#modal_noproducto").modal();
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
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop