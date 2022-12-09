<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pdf de grupos</title>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <style>
        hr {
            border: 3px solid #092EA2;
        }
        .color-letra{
            color: #FF30EF;
        }
        .color-letraa{
            font: 13px;
            color: #092EA2;
        }
        .margin-p{
            margin-left: 20px;
        }
        .container-p {
            margin: 0 auto;
            width: 90%;
            background: #ECEEDE;
        }
    </style>
</head>
<body>
    <hr>
    <div class="container-p">
        <label for="" class="color-letra"><b>Grupos</b></label>

    </div>
    <div>
    </div>
    
    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Grupo</th>
                <th>Zona</th>
                <th>Localidad</th>
                <th>Municipio</th>
                <th>Estado</th>
                <th>Clientes</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($grupos)) 
                @foreach ($grupos as $grupo)
            <tr>
                <td>{{$grupo->id_grupo}}</td>
                <td>{{$grupo->grupo}}</td>
                <td>
                    @if ($grupo->IdZona=='')
                        <small>
                            <b style="color:red;">No tiene sona</b>
                        </small>
                    @else
                    <a  href="{{ url('admin-zona/'.$grupo->IdZona) }}">{{$grupo->Zona}}</a> 
                    @endif
                    
                </td>
                <td>{{$grupo->localidad}}</td>
                <td>{{$grupo->municipio}}</td>
                <td>{{$grupo->estado}}</td>
                <td>
                    @php
                        $clientes=DB::table('tbl_prestamos')->select(DB::raw('count(*) as totalclientes'))
                                ->where('id_grupo', '=',$grupo->id_grupo)
                                ->get();
                    @endphp
                    @if($clientes[0]->totalclientes==0)
                        <small>No hay clientes</small>	
                    @else
                        {{$clientes[0]->totalclientes}}
                    @endif
                </td>
            </tr>
            @endforeach
            @else
                <p>No hay registros</p>
            @endif
        </tbody>
    </table>
    
</body>
</html>