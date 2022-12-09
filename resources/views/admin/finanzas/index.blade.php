@extends('layouts.master')
@section('title', 'Registro Finanzas')
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
        <a class="btn btn-success" type="submit" href="{{ route('finanzas.create') }}" title="Nuevo Registro">Nuevo Registro</a>
        <a href="{{ url('/finanzasexportar') }}">Exportar datos</a>
    </div>
    <div class="body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Socio Economico</th>
              <th>D. t. credito</th>
              <th>D. otras finanzas</th>
              <th>Pensión hijos</th>
              <th>Ingresos mensuales</th>
              <th>C. b. credito</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($finanzas))
            @foreach ($finanzas as $finan)
            <tr>
              <td>{{$finan->id_finanza}}</td>
              <td>{{$finan->id_socio_economico}}</td>
              <td>{{$finan->deuda_tarjeta_credito}}</td>
              <td>{{$finan->deuda_otras_finanzas}}</td>
              <td>{{$finan->pension_hijos}}</td>
              <td>{{$finan->ingresos_mensuales}}</td>
              <td>{{$finan->buro_credito}}</td>
              <td class="d-flex">
                <a class="btn btn-info" type="submit" href="{{ url('admin/finanzas/' .$finan->id_finanza.'/edit') }}">Editar</a>
                 | 
                <form action="{{ url('admin/finanzas/' .$finan->id_finanza) }}" method="post">
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