@extends('layouts.master')
@section('title', 'Registro Domicilio')
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
        <a class="btn btn-success" type="submit" href="{{ route('domicilio.create') }}" title="Nuevo Usuario">Nuevo Registro</a>
        <a href="{{ url('/domicilioexportar') }}">Exportar datos</a>
    </div>
    <div class="body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Socio Economico</th>
              <th>Calle</th>
              <th>N. Exterior</th>
              <th>N. Interior</th>
              <th>E. Calles</th>
              <th>C. Localidad</th>
              <th>Municipio</th>
              <th>Estado</th>
              <th>R. Visual</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($domicilio))
            @foreach ($domicilio as $dom)
            <tr>
              <td>{{$dom->id_domicilio}}</td>
              <td>{{$dom->id_socio_economico}}</td>
              <td>{{$dom->calle}}</td>
              <td>{{$dom->numero_ext}}</td>
              <td>{{$dom->numero_int}}</td>
              <td>{{$dom->entre_calles}}</td>
              <td>{{$dom->colonia_localidad}}</td>
              <td>{{$dom->municipio}}</td>
              <td>{{$dom->estado}}</td>
              <td>{{$dom->referencia_visual}}</td>
              <td class="d-flex">
                <a class="btn btn-info" type="submit" href="{{ url('admin/domicilio/' .$dom->id_domicilio.'/edit') }}">Editar</a>
                 | 
                <form action="{{ url('admin/domicilio/' .$dom->id_domicilio) }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button class="btn btn-danger" type="submit" onclick="return confirm('¿Desea borrarlo?')">Borrar</button>
                </form>
              </td>
            </tr>
            @endforeach
            @else
              <p>No hay Registros</p>
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