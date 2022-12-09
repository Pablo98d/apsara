@extends('layouts.master')
@section('title', 'Registrar varias visitas')
@section('parentPageTitle', 'Socioeconómicos')
@section('page-style')
<link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

@stop
@section('content')
  <div class="col-md-12">
    @if ( session('status') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
    @endif
        
    </div>
  <div class="body">
        <div class="row mb-4">
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    <form action="{{url('rutas/visitas/varias-visitas-store')}}" method="post">
        @csrf
        <div class="estilo-tabla">
            <table class="">
                <thead>
                    <tr>
                        <th>No. Grupo</th>
                        <th>Grupo</th>
                        <th>Dia de visita</th>
                        <th>Gerente de zona</th>
                        <th>Promotor</th>
                        {{--<th>Completar</th>--}}
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($grupos))
                        @foreach ($grupos as $grupo)
                            <tr>
                                <td>
                                    {{$grupo->id_grupo}}
                                    <input type="hidden" value="{{$grupo->id_grupo}}" name="id_grupo[]">
                                </td>
                                <td>{{$grupo->grupo}}</td>
                                <td>
                                    <select class="form-control" style="width: 90%" name="id_dia[]" id="">
                                        <option value="">--Seleccione el día--</option>
                                        @foreach ($dias as $dia)
                                            <option value="{{$dia->id_dia}}">{{$dia->nombre_dia}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" style="width: 90%" name="id_gerente_zona[]" id="">
                                        <option value="">--Seleccione el gerente de zona--</option>    
                                        @foreach ($allgerentes as $gerente)
                                            <option value="{{$gerente->id}}">{{$gerente->id}} {{$gerente->nombre.' '.$gerente->ap_paterno.' '.$gerente->ap_materno}}</option>
                                        @endforeach
                                    </select>    
                                
                                </td>
                                <td>
                                @php
                                    $promotoras=DB::table('tbl_grupos_promotoras')
                                    ->join('tbl_usuarios','tbl_grupos_promotoras.id_usuario','tbl_usuarios.id')
                                    ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')

                                    ->join('tbl_grupos','tbl_grupos_promotoras.id_grupo','tbl_grupos.id_grupo')
                                    
                                    ->select('tbl_usuarios.*','tbl_datos_usuario.*','tbl_grupos_promotoras.id_grupo_promotoras','tbl_grupos.grupo','tbl_grupos.id_grupo')
                                    ->where('tbl_grupos.id_grupo','=',$grupo->id_grupo)
                                    ->get();
                                @endphp 
                                    <select class="form-control" style="width: 90%" name="id_grupo_promotora[]" id="">
                                        <option value="">--Seleccione promotor--</option> 
                                        @foreach ($promotoras as $promotor)
                                            <option value="{{$promotor->id_grupo_promotoras}}">{{$promotor->id_grupo_promotoras}} {{$promotor->nombre.' '.$promotor->ap_paterno.' '.$promotor->ap_materno}}</option>

                                        @endforeach   
                                    </select>   
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <p>No hay registros</p>
                    @endif
                </tbody>
            </table>
            <br>
            <button style="float: right" class="btn btn-primary" onclick="return confirm('Verifique que cada visita por cada grupo, tenga seleccionado el DÍA, GERENTE DE ZONA y PROMOTOR. ¿Esta seguro de continuar?) ')" type="submit">Guardar visitas</button>
            <br>
            <br><br>
        </div>
    </form>
  </div>

@stop
@section('page-script')
<script>
    

    window.onload = function agregar_boton_atras(){
        document.getElementById('Atras').innerHTML='<a href="{{url('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
        document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
    
  }
</script>
<script>
    function buscar_grupo()
    {
        document.getElementById("formZona").submit();
    }

</script>

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>

    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop