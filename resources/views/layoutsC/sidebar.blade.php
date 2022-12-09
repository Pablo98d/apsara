<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="{{route('homecliente')}}"><img src="{{asset('assets/images/lf/logoNombre.png')}}"  alt="LaFeriecita"><span class="m-l-10"></span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <div class="image"><a href="#"><img src="{{asset('assets/images/profile_av.jpg')}}" alt="User"></a></div>
                    <div class="detail">
                        <h6>{{auth()->user()->nombre_usuario}}</h6>
                        <small>Bienvenido </small>
                    </div>
                </div>
            </li>            
            <li class="{{ Request::segment(1) === 'inicio' ? 'active open' : null }}"><a href="{{route('homecliente')}}"><i class="zmdi zmdi-home"></i><span>Inicio</span></a></li>
            <li class="{{ Request::segment(1) === 'mi_perfil' ? 'active open' : null }}"><a href="{{url('datos-usuario')}}"><i class="zmdi zmdi-account"></i><span>Mi Perfil</span></a></li>
            <li class="{{ Request::segment(1) === 'usuarios' ? 'active open' : null }}">
                <a href="#socioeconomico" class="menu-toggle"><i class="zmdi zmdi-apps"></i> <span>Actividades</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::segment(2) === 'socioeconomico' ? 'active' : null }}"><a href="{{url('socio_e_cliente')}}">Socioeconomico</a></li>
                    <li class="{{ Request::segment(2) === 'prestamos' ? 'active' : null }}"><a href="{{url('prestamo_cliente')}}">Préstamos</a></li>
                    <li class="{{ Request::segment(2) === 'historial_cliente' ? 'active' : null }}"><a href="{{url('historial_cliente')}}">Historial</a></li>
                </ul>
            </li>

            {{---<li class="{{ Request::segment(1) === 'grupos' ? 'active open' : null }}">
                <a href="#Grupos" class="menu-toggle"><i class="zmdi zmdi-assignment"></i> <span>Grupos</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::segment(2) === 'grupo' ? 'active' : null }}"><a href="{{route('grupos.index')}}">Grupos</a></li>
                    <li class="{{ Request::segment(2) === 'taskboard' ? 'active' : null }}"><a href="{{route('grupospromotoras.index')}}">Grupos Promotoras</a></li>
                </ul>
            </li>
            <li class="{{ Request::segment(1) === 'prestamos' ? 'active open' : null }}">
                <a href="#Prestamos" class="menu-toggle"><i class="zmdi zmdi-folder"></i> <span>Prestamos</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::segment(2) === 'prestamos' ? 'active' : null }}"><a href="{{route('prestamos.index')}}">Prestamos</a></li>
                    <li class="{{ Request::segment(2) === 'producto' ? 'active' : null }}"><a href="{{route('productos.index')}}">Productos</a></li>
                    <li class="{{ Request::segment(2) === 'penalizacion' ? 'active' : null }}"><a href="{{route('penalizacion.index')}}">Penalizaciones</a></li>
                    <li class="{{ Request::segment(2) === 'abonos' ? 'active' : null }}"><a href="{{route('abonos.index')}}">Abonos</a></li>
                    <li class="{{ Request::segment(2) === 'statusprestamo' ? 'active' : null }}"><a href="{{route('statusprestamo.index')}}">Estatus Prestamo</a></li>
                </ul>
            </li>
            <li class="{{ Request::segment(1) === 'rutas' ? 'active open' : null }}">
                <a href="#Rutas" class="menu-toggle"><i class="zmdi zmdi-blogger"></i> <span>Rutas</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::segment(2) === 'ruta' ? 'active' : null }}"><a href="{{route('rutas.index')}}">Rutas</a></li>
                    <li class="{{ Request::segment(2) === 'tipovisita' ? 'active' : null }}"><a href="{{route('tipovisita.index')}}">Tipo Visita</a></li>
                    <li class="{{ Request::segment(2) === 'detalleruta' ? 'active' : null }}"><a href="{{route('detalleruta.index')}}">Detalle Rutas</a></li>
                </ul>
            </li>
            <li hidden="" class="{{ Request::segment(1) === 'socioeconomicos' ? 'active open' : null }}">
                <a href="#SocioEconomico" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i> <span>Socio Economico</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::segment(2) === 'socioeconomico' ? 'active' : null }}"><a href="{{route('socioeconomico.index')}}">Socio Economico</a></li>
                    
                    <li class="{{ Request::segment(2) === 'pareja' ? 'active' : null }}"><a href="{{route('pareja.index')}}">Pareja</a></li>
                    <li class="{{ Request::segment(2) === 'productocreate' ? 'active' : null }}"><a href="{{route('productos.create')}}">Producto</a></li>
                    <li class="{{ Request::segment(2) === 'finanzas' ? 'active' : null }}"><a href="{{route('finanzas.index')}}">Finanzas</a></li>
                    <li class="{{ Request::segment(2) === 'promotora' ? 'active' : null }}"><a href="{{route('promotora.index')}}">Promotora</a></li>
                    <li class="{{ Request::segment(2) === 'fechamonto' ? 'active' : null }}"><a href="{{route('fechamonto.index')}}">Fecha Monto</a></li>
                    <li class="{{ Request::segment(2) === 'domicilio' ? 'active' : null }}"><a href="{{route('domicilio.index')}}">Domicilio</a></li>
                    <li class="{{ Request::segment(2) === 'familiares' ? 'active' : null }}"><a href="{{route('familiares.index')}}">Familiares</a></li>
                    <li class="{{ Request::segment(2) === 'vivienda' ? 'active' : null }}"><a href="{{route('vivienda.index')}}">Vivienda</a></li>

                    <li class="{{ Request::segment(2) === 'vivienda' ? 'active' : null }}"><a href="{{route('aval.index')}}">Aval</a></li>
                    <li class="{{ Request::segment(2) === 'fechamonto' ? 'active' : null }}"><a href="{{route('gastosmensuales.index')}}">Gastos Mensuales</a></li>
                    <li class="{{ Request::segment(2) === 'domicilio' ? 'active' : null }}"><a href="{{route('gastossemanales.index')}}">Gastos Semanales</a></li>
                    <li class="{{ Request::segment(2) === 'familiares' ? 'active' : null }}"><a href="{{route('articuloshogar.index')}}">Articulos del hogar</a></li>
                </ul>
            </li>
            <li hidden="" class="{{ Request::segment(1) === 'datos del hogar' ? 'active open' : null }}">
                <a href="#Components" class="menu-toggle"><i class="zmdi zmdi-swap-alt"></i> <span>Datos del Hogar</span></a>
                <ul class="ml-menu">
                    
                </ul>
            </li> --}}
        </ul>
    </div>
</aside>