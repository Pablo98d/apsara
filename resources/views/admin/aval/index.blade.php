@extends('layouts.master')
@section('title', 'Registro Aval')
@section('parentPageTitle', 'Socio Economico')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
  <div class="header">
    @if ( session('Guardar') )
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('Guardar') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
    @endif
        <a class="btn btn-success" type="submit" href="{{ route('aval.create') }}" title="Nuevo Registro">Nuevo Registro</a>
        <a href="{{ url('/avalexportar') }}">Exportar datos</a>
    </div>
	<div class="body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
          <tr>
            <th>#</th>
            <th>Socio Economico</th>
            <th>Nombre</th>
            <th>A. Paterno</th>
            <th>A. Materno</th>
            <th>F. Nacimiento</th>
            <th>Ocupación</th>
            <th>Genero</th>
            <th>Estado civil</th>
            <th>Calle</th>
            <th>N. Exterior</th>
            <th>N. Interior</th>
            <th>Entre calles</th>
            <th>Colonia</th>
            <th>Municipio</th>
            <th>Estado</th>
            <th>Referencia visual</th>
            <th>Vivienda</th>
            <th>tiempo viviendo domicilio</th>
            <th>T. casa</th>
            <th>T. movil</th>
            <th>T. trabajo</th>
            <th>R. solicitante</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($aval))
          @foreach ($aval as $seaval)
          <tr>
            <td>{{$seaval->id_aval}}</td>
            <td>{{$seaval->id_socio_economico}}</td>
            <td>{{$seaval->nombre}}</td>
            <td>{{$seaval->ap_paterno}}</td>
            <td>{{$seaval->ap_materno}}</td>
            <td>{{$seaval->fecha_nacimiento}}</td>
            <td>{{$seaval->ocupacion}}</td>
            <td>{{$seaval->genero}}</td>
            <td>{{$seaval->estado_civil}}</td>
            <td>{{$seaval->calle}}</td>
            <td>{{$seaval->numero_ext}}</td>
            <td>{{$seaval->numero_int}}</td>
            <td>{{$seaval->entre_calles}}</td>
            <td>{{$seaval->colonia}}</td>
            <td>{{$seaval->municipio}}</td>
            <td>{{$seaval->estado}}</td>
            <td>{{$seaval->referencia_visual}}</td>
            <td>{{$seaval->vivienda}}</td>
            <td>{{$seaval->tiempo_viviendo_domicilio}}</td>
            <td>{{$seaval->telefono_casa}}</td>
            <td>{{$seaval->telefono_movil}}</td>
            <td>{{$seaval->telefono_trabajo}}</td>
            <td>{{$seaval->relacion_solicitante}}</td>
            <td class="d-flex">
              <a class="btn btn-info" href="{{ url('admin/aval/'.$seaval->id_aval.'/edit') }}" title="">Editar</a>
                | 
              <form method="POST" action="{{ url('admin/aval/'.$seaval->id_aval) }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger" type="submit" onclick="return confirm('¿Desea borrarlo?')">Borrar</button>
              </form>
            </td>
          </tr>
          @endforeach
          @else
            <p>No hay registros</p>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop