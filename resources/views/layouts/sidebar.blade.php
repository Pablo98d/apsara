<style>
    .header_header{
        background: #3e516c;
        padding: 1rem 0;

    }
    .header_header a{
        color: #fff;
        text-decoration: none;

    }
    .logo_nav_container_header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        /* width: 300px; */
    }
    .logo_nav_container_header img{
        
        width: 150px;
    }
    .navigation_header ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }
        .navigation_header ul .li {
            display: inline-block;
        }
        .navigation_header ul .li .a {
            display: block;
            padding: 0.5rem 1.2rem;
            transition: all 0.4s linear;
            border-radius: 5px;
            /* background: red; */
        }
       

</style>
@guest
@else
    @php
        $foto_perfil=DB::table('tbl_datos_usuario')
        ->join('tbl_usuarios','tbl_datos_usuario.id_usuario','tbl_usuarios.id')
        ->join('tbl_tipo_usuario','tbl_usuarios.id_tipo_usuario','tbl_tipo_usuario.id_tipo_usuario')
        ->select('tbl_datos_usuario.foto_perfil','tbl_usuarios.nombre_usuario','tbl_tipo_usuario.nombre as tipo_usuario')
        ->where('id_usuario','=',auth::user()->id)
        ->get();
    @endphp
    
@endguest

<header class="header_header " >
    
    <div class="container_header logo_nav_container_header container-fluid">
        <a href="{{route('home')}}">
            <img src="{{asset('estilo_v2/img/logo/Logo-apsara-png-blanco.png')}}" class="img-fluid">
        </a>
        <div class="navigation_header">
            
            <ul>
                <li  class="contenido-opciones li">
                    <a href="#" class="a">Inicio <i class="fas fa-chevron-down"></i></a>
                    <ul class="lista-oppciones">

                        <a href="{{url('miperfil')}}">
                            <li>Perfil</li>
                        </a>

                        <a href="{{route('datosusuario.index')}}">
                            <li>Usuarios</li>
                        </a>

                        <a href="{{route('tipousuarios.index')}}">
                            <li>Tipos de usuario</li>
                        </a>


                    </ul>
                </li>
                <li  class="li">
                    <a href="{{url('admin/productos')}}" class="a">Productos </a>
                    
                </li>
                {{-- <li class="contenido-opciones li"><a href="#">Inicio</a></li> --}}
                <li class="contenido-opciones li">
                    <a href="#" class="a">
                        @if (count($foto_perfil)==0)
                            <img class="" style="width: 30px;border-radius: 50%" src="{{asset('assets/images/useradmin.jpg')}}" alt="">
                        @else
                            @foreach ($foto_perfil as $foto_p)
                            <small>
                                {{$foto_p->nombre_usuario}}
                                
                                {{-- {{$foto_p->tipo_usuario}} --}}
                            </small>
                                    @if ($foto_p->foto_perfil==null)
                                        <img class="" style="width: 30px;border-radius: 50%" src="{{asset('assets/images/useradmin.jpg')}}" alt="">
                                    @else
                                        <img class="" style="width: 30px;border-radius: 50%" src="{{asset($foto_p->foto_perfil)}}" alt="">
                                    @endif
                            @endforeach
                        @endif
                    </a>
                </li>
                <li class="li">
                    <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Cerrar sesión">
                        <i class="zmdi zmdi-power"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>

    @php

        $region_actual=\Cache::get('region');

        $region=DB::table('tbl_plaza')

        ->select('tbl_plaza.*')

        ->where('IdPlaza','=',$region_actual)

        ->get();



        $regiones=DB::table('tbl_plaza')

        ->select('tbl_plaza.*')

        ->get();



        $productos=DB::table('tbl_productos')

        ->select('tbl_productos.*')

        ->get();



        

    @endphp

        {{-- <div class="buscador-logo">

            <div style="">

                

            </div>

            <button class="nav-toggle" aria-label="Abrir menú">
                <i class="fas fa-bars"></i>
            </button>

            <div class="div-buscador">
                <nav class="nav">

                    <ul class="nav-menu ">

                        

                        
                        <li  class="nav-menu-item contenido-opciones">

                            <a href="" class="nav-menu-link nav-link">Operación <i class="fas fa-chevron-down"></i></a>

                            <ul class="lista-oppciones">

                                <a href="{{route('grupos.index')}}">

                                    <li>Grupo</li>

                                </a>

                                <a href="{{route('admin-zona.index')}}"> 

                                    <li class="li-rutas">Ruta</li> 

                                </a> 

                                <a href="{{route('admin-region.index')}}">

                                    <li class="li-rutas">Región</li> 

                                    

                                </a>

                                <a href="{{url('grupos/gerentes/excluir')}}">

                                    <li>Excluir grupos</li>

                                </a>

                            </ul>

                        </li>

                        <li  class="nav-menu-item contenido-opciones">

                            <a href="" class="nav-menu-link nav-link">Productos <i class="fas fa-chevron-down"></i></a>

                            <ul class="lista-oppciones">

                               

                                        @if (!empty($productos))



                                            @foreach ($productos as $product)

                                              @php

                                                  $prestamos=DB::table('tbl_prestamos')

                                                  ->select('tbl_prestamos.*')

                                                  ->where('id_producto','=',$product->id_producto)

                                                  ->get();

                                              @endphp

                                                <a href="{{ url('admin/productos/' .$product->id_producto.'/edit') }}">

                                                    <li>

                                                        {{$product->producto}}

                                                        

                                                        

                                                    </li>

                                                </a>

                                            @endforeach

                                        @else


                                        @endif

                                

                                <a href="{{route('productos.index')}}">

                                    <li>Produc</li>

                                </a>

                            </ul>

                        </li>

                        <li  class="nav-menu-item contenido-opciones">

                            <a href="" class="nav-menu-link nav-link">Personal <i class="fas fa-chevron-down"></i></a>

                            <ul class="lista-oppciones">

                                <a href="{{url('grupos/gerentes/allgerentes')}}"> 

                                    <li class="li-rutas">Gerente</li> 

                                </a> 

                                

                                <a href="{{url('grupos/admin/grupospromotoras')}}">

                                    <li>Promotora</li>

                                </a>

                                

                            </ul>

                        </li>

                        <li  class="nav-menu-item contenido-opciones">

                            <a href="" class="nav-menu-link nav-link">Préstamos <i class="fas fa-chevron-down"></i></a>

                            <ul class="lista-oppciones">

                                <a href="{{route('prestamos.index')}}">

                                    <li>Ver últimos</li>

                                </a>

                                

                                <a href="{{url('prestamo/abono/abonos-clientes')}}">

                                    <li>Abonos</li>

                                </a>

                                <a href="{{route('statusprestamo.index')}}">

                                    <li>Estatus préstamo</li>

                                </a>

                            </ul>

                        </li>

                        <li  class="nav-menu-item contenido-opciones">

                            <a href="" class="nav-menu-link nav-link">App <i class="fas fa-chevron-down"></i></a>

                            <ul class="lista-oppciones">

                                <a href="{{url('admin-carrousel')}}">

                                    <li>Carrousel</li>

                                </a>

                                <a href="{{url('validacion-sms')}}">

                                    <li>Validación SMS</li>

                                </a>

                            </ul>

                        </li>

                        <li class="nav-menu-item contenido-menu-rutas">

                            <a href="#" class="nav-menu-link nav-link" id="Rutas"></a>

                            

                        </li>

                        

                    </ul>

                </nav>

            </div>

            <div class="div-notificar" style="margin-top: 23px; margin-left: 90px;">

                

                <ul class="nav-menu region-perfil" style="display: flex">

                    

                    <li class="nav-menu-item contenido-menu2">

                        <a href="#" class="nav-menu-link nav-link">Región: 

                            @if (count($region)==0)

                            

                            @else

                                {{$region[0]->Plaza}}

                            @endif

                            <i class="fas fa-chevron-down"></i>

                        </a>

                        <div class="desplegable-menu-region" >

                            <ul class="lista-regiones">

                                @if (count($regiones)==0)

                                    <li>Sin regiones</li>

                                @else

                                <li><a href="{{route('admin-region.index')}}">Administrar</a></li>

                                <hr >

                                    @foreach ($regiones as $region)

                                        <a href="{{url('configuracion-region/'.$region->IdPlaza)}}">

                                            <li>

                                                {{$region->Plaza}} | #{{$region->IdPlaza}}

                                            </li>

                                        </a>

                                    @endforeach

                                @endif

                            </ul>

                        </div>

                    </li>

                    <li class="nav-menu-item contenido-notificacion">

                        @php

                            $contador_notificaciones=0;

                            if (count($prospectos)==0) {

                                $contador_notificaciones+=0;

                            } else {

                                $contador_notificaciones+=count($prospectos);

                            }

                            if ($contador_renovaciones==0) {

                                $contador_notificaciones+=0;

                            } else {

                                $contador_notificaciones+=$contador_renovaciones;

                            }

                            if (count($rechazado_por_cliente)==0) {

                                $contador_notificaciones+=0;

                            } else {

                                $contador_notificaciones+=count($rechazado_por_cliente);

                            } 

     

                            if (count($prestamos_anticipados)==0) {

                                $contador_notificaciones+=0;

                            } else {

                                $contador_notificaciones+=count($prestamos_anticipados);

                            } 

            

                        @endphp

                        <a href="" aria-label="Nuevas notificaciones" title="Notificaciones" class="nav-menu-link nav-link notificación-contenido"><i class="far fa-bell diseño-carrito"></i>

                            @if ($contador_notificaciones==0)

                                        

                            @else

                                <input id="notificaciones" value="{{$contador_notificaciones}}" disabled>

                            @endif

                        </a>

                        <div class="opciones-notificaciones">

                            <ul >

                                <li >Notificaciones</li>

                                <hr>

                                    @if (count($prospectos)==0)

                

                                    @else

                                            <a href="javascript:void(modal_prospecto());">

                                                <li>

                                                    

                                                    {{count($prospectos)}} nuevos prospectos

                                                </li>

                                            </a>

                                    @endif

                                    @if ($contador_renovaciones==0)

                    

                                    @else

                                        <a href="javascript:void(modal_renovacion());">

                                            <li>

                                                {{$contador_renovaciones}} renovaciones y préstamos nuevos

                                            </li>

                                        </a>

                                    @endif

                                    @if (count($rechazado_por_cliente)==0)

                        

                                    @else

                                            <a href="javascript:void(modal_rechazadoporcliente());">

                                                <li>

                                                    {{count($rechazado_por_cliente)}}  préstamos rechazados

                                                </li>

                                            </a>

                                    @endif

                                    @if (count($prestamos_anticipados)==0)

                

                                    @else

                                        <a href="javascript:void(modal_anticipados());">

                                            <li>

                                                {{count($prestamos_anticipados)}} préstamos anticipados

                                            </li>

                                        </a>

                                    @endif

                            </ul>

                        </div>

                        

                    </li>

                    

                    <li class="nav-menu-item contenido-off" >

                        <a class="link-off" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Cerrar sesión">

                            <i class="zmdi zmdi-power"></i>

                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

                            @csrf

                        </form>

                    </li>

                    

                    @guest

                        <li  class="nav-menu-item">

                            <a href="{{route('login')}}" class="nav-menu-link nav-link">Ingresar</a>

                        </li>

                        <li  class="nav-menu-item">

                            <a href="{{route('register')}}" class="nav-menu-link nav-link">Crear cuenta</a>

                        </li>

                    

                    @else

                        

                    @endguest

                </ul>

                

                

            </div>

        </div> --}}

        <div>

            

            {{-- <div class="cotenido-rutas"> 

                <b> Ruta: </b> 

                <span style="margin-left: 5px;">

                    @if ($zona==null) 

                    Seleccione ruta <i class="fas fa-chevron-down"></i> 

                    @else {{$zona->Zona}} 

                    <i class="fas fa-chevron-down"></i> 

                    @endif

                </span> 

                <div class="menu-rutas" > 

                    <ul class="ul-rutas"> 

                        

                        <a href="{{url('grupos/gerentes/allgerentes')}}"> 

                            <li class="li-rutas">Gerentes de ruta</li> 

                        </a> 

                        <a href="{{url('rutas/visitas/visitas-ruta')}}"> 

                            <li class="li-rutas">Vista de rutas</li> 

                        </a>

                        <hr>

                        @if (count($zonas)==0) 

                        Sin resultados 

                        @else 

                        @foreach ($zonas as $zona) 

                        <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> 

                            <li class="li-rutas"> 

                                {{$zona->Zona}} #{{$zona->IdZona}} 

                            </li> 

                        </a> 

                        @endforeach 

                        @endif 

                    </ul> 

                </div> 

            </div> --}}

        </div>

        <form id="formBuscarGrupos" action="{{url('grupos')}}" method="post">
            @csrf
        </form>

 

    

</header>

<script>

    function cobrax_buscar_grupos(id_region,id_zona)

        { 

            console.log('kkjadkjkdj')

            console.log(id_region,id_zona)

            var tfP1 = document.createElement("INPUT");

            tfP1.name="id_region";

            tfP1.type="hidden";

            tfP1.value=id_region;



            var tfP2 = document.createElement("INPUT");

            tfP2.name="id_zona";

            tfP2.type="hidden";

            tfP2.value=id_zona;

                



            var padre=document.getElementById("formBuscarGrupos");

           

            padre.appendChild(tfP1);

            padre.appendChild(tfP2);

            

            document.getElementById("formBuscarGrupos").submit();

    }

</script>

