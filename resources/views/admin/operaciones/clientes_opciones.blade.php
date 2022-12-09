@extends('layouts.master')
@section('title', 'Todos los clientes ativos y renovados')
@section('parentPageTitle', 'préstamos')
@section('page-style')



@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <table>
                <thead>
                    <tr>
                        <th>No. C</th>
                        <th>Usuario</th>
                        <th>Cliente</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($clientes)==0)
                        No hay clientes
                    @else
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{$cliente->id}}</td>
                                <td>{{$cliente->nombre_usuario}}</td>
                                <td>{{$cliente->nombre_usuario}}</td>
                                <td>
                                    
                                </td>


                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>
@stop
@section('page-script')


@stop