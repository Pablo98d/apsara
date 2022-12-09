<style>
    body {
    background: url("assets/images/image-gallery/16.jpg");
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
                <div class="card-header" style="color:#cd9903; font-weight:bold; font-size:40px">{{ __('¿Quiénes Somos?') }}</div>

                <div class="card-body" style="text-align: center">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label class="col-md-12 text-md-center" style="font-weight:bold; font-size:22px">Tu solución en los momentos más complicados.</p> 
                            Trabajas día a día, tratando de ahorrar y simplemente te alcanza para salir adelante ese día a día. 
                            De repente sale una emergencia pero no tienes historial crediticio, en la empresa no te pueden apoyar economicamente, 
                            tus familiares están en la misma situación que tu y necesitas generar ese dinerito extra. 
                            Nosotros estamos para apoyarte cuando nadie más lo puede hacer. Todos se merecen ese apoyo cuando más lo necesitan.</label>
                        </div>
                    </form> 
                
                @include('publicidad.navegacion')
                
                </div>   
            </div>
        </div>
    </div>
</div>

@endsection