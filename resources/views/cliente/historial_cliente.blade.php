@extends('layoutsC.master')
@section('title','Historial préstamos')
@section('parentPageTitle','préstamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estilo_acordeon.css')}}"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js"></script>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <hr>
        <div class="acordeon">
            @foreach ($prestamos as $prestamo)
                <div class="acordeon__item">
                    <input type="checkbox" name="acordeon" id="itme1">
                    <label for="itme1" class="acordeon__titulo"> <small>No. P: {{$prestamo->id_prestamo}} \ Préstamo: {{$prestamo->producto}}</small> 
                    <span><a href="{{url('historial_abono/'.$prestamo->id_prestamo)}}" class="btn btn-info btn-sm">Historial abonos</a></span>
                        @if ($prestamo->id_status_prestamo==1)
                            <span class="badge badge-warning"><small>Pendiente      </small></span>
                        @elseif($prestamo->id_status_prestamo==2)
                            <span class="badge badge-success"><small>Activo         </small></span>
                        @elseif($prestamo->id_status_prestamo==3)
                            <span class="badge badge-success"><small>Moroso         </small></span>
                        @elseif($prestamo->id_status_prestamo==4)
                            <span class="badge badge-success"><small>Convenio       </small></span>
                        @elseif($prestamo->id_status_prestamo==5)
                            <span class="badge badge-success"><small>Suspendido     </small></span>
                        @elseif($prestamo->id_status_prestamo==6)
                            <span class="badge badge-success"><small>Inactivo       </small></span>
                        @elseif($prestamo->id_status_prestamo==7)
                            <span class="badge badge-success"><small>No localizado  </small></span>
                        @elseif($prestamo->id_status_prestamo==8)
                            <span class="badge badge-success"><small>Pagado         </small></span>
                        @elseif($prestamo->id_status_prestamo==9)
                            <span class="badge badge-success"><small>Renovación     </small></span>
                        @endif
                        </label>
                        <div class="acordeon__contenido">
                           
                        </div>
                </div>
            @endforeach
        </div> 
        <br><br> 
    </div>
</div>
    
    
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop