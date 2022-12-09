@extends('landing.master_landing')
@section('content_landing')
      <!-- Banner principal -->
  <section id="banner">
    <div id="carousel" class="carousel slide hero-slides" data-ride="carousel" data-pause="hover" data-interval="5000">
      <div class="carousel-inner" role="listbox">
        {{-- @if (count($imagenes_carrousel)==0)
            
        @else
            @php
                $contador=0;
            @endphp
            @foreach ($imagenes_carrousel as $imagen_carrousel)
              @php
                  $contador+=1;
              @endphp
              @if ($contador==1)
                <div class="carousel-item active">
                  <img src="https://laferiecita.com/{{$imagen_carrousel->path_img}}" class="img-fluid w-100">
                  <div class="carousel-caption d-none d-md-block">
                    <div class="caption animated fadeIn text-end">
                      <h1 class="animated fadeInLeft h2 text-end mb-0 titulo">{{$imagen_carrousel->titulo}}</h1>
                      <p class="animated fadeInRight p mb-2 descripcion">Crédito para ti mujer emprendedora *</p>
                      @if ($imagen_carrousel->habilitar_pdf==1)
                        <a class="animated fadeInUp btn delicious-btn" target="_blank" download="https://laferiecita.com/{{$imagen_carrousel->titulo}}" href="https://laferiecita.com/{{$imagen_carrousel->path_pdf}}">Conoce más</a>
                          
                      @else
                          
                      @endif
                    </div>
                  </div>
                </div>
              @else
                <div class="carousel-item ">
                  <img src="https://laferiecita.com/{{$imagen_carrousel->path_img}}" class="img-fluid w-100">
                  <div class="carousel-caption d-none d-md-block">
                    <div class="caption animated fadeIn text-end">
                      <h1 class="animated fadeInLeft h2 text-end mb-0 titulo">{{$imagen_carrousel->titulo}}</h1>
                      <p class="animated fadeInRight p mb-2 descripcion">Crédito para ti mujer emprendedora *</p>
                      @if ($imagen_carrousel->habilitar_pdf==1)
                        <a class="animated fadeInUp btn delicious-btn" target="_blank" download="https://laferiecita.com/{{$imagen_carrousel->titulo}}" href="https://laferiecita.com/{{$imagen_carrousel->path_pdf}}">Conoce más</a>
                          
                      @else
                          
                      @endif
                    </div>
                  </div>
                </div>
              @endif
              
            @endforeach
        @endif --}}
        <div class="carousel-item active">
          <img src="landing/assets/slider/credi-negocio.jpg" class="img-fluid w-100">
          <div class="carousel-caption d-none d-md-block">
            <div class="caption animated fadeIn text-end">
              <h1 class="animated fadeInLeft h2 text-end mb-0 titulo">CREDI-NEGOCIO</h1>
              <p class="animated fadeInRight p mb-2 descripcion">Crédito para ti mujer emprendedora *</p>
              <a class="animated fadeInUp btn delicious-btn" href="#">Conoce más</a>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img src="landing/assets/slider/credi-novel.jpg" class="img-fluid w-100">
          <div class="carousel-caption d-none d-md-block">
            <div class="caption animated fadeIn text-end">
              <h1 class="animated fadeInLeft h2 text-end titulo">CREDI-NOVEL</h1>
              <p class="animated fadeInRight p mb-2 descripcion">Créditos menores a $5,000 pesos *</p>
              <a class="animated fadeInUp btn delicious-btn" href="#">Conoce más</a>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img src="landing/assets/slider/credi-plus.jpg" class="img-fluid w-100">
          <div class="carousel-caption d-none d-md-block">
            <div class="caption animated fadeIn text-end">
              <h1 class="animated fadeInLeft h2 text-end titulo">CREDI-PLUS</h1>
              <p class="animated fadeInRight p mb-2 descripcion">Créditos mayores a $5,000 pesos *</p>
              <a class="animated fadeInUp btn delicious-btn" href="#">Conoce más</a>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img src="landing/assets/slider/seguros.jpg" class="img-fluid w-100">
          <div class="carousel-caption d-none d-md-block" style="right: 23%; top: 35%;">
            <div class="caption animated fadeIn text-end">
              <h1 class="animated fadeInLeft h2 text-end titulo">SEGUROS</h1>
              <p class="animated fadeInRight p mb-2 descripcion">Conoce nuestra amplia gama de seguros *</p>
              <a class="animated fadeInUp btn delicious-btn" href="#">Conoce más</a>
            </div>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </section>

  <div class="line-divider"></div>

  <!-- Info general -->
  <section id="info-general">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
          <div class="inicio-item">
            <div class="hover-bg">
              <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                <div class="hover-text hover-bg-align">
                  <h5 class="estiloh5 px-5">Somos una empresa dedicada a préstamos personales en línea, desde el 2019 estamos
                    comprometidos a impulsar la inclusión financiera.</h5>
                  <div class="clearfix"></div>
                </div>
                <div class="text-center">
                  <img src="landing/assets/img-3/quienessomos.png" class="img-fluid">
                </div>
              </a>
              <div class="todo">
                <b class="estilo-text mb-0 capaTransparente">¿Quiénes somos?</b>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="row mx-0">
            <div class="col-lg-12 col-md-12">
              <div class="inicio-item">
                <div class="hover-bg">
                  <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                    <div class="hover-text">
                      <h5 class="estiloh5 px-5">Ser una entidad financiera ágil, eficiente, reconocida a nivel nacional por su
                        calidad y oportunidad.</h5>
                      <div class="clearfix"></div>
                    </div>
                    <img src="landing/assets/img-3/negocio.jpg" class="img-fluid">
                  </a>
                  <div class="todo">
                    <b class="estilo-text mb-0 capaTransparente">Misión</b>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12 col-md-12">
              <div class="inicio-item">
                <div class="img-clas">
                  <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                    <div class="hover-text">
                      <h5 class="estiloh5 px-5">Ser una entidad financiera dedicada a impulsar la inclusión financiera,
                        ofreciendo a sus clientes productos financieros que generen confianza, posicionándose
                        estratégicamente para operar en todo el territorio mexicano.</h5>
                      <div class="clearfix"></div>
                    </div>
                    <img src="landing/assets/img-3/familia.jpg" class="img-fluid">
                  </a>
                  <div class="todo">
                    <b class="estilo-text mb-0 capaTransparente">Visión</b>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="line-divider"></div>

  <!-- Pasos para un crédito -->
  <section id="pasos-credito">
    <div class="container">
      <div class="row">
        <div class="col-sm-4" style="background: #5a98eb">
          <div class="item">
            <div class="card-doctor">
              <div class="body" style="background: #5a98eb">
                <div class="row my-3">
                  <div class="offset-md-2 offset-1 col-lg-2 col-md-2 col-2 text-right">
                    <img src="landing/assets/img/images/1paso.png" height="50px">
                  </div>
                  <div class="col-lg-6 col-md-6 col">
                    <p class="text-xl mb-0 mx-1">
                      Crea una <br> cuenta
                    </p>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="text-sm text-grey col-lg-8 col-md-8 offset-2" style="line-height: 1.2">
                    <div>Ve hacia el registro y crea</div>
                    <div>una cuenta</div>
                  </div>
                </div>
                <div class="header">
                  <img src="landing/assets/img/images/1.png" width="50px">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4" style="background: #497cbf">
          <div class="item">
            <div class="card-doctor">
              <div class="body" style="background: #497cbf">
                <div class="row my-3">
                  <div class="offset-md-2 offset-1 col-lg-2 col-md-2 col-2 text-right">
                    <img src="landing/assets/img/images/2paso.png" height="50px">
                  </div>
                  <div class="col-lg-6 col-md-6 col">
                    <p class="text-xl mb-0 mx-1">
                      Contesta el test <br> socioeconómico
                    </p>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="text-sm text-grey col-lg-8 col-md-8 offset-2" style="line-height: 1.2">
                    <div>Llena con tus datos y</div>
                    <div>documentación</div>
                    <div>correspondiente</div>
                  </div>
                </div>
                <div class="header">
                  <img src="landing/assets/img/images/2.png" width="50px">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4" style="background: #2c5c9d">
          <div class="item">
            <div class="card-doctor">
              <div class="body" style="background: #2c5c9d">
                <div class="row my-3">
                  <div class="offset-md-2 offset-1 col-lg-2 col-md-2 col-2 text-right">
                    <img src="landing/assets/img/images/3paso.png" height="50px">
                  </div>
                  <div class="col-lg-6 col-md-6 col">
                    <p class="text-xl mb-0 mx-1">
                      Espera tu <br> autorización
                    </p>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="text-sm text-grey col-lg-8 col-md-8 offset-2" style="line-height: 1.2">
                    <div>Pronto recibirás</div>
                    <div>respuesta y el préstamo</div>
                    <div>solicitado.</div>
                  </div>
                </div>
                <div class="header">
                  <img src="landing/assets/img/images/3d.jpg" width="50px">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 text-center py-3" style="background: #497cbf;">
          <a href="#" id="btn3Color" class="btn btn-primary colorbtn">Quiero un crédito</a><br>
        </div>
      </div>
    </div>
  </section>

  <div class="line-divider"></div>

  <!-- Valores -->
  <section id="valores" class="principal">
    <br>
    <div class="row">
      <div class="col-md-12 text-center text-dark mt-5 mb-2">
        <br>
        <h1>Nuestros valores</h1>
      </div>
    </div>
    <!--Carousel Wrapper-->
    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

      <!--Slides-->
      <div class="carousel-inner" role="listbox">

        <div class="carousel-item active">
          <div class="row">
            <div class="col-md-4">
              <div class="slider-card-content m-5">
                <div class="vertical-center px-3">
                  <h2 class="wow bounceIn animated est-text1" data-wow-delay=".40s">Honestidad</h2>
                  <p class="wow bounceIn animated est-p" data-wow-delay=".60s">
                    Nuestra conducta siempre recta, confiable y
                    correcta, con la que transmitimos confianza y sinceridad.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="slider-card-content m-5">
                <div class="vertical-center px-3">
                  <h2 class="wow bounceIn animated est-text1" data-wow-delay=".40s">Transparencia</h2>
                  <p class="wow bounceIn animated est-p" data-wow-delay=".60s">
                    Somos una empresa en contra de la corrupción,
                    por lo que siempre alentamos a nuestros miembros a guiarse bajo la ética.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="slider-card-content m-5">
                <div class="vertical-center px-3">
                  <h2 class="wow bounceIn animated est-text1" data-wow-delay=".40s">Comunicación efectiva:</h2>
                  <p class="wow bounceIn animated est-p" data-wow-delay=".60s">
                    Mantenemos la comunicación activa ,
                    oportuna y veraz entre nuestros clientes y colaboradores.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <div class="row">
            <div class="col-md-4">
              <div class="slider-card-content m-5">
                <div class="vertical-center px-3">
                  <h2 class="wow bounceIn animated est-text1" data-wow-delay=".40s">Respeto al entorno:</h2>
                  <p class="wow bounceIn animated est-p" data-wow-delay=".60s">
                    Valoro y cuido a mis semejantes. Cuido mi área y equipo de trabajo. Actuó siempre cuidando
                    el bienestar de los demás y de los que representa mi trabajo.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="slider-card-content m-5">
                <div class="vertical-center px-3">
                  <h2 class="wow bounceIn animated est-text1" data-wow-delay=".40s">Excelencia Integral:</h2>
                  <p class="wow bounceIn animated est-p" data-wow-delay=".60s">
                    Soy profesional y busco mejorar día a día. Me supero a mi mismo.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="slider-card-content m-5">
                <div class="vertical-center px-3">
                  <h2 class="wow bounceIn animated est-text1" data-wow-delay=".40s">Solidaridad:</h2>
                  <p class="wow bounceIn animated est-p" data-wow-delay=".60s">
                    Destacamos la solidaridad como un elemento que nos permite reconocernos en relación
                    a otros y preocuparnos por su bienestar.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <a class="carousel-control-prev" href="#multi-item-example" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#multi-item-example" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>

  </section>

  <div class="line-divider"></div>

  <!-- Descarga nuestra app -->
  <section id="descargar-app">
    <div class="Principal">
      <div class="text-qr d-none d-sm-none d-md-block">¡La <span style="color: #3B81EC" class="text-magia">magia</span> de ayudar!</div>
      <img class="img-fluid" id="Imprin" src="landing/assets/img/QR/celular.jpg">
      <div class="location1">
        <div>
          <p class="color respon">Descárga nuestra App escaneando este QR.</p>
        </div>
        <img class="imagenuno respons" src="landing/assets/img/QR/phone2.png">
        <img class="imagendos respon1" src="landing/assets/img/QR/Mi_App.jpeg">
      </div>
    </div>
  </section>

  <div class="line-divider-white"></div>

  <!-- Educación financiera -->
  <section id="educacion-financiera">
    <div class="container">
      <div class="row mx-0 align-items-center">
        <div class="col-lg-6 col-md-6 col-12 wow fadeInRight" style="padding: inherit;">

          <div class="font-weight-normal mb-3 titlE mb-5 mt-4">Educación financiera</div>

          <div class="row mb-4">
            <div class="offset-md-3 offset-1 col-lg-1 col-md-1 col-2">
              <img src="landing/assets/img/images/finanzas.png" width="50px" height="50px">
            </div>
            <div class="col-lg-6 col-md-6 col">
              <h6 class="titlE1 text-left">
                Tus finanzas en la pandemia. <br>
                <a href="{{url('articulo-1')}}" class="ver-mas">Ver más...</a>
              </h6>
            </div>
          </div>

          <div class="row mb-4">
            <div class="offset-md-3 offset-1 col-lg-1 col-md-1 col-2">
              <img src="landing/assets/img/images/dinero.png" width="50px" height="50px">
            </div>
            <div class="col-lg-6 col-md-6 col">
              <h6 class="titlE1 text-left">
                ¿Cómo hacer rendir el dinero? <br>
                <a href="{{url('articulo-2')}}" class="ver-mas">Ver más...</a>
              </h6>
            </div>
          </div>

          <div class="row mb-4">
            <div class="offset-md-3 offset-1 col-lg-1 col-md-1 col-2">
              <img src="landing/assets/img/images/dinero.png" width="50px" height="50px">
            </div>
            <div class="col-lg-6 col-md-6 col">
              <h6 class="titlE1 text-left">
                Ahorra para emergencias. <br>
                <a href="{{url('articulo-3')}}" class="ver-mas">Ver más...</a>
              </h6>
            </div>
          </div>

        </div>
        <div class="col-lg-6 col-md-6 col-12 wow fadeInRight" style="padding: inherit;">
          <a href="#"><img src="landing/assets/img/images/EducacionFinanciera.png" class="img-fluid"></a>
          <br>
        </div>
      </div>
    </div>
  </section>

  <!-- Necesitas ayuda -->
  <section id="ayuda">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 py-5 wow fadeInRight" style="background: #3683f9;">
          <h1 class="font-weight-normal mb-2"><br><img src="landing/assets/img/images/interrogacion.png" class="img-fluid size-img-question"></h1>
          <br>
          <h2 class="text-white dejanos-ayudarte mb-2">Déjanos ayudarte<br></h2>
          <br>
          <h6 class="mb-3 tienes-dudas">¿Tienes dudas o problemas con tu<br> cuenta?</a></h6>
          <br>
          <div class="col-12 text-center">
            <a class="btn btn-primary" id="btn2">Necesito ayuda</a>
            <br><br><br>
          </div>
        </div>
        <div class="col-lg-6 wow fadeInRight pl-5" style="background: #F4F4F4;">
          <br><br class="d-none d-sm-none d-md-block"><br class="d-none d-sm-none d-md-block">
          <h5>¿Tienes dudas acerca de un producto o<br> servicio?</h5>
          <a href="{{url('centro-ayuda')}}">
            <p>Ir al Centro de Ayuda</p>
          </a></h5>
          <br><br class="d-none d-sm-none d-md-block"><br class="d-none d-sm-none d-md-block">

          <h5>¿Necesitas hablar con nosotros?</h5>
          <p class="numero">Llama al <b>(800) 002 24 34</b></p>

          <br><br class="d-none d-sm-none d-md-block"><br class="d-none d-sm-none d-md-block">
          <p class="numero">Horario de atención telefónica de lunes<br> a viernes de 08:00 a 19:00 hrs</p>
        </div>
      </div>
    </div>
  </section>
@endsection