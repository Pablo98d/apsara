@extends('layouts.master')
@section('title', 'Buscando - grupos')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>

@stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <label for="">Región</label>
            <a href="{{url('operacion/buscar_prestamos1?id_region='.$region->IdPlaza)}}" class="form-control" title="Clic para ir a las zonas de esta región">{{$region->Plaza}}</a>
            {{-- <input class="form-control" type="text" value="{{$region->Plaza}}" readonly> --}}
        </div>
        <div class="col-md-6">
            <form id="formZona" action="{{url('operacion/buscar-grupo/0/'.$region->IdPlaza)}}" method="get">
                <label for="">Zona</label>
                <select class="form-control show-tick ms select2" data-placeholder="Select" onchange="buscar_grupo()" name="id_zona" id="">
                    
                    @foreach ($zonas as $zon)
                        <option value="{{$zon->IdZona}}" 
                            {{$zona->IdZona==$zon->IdZona ? 'selected' : 'Seleccione un grupo'}}
                            >{{$zon->Zona}}</option>
                    @endforeach
                </select>
            </form>
            {{-- <input class="form-control" type="text" value="{{$zona->Zona}}" readonly> --}}
        </div>
    </div>
    @if (!empty($grupos))
        <div class="row mt-3">
            <div class="col-md-12">
                <span style="color: red"> <strong>Nota: </strong> Solo grupos que tienen clientes aparecen en esta lista </span>
                <div class="estilo-tabla">
                    <table class="col-md-12">
                        <thead>
                            <tr>
                                <th class="en-2">No. Grupo</th>
                                <th class="en-2">Grupo</th>
                                <th class="en-5">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grupos as $grupo)
                            @php
                                $semana_corte_actual=DB::table('tbl_cortes_semanas')
                                ->select('tbl_cortes_semanas.*')
                                ->where('id_grupo','=',$grupo->id_grupo)
                                ->get();
                            @endphp
                            <tr>
                                <td class="td-2">
                                    <h6>
                                        #{{$grupo->id_grupo}}
                                    </h6>
                                </td>
                                <td>
                                    <h6>
                                        {{$grupo->grupo}}</td>
                                    </h6>
                                <td>
                                    @php
                                        $grupos = DB::table('tbl_grupos')
                                        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
                                        ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
                                        ->select('tbl_grupos.*','tbl_zona.Zona','tbl_zona.IdZona')
                                        ->where('tbl_grupos.id_grupo','=',$grupo->id_grupo)
                                        ->orderBy('tbl_grupos.grupo','ASC')
                                        ->distinct()
                                        ->get();
                                        
                                    @endphp
                                    @if (count($grupos)==0)
                                        <center>
                                            <a href="{{url('rutas/visitas/visitas-porgrupo/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" class="btn btn-primary btn-sm" style="background: #880379" title="Visita de zonas">
                                                <img src="{{asset('img/visita-zona.png')}}" width="30px" style="border-radius: 20px" alt=""> 
                                                <br>Visitas</a>
                                        </center>
                                    @else
                                    <center>
                                        <a href="{{url('prestamo/buscar-cliente/'.$zona->IdZona.'/'.$region->IdPlaza.'/'.$grupo->id_grupo)}}" style="background: #880379"  class="btn btn-info btn-sm" title="Préstamos activos y renovaciones">
                                            <img src="{{asset('img/icons-rojos/clientes.png')}}" width="30px" style="border-radius: 20px; background: #ffff" alt="">
                                            <br>Clientes
                                        </a>
                                        <a href="{{url('rutas/visitas/visitas-porgrupo/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" class="btn btn-primary btn-sm" style="background: #880379" title="Visita de zonas">
                                            <img src="{{asset('img/visita-zona.png')}}" width="30px" style="border-radius: 20px" alt=""> 
                                            <br>Visitas</a>
                                        <a href="{{url('operacion/prospecto/admin-operaciones-prospectos/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" class="btn btn-success btn-sm" style="background: #880379" title="Prospectos">
                                            <img src="{{asset('img/man.png')}}" width="30px" style="border-radius: 20px; background: #fff;padding: 3px;" alt="">    
                                            <br>Prospectos
                                        </a> 
                                        <a href="{{url('operacion/socio/admin-operaciones-socio_eco/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}" class="btn btn-warning btn-sm" style="background: #880379" title="Estudios socioeconómicos">
                                            <img src="{{asset('img/icons-rojos/se.png')}}" width="30px" style="border-radius: 20px; background: #fff;padding: 3px;" alt="">
                                            <br>Estudios. S.E.</a>
                                        <a href="{{url('configurar-corte-semana/'.$region->IdPlaza.'/'.$zona->IdZona.'/'.$grupo->id_grupo)}}"  class="btn btn-dark btn-sm" style="background: #880379" title="Configurar corte semana">
                                            <img src="{{asset('img/cogwheel.png')}}" width="30px" style="border-radius: 20px; background: #fff;padding: 2px;" alt="">
                                            <br>Corte
                                        @if(count($semana_corte_actual)==0)
                                            <i style="color:red;" class="fas fa-exclamation" title="Se necesita configuraci&oacute;n"></i>
                                        @else
                                        
                                        @endif
                                        
                                        </a>
                                    </center>
                                    @endif
                                    
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
        
    @else
        
    @endif
@stop
@section('page-script')
<script>
    window.onload = function agregar_boton_atras(){
  
      document.getElementById('Atras').innerHTML='<a href="{{url('operacion/buscar_prestamos1?id_region='.$region->IdPlaza)}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';

  }
</script>
<script>
  function buscar_grupo()
  {
      document.getElementById("formZona").submit();
  }

</script>
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop