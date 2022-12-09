@extends('layouts.master')
@section('title', 'Mapa de calor')
@section('parentPageTitle', 'Mapa')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estilo_ayuda.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
        'packages': ['map'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyC-RynbG6IqumGahIpCQQNLqRcIqkYxrW4'
        });
        google.charts.setOnLoadCallback(drawMap);

        function drawMap () {
        var data = new google.visualization.arrayToDataTable([
            
        ['Lat', 'Long', 'Name','Marker'],

        
        @foreach ($prestamos as $prestamo)
            @if ($prestamo->latitud=="")
                                
            @else
                @if ($prestamo->total_m>=2)
                    @if($prestamo->total_m>4)
                        [{{$prestamo->latitud}}, {{$prestamo->longitud}}, '{{$prestamo->idus}} {{$prestamo->nombre}} No.P {{$prestamo->id_prestamo}}','rojo'],
                    @else
                        [{{$prestamo->latitud}}, {{$prestamo->longitud}}, '{{$prestamo->idus}} {{$prestamo->nombre}} No.P {{$prestamo->id_prestamo}}','amarillo'],
                    @endif
                @endif
            @endif
        @endforeach
        @foreach ($pretsamos_todo_bien as $pretsamos_t_b)

            @if($pretsamos_t_b->estatus==2)
                    @if ($pretsamos_t_b->latitud=="")
                    
                    @else
                        [{{$pretsamos_t_b->latitud}}, {{$pretsamos_t_b->longitud}}, '{{$pretsamos_t_b->idur}} {{$pretsamos_t_b->nombre}} No.P {{$pretsamos_t_b->id_prestamo}}','verde'],
                    @endif
                // [{{$pretsamos_t_b->latitud}}, {{$pretsamos_t_b->longitud}}, '{{$pretsamos_t_b->idur}} {{$pretsamos_t_b->nombre}} No.P {{$pretsamos_t_b->id_prestamo}}','green'],
            @else
                @php
                    $p_aprobado=DB::table('tbl_prestamos')
                    ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                    ->select('tbl_prestamos.*','tbl_productos.*')
                    ->where('tbl_prestamos.id_usuario','=',$pretsamos_t_b->idur)
                    ->whereBetween('tbl_prestamos.id_status_prestamo', [9, 10])
                    ->get();
                @endphp
                    @if (count($p_aprobado)==1)

                        @if ($pretsamos_t_b->latitud=="")
                                        
                        @else
                            [{{$pretsamos_t_b->latitud}}, {{$pretsamos_t_b->longitud}}, '{{$pretsamos_t_b->idur}} {{$pretsamos_t_b->nombre}} No.P {{$pretsamos_t_b->id_prestamo}}','verde'],
                        @endif
                    @else
                        
                    @endif
            @endif
        @endforeach
           
        ]);
        // var url = 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/';
        var url = 'img/';

        var options = {
            zoomLevel: 6,
            showTooltip: true,
            showInfoWindow: true,
            useMapTypeControl: true,
            icons: {
            amarillo: {
                normal:   url + 'Map-amarillo48.png',
                selected: url + 'Map-select-48.png'
            },
            verde: {
                normal:   url + 'Map-verde48.png',
                selected: url + 'Map-select-48.png'
            },
            rojo: {
                normal:   url + 'Map-rojo48.png',
                selected: url + 'Map-select-48.png'
            }
            }
        };
        var map = new google.visualization.Map(document.getElementById('map_div'));

        map.draw(data, options);
        }
    </script>
@stop
@section('content')
   
    <div id="map_div" style="width: 100%; height: 550px"></div>

@endsection
@section('page-script')
<script>
    window.onload = function agregar_boton_atras(){
      document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  }
  </script>
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop