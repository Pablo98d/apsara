@extends('layoutsC.master')
@section('title', 'Registro socio económico')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.css')}}"/>
@stop
@section('content')
<div class="row">
    @if ( session('status') )
        <div class="col-md-12">
            <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">x</span>
                </button>
            </div>
        </div>
    @endif 
    @if ( session('danger') )
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('danger') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif 
    <div class="col-md-12">
        @php
            $soci=DB::table('tbl_socio_economico')
                    ->join('tbl_usuarios as cliente','tbl_socio_economico.id_usuario','=','cliente.id')
                    ->join('tbl_usuarios as promotor','tbl_socio_economico.id_promotora','=','promotor.id')

                    ->join('tbl_datos_usuario as d_cliente','cliente.id','=','d_cliente.id_usuario')
                    ->join('tbl_datos_usuario as d_promotora','promotor.id','=','d_promotora.id_usuario')

                    ->select('tbl_socio_economico.*','d_cliente.nombre as n_cliente','d_cliente.ap_paterno as ap_cliente','d_cliente.ap_materno as am_cliente','d_promotora.nombre as n_promotor','d_promotora.ap_paterno as ap_promotor','d_promotora.ap_materno as am_promotor')
                    ->where('tbl_socio_economico.id_usuario','=',auth()->user()->id)
                    ->get();
                $socio_e=count($soci);
        @endphp

        @if ($socio_e==0)
            {{-- <form method="POST" action="{{url('guardar_socio') }}">
                @csrf --}}
                <div class="form-row">
                <div class="form-group col-md-4">
                    <input type="hidden" name="id_usuario" value="{{auth()->user()->id}}">
                    <input type="hidden" name="estatus" value="0">
                    <label for="id_promotora">Promotor</label>
                    <select class="form-control" id="id_promotora" name="id_promotora" value="{{old('id_promotora')}}">
                    <option value="">--Seleccione el promotor--</option>
                    @foreach ($promotores as $promotor)
                    <option value="{{$promotor->id}}">{{$promotor->nombre}} {{$promotor->ap_paterno}} {{$promotor->ap_materno}}</option>
                    @endforeach
                    </select>
                </div>
        
                <div class="form-group col-md-6" hidden="si">
                    <label for="fecha_registro">Fecha Registro</label>
                    <input type="text" id="fecha_registro" class="form-control" name="fecha_registro" value="{{ old('fecha_registro',$now->format('Y-m-d')) }}">
                </div>
                </div>
                {{-- <div class="d-flex">
                <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </form> --}}
        @else
        
            <label for=""><b>Socioeconomico: </b><span class="title">{{$soci[0]->n_cliente.' '.$soci[0]->ap_cliente.' '.$soci[0]->am_cliente}}</span></label><br>
           
            <label for=""><b>Promotor: </b><span class="title">{{$soci[0]->n_promotor.' '.$soci[0]->ap_promotor.' '.$soci[0]->am_promotor}}</span></label>
            
            </div>
            <div class="col-md-12">
                <div class="tabContainer">
                    <div class="buttonContainer">
                        <button onclick="showPanel(0,'white')">Familiares</button>
                        <button onclick="showPanel(1,'white')">Aval</button>
                        <button onclick="showPanel(2,'white')">Vivienda</button>
                        <button onclick="showPanel(3,'white')">Pareja</button>
                        <button onclick="showPanel(4,'white')">Domicilio</button>
                        <button onclick="showPanel(5,'white')">Artículos hogar</button>
                        <button onclick="showPanel(6,'white')">Finanzas</button>
                        <button onclick="showPanel(7,'white')">Fecha de monto</button>
                        <button onclick="showPanel(8,'white')">Gastos mensuales</button>
                        <button onclick="showPanel(9,'white')">Gastos semanales</button>
                        <button onclick="showPanel(10,'white')">Referencia laboral</button>
                        <button onclick="showPanel(11,'white')">Referencia personal</button>
                        <button onclick="showPanel(12,'white')">Datos generales</button>
                        <button onclick="showPanel(13,'white')">Doc. Prospecto</button>
                        <button onclick="showPanel(14,'white')">Doc. Aval</button>
                        <button onclick="showPanel(15,'white')">Terminación</button>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{---familiares---}}
                                @php
                                    $familiar=DB::table('tbl_familiares')->select(DB::raw('count(*) as ftotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($familiar[0]->ftotal==0)
                                    {{-- <form method="POST" action="{{ url('familiares_guardar') }}">
                                        {{ csrf_field() }} --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <label style="color: black" for="numero_personas">Número de Personas</label>
                                                <input id="numero_personas" name="numero_personas" type="number" class="form-control" value="{{old('numero_personas')}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label style="color: black" for="numero_personas_trabajando">Número de personas que trabajan</label>
                                            <input name="numero_personas_trabajando" type="number" class="form-control" id="numero_personas_trabajando" class="form-control" value="{{old('numero_personas_trabajando')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label style="color: black" for="aportan_dinero_mensual">Cuantos aportan dinero mensual</label>
                                            <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="number" class="form-control" value="{{old('aportan_dinero_mensual')}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar datos</button>
                                        </div> --}}
                                    {{-- </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $familiar=DB::table('tbl_familiares')
                                        ->select('tbl_familiares.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('familiares_update/'.$familiar[0]->id_familiar) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label style="color: black" for=""></label>
                                                <label style="color: black" for="numero_personas">Número de Personas</label>
                                                <input id="numero_personas" name="numero_personas" type="number" class="form-control" value="{{$familiar[0]->numero_personas}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label style="color: black" for="numero_personas_trabajando">Número de personas que trabajan</label>
                                                <input name="numero_personas_trabajando" type="number" class="form-control" id="numero_personas_trabajando" class="form-control" value="{{$familiar[0]->numero_personas_trabajando}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label style="color: black" for="aportan_dinero_mensual">Cuantos aportan dinero mensual</label>
                                                <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="number" class="form-control" value="{{$familiar[0]->aportan_dinero_mensual}}">
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{---aval---}}
                                @php
                                    $aval=DB::table('tbl_se_aval')->select(DB::raw('count(*) as atotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($aval[0]->atotal==0) 
                                    {{-- <form action="{{url('aval_guardar_se')}}" method="post">
                                        @csrf --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <label style="color: black" for="">Seleccione su aval</label>
                                                <select class="form-control" name="id_aval" id="">
                                                    <option value="">--Seleccione su aval--</option>
                                                    @foreach ($avales as $aval)
                                                        <option value="{{$aval->id_aval}}">{{$aval->nombre}} {{$aval->ap_paterno}} {{$aval->ap_materno}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label style="color: black" for=""><small><b>Nota: </b>en caso de que su aval no esté registrado, regístralo aquí</small></label><br>
                                                <a  href="#" class="btn btn-success" onclick="aval()" title="Registrar nuevo aval"> Nuevo aval</a>
                                            </div>
                                            <div class="col-md-6">
                                                <label style="color: black" for="">Relación solicitante</label><br>
                                                <input name="relacion_solicitante" class="form-control" type="text" placeholder="Ej. Familiar">
                                                {{-- <button type="submit" class="btn btn-primary mt-4">Registrar mi aval</button> --}}
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $aval=DB::table('tbl_avales')
                                        ->Join('tbl_se_aval', 'tbl_avales.id_aval', '=', 'tbl_se_aval.id_aval')
                                        ->select('tbl_avales.*')
                                        ->where('tbl_se_aval.id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('aval_update/'.$aval[0]->id_aval) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">CURP</label>
                                                <input class="form-control" type="text" id="curp" name="curp" value="{{$aval[0]->curp}}" placeholder="CURP" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Nombre</label>
                                                <input class="form-control" type="text" id="nombre" name="nombre" value="{{$aval[0]->nombre}}" placeholder="Nombre" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Ap. Paterno</label>
                                                <input class="form-control" id="ap_paterno" type="text" name="ap_paterno" value="{{$aval[0]->ap_paterno}}" placeholder="Apellido Paterno" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Ap. Materno</label>
                                                <input class="form-control" id="ap_materno" type="text" name="ap_materno" value="{{$aval[0]->ap_materno}}" placeholder="Apellido Materno" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Fecha de nacimiento</label>
                                                {{-- @php
                                                    $datenacimiento = date_create($aval[0]->fecha_nacimiento);
                                                @endphp --}}
                                                <div class="input-group masked-input">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
                                                    </div>
                                                    <input type="text" name="fecha_nacimiento" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59" value="{{$aval[0]->fecha_nacimiento}}">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Ocupación</label>
                                                <input class="form-control" id="ocupacion" type="text" name="ocupacion" value="{{$aval[0]->ocupacion}}" placeholder="Ocupación" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Género</label>
                                                <input class="form-control" id="genero" type="text" name="genero" value="{{$aval[0]->genero}}" placeholder="Genero" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Estado civil</label>
                                                <input class="form-control" id="estado_civil" type="text" name="estado_civil" value="{{$aval[0]->estado_civil}}" placeholder="Estado Civil" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Calle</label>
                                                <input class="form-control" id="calle" type="text" name="calle" value="{{$aval[0]->calle}}" placeholder="Calle" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">No. Exterior</label>
                                                <input class="form-control" id="numero_ext" type="text" name="numero_ext" value="{{$aval[0]->numero_ext}}" placeholder="Numero Exterior" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">No. Interior</label>
                                                <input class="form-control" id="numero_int" type="text" name="numero_int" value="{{$aval[0]->numero_int}}" placeholder="Numero Interior" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Entre calles</label>
                                                <input class="form-control" id="entre_calles" type="text" name="entre_calles" value="{{$aval[0]->entre_calles}}" placeholder="Entre Calles" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Colonia</label>
                                                <input class="form-control" id="colonia" type="text" name="colonia" value="{{$aval[0]->colonia}}" placeholder="Colonia" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Municipio</label>
                                                <input class="form-control" id="municipio" type="text" name="municipio" value="{{$aval[0]->municipio}}" placeholder="Municipio" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Estado</label>
                                                <input class="form-control" id="estado" type="text" name="estado" value="{{$aval[0]->estado}}" placeholder="Estado" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Referencia visual</label>
                                                <input class="form-control" id="referencia_visual" type="text" name="referencia_visual" value="{{$aval[0]->referencia_visual}}" placeholder="Referencia Visual" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Vivienda</label>
                                                <small></small>
                                                <input class="form-control" id="vivienda" type="text" name="vivienda" value="{{$aval[0]->vivienda}}" placeholder="Vivienda" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Tiempo viviendo en el domicilio</label>
                                                <input class="form-control" id="tiempo_viviendo_domicilio" type="text" name="tiempo_viviendo_domicilio" value="{{$aval[0]->tiempo_viviendo_domicilio}}" placeholder="Tiempo Viviendo en el Domicilio" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Teléfono casa</label>
                                                <input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{$aval[0]->telefono_casa}}" placeholder="Telefono Casa" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Teléfono móvil</label>
                                                <input class="form-control" id="telefono_movil" type="text" name="telefono_movil" value="{{$aval[0]->telefono_movil}}" placeholder="Telefono Movil" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Teléfono trabajo</label>
                                                <input class="form-control" id="telefono_trabajo" type="text" name="telefono_trabajo" value="{{$aval[0]->telefono_trabajo}}" placeholder="Telefono Trabajo" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="">Fecha de registro</label>
                                                @php
                                                    $dateregistro = date_create($aval[0]->fecha_registro);
                                                @endphp
                                                <div class="input-group masked-input">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
                                                    </div>
                                                    <input type="text" name="fecha_registro" class="form-control datetime" placeholder="Ex: 30/05/2020 23:59" value="{{date_format($dateregistro, 'd-m-Y H:i:s')}}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{---vivienda---}}
                                @php
                                    $vivienda=DB::table('tbl_vivienda')->select(DB::raw('count(*) as vtotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($vivienda[0]->vtotal==0)
                                    {{-- <form method="POST" action="{{ url('vivienda_guardar') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <label style="color: black" for="tipo_vivienda">Tipo vivienda</label>
                                                <input class="form-control" id="tipo_vivienda" type="text" name="tipo_vivienda" value="{{old('tipo_vivienda')}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="tiempo_viviendo_domicilio">Tiempo viviendo</label>
                                                <input class="form-control" id="tiempo_viviendo_domicilio" type="text" name="tiempo_viviendo_domicilio" value="{{old('tiempo_viviendo_domicilio')}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="telefono_casa">Teléfono Casa</label>
                                                <input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{old('telefono_casa')}}">
                                            </div>
                                        
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="telefono_celular">Teléfono celular</label>
                                                <input class="form-control" id="telefono_celular" type="text" name="telefono_celular" value="{{old('telefono_celular')}}">
                                            </div>
                                        </div>
                                        {{-- <div class="form-row">
                                        <button class="btn btn-primary" type="submit">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $vivienda=DB::table('tbl_vivienda')
                                        ->select('tbl_vivienda.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('vivienda_update/'.$vivienda[0]->id_vivienda) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="tipo_vivienda">Tipo vivienda</label>
                                                <input class="form-control" id="tipo_vivienda" type="text" name="tipo_vivienda" value="{{$vivienda[0]->tipo_vivienda}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="tiempo_viviendo_domicilio">Tiempo viviendo</label>
                                                <input class="form-control" id="tiempo_viviendo_domicilio" type="text" name="tiempo_viviendo_domicilio" value="{{$vivienda[0]->tiempo_viviendo_domicilio}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="telefono_casa">Teléfono Casa</label>
                                                <input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{$vivienda[0]->telefono_casa}}">
                                            </div>
                                        
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="telefono_celular">Teléfono celular</label>
                                                <input class="form-control" id="telefono_celular" type="text" name="telefono_celular" value="{{$vivienda[0]->telefono_celular}}">
                                            </div>
                                        </div>
                                        {{-- <div class="form-row">
                                        <button class="btn btn-primary" type="submit">Guardar datos</button>
                                        </div>
                                    </form> --}}
        
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{---pareja---}}
                                @php
                                    $pareja=DB::table('tbl_pareja')->select(DB::raw('count(*) as ptotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($pareja[0]->ptotal==0)
                                    {{-- <form method="POST" action="{{ url('pareja_guardar') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                            <label style="color: black" for="nombre">Nombre</label>
                                            <input id="nombre" type="text" class="form-control" name="nombre" value="{{old('nombre')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="ap_paterno">Apellido Paterno</label>
                                            <input type="text" id="ap_paterno" class="form-control" name="ap_paterno" value="{{ old('ap_paterno') }}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="ap_materno">Apellido Materno</label>
                                            <input id="ap_materno" type="text" class="form-control" name="ap_materno" value="{{old('ap_materno')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="telefono">Teléfono</label>
                                            <input name="telefono" type="text" class="form-control" id="telefono" class="form-control" value="{{ old('telefono') }}">
                                        </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="edad">Edad</label>
                                            <input class="form-control" id="edad" type="text" name="edad" value="{{old('edad')}}">
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label style="color: black" for="ocupacion">Ocupación</label>
                                            <input class="form-control" id="ocupacion" type="text" name="ocupacion" value="{{old('ocupacion')}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $pareja=DB::table('tbl_pareja')
                                        ->select('tbl_pareja.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('pareja_update/' .$pareja[0]->id_pareja) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                            <label style="color: black" for="nombre">Nombre</label>
                                            <input id="nombre" type="text" class="form-control" name="nombre" value="{{$pareja[0]->nombre}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="ap_paterno">Apellido Paterno</label>
                                            <input type="text" id="ap_paterno" class="form-control" name="ap_paterno" value="{{$pareja[0]->ap_paterno}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="ap_materno">Apellido Materno</label>
                                            <input id="ap_materno" type="text" class="form-control" name="ap_materno" value="{{$pareja[0]->ap_materno}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="telefono">Teléfono</label>
                                            <input name="telefono" type="text" class="form-control" id="telefono" class="form-control" value="{{$pareja[0]->telefono}}">
                                        </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="edad">Edad</label>
                                            <input class="form-control" id="edad" type="text" name="edad" value="{{$pareja[0]->edad}}">
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label style="color: black" for="ocupacion">Ocupación</label>
                                            <input class="form-control" id="ocupacion" type="text" name="ocupacion" value="{{$pareja[0]->ocupacion}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{---domicilio---}}
                                @php
                                    $domicilio=DB::table('tbl_domicilio')->select(DB::raw('count(*) as dtotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($domicilio[0]->dtotal==0)
                                    {{-- <form method="POST" action="{{ url('domicilio_guardar') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                            <label style="color: black" for="calle">Calle</label>
                                            <input class="form-control" id="calle" type="text" name="calle" placeholder="Calle" value="{{old('calle')}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="numero_ext">Numero Exterior</label>
                                            <input class="form-control" id="numero_ext" type="text" name="numero_ext" placeholder="Numero Exterior">
                                        </div>
                                        <div class="form-group col-md-4"> 
                                            <label style="color: black" for="numero_int">Numero Interior</label>
                                            <input class="form-control" id="numero_int" type="text" name="numero_int" placeholder="Numero Interior">
                                        </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="entre_calles">Entre Calles</label>
                                            <input class="form-control" id="entre_calles" type="text" name="entre_calles" placeholder="Entre Calles">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="colonia_localidad">Colonia Localidad</label>
                                            <input class="form-control" id="colonia_localidad" type="text" name="colonia_localidad" placeholder="Colonia Localidad">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="municipio">Municipio</label>
                                            <input class="form-control" id="municipio" type="text" name="municipio" placeholder="Municipio">
                                        </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="estado">Estado</label>
                                                <input class="form-control" id="estado" type="text" name="estado" placeholder="Estado">
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label style="color: black" for="referencia_visual">Referencia Visual</label>
                                                <input class="form-control" id="referencia_visual" type="text" name="referencia_visual" placeholder="Referencia Visual">
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                            <button class="btn btn-primary" type="submit">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $domicilio=DB::table('tbl_domicilio')
                                        ->select('tbl_domicilio.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('domicilio_update/' .$domicilio[0]->id_domicilio) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="calle">Calle</label>
                                                <input class="form-control" id="calle" type="text" name="calle" placeholder="Calle" value="{{$domicilio[0]->calle}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="numero_ext">Numero Exterior</label>
                                                <input class="form-control" id="numero_ext" type="text" name="numero_ext" placeholder="Numero Exterior" value="{{$domicilio[0]->numero_ext}}">
                                            </div>
                                            <div class="form-group col-md-4"> 
                                                <label style="color: black" for="numero_int">Numero Interior</label>
                                                <input class="form-control" id="numero_int" type="text" name="numero_int" placeholder="Numero Interior" value="{{$domicilio[0]->numero_int}}">
                                            </div>
                                            </div>
                                            <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="entre_calles">Entre Calles</label>
                                                <input class="form-control" id="entre_calles" type="text" name="entre_calles" placeholder="Entre Calles" value="{{$domicilio[0]->entre_calles}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="colonia_localidad">Colonia Localidad</label>
                                                <input class="form-control" id="colonia_localidad" type="text" name="colonia_localidad" placeholder="Colonia Localidad" value="{{$domicilio[0]->colonia_localidad}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="municipio">Municipio</label>
                                                <input class="form-control" id="municipio" type="text" name="municipio" placeholder="Municipio" value="{{$domicilio[0]->municipio}}">
                                            </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label style="color: black" for="estado">Estado</label>
                                                    <input class="form-control" id="estado" type="text" name="estado" placeholder="Estado" value="{{$domicilio[0]->estado}}">
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <label style="color: black" for="referencia_visual">Referencia Visual</label>
                                                    <input class="form-control" id="referencia_visual" type="text" name="referencia_visual" placeholder="Referencia Visual" value="{{$domicilio[0]->referencia_visual}}">
                                                </div>
                                            </div>
                                            {{-- <div class="d-flex">
                                                <button class="btn btn-primary" type="submit">Guardar datos</button>
                                            </div>
                                        </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--articulos del hogar---}}
                                @php
                                    $arhogar=DB::table('tbl_se_articulos_hogar')->select(DB::raw('count(*) as arhtotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($arhogar[0]->arhtotal==0)
                                    <br>
                                    {{-- <form method="POST" action="{{ url('art_hogar_guardar') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-1">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <label style="color: black; padding-button:10px;" class="mb-1" for="estufa">Estufa</label>
                                                <input style="width: 19px; height: 19px;" name="estufa" type="checkbox" id="cbox1" value="1">
                                                {{---<input class="form-control" type="text" id="estufa" name="estufa" value="{{old('estufa')}}" placeholder="Estufa">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="refrigerador">Refrigerador</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="refrigerador" id="cbox1" value="1">
                                                {{---<input class="form-control" id="refrigerador" type="text" name="refrigerador" value="{{old('refrigerador')}}" placeholder="Refrigerador">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="microondas">Microondas</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="microondas" id="cbox1" value="1">
                                                {{---<input class="form-control" id="microondas" type="text" name="microondas" value="{{old('microondas')}}" placeholder="Microondas">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="lavadora">Lavadora</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="lavadora" id="cbox1" value="1">
                                                {{---<input class="form-control" id="lavadora" type="text" name="lavadora" value="{{old('lavadora')}}" placeholder="Lavadora">---}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="secadora">Secadora</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="secadora" id="cbox1" value="1">
                                            {{---<input class="form-control" id="secadora" type="text" name="secadora" value="{{old('secadora')}}" placeholder="Secadora">--}}
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-1">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="computadora_escritorio">Computadora de escritorio</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="computadora_escritorio" id="cbox1" value="1">
                                                {{--<input class="form-control" id="computadora_escritorio" type="text" name="computadora_escritorio" value="{{old('computadora_escritorio')}}" placeholder="Computadora de escritorio">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="laptop">Laptop</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="laptop" id="cbox1" value="1">
                                                {{---<input class="form-control" id="laptop" type="text" name="laptop" value="{{old('laptop')}}" placeholder="Laptop">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="television">Televisión</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="television" id="cbox1" value="1">
                                                {{--<input class="form-control" id="television" type="text" name="television" value="{{old('television')}}" placeholder="Televisión">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="pantalla">Pantalla</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="pantalla" id="cbox1" value="1">
                                                {{--<input class="form-control" id="pantalla" type="text" name="pantalla" value="{{old('pantalla')}}" placeholder="Pantalla">--}}
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-1">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="grabadora">Grabadora</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="grabadora" id="cbox1" value="1">
                                                {{--<input class="form-control" id="grabadora" type="text" name="grabadora" value="{{old('grabadora')}}" placeholder="Grabadora">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="estereo">Estereo</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="estereo" id="cbox1" value="1">
                                                {{--<input class="form-control" id="estereo" type="text" name="estereo" value="{{old('estereo')}}" placeholder="Estereo">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="dvd">DvD</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="dvd" id="cbox1" value="1">
                                                {{--<input class="form-control" id="dvd" type="text" name="dvd" value="{{old('dvd')}}" placeholder="DvD">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="blue_ray">Blue Ray</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="blue_ray" id="cbox1" value="1">
                                                {{--<input class="form-control" id="blue_ray" type="text" name="blue_ray" value="{{old('blue_ray')}}" placeholder="Blue Ray">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="teatro_casa">Teatro casa</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="teatro_casa" id="cbox1" value="1">
                                                {{--<input class="form-control" id="teatro_casa" type="text" name="teatro_casa" value="{{old('teatro_casa')}}" placeholder="Teatro casa">--}}
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-1">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="bocina_portatil">Bocina Portatil</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="bocina_portatil" id="cbox1" value="1">
                                                {{--<input class="form-control" id="bocina_portatil" type="text" name="bocina_portatil" value="{{old('bocina_portatil')}}" placeholder="Bocina Portatil">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="celular">Celular</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="celular" id="cbox1" value="1">
                                                {{--<input class="form-control" id="celular" type="text" name="celular" value="{{old('celular')}}" placeholder="Celular">--}}
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="tablet">Tablet</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="tablet" id="cbox1" value="1">
                                                {{--<input class="form-control" id="tablet" type="text" name="tablet" value="{{old('tablet')}}" placeholder="Tablet">--}}
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="consola_videojuegos">Consola videojuegos</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="consola_videojuegos" id="cbox1" value="1">
                                                {{--<input class="form-control" id="consola_videojuegos" type="text" name="consola_videojuegos" value="{{old('consola_videojuegos')}}" placeholder="Consola de videojuegos">--}}
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-1">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="instrumentos">Instrumentos</label>
                                                <input style="width: 19px; height: 19px;" type="checkbox" name="instrumentos" id="cbox1" value="1">
                                                {{--<input class="form-control" id="instrumentos" type="text" name="instrumentos" value="{{old('instrumentos')}}" placeholder="Instrumentos">--}}
                                            </div>
                                            <div class=" col-md-6 d-flex">
                                                <label style="color: black" for="otros">Otros </label>
                                                <input class="ml-2 form-control" id="otros" type="text" name="otros" value="{{old('otros')}}" placeholder="Otros">
                                            </div>
                                        </div>
                                        {{-- <div class="form-row">
                                            <div class="form-group col-md-1">
                                            </div>
                                            <div class="form-group col-md-9">
                                                <button class="btn btn-primary" type="submit">Guardar datos</button>
                                            </div>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $articuloshogar=DB::table('tbl_se_articulos_hogar')
                                        ->select('tbl_se_articulos_hogar.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('art_hogar_update/'.$articuloshogar[0]->id_articulo) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                            <div class="form-row">
                                                <div class="form-group col-md-1">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black; padding-button:10px;" class="mb-1" for="estufa">Estufa</label>
                                                    @if ($articuloshogar[0]->estufa==1)
                                                        <input style="width: 19px; height: 19px;" name="estufa" type="checkbox" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" name="estufa" type="checkbox" id="cbox1" value="1">
                                                    @endif
                                                    {{---<input class="form-control" type="text" id="estufa" name="estufa" value="{{old('estufa')}}" placeholder="Estufa">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="refrigerador">Refrigerador</label>
                                                    @if ($articuloshogar[0]->refrigerador==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="refrigerador" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="refrigerador" id="cbox1" value="1">
                                                    @endif
                                                    {{---<input class="form-control" id="refrigerador" type="text" name="refrigerador" value="{{old('refrigerador')}}" placeholder="Refrigerador">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="microondas">Microondas</label>
                                                    @if ($articuloshogar[0]->microondas==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" checked name="microondas" id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="microondas" id="cbox1" value="1">
                                                    @endif
                                                    {{---<input class="form-control" id="microondas" type="text" name="microondas" value="{{old('microondas')}}" placeholder="Microondas">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="lavadora">Lavadora</label>
                                                    @if ($articuloshogar[0]->lavadora==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="lavadora" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="lavadora" id="cbox1" value="1">
                                                    @endif
                                                    {{---<input class="form-control" id="lavadora" type="text" name="lavadora" value="{{old('lavadora')}}" placeholder="Lavadora">---}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="secadora">Secadora</label>
                                                    @if ($articuloshogar[0]->secadora==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="secadora" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="secadora" id="cbox1" value="1">
                                                    @endif
                                                {{---<input class="form-control" id="secadora" type="text" name="secadora" value="{{old('secadora')}}" placeholder="Secadora">--}}
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-1">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label style="color: black" for="computadora_escritorio">Computadora de escritorio</label>
                                                    @if ($articuloshogar[0]->computadora_escritorio==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="computadora_escritorio" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="computadora_escritorio" id="cbox1" value="1">
                                                    @endif
                                                    
                                                    {{--<input class="form-control" id="computadora_escritorio" type="text" name="computadora_escritorio" value="{{old('computadora_escritorio')}}" placeholder="Computadora de escritorio">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="laptop">Laptop</label>
                                                    @if ($articuloshogar[0]->laptop==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="laptop" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="laptop" id="cbox1" value="1">
                                                    @endif
                                                    
                                                    {{---<input class="form-control" id="laptop" type="text" name="laptop" value="{{old('laptop')}}" placeholder="Laptop">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="television">Televisión</label>
                                                    @if ($articuloshogar[0]->television==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="television" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="television" id="cbox1" value="1">
                                                    @endif
                                                    {{--<input class="form-control" id="television" type="text" name="television" value="{{old('television')}}" placeholder="Televisión">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="pantalla">Pantalla</label>
                                                    @if ($articuloshogar[0]->pantalla==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="pantalla" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="pantalla" id="cbox1" value="1">
                                                    @endif
                                                    {{--<input class="form-control" id="pantalla" type="text" name="pantalla" value="{{old('pantalla')}}" placeholder="Pantalla">--}}
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-1">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="grabadora">Grabadora</label>
                                                    @if ($articuloshogar[0]->grabadora==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="grabadora" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="grabadora" id="cbox1" value="1">
                                                    @endif
                                                    {{--<input class="form-control" id="grabadora" type="text" name="grabadora" value="{{old('grabadora')}}" placeholder="Grabadora">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="estereo">Estereo</label>
                                                    @if ($articuloshogar[0]->estereo==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="estereo" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="estereo" id="cbox1" value="1">
                                                    @endif
                                                    {{--<input class="form-control" id="estereo" type="text" name="estereo" value="{{old('estereo')}}" placeholder="Estereo">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="dvd">DvD</label>
                                                    @if ($articuloshogar[0]->dvd==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="dvd" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="dvd" id="cbox1" value="1">
                                                    @endif
                                                    {{--<input class="form-control" id="dvd" type="text" name="dvd" value="{{old('dvd')}}" placeholder="DvD">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="blue_ray">Blue Ray</label>
                                                    @if ($articuloshogar[0]->blue_ray==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="blue_ray" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="blue_ray" id="cbox1" value="1">
                                                    @endif
                                                    {{--<input class="form-control" id="blue_ray" type="text" name="blue_ray" value="{{old('blue_ray')}}" placeholder="Blue Ray">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="teatro_casa">Teatro casa</label>
                                                    @if ($articuloshogar[0]->teatro_casa==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="teatro_casa" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="teatro_casa" id="cbox1" value="1">
                                                    @endif
                                                    {{--<input class="form-control" id="teatro_casa" type="text" name="teatro_casa" value="{{old('teatro_casa')}}" placeholder="Teatro casa">--}}
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-1">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="bocina_portatil">Bocina Portatil</label>
                                                    @if ($articuloshogar[0]->bocina_portatil==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="bocina_portatil" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="bocina_portatil" id="cbox1" value="1">
                                                    @endif
                                                    {{--<input class="form-control" id="bocina_portatil" type="text" name="bocina_portatil" value="{{old('bocina_portatil')}}" placeholder="Bocina Portatil">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="celular">Celular</label>
                                                    @if ($articuloshogar[0]->celular==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="celular" id="cbox1" checked value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="celular" id="cbox1" value="1">
                                                    @endif
                                                    
                                                    {{--<input class="form-control" id="celular" type="text" name="celular" value="{{old('celular')}}" placeholder="Celular">--}}
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="tablet">Tablet</label>
                                                    @if ($articuloshogar[0]->tablet==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="tablet" id="cbox1" checked value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="tablet" id="cbox1" value="1">
                                                    @endif
                                                    
                                                    {{--<input class="form-control" id="tablet" type="text" name="tablet" value="{{old('tablet')}}" placeholder="Tablet">--}}
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label style="color: black" for="consola_videojuegos">Consola videojuegos</label>
                                                    @if ($articuloshogar[0]->consola_videojuegos==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="consola_videojuegos" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="consola_videojuegos" id="cbox1" value="1">
                                                    @endif
                                                    
                                                    {{--<input class="form-control" id="consola_videojuegos" type="text" name="consola_videojuegos" value="{{old('consola_videojuegos')}}" placeholder="Consola de videojuegos">--}}
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-1">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label style="color: black" for="instrumentos">Instrumentos</label>
                                                    @if ($articuloshogar[0]->instrumentos==1)
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="instrumentos" checked id="cbox1" value="1">
                                                    @else
                                                        <input style="width: 19px; height: 19px;" type="checkbox" name="instrumentos" id="cbox1" value="1">
                                                    @endif
                                                    {{--<input class="form-control" id="instrumentos" type="text" name="instrumentos" value="{{old('instrumentos')}}" placeholder="Instrumentos">--}}
                                                </div>
                                                <div class=" col-md-6 d-flex">
                                                    <label style="color: black" for="otros">Otros </label>
                                                <input class="ml-2 form-control" id="otros" type="text" name="otros" value="{{$articuloshogar[0]->otros}}" placeholder="Otros">
                                                </div>
                                            </div>
                                            {{-- <div class="form-row">
                                                <div class="form-group col-md-1">
                                                </div>
                                                <div class="form-group col-md-9">
                                                    <button class="btn btn-primary" type="submit">Guardar cambios</button>
                                                </div>
                                            </div>
                                        </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--finanzas---}}
                                @php
                                    $finanzas=DB::table('tbl_se_finanzas')->select(DB::raw('count(*) as fintotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($finanzas[0]->fintotal==0)
                                    {{-- <form method="POST" action="{{ url('finanzas_guardar') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                            <label style="color: black" for="deuda_tarjeta_credito">Deuda en tarjeta de credito</label>
                                            <input class="form-control" id="deuda_tarjeta_credito" type="text" name="deuda_tarjeta_credito" value="{{old('deuda_tarjeta_credito')}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="deuda_otras_finanzas">Deuda en otras finanzas</label>
                                            <input class="form-control" id="deuda_otras_finanzas" type="text" name="deuda_otras_finanzas" value="{{old('deuda_otras_finanzas')}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="pension_hijos">Pensión para hijos</label>
                                            <input class="form-control" id="pension_hijos" type="text" name="pension_hijos" value="{{old('pension_hijos')}}">
                                        </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="ingresos_mensuales">Ingresos mensuales</label>
                                            <input class="form-control" id="ingresos_mensuales" type="text" name="ingresos_mensuales" value="{{old('ingresos_mensuales')}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="buro_credito">Cuenta en buro credito</label>
                                            <input class="form-control" id="buro_credito" type="text" name="buro_credito" value="{{old('buro_credito')}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button class="btn btn-primary" type="submit">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $finanzas=DB::table('tbl_se_finanzas')
                                        ->select('tbl_se_finanzas.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('finanzas_update/' .$finanzas[0]->id_finanza) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="deuda_tarjeta_credito">Deuda en tarjeta de credito</label>
                                            <input class="form-control" id="deuda_tarjeta_credito" type="text" name="deuda_tarjeta_credito" value="{{$finanzas[0]->deuda_tarjeta_credito}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="deuda_otras_finanzas">Deuda en otras finanzas</label>
                                            <input class="form-control" id="deuda_otras_finanzas" type="text" name="deuda_otras_finanzas" value="{{$finanzas[0]->deuda_otras_finanzas}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="pension_hijos">Pensión para hijos</label>
                                            <input class="form-control" id="pension_hijos" type="text" name="pension_hijos" value="{{$finanzas[0]->pension_hijos}}">
                                        </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="ingresos_mensuales">Ingresos mensuales</label>
                                            <input class="form-control" id="ingresos_mensuales" type="text" name="ingresos_mensuales" value="{{$finanzas[0]->ingresos_mensuales}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label style="color: black" for="buro_credito">Cuenta en buro credito</label>
                                            <input class="form-control" id="buro_credito" type="text" name="buro_credito" value="{{$finanzas[0]->buro_credito}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button class="btn btn-primary" type="submit">Guardar cambios</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{---fecha monto---}}
                                @php
                                    $fechamonto=DB::table('tbl_fecha_monto')->select(DB::raw('count(*) as fmtotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($fechamonto[0]->fmtotal==0)
                                    {{-- <form method="POST" action="{{ url('fecha_m_guardar') }}" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                            <label style="color: black" for="monto_credito">Monto de credito</label>
                                            <input id="monto_credito" type="text" class="form-control" name="monto_credito" value="{{ old('monto_credito') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label style="color: black" for="fecha_credito">Fecha Credito</label>
                                            <input name="fecha_credito" type="date" class="form-control" id="fecha_credito" class="form-control" value="{{ old('fecha_credito') }}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $fechamonto=DB::table('tbl_fecha_monto')
                                        ->select('tbl_fecha_monto.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('fecha_m_update/'.$fechamonto[0]->id_referencia) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label style="color: black" for="monto_credito">Monto de credito</label>
                                            <input id="monto_credito" type="text" class="form-control" name="monto_credito" value="{{ $fechamonto[0]->monto_credito }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label style="color: black" for="fecha_credito">Fecha Credito</label>
                                            <input name="fecha_credito" type="date" class="form-control" id="fecha_credito" class="form-control" value="{{ $fechamonto[0]->fecha_credito}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--gastos mensuales--}}
                                @php
                                    $gmensuales=DB::table('tbl_gastos_mensuales')->select(DB::raw('count(*) as gmtotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($gmensuales[0]->gmtotal==0)
                                    {{-- <form method="POST" action="{{ url('g_mensuales_guardar') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                            <label style="color: black" for="renta_hipoteca">Renta en hipoteca</label>
                                            <input class="form-control" type="text" id="renta_hipoteca" name="renta_hipoteca" value="{{old('renta_hipoteca')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="telefono_fijo">Telefono fijo</label>
                                            <input class="form-control" id="telefono_fijo" type="text" name="telefono_fijo" value="{{old('telefono_fijo')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="internet">Internet</label>
                                            <input class="form-control" id="internet" type="text" name="internet" value="{{old('internet')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="telefono_movil">Telefono movil</label>
                                            <input class="form-control" id="telefono_movil" type="text" name="telefono_movil" value="{{old('telefono_movil')}}">
                                        </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="cable">Cable</label>
                                            <input class="form-control" id="cable" type="text" name="cable" value="{{old('cable')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="luz">Luz</label>
                                            <input class="form-control" id="luz" type="text" name="luz" value="{{old('luz')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="gas">Gas</label>
                                            <input class="form-control" id="gas" type="text" name="gas" value="{{old('gas')}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button class="btn btn-primary" type="submit">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $gastosmensuales=DB::table('tbl_gastos_mensuales')
                                        ->select('tbl_gastos_mensuales.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('g_mensual_update/'.$gastosmensuales[0]->id_gasto_mensual) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="renta_hipoteca">Renta en hipoteca</label>
                                            <input class="form-control" type="text" id="renta_hipoteca" name="renta_hipoteca" value="{{$gastosmensuales[0]->renta_hipoteca}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="telefono_fijo">Telefono fijo</label>
                                            <input class="form-control" id="telefono_fijo" type="text" name="telefono_fijo" value="{{$gastosmensuales[0]->telefono_fijo}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="internet">Internet</label>
                                            <input class="form-control" id="internet" type="text" name="internet" value="{{$gastosmensuales[0]->internet}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="telefono_movil">Telefono movil</label>
                                            <input class="form-control" id="telefono_movil" type="text" name="telefono_movil" value="{{$gastosmensuales[0]->telefono_movil}}">
                                        </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="cable">Cable</label>
                                            <input class="form-control" id="cable" type="text" name="cable" value="{{$gastosmensuales[0]->cable}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="luz">Luz</label>
                                            <input class="form-control" id="luz" type="text" name="luz" value="{{$gastosmensuales[0]->luz}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="gas">Gas</label>
                                            <input class="form-control" id="gas" type="text" name="gas" value="{{$gastosmensuales[0]->gas}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button class="btn btn-primary" type="submit">Guardar cambios</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--gastos semanales--}}
                                @php
                                    $gsemanal=DB::table('tbl_gastos_semanales')->select(DB::raw('count(*) as gstotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($gsemanal[0]->gstotal==0)
                                    {{-- <form method="POST" action="{{ url('g_semanal_guardar') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                            <label style="color: black" for="alimentos">Alimentos</label>
                                            <input class="form-control" type="text" id="alimentos" name="alimentos" value="{{old('alimentos')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="transporte_publico">Transporte Publico</label>
                                            <input class="form-control" id="transporte_publico" type="text" name="transporte_publico" value="{{old('transporte_publico')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="gasolina">Gasolina</label>
                                            <input class="form-control" id="gasolina" type="text" name="gasolina" value="{{old('gasolina')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="educacion">Educación</label>
                                            <input class="form-control" id="educacion" type="text" name="educacion" value="{{old('educacion')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="diversion">Diversión</label>
                                            <input class="form-control" id="diversion" type="text" name="diversion" value="{{old('diversion')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="medicamentos">Medicamentos</label>
                                            <input class="form-control" id="medicamentos" type="text" name="medicamentos" value="{{old('medicamentos')}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="deportes">Deportes</label>
                                            <input style="color: black" class="form-control" id="deportes" type="text" name="deportes" value="{{old('deportes')}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button class="btn btn-primary" type="submit">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $gastossemanales=DB::table('tbl_gastos_semanales')
                                        ->select('tbl_gastos_semanales.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('g_semanal_update/' .$gastossemanales[0]->id_gasto_semanal) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="alimentos">Alimentos</label>
                                            <input class="form-control" type="text" id="alimentos" name="alimentos" value="{{$gastossemanales[0]->alimentos}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="transporte_publico">Transporte Publico</label>
                                            <input class="form-control" id="transporte_publico" type="text" name="transporte_publico" value="{{$gastossemanales[0]->transporte_publico}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="gasolina">Gasolina</label>
                                            <input class="form-control" id="gasolina" type="text" name="gasolina" value="{{$gastossemanales[0]->gasolina}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="educacion">Educación</label>
                                            <input class="form-control" id="educacion" type="text" name="educacion" value="{{$gastossemanales[0]->educacion}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="diversion">Diversión</label>
                                            <input class="form-control" id="diversion" type="text" name="diversion" value="{{$gastossemanales[0]->diversion}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="medicamentos">Medicamentos</label>
                                            <input class="form-control" id="medicamentos" type="text" name="medicamentos" value="{{$gastossemanales[0]->medicamentos}}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label style="color: black" for="deportes">Deportes</label>
                                            <input style="color: black" class="form-control" id="deportes" type="text" name="deportes" value="{{$gastossemanales[0]->deportes}}">
                                        </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button class="btn btn-primary" type="submit">Guardar cambios</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--referencia laboral---}}
                                @php
                                    $rlaboral=DB::table('tbl_se_referencia_laboral')->select(DB::raw('count(*) as rltotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($rlaboral[0]->rltotal==0)
                                    {{-- <form method="POST" action="{{ url('r_laboral_guardar') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <label style="color: black" for="nombre_empresa">Nombre empresa</label>
                                                <input class="form-control" id="nombre_empresa" type="text" name="nombre_empresa" value="{{old('nombre_empresa')}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="actividad_empresa">Actividad empresa</label>
                                                <input class="form-control" id="actividad_empresa" type="text" name="actividad_empresa" value="{{old('actividad_empresa')}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="cargo_empresa">Cargo empresa</label>
                                                <input class="form-control" id="cargo_empresa" type="text" name="cargo_empresa" value="{{old('cargo_empresa')}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label style="color: black" for="direccion">Dirección</label>
                                                <input class="form-control" id="direccion" type="text" name="direccion" value="{{old('direccion')}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="numero_ext">Numero exterior</label>
                                                <input class="form-control" id="numero_ext" type="text" name="numero_ext" value="{{old('numero_ext')}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="numero_int">Numero interior</label>
                                                <input class="form-control" id="numero_int" type="text" name="numero_int" value="{{old('numero_int')}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label style="color: black" for="entre_calles">Entre calles</label>
                                                <input class="form-control" id="entre_calles" type="text" name="entre_calles" value="{{old('entre_calles')}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="telefono_empresa">Teléfono empresa</label>
                                                <input class="form-control" id="telefono_empresa" type="number" name="telefono_empresa" value="{{old('telefono_empresa')}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="tiempo_empresa">Tiempo empresa</label>
                                                <input class="form-control" id="tiempo_empresa" type="text" name="tiempo_empresa" value="{{old('tiempo_empresa')}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label style="color: black" for="jefe_inmediato">Jefe inmediato</label>
                                                <input class="form-control" id="jefe_inmediato" type="text" name="jefe_inmediato" value="{{old('jefe_inmediato')}}">
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $referencialbpersonas=DB::table('tbl_se_rl_personas')
                                        ->join('tbl_se_referencia_laboral','tbl_se_rl_personas.id_referencia_laboral','=','tbl_se_referencia_laboral.id_referencia_laboral')
                                        ->select('tbl_se_rl_personas.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('r_l_presonas_update/'.$referencialbpersonas[0]->id_rl_persona) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="nombre_empresa">Nombre empresa</label>
                                                <input class="form-control" id="nombre_empresa" type="text" name="nombre_empresa" value="{{$referencialbpersonas[0]->nombre_empresa}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="actividad_empresa">Actividad empresa</label>
                                                <input class="form-control" id="actividad_empresa" type="text" name="actividad_empresa" value="{{$referencialbpersonas[0]->actividad_empresa}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="cargo_empresa">Cargo empresa</label>
                                                <input class="form-control" id="cargo_empresa" type="text" name="cargo_empresa" value="{{$referencialbpersonas[0]->cargo_empresa}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label style="color: black" for="direccion">Dirección</label>
                                                <input class="form-control" id="direccion" type="text" name="direccion" value="{{$referencialbpersonas[0]->direccion}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="numero_ext">Numero exterior</label>
                                                <input class="form-control" id="numero_ext" type="text" name="numero_ext" value="{{$referencialbpersonas[0]->numero_ext}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="numero_int">Numero interior</label>
                                                <input class="form-control" id="numero_int" type="text" name="numero_int" value="{{$referencialbpersonas[0]->numero_int}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label style="color: black" for="entre_calles">Entre calles</label>
                                                <input class="form-control" id="entre_calles" type="text" name="entre_calles" value="{{$referencialbpersonas[0]->entre_calles}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="telefono_empresa">Teléfono empresa</label>
                                                <input class="form-control" id="telefono_empresa" type="number" name="telefono_empresa" value="{{$referencialbpersonas[0]->telefono_empresa}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="tiempo_empresa">Tiempo empresa</label>
                                                <input class="form-control" id="tiempo_empresa" type="text" name="tiempo_empresa" value="{{$referencialbpersonas[0]->tiempo_empresa}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label style="color: black" for="jefe_inmediato">Jefe inmediato</label>
                                                <input class="form-control" id="jefe_inmediato" type="text" name="jefe_inmediato" value="{{$referencialbpersonas[0]->jefe_inmediato}}">
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--referencia personal--}}
                                @php
                                    $rpersonal=DB::table('tbl_se_referencia_personal')->select(DB::raw('count(*) as rptotal'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($rpersonal[0]->rptotal==0)
                                    {{-- <form method="POST" action="{{ url('r_personal_guardar') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <label style="color: black" for="nombre">Nombre</label>
                                                <input class="form-control" id="nombre" type="text" name="nombre" value="{{old('nombre')}}">
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label style="color: black" for="domicilio">Domicilio</label>
                                                <input class="form-control" id="domicilio" type="text" name="domicilio" value="{{old('domicilio')}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="telefono">Teléfono</label>
                                                <input class="form-control" id="telefono" type="number" name="telefono" value="{{old('telefono')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="relacion">Relación</label>
                                                <input class="form-control" id="relacion" type="text" name="relacion" value="{{old('relacion')}}">
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar datos</button>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $referenciappersonas=DB::table('tbl_se_rp_personas')
                                        ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_referencia_personal.id_referencia_personal')
                                        ->select('tbl_se_rp_personas.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('r_personal_update/' .$referenciappersonas[0]->id_rp_persona) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                        {{-- {{ method_field('PATCH') }} --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="nombre">Nombre</label>
                                                <input class="form-control" id="nombre" type="text" name="nombre" value="{{$referenciappersonas[0]->nombre}}">
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label style="color: black" for="domicilio">Domicilio</label>
                                                <input class="form-control" id="domicilio" type="text" name="domicilio" value="{{$referenciappersonas[0]->domicilio}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="telefono">Teléfono</label>
                                                <input class="form-control" id="telefono" type="number" name="telefono" value="{{$referenciappersonas[0]->telefono}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="relacion">Relación</label>
                                                <input class="form-control" id="relacion" type="text" name="relacion" value="{{$referenciappersonas[0]->relacion}}">
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--datos generales--}}
                                @php
                                    $tdpersonal=DB::table('tbl_se_datos_generales')->select(DB::raw('count(*) as td_total'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($tdpersonal[0]->td_total==0)
                                    <style>
                                        .input_m {text-transform: uppercase;}
                                        .input_c {text-transform: capitalize;}
                                    </style>
                                    {{-- <form method="POST" action="{{ url('guardar-datos-generales') }}">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <label style="color: black" for="curp">CURP</label>
                                                <input class="form-control input_m" id="curp" type="text" name="curp" value="{{old('curp')}}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="nombre">Nombre</label>
                                                <input class="form-control input_c" id="nombre" type="text" name="nombre" value="{{old('nombre')}}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="ap_paterno">Apellido paterno</label>
                                                <input class="form-control input_c" id="ap_paterno" type="text" name="ap_paterno" value="{{old('ap_paterno')}}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="ap_materno">Apellido materno</label>
                                                <input class="form-control input_c" id="ap_materno" type="text" name="ap_materno" value="{{old('ap_materno')}}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="fecha_nacimiento">Fecha de nacimiento</label>
                                                <input class="form-control" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}" required>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label style="color: black" for="edad">Edad</label>
                                                <input class="form-control" id="edad" type="number" name="edad" value="{{old('edad')}}" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="ocupacion">Ocupación</label>
                                                <input class="form-control input_c" id="ocupacion" type="text" name="ocupacion" value="{{old('ocupacion')}}" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="genero">Género</label>
                                                <input class="form-control input_c" id="genero" type="text" name="genero" value="{{old('genero')}}" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="estado_civil">Estado civil</label>
                                                <input class="form-control input_c" id="estado_civil" type="text" name="estado_civil" value="{{old('estado_civil')}}" required>
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar datos</button>
                                        </div>
                                    </form> --}}
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el registro!
                                    </div>
                                    @php
                                        $datos_generales=DB::table('tbl_se_datos_generales')
                                        // ->join('tbl_se_referencia_personal','tbl_se_datos_generales.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                        ->select('tbl_se_datos_generales.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->get();
                                    @endphp
                                    {{-- <form method="POST" action="{{ url('actualizar-datos-generales/'.$datos_generales[0]->id_datos_generales) }}" enctype="multipart/form-data">
                                        {{ csrf_field() }} --}}
                                          {{-- {{ method_field('PATCH') }} --}}
                                          <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <label style="color: black" for="curp">CURP</label>
                                                <input class="form-control input_m" id="curp" type="text" name="curp" value="{{$datos_generales[0]->curp,old('curp')}}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="nombre">Nombre</label>
                                                <input class="form-control input_c" id="nombre" type="text" name="nombre" value="{{$datos_generales[0]->nombre,old('nombre')}}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="ap_paterno">Apellido paterno</label>
                                                <input class="form-control input_c" id="ap_paterno" type="text" name="ap_paterno" value="{{$datos_generales[0]->ap_paterno,old('ap_paterno')}}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="ap_materno">Apellido materno</label>
                                                <input class="form-control input_c" id="ap_materno" type="text" name="ap_materno" value="{{$datos_generales[0]->ap_materno,old('ap_materno')}}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label style="color: black" for="fecha_nacimiento">Fecha de nacimiento</label>
                                                <input class="form-control" id="fecha_nacimiento" type="text" name="fecha_nacimiento" value="{{$datos_generales[0]->fecha_nacimiento,old('fecha_nacimiento')}}" required>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label style="color: black" for="edad">Edad</label>
                                                <input class="form-control" id="edad" type="number" name="edad" value="{{$datos_generales[0]->edad,old('edad')}}" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label style="color: black" for="ocupacion">Ocupación</label>
                                                <input class="form-control input_c" id="ocupacion" type="text" name="ocupacion" value="{{$datos_generales[0]->ocupacion,old('ocupacion')}}" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="genero">Género</label>
                                                <input class="form-control input_c" id="genero" type="text" name="genero" value="{{$datos_generales[0]->genero,old('genero')}}" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label style="color: black" for="estado_civil">Estado civil</label>
                                                <input class="form-control input_c" id="estado_civil" type="text" name="estado_civil" value="{{$datos_generales[0]->estado_civil,old('estado_civil')}}" required>
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Actualizar datos</button>
                                        </div>
                                        
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--doc prospecto--}}
                                @php
                                    $doc_ine_1=DB::table('tbl_se_documentos')->select(DB::raw('count(*) as doc_total_ine_1'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->where('tipo_persona','=',1)
                                    ->where('tipo_foto','=',1)
                                    ->get();
                                @endphp
                                @if ($doc_ine_1[0]->doc_total_ine_1==0)
                                    <div class="col-md-12 mb-3" style="border-bottom: 1px solid #000; color: #000">
                                        <center>
                                            Cargar aquí las imágenes del prospecto
                                        </center>
                                    </div>
                                    {{-- <form method="POST" action="{{ url('guardar-documento') }}" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="form-row">
                                            
                                            <div class="form-group col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <input type="hidden" name="tipo_persona" value="1">
        
                                                <input type="hidden" name="tipo_foto" value="1">
                                                <label style="color: black" for="nombre">Imágen 1 Frente del INE </label>
                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar imagen</button>
                                        </div>
                                    </form> --}}
                                    <br><br>
                                @else
                                    <div class="col-md-12" style="border-bottom: 1px solid #000; color: #000">
                                        <b>Imágen 1 INE (Frente del INE)</b>
                                    </div>
                                    @php
                                        $docs_ine_1=DB::table('tbl_se_documentos')
                                        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                        ->select('tbl_se_documentos.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->where('tipo_persona','=',1)
                                        ->where('tipo_foto','=',1)
                                        ->get();
                                    @endphp
                                    <div class="row">
                                        @if (count($docs_ine_1)==0)
                                        <center>Sin datos</center>
                                        @else 
                                            @foreach ($docs_ine_1 as $doc_ine_1)
                                                <div class="col-md-6">
                                                    @if(empty($doc_ine_1->path_url))
                                                    <center>Sin url</center>
                                                    @else
                                                        <br>
                                                        @php
                                                            $ub=str_split($doc_ine_1->path_url);
                                                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                                                        @endphp
                                                        @if ($ubicacion=='DocImagenes')
                                                            <img src="{{$doc_ine_1->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="240">  
                                                        @else
                                                                <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$doc_ine_1->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="240">  
                
                                                        @endif
                                                    @endif
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <form method="POST" action="{{ url('actualizar-documento/'.$doc_ine_1->id_documento)}}" enctype="multipart/form-data">
                                                        @csrf --}}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12 mt-3">
                                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                                
                                                                <label style="color: black" for="nombre"><small><i>Seleccione una nueva imágen para actualizarla (jpeg,png,jpg)</i></small></label>
                                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary">Actualizar imágen</button>
                                                        </div>
                                                    </form> --}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                                <br><br>
                                {{-- imagen ine 2  prospecto--}}
                                @php
                                    $doc_ine_2=DB::table('tbl_se_documentos')->select(DB::raw('count(*) as doc_total_ine_2'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->where('tipo_persona','=',1)
                                    ->where('tipo_foto','=',2)
                                    ->get();
                                @endphp
                                @if ($doc_ine_2[0]->doc_total_ine_2==0)
                                    {{-- <form method="POST" action="{{ url('guardar-documento') }}" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <input type="hidden" name="tipo_persona" value="1">
        
                                                <input type="hidden" name="tipo_foto" value="2">
                                                <label style="color: black" for="nombre">Imágen 2 Atrás del INE </label>
                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar imágen</button>
                                        </div>
                                    </form> --}}
                                    <br><br>
                                @else
                                    <div class="col-md-12" style="border-bottom: 1px solid #000; color: #000">
                                        <b>Imágen 2 INE (Atrás del INE)</b>
                                    </div>
                                    @php
                                        $docs_ine_2=DB::table('tbl_se_documentos')
                                        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                        ->select('tbl_se_documentos.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->where('tipo_persona','=',1)
                                        ->where('tipo_foto','=',2)
                                        ->get();
                                    @endphp
                                    <div class="row">
                                        @if (count($docs_ine_2)==0)
                                        <center>Sin datos</center>
                                        @else 
                                            @foreach ($docs_ine_2 as $doc_ine_2)
                                                <div class="col-md-6">
                                                    @if(empty($doc_ine_2->path_url))
                                                    <center>Sin url</center>
                                                    @else
                                                        <br>
                                                        @php
                                                            $ub=str_split($doc_ine_2->path_url);
                                                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                                                        @endphp
                                                        @if ($ubicacion=='DocImagenes')
                                                            <img src="{{$doc_ine_2->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="240">  
                                                        @else
                                                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$doc_ine_2->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="240">  
                                                        @endif
                                                    @endif
                                                   
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <form method="POST" action="{{ url('actualizar-documento/'.$doc_ine_2->id_documento)}}" enctype="multipart/form-data">
                                                        @csrf --}}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12 mt-3">
                                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                                
                                                                <label style="color: black" for="nombre"><small><i>Seleccione una nueva imágen para actualizarla (jpeg,png,jpg)</i></small></label>
                                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary">Actualizar imágen</button>
                                                        </div>
                                                    </form> --}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                                <br><br>
                                {{-- imagen comprobante de domicilio prospecto --}}
                                @php
                                    $doc_comprobante=DB::table('tbl_se_documentos')->select(DB::raw('count(*) as doc_total_comprobante'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->where('tipo_persona','=',1)
                                    ->where('tipo_foto','=',3)
                                    ->get();
                                @endphp
                                @if ($doc_comprobante[0]->doc_total_comprobante==0)
                                    {{-- <form method="POST" action="{{ url('guardar-documento') }}" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <input type="hidden" name="tipo_persona" value="1">
        
                                                <input type="hidden" name="tipo_foto" value="3">
                                                <label style="color: black" for="nombre">Imágen 3 Comprobante de domicilio </label>
                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar imágen</button>
                                        </div>
                                    </form> --}}
                                    <br><br>
                                @else
                                    <div class="col-md-12" style="border-bottom: 1px solid #000; color: #000">
                                        <b>Imágen 3 Comprobante de domicilio</b>
                                    </div>
                                    @php
                                        $docs_comprobante=DB::table('tbl_se_documentos')
                                        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                        ->select('tbl_se_documentos.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->where('tipo_persona','=',1)
                                        ->where('tipo_foto','=',3)
                                        ->get();
                                    @endphp
                                    <div class="row">
                                        
                                        @if (count($docs_comprobante)==0)
                                        <center>Sin datos</center>
                                        @else 
                                        
                                            @foreach ($docs_comprobante as $doc_comprobante)
                                                <div class="col-md-6">
                                                    @if(empty($doc_comprobante->path_url))
                                                    <center>Sin url</center>
                                                    @else
                                                        <br>
                                                        @php
                                                            $ub=str_split($doc_comprobante->path_url);
                                                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                                                        @endphp
                                                        @if ($ubicacion=='DocImagenes')
                                                            <img class="responsive-img materialboxed" src="{{$doc_comprobante->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="450">  
                                                        @else
                                                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$doc_comprobante->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="450">  
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <form method="POST" action="{{ url('actualizar-documento/'.$doc_comprobante->id_documento)}}" enctype="multipart/form-data">
                                                        @csrf --}}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12 mt-3">
                                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                                
                                                                <label style="color: black" for="nombre"><small><i>Seleccione una nueva imágen para actualizarla (jpeg,png,jpg)</i></small></label>
                                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary">Actualizar imágen</button>
                                                        </div>
                                                    </form> --}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                                <br><br>
                                {{-- foto perfil prospecto --}}
                                @php
                                    $doc_perfil=DB::table('tbl_se_documentos')->select(DB::raw('count(*) as doc_total_perfil'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->where('tipo_persona','=',1)
                                    ->where('tipo_foto','=',4)
                                    ->get();
                                @endphp
                                @if ($doc_perfil[0]->doc_total_perfil==0)
                                    {{-- <form method="POST" action="{{ url('guardar-documento') }}" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <input type="hidden" name="tipo_persona" value="1">
        
                                                <input type="hidden" name="tipo_foto" value="4">
                                                <label style="color: black" for="nombre">Imágen 4 Foto de perfil </label>
                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar imágen</button>
                                        </div>
                                    </form> --}}
                                    <br><br>
                                @else
                                    <div class="col-md-12" style="border-bottom: 1px solid #000; color: #000">
                                        <b>Imágen 4 Foto de perfil </b>
                                    </div>
                                    @php
                                        $docs_perfil=DB::table('tbl_se_documentos')
                                        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                        ->select('tbl_se_documentos.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->where('tipo_persona','=',1)
                                        ->where('tipo_foto','=',4)
                                        ->get();
                                    @endphp
                                    <div class="row">
                                        @if (count($docs_perfil)==0)
                                        <center>Sin datos</center>
                                        @else 
                                            @foreach ($docs_perfil as $doc_perfil)
                                                <div class="col-md-6">
                                                    @if(empty($doc_perfil->path_url))
                                                    <center>Sin url</center>
                                                    @else
                                                        <br>
                                                        @php
                                                            $ub=str_split($doc_perfil->path_url);
                                                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                                                        @endphp
                                                        @if ($ubicacion=='DocImagenes')
                                                            <img class="responsive-img materialboxed" src="{{$doc_perfil->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="350" height="450">
                                                        @else
                                                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$doc_perfil->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="350" height="450">
                                                        @endif
                                                    @endif
                                                      
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <form method="POST" action="{{ url('actualizar-documento/'.$doc_perfil->id_documento)}}" enctype="multipart/form-data">
                                                        @csrf --}}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12 mt-3">
                                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                                
                                                                <label style="color: black" for="nombre"><small><i>Seleccione una nueva imágen para actualizarla (jpeg,png,jpg)</i></small></label>
                                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary">Actualizar imágen</button>
                                                        </div>
                                                    </form> --}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                                <br><br>
        
                                {{-- referencia prospecto --}}
                                @php
                                    $doc_referencia=DB::table('tbl_se_documentos')->select(DB::raw('count(*) as doc_total_referencia'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->where('tipo_persona','=',1)
                                    ->where('tipo_foto','=',5)
                                    ->get();
                                @endphp
                                @if ($doc_referencia[0]->doc_total_referencia==0)
                                    {{-- <form method="POST" action="{{ url('guardar-documento') }}" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <input type="hidden" name="tipo_persona" value="1">
        
                                                <input type="hidden" name="tipo_foto" value="5">
                                                <label style="color: black" for="nombre">Imágen 5 Foto de referencia </label>
                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar imágen</button>
                                        </div>
                                    </form> --}}
                                    <br><br>
                                @else
                                    <div class="col-md-12" style="border-bottom: 1px solid #000; color: #000">
                                        <b>Imágen 5 Foto de referencia</b>
                                    </div>
                                    @php
                                        $docs_referencia=DB::table('tbl_se_documentos')
                                        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                        ->select('tbl_se_documentos.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->where('tipo_persona','=',1)
                                        ->where('tipo_foto','=',5)
                                        ->get();
                                    @endphp
                                    <div class="row">
                                        @if (count($docs_referencia)==0)
                                        <center>Sin datos</center>
                                        @else 
                                            @foreach ($docs_referencia as $doc_referencia)
                                                <div class="col-md-6">
                                                    {{-- {{$docs_ine_1}} --}}
                                                    @if(empty($doc_referencia->path_url))
                                                    <center>Sin url</center>
                                                    @else
                                                        <br>
                                                        @php
                                                            $ub=str_split($doc_referencia->path_url);
                                                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                                                        @endphp
                                                        @if ($ubicacion=='DocImagenes')
                                                        <img class="responsive-img materialboxed" src="{{$doc_referencia->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="350" height="450">  
                                                            
                                                        @else
                                                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$doc_referencia->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="350" height="450">  
                                                        @endif
                                                    @endif
                                                
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <form method="POST" action="{{ url('actualizar-documento/'.$doc_referencia->id_documento)}}" enctype="multipart/form-data">
                                                        @csrf --}}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12 mt-3">
                                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                                
                                                                <label style="color: black" for="nombre"><small><i>Seleccione una nueva imágen para actualizarla (jpeg,png,jpg)</i></small></label>
                                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary">Actualizar imágen</button>
                                                        </div>
                                                    </form> --}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--doc aval--}}
                                @php
                                    $doc_ine_1=DB::table('tbl_se_documentos')->select(DB::raw('count(*) as doc_total_ine_1'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->where('tipo_persona','=',2)
                                    ->where('tipo_foto','=',1)
                                    ->get();
                                @endphp
                                @if ($doc_ine_1[0]->doc_total_ine_1==0)
                                    {{-- <form method="POST" action="{{ url('guardar-documento') }}" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3" style="border-bottom: 1px solid #000; color: #000">
                                                <center>
                                                    Cargar aquí las imágenes del aval
                                                </center>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <input type="hidden" name="tipo_persona" value="2">
        
                                                <input type="hidden" name="tipo_foto" value="1">
                                                <label style="color: black" for="nombre">Frente del INE </label>
                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar imágen</button>
                                        </div>
                                    </form> --}}
                                    <br><br>
                                @else
                                    <div class="col-md-12" style="border-bottom: 1px solid #000; color: #000">
                                        <b>Imágen 1 INE (Frente del INE)</b>
                                    </div>
                                    @php
                                        $docs_ine_1=DB::table('tbl_se_documentos')
                                        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                        ->select('tbl_se_documentos.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->where('tipo_persona','=',2)
                                        ->where('tipo_foto','=',1)
                                        ->get();
                                        
                                    @endphp
                                    <div class="row">
                                        @if (count($docs_ine_1)==0)
                                        <center>Sin datos</center>
                                        @else 
                                            @foreach ($docs_ine_1 as $doc_ine_1)
                                                <div class="col-md-6">
                                                    @if(empty($doc_ine_1->path_url))
                                                    <center>Sin url</center>
                                                    @else
                                                        <br>
                                                        @php
                                                            $ub=str_split($doc_ine_1->path_url);
                                                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                                                        @endphp
                                                        @if ($ubicacion=='DocImagenes')
                                                            <img class="responsive-img materialboxed" src="{{$doc_ine_1->path_url}}" style="border:1px solid #000; border-radius: 6px;" alt="Este es el ejemplo de un texto alternativo" width="400" height="240">  
                                                        @else
                                                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$doc_ine_1->path_url}}" style="border:1px solid #000; border-radius: 6px;" alt="Este es el ejemplo de un texto alternativo" width="400" height="240">  
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <form method="POST" action="{{ url('actualizar-documento/'.$doc_ine_1->id_documento)}}" enctype="multipart/form-data">
                                                        @csrf --}}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12 mt-3">
                                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                                <label style="color: black" for="nombre"><small><i>Seleccione una nueva imágen para actualizarla (jpeg,png,jpg)</i></small></label>
                                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary">Actualizar imágen</button>
                                                        </div>
                                                    </form> --}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                                <br><br>
                                {{-- imagen ine 2 --}}
                                @php
                                    $doc_ine_2=DB::table('tbl_se_documentos')->select(DB::raw('count(*) as doc_total_ine_2'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->where('tipo_persona','=',2)
                                    ->where('tipo_foto','=',2)
                                    ->get();
                                @endphp
                                @if ($doc_ine_2[0]->doc_total_ine_2==0)
                                    {{-- <form method="POST" action="{{ url('guardar-documento') }}" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <input type="hidden" name="tipo_persona" value="2">
        
                                                <input type="hidden" name="tipo_foto" value="2">
                                                <label style="color: black" for="nombre">Atrás del INE </label>
                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar imágen</button>
                                        </div>
                                    </form> --}}
                                    <br><br>
                                @else
                                    <div class="col-md-12" style="border-bottom: 1px solid #000; color: #000">
                                        <b>Imágen 2 INE (Atras del INE)</b>
                                    </div>
                                    @php
                                        $docsa_ine_2=DB::table('tbl_se_documentos')
                                        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                        ->select('tbl_se_documentos.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->where('tipo_persona','=',2)
                                        ->where('tipo_foto','=',2)
                                        ->get();
                                    @endphp
                                    <div class="row">
                                        @if (count($docsa_ine_2)==0)
                                        <center>Sin datos</center>
                                        @else 
                                            @foreach ($docsa_ine_2 as $doc_ine_2)
                                                <div class="col-md-6">
                                                    @if(empty($doc_ine_2->path_url))
                                                    <center>Sin url</center>
                                                    @else
                                                        <br>
                                                        @php
                                                            $ub=str_split($doc_ine_2->path_url);
                                                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                                                        @endphp
                                                        @if ($ubicacion=='DocImagenes')
                                                            <img class="responsive-img materialboxed" src="{{$doc_ine_2->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="240">  
                                                        @else
                                                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$doc_ine_2->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="240">  
                
                                                        @endif
                                                     @endif
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <form method="POST" action="{{ url('actualizar-documento/'.$doc_ine_2->id_documento)}}" enctype="multipart/form-data">
                                                        @csrf --}}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12 mt-3">
                                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                                <label style="color: black" for="nombre"><small><i>Seleccione una nueva imágen para actualizarla (jpeg,png,jpg)</i></small></label>
                                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary">Actualizar imágen</button>
                                                        </div>
                                                    </form> --}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                                <br><br>
                                {{-- imagen comprobante de domicilio --}}
                                @php
                                    $doc_comprobante=DB::table('tbl_se_documentos')->select(DB::raw('count(*) as doc_total_comprobante'))
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->where('tipo_persona','=',2)
                                    ->where('tipo_foto','=',3)
                                    ->get();
                                @endphp
                                @if ($doc_comprobante[0]->doc_total_comprobante==0)
                                    {{-- <form method="POST" action="{{ url('guardar-documento') }}" enctype="multipart/form-data">
                                        @csrf --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                <input type="hidden" name="tipo_persona" value="2">
        
                                                <input type="hidden" name="tipo_foto" value="3">
                                                <label style="color: black" for="nombre">Comprobante de domicilio </label>
                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="d-flex">
                                        <button type="submit" class="btn btn-primary">Guardar imágen</button>
                                        </div>
                                    </form> --}}
                                    <br><br>
                                @else
                                    <div class="col-md-12" style="border-bottom: 1px solid #000; color: #000">
                                        <b>Comprobante de domicilio</b>
                                    </div>
                                    @php
                                        $docs_comprobante=DB::table('tbl_se_documentos')
                                        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                        ->select('tbl_se_documentos.*')
                                        ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                        ->where('tipo_persona','=',2)
                                        ->where('tipo_foto','=',3)
                                        ->get();
                                    @endphp
                                    <div class="row">
                                        @if (count($docs_comprobante)==0)
                                        <center>Sin datos</center>
                                        @else
                                            @foreach ($docs_comprobante as $doc_comprobante)
                                                <div class="col-md-6">
                                                    @if(empty($doc_comprobante->path_url))
                                                    <center>Sin url</center>
                                                    @else
                                                        <br>
                                                        @php
                                                            $ub=str_split($doc_comprobante->path_url);
                                                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                                                        @endphp
                                                        @if ($ubicacion=='DocImagenes')
                                                            <img class="responsive-img materialboxed" src="{{$doc_comprobante->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="450">  
                                                        @else
                                                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$doc_comprobante->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="400" height="450">  
                                                        @endif
                                                    @endif
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    {{-- <form method="POST" action="{{ url('actualizar-documento/'.$doc_comprobante->id_documento)}}" enctype="multipart/form-data">
                                                        @csrf --}}
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12 mt-3">
                                                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                                                <label style="color: black" for="nombre"><small><i>Seleccione una nueva imágen para actualizarla (jpeg,png,jpg)</i></small></label>
                                                                <input class="form-control" id="nombre" type="file" name="imagen" required>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- <div class="d-flex">
                                                        <button type="submit" class="btn btn-primary">Actualizar imágen</button>
                                                        </div>
                                                    </form> --}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tabPanel">
                        <br><br><br><br><br><br><br>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                {{--finalizacion--}}
                                @php
                                    $estatus=DB::table('tbl_socio_economico')
                                    ->select('tbl_socio_economico.*')
                                    ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                    ->get();
                                @endphp
                                @if ($estatus[0]->estatus==0)
                                    {{-- <form action="{{url('c_finalizacion')}}" method="post">
                                        @csrf --}}
                                        <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                        <center>
                                            {{-- <button type="submit" class="btn btn-success" onclick="return confirm('¿Seguro que quiere finalizar el socioeconómico?')">Finalizar socioeconomico</button> --}}
                                        </center>
                                    </form>
                                @else
                                    <div class="alert alert-success" role="alert">
                                        ¡Felicidades ya ha completado el socioeconomico!
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            
        @endif
</div>
{{--modal de registro de nuevo aval---}}
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Registro de nuevo aval</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        {{-- <form method="POST" action="{{ url('aval_guardar') }}">
                            @csrf --}}
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <small>CURP</small>
                                    <input class="form-control" type="text" id="curp" name="curp" value="{{old('nombre')}}" placeholder="CURP" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Nombre</small>
                                    <input class="form-control" type="text" id="nombre" name="nombre" value="{{old('nombre')}}" placeholder="Nombre" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Ap. Paterno</small>
                                    <input class="form-control" id="ap_paterno" type="text" name="ap_paterno" value="{{old('ap_paterno')}}" placeholder="Apellido Paterno" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Ap. Materno</small>
                                    <input class="form-control" id="ap_materno" type="text" name="ap_materno" value="{{old('ap_materno')}}" placeholder="Apellido Materno" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Fecha de nacimiento</small>
                                    <input class="form-control" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}" placeholder="Fecha Nacimiento" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Ocupación</small>
                                    <input class="form-control" id="ocupacion" type="text" name="ocupacion" value="{{old('ocupacion')}}" placeholder="Ocupación" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Género</small>
                                    <input class="form-control" id="genero" type="text" name="genero" value="{{old('genero')}}" placeholder="Genero" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Estado civil</small>
                                    <input class="form-control" id="estado_civil" type="text" name="estado_civil" value="{{old('estado_civil')}}" placeholder="Estado Civil" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Calle</small>
                                    <input class="form-control" id="calle" type="text" name="calle" value="{{old('calle')}}" placeholder="Calle" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>No. Exterior</small>
                                    <input class="form-control" id="numero_ext" type="text" name="numero_ext" value="{{old('numero_ext')}}" placeholder="Numero Exterior" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>No. Interior</small>
                                    <input class="form-control" id="numero_int" type="text" name="numero_int" value="{{old('numero_int')}}" placeholder="Numero Interior" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Entre calles</small>
                                    <input class="form-control" id="entre_calles" type="text" name="entre_calles" value="{{old('entre_calles')}}" placeholder="Entre Calles" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Colonia</small>
                                    <input class="form-control" id="colonia" type="text" name="colonia" value="{{old('colonia')}}" placeholder="Colonia" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Municipio</small>
                                    <input class="form-control" id="municipio" type="text" name="municipio" value="{{old('municipio')}}" placeholder="Municipio" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Estado</small>
                                    <input class="form-control" id="estado" type="text" name="estado" value="{{old('estado')}}" placeholder="Estado" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Referencia visual</small>
                                    <input class="form-control" id="referencia_visual" type="text" name="referencia_visual" value="{{old('referencia_visual')}}" placeholder="Referencia Visual" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Vivienda</small>
                                    <input class="form-control" id="vivienda" type="text" name="vivienda" value="{{old('vivienda')}}" placeholder="Vivienda" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Tiempo viviendo en el domicilio</small>
                                    <input class="form-control" id="tiempo_viviendo_domicilio" type="text" name="tiempo_viviendo_domicilio" value="{{old('tiempo_viviendo_domicilio')}}" placeholder="Tiempo Viviendo en el Domicilio" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Teléfono casa</small>
                                    <input class="form-control" id="telefono_casa" type="text" name="telefono_casa" value="{{old('telefono_casa')}}" placeholder="Telefono Casa" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Teléfono móvil</small>
                                    <input class="form-control" id="telefono_movil" type="text" name="telefono_movil" value="{{old('telefono_movil')}}" placeholder="Telefono Movil" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Teléfono trabajo</small>
                                    <input class="form-control" id="telefono_trabajo" type="text" name="telefono_trabajo" value="{{old('telefono_trabajo')}}" placeholder="Telefono Trabajo" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Fecha de registro</small>
                                    <input class="form-control" id="relacion_solicitante" type="date" name="fecha_registro" required>
                                </div>
                            </div>
                    <hr>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-round waves-effect">Guardar datos</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
                </form>
            </div> --}}
        </div>
    </div>
</div>


@stop
@section('page-script')
<script>
    function aval(){
    $("#largeModal").modal();
    }
    
</script>
<script src="js/scripttab.js">
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