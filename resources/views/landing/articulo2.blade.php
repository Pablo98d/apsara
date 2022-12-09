@extends('landing.master_landing')
@section('content_landing')
  <br>
  <div class="container-articulos">
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-dark bg-transparent justify-content-left py-0 mb-2">
        <li class="breadcrumb-item"><a href="{{url('/#educacion-financiera')}}" style="color: black;">Educación Financiera -> ¿Cómo hacer rendir el dinero?</a></li>
        <li class="breadcrumb-item active" aria-current="page" style="color: grey;">Artículo 2</li>
      </ol>
    </nav>
    <div class="art py-3 mb-3 mb-md-5">
      <h1 class="font-weight-normal mb-3 titulo-articulo">¿Cómo hacer rendir el dinero?</h1>
      <img src="landing/assets/img/articulos/articulo2.png" class="img-fluid">
      <div class="row justify-content-center mx-0 mt-md-5 mb-md-4 mt-4 mb-2">
        <div class="col-lg-6 wow fadeInUp">
          <div class="text-lg mx-3">
            <p class="estA1">Controlar tus finanzas te permitirá vivir dentro de tus posibilidades, evitar el estrés de
              los problemas financieros y te dará la libertad de tomar decisiones con los recursos con los que cuentas;
              de hecho, te permitirá trazar el camino para ahorrar y alcanzar tus objetivos.<br><br>El punto de partida
              para que aprendas cómo hacer rendir el dinero con la finalidad de que llegues a fin de mes más
              holgadamente, es saber cómo hacer un presupuesto ajustado a tu nivel de ingresos y que te sirva para todo
              el mes.<br><br>Gastas más de lo que ganas, deberás tomar algunas decisiones en función de disminuir lo más
              que puedas ese excedente y después asegurarte que tus desembolsos siempre estén por debajo de tus
              ingresos, para que puedas cumplir con tus necesidades y mantengas tu salud financiera.<br><br>¿Cómo
              administrar mi dinero para llegar a fin de mes?<br>
              Es importante que pienses que tienes que ahorrar dinero para lo inesperado, sin que ello te signifique
              dejar de comprar las cosas que te gustan. Establece objetivos de ahorro y alcánzalos poco a poco, de forma
              que tus inversiones se conviertan en un poco de dinero extra al mes y tus ahorros te preparen para el
              futuro.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection