@extends('landing.master_landing')
@section('content_landing')
  <section id="banner">
    <div class="page-banner overlay-dark bg-image" style="background-image: url(landing/assets/img/nosotros/nosotros.png);">
      <div class="banner-section">
        <div class="container text-center wow fadeInUp">
          <nav aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark bg-transparent justify-content-center py-0 mb-2">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>
              <li class="breadcrumb-item active" aria-current="page">Nosotros</li>
            </ol>
          </nav>
          <h1 class="font-weight-normal">Nosotros</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- Cards -->
  <section class="bg-light mb-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 py-3 wow zoomIn">
          <div class="card-service">
            <div class="circle-shape bg-secondary text-white">
              <span class="mai-chatbubbles-outline"></span>
            </div>
            <p>¿Quiénes somos?</p>
          </div>
        </div>
        <div class="col-md-4 py-3 wow zoomIn">
          <div class="card-service ">
            <div class="circle-shape bg-primary text-white">
              <span class="mai-shield-checkmark"></span>
            </div>
            <p>Misión</p>
          </div>
        </div>
        <div class="col-md-4 py-3 wow zoomIn">
          <div class="card-service">
            <div class="circle-shape bg-accent text-white">
              <span class="mai-basket"></span>
            </div>
            <p>Visión</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Content -->
  <section class="mb-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 wow fadeInUp">
          <div class="text-center">
            <img src="landing/assets/img/nosotros/quienessomos.png" class="imgN">
          </div>
          <h1 class="text-center my-4">¿Quiénes somos?</h1>
          <div class="text-lg mx-4">
            <p class="estiloN">Somos una empresa dedicada a préstamos personales en línea, desde el 2019 estamos
              comprometidos a impulsar la inclusión financiera. A través de nuestros productos y servicios de uso
              sencillo, integramos a la población desatendida por la banca tradicional al sistema financiero formal.
              Estamos convencidos que a través de la inclusión financiera y digital es cómo podemos ayudar a generar una
              mayor prosperidad. Tenemos el compromiso por alcanzar una prosperidad incluyente no solo en Jalisco sino
              en los demás estados de la república mexicana. Siempre hemos apostado por la innovación y la tecnología,
              por eso implementamos la aplicación y plataforma web. Durante estos años se han otorgado más de 10,000
              préstamos a diferentes personas que buscan tener una mejor calidad de vida, tomar el control de sus
              inversiones o de sus deudas. Sabemos que todos merecen la oportunidad de mejorar sus finanzas personales.
              En La feriecita buscamos dar esa oportunidad a más personas por eso seguimos trabajando con compromiso y
              talento para lograr nuestros objetivos, que todas las personas obtengan los préstamos que se merecen y
              sabemos que vamos en camino a lograrlo.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Cards description-->
  <section class="mb-5">
    <div class="container">
      <div class="row">
        <div class="offset-md-1 offset-0 col-md-3 py-3">
          <div class="card-blog">
            <p class="estN my-2">Misión</p>
            <div class="header">
              <a href="blog-details" class="post-thumb">
                <img src="landing/assets/img/nosotros/mision.png" alt="">
              </a>
            </div>
            <div class="body">
              <h6 class="post-title size">Ser una entidad financiera ágil, eficiente, reconocida a nivel nacional
                por su calidad y oportunidad</a></h6>
            </div>
          </div>
        </div>
        <div class="col-md-4 py-3">
          <div class="card-blog">
            <p class="estN my-2">Visión</p>
            <div class="header">
              <a href="blog-details" class="post-thumb ">
                <img src="landing/assets/img/nosotros/vision.png" alt="">
              </a>
            </div>
            <div class="body">
              <h6 class="post-title size">Ser una entidad financiera dedicada a impulsar la inclusión financiera,
                ofreciendo a sus clientes productos financieros que generen confianza, posicionándose
                estratégicamente para operar en todo el territorio mexicano.</h6>
            </div>
          </div>
        </div>
        <div class="col-md-3 py-3">
          <div class="card-blog">
            <p class="estN my-2">Valores</p>
            <div class="header">
              <a href="blog-details" class="post-thumb">
                <img src="landing/assets/img/nosotros/visionweb.png" alt="">
              </a>
            </div>
            <div class="body">
              <h6 class="post-title size">
                <ul>
                  <li>Honestidad</li>
                  <li>Transparencia</li>
                  <li>Comunicación efectiva</li>
                  <li>Respeto al entorno</li>
                  <li>Excelencia integral</li>
                </ul>
              </h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection