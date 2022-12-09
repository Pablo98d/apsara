@extends('landing.master_landing')
@section('content_landing')
  <br>
  <div class="container-articulos">
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-dark bg-transparent justify-content-left py-0 mb-2">
        <li class="breadcrumb-item"><a href="{{url('/#educacion-financiera')}}" style="color: black;">Educación Financiera -> Ahorra para emergencias</a></li>
        <li class="breadcrumb-item active" aria-current="page" style="color: grey;">Artículo 3</li>
      </ol>
    </nav>
    <div class="art py-3 mb-3 mb-md-5">
      <h1 class="font-weight-normal mb-3 titulo-articulo">Ahorra para emergencias</h1>
      <img src="landing/assets/img/articulos/articulo3.png" class="img-fluid">
      <div class="row justify-content-center mx-0 mt-md-5 mb-md-4 mt-4 mb-2">
        <div class="col-lg-6 wow fadeInUp">
          <div class="text-lg mx-3">
            <p class="estA1">Quizá puedas pagar tus necesidades y gastos mensualmente, pero ¿cómo enfrentarás una
              emergencia o un gasto inesperado?<br><br> No es fácil apartar dinero para una emergencia o para gastos
              inesperados. Se trata de un desafío para muchas personas en todo el mundo. Si eres una de esas personas,
              una emergencia o un imprevisto pueden producirte dificultades financieras.<br><br>Si te preparas para lo
              inesperado, en lugar de enfrentarlo recién cuando surge, podrás conservar tu bienestar financiero. Hay
              formas distintas de hacerlo en todo el mundo, Generar ahorros de emergencia puede ser un desafío.<br><br>
              Estas son 5 sugerencias para crear un fondo de ahorro para emergencias:<br><br>1. Establece metas de
              ahorro. Al establecer metas, podrás hacer un seguimiento de tu progreso y medir el éxito que
              tienes.<br><br>2. También debes platicar sobre las metas de ahorro con tus seres queridos. Explícales qué
              son y por qué son importantes.<br><br>3. Separa los fondos de emergencia del dinero que usas para tus
              gastos cotidianos o para pagar tus deudas mensuales.<br><br>4. Intenta ahorrar con frecuencia y de manera
              automática. En lugar de ahorrar lo que te sobra a fin de mes, establece una transferencia automática de tu
              cuenta bancaria habitual a una cuenta de ahorro para el día en que te depositen.<br><br>5. Si no puedes
              ahorrar mucho, es posible que te resulte difícil motivarte. No obstante, es útil ahorrar cualquier monto
              (aunque sea pequeño). Esto puede ayudarte a crear un valioso fondo para emergencias a lo largo del tiempo.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection