@extends('layouts.master')
@section('title', 'Detalle de zona')
@section('parentPageTitle', 'zonas')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
    <div class="body">
            <div class="col-md-12">
                <div class="estilo-tabla">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    No. Zona
                                </th>
                                <th>
                                    Nombre zona
                                </th>
                                <th>
                                    Fecha apertura
                                </th>
                                <th>Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{$zona->IdZona }}
                                </td>
                                <td>
                                    {{$zona->Zona }}
                                </td>
                                <td>
                                    {{$zona->Fecha_apertura }}
                                </td>
                                <td>
                                    <a href="#" class="btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn-danger btn-sm"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        
{{--<a href="{{route('admin-zona.index')}}" class="btn btn-outline-dark btn-sm">Regresar</a>--}}
    </div>
@endsection