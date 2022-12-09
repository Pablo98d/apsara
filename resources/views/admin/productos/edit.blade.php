@extends('layouts.master')
@section('title', 'Actualizando datos de producto')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<form method="POST" action="{{ url('admin/productos/' .$productos->id_producto) }}" enctype="multipart/form-data">
  {{ csrf_field() }}
    {{ method_field('PATCH') }}
  <div class="form-row">
    <div class="col-md-3">
      <label for="producto">Producto</label>
      <input class="form-control" type="text" name="producto" id="producto" value="{{$productos->producto}}">
    </div>
    <div class="col-md-2">
      <label for="rango_inicial">Rango inicial</label>
      <input class="form-control" type="number" name="rango_inicial" value="{{$productos->rango_inicial}}">
    </div>
    <div class="col-md-2">
      <label for="rango_final">Rango final</label>
      <input class="form-control" id="rango_final" type="number" name="rango_final" value="{{$productos->rango_final}}">
    </div>
    <div class="col-md-1">
      <label for="semanas">Semanas</label>
      <input class="form-control" id="semanas" type="number" name="semanas" value="{{$productos->semanas}}">
    </div>
    <div class="col-md-1">
      <label for="reditos">Rédito</label>
      <input class="form-control" id="reditos" type="number" name="reditos" value="{{$productos->reditos}}">
    </div>
    <div class="col-md-1">
      <label for="papeleria">Papeleria</label>
      <input class="form-control" id="papeleria" type="number" name="papeleria" value="{{$productos->papeleria}}">
    </div>
  </div>
  <div class="form-row mt-4">
    <div class="col-md-2">
      <label for="comision_promotora">Comisión promotora</label>
      <input class="form-control" id="comision_promotora" type="number" name="comision_promotora" value="{{$productos->comision_promotora}}">
    </div>
    <div class="col-md-2">
      <label for="comision_cobro_perfecto">Comisión cobro perfecto</label>
      <input class="form-control" id="comision_cobro_perfecto" type="number" name="comision_cobro_perfecto" value="{{$productos->comision_cobro_perfecto}}">
    </div>
    <div class="col-md-2">
      <label for="penalizacion">Penalización</label>
      <input class="form-control mt-4" id="penalizacion" type="number" name="penalizacion" value="{{$productos->penalizacion}}">
    </div>
    <div class="col-md-2">
      <label for="pago_semanal">Pago semanal</label>
      <input class="form-control mt-4" id="pago_semanal" type="number" name="pago_semanal" value="{{$productos->pago_semanal}}">
    </div>
    <div class="col-md-2">
      <label for="ultima_semana">Última semana</label>
      <input class="form-control mt-4" id="ultima_semana" type="number" name="ultima_semana" value="{{$productos->ultima_semana}}">
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-12 mt-3">
      <button class="btn btn-primary" type="submit">Guardar cambios</button>
    </div>
  </div>
</form>
<br><br>
@stop
@section('page-script')
<script>
  window.onload = function agregar_boton_atras(){
    document.getElementById('Atras').innerHTML='<a href="{{ route('productos.index') }}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
}
</script>
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop