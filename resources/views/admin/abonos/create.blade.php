@extends('layouts.master')
@section('title', 'Registro Abonos')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
  <div class="form-row">
    {{--- regiones---}}
  <div class="form-group col-md-6">
      <form id="formregion" action="{{ url('a-buscar-zona') }}" method="GET">
        <div>
          <label for="id_grupo">Regiones</label>
        </div>
        <select name="idplaza" onchange="buscarzona()" class="form-control" id="">
            <option value="">--Seleccione una región--</option>
          @foreach ($regiones as $region)
            <option value="{{$region->IdPlaza}}" 
            {{$fidplaza==$region->IdPlaza ? 'selected' : 'Seleccione una region'}}
            >{{$region->Plaza}}</option>
          @endforeach
        </select>
        <label for="">{{$fidplaza}}</label>
      </form>
    </div>
    
    {{---Zonas---}}
    <div class="form-group col-md-6">
        @if (empty($zonas))
          <div class="form-group">
          
            <label for="">Zonas</label>
            <div class="col-md-12 alert alert-warning" role="alert">
              Seleccione una región para mostrar las zonas
            </div>
          </div>
        @else
          <form id="formgrupo" action="{{ url('a-buscar-grupo') }}" method="GET">
            <div>
            <input type="text" values="{{$fidplaza}}">
              <label for="idzona">Zonas</label>
            </div>
            <select name="idzona" onchange="buscargrupo()" class="form-control" id="">
                <option value="">--Seleccione una zona--</option>
              @foreach ($zonas as $zona)
                <option value="{{$zona->IdZona}}" 
                {{$fzona==$zona->IdZona ? 'selected' : 'Seleccione una zona'}}
                >{{$zona->Zona}}</option>
              @endforeach
            </select>
          </form>
        @endif
    </div>

    {{---Grupos---}}
    <div class="form-group col-md-6">
        @if (empty($grupos))
          <div class="form-group">
            <div class="col-md-12 alert alert-warning" role="alert">
              Seleccione una zona para mostrar los grupos
            </div>
          </div>
        @else
          <form id="formgrupo" action="{{ route('buscar') }}" method="POST">
          {{ csrf_field() }}
            <div>
              <label for="id_grupo">Grupos</label>
            </div>
            <select name="id_grupo" onchange="buscarc()" class="form-control" id="">
                <option value="">--Seleccione un grupo--</option>
              @foreach ($grupos as $grupo)
                <option value="{{$grupo->id_grupo}}" 
                {{$fgrupo==$grupo->id_grupo ? 'selected' : 'Seleccione un grupo'}}
                >{{$grupo->grupo}}</option>
              @endforeach
            </select>
          </form>
        @endif
    </div>

    
    @if (empty($gclientes))
    </div>
    <div class="form-group">
      <div class="col-md-12 alert alert-warning" role="alert">
        Seleccione el grupo para mostrar los clientes
      </div>
    </div>
    @else
    <div class="form-group col-md-6">
      <form id="formp" action="{{ route('buscarp') }}" method="POST">
        {{ csrf_field() }}
          <input type="hidden" name="id_grupo" value="{{$fgrupo}}">
          <div>
            <label for="id_prestamo">Clientes</label>
          </div>
          <select name="id_cliente" onchange="buscarp()" class="form-control" id="">
              <option value="">--Seleccione un cliente--</option>
              @foreach ($gclientes as $cliente)
                <option value="{{$cliente->id}}"
                {{$idcliente==$cliente->id ? 'selected' : 'Seleccione un cliente'}}
                >{{$cliente->nombre}} {{$cliente->ap_paterno}} {{$cliente->ap_materno}}</option>
              @endforeach
          </select>
      </form>
    </div>
    @endif
  </div>

  @if (empty($prestamos))
  <div class="form-group">
    <div class="col-md-12 alert alert-warning" role="alert">
      Seleccione el cliente
    </div>
  </div>
  @else
  <div class="form-row">
    <div class="accordion col-md-12" id="accordionExample">
      <br>
      <hr>
      <center><b>Préstamos</b></center>
      <hr>
        @foreach ($prestamos as $prestamo)
            <div class="card mb-0">
            <div class="card-header" id="headingOne">
                <div class="row">
                    <div class="col-md-6">
                        <small># prestamo</small> <small>Producto</small><br>
                        {{$prestamo->id_prestamo}} {{$prestamo->producto}}
                    </div>
                    
                    <div class="col-md-4">
                        <br>
                        <a href="#" type="button" data-toggle="collapse" data-target="#collapse{{$prestamo->id_prestamo}}" aria-expanded="true" aria-controls="">Ver detalle del préstamo</a>

                    </div>
                </div>
            </div>
            <div id="collapse{{$prestamo->id_prestamo}}" class="collapse" aria-labelledby="" data-parent="#accordionExample">

              @php
                  $datosabonos=DB::table('tbl_abonos')
                  ->where('id_prestamo', '=', $prestamo->id_prestamo)
                  ->get();
                  
              @endphp
                <div class="body mb-4">
                  <div class="col-md-12">
                    <div class="header">
                    
                    </div>
                    <br><br>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      @if ( session('Status') )
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          {{ session('Status') }}
                          <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"></span>
                          </button>
                        </div>
                      @endif

                    </div>
                    <div class="col-md-8">
                      <center> 
                        <b>
                        Detalle de pagos (abonos)
                        </b>
                      </center> 
                      <hr>
                      <table class="table">
                        <thead>
                          <th>No. abono</th>
                          <th>Semanas</th>
                          <th>Cantidad</th>
                          <th>Fecha</th>
                        </thead>
                        <tbody>
                        @if (empty($datosabonos[0]->id_abono))
                          
                        @else
                          <tr>
                            <td>{{$datosabonos[0]->id_abono}}</td>
                            <td>Semana {{$datosabonos[0]->semana}}</td>
                            <td>{{$datosabonos[0]->cantidad}}</td>
                            <td>{{$datosabonos[0]->fecha_pago }}</td>
                          </tr>
                        @endif
                        @if (empty($datosabonos[1]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[1]->id_abono}}</td>
                          <td>Semana {{$datosabonos[1]->semana}}</td>
                          <td>{{$datosabonos[1]->cantidad}}</td>
                          <td>{{$datosabonos[1]->fecha_pago }}</td>
                        </tr>
                        @endif
                        @if (empty($datosabonos[2]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[2]->id_abono}}</td>
                          <td>Semana {{$datosabonos[2]->semana}}</td>
                          <td>{{$datosabonos[2]->cantidad}}</td>
                          <td>{{$datosabonos[2]->fecha_pago }}</td>
                        </tr>
                        @endif
                        @if (empty($datosabonos[3]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[3]->id_abono}}</td>
                          <td>Semana {{$datosabonos[3]->semana}}</td>
                          <td>{{$datosabonos[3]->cantidad}}</td>
                          <td>{{$datosabonos[3]->fecha_pago }}</td>
                        </tr>
                        @endif
                        @if (empty($datosabonos[4]->id_abono))
                         
                        @else
                        <tr>
                          <td>{{$datosabonos[4]->id_abono}}</td>
                          <td>Semana {{$datosabonos[4]->semana}}</td>
                          <td>{{$datosabonos[4]->cantidad}}</td>
                          <td>{{$datosabonos[4]->fecha_pago }}</td>
                        </tr>
                        @endif
                        @if (empty($datosabonos[5]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[5]->id_abono}}</td>
                          <td>Semana {{$datosabonos[5]->semana}}</td>
                          <td>{{$datosabonos[5]->cantidad}}</td>
                          <td>{{$datosabonos[5]->fecha_pago }}</td>
                        </tr>
                        @endif
                        @if (empty($datosabonos[6]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[6]->id_abono}}</td>
                          <td>Semana {{$datosabonos[6]->semana}}</td>
                          <td>{{$datosabonos[6]->cantidad}}</td>
                          <td>{{$datosabonos[6]->fecha_pago }}</td>
                        </tr>
                        @endif
                        @if (empty($datosabonos[7]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[7]->id_abono}}</td>
                          <td>Semana {{$datosabonos[7]->semana}}</td>
                          <td>{{$datosabonos[7]->cantidad}}</td>
                          <td>{{$datosabonos[7]->fecha_pago }}</td>
                        </tr>
                        @endif
                        @if (empty($datosabonos[8]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[8]->id_abono}}</td>
                          <td>Semana {{$datosabonos[8]->semana}}</td>
                          <td>{{$datosabonos[8]->cantidad}}</td>
                          <td>{{$datosabonos[8]->fecha_pago }}</td>
                        </tr>
                        @endif
                        @if (empty($datosabonos[9]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[9]->id_abono}}</td>
                          <td>Semana {{$datosabonos[9]->semana}}</td>
                          <td>{{$datosabonos[9]->cantidad}}</td>
                          <td>{{$datosabonos[9]->fecha_pago }}</td>
                        </tr>
                        @endif 
                        @if (empty($datosabonos[10]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[10]->id_abono}}</td>
                          <td>Semana {{$datosabonos[10]->semana}}</td>
                          <td>{{$datosabonos[10]->cantidad}}</td>
                          <td>{{$datosabonos[10]->fecha_pago }}</td>
                        </tr>
                        @endif 
                        @if (empty($datosabonos[11]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[11]->id_abono}}</td>
                          <td>Semana {{$datosabonos[11]->semana}}</td>
                          <td>{{$datosabonos[11]->cantidad}}</td>
                          <td>{{$datosabonos[11]->fecha_pago }}</td>
                        </tr>
                        @endif 
                        @if (empty($datosabonos[12]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[12]->id_abono}}</td>
                          <td>Semana {{$datosabonos[12]->semana}}</td>
                          <td>{{$datosabonos[12]->cantidad}}</td>
                          <td>{{$datosabonos[12]->fecha_pago }}</td>
                        </tr>
                        @endif 
                        @if (empty($datosabonos[13]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[13]->id_abono}}</td>
                          <td>Semana {{$datosabonos[13]->semana}}</td>
                          <td>{{$datosabonos[13]->cantidad}}</td>
                          <td>{{$datosabonos[13]->fecha_pago }}</td>
                        </tr>
                        @endif 
                        @if (empty($datosabonos[14]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[14]->id_abono}}</td>
                          <td>Semana {{$datosabonos[14]->semana}}</td>
                          <td>{{$datosabonos[14]->cantidad}}</td>
                          <td>{{$datosabonos[14]->fecha_pago }}</td>
                        </tr>
                        @endif
                        @if (empty($datosabonos[15]->id_abono))
                          
                        @else
                        <tr>
                          <td>{{$datosabonos[15]->id_abono}}</td>
                          <td>Semana {{$datosabonos[15]->semana}}</td>
                          <td>{{$datosabonos[15]->cantidad}}</td>
                          <td>{{$datosabonos[15]->fecha_pago }}</td>
                        </tr>
                        @endif
                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-4">
                      <center> 
                        <b>
                        Hacer pagos
                        </b>
                      </center> 
                      <hr>
                      <form action="{{route('abonos.store')}}" method="post">
                          @csrf
                          <input type="hidden" class="form-control" name="id_prestamo" value="{{$prestamo->id_prestamo}}">
                          <label for="">Semanas</label>
                          <select class="form-control mb-2" name="semana" >
                            <option value="1">Semana 1</option>
                            <option value="2">Semana 2</option>
                            <option value="3">Semana 3</option>
                            <option value="4">Semana 4</option>
                            <option value="5">Semana 5</option>
                            <option value="6">Semana 6</option>
                            <option value="7">Semana 7</option>
                            <option value="8">Semana 8</option>
                            <option value="9">Semana 9</option>
                            <option value="10">Semana 10</option>
                            <option value="11">Semana 11</option>
                            <option value="12">Semana 12</option>
                            <option value="13">Semana 13</option>
                            <option value="14">Semana 14</option>
                          </select>
                          <label for="">Cantidad</label>
                          <input type="text" class="form-control mb-2" name="cantidad">
                          <label for="">Fecha</label>
                          <input type="date" class="form-control mb-3" name="fecha_pago" require>
                          
                          <input type="submit" class="btn-primary btn-sm" value="Agregar pago">

                      </form>
                    </div>
                  </div>

                </div>
            </div>
            </div>
        @endforeach
    </div>
  </div>
  @endif
@stop
@section('page-script')

<script>
  function buscarzona()
  {
      document.getElementById("formregion").submit();
  }
  function buscargrupo()
  {
      document.getElementById("formgrupo").submit();
  }
  function buscarp()
  {
      document.getElementById("formp").submit();
  }
</script>

<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop