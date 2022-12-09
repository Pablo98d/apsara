<style>
    body {
    background: url("assets/images/image-gallery/18.jpg");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    } 

    .linksInf > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        text-transform: uppercase;
    }    
</style>

@extends('layouts.app')

@section('content')

<div class="container" style="margin-top:50px; opacity:0.8; height: 450px;">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="color:#cd9903; font-weight:bold; font-size:40px">{{ __('Visión') }}</div>

                <div class="card-body" style="text-align: center">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label class="col-md-12 text-md-center" style="font-weight:bold; font-size:22px">
                            Ser la empresa líder en Guadalajara de préstamos personales.
                            </label>
                        </div>
                    </form> 
                
                @include('publicidad.navegacion')
                
                </div>   
            </div>
        </div>
    </div>
</div>

@endsection