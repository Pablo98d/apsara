@extends('layouts.master')
@section('title', 'Monitoreo de gerentes de zona')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@stop
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Hecho</strong> {{$respuesta->response}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
          <div class="col-md-5">
            <div class="row">
              <div class="col-md-12">
                <label for="">Nombre usuario</label>
                <input type="text" class="form-control" disabled="" value="{{$respuesta->name}}">
              </div>
              <div class="col-md-12 mt-4">
                @php
                  use GuzzleHttp\Client;

                                      $client = new Client([
                              // Base URI is used with relative requests
                              'base_uri' => 'https://api.indacar.io/',
                              'timeout'  => 9.0,
                          ]);
                          $auto = $client->post('https://api.indacar.io/api/vehicules/get',[

                              'form_params'=>
                              [
                                  'token'=>$respuesta->token
                              ]
                          ]);

                          $autos_obtenidos= json_decode( $auto->getBody()->getContents());
                  $obtenido=$autos_obtenidos->data;
                @endphp
                <label for="">Mis autos</label>
                <div class="card col-md-12">
                  <form action="{{route('buscar_autos')}}" method="get">
                    <input type="hidden" name="token" value="{{$respuesta->token}}">
                      <button type="submit" class="btn btn-primary"> Mis autos <i class="fas fa-car"></i></button>
                  </form>
                </div>
              </div>
            </div>
            

            
          </div>
          <div class="col-md-7">
          </div>
        </div>
        <div class="row">
          
        </div>
        
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        

    </div>
    
</div>
@stop
@section('page-script')
<script>
  // var contenido = document.querySelector('#id_content')
  // var token
  
  window.onload=function traer()
  {
      
      var url = 'https://api.indacar.io/api/vehicules/get';
      var data = {token: '{{$respuesta->token}}'};
      

      fetch(url, {
        method: 'POST', 
        body: JSON.stringify(data), 
        headers:{
            'Content-Type': 'application/json'
        }
      }).then(res => res.json())
      .catch(error => console.error('Error:', error))
      .then(response =>{
        console.log(response)
          var autos=response.data;
          console.log(autos)
            $var_php=autos;
            initMap(autos)
          // console.log(autos)
          // listar_autos(autos)

        // console.log('Success:', response.data)
      } )
  }
  // window.onload=miFuncion;
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-RynbG6IqumGahIpCQQNLqRcIqkYxrW4"></script>


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
