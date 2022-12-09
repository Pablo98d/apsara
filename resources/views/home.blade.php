@extends('layouts.master')
{{-- @section('title', 'Dashboard') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>

@stop
@section('content')
<div class="row clearfix" style="margin: 0 auto"> 
    {{-- Aqui empieza lo de accesos directo --}}
    <div class="col-md-3" style="border: 1px solid gray;border-radius: 10px;">
        
        <div class="row mt-2">
            {{-- <div class="col-md-12 ">
                @guest
                @else
                    <a href="{{route('miperfil.index')}}">
                        @php
                            $foto_perfil=DB::table('tbl_datos_usuario')
                            ->join('tbl_usuarios','tbl_datos_usuario.id_usuario','tbl_usuarios.id')
                            ->join('tbl_tipo_usuario','tbl_usuarios.id_tipo_usuario','tbl_tipo_usuario.id_tipo_usuario')
                            ->select('tbl_datos_usuario.foto_perfil','tbl_usuarios.nombre_usuario','tbl_tipo_usuario.nombre as tipo_usuario')
                            ->where('id_usuario','=',auth::user()->id)
                            ->get();
                        @endphp
                        <div class="row">
                            @if (count($foto_perfil)==0)
                                <div class="col-md-3">
                                    <img class="" style="width: 50px;border-radius: 50%" src="{{asset('assets/images/useradmin.jpg')}}" alt="">
                                </div>
                            @else
                                @foreach ($foto_perfil as $foto_p)
                                    @if ($foto_p->foto_perfil==null)
                                    <div class="col-md-3">
                                        <img class="" style="width: 50px;border-radius: 50%" src="{{asset('assets/images/useradmin.jpg')}}" alt="">
                                    </div>
                                    @else
                                    <div class="col-md-3">
                                        <img class="" style="width: 50px;border-radius: 50%" src="{{asset($foto_p->foto_perfil)}}" alt="">
                                    </div>
                                    @endif
                                    <div class="col-md-7">
                                        <center>
                                            <strong>
                                                <label style="color: rgb(37, 37, 37);font-weight: bold; margin-top:5px;font-size: 17px">{{$foto_p->nombre_usuario}}</label>
                                            </strong>
                                            <label style="color: rgb(37, 37, 37);font-size: 17px">{{$foto_p->tipo_usuario}}</label>

                                        </center>
                                    </div>
                                    
                                @endforeach
                            @endif

                        </div>
                    </a>
                    
                @endguest
            </div> --}}
            <div class="col-md-12">
                <center>
                    <label for="">Solicitud de préstamos</label>
                </center>
            </div>
            <div class="col-md-12" 
            {{-- style="height: calc(65vh);  overflow-y: scroll" --}}
            >
                <div class="row">
                    {{-- <div class="col-md-12 mb-3 mt-2">
                        <hr>
                        <h5>
                            Acceso directo
                        </h5>
                    </div> --}}
                    
                            <div class="col-md-6 mb-4">
                                <button onclick="window.location.href='{{url('prestamo/socio/admin/socioeconomico')}}'" style="background: none; border:2px solid #007fb2; border-radius: 10px;color: #fff;padding: 5px;">
                                    SOLICITAR PRÉSTAMO
                                </button>
                            </div>
                    
                    
                    
                    {{-- @if ($zona==null)
                        
                    @else
                        @if ($region==null)
                            
                        @else
                            <div class="col-md-12 mb-3 mt-2">
                                <hr>
                                <h5>
                                    Operaciones de <b>{{$zona->Zona}}</b>
                                </h5>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center mb-3">
                                <a href="{{url('prestamo/socio/admin/socioeconomico')}}" title="Socio Economico">
                                    <center>
                                        <img src="img/botones_home/Socioeconomicos.png" class="mb-2" alt="" width="100%">
                                    </center>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center mb-3">
                                <a href="{{url('rutas/visitas/varias-visitas/'.$zona->IdZona.'/'.$region->IdPlaza)}}" title="Registrar Visita">
                                    <center>
                                        <img src="img/botones_home/Registrarvisita.png" class="mb-2" alt="" width="100%">
                                    </center>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center mb-3">
                                <a href="{{url('admin/datosusuario/0')}}" title="Datos de Usuario">
                                    <center>
                                        <img src="img/botones_home/Cliente.png" class="mb-2" alt="" width="100%">
                                    </center>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center mb-3">
                                <a href="{{url('grupos/zona/corte_zona/'.$region->IdPlaza.'/'.$zona->IdZona)}}" title="Reporte de Corte">
                                    <center>
                                        <img src="img/botones_home/Reportedecorte.png" class="mb-2" alt="" width="100%">
                                    </center>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center mb-3">
                                <a href="{{url('mejor-panorama/'.$region->IdPlaza.'/'.$zona->IdZona)}}" title="Mejorar Panorama">
                                    <img src="img/botones_home/MejorarPanorama.png" class="mb-2" alt="" width="100%">
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center mb-3">
                                <a href="{{url('exportar')}}" title="Exportar Reporte">
                                    <img src="img/botones_home/ExportarReporte.png" class="mb-2" alt="" width="100%">
                                </a>
                            </div>
                            
                        @endif
                    @endif --}}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9"
        @if ($zona==null)
            
        @else
            @if ($region==null)
                
            @else
                <div class="row">
                    @if (count($grupos)==0)
                        
                    @else
                        <div class="col-md-12 mb-3" >
                            
                            <div class="contenido-caja-texto">
                                {{-- <label for="fecha_nacimiento" style="color: gray;">{{ __('Fecha de nacimiento') }}</label> --}}
                                {{-- <input id="fecha_nacimiento" type="text" class="caja-texto @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required autocomplete="fecha_nacimiento" autofocus> --}}
                                <input id="myInput" type="text" class="caja-texto input @error('fecha_nacimiento') is-invalid @enderror" placeholder="Buscar grupo ...">
        
                                @error('fecha_nacimiento')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12" >
                            {{-- <span style="color: red"> <strong>Nota: </strong> Solo grupos que tienen clientes aparecen en esta lista </span> --}}
                            <div class="estilo-tabla" style="height: calc(65vh);  overflow-y: scroll">
                                <table class="col-md-12" >
                                    <thead>
                                        <tr>
                                            <th class="">Ruta</th>
                                            <th class="">Grupo</th>
                                            <th class="">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myList">
                                        @foreach ($grupos as $grupo)
                                        @php
                                            $semana_corte_actual=DB::table('tbl_cortes_semanas')
                                            ->select('tbl_cortes_semanas.*')
                                            ->where('id_grupo','=',$grupo->id_grupo)
                                            ->get();
                                        @endphp
                                        <tr>
                                            <td class="">
                                                <h6>
                                                    {{$grupo->Zona}} #{{$grupo->IdZona}}
                                                    
                                                </h6>
                                            </td>
                                            <td>
                                                <h6>
                                                    {{$grupo->grupo}} #{{$grupo->id_grupo}}
                                                </h6>
                                            </td>
                                            <td >
                                                @php
                                                    $grupos = DB::table('tbl_grupos')
                                                    ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
                                                    ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
                                                    ->select('tbl_grupos.*','tbl_zona.Zona','tbl_zona.IdZona')
                                                    ->where('tbl_grupos.id_grupo','=',$grupo->id_grupo)
                                                    ->orderBy('tbl_grupos.grupo','ASC')
                                                    ->distinct()
                                                    ->get();
                                                    
                                                @endphp
                                                
                                                

                                                    {{-- <a href="#" class="">Opciones <i class="fas fa-chevron-down" style="top: 4px;"></i>
                                                        
                                                    </a> --}}
                                                    {{-- <ul class="lista-opciones-tabla"> --}}
                                                        
                                                        @if (count($grupos)==0)

                                                                <span title="Estudios socioeconómicos">
                                                                    <img src="{{asset('img/botones_tabla/socioeconomico_des.png')}}" width="40px" alt="">
                                                                    {{-- <li>Estudios. S.E.</li> --}}
                                                                    {{-- Estudios. S.E. --}}
                                                                </span>
                                                                <span  title="Configurar corte semana">
                                                                    <img src="{{asset('img/botones_tabla/corte_des.png')}}" width="40px" alt="">
                                                                </span>
                                                                <span title="Clientes con préstamos">
                                                                    <img src="{{asset('img/botones_tabla/clientes_des.png')}}" width="40px" alt="">
                                                                    {{-- <li>Clientes</li> --}}
                                                                </span>
                                                                <a href="{{url('rutas/visitas/visitas-porgrupo/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}" >
                                                                    <img src="{{asset('img/botones_tabla/Ruta.png')}}" width="40px"  alt=""> 
                                                                    {{-- <li>Visitas</li>  --}}
                                                                </a>
                                                                <span>
                                                                    <img src="{{asset('img/botones_tabla/menu_des.png')}}" width="40px" alt="">
                                                                </span>
                                                        @else
                                                                <a href="{{url('operacion/socio/admin-operaciones-socio_eco/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}" title="Estudios socioeconómicos">
                                                                    <img src="{{asset('img/botones_tabla/Socioeconomico.png')}}" width="40px" alt="">
                                                                    {{-- <li>Estudios. S.E.</li> --}}
                                                                    {{-- Estudios. S.E. --}}
                                                                </a>
                                                                <a href="{{url('configurar-corte-semana/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}"  title="Configurar corte semana" style="position: relative">
                                                                    <img src="{{asset('img/botones_tabla/Corte.png')}}" width="40px" alt="">
                                                                    {{-- <li>Corte --}}
                                                                        @if(count($semana_corte_actual)==0)
                                                                            <i style="color:red;position: absolute;right: 7px;top:-2px;" class="fas fa-exclamation" title="Se necesita configuraci&oacute;n"></i>
                                                                        @else
                                                                        
                                                                        @endif

                                                                    {{-- </li> --}}
                                                                </a>
                                                                <a href="{{url('prestamo/buscar-cliente/'.$grupo->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo)}}" title="Clientes con préstamos">
                                                                    <img src="{{asset('img/botones_tabla/Clientes.png')}}" width="40px" alt="">
                                                                    {{-- <li>Clientes</li> --}}
                                                                </a>
                                                                <a href="{{url('rutas/visitas/visitas-porgrupo/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}"  title="Visita de zonas">
                                                                    <img src="{{asset('img/botones_tabla/Ruta.png')}}" width="40px"  alt=""> 
                                                                    {{-- <li>Visitas</li> --}}
                                                                </a>
                                                                
                                                                
                                                                
                                                                <span class="contenido-a-opciones">
                                                                    <a href="#">
                                                                        <img src="{{asset('img/botones_tabla/Menu.png')}}" width="40px" alt="">
                                                                    </a>
                                                                    <ul class="lista-opciones-tabla">
                                                                        <a href="{{url('operacion/prospecto/admin-operaciones-prospectos/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}"  title="Prospectos">
                                                                            {{-- <img src="{{asset('img/botones_tabla/Prospectos.png')}}" width="40px" alt="">     --}}
                                                                            <li>Prospectos</li>
                                                                        </a> 
                                                                    </ul>
                                                                </span>
                                                        @endif
                                                    </ul>
                                                    {{-- <a href="#" class="">Opciones <i class="fas fa-chevron-down" style="top: 4px;"></i>
                                                        
                                                    </a> --}}

                                                    {{-- <ul class="lista-opciones-tabla">
                                                        
                                                        @if (count($grupos)==0)
                                                            <center>
                                                                <a href="{{url('rutas/visitas/visitas-porgrupo/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}" style="background: rgb(248, 248, 248); border: solid rgb(163, 163, 163) 1px;color: #2b2b2b" title="Visita de zonas">
                                                                    <img src="{{asset('img/botones_tabla/Ruta.png')}}" width="30px" style="border-radius: 20px" alt=""> 
                                                                    <li>Visitas</li> </a>
                                                            </center>
                                                        @else
                                                            <a href="{{url('prestamo/buscar-cliente/'.$grupo->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo)}}" title="Préstamos activos y renovaciones">
                                                                <img src="{{asset('img/icons-rojos/clientes.png')}}" width="30px" style="border-radius: 20px; background: #ffff; " alt="">
                                                                <li>Clientes</li>
                                                            </a>
                                                            <a href="{{url('rutas/visitas/visitas-porgrupo/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}"  title="Visita de zonas">
                                                                <img src="{{asset('img/icons-rojos/visita-zona.png')}}" width="30px" style="border-radius: 20px" alt=""> 
                                                                <li>Visitas</li></a>
                                                            <a href="{{url('operacion/prospecto/admin-operaciones-prospectos/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}"  title="Prospectos">
                                                                <img src="{{asset('img/man.png')}}" width="30px" style="border-radius: 20px; background: #fff;padding: 3px;" alt="">    
                                                                <li>Prospectos</li>
                                                            </a> 
                                                            <a href="{{url('operacion/socio/admin-operaciones-socio_eco/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}" title="Estudios socioeconómicos">
                                                                <img src="{{asset('img/icons-rojos/se.png')}}" width="30px" style="border-radius: 20px; background: #fff;padding: 3px;" alt="">
                                                                <li>Estudios. S.E.</li></a>
                                                            <a href="{{url('configurar-corte-semana/'.$region->IdPlaza.'/'.$grupo->IdZona.'/'.$grupo->id_grupo)}}"  title="Configurar corte semana">
                                                                <img src="{{asset('img/icons-rojos/cogwheel.png')}}" width="30px" style="border-radius: 20px; background: #fff;padding: 2px;" alt="">
                                                                <li>Corte
                                                                    @if(count($semana_corte_actual)==0)
                                                                        <i style="color:red;" class="fas fa-exclamation" title="Se necesita configuraci&oacute;n"></i>
                                                                    @else
                                                                    
                                                                    @endif

                                                                </li>
                                                            </a>
                                                        @endif
                                                    </ul> --}}
                                                </div>
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
        
                            </div>
        
                        </div>
                        {{-- @endforeach --}}
                    @endif
                </div>
            
    
            @endif
            
        @endif

    </div>

    
    
    
    
    <br><br><br>

    <div class="modal fade" id="modal_monitoreo" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
				<div class="col-md-12 mt-3">
					<center>
                        <small>Se requiere autenticación para ingresar al monitoreo</small>
					</center>
                    <hr>
                    <form action="{{route('ubicacion_gerente')}}" method="get">
                        @csrf
                        <div class="col-md-12">
                            <center>
                                <small>Correo</small><br>
                                <input class="form-control" type="text" placeholder="Ingrese su correo" name="email">
                            </center>

                        </div>
                        <div class="col-md-12">
                            <center>
                                <small>Contraseña</small><br>
                                <input class="form-control" type="password" name="password">
                            </center>
                        </div>
                        <div class="col-md-12">
                            <center>
                                <button type="submit" class="btn btn-primary">Ingresar</button>

                            </center>
                        </div>
                    </form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
					
				</div>
			</div>
        </div>
    </div>
    
</div>
@stop
@section('page-script')
<script type="text/javascript">
    function ConfirmDemo() {
    //Ingresamos un mensaje a mostrar
    var mensaje = confirm("¿Esta seguro de aplicar el corte?");
    //Detectamos si el usuario acepto el mensaje
    if (mensaje) {
        location.href="{{url('corte-general')}}";
    }
    //Detectamos si el usuario denegó el mensaje
    else {
    
    }
}
</script>
<script>
    
    window.onload = function agregar_boton_atras(){
      document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
    }
</script>
<script>
    function modal_prospecto(){
        $("#modal_prospecto").modal();
    }

    function modal_renovacion(){
        $("#modal_renovacion").modal();
    }

    function modal_rechazadoporcliente(){
        $("#modal_rechazadoporcliente").modal();
    }

    function modal_monitoreo(){
        $("#modal_monitoreo").modal();
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
</script>

@stop
