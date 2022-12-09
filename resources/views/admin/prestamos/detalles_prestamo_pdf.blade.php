<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalles de prestamo</title>
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
       
    <style>
       
        .contenido-general{
            font-family: Arial, Helvetica, sans-serif !important;
            width: 90%;
            margin-top: 20px; 
            margin: 0 auto;
        }
        .contenido-text{
            margin: 0 auto;
            width: 95%;
        }
        .hr-1{
            border: solid 2px navy;
        }
        .hr-2{
            margin-top:15px !important;
            margin-bottom: 20px !important;
        }
        .hr-3{
            margin: 0px;
            border: solid 1px;
        }
        .label{
            margin: 0;
            color: deeppink !important;
            font-weight: bold;
            font-size: 13px;
        }
        .label-2{
            font-weight: bold;
            font-size: 14px !important;
            color: navy !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 13px;
        }
        .fila{
            
            width: 100%;
        }
        .text-1{
            width: 70px;
            p

        }
        .separador-text{
            width: 150px;
            color: white;
        }
        .text-grande{
            font-size: 1.2em;
            font-weight: bold;
            color: navy;
        }
        .columna-1{
            margin: 0;
            padding: 0;
        }
        .separador-10{
            width: 10px;
        }
        .separador-20{
            width: 20px;
            color: white;
        }
        .separador-30{
            width: 30px;
        }
        .separador-40{
            width: 40;
            color: white;
        }
        .separador-50{
            width: 50;
        }
        .separador-100{
            width: 100px;
            color: white;
        }
        .label-w-10{
            width: 10px;
        }
        .label-w-20{
            width: 20px;
        }
        .label-w-40{
            width: 40px;
        }
        .label-w-50{
            width: 50px;
        }
        .label-w-75{
            width: 75px;
        }
        .label-w-100{
            width: 100px;
        }
        .label-w-150{
            width: 150px;
        }
        .label-w-200{
            width: 200px;
        }
        .label-w-300{
            width: 300px;
        }
        .estilo-tabladia{
            width: 100%;
        }
        .estilo-tabladia th,td{
            font-size: 13px;
            padding: 0;
            color: black;
        }
        .ancho-1{
            width: 200px;
        }
        .ancho-2{
            width: 200px;
        }
        .ancho-3{
            width: 200px;
        }
        .estilo-tabladia-2{
            width: 100%;
        }
        .estilo-tabladia-2 th{
            padding: 5px;
            font-size: 13px;
            color: navy;
        }
        .estilo-tabladia-2 td{
            font-size: 10px;
            padding: 5px;
        }

        #contenedor div{ 
            float:left; 
        }
    </style>
</head>
<body>
        <img  class="float-right" style="margin-left:105px; margin-bottom: 5px; z-index: -80; margin-top: 2px;"  src="{{asset('img/logoferiecita.png')}}" width="170px" height="80px">
        <br>
        <div>
            <label style="background: rgba(17, 0, 112, 0.712); color: #fff; padding-left: 15px; padding-right: 15px; padding-top: 1px; padding-bottom: 1px; border-radius: 10px;">RELACIÓN DE PRÉSTAMO</label>
        </div>
        @if (count($datos_prestamo)==0)
            <center>No hay datos</center>
        @else
        <br>
        
        <br>
        <div style="margin: 0px; padding: 5px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos del cliente
        </div>
        <div style="margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            <label style="width: 80px; margin: 0px; padding: 0px; font-size: 11px;  text-align: center">No. Cliente</label>
            <label style="width: 250px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">Cliente</label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">Tel. Casa</label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">Celular</label>
            <br>
            <label style="width: 80px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->no_usuario}}</b></label>
            <label style="width: 250px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_nombre.' '.$datos_prestamo[0]->cli_paterno.' '.$datos_prestamo[0]->cli_materno}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_telefono_casa}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_telefono_celular}}</b></label>
            <br>
            <label style="width: 300px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">Dirección</label>
            <label style="width: 100px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">No. Exterior</label>
            <label style="width: 100px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">No. Interior</label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">Colonia</label>
            <br>
            <label style="width: 300px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_direccion}}</b></label>
            <label style="width: 100px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_numero_exterior}}</b></label>
            <label style="width: 100px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_numero_interior}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_colonia}}</b></label>
            <br>
            <label style="width: 90px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">CP</label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">Localidad</label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">Municipio</label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">Estado</label>
            <br>
            <label style="width: 90px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_codigo_postal}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_localidad}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_municipio}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->cli_estado}}</b></label>


        </div>
            
        <br><br>

        <div style="margin: 0px; padding: 5px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Detalle del préstamo
        </div>
        <div style="margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            <label style="width: 110px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">No. Préstamo</label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 11px; text-align: center">Producto</label>
            <label style="width: 120px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">Monto</label>
            <label style="width: 150px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">Fecha solicitud</label>
            <label style="width: 100px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">Estatus</label>
            <br>
            <label style="width: 110px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->id_prestamo}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px; font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->producto}}</b></label>
            <label style="width: 120px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>$ {{number_format($datos_prestamo[0]->cantidad,2)}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->fecha_solicitud}}</b></label>
            <label style="width: 100px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->status_prestamo}}</b></label>
            <br>

            <label style="width: 200px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">Grupo</label>
            <label style="width: 250px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">Promotora</label>
            <label style="width: 150px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">Autorizó</label>
            
            
            <br>
            <label style="width: 200px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->grupo}}</b></label>
            <label style="width: 250px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->pro_nombre.' '.$datos_prestamo[0]->pro_paterno.' '.$datos_prestamo[0]->pro_materno}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->administrador}}</b></label>
            <br>

            <label style="width: 150px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">Fecha de aprobación</label>
            <label style="width: 150px; margin: 0px; padding: 0px;  font-size: 11px; text-align: center">Fecha de entrega de recurso</label>
            <br>
            <label style="width: 150px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->fecha_aprovacion}}</b></label>
            <label style="width: 150px; margin: 0px; padding: 0px;  font-size: 12px; background: #fff; border-radius: 10px; text-align: center"><b>{{$datos_prestamo[0]->fecha_entrega_recurso}}</b></label>




            



        </div>
        @endif
    </div>
    
</body>
</html>