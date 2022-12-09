<!DOCTYPE html>

<html lang="es">



<head>

  <meta charset="UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">



  <title>Apsara - Home</title>



  <link rel="shortcut icon" href="{{asset('landing/logo.png')}}">

  <link rel="stylesheet" href="landing/assets/css/maicons.css">

  <link rel="stylesheet" href="landing/assets/css/bootstrap.css">

  <link rel="stylesheet" href="landing/assets/vendor/owl-carousel/css/owl.carousel.css">

  <link rel="stylesheet" href="landing/assets/vendor/animate/animate.css">

  <!--ESTILOS DE 3 IMÁGENES -->

  <link rel="stylesheet" href="landing/assets/css/theme.css?v=1.1.0">

  <link rel="stylesheet" href="landing/assets/cssimg/bootstrap.css">

  <link rel="stylesheet" href="landing/assets/cssimg/style.css?v=1.0">

  <!--ESTILOS DE SLIDER VALORES -->

  <link rel="stylesheet" href="landing/assets/cssSlider/style.css">

  <link rel="stylesheet" href="landing/assets/fontSlider/css/font-awesome.min.css">

  <link rel="stylesheet" href="landing/assets/efectos/estils.css">

  <link rel="stylesheet" href="landing/assets/efectos/esti.css">

  <!--ESTILOS DE SLIDER -->

  <link rel="stylesheet" type="text/css" href="landing/assets/slider/slider.css?v=1.0.0">

  <!-- Custom styles -->

  <link rel="stylesheet" href="landing/assets/css/styles.css?v=1.2.8">

  <style>

    .img-clas .hover-text {

      will-change: background-position;

      background: linear-gradient(-10deg,rgba(7,33,70,.9) 50%,transparent 50%);

      background-size: 100% 300%;

      background-repeat: no-repeat;

      background-position: center 12%;

      -webkit-transition: background-position .66667s cubic-bezier(.61,0,.39,1);

      transition: background-position .66667s cubic-bezier(.61,0,.39,1);

    }

    .img-clas:hover .hover-text {

      -webkit-transition-delay: 0;

      transition-delay: 0;

      background-position: center 88%;

    }



    .hover-bg .hover-text {

      will-change: background-position;

      background: linear-gradient(-10deg,rgba(7,33,70,.9) 50%,transparent 50%);

      background-size: 100% 300%;

      background-repeat: no-repeat;

      background-position: center 12%;

      -webkit-transition: background-position .66667s cubic-bezier(.61,0,.39,1);

      transition: background-position .66667s cubic-bezier(.61,0,.39,1);

    }



    .hover-bg:hover .hover-text {

      -webkit-transition-delay: 0;

      transition-delay: 0;

      background-position: center 88%;

    }



    .size-img-question {

      width: 80px;

      height: auto;

    }



    .tienes-dudas {

      color: white;

      font-size: 20px;

    }



    .dejanos-ayudarte {

      font-size: 2rem;

    }



    .ali {

      margin-right: unset;

    }



    .footer-menu {

      margin-left: unset;

      text-align: center;

    }



    .line-divider {

      border-top: 15px solid #E6E6E6;

    }



    .line-divider-white {

      border-top: 15px solid #FFF;

    }



    .capaTransparente {

      padding: 18px 0;

      background: rgb(50, 60, 107);

    }



    .navbar-expand-lg .navbar-nav {

      margin-left: unset;

    }



    #buscar {

      width: 97%;

      margin-left: unset;

      margin-top: unset;

    }



    .btn-search:not(:disabled):not(.disabled) {

      background: white;

      color: #495057;

    }



    .icon-search {

      border-left: solid #e6e8ea 1px;

      border-radius: 0;

    }



    .topbar .social-mini-button a {

      margin-top: 24px;

      margin-left: unset;

    }



    .icono {

      margin-left: unset;

    }



    @media (min-width: 1920px) {

      .size-img-question {

        width: 160px;

      }

      .tienes-dudas {

        font-size: 30px;

      }

      .dejanos-ayudarte {

        font-size: 2.2rem;

      }

      #btn2 {

        font-size: 32px;

        margin-bottom: 30px;

      }

      .logo-align-footer {

        margin-left: 8%;

        margin-top: 3%;

      }



      .capaTransparente {

        padding: 28px 0;

      }

      .estilo-text {

        font-size: 38px !important;

      }

      .principal {

        height: 820px;

      }

    }

    

  </style>

</head>



<body class="bg-fondo">



  <!-- Header -->

  @include('landing.partials.header')

  @yield('content_landing')



  <!-- Footer -->

  @include('landing.partials.footer')





  <script src="landing/assets/js/jquery-3.5.1.min.js"></script>

  <script src="landing/assets/js/bootstrap.bundle.min.js"></script>

  <script src="landing/assets/vendor/owl-carousel/js/owl.carousel.min.js"></script>

  <script src="landing/assets/vendor/wow/wow.min.js"></script>

  <script src="landing/assets/js/theme.js?v=1.0"></script>

  <!--SCRIPTS DE las 3 imágenes -->

  <script src="landing/assets/jsimg/jquery.js"></script>

  <script src="landing/assets/jsimg/bootstrap.min.js"></script>

  <script src="landing/assets/jsimg/xBe.js?v=1.0"></script>

  <script src="landing/assets/jsimg/jquery.isotope.min.js" type="text/javascript"></script>

  <!--SCRIPTS DEL SLIDER DE VALORES -->

  <script src="landing/assets/jsSlider/jquery.js"></script>

  <script src="landing/assets/jsSlider/creatividad.js?v=1.0.0"></script>

  <script src="landing/assets/efectos/estils.js"></script>



  



</body>



</html>