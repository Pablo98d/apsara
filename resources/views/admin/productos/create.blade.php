@extends('layouts.master')
@section('title', 'Nuevo producto')
@section('parentPageTitle', 'Prestamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<hr>
<form method="POST" action="{{ route('productos.store') }}">
  @csrf
  <div class="form-row mt-4">
      <div class="col-md-3">
        <label for="producto">Producto</label>
        <input class="form-control" id="producto" type="text" name="producto" id="producto" value="{{old('producto')}}">
      </div>
      <div class="col-md-2">
        <label for="rango_inicial">Rango Inicial</label>
        <input class="form-control" id="rango_inicial" type="number" min="1" pattern="^[0-9]+" name="rango_inicial" value="{{old('rango_inicial')}}">
      </div>
      <div class="col-md-2">
        <label for="rango_final">Rango final</label>
        <input class="form-control" id="rango_final" type="number" min="1" pattern="^[0-9]+" name="rango_final" value="{{old('rango_final')}}">
      </div>
      <div class="col-md-1">
        <label for="semanas">Semanas</label>
        <input class="form-control" id="semanas" type="number" min="1" pattern="^[0-9]+" name="semanas" value="{{old('semanas')}}">
      </div>
      <div class="col-md-1">
        <label for="reditos">Rédito</label>
        <input class="form-control" id="reditos" type="number" min="1" pattern="^[0-9]+" name="reditos" value="{{old('reditos')}}">
      </div>
    
      <div class="col-md-1">
        <label for="papeleria">Papelería</label>
        <input class="form-control" id="papeleria" type="number" min="1" pattern="^[0-9]+" name="papeleria" value="{{old('papeleria')}}">
      </div>
    </div>
    <div class="form-row mt-4">
      <div class="col-md-2">
        <label for="comision_promotora">Comisión promotora</label>
        <input class="form-control" id="comision_promotora" type="number" min="1" pattern="^[0-9]+" name="comision_promotora" value="{{old('comision_promotora')}}">
      </div>
      <div class="col-md-2">
        <label for="comision_cobro_perfecto">Comisión cobro perfecto</label>
        <input class="form-control" id="comision_cobro_perfecto" type="number" min="1" pattern="^[0-9]+" name="comision_cobro_perfecto" value="{{old('comision_cobro_perfecto')}}">
      </div>
      <div class="col-md-2">
        <label for="penalizacion">Penalización</label>
        <input class="form-control mt-4" id="penalizacion" type="number" min="1" pattern="^[0-9]+" name="penalizacion" value="{{old('penalizacion')}}">
      </div>
      <div class="col-md-2">
        <label for="pago_semanal">Pago semanal</label>
        <input class="form-control mt-4" id="pago_semanal" type="number" min="1" pattern="^[0-9]+" name="pago_semanal" value="{{old('pago_semanal')}}">
      </div>
      <div class="col-md-2">
        <label for="ultima_semana">última semana</label>
        <input class="form-control mt-4" id="ultima_semana" type="number" min="1" pattern="^[0-9]+" name="ultima_semana" value="{{old('ultima_semana')}}">
      </div>
    </div>
  </div>
  <div class="form-row mt-4">
    <div class="col-md-12 ml-3">
      <button class="btn btn-primary" type="submit">Guardar</button>
      {{-- <a class="btn btn-danger" type="submit" href="{{ route('productos.index') }}">Cancelar</a> --}}
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