@extends('layouts.master')
@section('title', 'Buscando - zonas')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
        <form id="formregion" action="{{url('operacion/buscar_prestamos1')}}" method="GET">
                <label for="">Región</label>
                <select class="form-control show-tick ms select2" name="id_region" id="" onchange="buscarzona()" data-placeholder="Select">
                    <option value="">Seleccione una región</option>
                    @foreach ($regiones as $region)
                        <option value="{{$region->IdPlaza}}"
                            {{$idregion==$region->IdPlaza ? 'selected' : 'Seleccione una region'}}
                            >{{$region->Plaza}}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    @if (!empty($zonas))
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="estilo-tabla">
                    <table class="col-md-12">
                        <thead>
                            <tr>
                                <th class="en-2">No. Zona</th>
                                <th class="en-3">Zona</th>
                                <th class="en-5">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($zonas as $zona)
                            <tr>
                                <td class="td-2"><h6>#{{$zona->IdZona}}</h6></td>
                                <td><h6>{{$zona->Zona}}</h6></td>
                                <td>
                                    <center>
                                        <a href="{{url('operacion/buscar-grupo/'.$zona->IdZona.'/'.$idregion)}}" class="btn btn-primary" style="background: #880379"  title="Muesta el listado de grupos de esta zona">
                                            
                                            <img src="{{asset('img/grupo-de-usuario.png')}}" width="30px" style="border-radius: 20px" alt="">
                                            <br> Grupos
                                        </a>
                                        <a href="{{url('rutas/visitas/varias-visitas/'.$zona->IdZona.'/'.$idregion)}}"  class="btn btn-primary " style="background: #880379" title="Nos permite agregar varias visitas para esta zona">
                                            <img src="{{asset('img/visita-zona.png')}}" width="30px" style="border-radius: 20px" alt=""> 
                                            <br>Visitas</a>
                                        <a href="{{url('grupos/zona/corte_zona/'.$idregion.'/'.$zona->IdZona)}}"  class="btn btn-secondary " style="background: #880379" title="Hace una previsualización del reporte de corte">
                                            <img src="{{asset('img/icons-rojos/clientes.png')}}" width="30px" style="border-radius: 20px; background: #fff" alt="">
                                            <br> Reporte de corte</i>
                                        </a>
                                    </center>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
        
    @else
    <div class="col-md-12 mt-3">
        <center>
            <b>Seleccione una región</b>
        </center>

    </div>
    @endif
    <br><br>

@stop
@section('page-script')
<script>
    window.onload = function agregar_boton_atras(){
      document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';

  }
</script>
<script>
  function buscarzona()
  {
      document.getElementById("formregion").submit();
  }

</script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop