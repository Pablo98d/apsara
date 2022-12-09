@extends('layouts.master')
@section('title', 'Cambiando fecha de corte a los abonos')
@section('parentPageTitle', 'Fecha de corte')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/> --}}
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')

  <div class="row mb-3 mt-3">
    <div class="col-md-12">
        @if ( session('error') )
            <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
                <center>
                    {{ session('error') }}
                </center>
                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">x</span>
                </button>
            </div>
        @endif
        @if ( session('status') )
            <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                <center>
                    {{ session('status') }}
                </center>
                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">x</span>
                </button>
            </div>
        @endif
    </div>
  </div>
  <div class="row">
      @if (count($region_zona_grupo)==0)
          Ningún grupo
      @else
      @foreach ($region_zona_grupo as $region_zona_g)
        <div class="col-md-12">

            <a href="{{url('configurar-corte-semana/'.$region_zona_g->IdPlaza.'/'.$region_zona_g->IdZona.'/'.$region_zona_g->id_grupo)}}"> <span class="btn btn-dark"><i class="fas fa-chevron-left"></i> Regregar a fechas de corte </span> {{$region_zona_g->Plaza}} / {{$region_zona_g->Zona}} / {{$region_zona_g->grupo}}</a>
        </div>
      @endforeach
      @endif

  </div>
  <div class="row">
      <div class="col-md-12">
          <hr>
      </div>
      <div class="col-md-12">
        <div class="estilo-tabla">
            <form id="guardarCambiosCorteForm" action="{{url('guardar-cambios-fecha-corte')}}" method="post">
                @csrf
            <table>
                <thead>
                    <th >No. Abono</th>
                    <th >Préstamos</th>
                    <th >Semana</th>
                    <th >Tipo abono</th>
                    <th >Cantidad</th>
                    <th >Fec. Pago</th>
                    {{-- <th>Fec. Corte</th> --}}
                    <th >Fecha de corte</th>
                </thead>
                <tbody>
                    
                    @if (count($abonos_corte)==0)
                        Sin abonos
                    @else
                        @foreach ($abonos_corte as $abonos_c)
                            <tr>
                                <td>
                                <input type="hidden" name="id_abono[]" value="{{$abonos_c->id_abono}}">
                                    {{$abonos_c->id_abono}}</td>
                                <td >No.{{$abonos_c->id_prestamo}} | {{$abonos_c->nombre}} {{$abonos_c->ap_paterno}} {{$abonos_c->ap_materno}}</td>
                                <td >
                                    <center>
                                        {{$abonos_c->semana}}
                                    </center>
                                </td>
                                <td >
                                    <center>

                                        {{$abonos_c->tipoAbono}}
                                    </center>
                                </td>
                                <td >{{$abonos_c->cantidad}}</td>
                                <td >
                                    @php
                                        $fechaPago = $abonos_c->fecha_pago;
                                        setlocale(LC_TIME, "spanish");
                                        $fecha_pago = $fechaPago;
                                        $fecha_pago = str_replace("/", "-", $fecha_pago);
                                        $Nueva_Fecha_pago = date("d-m-Y", strtotime($fecha_pago));
                                    @endphp
                                    {{$Nueva_Fecha_pago}}
                                </td>
                                {{-- <td>{{$abonos_c->id_corte_semana}}</td> --}}
                                <td >
                                    @php
                                        $cortes_semana = DB::table('tbl_cortes_semanas')
                                        ->select('tbl_cortes_semanas.*')
                                        ->where('tbl_cortes_semanas.id_grupo','=',$abonos_c->id_grupo)
                                        ->orderBy('tbl_cortes_semanas.id_corte_semana','DESC')
                                        ->get();
                                    @endphp
                                    <input type="hidden" id="nueva_fecha_corte{{$abonos_c->id_abono}}" name="nueva_fecha_corte[]" value="">
                                    <select id="seleccion_fecha" name="" class="form-control show-tick ms select2" id="" data-placeholder="Select" onchange="asignar_nueva_fecha(this.value,'{{$abonos_c->id_abono}}');">
                                        @if (count($cortes_semana)==0)
                                            <option value="" selected>Sin fechas de corte</option>
                                        @else
                                        
                                            @foreach ($cortes_semana as $cortes_s)
                                            @php
                                                $fechaCorte = $cortes_s->fecha_final;
                                                setlocale(LC_TIME, "spanish");
                                                $fecha_corte = $fechaCorte;
                                                $fecha_corte = str_replace("/", "-", $fecha_corte);
                                                $Nueva_Fecha_Corte = date("d-m-Y", strtotime($fecha_corte));
                                            @endphp
                                                <option value="{{$cortes_s->id_corte_semana}}"
                                                    
                                                    {{$cortes_s->id_corte_semana==$abonos_c->id_corte_semana ? 'selected' : 'Seleccione una fecha de corte'}}

                                                >#{{$cortes_s->id_corte_semana}} | {{$Nueva_Fecha_Corte}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <hr>
            <button type="button" class="btn btn-primary mt-3" style="float: right" data-toggle="modal" data-target="#guardarCambiosCorteModel">
                Guardar cambios
              </button>
            {{-- <button class="btn btn-primary mt-3"  type="submit">Guardar cambios</button> --}}
            </form>
            
        </div>
      </div>
  </div>
  <div class="modal fade" id="guardarCambiosCorteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body " >
          
          <div class="col-md-12">
            <center>
              <img src="{{asset('img/modal/question.png')}}" style="width: 50%" alt="">
  
            </center>
            
              <center>
                <b class="modal-title mt-2 mb-4" id="exampleModalLabel">¿Esta seguro de continuar con la operación?</b><br>
              </center>
              <br>
            <center>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
              <a id="enlaceCorte" href="#" class="btn btn-success" style="background: #870374;" onclick="guardarCambiosCorte()" data-dismiss="modal">Continuar</a>
            </center>
          </div>
         
        </div>
        {{-- <div class="modal-footer"> --}}
        {{-- </div> --}}
      </div>
    </div>
  </div> 
 <br>
 <br>
 <br>
 <br>
 <br>
@stop
@section('page-script')
<script>
    function asignar_nueva_fecha(id_corte_semana,id_abono){
        // $("#nueva_fecha_corte").val(id_corte_semana);
        var nueva_fecha='nueva_fecha_corte'+id_abono
        console.log(nueva_fecha)
        document.getElementById(nueva_fecha).value=id_corte_semana
    }
    function guardarCambiosCorte(){
        document.getElementById("guardarCambiosCorteForm").submit();
    }
</script>

{{-- <script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script> --}}
{{-- <script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script> --}}
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop