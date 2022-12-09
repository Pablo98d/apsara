@extends('layouts.master')
@section('title', 'Reporte de préstamos')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
<link rel="stylesheet" href="{{asset('css/estilos_menus.css')}}"/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" integrity="sha512-siwe/oXMhSjGCwLn+scraPOWrJxHlUgMBMZXdPe2Tnk3I0x3ESCoLz7WZ5NTH6SZrywMY+PB1cjyqJ5jAluCOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-dt/2.2.3/buttons.dataTables.min.css" integrity="sha512-lvDbVjye7FzFEPdv4/3FOlNJo5UNBtZPXWbAz1ZLW+lbC+NQj9L4hKOviftwx7yieQxhFZh55lzUQ/eM4Y6O9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@stop
@section('content')
<div class="row clearfix" style="margin: 0 auto"> 
    {{-- Aqui empieza lo de accesos directo --}}
    <table id="excel" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Zona</th>
                <th>Grupo</th>
                <th>Cat.</th>
                <th>Cliente</th>
                <th>No. Prestamo</th>
                <th>Fecha entregado</th>
                <th>Monto</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @if (count($contenido_excel)==0)
                
            @else
                @foreach ($contenido_excel as $contenido_ex)
                <tr>
                    <td>{{$contenido_ex->zona}}</td>
                    <td>{{$contenido_ex->grupo}}</td>
                    <td>{{$contenido_ex->color}}</td>
                    <td>{{$contenido_ex->nombre_completo}}</td>
                    <td>{{$contenido_ex->id_prestamo}}</td>
                    <td>{{$contenido_ex->fecha_entrega_recurso}}</td>
                   
                    <td>$ {{$contenido_ex->cantidad}}</td>
                    <td>$ {{$contenido_ex->saldo}}</td>

                </tr>
                @endforeach    
                
            @endif
            
            
        </tbody>
        <tfoot>
            
            <tr>
                <th>Zona</th>
                <th>Grupo</th>
                <th>Cat.</th>
                <th>Cliente</th>
                <th>No. Prestamo</th>
                <th>Fecha entregado</th>
                <th>Monto</th>
                <th>Saldo</th>
            </tr>
        </tfoot>
    </table>


    
</div>
@stop
@section('page-script')
<script type="text/javascript">
    function ConfirmDemo() {
    //Ingresamos un mensaje a mostrar
    var mensaje = confirm("¿Esta seguro de aplicar el corte?");
    //Detectamos si el usuario acepto el mensaje
    if (mensaje) {
        location.href="{{url('corte-general')}}";
    }
    //Detectamos si el usuario denegó el mensaje
    else {
    
    }
}
</script>
<script>
    
    window.onload = function agregar_boton_atras(){
      document.getElementById('Rutas').innerHTML='<div class="cotenido-rutas"> <b> Ruta: </b> <span style="margin-left: 5px;">@if ($zona==null) Seleccione ruta <i class="fas fa-chevron-down"></i> @else {{$zona->Zona}} <i class="fas fa-chevron-down"></i> @endif</span> <div class="menu-rutas" > <ul class="ul-rutas"> <a href="{{route('admin-zona.index')}}"> <li class="li-rutas">Administrar rutas</li> </a> <a href="{{url('grupos/gerentes/allgerentes')}}"> <li class="li-rutas">Gerentes de ruta</li> </a> <a href="{{url('rutas/visitas/visitas-ruta')}}"> <li class="li-rutas">Vista de rutas</li> </a><hr> @if (count($zonas)==0) Sin resultados @else @foreach ($zonas as $zona) <a href="{{url('configuracion-zona/'.$zona->IdZona)}}"> <li class="li-rutas"> {{$zona->Zona}} #{{$zona->IdZona}} </li> </a> @endforeach @endif </ul> </div> </div>';
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js" integrity="sha512-1TK4hjCY5+E9H3r5+05bEGbKGyK506WaDPfPe1s/ihwRjr6OtL43zJLzOFQ+/zciONEd+sp7LwrfOCnyukPSsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.2.3/js/dataTables.buttons.min.js" integrity="sha512-QT3oEXamRhx0x+SRDcgisygyWze0UicgNLFM9Dj5QfJuu2TVyw7xRQfmB0g7Z5/TgCdYKNW15QumLBGWoPefYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" integrity="sha512-XMVd28F1oH/O71fzwBnV7HucLxVwtxf26XV8P4wPk26EDxuGZ91N8bsOttmnomcCD3CS5ZMRL50H0GgOHvegtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.2.3/js/buttons.html5.min.js" integrity="sha512-BdN+kHA7QfWIcQE3WMwSj5QAvVUrSGxJLv7/yuEEypMOZBSJ1VKGr9BSpOew+6va9yfGUACw/8Yt7LKNn3RKRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js"></script>
<script>
    $(document).ready(function(){
        $('#excel').DataTable({
            dom:"Bfrtip",
            buttons:{
                dom:{
                    button:{
                        className: 'btn'
                    }
                },
                buttons:[
                    {
                        extend:"excel",
                        text:'Exportar a Excel',
                        className: 'btn btn-outline-success',
                        excelStyles:{
                            template:'header_blue',
                            // cells: 'sD',
                            // condition:{
                            //     type:'cellIs',
                            //     operator:'between',
                            //     formula: [35,45]
                            // },
                            // style: {
                            //     font: {
                            //         b:true
                            //     },
                            //     fill:{
                            //         pattern:{
                            //             bgColor: 'e8f401'
                            //         }
                            //     }
                            // },
                        }
                    }
                ]

            }
        });

    })
</script>
@stop


{{-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" integrity="sha512-siwe/oXMhSjGCwLn+scraPOWrJxHlUgMBMZXdPe2Tnk3I0x3ESCoLz7WZ5NTH6SZrywMY+PB1cjyqJ5jAluCOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-dt/2.2.3/buttons.dataTables.min.css" integrity="sha512-lvDbVjye7FzFEPdv4/3FOlNJo5UNBtZPXWbAz1ZLW+lbC+NQj9L4hKOviftwx7yieQxhFZh55lzUQ/eM4Y6O9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Reporte de préstamos</title>
    <style>
        table.dataTable thead{
            background: #3783fa;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table id="excel" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Zona</th>
                            <th>Grupo</th>
                            <th>Cat.</th>
                            <th>Cliente</th>
                            <th>No. Prestamo</th>
                            <th>Fecha entregado</th>
                            <th>Monto</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($contenido_excel)==0)
                            
                        @else
                            @foreach ($contenido_excel as $contenido_ex)
                            <tr>
                                <td>Zona</td>
                                <td>Grupo</td>
                                <td>{{$contenido_ex->color}}</td>
                                <td>{{$contenido_ex->nombre_completo}}</td>
                                <td>{{$contenido_ex->id_prestamo}}</td>
                                <td>{{$contenido_ex->fecha_entrega_recurso}}</td>
                               
                                <td>{{$contenido_ex->cantidad}}</td>
                                <td>{{$contenido_ex->saldo}}</td>

                            </tr>
                            @endforeach    
                        @endif
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Zona</th>
                            <th>Grupo</th>
                            <th>Cat.</th>
                            <th>Cliente</th>
                            <th>No. Prestamo</th>
                            <th>Fecha entregado</th>
                            <th>Monto</th>
                            <th>Saldo</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js" integrity="sha512-1TK4hjCY5+E9H3r5+05bEGbKGyK506WaDPfPe1s/ihwRjr6OtL43zJLzOFQ+/zciONEd+sp7LwrfOCnyukPSsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.2.3/js/dataTables.buttons.min.js" integrity="sha512-QT3oEXamRhx0x+SRDcgisygyWze0UicgNLFM9Dj5QfJuu2TVyw7xRQfmB0g7Z5/TgCdYKNW15QumLBGWoPefYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" integrity="sha512-XMVd28F1oH/O71fzwBnV7HucLxVwtxf26XV8P4wPk26EDxuGZ91N8bsOttmnomcCD3CS5ZMRL50H0GgOHvegtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.2.3/js/buttons.html5.min.js" integrity="sha512-BdN+kHA7QfWIcQE3WMwSj5QAvVUrSGxJLv7/yuEEypMOZBSJ1VKGr9BSpOew+6va9yfGUACw/8Yt7LKNn3RKRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js"></script>




</body>
</html> --}}