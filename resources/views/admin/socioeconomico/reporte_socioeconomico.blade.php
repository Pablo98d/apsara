<!DOCTYPE html>
<html lang="es">
<head>
 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Socioeconómico {{$id_socio}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Otomanopee+One&display=swap" rel="stylesheet">
    <style>
        hr{
            page-break-after: always;
            border: none;
            margin: 0;
            padding: 0;
        }

        @font-face {
            font-family: 'ProximaSoft-Bold';
            src: url({{ storage_path('fonts\ProximaSoft-Bold.ttf') }}) format("truetype");

            
        }
        @font-face {
            font-family: 'ProximaSoft-Regular';
            src: url({{ storage_path('fonts\ProximaSoft-Regular.ttf') }}) format("truetype");
            
        }

        @font-face {
            font-family: 'ProximaSoft-Medium';
            src: url({{ storage_path('fonts\ProximaSoft-Medium.ttf') }}) format("truetype");
            
        }



    </style>
    <style>
        @page {
            margin: 0cm 0cm;
            
            background-color: #ffde59;
            
            
        }
        
        body {
            /* margin: 3cm 2cm 2cm; */
            background-color: #ffde59;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #ffde59;
            color: white;
            text-align: center;
            line-height: 30px;
        }

        .footer {
            position: fixed;
            bottom: 11px;
            left: 0cm;
            right: 1cm;
            height: 1cm;
            /* background-color: #ffde59; */
            color: black;
            text-align: right;
            font-size: 11px;
            
        }
    </style>
</head>
<body>

@php
    $hoy = new DateTime();
@endphp

<main style="padding: 11px; ">
    <center>
        <span style="font-size: 9px;letter-spacing:5px; font-family: ProximaSoft-Regular">CONTRATO DE APERTURA CRÉDITO SIMPLE</span>
    </center>
    <span style="font-family: ProximaSoft-Bold; position: absolute; right: 15px; top:5px; font-size: 20px;">S.E. # {{$id_socio}}</span>
    <div style="width: 700px; display: flex;">
    
        <div style="width: 130px;  ">
            @if (empty($docs_perfil[0]->path_url))
            <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" width="155" height="200" alt="" style=" border-radius: 2px;">
            @else
                @php
                    $ub=str_split($docs_perfil[0]->path_url);
                    $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                @endphp
                @if ($ubicacion=='DocImagenes')
                    <img src="{{$docs_perfil[0]->path_url}}" width="155" height="200" alt="" style=" border-radius: 2px;">
                @else

                    @php
                        $r_perfil = @getimagesize('https://laferiecita.com/ws/documentos/'.$docs_perfil[0]->path_url);
                    
                    @endphp
                    @if ($r_perfil)
                    <img src="https://laferiecita.com/ws/documentos/{{$docs_perfil[0]->path_url}}" width="155" height="200" alt="" style=" border-radius: 2px;">
                    @else 
                        <div style="margin-left: 1px; width: 155px; height: 200px;border:1px solid #000">
                            <br><br>
                            <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                        </div>
                    @endif

                    
                @endif
            @endif
        </div>
            <div style="width: 100%; margin-left:162px" >
            <p style="text-transform: uppercase; font-size: 20px;margin-top: 5px;margin-bottom: 7px; font-family: ProximaSoft-Bold;">
                @if (!empty($datos_generales[0]->nombre))
                    @php
                        $nombre_user=$datos_generales[0]->nombre.' '.$datos_generales[0]->ap_paterno.' '.$datos_generales[0]->ap_materno;
                    @endphp
                    {{$nombre_user}}
                @else
                    Sin nombre
                @endif
                
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold;color: #5e595f; padding: 0; margin: 0;">CURP:</span> 
                @if (!empty($datos_generales[0]->curp))
                    {{$datos_generales[0]->curp}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold;color: #5e595f; padding: 0; margin: 0;">CELULAR:</span> 
                @if (!empty($vivienda[0]->telefono_celular))
                    {{$vivienda[0]->telefono_celular}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">FECHA DE NACIMIENTO:</span> 
                @if (!empty($datos_generales[0]->fecha_nacimiento))
                    {{$datos_generales[0]->fecha_nacimiento}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">OCUPACIÓN:</span> 
                @if (!empty($datos_generales[0]->ocupacion))
                    {{$datos_generales[0]->ocupacion}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">GENERO:</span> 
                @if (!empty($datos_generales[0]->genero))
                    {{$datos_generales[0]->genero}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">ESTADO CIVIL:</span> 
                @if (!empty($datos_generales[0]->estado_civil))
                    {{$datos_generales[0]->estado_civil}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">ENFERMEDAD CRÓNICA:</span> 
                PENDIENTE
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">GRUPO:</span> 
                @if (!empty($prestamo))
                        {{$prestamo->grupo}}
                @else
                    
                @endif
            </p>

            <center>
                <p style="letter-spacing:3px;text-transform: uppercase; font-size: 13px; margin-top: 3px; font-family:ProximaSoft-Bold ">                    
                    @if (!empty($prestamo))
                        {{$prestamo->producto}}
                        {{number_format($prestamo->cantidad,2)}} MX 
                        {{$prestamo->estatus_prestamo}}
                    @else
                        0.00 MX
                    @endif
                     
                </p>
            </center>
            
        </div>
        
        <div style="width: 265px; background: #fff;top: 207px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f;letter-spacing:4px;">
            <center>
                <span style="font-family: ProximaSoft-Bold">
                    FOTO DE LA VIVIENDA
                </span>
            </center>
        </div>
        <div style="width: 485px; background: #fff; left: 218; top: 230px;position: absolute; font-size: 14px;padding: 3px;  color: #5e595f;letter-spacing:4px; ">
            <span style="font-family: ProximaSoft-Bold">
                DOMICILIO
            </span>
        </div>
        <div style="width: 265px; height: 361px; background: #fff;top: 235px;position: absolute; font-size: 14px;padding: 3px;  color: #5e595f;letter-spacing:4px;">
            <center>
                <br>
                @if (empty($docs_referencia[0]->path_url))
                <img src="{{asset('img/icons-rojos/no imagen.jpg')}}"  alt="" width="98%" height="330" >  
                @else
                    @php
                        $ub=str_split($docs_referencia[0]->path_url);
                        $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                    @endphp
                    @if ($ubicacion=='DocImagenes')
                        <img src="{{$docs_referencia[0]->path_url}}" style="-webkit-transform: rotate(90deg);margin-top: 35px;" alt="" width="350px" height="70%" >  
                        {{-- <img src="{{$docs_referencia[0]->path_url}}" style="-webkit-transform: rotate(90deg);margin-top: 35px;" alt="" width="350px" height="70%" >   --}}
                    @else

                        @php
                            $r_domicilio = @getimagesize('https://laferiecita.com/ws/documentos/'.$docs_referencia[0]->path_url);
                        // dd($r_domicilio);
                        @endphp
                        @if ($r_domicilio)
                            <img src="https://laferiecita.com/ws/documentos/{{$docs_referencia[0]->path_url}}" style="margin-top: -10px" alt="" width="95%" height="350px" >  
                        @else 
                            <div style="margin-left: 1px; width: 98.7%; height: 330px;border:1px solid #000">
                                <br><br>
                                <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                            </div>
                        @endif
                            @php
                                // dd($r_domicilio,$docs_referencia[0]->path_url);
                            @endphp
                    @endif
                @endif
            </center>
        </div>
        {{-- <img src="https://laferiecita.com/ws/documentos/{{$docs_referencia[0]->path_url}}" alt="" style="z-index: 100"> --}}
        <div style="width: 485px; height: 210px; background: #fff; left: 218; top: 258px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">
            
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 3px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">CALLE:</span> 
                    @if (!empty($domicilio[0]->calle))
                        {{$domicilio[0]->calle}}
                    @endif
                </p>
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">NÚMERO EXTERIOR:</span> 
                    @if (!empty($domicilio[0]->numero_ext))
                        {{$domicilio[0]->numero_ext}}
                    @endif
                </p>
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">COLONIA:</span> 
                    @if (!empty($domicilio[0]->colonia_localidad))
                        {{$domicilio[0]->colonia_localidad}}
                    @endif
                </p>
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">MUNICIPIO:</span> 
                    @if (!empty($domicilio[0]->municipio))
                        {{$domicilio[0]->municipio}}
                    @endif
                </p>
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">ESTADO:</span> 
                    @if (!empty($domicilio[0]->estado))
                        {{$domicilio[0]->estado}}
                    @endif
                </p>
                
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">COORDENADAS:</span></p>
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">LONGITUD:</span>
                    @if (!empty($datos_usuario[0]->longitud))
                        {{$datos_usuario[0]->longitud}}
                    @endif
                </p>
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family:ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">LATITUD:</span>
                    @if (!empty($datos_usuario[0]->latitud))
                        {{$datos_usuario[0]->latitud}}
                    @endif
                </p>
                
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 5px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">TIPO DE VIVIENDA:</span> 
                    @if (!empty($vivienda[0]->tipo_vivienda))
                        {{$vivienda[0]->tipo_vivienda}}
                    @endif
                </p>
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">TIEMPO VIVIENDO EN VIVIENDA:</span> 
                    @if (!empty($vivienda[0]->tiempo_viviendo_domicilio))
                        {{$vivienda[0]->tiempo_viviendo_domicilio}}
                    @endif
                </p>
                <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">REFERENCIAS VISUALES:</span> 
                    @if (!empty($domicilio[0]->referencia_visual))
                        {{$domicilio[0]->referencia_visual}} 
                    @endif
                </p>
        </div>
        <div style="width: 485px; background: #fff; left: 218; top: 478px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f;letter-spacing:4px; font-family: ProximaSoft-Bold">
            
            REFERENCIAS
        </div>
        <div style="text-transform: uppercase;width: 485px; background: #fff; left: 218; top: 505px;position: absolute; font-size: 9px;padding: 3px; color: #5e595f; font-family: ProximaSoft-Bold">
            
            <span style="letter-spacing:2px; font-family: ProximaSoft-Bold">REFERENCIAS PERSONALES</span><br>
            <p style=" font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 8px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold">Nombre:</span> 
                @if (!empty($referenciappersonas[0]->nombre))
                    {{$referenciappersonas[0]->nombre}}
                @endif
            </p>
            <p style=" font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold">Parentesco:</span> 
                @if (!empty($referenciappersonas[0]->relacion))
                    {{$referenciappersonas[0]->relacion}}
                @endif
            </p>
            <p style=" font-size: 12px; font-family: ProximaSoft-Medium; margin-top: 3px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold">Teléfono:</span> 
                @if (!empty($referenciappersonas[0]->telefono))
                    {{$referenciappersonas[0]->telefono}}
                @endif
            </p>
            <span style="letter-spacing:2px; font-family: ProximaSoft-Bold">REFERENCIAS LABORALES</span><br>
            <p style=" font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 8px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold">Nombre de la empresa:</span> 
                @if (!empty($referencialbpersonas[0]->nombre_empresa))
                    {{$referencialbpersonas[0]->nombre_empresa}}
                @endif
            </p>
            {{-- <p style=" font-size: 12px; font-family: Arial, Helvetica, sans-serif; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><strong>Nombre:</strong></p> --}}
            <p style=" font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold">Domicilio:</span> 
                @if (!empty($referencialbpersonas[0]->direccion))
                    {{$referencialbpersonas[0]->direccion}} {{$referencialbpersonas[0]->numero_ext}} {{$referencialbpersonas[0]->numero_int}} {{$referencialbpersonas[0]->entre_calles}}
                @endif
            </p>
            <p style=" font-size: 12px; font-family: ProximaSoft-Medium; margin-top: 3px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold">Teléfono:</span> 
                @if (!empty($referencialbpersonas[0]->telefono_empresa))
                    {{$referencialbpersonas[0]->telefono_empresa}}
                @endif
            </p>
        </div>
        
        <div style="letter-spacing:2px;width: 265px; background: #fff;top: 607px;position: absolute; font-size: 13px;padding-right: 3px;padding-left: 3px;padding-bottom: 4px;padding-top: 4px;  color: #5e595f; font-family: ProximaSoft-Bold">
            <center>
                COMPROBANTE DE DOMICILIO
            </center>
        </div>
        <div style="width: 265px; height: 400px; background: #fff;top: 636px;position: absolute; padding: 3px;">
            <center>
                {{-- comprobante de domicilio --}}
                <br>
                @if (empty($docs_comprobante[0]->path_url))
                    <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" alt="" width="90%" height="370">  
                @else
                    @php
                        $ub=str_split($docs_comprobante[0]->path_url);
                        $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                    @endphp
                    @if ($ubicacion=='DocImagenes')
                        <img src="{{$docs_comprobante[0]->path_url}}"  width="90%" height="375">  
                    @else
                        @php
                            $r_comprobante = @getimagesize('https://laferiecita.com/ws/documentos/'.$docs_comprobante[0]->path_url);
                            
                        @endphp
                        @if ($r_comprobante)
                            <img class="" src="https://laferiecita.com/ws/documentos/{{$docs_comprobante[0]->path_url}}" style="margin-top: -13px" width="95%" height="390px" >
                            {{-- <img class="" src="https://laferiecita.com/ws/documentos/{{$docs_comprobante[0]->path_url}}" style="margin-top: 55px; -webkit-transform: rotate(90deg);" alt="" width="385" height="63%" > --}}
                        @else 
                            <div style="margin-left: 12px; width: 90%; height: 370px;border:1px solid #000">
                                <br><br>
                                <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                            </div>
                        @endif

                        {{-- <img class="" src="https://laferiecita.com/ws/documentos/{{$docs_comprobantea[0]->path_url}}" style="border:1px solid #000;" alt="" width="90%" height="370" >   --}}
                    @endif
                @endif
            </center>
        </div>

        <div style="width: 485px; background: #fff; left: 218; top: 682px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f;letter-spacing:4px; font-family: ProximaSoft-Bold">
            
            IDENTIFICACIÓN DEL PROSPECTO 
        </div>

        <div style="width: 490px; background: #fff; left: 218; top: 710px;position: absolute; color: #5e595f;letter-spacing:4px;">
            {{-- Identificacion del prospecto --}}
            <span style="margin-left: 5px;letter-spacing:2px; font-family: ProximaSoft-Medium; font-size: 9px">IDENTIFICACIÓN FRONTAL</span><br>
                <div >

                    @if (empty($docs_ine_1[0]->path_url))
                        <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" style="margin-left: 5px;border:1px solid #000" alt="" width="240px" height="145">  
                    @else
                        @php
                            $ub=str_split($docs_ine_1[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_ine_1[0]->path_url}}" style="margin-left: 5px;border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="240px" height="145">  
                        @else
                            @php
                                $resultine1 = @getimagesize('https://laferiecita.com/ws/documentos/'.$docs_ine_1[0]->path_url);
                                
                            @endphp
                            @if ($resultine1)
                                <img  src="https://laferiecita.com/ws/documentos/{{$docs_ine_1[0]->path_url}}" style="margin-left: 5px;border:1px solid #000" alt="Identificiación INE reverso" width="240px" height="145">  
                            @else 
                                <div style="margin-left: 5px;width: 240px; height: 145px;border:1px solid #000">
                                    <br><br>
                                    <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                                </div>
                            @endif

                            {{-- <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$docs_ine_1[0]->path_url}}" style="margin-left: 5px;"  alt="Identificiación INE frontal" width="240px" height="145">   --}}
    
                        @endif
                    @endif

                    
                </div>
                <span style="margin-left: 242px;letter-spacing:2px; font-family: ProximaSoft-Medium; font-size: 9px">IDENTIFICACIÓN REVERSO</span><br>
                <div style="margin-left: 242px; margin-bottom: 3px">

                    @if (empty($docs_ine_2[0]->path_url))
                        <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" style="border:1px solid #000" alt="" width="240px" height="145">  
                    @else
                        @php
                            $ub=str_split($docs_ine_2[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_ine_2[0]->path_url}}" style="border:1px solid #000" alt="Este es el ejemplo de un texto alternativo" width="240px" height="145">  
                        @else
                            @php
                                $result = @getimagesize('https://laferiecita.com/ws/documentos/'.$docs_ine_2[0]->path_url);
                                
                            @endphp
                            @if ($result)
                                <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$docs_ine_2[0]->path_url}}" style="border:1px solid #000" alt="Identificiación INE reverso" width="240px" height="145">  
                            @else 
                                <div style="width: 240px; height: 145px;border:1px solid #000">
                                    <br><br>
                                    <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                                </div>
                            @endif
                            {{-- <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$docs_ine_2[0]->path_url}}" style="border:1px solid #000" alt="Identificiación INE reverso" width="240px" height="145">   --}}
                        @endif
                    @endif

                    
                </div>
                <br>
        </div>

    </div>
    
    <div class="footer">
        
        <span style="font-size: 12px; margin-right: 385px; font-family: ProximaSoft-Bold">S.E. # {{$id_socio}} generado el: {{$hoy->format('d-m-Y')}}</span>  
        <span style="font-size: 23px;font-family: ProximaSoft-Bold" >laferiecita.com</span>
    </div>
</main>



<hr>

<main style=" background: #fff; -webkit-transform: rotate(-180deg);margin: 0; " >
    <div  style="margin-top: 45px; position: static; background: #fff;  padding: 55px; padding-bottom: 5px;font-size: 12px; text-align: justify; ">
        <p style="font-family: ProximaSoft-Medium">CONTRATO DE APERTURA DE CRÉDITO SIMPLE QUE CELEBRAN LA FINANCIERA PRESTAMOS LA FERIECITA, A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ “LA FERIECITA” Y POR LA OTRA PARTE, LA PERSONA CUYOS DATOS Y FIRMA SE ENCUENTRAN EN EL SOCIOECONÓMICO Y CARÁTULA DEL PRESENTE CONTRATO, SE LE DENOMINARÁ “LA CLIENTA”, DE CONFORMIDAD CON LAS DECLARACIONES Y CLÁUSULAS SIGUIENTES:  </p>
        
        <center>
            <p style="letter-spacing: 4px;font-family: ProximaSoft-Medium">DECLARACIONES</p>
        </center>
        <table>
            <tbody>
                <td style="text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium; width: 48%;">
                    <span style="font-family: ProximaSoft-Bold">I. Declara la financiera que:</span>
                    <br><span style="font-family: ProximaSoft-Bold">b)</span> Cuenta con las facultades suficientes y necesarias para obligarse en los términos del presente contrato, mismas que no le han sido revocadas o modificadas en forma alguna.
                    <br><span style="font-family: ProximaSoft-Bold">II. Declara la clienta que:</span>
                    <br><span style="font-family: ProximaSoft-Bold">a)</span> Es una persona física facultada para celebrar el presente contrato.
                    <br><span style="font-family: ProximaSoft-Bold">b)</span> Declara la clienta que los datos proporcionados son verídicos, para recibir toda clase de notificaciones, requerimientos de pagos y avisos correspondientes.
                    <br><span style="font-family: ProximaSoft-Bold">c)</span> Declara que ha solicitado a La Feriecita un préstamo por el monto establecido, en moneda nacional mexicana, términos y condiciones contenidos en el presente contrato.
                    
                    
                </td>
                <td style="padding-left: 25px; text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium">
                    <span style="font-family: ProximaSoft-Bold">d)</span> La clienta, realizo una previa revisión y análisis de la información y documentación que es proporcionada y presentada por La Feriecita por medio de un trabajador de la empresa.
                    <br><span style="font-family: ProximaSoft-Bold">III. Declara aval de la cliente que:</span>
                    <br><span style="font-family: ProximaSoft-Bold">a)</span> Reconoce las responsabilidades que conlleva firmar el siguiente documento, así como asumir la responsabilidad de la falta de pagos que pueda llegar a tener el cliente. Acata las políticas contenidas en el presente contrato, así como cualquier cambio que decida realizar la dirección general y administración. 
                    <br><br><br><br>
                </td>
            </tbody>
        </table>
        <center>
            <p style="letter-spacing: 4px; margin-top: 25px;font-family: ProximaSoft-Medium">CLÁUSULAS</p>
        </center>
        <table>
            <tbody>
                <td style="text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium; width: 48%;">
                    <span style="font-family: ProximaSoft-Bold">PRIMERA.</span> Las siguientes cláusulas se aplicarán al cumplimiento en tiempo y forma del pago, así como las condiciones del préstamo que otorga La Feriecita, en beneficio de la cliente. <span style="font-family: ProximaSoft-Bold">SEGUNDA.</span> Monto a entregar . La Feriecita, otorga y hace entrega a la clienta, un préstamo, crédito, por la cantidad que fue aprobada, se muestra en el estudio socioeconómico, mismo que la clienta reconoce recibir teniendo en cuenta la retención de ahorro semana 14 y el 5% del total del préstamo que corresponden a los gastos administrativos (trámite). 
                    <span style="font-family: ProximaSoft-Bold">TERCERA.</span> ENTREGA DEL PRÉSTAMO, la clienta dispondrá del total del crédito en una sola disposición, después de verificar nuevamente la información y desglose del crédito, así como la firma de la solicitante (clienta). <span style="font-family: ProximaSoft-Bold">CUARTA.</span> INTERESES Y GASTOS POR CRÉDITO. La clienta pagará un porcentaje de intereses correspondientes al  cual para su cálculo se computarán de manera semanal, siendo esto el día y hora acordada, así mismo el cliente pagará con concepto de gastos por cada crédito otorgado la cantidad de $50.00 pesos por cada $1000 pesos de crédito. 
                    En caso de que el monto solicitado sea mayor o menor, el cálculo será proporcional bajo dicho razonamiento. <span style="font-family: ProximaSoft-Bold">QUINTA:</span> PAGOS ANTICIPADOS Y PAGOS ADELANTADOS. La clienta podrá́ efectuar pagos mayores a los comprometidos y/o pagos anticipados, cuyos montos se imputarán en la forma que La Feriecita determine, en cuyo caso este ultimo se comunicará a la cliente el nuevo cronograma de pagos. “La Feriecita” está obligada a recibir pagos anticipados siempre que la clienta se encuentre al corriente en los pagos exigibles de conformidad con el presente Contrato. 
                    <span style="font-family: ProximaSoft-Bold">SEXTA.</span> FECHAS, MONTO DE PAGO, MULTAS GARANTÍAS Y SEMANA DE PENALIZACIÓN. La cliente está obligada a realizar los abonos del crédito entregado, el día y hora acordada inmediatamente a la siguiente fecha en que se entregó el crédito. <span style="font-family: ProximaSoft-Bold">SÉPTIMA.</span> FORMA Y LUGAR DEL 
                <br><br>
                </td>
                <td style="padding-left: 25px; padding-bottom: 15px; text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium"> 
                    PAGO es responsabilidad de la cliente, acudir al domicilio donde se entregó el recurso del presente contrato y así mismo realizar el pago del monto acordado <span style="font-family: ProximaSoft-Bold">OCTAVA. DUDAS O ACLARACIONES</span>, en caso de que el cliente tenga alguna duda, consulta, sugerencia, aclaración, necesite información o solicitar un nuevo crédito, deberá comunicarse vía telefónica al número siguiente (33) 38-03-24-32. 
                    <span style="font-family: ProximaSoft-Bold">NOVENA</span> El siguiente contrato entrará en vigor a partir de su fecha de entrega y firma, el cual tendrá una duración de 13 semanas con pagos si se realizan en tiempo y forma, si no realiza sus pagos se extiende el plazo, por el aumento de su saldo gracias a las multas. <span style="font-family: ProximaSoft-Bold">PAGO CONVENCIONAL</span> la clienta pagará la cantidad como pago semanal, en la primera ocasión que no se cubra un pago, se multa con la semana 15. <span style="font-family: ProximaSoft-Bold">MULTA</span> si la clienta realiza su pago en una fecha distinta, a la fecha antes mencionada, se multará con $50 pesos. <span style="font-family: ProximaSoft-Bold">GARANTÍAS</span> a partir de cuatro retrasos se retienen las garantías. 
                    <span style="font-family: ProximaSoft-Bold">NOTIFICACIÓN DE EMBARGO.</span> Si el cliente cuenta con pagos parciales o multas después de haber terminado el plazo de pagos, se pasa la cuenta a jurídico enviando la primera notificación de embargo, si el cliente no realiza sus pagos de después de la primera notificación, se le estará enviando la segunda notificación, dándole al cliente una segunda oportunidad para realizar los pagos o liquidar la cuenta de lo contrario se procederá legalmente. <span style="font-family: ProximaSoft-Bold">POLÍTICAS DE CRÉDITOS</span> en la entrega del crédito, el cliente estará recibiendo un control de recibos en el cual se tendrá que recabar la firma ante quien efectúe su pago. 
                    En caso de ser puntual en el pago de sus 13 semanas el cliente, podrá solicitar un nuevo crédito con aumento de $500 pesos. Podrá renovar sin aumento su nuevo crédito si solo tiene una falla y contar con 13 semanas pagadas. Podrá renovar con una disminución en su crédito si cuenta con dos fallas en sus pagos o parciales. (la disminución será de $500.00 a su nuevo crédito).
                    
                </td>
            </tbody>
            <br>
        </table>
    
    </div>
    <div class="footer" style="bottom: -14px;">
        
        <span style="font-family: ProximaSoft-Bold;font-size: 13px; margin-right: 365px">S.E. # {{$id_socio}} generado el: {{$hoy->format('d-m-Y')}}</span> 
        <span style="font-family: ProximaSoft-Bold;font-size: 23px;">laferiecita.com</span>
    </div>
</main>

<hr>
<main style="padding: 11px;  ">
    <center>
        <span style="font-size: 9px;letter-spacing:5px; font-family: ProximaSoft-Medium">CONTRATO DE APERTURA CRÉDITO SIMPLE</span>
    </center>
    <div style="width: 700px; display: flex;">
        <div style="letter-spacing:4px; width: 265px; background: #fff;top: 20px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f;letter-spacing:4px; font-family: ProximaSoft-Bold">
            
                GARANTÍAS
        </div>
        <div style="width: 485px; background: #fff; left: 218; top: 42px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f;letter-spacing:4px; font-family: ProximaSoft-Bold">
            
                FINANZAS DEL PROSPECTO
        </div>
        <div style="width: 265px; height: 441px; background: #fff;top: 48px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f; font-family: ProximaSoft-Medium">
            @if (count($datosgarantias)==0)
                <div class="" style="width: 190px; height: 75;  background: rgb(151, 151, 151); margin-left: 33px;padding: 5px; margin-top: 10px">
                    <center>
                        {{-- <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" style="border:1px solid #000" alt="" width="240px" height="145">  --}}
                        <img class="respuesta" src="{{asset('img/icons-rojos/no imagen.jpg')}}" style="border:1px solid #000; " alt="" height="100%" >  
                    </center>
                </div>
                <div style="margin: 5px; width: 92%; text-align: justify;padding: 0px;">
                    <p style="font-size: 12px; font-family: ProximaSoft-Medium; padding: 0; margin: 0px;  color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">Descripción:</span> </p>
                    <p style="font-size: 12px; font-family: ProximaSoft-Medium; padding: 0; margin: 0;  color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">Marca:</span> </p>
                    <p style="font-size: 12px; font-family: ProximaSoft-Medium; padding: 0; margin: 0;  color: #78766f;"><span style="font-family: ProximaSoft-Bold;color: #5e595f; padding: 0; margin: 0;">Modelo:</span> </p>
                </div>
            @else
                @foreach ($datosgarantias as $datosgarantia)
                    
                    <div class="" style="width: 190px; height: 75;  background: rgb(151, 151, 151); margin-left: 33px;padding: 5px; margin-top: 10px">
                        {{-- <center>
                            <img class="respuesta" src="https://laferiecita.com/{{$datosgarantia->foto}}" style="border:1px solid #000; " alt="" height="100%" >  
                        </center> --}}

                            @php
                                $r_garantia = @getimagesize('https://laferiecita.com/'.$datosgarantia->foto);
                                
                            @endphp
                            @if ($r_garantia)
                                <center>
                                    <img class="respuesta" src="https://laferiecita.com/{{$datosgarantia->foto}}" style="border:1px solid #000; " alt="" height="100%" >  
                                </center> 
                            @else 
                                <div style="height: 100%;border:1px solid #000">
                                    <br><br>
                                    <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                                </div>
                            @endif



                    </div>
                    <div style="margin: 5px; width: 92%; text-align: justify;padding: 0px;">
                        <p style="font-size: 12px; font-family: ProximaSoft-Medium; padding: 0; margin: 0px;  color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">Descripción:</span> {{$datosgarantia->descripcion}}</p>
                        <p style="font-size: 12px; font-family: ProximaSoft-Medium; padding: 0; margin: 0;  color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">Marca:</span> {{$datosgarantia->marca}}</p>
                        <p style="font-size: 12px; font-family: ProximaSoft-Medium; padding: 0; margin: 0;  color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">Modelo:</span> {{$datosgarantia->modelo}}</p>
                    </div>
                    @endforeach
            
            @endif
        </div>
        <div style="width: 485px; height: 140px; background: #fff; left: 218; top: 71px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f; ">
                <p style="margin: 0; margin-left: 100px; ">
                    <center>
                        @php
                            $total=0;
                            $aportan=0;
                            $resultado=0;
                        @endphp
                        {{-- Total personas --}}
                        @if (empty($familiar[0]->numero_personas))
                            
                        @else
                            @php
                                $total=$familiar[0]->numero_personas;
                            @endphp
                            
                        @endif

                        {{-- aporltan --}}
                        @if (empty($familiar[0]->aportan_dinero_mensual))
                           
                        @else
                            @php
                                $aportan=$familiar[0]->aportan_dinero_mensual;
                            @endphp
                        @endif

                        @php
                            $resultado=$total-$aportan;
                        @endphp


                        @for ($i = 0; $i < $aportan; $i++)
                            <img src="{{asset('img/icons-rojos/p1.png')}}" alt="" style="width: 25px;margin-top: 8px;  ">
                        @endfor

                        @for ($i = 0; $i < $resultado; $i++)
                            <img src="{{asset('img/icons-rojos/p2.png')}}" alt="" style="width: 25px;margin-top: 8px; ">
                        @endfor


                    </center>
                </p>    

                <p style="margin-left: 100px; font-size: 18px; position: absolute;  font-family: ProximaSoft-Medium; margin-bottom: 0px; margin-top: 0px; top: 55px; padding: 0; color: #5e595f;">
                    @if (empty($familiar[0]->numero_personas))
                        0 personas que viven en el domicilio
                    @else
                        {{$familiar[0]->numero_personas}} personas que viven en el domicilio
                    @endif
                    <br>
                    @if (empty($familiar[0]->aportan_dinero_mensual))
                        0 personas aportan en la vivienda
                    @else
                        {{$familiar[0]->aportan_dinero_mensual}} personas aportan en la vivienda
                    @endif
                </p>
                
        </div>
        <div style="width: 485px; background: #fff; left: 218; top: 223px;position: absolute; font-size: 14px;padding: 3px;  color: #5e595f;letter-spacing:4px; font-family: ProximaSoft-Bold">
            
            DOMICILIO DEL AVAL
        </div>

        <div style="width: 485px; height: 210px; background: #fff; left: 218; top: 249px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f; ">
            
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 3px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">CALLE:</span> 
                @if (!empty($aval[0]->calle))
                    {{$aval[0]->calle}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">NÚMERO EXTERIOR:</span> 
                @if (!empty($aval[0]->numero_ext))
                    {{$aval[0]->numero_ext}}
                @endif
                </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">COLONIA:</span> 
                @if (!empty($aval[0]->colonia))
                    {{$aval[0]->colonia}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">MUNICIPIO:</span> 
                @if (!empty($aval[0]->municipio))
                    {{$aval[0]->municipio}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">ESTADO:</span> 
                @if (!empty($aval[0]->estado))
                    {{$aval[0]->estado}}
                @endif
            </p>
            
            {{-- <p style="text-transform: uppercase; font-size: 12px; font-family: Arial, Helvetica, sans-serif; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><strong style="color: #5e595f; padding: 0; margin: 0;">COORDENADAS:</strong></p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: Arial, Helvetica, sans-serif; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><strong style="color: #5e595f; padding: 0; margin: 0;">LONGITUD:</strong></p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: Arial, Helvetica, sans-serif; margin-top: 0px; padding: 0; color: #78766f;"><strong>LATITUD:</strong></p> --}}
            
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 5px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">TIPO DE VIVIENDA:</span> 
                @if (!empty($aval[0]->vivienda))
                    {{$aval[0]->vivienda}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">TIEMPO VIVIENDO EN VIVIENDA:</span> 
                @if (!empty($aval[0]->tiempo_viviendo_domicilio))
                    {{$aval[0]->tiempo_viviendo_domicilio}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 2px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">REFERENCIAS VISUALES:</span> 
                @if (!empty($aval[0]->referencia_visual))
                    {{$aval[0]->referencia_visual}}
                @endif
            </p>
        </div>

        
        <div style="letter-spacing:2px;width: 265px; background: #fff;top: 500px;position: absolute; font-size: 13px;padding-right: 3px;padding-left: 3px;padding-bottom: 4px;padding-top: 4px; color: #5e595f; font-family: ProximaSoft-Bold">
            INFORMACIÓN DEL AVAL
        </div>
        <div style="width: 260px; height: 135px; background: #fff;top: 530px;position: absolute; font-size: 14px;padding: 5px;  color: #5e595f; ">
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-left: 3px; margin-top: 3px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">CURP:</span> 
                @if (!empty($aval[0]->curp))
                    {{$aval[0]->curp}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-left: 3px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">NOMBRE:</span> 
                @if (!empty($aval[0]->nombre))
                    {{$aval[0]->nombre}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-left: 3px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">CELULAR:</span> 
                @if (!empty($aval[0]->telefono_movil))
                    {{$aval[0]->telefono_movil}}
                @endif
            </p>
            @php
            
                if (!empty($aval[0]->fecha_nacimiento)) {
                    
                    $fecha = $aval[0]->fecha_nacimiento;

                    $fecha_ex = explode("/", $fecha);
                    
                    if (count($fecha_ex)>1) {
                        $fecha_ex = explode("/", $fecha);
                    } else {
                        $fecha_ex = explode("-", $fecha);
                    }
                    

                    // dd($fecha_ex);

                    if (Str::length($fecha_ex[0])==2 || Str::length($fecha_ex[2])==4) {

                        $fecha_nueva=$fecha_ex[2].'-'.$fecha_ex[1].'-'.$fecha_ex[0];
                        $fecha_nacimiento=$fecha_ex[0].'-'.$fecha_ex[1].'-'.$fecha_ex[2];
                    } else {
                        $fecha_nueva=$fecha_ex[0].'-'.$fecha_ex[1].'-'.$fecha_ex[2];
                        $fecha_nacimiento=$fecha_ex[2].'-'.$fecha_ex[1].'-'.$fecha_ex[0];
                    }
                    
                    $cumpleanos = new DateTime($fecha_nueva);
                    $hoy = new DateTime();
                    $annos = $hoy->diff($cumpleanos);
                } else {
                
                }
            
                
            @endphp
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-left: 3px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">FECHA DE NACIMIENTO:</span> 
                @if (!empty($fecha_nacimiento))
                    {{$fecha_nacimiento}}
                @endif
            </p>
            
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-left: 3px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">EDAD:</span> 
                {{-- {{$aval[0]->fecha_nacimiento}} --}}
                @if (!empty($annos->y))
                    {{$annos->y}}
                @endif
                {{-- {{$fecha_nueva}} --}}
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-left: 3px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">OCUPACIÓN:</span> 
                @if (!empty($aval[0]->ocupacion))
                    {{$aval[0]->ocupacion}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-left: 3px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">GENERO:</span> 
                @if (!empty($aval[0]->genero))
                    {{$aval[0]->genero}}
                @endif
            </p>
            <p style="text-transform: uppercase; font-size: 12px; font-family: ProximaSoft-Medium; margin-bottom: 1px; margin-left: 3px; margin-top: 0px; padding: 0; color: #78766f;"><span style="font-family: ProximaSoft-Bold; color: #5e595f; padding: 0; margin: 0;">ESTADO CIVIL:</span> 
                @if (!empty($aval[0]->estado_civil))
                    {{$aval[0]->estado_civil}}
                @endif
            </p>
            
        </div>


        <div style="letter-spacing:2px;width: 265px; background: #fff;top: 680px;position: absolute; font-size: 13px;padding-right: 3px;padding-left: 3px;padding-bottom: 4px;padding-top: 4px; color: #5e595f; font-family: ProximaSoft-Bold">
            IDENTIFICACIÓN DEL AVAL
        </div>

        <div style="width: 265px; background: #fff; left: 8; top: 731px;position: absolute; font-size: 14px;padding: 3px;  color: #5e595f;letter-spacing:4px;">
            {{-- Identificacion del prospecto --}}
            <span style="margin-left: 5px;letter-spacing:2px; font-family: ProximaSoft-Medium; font-size: 9px">IDENTIFICACIÓN FRONTAL</span><br>
                <div style="margin-left: 10px">


                    @if (empty($docs_ine_1a[0]->path_url))
                        <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" style="border:1px solid #000" alt="" width="240px" height="145"> 
                    @else
                        @php
                            $ub=str_split($docs_ine_1a[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_ine_1a[0]->path_url}}" style="border:1px solid #000" alt="Identificiación INE frontal" width="240px" height="145">
                        @else
                        
                            @php
                                $r_ine_aval1 = @getimagesize('https://laferiecita.com/ws/documentos/'.$docs_ine_1a[0]->path_url);
                                
                            @endphp
                            @if ($r_ine_aval1)
                                <img src="https://laferiecita.com/ws/documentos/{{$docs_ine_1a[0]->path_url}}"  alt="Identificiación INE frontal" width="240px" height="145">
                            @else 
                                <div style="height: 140px; width: 240px; border:1px solid #000">
                                    <br><br>
                                    <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                                </div>
                            @endif


                            
                        @endif
                    @endif


                </div>
                <span style="margin-left: 5px;letter-spacing:2px; font-family: ProximaSoft-Medium; font-size: 9px">IDENTIFICACIÓN REVERSO</span><br>
                <div style="margin-left: 10px">
                    @if (empty($docs_ine_2a[0]->path_url))
                        <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" style="border:1px solid #000" alt="" width="240px" height="145">  
                    @else
                        @php
                            $ub=str_split($docs_ine_2a[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_ine_2a[0]->path_url}}" style="border:1px solid #000" alt="Identificiación INE reverso" width="240px" height="145"> 
                        @else

                            @php
                                $r_ine_aval2 = @getimagesize('https://laferiecita.com/ws/documentos/'.$docs_ine_2a[0]->path_url);
                            
                            @endphp
                            @if ($r_ine_aval2)
                                <img  src="https://laferiecita.com/ws/documentos/{{$docs_ine_2a[0]->path_url}}"  alt="Identificiación INE reverso" width="240px" height="145">
                            @else 
                                <div style="height: 140px; width: 240px; border:1px solid #000">
                                    <br><br>
                                    <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                                </div>
                            @endif


                            
                        @endif
                    @endif
                   
                </div>
                <br>
        </div>



        <div style="width: 485px; background: #fff; left: 218; top: 470px;position: absolute; font-size: 14px;padding: 3px; color: #5e595f;letter-spacing:4px; font-family: ProximaSoft-Bold">
            COMPROBANTE DE DOMICILIO DEL AVAL
        </div>

        <div style="width: 452px; height: 539px; background: #fff; left: 218; top: 498px;position: absolute; font-size: 14px;padding: 20px; color: #5e595f;letter-spacing:4px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">
            <center>

                @if (empty($docs_comprobantea[0]->path_url))
                        <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" alt="" width="75%" height="395" style="border:1px solid #000" >  
                    @else
                        @php
                            $ub=str_split($docs_comprobantea[0]->path_url);
                            $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
                        @endphp
                        @if ($ubicacion=='DocImagenes')
                            <img src="{{$docs_comprobantea[0]->path_url}}" alt="" width="93%" height="380" style="-webkit-transform: rotate(90deg); margin-top: 10px">
                        @else

                            @php
                                $r_comprobante_aval = @getimagesize('https://laferiecita.com/ws/documentos/'.$docs_comprobantea[0]->path_url);
                            
                            @endphp
                            @if ($r_comprobante_aval)
                                <img src="https://laferiecita.com/ws/documentos/{{$docs_comprobantea[0]->path_url}}" alt="" width="95%" height="540px" >
                                {{-- <img src="https://laferiecita.com/ws/documentos/{{$docs_comprobantea[0]->path_url}}" alt="" width="93%" height="380" style="-webkit-transform: rotate(90deg); margin-top: 10px" > --}}
                            @else 
                                <div style="margin-left:50px;height: 395px; width: 350px; border:1px solid #000">
                                    <br><br>
                                    <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                                </div>
                            @endif
                              
                        @endif
                    @endif
            </center>  
        </div>
    </div>
    
    <div class="footer">
        <span style="font-size: 12px; margin-right: 385px; font-family: ProximaSoft-Bold">S.E. # {{$id_socio}} generado el: {{$hoy->format('d-m-Y')}}</span>  
        <span style="font-size: 23px;font-family: ProximaSoft-Bold" >laferiecita.com</span>
    </div>
</main>
<hr>
<main style=" background: #fff; -webkit-transform: rotate(-180deg);margin: 0; " >
    <div  style="margin-top: 45px; position: static; background: #fff;  padding: 55px; padding-bottom: 5px;font-size: 12px; text-align: justify; ">
        <p style="font-family: ProximaSoft-Medium">CONTRATO DE APERTURA DE CRÉDITO SIMPLE QUE CELEBRAN LA FINANCIERA PRESTAMOS LA FERIECITA, A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ “LA FERIECITA” Y POR LA OTRA PARTE, LA PERSONA CUYOS DATOS Y FIRMA SE ENCUENTRAN EN EL SOCIOECONÓMICO Y CARÁTULA DEL PRESENTE CONTRATO, SE LE DENOMINARÁ “LA CLIENTA”, DE CONFORMIDAD CON LAS DECLARACIONES Y CLÁUSULAS SIGUIENTES:  </p>
        
        <center>
            <p style="letter-spacing: 4px;font-family: ProximaSoft-Medium">DECLARACIONES</p>
        </center>
        <table>
            <tbody>
                <td style="text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium; width: 48%;">
                    <span style="font-family: ProximaSoft-Bold">I. Declara la financiera que:</span>
                    <br><span style="font-family: ProximaSoft-Bold">b)</span> Cuenta con las facultades suficientes y necesarias para obligarse en los términos del presente contrato, mismas que no le han sido revocadas o modificadas en forma alguna.
                    <br><span style="font-family: ProximaSoft-Bold">II. Declara la clienta que:</span>
                    <br><span style="font-family: ProximaSoft-Bold">a)</span> Es una persona física facultada para celebrar el presente contrato.
                    <br><span style="font-family: ProximaSoft-Bold">b)</span> Declara la clienta que los datos proporcionados son verídicos, para recibir toda clase de notificaciones, requerimientos de pagos y avisos correspondientes.
                    <br><span style="font-family: ProximaSoft-Bold">c)</span> Declara que ha solicitado a La Feriecita un préstamo por el monto establecido, en moneda nacional mexicana, términos y condiciones contenidos en el presente contrato.
                    
                    
                </td>
                <td style="padding-left: 25px; text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium">
                    <span style="font-family: ProximaSoft-Bold">d)</span> La clienta, realizo una previa revisión y análisis de la información y documentación que es proporcionada y presentada por La Feriecita por medio de un trabajador de la empresa.
                    <br><span style="font-family: ProximaSoft-Bold">III. Declara aval de la cliente que:</span>
                    <br><span style="font-family: ProximaSoft-Bold">a)</span> Reconoce las responsabilidades que conlleva firmar el siguiente documento, así como asumir la responsabilidad de la falta de pagos que pueda llegar a tener el cliente. Acata las políticas contenidas en el presente contrato, así como cualquier cambio que decida realizar la dirección general y administración. 
                    <br><br><br><br>
                </td>
            </tbody>
        </table>
        <center>
            <p style="letter-spacing: 4px; margin-top: 25px;font-family: ProximaSoft-Medium">CLÁUSULAS</p>
        </center>
        <table>
            <tbody>
                <td style="text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium; width: 48%;">
                    <span style="font-family: ProximaSoft-Bold">PRIMERA.</span> Las siguientes cláusulas se aplicarán al cumplimiento en tiempo y forma del pago, así como las condiciones del préstamo que otorga La Feriecita, en beneficio de la cliente. <span style="font-family: ProximaSoft-Bold">SEGUNDA.</span> Monto a entregar . La Feriecita, otorga y hace entrega a la clienta, un préstamo, crédito, por la cantidad que fue aprobada, se muestra en el estudio socioeconómico, mismo que la clienta reconoce recibir teniendo en cuenta la retención de ahorro semana 14 y el 5% del total del préstamo que corresponden a los gastos administrativos (trámite). 
                    <span style="font-family: ProximaSoft-Bold">TERCERA.</span> ENTREGA DEL PRÉSTAMO, la clienta dispondrá del total del crédito en una sola disposición, después de verificar nuevamente la información y desglose del crédito, así como la firma de la solicitante (clienta). <span style="font-family: ProximaSoft-Bold">CUARTA.</span> INTERESES Y GASTOS POR CRÉDITO. La clienta pagará un porcentaje de intereses correspondientes al  cual para su cálculo se computarán de manera semanal, siendo esto el día y hora acordada, así mismo el cliente pagará con concepto de gastos por cada crédito otorgado la cantidad de $50.00 pesos por cada $1000 pesos de crédito. 
                    En caso de que el monto solicitado sea mayor o menor, el cálculo será proporcional bajo dicho razonamiento. <span style="font-family: ProximaSoft-Bold">QUINTA:</span> PAGOS ANTICIPADOS Y PAGOS ADELANTADOS. La clienta podrá́ efectuar pagos mayores a los comprometidos y/o pagos anticipados, cuyos montos se imputarán en la forma que La Feriecita determine, en cuyo caso este ultimo se comunicará a la cliente el nuevo cronograma de pagos. “La Feriecita” está obligada a recibir pagos anticipados siempre que la clienta se encuentre al corriente en los pagos exigibles de conformidad con el presente Contrato. 
                    <span style="font-family: ProximaSoft-Bold">SEXTA.</span> FECHAS, MONTO DE PAGO, MULTAS GARANTÍAS Y SEMANA DE PENALIZACIÓN. La cliente está obligada a realizar los abonos del crédito entregado, el día y hora acordada inmediatamente a la siguiente fecha en que se entregó el crédito. <span style="font-family: ProximaSoft-Bold">SÉPTIMA.</span> FORMA Y LUGAR DEL 
                <br><br>
                </td>
                <td style="padding-left: 25px; padding-bottom: 15px; text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium"> 
                    PAGO es responsabilidad de la cliente, acudir al domicilio donde se entregó el recurso del presente contrato y así mismo realizar el pago del monto acordado <span style="font-family: ProximaSoft-Bold">OCTAVA. DUDAS O ACLARACIONES</span>, en caso de que el cliente tenga alguna duda, consulta, sugerencia, aclaración, necesite información o solicitar un nuevo crédito, deberá comunicarse vía telefónica al número siguiente (33) 38-03-24-32. 
                    <span style="font-family: ProximaSoft-Bold">NOVENA</span> El siguiente contrato entrará en vigor a partir de su fecha de entrega y firma, el cual tendrá una duración de 13 semanas con pagos si se realizan en tiempo y forma, si no realiza sus pagos se extiende el plazo, por el aumento de su saldo gracias a las multas. <span style="font-family: ProximaSoft-Bold">PAGO CONVENCIONAL</span> la clienta pagará la cantidad como pago semanal, en la primera ocasión que no se cubra un pago, se multa con la semana 15. <span style="font-family: ProximaSoft-Bold">MULTA</span> si la clienta realiza su pago en una fecha distinta, a la fecha antes mencionada, se multará con $50 pesos. <span style="font-family: ProximaSoft-Bold">GARANTÍAS</span> a partir de cuatro retrasos se retienen las garantías. 
                    <span style="font-family: ProximaSoft-Bold">NOTIFICACIÓN DE EMBARGO.</span> Si el cliente cuenta con pagos parciales o multas después de haber terminado el plazo de pagos, se pasa la cuenta a jurídico enviando la primera notificación de embargo, si el cliente no realiza sus pagos de después de la primera notificación, se le estará enviando la segunda notificación, dándole al cliente una segunda oportunidad para realizar los pagos o liquidar la cuenta de lo contrario se procederá legalmente. <span style="font-family: ProximaSoft-Bold">POLÍTICAS DE CRÉDITOS</span> en la entrega del crédito, el cliente estará recibiendo un control de recibos en el cual se tendrá que recabar la firma ante quien efectúe su pago. 
                    En caso de ser puntual en el pago de sus 13 semanas el cliente, podrá solicitar un nuevo crédito con aumento de $500 pesos. Podrá renovar sin aumento su nuevo crédito si solo tiene una falla y contar con 13 semanas pagadas. Podrá renovar con una disminución en su crédito si cuenta con dos fallas en sus pagos o parciales. (la disminución será de $500.00 a su nuevo crédito).
                    
                </td>
            </tbody>
            <br>
        </table>
    
    </div>
    <div class="footer" style="bottom: -14px;">
        
        <span style="font-family: ProximaSoft-Bold;font-size: 13px; margin-right: 365px">S.E. # {{$id_socio}} generado el: {{$hoy->format('d-m-Y')}}</span> 
        <span style="font-family: ProximaSoft-Bold;font-size: 23px;">laferiecita.com</span>
    </div>
</main>
<hr>
<main style="padding: 11px; background: #fff;">
    <center>
        <span style="font-size: 9px;letter-spacing:5px; font-family: ProximaSoft-Medium">CONTRATO DE APERTURA CRÉDITO SIMPLE</span>
    </center>
    <img src="{{asset('img/logo/Logo Prestamos.jpg')}}" alt="" width="210px" height="150px" style=" margin-left: 60px; margin-top: 25px" >  
    <div style=" padding-left: 60px; padding-right: 60px; text-align: justify;font-family:ProximaSoft-Medium">
        <p style="margin-bottom: 30px;">
            Acepto en forma voluntaria, expresó mi entera satisfacción, convencimiento y sin coacción
            de ningún tipo, el préstamo que por concepto de crédito individual que me otorga la
            financiera PRESTAMOS “ LA FERIECITA”.
        </p>
        <p style="margin-bottom: 30px;">
            Por ello, estoy de acuerdo en garantizar el pago de dicho crédito, para lo cual suscribo,
            acepto y firmo el pagaré mercantil y éste documento para que, en caso de
            INCUMPLIMIENTO de pago, el saldo de mi crédito sea liquidado con los bienes que otorgo
            en garantía y, que a anteriormente se detalla.
        </p>
        <p style="margin-bottom: 30px;">
            Las garantías mencionadas anteriormente, las entregaré voluntariamente a los
            representantes de la financiera PRESTAMOS “ LA FERIECITA”, renunciando a todo juicio
            mercantil o cualquier alternativa que fuese, en cualquier parte de la república mexicana,
            como consecuencia de NO cubrir los pagos establecidos en el crédito mencionado, en el
            entendido de que con el referido préstamo, no se comete en mi contra, la usura prevista en
            el Artículo 258 del código penal del estado de Jalisco, ya que no se está abusando de mis
            necesidades.

        </p>
        <p style="margin-bottom: 40px;">
            LA INFORMACIÓN QUE AQUÍ USTED NOS PROPORCIONA ES TOTALMENTE CONFIDENCIAL
            Y POR NINGÚN MOTIVO SE PUEDE HACER PUBLICA.

        </p>
        <p >
            Firmando el documento, doy fe de que toda la información que proporcioné a la empresa es
            verdadera y completa que no omití detalle alguno y, si la empresa encontrara alguna
            falsedad en mi socioeconómico, tiene derecho a rechazar mi solicitud.

        </p>
        <br>
        @if (empty($docs_ine_2[0]->path_url))
            <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" style="border:1px solid #000" alt="" width="240px" height="145">  
        @else
            @php
                $ub=str_split($docs_ine_2[0]->path_url);
                $ubicacion=$ub[0].$ub[1].$ub[2].$ub[3].$ub[4].$ub[5].$ub[6].$ub[7].$ub[8].$ub[9].$ub[10];
            @endphp
            @if ($ubicacion=='DocImagenes')
                <img src="{{$docs_ine_2[0]->path_url}}" style="border:1px solid #000" alt="INE REVERSO" width="240px" height="145">  
            @else
                @php
                    $result = @getimagesize('https://laferiecita.com/ws/documentos/'.$docs_ine_2[0]->path_url);
                    
                @endphp
                @if ($result)
                    <img class="responsive-img materialboxed" src="https://laferiecita.com/ws/documentos/{{$docs_ine_2[0]->path_url}}" style="border:1px solid #000" alt="Identificiación INE reverso" width="240px" height="145">  
                @else 
                    <div style="width: 240px; height: 145px;border:1px solid #000; margin-top: -25px">
                        <br><br>
                        <center>¡Imagen dañada!. <br>Vuelva a cargarla.</center>
                    </div>
                @endif
            @endif
        @endif
        {{-- <img src="{{asset('img/icons-rojos/no imagen.jpg')}}" alt="" width="300px" height="115px" style="margin-top: 15px; border:1px solid #000;" >   --}}
        <br>
        <br>
        
            <div style="position: relative;">
                <div style="position: absolute">
                    <label style="font-size: 11px; width: 20px;">_____________________________</label>
                    <label style="font-size: 11px;margin-left: 30px; width: 20px;">_____________________________</label>
                    <br>
            
                    <label style="margin-left:14px; font-size: 11px; text-align: center; letter-spacing:3px; color: rgb(82, 82, 82);">FIRMA DEL CLIENTE</label>
                    <label style="margin-left:54px; font-size: 11px; text-align: center; letter-spacing:3px; color: rgb(82, 82, 82);">FIRMA DEL TESTIGO</label>
                    <div style="width: 170px; height: 170px; border:3px solid #000; position: absolute; margin-left: 60px; bottom: 126px;">
                    </div><br>
                    <label style=" margin-left:458px; font-size: 11px; text-align: center; letter-spacing:3px; color: rgb(82, 82, 82);">HUELLAS DACTIDALES</label>
                    
                </div>
                
            </div>
        <br><br><br><br>
        <br><br>
    </div>
    <div class="footer">
        <span style="font-size: 12px; margin-right: 385px; font-family: ProximaSoft-Bold">S.E. # {{$id_socio}} generado el: {{$hoy->format('d-m-Y')}}</span>  
        <span style="font-size: 23px;font-family: ProximaSoft-Bold" >laferiecita.com</span>
    </div>
</main>
<hr>

<main style=" background: #fff; -webkit-transform: rotate(-180deg);margin: 0; " >
    <div  style="margin-top: 45px; position: static; background: #fff;  padding: 55px; padding-bottom: 5px;font-size: 12px; text-align: justify; ">
        <p style="font-family: ProximaSoft-Medium">CONTRATO DE APERTURA DE CRÉDITO SIMPLE QUE CELEBRAN LA FINANCIERA PRESTAMOS LA FERIECITA, A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ “LA FERIECITA” Y POR LA OTRA PARTE, LA PERSONA CUYOS DATOS Y FIRMA SE ENCUENTRAN EN EL SOCIOECONÓMICO Y CARÁTULA DEL PRESENTE CONTRATO, SE LE DENOMINARÁ “LA CLIENTA”, DE CONFORMIDAD CON LAS DECLARACIONES Y CLÁUSULAS SIGUIENTES:  </p>
        
        <center>
            <p style="letter-spacing: 4px;font-family: ProximaSoft-Medium">DECLARACIONES</p>
        </center>
        <table>
            <tbody>
                <td style="text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium; width: 48%;">
                    <span style="font-family: ProximaSoft-Bold">I. Declara la financiera que:</span>
                    <br><span style="font-family: ProximaSoft-Bold">b)</span> Cuenta con las facultades suficientes y necesarias para obligarse en los términos del presente contrato, mismas que no le han sido revocadas o modificadas en forma alguna.
                    <br><span style="font-family: ProximaSoft-Bold">II. Declara la clienta que:</span>
                    <br><span style="font-family: ProximaSoft-Bold">a)</span> Es una persona física facultada para celebrar el presente contrato.
                    <br><span style="font-family: ProximaSoft-Bold">b)</span> Declara la clienta que los datos proporcionados son verídicos, para recibir toda clase de notificaciones, requerimientos de pagos y avisos correspondientes.
                    <br><span style="font-family: ProximaSoft-Bold">c)</span> Declara que ha solicitado a La Feriecita un préstamo por el monto establecido, en moneda nacional mexicana, términos y condiciones contenidos en el presente contrato.
                    
                    
                </td>
                <td style="padding-left: 25px; text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium">
                    <span style="font-family: ProximaSoft-Bold">d)</span> La clienta, realizo una previa revisión y análisis de la información y documentación que es proporcionada y presentada por La Feriecita por medio de un trabajador de la empresa.
                    <br><span style="font-family: ProximaSoft-Bold">III. Declara aval de la cliente que:</span>
                    <br><span style="font-family: ProximaSoft-Bold">a)</span> Reconoce las responsabilidades que conlleva firmar el siguiente documento, así como asumir la responsabilidad de la falta de pagos que pueda llegar a tener el cliente. Acata las políticas contenidas en el presente contrato, así como cualquier cambio que decida realizar la dirección general y administración. 
                    <br><br><br><br>
                </td>
            </tbody>
        </table>
        <center>
            <p style="letter-spacing: 4px; margin-top: 25px;font-family: ProximaSoft-Medium">CLÁUSULAS</p>
        </center>
        <table>
            <tbody>
                <td style="text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium; width: 48%;">
                    <span style="font-family: ProximaSoft-Bold">PRIMERA.</span> Las siguientes cláusulas se aplicarán al cumplimiento en tiempo y forma del pago, así como las condiciones del préstamo que otorga La Feriecita, en beneficio de la cliente. <span style="font-family: ProximaSoft-Bold">SEGUNDA.</span> Monto a entregar . La Feriecita, otorga y hace entrega a la clienta, un préstamo, crédito, por la cantidad que fue aprobada, se muestra en el estudio socioeconómico, mismo que la clienta reconoce recibir teniendo en cuenta la retención de ahorro semana 14 y el 5% del total del préstamo que corresponden a los gastos administrativos (trámite). 
                    <span style="font-family: ProximaSoft-Bold">TERCERA.</span> ENTREGA DEL PRÉSTAMO, la clienta dispondrá del total del crédito en una sola disposición, después de verificar nuevamente la información y desglose del crédito, así como la firma de la solicitante (clienta). <span style="font-family: ProximaSoft-Bold">CUARTA.</span> INTERESES Y GASTOS POR CRÉDITO. La clienta pagará un porcentaje de intereses correspondientes al  cual para su cálculo se computarán de manera semanal, siendo esto el día y hora acordada, así mismo el cliente pagará con concepto de gastos por cada crédito otorgado la cantidad de $50.00 pesos por cada $1000 pesos de crédito. 
                    En caso de que el monto solicitado sea mayor o menor, el cálculo será proporcional bajo dicho razonamiento. <span style="font-family: ProximaSoft-Bold">QUINTA:</span> PAGOS ANTICIPADOS Y PAGOS ADELANTADOS. La clienta podrá́ efectuar pagos mayores a los comprometidos y/o pagos anticipados, cuyos montos se imputarán en la forma que La Feriecita determine, en cuyo caso este ultimo se comunicará a la cliente el nuevo cronograma de pagos. “La Feriecita” está obligada a recibir pagos anticipados siempre que la clienta se encuentre al corriente en los pagos exigibles de conformidad con el presente Contrato. 
                    <span style="font-family: ProximaSoft-Bold">SEXTA.</span> FECHAS, MONTO DE PAGO, MULTAS GARANTÍAS Y SEMANA DE PENALIZACIÓN. La cliente está obligada a realizar los abonos del crédito entregado, el día y hora acordada inmediatamente a la siguiente fecha en que se entregó el crédito. <span style="font-family: ProximaSoft-Bold">SÉPTIMA.</span> FORMA Y LUGAR DEL 
                <br><br>
                </td>
                <td style="padding-left: 25px; padding-bottom: 15px; text-align: justify; font-size: 12px; font-family: ProximaSoft-Medium"> 
                    PAGO es responsabilidad de la cliente, acudir al domicilio donde se entregó el recurso del presente contrato y así mismo realizar el pago del monto acordado <span style="font-family: ProximaSoft-Bold">OCTAVA. DUDAS O ACLARACIONES</span>, en caso de que el cliente tenga alguna duda, consulta, sugerencia, aclaración, necesite información o solicitar un nuevo crédito, deberá comunicarse vía telefónica al número siguiente (33) 38-03-24-32. 
                    <span style="font-family: ProximaSoft-Bold">NOVENA</span> El siguiente contrato entrará en vigor a partir de su fecha de entrega y firma, el cual tendrá una duración de 13 semanas con pagos si se realizan en tiempo y forma, si no realiza sus pagos se extiende el plazo, por el aumento de su saldo gracias a las multas. <span style="font-family: ProximaSoft-Bold">PAGO CONVENCIONAL</span> la clienta pagará la cantidad como pago semanal, en la primera ocasión que no se cubra un pago, se multa con la semana 15. <span style="font-family: ProximaSoft-Bold">MULTA</span> si la clienta realiza su pago en una fecha distinta, a la fecha antes mencionada, se multará con $50 pesos. <span style="font-family: ProximaSoft-Bold">GARANTÍAS</span> a partir de cuatro retrasos se retienen las garantías. 
                    <span style="font-family: ProximaSoft-Bold">NOTIFICACIÓN DE EMBARGO.</span> Si el cliente cuenta con pagos parciales o multas después de haber terminado el plazo de pagos, se pasa la cuenta a jurídico enviando la primera notificación de embargo, si el cliente no realiza sus pagos de después de la primera notificación, se le estará enviando la segunda notificación, dándole al cliente una segunda oportunidad para realizar los pagos o liquidar la cuenta de lo contrario se procederá legalmente. <span style="font-family: ProximaSoft-Bold">POLÍTICAS DE CRÉDITOS</span> en la entrega del crédito, el cliente estará recibiendo un control de recibos en el cual se tendrá que recabar la firma ante quien efectúe su pago. 
                    En caso de ser puntual en el pago de sus 13 semanas el cliente, podrá solicitar un nuevo crédito con aumento de $500 pesos. Podrá renovar sin aumento su nuevo crédito si solo tiene una falla y contar con 13 semanas pagadas. Podrá renovar con una disminución en su crédito si cuenta con dos fallas en sus pagos o parciales. (la disminución será de $500.00 a su nuevo crédito).
                    
                </td>
            </tbody>
            <br>
        </table>
    
    </div>
    <div class="footer" style="bottom: -14px;">
        
        <span style="font-family: ProximaSoft-Bold;font-size: 13px; margin-right: 365px">S.E. # {{$id_socio}} generado el: {{$hoy->format('d-m-Y')}}</span> 
        <span style="font-family: ProximaSoft-Bold;font-size: 23px;">laferiecita.com</span>
    </div>
</main>

</body>
</html>