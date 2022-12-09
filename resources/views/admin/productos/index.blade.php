@extends('layouts.master')
@section('title', 'Registro productos')
@section('parentPageTitle', 'Préstamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        @if ( session('Guardar') )
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('Guardar') }}
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true"></span>
            </button>
          </div>
        @endif
        <a class="btn btn-success btn-sm" type="submit" href="{{ route('productos.create') }}"><i class="fas fa-plus-circle"> Nuevo producto </i></a>
    </div>
</div>
    <div class="body">
      <div class="estilo-tabla">
        <table>
          <thead>
            <tr>
              <th title="Id del producto">#</th>
              <th title="Nombre del producto">Producto</th>
              <th title="Rango inicial">R.Inicial</th>
              <th title="Rango final">R.Final</th>
              <th title="Total de semanas para abonar">Semanas</th>
              <th title="Total de semanas para abonar">Meses</th>
              <th title="Interés a cobrar ">Interes</th>
              {{-- <th title="Pago de papelería"><small>Papelería</small></th> --}}
              {{-- <th title="Comisión de promotora"><small>C. Promotara</small></th> --}}
              {{-- <th title="Comisión de cobro perfecto"><small>C. Cobro perfecto</small></th> --}}
              <th title="Cantidad de multa por incumplimiento">Moratoria</th>
              {{-- <th title="Pago semanal"><small>P. Semanal</small></th> --}}
              {{-- <th title="última semana para generar multa"><small>U. Semana</small></th> --}}
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($productos))
            @foreach ($productos as $product)
            <tr>
              <td><small>{{$product->id_producto}}</small></td>
              <td><small>{{$product->producto}}</small></td>
              <td style="text-align: center; padding-right: 10px">$ {{number_format($product->rango_inicial,2)}}</td>
              <td style="text-align: center; padding-right: 4px">$ {{number_format($product->rango_final,2)}}</td>
              <td style="text-align: center; padding-right: 4px">{{$product->semanas}} </td>
              <td style="text-align: center; padding-right: 4px">{{$product->mensual}} </td>
              <td style="text-align: center; padding-right: 4px">{{$product->reditos}}%</td>
              {{-- <td style="text-align: right; padding-right: 4px"><small>{{$product->papeleria}}%</small></td> --}}
              {{-- <td style="text-align: right; padding-right: 4px"><small>{{$product->comision_promotora}}%</small></td> --}}
              {{-- <td style="text-align: right; padding-right: 4px"><small>{{$product->comision_cobro_perfecto}}%</small></td> --}}
              <td style="text-align: center; padding-right: 4px">$ {{number_format($product->penalizacion,2)}}</td>
              {{-- <td style="text-align: right; padding-right: 4px"><small>{{$product->pago_semanal}}%</small></td> --}}
              {{-- <td style="text-align: right; padding-right: 4px"><small>{{$product->ultima_semana}}</small></td> --}}
              <td class="d-flex">
                @php
                    $prestamos=DB::table('tbl_prestamos')
                    ->select('tbl_prestamos.*')
                    ->where('id_producto','=',$product->id_producto)
                    ->get();
                @endphp
                <a class="btn btn-warning btn-sm" type="submit" href="{{ url('admin/productos/' .$product->id_producto.'/edit') }}" title="Editar datos del producto"><i class="fas fa-pen"></i></a>
                 | 
                <form action="{{ url('admin/productos/' .$product->id_producto) }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  @if (count($prestamos)==0)
                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('¿Desea borrarlo?')" title="Eliminar producto"><i class="fas fa-trash"></i></button>
                  @else
                    <button class="btn btn-secondary btn-sm" type="button" onclick="alert('El producto tiene préstamos, es imposible de eliminar')" title="Eliminar producto"><i class="fas fa-trash"></i></button>
                  @endif
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
<script>
  window.onload = function agregar_boton_atras(){
    document.getElementById('Atras').innerHTML='<a href="{{route('home')}}" title="Ir atrás" class="btn btn-dark float-right right_icon_toggle_btn"><i class="fas fa-chevron-left"></i> Ir atrás</a>';
}
</script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop