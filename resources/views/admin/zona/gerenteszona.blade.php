@extends('layouts.master')
@section('title', 'Listado gerentes de zona')
@section('parentPageTitle', 'zonas')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <div class="body">
        <div class="row">
            <div class="col-md-12">
                <h5>
                   Gerentes de Zona: {{$zona->Zona}}
                </h5>
            </div>
            <div class="col-md-6">
                <div class="estilo-tabla">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    No.
                                </th>
                                <th>
                                    Nombre usuario gerente
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gerenteszona as $gerente)
                                <tr>
                                    <td>
                                        {{$gerente->id}}
                                    </td>
                                    <td>
                                        {{$gerente->nombre_usuario}}
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<script>
	window.onload = function agregar_boton_atras(){
  
	  document.getElementById('Atras').innerHTML='<a href="{{ route('admin-zona.index') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
  
  }
  </script>

@stop