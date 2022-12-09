
@extends('landing.master_landing')
@section('content_landing')
<style>
  .al {
    margin-left: unset;
  }

  .estA2 {
    text-align: unset;
  }

  .info {
    background-color: #fff;
  }

  @media (min-width: 268px) and (max-width: 1024px) {
    .estA2 {
      font-size: 18px;
    }
  }
</style>
  <br>
  <div class="container-articulos">
    <div class="info my-md-5 my-3">
      <br>
      <div class="row justify-content-center mx-0">
        <div class="col-lg-6 wow fadeInUp">
          <div class="text-lg text-center my-md-5 my-3">
            <h1 class="font-weight-normal my-0">Centro de ayuda</h1>
            <p class="estA2 al my-0 text-muted">Estamos listos para resolver sus dudas.</p>
          </div>
        </div>
      </div>
      <div class="row mx-0 justify-content-center align-items-center pb-5">
        <div class="col-md-1 col-3 offset-md-1 offset-1">
          <img src="landing/assets/img/articulo/1.png" class="img-fluid">
        </div>
        <div class="col-md-3 col-7">
          <div>Preguntanos por chat <br> en <span style="color: #65a0d2;">Twitter</span> o <span style="color: #65a0d2;">Facebook</span></div>
        </div>
        <div class="col-md-1 col-3 offset-md-0 offset-1">
          <img src="landing/assets/img/articulo/2.png" class="img-fluid">
        </div>
        <div class="col-md-3 col-7">
          <div>Llámanos al 000000000 <br> <span style="color: #65a0d2;">Ver más teléfonos</span></div>
        </div>
        <div class="col-md-1 col-3 offset-md-0 offset-1">
          <img src="landing/assets/img/articulo/2.png" class="img-fluid">
        </div>
        <div class="col-md-2 col-7">
          <div>Escríbenos o envíanos <br> un <span style="color: #65a0d2;">Correo electrónico</span></div>
        </div>
      </div>
      <br>
    </div>
  </div>
  <br>
  @endsection