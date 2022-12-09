@extends('layouts.master')
@section('title', 'Registro socioeconómico')
@section('parentPageTitle', 'Socio Económico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<!--<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.css')}}"/>-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">-->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        @php
        // $diferencia_en_dias = $fecha_actual->diffInDays($socioe->fecha_actualizacion);
            $interval=$fecha_actual->diff($soci[0]->fecha_actualizacion);
            $intervalMeses=$interval->format("%m");
        @endphp
        @if ($intervalMeses>=6)
            
            <span class="badge badge-warning">Se requiere actualización del socioeconómico. Última actualizaición hace {{$intervalMeses}} meses. <br> Por favor revise cada apartado para actualizar sus datos.</span></td>
            
        @else
            
        @endif
    {{-- <a href="{{route('socioeconomico.index')}}" class="btn btn-dark btn-sm"><-Regresar</a> --}}
    <h5>Socioeconómico de: {{$soci[0]->nombre_usuario}}</h5>
    </div>
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
        <div class="tabContainer">
            <div class="buttonContainer">
                <button id="buton_0"  onclick="showPanel(0,'#2d3c50')">DETALLES DEL PRÉSTAMO</button>
                <button id="buton_1"  onclick="showPanel(1,'#2d3c50')">DATOS GENERALES</button>
                <button id="buton_2" onclick="showPanel(2,'#2d3c50')">PAREJA</button>
                <button id="buton_3" onclick="showPanel(3,'#2d3c50')">DEPENDIENTES ECONOMICOS</button>
                <button id="buton_4" onclick="showPanel(4,'#2d3c50')">DOMICILIO</button>
                <button id="buton_5" onclick="showPanel(5,'#2d3c50')">VIVIENDA</button>
                <button id="buton_6" onclick="showPanel(6,'#2d3c50')">INGRESOS</button>
                <button id="buton_7" onclick="showPanel(7,'#2d3c50')">REFERENCIA PERSONAL</button>
                <button id="buton_8" onclick="showPanel(8,'#2d3c50')">INFORMACIÓN DE LA GARANTÍA</button>
                {{-- <button id="buton_5" onclick="showPanel(5,'#0c1729')">Domicilio</button>
                <button id="buton_6" onclick="showPanel(6,'#0c1729')">Artículos hogar</button>
                <button id="buton_7" onclick="showPanel(7,'#0c1729')">Finanzas</button>
                <button id="buton_8" onclick="showPanel(8,'#0c1729')">Fecha de monto</button>
                <button id="buton_9" onclick="showPanel(9,'#0c1729')">Gastos mensuales</button>
                <button id="buton_10" onclick="showPanel(10,'#0c1729')">Gastos semanales</button>
                <button id="buton_11" onclick="showPanel(11,'#0c1729')">Referencia laboral</button>
                <button id="buton_12" onclick="showPanel(12,'#0c1729')">Referencia personal</button>
                <button id="buton_13" onclick="showPanel(13,'#0c1729')">Datos generales</button>
                <button id="buton_14" onclick="showPanel(14,'#0c1729')">Doc. Prospecto</button>
                <button id="buton_15" onclick="showPanel(15,'#0c1729')">Doc. Aval</button>
                <button id="buton_16" onclick="showPanel(16,'#0c1729')">Garantía</button>
                <button id="buton_17" onclick="showPanel(17,'#0c1729')">Terminación</button> --}}
            </div>
            {{-- Detalle préstamo --}}
            <div class="tabPanel">
                <br><br><br>
                <div class="form-row">
                    <div class="col-md-12">
                        {{---familiares---}}
                        @php
                            // $familiar=DB::table('tbl_familiares')->select(DB::raw('count(*) as ftotal'))
                            // ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                            // ->get();
                            $prestamos_socioeconomico=DB::table('tbl_prestamos')
                            ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                            ->select('tbl_productos.id_producto','tbl_productos.producto','tbl_productos.semanas','tbl_productos.mensual','tbl_productos.reditos as interes','tbl_productos.penalizacion as moratorial','tbl_prestamos.*')
                            ->where('id_usuario','=',$soci[0]->id_usuario)
                            ->orderBy('fecha_solicitud', 'desc')->first();
                            
                            // ->get();
                            // dd($prestamos_socioeconomico);
                        @endphp
                        @if (empty($prestamos_socioeconomico))
                            <form method="POST" action="{{ route('familiares.store') }}">
                                {{ csrf_field() }}
                                <div class="form-row">
                                   
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-5 text-left" >
                                                <label for="numero_personas">FECHA</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input id="numero_personas" name="numero_personas" type="date" class="form-control" value="{{old('fecha_solicitud')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="numero_personas_trabajando">MONTO DEL PRÉSTAMO</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="number" class="form-control" value="{{old('aportan_dinero_mensual')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="numero_personas_trabajando">FORMA DE PAGO</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="number" class="form-control" value="{{old('aportan_dinero_mensual')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-5 text-left" >
                                                <label for="numero_personas">PLAZO DEL PRÉSTAMO</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input id="numero_personas" name="numero_personas" type="date" class="form-control" value="{{old('numero_personas')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="numero_personas_trabajando">TASA DE INTERES (Mensual)</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="number" class="form-control" value="{{old('aportan_dinero_mensual')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="numero_personas_trabajando">TASA DE INTERES (Moratoria)</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="number" class="form-control" value="{{old('aportan_dinero_mensual')}}">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="d-flex">
                                <button type="submit" class="btn btn-primary">Guardar datos</button>
                                </div>
                            </form>
                        @else
                            <style>
                                #buton_0{
                                    background: rgb(0, 0, 0);
                                }
                            </style>
                            <span class="badge text-bg-success alert alert-success">COMPLETADO</span>
                            <hr>
                            <form  method="POST" action="{{ url('update_prestamo_se') }}">
                                {{ csrf_field() }}
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-5 text-left" >
                                                <label for="numero_personas">FECHA</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                @php

                                                $new_fecha =\Carbon\Carbon::parse($prestamos_socioeconomico->fecha_solicitud)->format('Y-m-d');
                                                $time =\Carbon\Carbon::parse($prestamos_socioeconomico->fecha_solicitud)->format('H:i');
                                                   
                                                @endphp
                                                <div class="d-flex">
                                                    <input id="fecha_solicitud" name="fecha_solicitud" type="date" class="form-control" value="{{$new_fecha}}">
                                                    <input id="hora_solicitud" name="hora_solicitud" type="time" class="form-control" value="{{$time}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="numero_personas_trabajando">MONTO DEL PRÉSTAMO</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <div class="d-flex" style="position: relative;">
                                                    <span style="position: absolute;top:4px;left:5px;">$</span>
                                                    <input id="" name="id_prestamo" style="padding-left: 20px;" type="hidden" class="form-control" value="{{$prestamos_socioeconomico->id_prestamo}}">
                                                    <input id="cantidad" name="cantidad" style="padding-left: 20px;" type="text" class="form-control" value="{{$prestamos_socioeconomico->cantidad}}">
                                                </div>
                                            </div>
                                            <script>
                                                function format(input)
                                                    {
                                                    var num = input.value.replace(/\./g,'');
                                                    if(!isNaN(num)){
                                                    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                                                    num = num.split('').reverse().join('').replace(/^[\.]/,'');
                                                    input.value = num;
                                                    }
                                                    else{ alert('Solo se permiten numeros');
                                                    input.value = input.value.replace(/[^\d\.]*/g,'');
                                                    }
                                                    }
                                            </script>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="numero_personas_trabajando">FORMA DE PAGO</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                @php
                                                    $forma_pago='Ninguno';
                                                    $plazo=0;
                                                    if($prestamos_socioeconomico->semanas!=0){
                                                        $forma_pago='Semanal';
                                                        $plazo=$prestamos_socioeconomico->semanas.' semanas';
                                                    }elseif($prestamos_socioeconomico->mensual!=0){
                                                        $forma_pago='Mensual';
                                                        $plazo=$prestamos_socioeconomico->mensual.' meses';
                                                    }
                                                @endphp
                                                <input id="forma_de_pago" style="background: #0c1729" disabled="true"  type="text" class="form-control" value="{{$forma_pago}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="numero_personas_trabajando">TIPO PRODUCTO</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <select name="id_producto" class="form-control" onchange="buscar_producto_se(this.value)">
                                                    @if (count($productos)==0)
                                                        <option value="">Ningun resultado</option>
                                                    @else
                                                        @foreach ($productos as $producto)
                                                            <option value="{{$producto->id_producto}}"
                                                                {{$prestamos_socioeconomico->id_producto==$producto->id_producto ? 'selected' : 'Seleccione un producto'}}    
                                                            >
                                                                {{$producto->producto}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                {{-- <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="text" class="form-control" value="{{$prestamos_socioeconomico->producto}}"> --}}
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5 text-left" >
                                                <label for="numero_personas">PLAZO DEL PRÉSTAMO</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input id="plazo_prestamo"  style="background: #0c1729" disabled="true" type="text" class="form-control" value="{{$plazo}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="numero_personas_trabajando">TASA DE INTERES ({{$forma_pago}})</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input id="tasa_interes" style="background: #0c1729" disabled="true" type="text" class="form-control" value="{{$prestamos_socioeconomico->interes}}%">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label for="numero_personas_trabajando">TASA DE INTERES (Moratoria)</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input id="tasa_interes_moratoria" style="background: #0c1729" disabled="true" type="text" class="form-control" value="{{$prestamos_socioeconomico->moratorial}}%">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-12 mt-3 mb-3">
    
                                        <button type="submit" style="float: right" class="btn btn-primary">Actualizar datos del préstamo</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Datos generales --}}
            <div class="tabPanel">
                <br><br><br>
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
                            <form method="POST" action="{{ url('admin/datosgenerales') }}">
                                @csrf
                                {{-- <div class="form-row">
                                    
                                    <div class="form-group col-md-3">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control input_c" id="nombre" type="text" name="nombre" value="{{old('nombre')}}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="ap_paterno">Apellido paterno</label>
                                        <input class="form-control input_c" id="ap_paterno" type="text" name="ap_paterno" value="{{old('ap_paterno')}}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="ap_materno">Apellido materno</label>
                                        <input class="form-control input_c" id="ap_materno" type="text" name="ap_materno" value="{{old('ap_materno')}}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                        <label for="curp">CURP</label>
                                        <input class="form-control input_m" id="curp" type="text" name="curp" value="{{old('curp')}}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                        <label for="curp">RFC(con homoclave)</label>
                                        <input class="form-control input_m" id="curp" type="text" name="curp" value="{{old('curp')}}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                        <label for="curp">Nacionalidad</label>
                                        <input class="form-control input_m" id="curp" type="text" name="curp" value="{{old('curp')}}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                                        <input class="form-control" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}" required>
                                    </div>
                                    


                                    <div class="form-group col-md-1">
                                        <label for="edad">Ciudad de nacimiento</label>
                                        <input class="form-control" id="edad" type="number" name="edad" value="{{old('edad')}}" required>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="edad">País de nacimiento</label>
                                        <input class="form-control" id="edad" type="number" name="edad" value="{{old('edad')}}" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="estado_civil">Estado civil</label>
                                        <input class="form-control input_c" id="estado_civil" type="text" name="estado_civil" value="{{old('estado_civil')}}" required>
                                    </div>
                                    
                                    <div class="form-group col-md-2">
                                        <label for="estado_civil">Regimen matrimonial</label>
                                        <input class="form-control input_c" id="estado_civil" type="text" name="estado_civil" value="{{old('estado_civil')}}" required>
                                    </div>
                                    
                                </div>
                                <div class="d-flex">
                                <button type="submit" class="btn btn-primary">Guardar datos</button>
                                </div>
                            </form> --}}
                        @else
                            <style>
                                #buton_1{
                                    background: rgb(0, 0, 0);
                                }
                            </style>
                            <span class="badge text-bg-success alert alert-success">COMPLETADO</span>
                            <hr>
                            @php
                                $datos_generales=DB::table('tbl_se_datos_generales')
                                // ->join('tbl_se_referencia_personal','tbl_se_datos_generales.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                ->select('tbl_se_datos_generales.*')
                                ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                ->get();
                            @endphp
                            <form method="POST" action="{{ url('admin/datosgenerales-editar/'.$datos_generales[0]->id_datos_generales) }}" >
                                {{ csrf_field() }}
                                  {{-- {{ method_field('PATCH') }} --}}
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="nombre">Nombre</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control input_c" id="nombre" type="text" name="nombre" value="{{$datos_generales[0]->nombre,old('nombre')}}" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="ap_paterno">Apellido paterno</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control input_c" id="ap_paterno" type="text" name="ap_paterno" value="{{$datos_generales[0]->ap_paterno,old('ap_paterno')}}" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="ap_materno">Apellido materno</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control input_c" id="ap_materno" type="text" name="ap_materno" value="{{$datos_generales[0]->ap_materno,old('ap_materno')}}" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="curp">CURP</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control input_m" id="curp" type="text" name="curp" value="{{$datos_generales[0]->curp,old('curp')}}" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="rfc_homo_clave">RFC(con homoclave)</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control input_m" id="rfc_homo_clave" type="text" name="rfc_homo_clave" value="{{$datos_generales[0]->rfc_homo_clave,old('rfc_homo_clave')}}" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="nacionalidad">Nacionalidad</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control input_m" id="nacionalidad" type="text" name="nacionalidad" value="{{$datos_generales[0]->nacionalidad,old('nacionalidad')}}" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control" id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{$datos_generales[0]->fecha_nacimiento,old('fecha_nacimiento')}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="ciudad_nacimiento">Ciudad de nacimiento</label>
                                                </div>
                                                <div class="form-group col-md-7">
                                                    <input class="form-control" id="ciudad_nacimiento" type="text" name="ciudad_nacimiento" value="{{$datos_generales[0]->ciudad_nacimiento,old('ciudad_nacimiento')}}" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="pais_nacimiento">País de nacimiento</label>
                                                </div>
                                                <div class="form-group col-md-7">
                                                    <input class="form-control" id="pais_nacimiento" type="text" name="pais_nacimiento" value="{{$datos_generales[0]->pais_nacimiento,old('pais_nacimiento')}}" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="estado_civil">Estado civil</label>
                                                </div>
                                                <div class="form-group col-md-7">
                                                    <input class="form-control input_c" id="estado_civil" type="text" name="estado_civil" value="{{$datos_generales[0]->estado_civil,old('estado_civil')}}" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="regimen_matrimonial">Regimen matrimonial</label>
                                                </div>
                                                <div class="form-group col-md-7">
                                                    <input class="form-control input_c" id="regimen_matrimonial" type="text" name="regimen_matrimonial" value="{{$datos_generales[0]->regimen_matrimonial,old('regimen_matrimonial')}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3 mb-3">
                                            <button type="submit" class="btn btn-primary" style="float: right">Actualizar datos generales</button>
                                        </div>
                                    </div>
                                    
                                
                                
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Pareja --}}
            <div class="tabPanel">
                <br><br><br>
                <div class="form-row">
                    <div class="col-md-12">
                        {{---pareja---}}
                        @php
                            $pareja=DB::table('tbl_pareja')->select(DB::raw('count(*) as ptotal'))
                            ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                            ->get();
                        @endphp
                        @if ($pareja[0]->ptotal==0)
                            <form method="POST" action="{{ route('pareja.store') }}">
                                @csrf
                                <div class="form-row">
                                <div class="form-group col-md-3">
                                    <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                    <label  for="nombre">Nombre</label>
                                    <input id="nombre" type="text" class="form-control" name="nombre" value="{{old('nombre')}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label  for="ap_paterno">Apellido Paterno</label>
                                    <input type="text" id="ap_paterno" class="form-control" name="ap_paterno" value="{{ old('ap_paterno') }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label  for="ap_materno">Apellido Materno</label>
                                    <input id="ap_materno" type="text" class="form-control" name="ap_materno" value="{{old('ap_materno')}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="telefono">Teléfono</label>
                                    <input name="telefono" type="number" class="form-control" id="telefono" class="form-control" value="{{ old('telefono') }}">
                                </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label  for="edad">Edad</label>
                                        <input class="form-control" id="edad" type="number" name="edad" value="{{old('edad')}}">
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label  for="ocupacion">Ocupación</label>
                                        <input class="form-control" id="ocupacion" type="text" name="ocupacion" value="{{old('ocupacion')}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <button type="submit" style="float: right" class="btn btn-primary">Guardar datos</button>
                                </div>
                            </form>
                        @else
                            <style>
                                #buton_2{
                                    background: rgb(0, 0, 0);
                                }
                            </style>
                            <span class="badge text-bg-success alert alert-success">COMPLETADO</span>
                            <hr>
                            @php
                                $pareja=DB::table('tbl_pareja')
                                ->select('tbl_pareja.*')
                                ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                ->get();
                            @endphp
                            <form method="POST" action="{{ url('admin/pareja/' .$pareja[0]->id_pareja) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-row">
                                <div class="form-group col-md-3">
                                    <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                    <label  for="nombre">Nombre</label>
                                    <input id="nombre" type="text" class="form-control" name="nombre" value="{{$pareja[0]->nombre}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label  for="ap_paterno">Apellido Paterno</label>
                                    <input type="text" id="ap_paterno" class="form-control" name="ap_paterno" value="{{$pareja[0]->ap_paterno}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label  for="ap_materno">Apellido Materno</label>
                                    <input id="ap_materno" type="text" class="form-control" name="ap_materno" value="{{$pareja[0]->ap_materno}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label  for="telefono">Teléfono</label>
                                    <input name="telefono" type="number" class="form-control" id="telefono" class="form-control" value="{{$pareja[0]->telefono}}">
                                </div>
                                </div>
                                <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="edad">Edad</label>
                                    <input class="form-control" id="edad" type="number" name="edad" value="{{$pareja[0]->edad}}">
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="ocupacion">Ocupación</label>
                                    <input class="form-control" id="ocupacion" type="text" name="ocupacion" value="{{$pareja[0]->ocupacion}}">
                                </div>
                                </div>
                                <div class="col-md-12 mt-3 mb-3">
                                    <button type="submit" class="btn btn-primary" style="float: right">Guardar cambios</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Familiares --}}
            <div class="tabPanel">
                <br><br><br>
                <div class="form-row">
                    <div class="col-md-12">
                        {{---familiares---}}
                        @php
                            $familiar=DB::table('tbl_familiares')->select(DB::raw('count(*) as ftotal'))
                            ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                            ->get();
                        @endphp
                        @if ($familiar[0]->ftotal==0)
                            <form method="POST" action="{{ route('familiares.store') }}">
                                {{ csrf_field() }}
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                        <label  for="numero_personas">Número de Personas</label>
                                        <input id="numero_personas" name="numero_personas" type="number" class="form-control" value="{{old('numero_personas')}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="numero_personas_trabajando">Número de personas que trabajan</label>
                                    <input name="numero_personas_trabajando" type="number" class="form-control" id="numero_personas_trabajando" class="form-control" value="{{old('numero_personas_trabajando')}}">
                                    </div>
                                </div>
                                <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label  for="aportan_dinero_mensual">¿Cuántos aportan dinero mensual?</label>
                                    <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="number" class="form-control" value="{{old('aportan_dinero_mensual')}}">
                                </div>
                                </div>
                                <div class="d-flex">
                                <button type="submit" class="btn btn-primary">Guardar datos</button>
                                </div>
                            </form>
                        @else
                            <style>
                                #buton_3{
                                    background: rgb(0, 0, 0);
                                }
                            </style>
                            <span class="badge text-bg-success alert alert-success">COMPLETADO</span>
                            <hr>
                            @php
                                $familiar=DB::table('tbl_familiares')
                                ->select('tbl_familiares.*')
                                ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                ->get();
                            @endphp
                            <form method="POST" action="{{ url('admin/familiares/' .$familiar[0]->id_familiar) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label  for="numero_personas">Número de Personas</label>
                                        <input id="numero_personas" name="numero_personas" type="number" class="form-control" value="{{$familiar[0]->numero_personas}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label  for="numero_personas_trabajando">Número de personas que trabajan</label>
                                        <input name="numero_personas_trabajando" type="number" class="form-control" id="numero_personas_trabajando" class="form-control" value="{{$familiar[0]->numero_personas_trabajando}}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="aportan_dinero_mensual">¿Cuántos aportan dinero mensual?</label>
                                        <input id="aportan_dinero_mensual" name="aportan_dinero_mensual" type="number" class="form-control" value="{{$familiar[0]->aportan_dinero_mensual}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" style="float: right" class="btn btn-primary">Guardar cambios</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Domicilio --}}
            <div class="tabPanel">
                <br><br><br>
                <div class="form-row">
                    <div class="col-md-12">
                        {{---domicilio---}}
                        @php
                            $domicilio=DB::table('tbl_domicilio')->select(DB::raw('count(*) as dtotal'))
                            ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                            ->get();
                        @endphp
                        @if ($domicilio[0]->dtotal==0)
                            <form method="POST" action="{{ route('domicilio.store') }}">
                                @csrf
                                <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                    <label  for="calle">Calle</label>
                                    <input class="form-control" id="calle" type="text" name="calle" placeholder="Calle" value="{{old('calle')}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="numero_ext">Num. Exterior</label>
                                    <input class="form-control" id="numero_ext" type="text" name="numero_ext" placeholder="Numero Exterior">
                                </div>
                                <div class="form-group col-md-4"> 
                                    <label  for="numero_int">Num. Interior</label>
                                    <input class="form-control" id="numero_int" type="text" name="numero_int" placeholder="Numero Interior">
                                </div>
                                <div class="form-group col-md-4">
                                    <label  for="colonia_localidad">Colonia</label>
                                    <input class="form-control" id="colonia_localidad" type="text" name="colonia_localidad" placeholder="Colonia Localidad">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="municipio">Municipio/Ciudad</label>
                                    <input class="form-control" id="municipio" type="text" name="municipio" placeholder="Municipio">
                                </div>
                                <div class="form-group col-md-4">
                                    <label  for="estado">Estado</label>
                                    <input class="form-control" id="estado" type="text" name="estado" placeholder="Estado">
                                </div>
                                <div class="form-group col-md-4">
                                    <label  for="c_p">C.P</label>
                                    <input class="form-control" id="c_p" type="text" name="c_p" placeholder="Código Postal">
                                </div>
                                <div class="form-group col-md-4">
                                    <label  for="pais">Pais</label>
                                    <input class="form-control" id="pais" type="text" name="pais" placeholder="País">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary mt-3 mb-3" style="float: right" type="submit">Guardar datos</button>
                                </div>
                            </form>
                        @else
                            <style>
                                #buton_4{
                                    background: rgb(0, 0, 0);
                                }
                            </style>
                            <span class="badge text-bg-success alert alert-success">COMPLETADO</span>
                            <hr>
                            @php
                                $domicilio=DB::table('tbl_domicilio')
                                ->select('tbl_domicilio.*')
                                ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                ->get();
                            @endphp
                            <form method="POST" action="{{ url('admin/domicilio/' .$domicilio[0]->id_domicilio) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label  for="calle">Calle</label>
                                        <input class="form-control" id="calle" type="text" name="calle" placeholder="Calle" value="{{$domicilio[0]->calle}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label  for="numero_ext">Número Exterior</label>
                                        <input class="form-control" id="numero_ext" type="text" name="numero_ext" placeholder="Numero Exterior" value="{{$domicilio[0]->numero_ext}}">
                                    </div>
                                    <div class="form-group col-md-4"> 
                                        <label  for="numero_int">Número Interior</label>
                                        <input class="form-control" id="numero_int" type="text" name="numero_int" placeholder="Numero Interior" value="{{$domicilio[0]->numero_int}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label  for="colonia_localidad">Colonia Localidad</label>
                                        <input class="form-control" id="colonia_localidad" type="text" name="colonia_localidad" placeholder="Colonia Localidad" value="{{$domicilio[0]->colonia_localidad}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label  for="municipio">Municipio</label>
                                        <input class="form-control" id="municipio" type="text" name="municipio" placeholder="Municipio" value="{{$domicilio[0]->municipio}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label  for="estado">Estado</label>
                                        <input class="form-control" id="estado" type="text" name="estado" placeholder="Estado" value="{{$domicilio[0]->estado}}">
                                    </div>
                                    
                                    <div class="form-group col-md-1">
                                        <label  for="c_p">C.P</label>
                                        <input class="form-control" id="c_p" type="number" name="c_p" placeholder="C.P" value="{{$domicilio[0]->c_p}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label  for="pais">País</label>
                                        <input class="form-control" id="pais" type="text" name="pais" placeholder="País" value="{{$domicilio[0]->pais}}">
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" style="float: right" type="submit">Guardar cambios</button>
                                    </div>
                                </div>
                                </form>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Vivienda --}}
            <div class="tabPanel">
                <br><br><br>
                <div class="form-row">
                    <div class="col-md-12">
                        {{---vivienda---}}
                        @php
                            $vivienda=DB::table('tbl_vivienda')->select(DB::raw('count(*) as vtotal'))
                            ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                            ->get();
                        @endphp
                        @if ($vivienda[0]->vtotal==0)
                            <form method="POST" action="{{ route('vivienda.store') }}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                        <label for="tipo_vivienda">Tipo vivienda</label>
                                        <input class="form-control" id="tipo_vivienda" type="text" name="tipo_vivienda" value="{{old('tipo_vivienda')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tiempo_viviendo_domicilio">Tiempo viviendo</label>
                                        <input class="form-control" id="tiempo_viviendo_domicilio" type="text" name="tiempo_viviendo_domicilio" value="{{old('tiempo_viviendo_domicilio')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label  for="telefono_casa">Teléfono Casa</label>
                                        <input class="form-control" id="telefono_casa" type="number" name="telefono_casa" value="{{old('telefono_casa')}}">
                                    </div>
                                
                                    <div class="form-group col-md-3">
                                        <label  for="telefono_celular">Teléfono celular</label>
                                        <input class="form-control" id="telefono_celular" type="number" name="telefono_celular" value="{{old('telefono_celular')}}">
                                    </div>
                                </div>
                                <div class="form-row">
                                <button class="btn btn-primary" type="submit">Guardar datos</button>
                                </div>
                            </form>
                        @else
                            <style>
                                #buton_5{
                                    background: rgb(0, 0, 0);
                                }
                            </style>
                                <span class="badge text-bg-success alert alert-success">COMPLETADO</span>
                                <hr>
                                
                            {{-- </div> --}}
                            @php
                                $vivienda=DB::table('tbl_vivienda')
                                ->select('tbl_vivienda.*')
                                ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                ->get();
                            @endphp
                            <form method="POST" action="{{ url('admin/vivienda/'.$vivienda[0]->id_vivienda) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="tipo_vivienda">Tipo de vivienda</label>
                                        <input class="form-control" id="tipo_vivienda" type="text" name="tipo_vivienda" value="{{$vivienda[0]->tipo_vivienda}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tiempo_viviendo_domicilio">Antigüedad</label>
                                        <input class="form-control" id="tiempo_viviendo_domicilio" type="text" name="tiempo_viviendo_domicilio" value="{{$vivienda[0]->tiempo_viviendo_domicilio}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="telefono_celular">Celular (Obligatorio)</label>
                                        <input class="form-control" id="telefono_celular" type="number" name="telefono_celular" value="{{$vivienda[0]->telefono_celular}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="telefono_casa">Casa</label>
                                        <input class="form-control" id="telefono_casa" type="number" name="telefono_casa" value="{{$vivienda[0]->telefono_casa}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="telefono_casa">Correo</label>
                                        <input class="form-control" style="background: #0c1729" disabled="true" id="telefono_casa" type="text" name="telefono_casa" value="{{$soci[0]->email}}">
                                    </div>
                                
                                </div>
                                <div class="col-md-12">
                                <button class="btn btn-primary" style="float: right" type="submit">Guardar datos</button>
                                </div>
                            </form>

                        @endif
                    </div>
                </div>
            </div>
            {{-- Ingresos --}}
            <div class="tabPanel">
                <br><br><br>
                <div class="form-row">
                    <div class="col-md-12">
                        {{--referencia laboral---}}
                        @php
                            $rlaboral=DB::table('tbl_se_referencia_laboral')->select(DB::raw('count(*) as rltotal'))
                            ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                            ->get();
                        @endphp
                        @if ($rlaboral[0]->rltotal==0)
                            <form method="POST" action="{{ route('referencialaboral.store') }}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                        <label  for="nombre_empresa">Nombre empresa</label>
                                        <input class="form-control" id="nombre_empresa" type="text" name="nombre_empresa" value="{{old('nombre_empresa')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label  for="actividad_empresa">Actividad empresa</label>
                                        <input class="form-control" id="actividad_empresa" type="text" name="actividad_empresa" value="{{old('actividad_empresa')}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label  for="cargo_empresa">Cargo empresa</label>
                                        <input class="form-control" id="cargo_empresa" type="text" name="cargo_empresa" value="{{old('cargo_empresa')}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label  for="direccion">Dirección</label>
                                        <input class="form-control" id="direccion" type="text" name="direccion" value="{{old('direccion')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label  for="numero_ext">Número exterior</label>
                                        <input class="form-control" id="numero_ext" type="text" name="numero_ext" value="{{old('numero_ext')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label  for="numero_int">Número interior</label>
                                        <input class="form-control" id="numero_int" type="text" name="numero_int" value="{{old('numero_int')}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="entre_calles">Entre calles</label>
                                        <input class="form-control" id="entre_calles" type="text" name="entre_calles" value="{{old('entre_calles')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label  for="telefono_empresa">Teléfono empresa</label>
                                        <input class="form-control" id="telefono_empresa" type="number" name="telefono_empresa" value="{{old('telefono_empresa')}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tiempo_empresa">Tiempo empresa</label>
                                        <input class="form-control" id="tiempo_empresa" type="text" name="tiempo_empresa" value="{{old('tiempo_empresa')}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="jefe_inmediato">Jefe inmediato</label>
                                        <input class="form-control" id="jefe_inmediato" type="text" name="jefe_inmediato" value="{{old('jefe_inmediato')}}">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 mb-3">
                                    <button type="submit" class="btn btn-primary" style="float: right">Guardar datos</button>
                                </div>
                            </form>
                        @else
                            <style>
                                #buton_6{
                                    background: #000; 
                                }
                            </style>
                            <span class="badge text-bg-success alert alert-success">COMPLETADO</span>
                            <hr>
                            @php
                                $referencialbpersonas=DB::table('tbl_se_rl_personas')
                                ->join('tbl_se_referencia_laboral','tbl_se_rl_personas.id_referencia_laboral','=','tbl_se_referencia_laboral.id_referencia_laboral')
                                ->select('tbl_se_rl_personas.*')
                                ->where('tbl_se_referencia_laboral.id_socio_economico','=',$soci[0]->id_socio_economico)
                                ->get();
                            @endphp
                            <form method="POST" action="{{ url('admin/referencialbpersonas/'.$referencialbpersonas[0]->id_rl_persona) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                  {{ method_field('PATCH') }}
                                <div class="form-row">
                                    <div class="col-md-7">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="cargo_empresa">Ocupación</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="cargo_empresa" type="text" name="cargo_empresa" value="{{$referencialbpersonas[0]->cargo_empresa}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="nombre_empresa">Nombre de la empresa</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="nombre_empresa" type="text" name="nombre_empresa" autocomplete="" value="{{$referencialbpersonas[0]->nombre_empresa}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="actividad_empresa">Giro/Actividad</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="actividad_empresa" type="text" name="actividad_empresa" value="{{$referencialbpersonas[0]->actividad_empresa}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="telefono_empresa">Teléfono</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input class="form-control" id="telefono_empresa" type="number" name="telefono_empresa" value="{{$referencialbpersonas[0]->telefono_empresa}}">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <center>
                                                    <label for="ext">Ext.</label>
                                                </center>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input class="form-control" id="ext" type="number" name="ext" value="{{$referencialbpersonas[0]->ext}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="pagina_web">Página web</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="pagina_web" type="text" name="pagina_web" value="{{$referencialbpersonas[0]->pagina_web}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="tiempo_empresa">Antigüedad</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="tiempo_empresa" type="text" name="tiempo_empresa" value="{{$referencialbpersonas[0]->tiempo_empresa}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="sueldo">Sueldo</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="sueldo" type="text" name="sueldo" value="{{$referencialbpersonas[0]->sueldo}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="otros">Otros</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="otros" type="text" name="otros" value="{{$referencialbpersonas[0]->otros}}">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="calle">Calle</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="calle" type="text" name="calle" value="{{$referencialbpersonas[0]->calle}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="numero_ext">Número exterior</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="numero_ext" type="text" name="numero_ext" value="{{$referencialbpersonas[0]->numero_ext}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="colonia">Colonia</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="colonia" type="text" name="colonia" value="{{$referencialbpersonas[0]->colonia}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="municipio_ciudad">Municipio/Ciudad</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="municipio_ciudad" type="text" name="municipio_ciudad" value="{{$referencialbpersonas[0]->municipio_ciudad}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="estado">Estado</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="estado" type="text" name="estado" value="{{$referencialbpersonas[0]->estado}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="entre_calles">Código Postal</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="codigo_postal" type="text" name="codigo_postal" value="{{$referencialbpersonas[0]->codigo_postal}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="entre_calles">País</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="pais" type="text" name="pais" value="{{$referencialbpersonas[0]->pais}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-primary" style="float: right">Guardar cambios</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Referencia personal --}}
            <div class="tabPanel">
                <br><br><br>
                <div class="form-row">
                    <div class="col-md-12">
                        {{--referencia personal--}}
                        @php
                            $rpersonal=DB::table('tbl_se_referencia_personal')->select(DB::raw('count(*) as rptotal'))
                            ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                            ->get();
                        @endphp
                        @if ($rpersonal[0]->rptotal==0)
                            <form method="POST" action="{{ route('referenciapersonal.store') }}">
                                @csrf
                                <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                <div class="form-row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="relacion">Relación</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="relacion" type="text" name="relacion" value="{{old('relacion')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="nombre">Nombre</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="nombre" type="text" name="nombre" value="{{old('nombre')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="calle_numero">Calle y número</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="calle_numero" type="text" name="calle_numero" value="{{old('calle_numero')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="colonia">Colonia</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="colonia" type="text" name="colonia" value="{{old('colonia')}}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="municipio_ciudad">Municipio/Ciudad</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="municipio_ciudad" type="text" name="municipio_ciudad" value="{{old('municipio_ciudad')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="estado">Estado</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="estado" type="text" name="estado" value="{{old('estado')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="celular">Celular (Obligatorio)</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="celular" type="text" name="celular" value="{{old('celular')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="otro">Otro</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="otro" type="text" name="otro" value="{{old('otro')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3 mt-3">
                                    <button type="submit" class="btn btn-primary" style="float: right">Guardar datos</button>
                                </div>
                            </form>
                        @else
                            <style>
                                #buton_7{
                                    background: #000; 
                                }
                            </style>
                            <span class="badge text-bg-success alert alert-success">COMPLETADO</span>
                            <hr>
                            @php
                                $referenciappersonas=DB::table('tbl_se_rp_personas')
                                ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_referencia_personal.id_referencia_personal')
                                ->select('tbl_se_rp_personas.*')
                                ->where('tbl_se_referencia_personal.id_socio_economico','=',$soci[0]->id_socio_economico)
                                ->get();
                            @endphp
                            <form method="POST" action="{{ url('admin/referenciappersonas/' .$referenciappersonas[0]->id_rp_persona) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                  {{ method_field('PATCH') }}
                                <div class="form-row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="relacion">Relación</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="relacion" type="text" name="relacion" value="{{$referenciappersonas[0]->relacion,old('relacion')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="nombre">Nombre</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="nombre" type="text" name="nombre" value="{{$referenciappersonas[0]->nombre,old('nombre')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="calle_numero">Calle y número</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="calle_numero" type="text" name="calle_numero" value="{{$referenciappersonas[0]->calle_numero,old('calle_numero')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="colonia">Colonia</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="colonia" type="text" name="colonia" value="{{$referenciappersonas[0]->colonia,old('colonia')}}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="municipio_ciudad">Municipio/Ciudad</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="municipio_ciudad" type="text" name="municipio_ciudad" value="{{$referenciappersonas[0]->municipio_ciudad,old('municipio_ciudad')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="estado">Estado</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="estado" type="text" name="estado" value="{{$referenciappersonas[0]->estado,old('estado')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="celular">Celular (Obligatorio)</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="celular" type="text" name="celular" value="{{$referenciappersonas[0]->celular,old('celular')}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="otro">Otro</label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <input class="form-control" id="otro" type="text" name="otro" value="{{$referenciappersonas[0]->otro,old('otro')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3 mt-3">
                                    <button type="submit" class="btn btn-primary" style="float: right">Guardar cambios</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Información de garantía --}}
            <div class="tabPanel">
                <br><br><br><br><br>
                <center>
                    (Vehicular, inmuebles, joyas, Maquinaria)
                </center>
                <hr>
                <div class="form-row">
                    <div class="col-md-12">
                            {{--garantias--}}
                            @php
                                $garantias=DB::table('tbl_se_garantias')->select(DB::raw('count(*) as total_garantias'))
                                ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                ->get();
                            @endphp
                            {{-- @if ($garantias[0]->total_garantias==0) --}}
                            <form method="POST" action="{{ url('guardar_garantia') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label for="propietario">Garantía propiedad de: </label><br>
                                        <input type="text" class="form-control" name="propietario" placeholder="Propietario">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="hidden" name="id_socio_economico" value="{{$soci[0]->id_socio_economico}}">
                                        <label for="tipo_garantia">Tipo garantía </label><br>
                                        <select name="tipo_garantia" id="" class="form-control show-tick ms select2" data-placeholder="Select">
                                            <option value="">Seleccione tipo garantía</option>
                                            @if (count($articulos)==0)
                                                <Option value="">Sin garantía</Option>
                                            @else
                                                @foreach ($articulos as $articulo)
                                                    <Option value="{{$articulo->id_articulo}}">{{$articulo->Nombre_articulo}}</Option>
                                                @endforeach
                                                
                                            @endif
                                        </select>
                                    </div>
                                    <div class=" col-md-4">
                                        <label for="foto_garantia">Documento que acredita la propiedad</label><br>
                                        <input type="file" class="form-control" name="foto_garantia">
                                    </div>
                                    <div class=" col-md-12">
                                        <label for="descripcion">Descripción general</label><br>
                                        <textarea name="descripcion" rows="3" style="width: 100%;background: transparent;color:#fff"></textarea>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-md-12 mt-3 mb-3" >
                                    <button type="submit" class="btn btn-primary mt-3" style="float: right">Guardar datos de garantía</button>
                                </div>
                            </form>
                            <br><br>

                            <div class="col-md-12">
                                Lista de garantías
                            </div>
                            @php
                                $garantias_list=DB::table('tbl_se_garantias')
                                // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
                                ->select('tbl_se_garantias.*')
                                ->where('id_socio_economico','=',$soci[0]->id_socio_economico)
                                ->get();
                            @endphp
                            <div class="row">
                                @if (count($garantias_list)==0)
                                <div class="col-md-12" >
                                    <span >
                                        <center>Sin garantías</center>
                                    </span>
                                </div>
                                @else 
                                <style>
                                    #buton_8{
                                        background: rgb(196, 196, 196); 
                                        
                                    }
                                </style>
                                    @foreach ($garantias_list as $garantias_list)
                                        <div class="col-md-6">
                                            @if(empty($garantias_list->foto))
                                            <center>Sin url</center>
                                            @else
                                                <br>
                                                    <img class="responsive-img materialboxed" src="{{asset($garantias_list->foto)}}" style="border:1px solid #000; border-radius: 6px;" alt="Este es el ejemplo de un texto alternativo" width="100%" >  
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{ url('guardar-garantias')}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-row">
                                    
                                                    <div class="form-group col-md-12 mt-4">
                                                        <input type="hidden" name="id_garantia" value="{{$garantias_list->id_garantia}}">
                                                        <labearantía </label><br>
                                                        <select name="id_articulo" id="" class="form-control">
                                                            <option value="">Seleccione tipo garantía</option>
                                                            @if (count($articulos)==0)
                                                                <Option value="">Sin artículos</Option>
                                                            @else
                                                                @foreach ($articulos as $articulo)
                                                                    <option {{$garantias_list->tipo_garantia == $articulo->id_articulo ? 'selected="selected"' : 'Selecciona un articulo'}} value="{{$articulo->id_articulo}}">{{$articulo->Nombre_articulo}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    
                                                    <div class=" col-md-12 mt-2">
                                                        <label for="nombre">Seleccione nueva foto en caso de cambiar la garantía</label><br>
                                                        <input type="file" class="form-control" name="foto_garantia">
                                                    </div>
                                                    <div class=" col-md-12 mt-2">
                                                        <label for="nombre">Descripción</label><br>
                                                        <textarea name="descripcion_articulo" rows="3" cols="47">{{$garantias_list->descripcion}}</textarea>
                                                    </div>
                                                    
                                                    
                                                </div>
                                                
                                                <div class="d-flex">
                                                <button type="submit" class="btn btn-primary">Actualizar datos de garantía</button><button type="button" class="btn btn-danger" onclick="eliminar_garantia({{$garantias_list->id_garantia}})">Eliminar garantía</button>
                                                </div>
                                            </form>
                                            <br><br><br>
                                            <form action="{{url('eliminar-garantia')}}" method="post" id="formGarantia" onsubmit="return confirm('¿Esta seguro de eliminar la garantía?')">
                                                @csrf
                                            </form>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        {{-- @else --}}
                            
                        {{-- @endif --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
    <br>
    <br>
    <div class="col-md-12 mt-3">
        <div class="row">
                @php
                    $usuario_tipo=auth()->user()->id_tipo_usuario;
    
                    $prestamo_socio=DB::table('tbl_prestamos')
                    ->join('tbl_usuarios','tbl_prestamos.id_usuario','=','tbl_usuarios.id')
                    ->join('tbl_socio_economico','tbl_usuarios.id','=','tbl_socio_economico.id_usuario')
                    ->select('tbl_prestamos.*','tbl_socio_economico.*')
                    ->where('tbl_socio_economico.id_socio_economico','=',$soci[0]->id_socio_economico)
                    ->whereIn('id_status_prestamo',[1,13,14])
                    ->orderby('id_prestamo','ASC')
                    ->get(); 
                    // dd($prestamo_socio->last()->id_prestamo);

                @endphp
            <div class="col-md-12">
                <hr>
            </div>
                @if (count($prestamo_socio)==0)
                    <div class="col-md-12">
                        <center>
                            No hay préstamo
                        </center>
                    </div>
                @else
                    <div class="col-md-6"></div>
                    <div class="col-md-3">
                        <form action="{{url('aprobacion-socioeconomico')}}" method="post">
                            @csrf
                            <input type="hidden" name="id_préstamo" value="{{$prestamo_socio->last()->id_prestamo}}">
                            <center>
                                <button type="submit" class="btn btn-success" onclick="return confirm('¿Esta seguro de continuar con la aprobación?')">Aprobar socioeconómico</button>
                            </center>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form action="{{url('negacion-socioeconomico')}}" method="post">
                            @csrf
                            <input type="hidden" name="id_préstamo" value="{{$prestamo_socio->last()->id_prestamo}}">
                            <center>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Esta seguro de continuar con la aprobación?')">Negar socioeconómico</button>
                            </center>
                        </form>
                    </div> 
                @endif
            </div>        
        </div>
    </div>
    

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
                        <form method="POST" action="{{ route('aval.store') }}">
                            @csrf
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
                                    <input class="form-control" id="telefono_casa" type="number" name="telefono_casa" value="{{old('telefono_casa')}}" placeholder="Telefono Casa" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Teléfono móvil</small>
                                    <input class="form-control" id="telefono_movil" type="number" name="telefono_movil" value="{{old('telefono_movil')}}" placeholder="Telefono Movil" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <small>Teléfono trabajo</small>
                                    <input class="form-control" id="telefono_trabajo" type="number" name="telefono_trabajo" value="{{old('telefono_trabajo')}}" placeholder="Telefono Trabajo" required>
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
            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-round waves-effect">Guardar datos</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="{{asset('js/imgzoom.js')}}"></script>

@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
<script>
    window.onload = function agregar_boton_atras(){
      document.getElementById('Atras').innerHTML='<a href="{{url('prestamo/socio/admin/socioeconomico')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  }
  </script>
<script>
    function aval(){
    $("#largeModal").modal();
    }
    
</script>
<script>
        function eliminar_garantia(id_garantia)
        { 
            var tfP1 = document.createElement("INPUT");
            tfP1.name="id_garantia";
            tfP1.type="hidden";
            tfP1.value=id_garantia;
                
            var padre=document.getElementById("formGarantia");
            // padre.appendChild(tfAccion);
            padre.appendChild(tfP1);

            var resultado = window.confirm('¿Esta seguro de eliminar la garantía?');
            if (resultado === true) {
                document.getElementById("formGarantia").submit();
            } else { 
                
            }
            
            
        }

        function buscar_producto_se(id_producto){
            console.log(id_producto)

            var url = "{{route('buscar_producto')}}";
            var data = {id_producto: id_producto,_token:'{{csrf_token()}}'};
            
            fetch(url, {
            method: 'POST', // or 'PUT'
            body: JSON.stringify(data), // data can be `string` or {object}!
            headers:{
                'Content-Type': 'application/json'
            }
            }).then(res => res.json())
            .catch(error => console.error('Error:', error))
            .then(function(response){
                if (response[0].semanas!=0) {
                    document.getElementById('plazo_prestamo').value = response[0].semanas+' semanas';
                    document.getElementById('forma_de_pago').value = 'Semanal';
                    
                } else if(response[0].mensual!=0) {
                    document.getElementById('plazo_prestamo').value = response[0].mensual+' meses';
                    document.getElementById('forma_de_pago').value = 'Mensual';

                }
                document.getElementById('tasa_interes').value = response[0].reditos+'%';
                document.getElementById('tasa_interes_moratoria').value = response[0].penalizacion+'%';

                
            }
                // response => 
                // console.log('Success:', response)
                
            );
        }
</script>
<script src="js/scripttab.js">
</script>




@stop