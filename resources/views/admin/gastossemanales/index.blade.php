@extends('layouts.master')
@section('title', 'Registro Gastos Semanales')
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
        <a class="btn btn-success" type="submit" href="{{ route('gastossemanales.create') }}" title="Nuevo Registro">Nuevo Registro</a>
        <a href="{{ url('/gastossemanalesexportar') }}">Exportar datos</a>
    </div>
    <div class="body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Socio Economico</th>
              <th>Alimentos</th>
              <th>Transporte</th>
              <th>Gasolina</th>
              <th>Educación</th>
              <th>Diversión</th>
              <th>Medicamentos</th>
              <th>Deportes</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($gastossemanales))
            @foreach ($gastossemanales as $gastosemanal)
            <tr>
              <td>{{$gastosemanal->id_gasto_semanal}}</td>
              <td>{{$gastosemanal->id_socio_economico}}</td>
              <td>{{$gastosemanal->alimentos}}</td>
              <td>{{$gastosemanal->transporte_publico}}</td>
              <td>{{$gastosemanal->gasolina}}</td>
              <td>{{$gastosemanal->educacion}}</td>
              <td>{{$gastosemanal->diversion}}</td>
              <td>{{$gastosemanal->medicamentos}}</td>
              <td>{{$gastosemanal->deportes}}</td>
              <td class="d-flex">
                <a class="btn btn-info" type="submit" href="{{ url('admin/gastossemanales/' .$gastosemanal->id_gasto_semanal.'/edit') }}">Editar</a>
                 | 
                <form action="{{ url('admin/gastossemanales/' .$gastosemanal->id_gasto_semanal) }}" method="post">
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