<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="{{route('home')}}"><img src="{{asset('assets/images/lf/logoNombre.png')}}"  alt="LaFeriecita"><span class="m-l-10"></span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <div class="image"><a href="#"><img src="{{asset('assets/images/useradmin.jpg')}}" alt="User"></a></div>
                    <div class="detail">
                        <h6>{{auth()->user()->nombre_usuario}}</h6>
                        <small>Bienvenido analista</small>
                    </div>
                </div>
            </li>            
            <li class="{{ Request::segment(1) === 'inicio' ? 'active open' : null }}"><a href="{{route('homeanalista')}}"><i class="zmdi zmdi-home"></i><span>Inicio</span></a></li>
            <li class="{{ Request::segment(1) === 'mi_perfil' ? 'active open' : null }}"><a href="{{url('analista-mi-perfil')}}"><i class="zmdi zmdi-account"></i><span>Mi Perfil</span></a></li>
            
            
            
          
        </ul>
    </div>
</aside>