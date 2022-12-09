@extends('layouts.master')
@section('title', 'Operaciones')
@section('parentPageTitle', 'Prospectos')
@section('content')

<style>
    .context-menu{
        width: 200px;
        height: auto;
        box-shadow: 0 0 20px 0 #ccc;
        position: absolute;
        display: none;
    }
    .context-menu ul{
        list-style: none;
        padding: 5px 0px 0px;
    }
    .context-menu ul li:not(.separator){
        padding: 10px 5px 10px 5px;
        border-left: 4px solid transparent;
        cursor: pointer;
    }
    .context-menu ul li:hover{
        background: #eee;
        border-left: 4px solid #666;
    }
    .separator{
        height: 1px;
        background: #dedede;
        margin: 2px 0px 2px 0px;
        width: 100%;
    }
</style>
<h1>pagina en desarrollo</h1>
<div class="container" oncontextmenu="return showContextMenu(event);">
    <div id="contextMenu" class="context-menu">
        <ul>
            <li>Agregar nuevo</li>
            <li>Eliminar</li>
            <li>Editar </li>
            <li>Buscar</li>
            <li class="separator"></li>
            <li>Actualizar</li>
        </ul>
    </div>
</div>
    <table>
        <thead>
            <th>Columna 1</th>
            <th>Columna 2</th>
            <th>Columna 3</th>
            <th>OPciones</th>

        </thead>
        <tbody>
            <tr>
                <td>Juan</td>
                <td>Orgin</td>
                <td>Rendon</td>
                <td><a href="#" onclick="showContextMenu(event)">...</a></td>
            </tr>
        </tbody>
    </table>
    <script type="text/javascript">
        var contextMenu= document.getElementById('contextMenu');
        function showContextMenu(event){
            contextMenu.style.display = 'block';
            contextMenu.style.left= event.clientX + 'px';
            contextMenu.style.top= event.clientY + 'px';
            return false;
        };
    </script>
@endsection