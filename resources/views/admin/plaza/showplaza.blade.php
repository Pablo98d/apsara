@extends('layouts.master')
@section('content')
    <div class="body">
        <div>
            <h5>
                Datos de la región
            </h5>
            <a href="{{route('admin-zona.index')}}" class="btn btn-outline-dark btn-sm">Regresar</a>

            <div class="form-control">
                {{$plaza->IdPlaza }}
            </div>
            <div class="form-control">
                {{$plaza->Plaza }}
            </div>
            <div class="form-control">
                {{$plaza->Fecha_apertura }}
            </div>
    </div>
@endsection