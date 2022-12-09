







<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

    <head>

        <meta charset="utf-8">
        <meta lang="es">

        <meta http-equiv="X-UA-Compatible" content="IE=Edge">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{asset("Icono_pagina/logo.png")}}" type="image/x-icon">

        

        <title>{{ config('app.name') }} - @yield('title')</title>

        <meta name="description" content="@yield('meta_description', config('app.name'))">

        <meta name="author" content="@yield('meta_author', config('app.name'))">

        <link href="{{ asset('css/estilos_menus.css') }}" rel="stylesheet">

        @yield('meta')

        {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}

        @stack('before-styles')        

            <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">

        @if (trim($__env->yieldContent('page-style')))

            @yield('page-style')

        @endif

        <!-- Custom Css -->

        <link rel="stylesheet" href="{{asset('css/estilos_personalizado.css')}}">

        <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">

        <link rel="stylesheet" href="{{asset('assets/fontawesome-free-5.13.0-web/css/all.css')}}">

        @stack('after-styles')

        

    </head>

    <?php 

        $setting = !empty($_GET['theme']) ? $_GET['theme'] : '';

        

        $theme = "theme-blush";

        $menu = "";

        if ($setting == 'p') {

            $theme = "theme-purple";

        } else if ($setting == 'b') {

            $theme = "theme-blue";

        } else if ($setting == 'g') {

            $theme = "theme-green";

        } else if ($setting == 'o') {

            $theme = "theme-orange";

        } else if ($setting == 'bl') {

            $theme = "theme-cyan";

        } else {

            $theme = "theme-orange";

        }



        if (Request::segment(2) === 'rtl' ){

            $theme .= " rtl";

        }

    ?>

    <body class="<?= $theme ?>">

        {{-- @include('master.header') --}}

        {{-- @yield('contenido') --}}

        <!-- Page Loader -->

        {{-- <div class="page-loader-wrapper">

            <div class="loader">

                <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('assets/images/lf/logoHada.png')}}" width="48" height="48" alt="Aero"></div>

                <p>Por favor espere...</p>        

            </div>

        </div> --}}

        <!-- Overlay For Sidebars -->

        <div class="overlay"></div>

        <div class="col-md-12">

            @php

                $prospectos = DB::table('tbl_prestamos')

                ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')

                ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')

                ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')

                ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')

                ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')

                ->select('tbl_prestamos.*','tbl_datos_usuario.*','tbl_grupos.grupo','tbl_grupos.id_grupo','tbl_zona.Zona','tbl_zona.IdZona','tbl_plaza.IdPlaza','tbl_plaza.Plaza')

                ->where('id_status_prestamo','=',1)

                ->get();

        

                // if (count($prospectos)==0) {

                    

                // } else {

                    $renovaciones = DB::table('tbl_prestamos')

                    ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')

                    ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')

                    ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')

                    ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')

                    ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')

                    ->select('tbl_prestamos.*','tbl_datos_usuario.*','tbl_grupos.grupo','tbl_grupos.id_grupo','tbl_zona.Zona','tbl_zona.IdZona','tbl_plaza.IdPlaza','tbl_plaza.Plaza')

                    ->where('id_status_prestamo','=',9)

                    // ->where('id_status_prestamo','=',10)

                    ->get();

        

                    $prestamosnuevos = DB::table('tbl_prestamos')

                    ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')

                    ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')

                    ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')

                    ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')

                    ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')

                    ->select('tbl_prestamos.*','tbl_datos_usuario.*','tbl_grupos.grupo','tbl_grupos.id_grupo','tbl_zona.Zona','tbl_zona.IdZona','tbl_plaza.IdPlaza','tbl_plaza.Plaza')

                    ->where('id_status_prestamo','=',10)

                    // ->where('id_status_prestamo','=',10)

                    ->get();

        

                    $rechazado_por_cliente = DB::table('tbl_prestamos')

                    ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')

                    ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')

                    ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')

                    ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')

                    ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')

                    ->select('tbl_prestamos.*','tbl_datos_usuario.*','tbl_grupos.grupo','tbl_grupos.id_grupo','tbl_zona.Zona','tbl_zona.IdZona','tbl_plaza.IdPlaza','tbl_plaza.Plaza')

                    ->where('id_status_prestamo','=',17)

                    // ->where('id_status_prestamo','=',10)

                    ->get();

                    

                    $prestamos_anticipados = DB::table('tbl_prestamos')

                    ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')

                    ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')

                    ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')

                    ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')

                    ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')

                    ->select('tbl_prestamos.*','tbl_datos_usuario.*','tbl_grupos.grupo','tbl_grupos.id_grupo','tbl_zona.Zona','tbl_zona.IdZona','tbl_plaza.IdPlaza','tbl_plaza.Plaza')

                    ->where('id_status_prestamo','=',19)

                    ->get();

        

                    

                   

                // }

                $contador_renovaciones=0;

            @endphp

              @if (count($prestamosnuevos)==0)

                

              @else

                  <div class="modal fade" id="modal_renovacion" tabindex="-1" role="dialog">

                      <div class="modal-dialog modal-lg" role="document">

                          <div class="modal-content">

                              <div class="col-md-12 mt-3"  >

                                  <center>

                                      <h5 for="">Renovaciones y nuevos préstamos pendientes por entregar</h5>

                                  </center>

                                  <hr>

                                  

                                      <table class="js-basic-example">

                                          <thead>

                                          <tr>

                                              <th><small>Grupo</small></th>

                                              <th><small>No.C</small></th>

                                              <th><small>Cliente</small></th>

                                              <th><small>No.P</small></th>

                                              <th><small>F. Solicitado</small></th>

                                          </tr>

                                          </thead>

                                          <tbody>

                                              @foreach ($prestamosnuevos as $reno)

                                                  @php

                                                      $aprobados = DB::table('tbl_prestamos')

                                                          ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')

                                                          ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')

                                                          ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')

                                                          ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')

                                                          ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario') 

                                                          ->select('tbl_prestamos.*','tbl_datos_usuario.*','tbl_grupos.grupo','tbl_grupos.id_grupo','tbl_zona.Zona','tbl_zona.IdZona','tbl_plaza.IdPlaza','tbl_plaza.Plaza')

                                                          ->where('tbl_prestamos.id_usuario','=',$reno->id_usuario)

                                                          ->whereIn('tbl_prestamos.id_status_prestamo', [9,10])

                                                          ->get();

                                                  @endphp

                                                      @if (count($aprobados)==2)

                                                          @foreach ($aprobados as $aprobado)

                                                              @if ($aprobado->id_status_prestamo==10)

                                                                  <tr>

                                                                      

                                                                      

                                                                      <td><small>{{$aprobado->id_grupo}} - {{$aprobado->grupo}}</small></td>

                                      

                                                                      <td><small>#{{$aprobado->id_usuario}}</small></td>

                                                                      <td><small>{{$aprobado->nombre}} {{$aprobado->ap_paterno}} {{$aprobado->ap_materno}}</small></td>

                                                                      <td><small>

                                                                    

                                                                          <a href="{{url('prestamo/buscar-cliente/prestamos-nuevos/'.$aprobado->IdPlaza.'/'.$aprobado->IdZona.'/'.$aprobado->id_grupo)}}"  title="Ir a entregar los préstamos">

                                                                              Renovación

                                                                          </a>

                                                                      </small></td>

                                                                      <td><small>{{$aprobado->fecha_solicitud}}</small></td>

                                                                      

                                                                  

                                                                  </tr>

                                                                  @php

                                                                      $contador_renovaciones+=1;

                                                                  @endphp

                                                              @else

                                                                  

                                                              @endif

                                                          @endforeach

                                                          

                                                                            

                                                          

                                                      @else

                                                          @foreach ($aprobados as $aprobado)

                                                              @if($aprobado->id_status_prestamo==10)

                                                                  <tr>

                                                                      

                                                                      <td><small>{{$aprobado->id_grupo}} - {{$aprobado->grupo}}</small></td>

                                      

                                                                      <td><small>#{{$aprobado->id_usuario}}</small></td>

                                                                      <td><small>{{$aprobado->nombre}} {{$aprobado->ap_paterno}} {{$aprobado->ap_materno}}</small></td>

                                                                      <td><small><a href="{{url('prestamo/buscar-cliente/prestamos-nuevos/'.$aprobado->IdPlaza.'/'.$aprobado->IdZona.'/'.$aprobado->id_grupo)}}"  title="Ir a entregar los préstamos">

                                                                          Nuevo

                                                                          </a>

                                                                          </small>

                                                                      </td>

                                                                      <td><small>{{$aprobado->fecha_solicitud}}</small></td>

                                                                    

                                                                  </tr>

                                                                  @php

                                                                      $contador_renovaciones+=1;

                                                                  @endphp

                                                              @else

                                                              @endif

                                                          @endforeach

                                                      @endif

                                              @endforeach

                                          </tbody>

                                      </table>

                              </div>

                          <div class="modal-footer">

                                  <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>

                                  </form>

                              </div>

                          </div>

                      </div>

                  </div>

              @endif

              <div class="modal fade" id="modal_prospecto" tabindex="-1" role="dialog">

                  <div class="modal-dialog modal-lg" role="document">

                      <div class="modal-content">

                          <div class="col-md-12 mt-3">

                              <center>

                                  <h5 for="">Nuevos prospectos</h5>

                              </center>

                              <hr>

                              <table class="js-basic-example">

                                  <thead>

                                  <tr>

                                      <th><small>Zona</small></th>

                                      <th><small>Grupo</small></th>

                                      <th><small>No.C</small></th>

                                      <th><small>Cliente</small></th>

                                      <th><small>No.P</small></th>

                                      <th><small>F. Solicitado</small></th>

                                      {{-- <th><small>Estatus</small></th> --}}

                                      <th><small>Operación</small></th>

                                  </tr>

                                  </thead>

                                  <tbody>

                                      @foreach ($prospectos as $prospecto)

                                      <tr>

                                          <td><small>{{$prospecto->IdZona}} - {{$prospecto->Zona}}</small></td>

                                          <td><small>{{$prospecto->id_grupo}} - {{$prospecto->grupo}}</small></td>

              

                                          <td><small>{{$prospecto->id_usuario}}</small></td>

                                          <td><small>{{$prospecto->nombre}} {{$prospecto->ap_paterno}} {{$prospecto->ap_materno}}</small></td>

                                          <td><small>{{$prospecto->id_prestamo}}</small></td>

                                          <td><small>{{$prospecto->fecha_solicitud}}</small></td>

                                          {{-- <td><small>{{$prospecto->status_prestamo}}</small></td> --}}

                                          <td>

                                              {{-- <a class="btn btn-warning btn-sm" type="submit" href="{{ url('prestamo/buscar-cliente/admin/prestamos/' .$prospecto->id_prestamo.'/edit') }}">Actualizar</a> --}}

                                              <a href="{{url('operacion/prospecto/admin-operaciones-prospectos/'.$prospecto->IdPlaza.'/'.$prospecto->IdZona.'/'.$prospecto->id_grupo)}}" class="btn btn-success btn-sm">Revisar</a>

                                              

                                          </td>

                                      </tr>

                                      

                                      @endforeach

                                  </tbody>

                              </table>

                          </div>

                          <div class="modal-footer">

                              <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>

                              </form>

                          </div>

                      </div>

                  </div>

              </div>

              <div class="modal fade" id="modal_rechazadoporcliente" tabindex="-1" role="dialog">

                  <div class="modal-dialog modal-lg" role="document">

                      <div class="modal-content">

                          <div class="col-md-12 mt-3">

                              <center>

                                  <h5 for="">Préstamos rechazados por el cliente, pendientes por recibir</h5>

                              </center>

                              <hr>

                              <table class="js-basic-example">

                                  <thead>

                                  <tr>

                                      <th><small>Zona</small></th>

                                      <th><small>Grupo</small></th>

                                      <th><small>No.C</small></th>

                                      <th><small>Cliente</small></th>

                                      <th><small>No.P</small></th>

                                      <th><small>F. Solicitado</small></th>

                                      {{-- <th><small>Estatus</small></th> --}}

                                      <th><small>Operación</small></th>

                                  </tr>

                                  </thead>

                                  <tbody>

                                      @if (count($rechazado_por_cliente)==0)

                                          

                                      @else

                                          @foreach ($rechazado_por_cliente as $rechazado_por_c)

                                                 

                                              <tr>

                                                  <td><small>{{$rechazado_por_c->IdZona}} - {{$rechazado_por_c->Zona}}</small></td>

                                                  <td><small>{{$rechazado_por_c->id_grupo}} - {{$rechazado_por_c->grupo}}</small></td>

                  

                                                  <td><small>{{$rechazado_por_c->id_usuario}}</small></td>

                                                  <td><small>{{$rechazado_por_c->nombre}} {{$rechazado_por_c->ap_paterno}} {{$rechazado_por_c->ap_materno}}</small></td>

                                                  <td><small>{{$rechazado_por_c->id_prestamo}}</small></td>

                                                  <td><small>{{$rechazado_por_c->fecha_solicitud}}</small></td>

                                                  {{-- <td><small>{{$prospecto->status_prestamo}}</small></td> --}}

                                                  <td>

                                                      <center>

                                                          <a href="{{url('prestamo/buscar-cliente/prestamos-devolucion/'.$rechazado_por_c->IdPlaza.'/'.$rechazado_por_c->IdZona.'/'.$rechazado_por_c->id_grupo)}}" class="btn btn-success btn-sm" title="Préstamos aprobados y pendientes por entregar">Ver</a>

                                                      </center>

                                                  </td>

                                              </tr>

                                          @endforeach

                                          

                                      @endif

                                  </tbody>

                              </table>

                          </div>

                      <div class="modal-footer">

                              <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>

                              </form>

                          </div>

                      </div>

                  </div>

              </div>

              <div class="modal fade" id="modal_anticipados" tabindex="-1" role="dialog">

                    <div class="modal-dialog modal-lg" role="document">

                        <div class="modal-content">

                            <div class="col-md-12 mt-3">

                                <center>

                                    <h5 for="">Préstamos anticipados</h5>

                                </center>

                                <hr>

                                <table class="js-basic-example">

                                    <thead>

                                    <tr>

                                        <th><small>Zona</small></th>

                                        <th><small>Grupo</small></th>

                                        <th><small>No.C</small></th>

                                        <th><small>Cliente</small></th>

                                        <th><small>No.P</small></th>

                                        <th><small>F. Solicitado</small></th>

                                        {{-- <th><small>Estatus</small></th> --}}

                                        <th><small>Operación</small></th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                        @if (count($prestamos_anticipados)==0)

                                            

                                        @else

                                            @foreach ($prestamos_anticipados as $prestamo_anticipado)

                                                

                                                <tr>

                                                    <td><small>{{$prestamo_anticipado->IdZona}} - {{$prestamo_anticipado->Zona}}</small></td>

                                                    <td><small>{{$prestamo_anticipado->id_grupo}} - {{$prestamo_anticipado->grupo}}</small></td>

                    

                                                    <td><small>{{$prestamo_anticipado->id_usuario}}</small></td>

                                                    <td><small>{{$prestamo_anticipado->nombre}} {{$prestamo_anticipado->ap_paterno}} {{$prestamo_anticipado->ap_materno}}</small></td>

                                                    <td><small>{{$prestamo_anticipado->id_prestamo}}</small></td>

                                                    <td><small>{{$prestamo_anticipado->fecha_solicitud}}</small></td>

                                                    {{-- <td><small>{{$prospecto->status_prestamo}}</small></td> --}}

                                                    <td>

                                                        <center>

                                                            <a href="{{url('prestamo/buscar-cliente/prestamos-anticipados/'.$prestamo_anticipado->IdPlaza.'/'.$prestamo_anticipado->IdZona.'/'.$prestamo_anticipado->id_grupo)}}" class="btn btn-success btn-sm" title="Préstamos aprobados y pendientes por entregar">Ver</a>

                                                        </center>

                                                    </td>

                                                </tr>

                                            @endforeach

                                            

                                        @endif

                                    </tbody>

                                </table>

                            </div>

                        <div class="modal-footer">

                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>

                                </form>

                            </div>

                        </div>

                    </div>

              </div>

        </div>

        

        {{-- @include('layouts.navbarright') --}}

        @include('layouts.sidebar')

        {{-- @include('layouts.rightsidebar') --}}

        <style>

            .contenido-admin{

                /* background: red; */

                /* position: initial; */

                /* padding: 90px 60px 0; */

                margin: 0 auto;

                max-width: 1400px;

                

            }

        </style>

        <section class="contenido-admin mt-4">

            {{-- <div class="block-header">

                <div class="row">

                    <div class="col-lg-10 col-md-6 col-sm-12">

                        <h2>@yield('title')</h2>

                      

                        <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>

                    </div>     

                    <div class="col-lg-2 col-md-6 col-sm-12" id="Atras">



                    </div>

                </div>

            </div> --}}

            <div class="container-fluid">                

                @yield('content')

            </div>

        </section>

        @yield('modal')

        <!-- Scripts -->



        <script>

            function modal_prospecto(){

                $("#modal_prospecto").modal();

            }

        

            function modal_renovacion(){

                $("#modal_renovacion").modal();

            }

        

            function modal_rechazadoporcliente(){

                $("#modal_rechazadoporcliente").modal();

            }



            function modal_anticipados(){

                $("#modal_anticipados").modal();

            }

        

            function modal_monitoreo(){

                $("#modal_monitoreo").modal();

            }



            

        </script>

        @stack('before-scripts')

        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    

        {{-- <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> --}}



        {{-- <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script> --}}

        @stack('after-scripts')

        @if (trim($__env->yieldContent('page-script')))

            @yield('page-script')

		@endif

    

        

        <script>

        

            function buscarCliente() {

    

                nombre_cliete = document.getElementById("nombre_cliente");

                

                console.log(nombre_cliete);

                /*Para llenar la tabla din��micamente**/

    

                $.ajax({

                    data: {

                        "_token": "{{ csrf_token() }}",

                        "nombre_cliente": nombre_cliente,

                    },

                    url: "{{ url('buscar_cliente') }}",

                    type: 'post',

                    dataType: "json",

                    success: function(resp) {

    

                        /*una vez que el archivo recibe el request lo procesa y lo devuelve

                        y  construye la tabla dentro del modal con el nombre y tipo del documento de 

                        determinada fase

                        */

    

                        console.log(resp);

                        

                        $(".display tbody tr").remove();

                        

                        trHTML = '';

                        $.each(resp, function(i, userData) {

    

                            var public_path = "{{asset('documents/') }}";

                            var f = public_path + "/" + resp[i].url

                            trHTML +=

                                '<tr><td >' +

                                '<a  target="_blank" class="badge badge-pill badge-info" href="'+f+'">'+resp[i].url +' </a>'+    

                                '<td>'+ resp[i].titulo +' </td>'+

                                '</td>><td>' +

                               ' <a id="deldoc" href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal" data-id="'+resp[i].id+'" data-name="'+resp[i].url+'">'+

                               '<i class="fa fa-trash"></i></a>'+ 

                               '</tr>';

                        });

    

                        $('#cuerpodocumentos').append(trHTML);

    

                        if (resp.length == 0) {

                            trHTML += '<tr><td>Sin documentos</td><td></td></tr>';

                            $('#cuerpodocumentos').append(trHTML);

                        }

                    

                    },

                    error: function(response) {

                      

                    }

                });

              

            }

        </script>



    {{-- <script src="{{asset('js/deletemodaldocument.js')}}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script src="js/sweetAlert.js"></script> --}}





    </body>

</html>