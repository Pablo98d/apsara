@extends('landing.master_landing')
@section('content_landing')
  <br>
  <div class="container-articulos">
    <nav aria-label="Breadcrumb">
      <ol class="breadcrumb breadcrumb-dark bg-transparent justify-content-left py-0 mb-2">
        <li class="breadcrumb-item"><a href="{{url('/#educacion-financiera')}}" style="color: black;">Educación Financiera -> Tus finanzas en pandemia</a></li>
        <li class="breadcrumb-item active" aria-current="page" style="color: grey;">Artículo 1</li>
      </ol>
    </nav>
    <div class="art py-3 mb-3 mb-md-5">
      <h1 class="font-weight-normal mb-3 titulo-articulo">Tus finanzas en la pandemia</h1>
      <img src="landing/assets/img/articulos/articulo1.png" class="img-fluid">
      <div class="row justify-content-center mx-0 mt-md-5 mb-md-4 mt-4 mb-2">
        <div class="col-md-6 wow fadeInUp">
          <div class="text-lg mx-3">
            <p class="estA1">Actualmente la situación económica se torna complicada gracias a la pandemia, donde vemos
              los efectos negativos que causa a nuestra salud, resulta también importante considerar los efectos que la
              misma puede ocasionar en nuestras finanzas personales. Por eso hay que cuidar nuestras finanzas personales
              administrando nuestros recursos.<br><br>• <b>Realiza un diagnóstico y revisa tus finanzas.</b> Escribe en
              una libreta tus deudas, dinero, dinero guardado en casa, gastos, seguros, ingresos fijos y variables, etc.
              De esta manera revisar a fondo tus finanzas.<br><br> Revisa desde los gastos más grandes hasta los más
              pequeños con el fin de detectar los gastos hormiga, para que comiences a poner límites de acuerdo con tus
              prioridades y de esta manera reasignar tus recursos. Así lograrás equilibrar tu presupuesto para no gastar
              más de lo que ganas.<br><br><b>• Disminuye gastos.</b> En época de crisis debemos procurar disminuir
              gastos, para lo cual puedes identificar gastos innecesarios para eliminarlos.<br><br><b>• Ahorra.</b> Aún
              en época de crisis ahorrar debe ser una de las acciones que no debes dejar para después. Recuerda que
              siempre debes contar con una reserva para momentos de emergencia. Si no la tienes siempre es buen momento
              para empezar.<br><br> Destinar cierto porcentaje de tu ingreso para el ahorro, puede ser todo un, reto,
              pero cuando recibas dinero adicional por un bono, horas extras, o alguna gratificación es importante que
              lo ahorres, de esta manera estarás mejor preparado en caso de que se presente algún imprevisto y podrás
              echar mano de este dinero sin recurrir al crédito.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection