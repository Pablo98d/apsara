@extends('layouts.master')
@section('title', 'Registro Referencia laboral personas')
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
        <a class="btn btn-success" type="submit" href="{{ route('referencialbpersonas.create') }}">Nuevo Registro</a>
        <a href="{{ url('/referencialbpersonasexportar') }}">Exportar datos</a>
    </div>
    <div class="body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Referencia laboral</th>
              <th>Nombre empresa</th>
              <th>Actividad empresa</th>
              <th>C. empresa</th>
              <th>Dirección</th>
              <th>N. exterior</th>
              <th>N. interior</th>
              <th>E. calles</th>
              <th>Teléfono</th>
              <th>Tiempo e.</th>
              <th>Jefe inmediato</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($referencialbpersonas))
            @foreach ($referencialbpersonas as $referencialbp)
            <tr>
              <td>{{$referencialbp->id_rl_persona}}</td>
              <td>{{$referencialbp->id_referencia_laboral}}</td>
              <td>{{$referencialbp->nombre_empresa}}</td>
              <td>{{$referencialbp->actividad_empresa}}</td>
              <td>{{$referencialbp->cargo_empresa}}</td>
              <td>{{$referencialbp->direccion}}</td>
              <td>{{$referencialbp->numero_ext}}</td>
              <td>{{$referencialbp->numero_int}}</td>
              <td>{{$referencialbp->entre_calles}}</td>
              <td>{{$referencialbp->telefono_empresa}}</td>
              <td>{{$referencialbp->tiempo_empresa}}</td>
              <td>{{$referencialbp->jefe_inmediato}}</td>
              <td class="d-flex">
                <a class="btn btn-info" type="submit" href="{{ url('admin/referencialbpersonas/' .$referencialbp->id_rl_persona.'/edit') }}">Editar</a>
                 | 
                <form action="{{ url('admin/referencialbpersonas/' .$referencialbp->id_rl_persona) }}" method="post">
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