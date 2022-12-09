@extends('layouts.master')
@section('title', 'Monitoreo de gerentes de zona heciendo pruebas')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{-- <meta http-equiv="refresh" content="60"> --}}

@stop
@section('content')

<div class="row">
    <div class="col-md-12">
        @php
            use GuzzleHttp\Client;
            use Carbon\Carbon;


                                $client = new Client([
                        // Base URI is used with relative requests
                        'base_uri' => 'https://api.indacar.io/',
                        'timeout'  => 9.0,
                    ]);

                    $chek_token = $client->post('https://api.indacar.io/api/auth/token/web/check',[

                        'form_params'=>
                        [
                            'token'=>$token
                        ]
                    ]);

                    $confirmando_token= json_decode( $chek_token->getBody()->getContents());

                    
                    


                    
            
        @endphp
        {{-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Hecho</strong> {{$respuesta->response}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> --}}
        {{-- {{$confirmando_token->res}} --}}
        @if ($confirmando_token->response=='Token Valido')
            @php
                    
                                
                    $auto = $client->post('https://api.indacar.io/api/vehicules/get',[

                                'form_params'=>
                                [
                                    'token'=>$token
                                ]
                            ]);
                    $autos_obtenidos= json_decode( $auto->getBody()->getContents());
                    $obtenido=$autos_obtenidos->data;
                    
                


                

            @endphp
             <div class="row">
                <div class="col-md-12">
                   <div class="row">
                       <div class="col-md-3">
                          @foreach ($obtenido as $item)
                              <div class="card" style="width: 15rem; background: rgb(54, 54, 54); color: #fff;" >
                                  @php
                                      $uc = str_split($item->lastconnection);
                                      $realH=$uc[11].$uc[12];
                                    $fecha_2=$uc[0].$uc[1].$uc[2].$uc[3].$uc[4].$uc[5].$uc[6].$uc[7].$uc[8].$uc[9]." ".$realH.$uc[13].$uc[14].$uc[15].$uc[16].$uc[17].$uc[18];
                                    $fecha_actual=Carbon::now();
                                    $fecha1=$fecha_actual->modify('+6 hours');

                                    // $fecha2 = new DateTime('2016-11-30 11:55:06');//fecha de cierre
                                    $intervalo = $fecha1->diff($fecha_2);
                                    // $fecha_2->modify('-5 hours'); 
                                    // $NuevaFecha = strtotime ( '-5 hours' , strtotime ($intervalo->format('%Y %m %d %H %i %s')) ) ;

                                    // echo $intervalo->format('%Y años %m meses %d days %H horas %i minutos 
                                    // %s segundos');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos
                                  @endphp
                                      
                                  
                                      <div class="card-body">
                                          
                                      <h6 class="" style="background: rgb(20, 168, 0); padding: 5px; color: #fff; border-radius: 20px"><center>{{$item->name}}</center></h6>
                                      <h6 class=" mb-2 " style="color: #fff;">Auto: {{$item->brand}}</h6>
                                      <p class="card-text">Modelo: {{$item->model}} <br>Año: {{$item->year}} <br>Color: {{$item->color}} <br>Placa: {{$item->plate}}</p>
                                      {{-- <a href="#" class="card-link">Card link</a>
                                      <a href="#" class="card-link">Another link</a> --}}
                                      {{-- <label for="">{{$autos}}</label> --}}
                                      </div>
                                  
                              
                              </div>
                          @endforeach
                      </div>
                       <div class="col-md-9">
                          
                      <div id="map_div" style="width: 100%; height: 550px"></div>
                       </div>
                  </div>
                   
              
              
                         
              
      
                          
      
          
                </div>
            </div>
            
        @else
            <div class="col-md-12">
                <small>Se caducó la sesion, ingrese de nuevo</small>
            <a href="{{route('home')}}" class="btn btn-primary ">Regresar</a>
            </div>
            
        @endif
       
        

    </div>
    
</div>
@stop
@section('page-script')

<script>
    var url = 'https://api.indacar.io/api/vehicules/get';
    var data = {token: '{{$token}}'};

    fetch(url, {
    method: 'POST', // or 'PUT'
    body: JSON.stringify(data), // data can be `string` or {object}!
    headers:{
        'Content-Type': 'application/json'
    }
    }).then(res => res.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
        var autos = response.data
        console.log(autos)
        drawMap(autos)
    })

    // .then(response => console.log('Success:', response.data));

    </script>
        
   
<script type="text/javascript">
    google.charts.load('current', {
    'packages': ['map'],
    // Note: you will need to get a mapsApiKey for your project.
    // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
    'mapsApiKey': 'AIzaSyC-RynbG6IqumGahIpCQQNLqRcIqkYxrW4'
    });

    google.charts.setOnLoadCallback();

    function drawMap (autos) {
       
        var data = new google.visualization.arrayToDataTable([
            
            ['Lat', 'Long', 'Name','Marker'],
            
            autos.forEach(element => {
                [element.gps.lat,element.gps.lng,"juan","rojo"],
            })
        
        
        
        ]);
        // var url = 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/';
        var url = 'img/';

        var options = {
            zoomLevel: 20,
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
                    normal:   url + 'auto_listo.png',
                    selected: url + 'auto_listo.png'
                }
            }
        };

        var map = new google.visualization.Map(document.getElementById('map_div'));

        map.draw(data, options);
    }

</script>


    <script>
        function modal_prospecto(){
            $("#modal_prospecto").modal();
        }

        function modal_renovacion(){
            $("#modal_renovacion").modal();
    }
</script>

<script src="{{asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/sparkline.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/c3.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/index.js')}}"></script>

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop
