<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalles de prestamo</title>
    {{-- <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/> --}}
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">

    <style>
        .respuesta{
            margin: 0px; 
            padding: 0px; 
            font-size: 12px; 
            background: #fff; 
            border-radius: 10px; 
            text-align: center;
        }
        .sut_titulos{
            margin: 0px; 
            padding: 0px; 
            font-size: 11px;  
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }
    </style>

</head>
<body>
        <img  class="float-right" style="margin-left:105px; margin-bottom: 5px; z-index: -80; margin-top: 2px;"  src="{{asset('img/logoferiecita.png')}}" width="170px" height="80px">
        <br>
        <div>
            <label style="background: rgba(17, 0, 112, 0.712); color: #fff; padding-left: 15px; padding-right: 15px; padding-top: 1px; padding-bottom: 1px; border-radius: 10px;">INFORMACIÓN DE SOCIOECONÓMICO</label>
        </div>
        
        <br>
        <hr>
        <div class="">
            <div>
                <table>
                    <tr>
                        <td>
                            @if (empty($docs_perfil[0]->path_url))
                                <center>No hay datos</center>
                            @else
                                @php
                                    $ub=str_split($docs_perfil[0]->path_url);
                                    $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                                @endphp
                                @if ($ubicacion=='DocImagenes')
                                    <img class="" src="{{$docs_perfil[0]->path_url}}" width="130" height="168" alt="" style="margin-top: 0px; border-radius: 5px;">
                                @else
                                    <img class="" src="https://laferiecita.com/ws/documentos/{{$docs_perfil[0]->path_url}}" width="130" height="175" alt="" style="margin-top: 0px; border-radius: 5px;">
                                @endif
                            @endif
                        </td>
                        <td style="width: 570px">
                            <div style="margin: 0px; margin-left: 8px; margin-bottom: 0; padding-top: 1px; padding-bottom: 1px; padding-left: 230px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff; font-size: 12px;">
                                DATOS GENERALES
                            </div>
                            <div style="margin: 0px; margin-left: 8px; margin-bottom: 0; text-align: center;  padding: 5px 5px 0px 10px; border-radius: 0px 0px 15px 15px; background: rgba(43, 0, 143, 0.089);">
                                @if (empty($datos_generales[0]->id_socio_economico))
                                <center>No hay datos</center>
                                @else
                                <label class="sut_titulos" style="width: 210px;">Curp</label>
                                <br>
                                <label class="respuesta" style="width: 210px;"><b>{{$datos_generales[0]->curp}}</b></label>
                                <br>
                                <label class="sut_titulos" style="width: 150px;">Nombre</label>
                                <label class="sut_titulos" style="width: 130px;">Apellido paterno</label>
                                <label class="sut_titulos" style="width: 130px;">Apellido materno</label>
                                <label class="sut_titulos" style="width: 120px;">Fecha de nacimiento</label>
                    
                                <br>
                                <label class="respuesta" style="width: 150px;"><b>{{$datos_generales[0]->nombre}}</b></label>
                                <label class="respuesta" style="width: 130px;"> <b>{{$datos_generales[0]->ap_paterno}}</b></label>
                                <label class="respuesta" style="width: 130px;"> <b>{{$datos_generales[0]->ap_materno}}</b></label>
                                <label class="respuesta" style="width: 120px;"><b>{{$datos_generales[0]->fecha_nacimiento}}</b></label>
                
                                <br>
                                <label class="sut_titulos" style="width: 80px;">Edad</label>
                                <label class="sut_titulos" style="width: 230px;">Ocupación</label>
                                <label class="sut_titulos" style="width: 110px;">Género</label>
                                <label class="sut_titulos" style="width: 110px;">Estado civil</label>
                        
                                <br>
                                <label class="respuesta" style="width: 80px;"><b>{{$datos_generales[0]->edad}}</b></label>
                                <label class="respuesta" style="width: 230px;"> <b>{{$datos_generales[0]->ocupacion}}</b></label>
                                <label class="respuesta" style="width: 110px;"> <b>{{$datos_generales[0]->genero}}</b></label>
                                <label class="respuesta" style="width: 110px;"> <b>{{$datos_generales[0]->estado_civil}}</b></label>
                    
                    
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div style="margin: 0px; margin-top: 10px; padding-top: 1px; padding-bottom: 1px; padding-left: 15px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff; font-size: 12px;">
                DATOS DOMICILIO
            </div>
            <div style="text-align: center; margin: 0px; border-radius: 0 0 5px 10px; background: rgba(43, 0, 143, 0.089);">
                @if (empty($domicilio[0]->id_socio_economico))
                    No hay datos
                @else
                <label class="sut_titulos" style="width: 200px;">Calle</label>
                <label class="sut_titulos" style="width: 150px;">Numero Exterior</label>
                <label class="sut_titulos" style="width: 150px;">Numero Interior</label>
                <label class="sut_titulos" style="width: 150px;">Entre Calles</label>
                <br>
                <label class="respuesta" style="width: 200px;"><b>{{$domicilio[0]->calle}}</b></label>
                <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->numero_ext}}</b></label>
                <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->numero_int}}</b></label>
                <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->entre_calles}}"</b></label>
    
                <br>
    
                <label class="sut_titulos" style="width: 150px;">Colonia Localidad</label>
                <label class="sut_titulos" style="width: 150px;">Municipio</label>
                <label class="sut_titulos" style="width: 150px;">Estado</label>
                <label class="sut_titulos" style="width: 150px;">Referencia Visual</label>
    
    
                <br>
                <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->colonia_localidad}}</b></label>
                <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->municipio}}</b></label>
                <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->estado}}</b></label>
                <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->referencia_visual}}</b></label>
    
                <br>
                @endif
            </div>
            <div style="margin: 0px; margin-top: 12px; padding-top: 1px; padding-bottom: 1px; padding-left: 15px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff; font-size: 12px;">
                TIPO DE CRÉDITO / MONTO / FECHA DE CRÉDITO
            </div>
            <div style="text-align: center; margin: 0px; padding: 3px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
                @if (empty($fechamonto[0]->id_socio_economico))
                <center>No hay datos</center>
                @else
                <label class="sut_titulos" style="width: 150px;">Monto de crédito</label><label class="respuesta" style="width: 250px;"><b>{{$fechamonto[0]->monto_credito }}</b></label>
                <label class="sut_titulos" style="width: 140px;">Fecha crédito</label><label class="respuesta" style="width: 80px;"><b>{{ $fechamonto[0]->fecha_credito}}</b></label>
    
                <br>
                
                
    
                @endif
            </div>
        </div>
        <hr style="padding: 0; margin: 4px;">
        <table>
            <tr>
                <td style="padding-left: 5px;">
                    <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 15px;  border-radius: 15px 15px 0 0; width: 100; background: rgba(17, 0, 112, 0.712); color: #fff; font-size: 12px">
                        INE FRENTE
                    </div>
                    @if (empty($docs_ine_1[0]->path_url))
                        No hay datos
                    @else
                        @php
                            $ub=str_split($docs_ine_1[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_ine_1[0]->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="340" height="210">  
                        @else
                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$docs_ine_1[0]->path_url}}"  alt="Este es el ejemplo de un texto alternativo" width="340" height="180">  
    
                        @endif
                    @endif
                </td>
                <td style="padding-left: 5px;">
                    <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 15px;  border-radius: 15px 15px 0 0; width: 100; background: rgba(17, 0, 112, 0.712); color: #fff; font-size: 12px">
                        INE REVERSO
                    </div>
                    @if (empty($docs_ine_2[0]->path_url))
                        No hay datos
                    @else
                        @php
                            $ub=str_split($docs_ine_2[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_ine_2[0]->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="340" height="210">  
                        @else
                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$docs_ine_2[0]->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="340" height="180">  
                        @endif
                    @endif
                </td>
            </tr>
            
        </table>
        <table>
            <tr>
                <td style="padding-left: 210px">
                    <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 15px;  border-radius: 15px 15px 0 0; width: 170; background: rgba(17, 0, 112, 0.712); color: #fff; font-size: 12px">
                        COMPROBANTE DE DOMICILIO
                    </div>
                    @if (empty($docs_comprobante[0]->path_url))
                        No hay datos
                    @else
                        @php
                            $ub=str_split($docs_comprobante[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_comprobante[0]->path_url}}" style="border:1px solid #000" alt="" width="340" height="270">  
                        @else
                            <img class="" src="https://laferiecita.com/ws/documentos/{{$docs_comprobante[0]->path_url}}" style="border:1px solid #000;" alt="" width="340" height="270" >  
                        @endif
                    @endif
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            INFORMACIÓN DEL AVAL
        </div>
        <div style="margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($aval[0]->id_aval))
                <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 200px;">CURP</label>
            <label class="sut_titulos" style="width: 150px;">Nombre</label>
            <label class="sut_titulos" style="width: 150px;">Ap. Paterno</label>
            <label class="sut_titulos" style="width: 150px;">Ap. Materno</label>
            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$aval[0]->curp}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$aval[0]->nombre}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$aval[0]->ap_paterno}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$aval[0]->ap_materno}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 120px;">Fecha de nacimiento</label>
            <label class="sut_titulos" style="width: 290px;">Ocupación</label>
            <label class="sut_titulos" style="width: 120px;">Género</label>
            <label class="sut_titulos" style="width: 120px;">Estado civil</label>
            <br>
            @php
               // $datenacimiento = date_create($aval[0]->fecha_nacimiento);
            @endphp
            <label class="respuesta" style="width: 120px;"><b>{{$aval[0]->fecha_nacimiento}}</b></label>
            <label class="respuesta" style="width: 290px;"><b>{{$aval[0]->ocupacion}}</b></label>
            <label class="respuesta" style="width: 120px;"><b>{{$aval[0]->genero}}</b></label>
            <label class="respuesta" style="width: 120px;"><b>{{$aval[0]->estado_civil}}</b></label>
            
            <br>
            
            <label class="sut_titulos" style="width: 190px;">Calle</label>
            <label class="sut_titulos" style="width: 110px;">No. Exterior</label>
            <label class="sut_titulos" style="width: 110px;">No. Interior</label>
            <label class="sut_titulos" style="width: 250px;">Entre calles</label>
            <br>
            <label class="respuesta" style="width: 190px;"><b>{{$aval[0]->calle}}</b></label>
            <label class="respuesta" style="width: 110px;"><b>{{$aval[0]->numero_ext}}</b></label>
            <label class="respuesta" style="width: 110px;"><b>{{$aval[0]->numero_int}}</b></label>
            <label class="respuesta" style="width: 250px;"><b>{{$aval[0]->entre_calles}}</b></label>
            <br>

            <label class="sut_titulos" style="width: 210px;">Colonia</label>
            <label class="sut_titulos" style="width: 210px;">Municipio</label>
            <label class="sut_titulos" style="width: 210px;">Estado</label>
            <br>
            <label class="respuesta" style="width: 220px;"><b>{{$aval[0]->colonia}}</b></label>
            <label class="respuesta" style="width: 220px;"><b>{{$aval[0]->municipio}}</b></label>
            <label class="respuesta" style="width: 220px;"><b>{{$aval[0]->estado}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 250px;">Referencia visual</label>
            <label class="sut_titulos" style="width: 205px;">Vivienda</label>
            <label class="sut_titulos" style="width: 205px;">Tiempo viviendo en el domicilio</label>
            <br>
            <label class="respuesta" style="width: 250px;"><b>{{$aval[0]->referencia_visual}}</b></label>
            <label class="respuesta" style="width: 205px;"><b>{{$aval[0]->vivienda}}</b></label>
            <label class="respuesta" style="width: 205px;"><b>{{$aval[0]->tiempo_viviendo_domicilio}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 160px;">Teléfono casa</label>
            <label class="sut_titulos" style="width: 160px;">Teléfono móvil</label>
            <label class="sut_titulos" style="width: 160px;">Teléfono trabajo</label>
            <label class="sut_titulos" style="width: 160px;">Fecha de registro</label>
            <br>
            <label class="respuesta" style="width: 160px;"><b>{{$aval[0]->telefono_casa}}</b></label>
            <label class="respuesta" style="width: 160px;"><b>{{$aval[0]->telefono_movil}}</b></label>
            <label class="respuesta" style="width: 160px;"><b>{{$aval[0]->telefono_trabajo}}</b></label>
            @php
                $dateregistro = date_create($aval[0]->fecha_registro);
            @endphp
            <label class="respuesta" style="width: 160px;"><b>{{date_format($dateregistro, 'd-m-Y H:i:s')}}</b></label>
            @endif
        </div><br>
        <hr><br>
        <table>
            <tr>
                <td style="padding-left: 5px;">
                    <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 15px;  border-radius: 15px 15px 0 0; width: 100; background: rgba(17, 0, 112, 0.712); color: #fff; font-size: 12px">
                        INE FRENTE
                    </div>
                    @if (empty($docs_ine_1a[0]->path_url))
                        No hay datos
                    @else
                        @php
                            $ub=str_split($docs_ine_1a[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_ine_1a[0]->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="340" height="210">  
                        @else
                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$docs_ine_1a[0]->path_url}}"  alt="Este es el ejemplo de un texto alternativo" width="340" height="180">  
    
                        @endif
                    @endif
                </td>
                <td style="padding-left: 5px;">
                    <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 15px;  border-radius: 15px 15px 0 0; width: 100; background: rgba(17, 0, 112, 0.712); color: #fff; font-size: 12px">
                        INE REVERSO
                    </div>
                    @if (empty($docs_ine_2a[0]->path_url))
                        No hay datos
                    @else
                        @php
                            $ub=str_split($docs_ine_2a[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_ine_2a[0]->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="340" height="210">  
                        @else
                            <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$docs_ine_2a[0]->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="340" height="180">  
                        @endif
                    @endif
                </td>
            </tr>
            
        </table>
        <hr>
        <table>
            <tr>
                <td style="padding-left: 210px">
                    <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 15px;  border-radius: 15px 15px 0 0; width: 170; background: rgba(17, 0, 112, 0.712); color: #fff; font-size: 12px">
                        COMPROBANTE DE DOMICILIO
                    </div>
                    @if (empty($docs_comprobantea[0]->path_url))
                        No hay datos
                    @else
                        @php
                            $ub=str_split($docs_comprobantea[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_comprobantea[0]->path_url}}" style="border:1px solid #000" alt="" width="340" height="210">  
                        @else
                            <img class="" src="https://laferiecita.com/ws/documentos/{{$docs_comprobantea[0]->path_url}}" style="border:1px solid #000;" alt="" width="280" height="280" >  
                        @endif
                    @endif
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Pareja
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($pareja[0]->id_socio_economico))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 200px;">Nombre</label>
            <label class="sut_titulos" style="width: 150px;">Apellido Paterno</label>
            <label class="sut_titulos" style="width: 150px;">Apellido Materno</label>
            <label class="sut_titulos" style="width: 150px;">Teléfono</label>
            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$pareja[0]->nombre}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$pareja[0]->ap_paterno}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$pareja[0]->ap_materno}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$pareja[0]->telefono}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 80px;">Edad</label>
            <label class="sut_titulos" style="width: 250px;">Ocupación</label>
            <br>
            <label class="respuesta" style="width: 80px;"><b>{{$pareja[0]->edad}}</b></label>
            <label class="respuesta" style="width: 250px;"><b>{{$pareja[0]->ocupacion}}</b></label>

            <br>
            @endif
        </div>
        <br>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Vivienda
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($vivienda[0]->id_socio_economico))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 200px;">Tipo vivienda</label>
            <label class="sut_titulos" style="width: 150px;">Tiempo viviendo</label>
            <label class="sut_titulos" style="width: 150px;">Teléfono Casa</label>
            <label class="sut_titulos" style="width: 150px;">Teléfono celular</label>
            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$vivienda[0]->tipo_vivienda}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$vivienda[0]->tiempo_viviendo_domicilio}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$vivienda[0]->telefono_casa}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$vivienda[0]->telefono_celular}}</b></label>

            <br>
            @endif
        </div>
        <br>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Artículos hogar
         </div>
         <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
             @if (empty($articuloshogar[0]->id_socio_economico))
                 No hay datos
             @else
                 
             <label class="sut_titulos" style="width: 60px;">Estufa</label>
             <label class="sut_titulos" style="width: 70px;">Refrigerador</label>
             <label class="sut_titulos" style="width: 70px;">Microondas</label>
             <label class="sut_titulos" style="width: 60px;">Lavadora</label>
             <label class="sut_titulos" style="width: 70px;">Secadora</label>
 
             <label class="sut_titulos" style="width: 150px;">Computadora de escritorio</label>
             <label class="sut_titulos" style="width: 60px;">Laptop</label>
             <label class="sut_titulos" style="width: 60px;">Televisión</label>
             
             <br>
             <label class="respuesta" style="width: 60px;">
                 @if ($articuloshogar[0]->estufa==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 70px;">
                 @if ($articuloshogar[0]->refrigerador==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 70px;">
                 @if ($articuloshogar[0]->microondas==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 60px;">
                 @if ($articuloshogar[0]->lavadora==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 70px;">
                 @if ($articuloshogar[0]->secadora==1)
                 <b>Si</b>
                 @endif
             </label>
 
             <label class="respuesta" style="width: 150px;">
                 @if ($articuloshogar[0]->computadora_escritorio==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 60px;">
                 @if ($articuloshogar[0]->laptop==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 60px;">
                 @if ($articuloshogar[0]->television==1)
                 <b>Si</b>
                 @endif
             </label>
 
             <br>
 
             <label class="sut_titulos" style="width: 60px;">Pantalla</label>
             <label class="sut_titulos" style="width: 80px;">Grabadora</label>
             <label class="sut_titulos" style="width: 70px;">Estereo</label>
             <label class="sut_titulos" style="width: 50px;">DvD</label>
             <label class="sut_titulos" style="width: 80px;">Blue Ray</label>
 
             <label class="sut_titulos" style="width: 110px;">Teatro casa</label>
             <label class="sut_titulos" style="width: 120px;">Bocina Portatil</label>
             
 
             <br>
             
             <label class="respuesta" style="width: 60px;">
                 @if ($articuloshogar[0]->pantalla==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 80px;">
                 @if ($articuloshogar[0]->grabadora==1)
                  <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 70px;">
                 @if ($articuloshogar[0]->estereo==1)
                  <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 50px;">
                 @if ($articuloshogar[0]->dvd==1)
                  <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 80px;">
                 @if ($articuloshogar[0]->blue_ray==1)
                  <b>Si</b>
                 @endif
             </label>
 
             <label class="respuesta" style="width: 110px;">
                 @if ($articuloshogar[0]->teatro_casa==1)
                  <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 120px;">
                 @if ($articuloshogar[0]->bocina_portatil==1)
                  <b>Si</b>
                 @endif
             </label>
 
             
             <br>
 
             <label class="sut_titulos" style="width: 80px;">Celular</label>
             <label class="sut_titulos" style="width: 90px;">Tablet</label>
             <label class="sut_titulos" style="width: 130px;">Consola videojuegos</label>
             <label class="sut_titulos" style="width: 100px;">Instrumentos</label>
             <label class="sut_titulos" style="width: 150px;">Otros</label>
             <br>
     
             <label class="respuesta" style="width: 80px;">
                 @if ($articuloshogar[0]->celular==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 90px;">
                 @if ($articuloshogar[0]->tablet==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 130px;">
                 @if ($articuloshogar[0]->consola_videojuegos==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 100px;">
                 @if ($articuloshogar[0]->instrumentos==1)
                 <b>Si</b>
                 @endif
             </label>
             <label class="respuesta" style="width: 150px;">
                 <b>{{$articuloshogar[0]->otros}}</b>
             </label>
 
             @endif
 
         </div>
         <br>
         <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Finanzas
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($finanzas[0]->id_socio_economico))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 150px;">Deuda en tarjeta de credito</label>
            <label class="sut_titulos" style="width: 140px;">Deuda en otras finanzas</label>
            <label class="sut_titulos" style="width: 110px;">Pensión para hijos</label>
            <label class="sut_titulos" style="width: 110px;">Ingresos mensuales</label>
            <label class="sut_titulos" style="width: 130px;">Cuenta en buro credito</label>

            <br>
            <label class="respuesta" style="width: 150px;"><b>{{$finanzas[0]->deuda_tarjeta_credito}}</b></label>
            <label class="respuesta" style="width: 140px;"><b>{{$finanzas[0]->deuda_otras_finanzas}}</b></label>
            <label class="respuesta" style="width: 110px;"><b>{{$finanzas[0]->pension_hijos}}</b></label>
            <label class="respuesta" style="width: 110px;"><b>$ {{number_format($finanzas[0]->ingresos_mensuales,2)}}</b></label>
            <label class="respuesta" style="width: 130px;"><b>{{$finanzas[0]->buro_credito}}</b></label>

            @endif
        </div>
        <br>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Gastos mensuales
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($gastosmensuales[0]->id_socio_economico))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 120px;">Renta en hipoteca</label>
            <label class="sut_titulos" style="width: 100px;">Telefono fijo</label>
            <label class="sut_titulos" style="width: 80px;">Internet</label>
            <label class="sut_titulos" style="width: 100px;">Telefono movil</label>
            <label class="sut_titulos" style="width: 80px;">Cable</label>
            <label class="sut_titulos" style="width: 80px;">Luz</label>
            <label class="sut_titulos" style="width: 80px;">Gas</label>

            <br>
            <label class="respuesta" style="width: 120px;"><b>$ {{number_format($gastosmensuales[0]->renta_hipoteca,2)}}</b></label>
            <label class="respuesta" style="width: 100px;"><b>$ {{number_format($gastosmensuales[0]->telefono_fijo,2)}}</b></label>
            <label class="respuesta" style="width: 80px;"> <b>$ {{number_format($gastosmensuales[0]->internet,2)}}</b></label>
            <label class="respuesta" style="width: 100px;"><b>$ {{number_format($gastosmensuales[0]->telefono_movil,2)}}</b></label>
            <label class="respuesta" style="width: 80px;"> <b>$ {{number_format($gastosmensuales[0]->cable,2)}}</b></label>
            <label class="respuesta" style="width: 80px;"> <b>$ {{number_format($gastosmensuales[0]->luz,2)}}</b></label>
            <label class="respuesta" style="width: 80px;"> <b>$ {{number_format($gastosmensuales[0]->gas,2)}}</b></label>

            @endif
        </div>
        <br>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Gastos semanales
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($gastossemanales[0]->id_socio_economico))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 120px;">Alimentos</label>
            <label class="sut_titulos" style="width: 100px;">Transporte Publico</label>
            <label class="sut_titulos" style="width: 80px;">Gasolina</label>
            <label class="sut_titulos" style="width: 100px;">Educación</label>
            <label class="sut_titulos" style="width: 80px;">Diversión</label>
            <label class="sut_titulos" style="width: 80px;">Medicamentos</label>
            <label class="sut_titulos" style="width: 80px;">Deportes</label>

            <br>
            <label class="respuesta" style="width: 120px;"><b>$ {{number_format($gastossemanales[0]->alimentos,2)}}</b></label>
            <label class="respuesta" style="width: 100px;"><b>$ {{number_format($gastossemanales[0]->transporte_publico,2)}}</b></label>
            <label class="respuesta" style="width: 80px;"> <b>$ {{number_format($gastossemanales[0]->gasolina,2)}}</b></label>
            <label class="respuesta" style="width: 100px;"><b>$ {{number_format($gastossemanales[0]->educacion,2)}}</b></label>
            <label class="respuesta" style="width: 80px;"> <b>$ {{number_format($gastossemanales[0]->diversion,2)}}</b></label>
            <label class="respuesta" style="width: 80px;"> <b>$ {{number_format($gastossemanales[0]->medicamentos,2)}}</b></label>
            <label class="respuesta" style="width: 80px;"> <b>$ {{number_format($gastossemanales[0]->deportes,2)}}</b></label>

            @endif
        </div>
        <br>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos familiares
        </div>
        <div style="margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($familiar[0]->id_socio_economico))
                <center>No hay datos</center> 
            @else
            <label class="sut_titulos" style="width: 200px;">Número de Personas</label>
            <label class="sut_titulos" style="width: 200px;">Número de personas que trabajan</label>
            <label class="sut_titulos" style="width: 200px;">Cuantos aportan dinero mensual</label>
            <br>
            <label class="respuesta" style="width: 200px; "><b>{{$familiar[0]->numero_personas}}</b></label>
            <label class="respuesta" style="width: 200px;"><b>{{$familiar[0]->numero_personas_trabajando}}</b></label>
            <label class="respuesta" style="width: 200px;"><b>{{$familiar[0]->aportan_dinero_mensual}}</b></label>
            <br>
            @endif
        </div>


        <div class="page-break"></div>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Referencia laboral
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($referencialbpersonas[0]->id_rl_persona))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 200px;">Nombre empresa</label>
            <label class="sut_titulos" style="width: 200px;">Actividad empresa</label>
            <label class="sut_titulos" style="width: 200px;">Cargo empresa</label>
            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$referencialbpersonas[0]->nombre_empresa}}</b></label>
            <label class="respuesta" style="width: 200px;"><b>{{$referencialbpersonas[0]->actividad_empresa}}</b></label>
            <label class="respuesta" style="width: 200px;"> <b>{{$referencialbpersonas[0]->cargo_empresa}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 250px;">Dirección</label>
            <label class="sut_titulos" style="width: 90px;">Numero exterior</label>
            <label class="sut_titulos" style="width: 90px;">Numero interior</label>
            <label class="sut_titulos" style="width: 200px;">Entre calles</label>
            <br>
            <label class="respuesta" style="width: 250px;"><b>{{$referencialbpersonas[0]->direccion}}</b></label>
            <label class="respuesta" style="width: 90px;"> <b>{{$referencialbpersonas[0]->numero_ext}}</b></label>
            <label class="respuesta" style="width: 90px;"> <b>{{$referencialbpersonas[0]->numero_int}}</b></label>
            <label class="respuesta" style="width: 200px;"> <b>{{$referencialbpersonas[0]->entre_calles}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 120px;">Teléfono empresa</label>
            <label class="sut_titulos" style="width: 120px;">Tiempo empresa</label>
            <label class="sut_titulos" style="width: 200px;">Jefe inmediato</label>
            <br>
            <label class="respuesta" style="width: 120px;"> <b>{{$referencialbpersonas[0]->telefono_empresa}}</b></label>
            <label class="respuesta" style="width: 120px;"> <b>{{$referencialbpersonas[0]->tiempo_empresa}}</b></label>
            <label class="respuesta" style="width: 200px;"> <b>{{$referencialbpersonas[0]->jefe_inmediato}}</b></label>

            @endif
        </div><br>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Referencia personal
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($referenciappersonas[0]->id_rp_persona))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 200px;">Nombre</label>
            <label class="sut_titulos" style="width: 230px;">Domicilio</label>
            <label class="sut_titulos" style="width: 100px;">Teléfono</label>
            <label class="sut_titulos" style="width: 130px;">Relación</label>

            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$referenciappersonas[0]->nombre}}</b></label>
            <label class="respuesta" style="width: 230px;"><b>{{$referenciappersonas[0]->domicilio}}</b></label>
            <label class="respuesta" style="width: 100px;"> <b>{{$referenciappersonas[0]->telefono}}</b></label>
            <label class="respuesta" style="width: 130px;"> <b>{{$referenciappersonas[0]->relacion}}</b></label>

            @endif
        </div>
        <br>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de garantías
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (count($datosgarantias)==0)
            <center>No hay garantías</center>
            @else
                @foreach ($datosgarantias as $datosgarantia)
                    <label class="sut_titulos" style="width: 300px;">Tipo garantía</label>
                    <label class="sut_titulos" style="width: 200px;">Marca</label>
                    <label class="sut_titulos" style="width: 160px;">Modelo</label>
                    
                    {{-- <label class="sut_titulos" style="width: 130px;">Foto</label> --}}

                    <br>
                    <label class="respuesta" style="width: 300px;"><b>{{$datosgarantia->Nombre_articulo}}</b></label>
                    <label class="respuesta" style="width: 200px;"><b>{{$datosgarantia->marca}}</b></label>
                    <label class="respuesta" style="width: 160px;"> <b>{{$datosgarantia->modelo}}</b></label>
                    
                    {{-- <label class="respuesta" style="width: 130px;"> <b>{{$datosgarantia->foto}}</b></label> --}}
                    <br>
                    <label class="sut_titulos" style="width: 680px;">Descripción</label>
                    <br>
                    <label class="respuesta" style="width: 680px;"> <b>{{$datosgarantia->descripcion}}</b></label>
                    <br>
                    <img class="respuesta" style="margin-top:40px" src="https://laferiecita.com/{{$datosgarantia->foto}}" style="border:1px solid #000" alt="" width="500" height="400" >  
                    <hr style="margin: 0; padding: 0">

                    @endforeach
            
            @endif
        </div>
        <br>



        {{-- <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos familiares
        </div>
        <div style="margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($familiar[0]->id_socio_economico))
                <center>No hay datos</center> 
            @else
            <label class="sut_titulos" style="width: 200px;">Número de Personas</label>
            <label class="sut_titulos" style="width: 200px;">Número de personas que trabajan</label>
            <label class="sut_titulos" style="width: 200px;">Cuantos aportan dinero mensual</label>
            <br>
            <label class="respuesta" style="width: 200px; "><b>{{$familiar[0]->numero_personas}}</b></label>
            <label class="respuesta" style="width: 200px;"><b>{{$familiar[0]->numero_personas_trabajando}}</b></label>
            <label class="respuesta" style="width: 200px;"><b>{{$familiar[0]->aportan_dinero_mensual}}</b></label>
            <br>
            @endif
        </div>

        <br>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos del Aval
        </div>
        <div style="margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($aval[0]->id_aval))
                <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 200px;">CURP</label>
            <label class="sut_titulos" style="width: 150px;">Nombre</label>
            <label class="sut_titulos" style="width: 150px;">Ap. Paterno</label>
            <label class="sut_titulos" style="width: 150px;">Ap. Materno</label>
            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$aval[0]->curp}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$aval[0]->nombre}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$aval[0]->ap_paterno}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$aval[0]->ap_materno}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 120px;">Fecha de nacimiento</label>
            <label class="sut_titulos" style="width: 290px;">Ocupación</label>
            <label class="sut_titulos" style="width: 120px;">Género</label>
            <label class="sut_titulos" style="width: 120px;">Estado civil</label>
            <br>
            @php
                $datenacimiento = date_create($aval[0]->fecha_nacimiento);
            @endphp
            <label class="respuesta" style="width: 120px;"><b>{{date_format($datenacimiento, 'd-m-Y')}}</b></label>
            <label class="respuesta" style="width: 290px;"><b>{{$aval[0]->ocupacion}}</b></label>
            <label class="respuesta" style="width: 120px;"><b>{{$aval[0]->genero}}</b></label>
            <label class="respuesta" style="width: 120px;"><b>{{$aval[0]->estado_civil}}</b></label>
            
            <br>
            
            <label class="sut_titulos" style="width: 190px;">Calle</label>
            <label class="sut_titulos" style="width: 110px;">No. Exterior</label>
            <label class="sut_titulos" style="width: 110px;">No. Interior</label>
            <label class="sut_titulos" style="width: 250px;">Entre calles</label>
            <br>
            <label class="respuesta" style="width: 190px;"><b>{{$aval[0]->calle}}</b></label>
            <label class="respuesta" style="width: 110px;"><b>{{$aval[0]->numero_ext}}</b></label>
            <label class="respuesta" style="width: 110px;"><b>{{$aval[0]->numero_int}}</b></label>
            <label class="respuesta" style="width: 250px;"><b>{{$aval[0]->entre_calles}}</b></label>
            <br>

            <label class="sut_titulos" style="width: 210px;">Colonia</label>
            <label class="sut_titulos" style="width: 210px;">Municipio</label>
            <label class="sut_titulos" style="width: 210px;">Estado</label>
            <br>
            <label class="respuesta" style="width: 220px;"><b>{{$aval[0]->colonia}}</b></label>
            <label class="respuesta" style="width: 220px;"><b>{{$aval[0]->municipio}}</b></label>
            <label class="respuesta" style="width: 220px;"><b>{{$aval[0]->estado}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 250px;">Referencia visual</label>
            <label class="sut_titulos" style="width: 205px;">Vivienda</label>
            <label class="sut_titulos" style="width: 205px;">Tiempo viviendo en el domicilio</label>
            <br>
            <label class="respuesta" style="width: 250px;"><b>{{$aval[0]->referencia_visual}}</b></label>
            <label class="respuesta" style="width: 205px;"><b>{{$aval[0]->vivienda}}</b></label>
            <label class="respuesta" style="width: 205px;"><b>{{$aval[0]->tiempo_viviendo_domicilio}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 160px;">Teléfono casa</label>
            <label class="sut_titulos" style="width: 160px;">Teléfono móvil</label>
            <label class="sut_titulos" style="width: 160px;">Teléfono trabajo</label>
            <label class="sut_titulos" style="width: 160px;">Fecha de registro</label>
            <br>
            <label class="respuesta" style="width: 160px;"><b>{{$aval[0]->telefono_casa}}</b></label>
            <label class="respuesta" style="width: 160px;"><b>{{$aval[0]->telefono_movil}}</b></label>
            <label class="respuesta" style="width: 160px;"><b>{{$aval[0]->telefono_trabajo}}</b></label>
            @php
                $dateregistro = date_create($aval[0]->fecha_registro);
            @endphp
            <label class="respuesta" style="width: 160px;"><b>{{date_format($dateregistro, 'd-m-Y H:i:s')}}</b></label>
            @endif
        </div>

        <br>
        

        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Pareja
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($pareja[0]->id_socio_economico))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 200px;">Nombre</label>
            <label class="sut_titulos" style="width: 150px;">Apellido Paterno</label>
            <label class="sut_titulos" style="width: 150px;">Apellido Materno</label>
            <label class="sut_titulos" style="width: 150px;">Teléfono</label>
            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$pareja[0]->nombre}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$pareja[0]->ap_paterno}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$pareja[0]->ap_materno}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$pareja[0]->telefono}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 80px;">Edad</label>
            <label class="sut_titulos" style="width: 250px;">Ocupación</label>
            <br>
            <label class="respuesta" style="width: 80px;"><b>{{$pareja[0]->edad}}</b></label>
            <label class="respuesta" style="width: 250px;"><b>{{$pareja[0]->ocupacion}}</b></label>

            <br>
            @endif
        </div>
        <br>
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos del Domicilio
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($domicilio[0]->id_socio_economico))
                No hay datos
            @else
            <label class="sut_titulos" style="width: 200px;">Calle</label>
            <label class="sut_titulos" style="width: 150px;">Numero Exterior</label>
            <label class="sut_titulos" style="width: 150px;">Numero Interior</label>
            <label class="sut_titulos" style="width: 150px;">Entre Calles</label>
            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$domicilio[0]->calle}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->numero_ext}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->numero_int}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->entre_calles}}"</b></label>

            <br>

            <label class="sut_titulos" style="width: 150px;">Colonia Localidad</label>
            <label class="sut_titulos" style="width: 150px;">Municipio</label>
            <label class="sut_titulos" style="width: 150px;">Estado</label>
            <label class="sut_titulos" style="width: 150px;">Referencia Visual</label>


            <br>
            <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->colonia_localidad}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->municipio}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->estado}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$domicilio[0]->referencia_visual}}</b></label>

            <br>
            @endif
        </div>

        <div class="page-break"></div>

        
        
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Fecha de monto
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($fechamonto[0]->id_socio_economico))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 150px;">Monto de credito</label>
            <label class="sut_titulos" style="width: 140px;">Fecha Credito</label>

            <br>
            <label class="respuesta" style="width: 150px;"><b>{{$fechamonto[0]->monto_credito }}</b></label>
            <label class="respuesta" style="width: 140px;"><b>{{ $fechamonto[0]->fecha_credito}}</b></label>

            @endif
        </div>
        
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Referencia laboral
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($referencialbpersonas[0]->id_rl_persona))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 200px;">Nombre empresa</label>
            <label class="sut_titulos" style="width: 200px;">Actividad empresa</label>
            <label class="sut_titulos" style="width: 200px;">Cargo empresa</label>
            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$referencialbpersonas[0]->nombre_empresa}}</b></label>
            <label class="respuesta" style="width: 200px;"><b>{{$referencialbpersonas[0]->actividad_empresa}}</b></label>
            <label class="respuesta" style="width: 200px;"> <b>{{$referencialbpersonas[0]->cargo_empresa}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 250px;">Dirección</label>
            <label class="sut_titulos" style="width: 90px;">Numero exterior</label>
            <label class="sut_titulos" style="width: 90px;">Numero interior</label>
            <label class="sut_titulos" style="width: 200px;">Entre calles</label>
            <br>
            <label class="respuesta" style="width: 250px;"><b>{{$referencialbpersonas[0]->direccion}}</b></label>
            <label class="respuesta" style="width: 90px;"> <b>{{$referencialbpersonas[0]->numero_ext}}</b></label>
            <label class="respuesta" style="width: 90px;"> <b>{{$referencialbpersonas[0]->numero_int}}</b></label>
            <label class="respuesta" style="width: 200px;"> <b>{{$referencialbpersonas[0]->entre_calles}}</b></label>

            <br>

            <label class="sut_titulos" style="width: 120px;">Teléfono empresa</label>
            <label class="sut_titulos" style="width: 120px;">Tiempo empresa</label>
            <label class="sut_titulos" style="width: 200px;">Jefe inmediato</label>
            <br>
            <label class="respuesta" style="width: 120px;"> <b>{{$referencialbpersonas[0]->telefono_empresa}}</b></label>
            <label class="respuesta" style="width: 120px;"> <b>{{$referencialbpersonas[0]->tiempo_empresa}}</b></label>
            <label class="respuesta" style="width: 200px;"> <b>{{$referencialbpersonas[0]->jefe_inmediato}}</b></label>

            @endif
        </div>
        <div class="page-break"></div>
        
        <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos de Referencia personal
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($referenciappersonas[0]->id_rp_persona))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 200px;">Nombre</label>
            <label class="sut_titulos" style="width: 230px;">Domicilio</label>
            <label class="sut_titulos" style="width: 100px;">Teléfono</label>
            <label class="sut_titulos" style="width: 130px;">Relación</label>

            <br>
            <label class="respuesta" style="width: 200px;"><b>{{$referenciappersonas[0]->nombre}}</b></label>
            <label class="respuesta" style="width: 230px;"><b>{{$referenciappersonas[0]->domicilio}}</b></label>
            <label class="respuesta" style="width: 100px;"> <b>{{$referenciappersonas[0]->telefono}}</b></label>
            <label class="respuesta" style="width: 130px;"> <b>{{$referenciappersonas[0]->relacion}}</b></label>

            @endif
        </div>
        <br> --}}
        {{-- <div style="margin: 0px; padding-top: 1px; padding-bottom: 1px; padding-left: 7px; padding-right: 7px; border-radius: 15px 15px 0 0; width: auto; background: rgba(17, 0, 112, 0.712); color: #fff">
            Datos generales
        </div>
        <div style="text-align: center; margin: 0px; padding: 10px; border-radius: 0 0 15px 15px; background: rgba(43, 0, 143, 0.089);">
            @if (empty($datos_generales[0]->id_socio_economico))
            <center>No hay datos</center>
            @else
            <label class="sut_titulos" style="width: 210px;">Curp</label>
            <label class="sut_titulos" style="width: 150px;">Nombre</label>
            <label class="sut_titulos" style="width: 130px;">Apellido paterno</label>
            <label class="sut_titulos" style="width: 130px;">Apellido materno</label>

            <br>
            <label class="respuesta" style="width: 210px;"><b>{{$datos_generales[0]->curp}}</b></label>
            <label class="respuesta" style="width: 150px;"><b>{{$datos_generales[0]->nombre}}</b></label>
            <label class="respuesta" style="width: 130px;"> <b>{{$datos_generales[0]->ap_paterno}}</b></label>
            <label class="respuesta" style="width: 130px;"> <b>{{$datos_generales[0]->ap_materno}}</b></label>

            <br>
            <label class="sut_titulos" style="width: 120px;">Fecha de nacimiento</label>
            <label class="sut_titulos" style="width: 80px;">Edad</label>
            <label class="sut_titulos" style="width: 230px;">Ocupación</label>
            <label class="sut_titulos" style="width: 110px;">Género</label>
            <label class="sut_titulos" style="width: 110px;">Estado civil</label>


            <br>
            <label class="respuesta" style="width: 120px;"><b>{{$datos_generales[0]->fecha_nacimiento}}</b></label>
            <label class="respuesta" style="width: 80px;"><b>{{$datos_generales[0]->edad}}</b></label>
            <label class="respuesta" style="width: 230px;"> <b>{{$datos_generales[0]->ocupacion}}</b></label>
            <label class="respuesta" style="width: 110px;"> <b>{{$datos_generales[0]->genero}}</b></label>
            <label class="respuesta" style="width: 110px;"> <b>{{$datos_generales[0]->estado_civil}}</b></label>


            @endif
        </div> --}}
        <br><br>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(490, 790, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>
</body>
</html>