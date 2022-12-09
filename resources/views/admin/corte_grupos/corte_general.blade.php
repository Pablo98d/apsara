@extends('layouts.master')
@section('title', 'Corte general por semana')
@section('parentPageTitle', 'Corte')
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
@stop
@section('content')
{{-- $multas_por_grupo=json_encode($multas_por_grupo);
            $multas_por_grupo=json_decode($multas_por_grupo);

            $grupos_sin_configuracion=json_encode($grupos_sin_configuracion);
            $grupos_sin_configuracion=json_decode($grupos_sin_configuracion);

            $prestamos_sin_producto=json_encode($prestamos_sin_producto);
            $prestamos_sin_producto=json_decode($prestamos_sin_producto);

            $grupos_corte=json_encode($grupos_corte);
            $grupos_corte=json_decode($grupos_corte); --}}

            {{-- array_push($grupos_sin_configuracion, array(
                'id_grupo' => $grupo->id_grupo,
                'grupo' =>$grupo->grupo,
            ));
            array_push($prestamos_sin_producto, array(
                'id_prestamo' =>$prestamo->id_prestamo,
                'id_grupo' => $grupo->id_grupo,
                'grupo' =>$grupo->grupo,
            ));

            array_push($multas_por_grupo, array(
                'id_prestamo' => $prestamo->id_prestamo,
                'tipo_abono' => $tipo_abono,
                'id_corte_semana' => $corte_semana,
                'grupo' => $grupo->id_grupo,
                'cantidad_multa'=>$cantidad_multa
            ));

            array_push($grupos_corte, array(
                'id_grupo' => $grupo->id_grupo,
                'grupo' => $grupo->grupo,
                'total_clientes' => $total_clientes,
                'corte_ideal' => $corte_ideal
            )); --}}



    <hr>
    <div class="row">
        <div class="col-md-12" >
            <b style="background: #3728A2; padding: 5px; color: #fff; border-radius: 10px 10px 0 0" class="mb-3">MULTAS ENCONTRADAS EN LOS DIFERENTES GRUPOS</b>
            <div>
                <table>
                    <thead>
                        <th style="width: 145px">Grupo</th>
                        <th style="width: 375px;">#prestamo</th>
                        <th style="width: 100px">Tipo abono</th>
                        <th style="width: 155px">Corte semana</th>
                    </thead>
                    
                </table>
            </div>
            <div style="height: 350px; overflow-y: scroll">
                
                <div class="estilo-tabla">
                    <table>
                        
                        <tbody>
                            @foreach ($multas_por_grupo as $multas_por_g)
                            @php
                                $usuario=DB::table('tbl_datos_usuario')
                                ->join('tbl_prestamos','tbl_datos_usuario.id_usuario','tbl_prestamos.id_usuario')
                                ->select('tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
                                ->where('tbl_prestamos.id_prestamo','=',$multas_por_g->id_prestamo)
                                ->get();
                            @endphp
                                <tr>
                                    <td style="width: 150px;">{{$multas_por_g->grupo}}</td>
                                    <td style="width: 400px;">#{{$multas_por_g->id_prestamo}} / {{$usuario[0]->nombre}} {{$usuario[0]->ap_paterno}} {{$usuario[0]->ap_materno}}</td>
                                    <td style="width: 100px">
                                            {{$multas_por_g->tipo_abono}} / $ {{number_format($multas_por_g->cantidad_multa,1)}}
                                    </td>
                                    <td style="width: 150px">
                                            #{{$multas_por_g->id_corte_semana}} / {{$multas_por_g->fecha_corte}}
                                    </td>
                                    
                                </tr>
                                {{-- <li>#prestamo {{$multas_por_g->id_prestamo}} / Tipo abono {{$multas_por_g->tipo_abono}} / Id corte semana {{$multas_por_g->id_corte_semana}} / Grupo {{$multas_por_g->grupo}} / Cantidad {{$multas_por_g->cantidad_multa}} </li> --}}
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <ul>
                
            </ul>
        </div>

        <div class="col-md-5 mt-4" >
            <b style="background: #3728A2; padding: 5px; color: #fff; border-radius: 10px 10px 0 0" class="mb-3">GRUPOS SIN FECHA DE CORTE</b>
            <div>
                <table>
                    <thead>
                        <th style="width: 145px">#grupo</th>
                        <th style="width: 145px">Grupo</th>
                    </thead>
                    
                </table>
            </div>
            <div style="height: 350px; overflow-y: scroll">
                
                <div class="estilo-tabla">
                    <table>
                        
                        <tbody>
                            @foreach ($grupos_sin_configuracion as $grupos_sin_c)
                                <tr>
                                    <td style="width: 150px;">{{$grupos_sin_c->id_grupo}}</td>
                                    <td style="width: 150px;">{{$grupos_sin_c->grupo}}</td>
                                    
                                </tr>
                                {{-- <li>#prestamo {{$multas_por_g->id_prestamo}} / Tipo abono {{$multas_por_g->tipo_abono}} / Id corte semana {{$multas_por_g->id_corte_semana}} / Grupo {{$multas_por_g->grupo}} / Cantidad {{$multas_por_g->cantidad_multa}} </li> --}}
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-7 mt-4" >
            <b style="background: #3728A2; padding: 5px; color: #fff; border-radius: 10px 10px 0 0" class="mb-3">APLICACIÓN DE CORTE</b>
            <div>
                <table>
                    <thead>
                        <th style="width: 240px">Grupo</th>
                        <th style="width: 90px">Total clientes</th>
                        <th style="width: 95px">Corte ideal</th>
                        <th style="width: 95px">Semana</th>
                    </thead>
                    
                </table>
            </div>
            <div style="height: 350px; overflow-y: scroll">
                
                <div class="estilo-tabla">
                    <table>
                        <form action="" method="post">
                        <tbody>
                            @foreach ($grupos_corte as $grupos_c)
                                @if ($grupos_c->total_clientes==0 && $grupos_c->corte_ideal==0)
                                    
                                @else
                                    <tr>
                                        <td style="width: 250px;">
                                            <input type="text" name="id_grupo[]" value="{{$grupos_c->id_grupo}}">
                                            #{{$grupos_c->id_grupo}} / {{$grupos_c->grupo}}</td>
                                        <td style="width: 80px;">
                                            <input type="text" name="total_clientes[]" value="{{$grupos_c->total_clientes}}">
                                            {{$grupos_c->total_clientes}}</td>
                                        <td style="width: 80px;">
                                            <input type="text" name="corte_ideal[]" value="{{$grupos_c->corte_ideal}}">
                                            $ {{number_format($grupos_c->corte_ideal,1)}}</td>
                                        <td style="width: 80px;">{{$grupos_c->semana_siguiente}}</td>
                                        
                                        
                                    </tr>
                                @endif
                                {{-- <li>#prestamo {{$multas_por_g->id_prestamo}} / Tipo abono {{$multas_por_g->tipo_abono}} / Id corte semana {{$multas_por_g->id_corte_semana}} / Grupo {{$multas_por_g->grupo}} / Cantidad {{$multas_por_g->cantidad_multa}} </li> --}}
                            @endforeach
                            
                        </tbody>
                        </form>
                    </table>
                </div>
            </div>
        </div>
        @if (count($prestamos_sin_producto)==0)
            
        @else
            <div class="col-md-4 mt-4" >
                <b style="background: #3728A2; padding: 5px; color: #fff; border-radius: 10px 10px 0 0" class="mb-3">PRÉSTAMOS SIN PRODUCTO</b>
                <div>
                    <table>
                        <thead>
                            <th style="width: 145px">#prestamo</th>
                            <th style="width: 145px">id grupo</th>
                        </thead>
                        
                    </table>
                </div>
                <div style="height: 350px; overflow-y: scroll">
                    
                    <div class="estilo-tabla">
                        <table>
                            
                            <tbody>
                                @foreach ($prestamos_sin_producto as $prestamos_sin_p)
                                    <tr>
                                        <td style="width: 150px;">{{$prestamos_sin_p->id_prestamo}}</td>
                                        <td style="width: 150px;">{{$prestamos_sin_p->id_grupo}}</td>
                                        
                                    </tr>
                                    {{-- <li>#prestamo {{$multas_por_g->id_prestamo}} / Tipo abono {{$multas_por_g->tipo_abono}} / Id corte semana {{$multas_por_g->id_corte_semana}} / Grupo {{$multas_por_g->grupo}} / Cantidad {{$multas_por_g->cantidad_multa}} </li> --}}
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
       


        
    </div>

    
@endsection
@section('page-script')

@stop