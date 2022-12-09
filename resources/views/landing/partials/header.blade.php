<!-- Back to top button -->

<div class="back-to-top"></div>

<div class="loading"><img src="landing/assets/img/loading.gif"></div>

<header class="position-relative">

    <a class="logo-home d-none d-sm-none d-md-block mt-3" href="{{url('/')}}"><img src="landing/assets/img/Logo-apsara-png.png" class="img-fluid"></a>

    <div class="topbar">

        <div class="container">

            <div class="row">

                <div class="col-md-3">

                    <!-- Icon position adsolute -->

                </div>

                <div class="col-md-7 mt-3 text-sm d-none d-sm-none d-md-block px-md-5">

                    <div class="site-info">

                        <form class="form-inline my-2 my-lg-0">

                            <div class="d-flex w-100 bg-white">

                                <input type="search" id="buscar" class="form-control">

                                <div class="input-group-append">

                                    <button class="btn btn-search px-3 icon-search" type="button">

                                        <i class="fa fa-search"></i>

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="col-8 d-block d-sm-block d-md-none">

                    <a href="{{url('/')}}">

                        <img src="landing/assets/img/logotipo.png" class="img-fluid ml-3 py-3" style="height: 120px;">

                    </a>

                </div>

                <div class="col-md-2 col-4 text-sm text-md-left text-right">

                    <div class="social-mini-button">

                        <a href="#"><img class="icono" src="landing/assets/img/usuario-gris.png" width="30px" height="30px"></span></a>

                        <a href="#"><img class="icono" src="landing/assets/img/campana-gris.png" width="30px" height="30px"></span></a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">

        <div class="row">

            <div class="col-md-3">

                <!-- Icon position adsolute -->

            </div>

            <div class="col-md-7 px-md-5">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse text-center text-md-left" id="navbarSupportedContent">

                    <ul class="navbar-nav w-100 justify-content-between">

                        <li class="nav-item">

                            <a class="nav-link pl-0" href="{{url('nosotros')}}">Nosotros</a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="#creditos">Créditos</a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{route('register')}}">Regístrate</a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{url('/#educacion-financiera')}}">Educación financiera</a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link pr-0" href="#catalogos-puntos">Catálogos de puntos</a>

                        </li>

                    </ul>

                </div>

            </div>

            <div class="col-md-2 d-none d-sm-none d-md-block">

                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">

                        <a class="nav-link" href="{{route('login')}}">Ingresa</a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

</header>