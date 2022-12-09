<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Abonos;
use App\Penalizacion;
use Illuminate\Console\Command;

class corte_general extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'corte_general:hacer_corte';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $fecha_hoy=Carbon::now();
       

        $grupos = DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->orderBy('grupo','ASC')
        ->get();
       
        if (count($grupos)==0) {
            dd('Sin grupos');
        } else {
            
            $grupos_sin_configuracion = array();
            $prestamos_sin_producto = array();
            $multas_por_grupo = array();

            $grupos_corte=array();


            $grupos_corte_exito=array();
            $grupos_corte_error=array();

            foreach ($grupos as $grupo) {
                
                $corte_semana='';
                $fecha_corte='';
                $total_clientes=0;
                $corte_ideal=0;
                

                $prestamos = DB::table('tbl_prestamos')
                ->select('tbl_prestamos.*')
                ->where('id_grupo','=', $grupo->id_grupo)
                ->whereIn('id_status_prestamo',[2,9,20])
                ->get();

                
                $semana_corte_actual=DB::table('tbl_cortes_semanas')
                ->select('tbl_cortes_semanas.*')
                ->where('id_grupo','=',$grupo->id_grupo)
                ->orderBy('fecha_final','ASC')
                ->get();
                
                if(count($semana_corte_actual)==0){

                    array_push($grupos_sin_configuracion, array(
                        'id_grupo' => $grupo->id_grupo,
                        'grupo' =>$grupo->grupo,
                    ));

                } else {


                    // dd(count($semana_corte_actual));
                    $corte_semana=$semana_corte_actual->last()->id_corte_semana;
                    $fecha_corte=$semana_corte_actual->last()->fecha_final;
                    $fecha_inicio=$semana_corte_actual->last()->fecha_inicio;

                    if (count($prestamos)==0) {
                        
                    } else {
    
                        foreach ($prestamos as $prestamo) {
    
                            $tipo_abono=0;
                            $cantidad_multa=0;
                            $ultima_semana=0;

                            
                            $producto=DB::table('tbl_productos')
                            ->select('tbl_productos.pago_semanal','tbl_productos.ultima_semana','tbl_productos.penalizacion')
                            ->where('id_producto','=',$prestamo->id_producto)
                            ->get();

                            $semana=DB::table('tbl_abonos')
                            ->select('tbl_abonos.semana')
                            ->where('id_prestamo','=',$prestamo->id_prestamo)
                            ->orderBy('semana','ASC')
                            ->get();

                            if (count($semana)==0) {

                                
                            } else {

                                $aplicar_multa='si';
                              
                                if ($semana->last()->semana==0) {
                                    $semana_siguiente=1;

                                    $buscar_si_esta_en_la_fechacorte=DB::table('tbl_abonos')
                                    ->select('tbl_abonos.semana','tbl_abonos.id_abono')
                                    ->where('id_prestamo','=',$prestamo->id_prestamo)
                                    ->where('semana','=',0)
                                    ->whereBetween('fecha_pago', [$fecha_inicio, $fecha_corte])
                                    ->get();

                                    if (count($buscar_si_esta_en_la_fechacorte)==0) {
                                        $aplicar_multa='si';
                                    } else {
                                        $aplicar_multa='no';
                                    }
                                    
                                } else {
                                    $semana_siguiente=$semana->last()->semana + 1;
                                }

                                // dd($prestamo->id_prestamo,$aplicar_multa);
                                if ($aplicar_multa=='si') {
                                    
                                    if (empty($producto[0]->ultima_semana)) {
                                        $ultima_semana=0;
                                    } else {
                                        $ultima_semana=$producto[0]->ultima_semana;
                                    }
                                    
            
                                    if ($prestamo->id_status_prestamo==9) {
                                        // Hacemos el proceso cuando el préstamo es de renovación
        
                                        $p_aprobados=DB::table('tbl_prestamos')
                                        ->select('tbl_prestamos.*')
                                        ->where('id_usuario','=',$prestamo->id_usuario)
                                        ->where('id_status_prestamo','=',10)
                                        ->get();
            
                                        if (count($p_aprobados)==0) {
                                            $total_clientes+=1;
                                            $corte_ideal = $prestamo->cantidad*($producto[0]->pago_semanal/100);
        
        
                                            $abonado=DB::table('tbl_abonos')
                                            ->select('tbl_abonos.*')
                                            ->where('id_prestamo','=',$prestamo->id_prestamo)
                                            ->where('id_corte_semana','=',$corte_semana)
                                            ->get();
            
                                            if (count($abonado)==0) {
                                                // Como no hay abonos con la fecha del corte entonces, 
                                                // preguntamos si hay penalizaciones
                                                $tipo_penalizacion=DB::table('tbl_penalizacion')
                                                ->select('tbl_penalizacion.*')
                                                ->where('id_prestamo','=',$prestamo->id_prestamo)
                                                ->get();
        
        
                                                if (empty($producto[0]->pago_semanal)) {
        
                                                    array_push($prestamos_sin_producto, array(
                                                        'id_prestamo' =>$prestamo->id_prestamo,
                                                        'id_grupo' => $grupo->id_grupo,
                                                        'grupo' =>$grupo->grupo,
                                                    ));
                                                    
                                                } else {
                                                    
        
        
                                                    // Contamos si hay penalizaciones
                                                    if (count($tipo_penalizacion)==0) {
                                                        // No hay penalizaciones, por lo tanto la multa será de Multa 1
        
                                                        if ($semana_siguiente>$ultima_semana) {
                                                            $tipo_abono=2;
                                                            $cantidad_multa = 0;
                                                        } else {
                                                            $tipo_abono=4;
                                                            $cantidad_multa = $prestamo->cantidad*($producto[0]->pago_semanal/100)+$producto[0]->penalizacion;
                                                        }
                                                        
                
                                                    } else {
                                                        // Hay multas, por lo tanto será de multa 2
        
                                                        if ($semana_siguiente>$ultima_semana) {
                                                            $tipo_abono=2;
                                                            $cantidad_multa = 0;
                                                        } else {
                                                            $tipo_abono=5;
                                                            $cantidad_multa=$producto[0]->penalizacion;
                                                        }
                                                        
                                                    }
        
                                                    // Agregamos a la lista la multa, porque no hay abonos con la fecha de corte
                                                    array_push($multas_por_grupo, array(
                                                        'id_prestamo' => $prestamo->id_prestamo,
                                                        'tipo_abono' => $tipo_abono,
                                                        'id_corte_semana' => $corte_semana,
                                                        'fecha_corte'=>$fecha_corte,
                                                        'grupo' => $grupo->grupo,
                                                        'cantidad_multa'=>$cantidad_multa,
                                                        'semana_siguiente'=>$semana_siguiente
                                                    ));
        
                                                }
                                                
                                                
            
                                            } else {
                                                
                                            }
                                        } else {
                                            # code...
                                        }
                                
                                    } else {
                                        $total_clientes+=1;
                                        $corte_ideal = $prestamo->cantidad*($producto[0]->pago_semanal/100);
                                    
                                        $abonado=DB::table('tbl_abonos')
                                        ->select('tbl_abonos.*')
                                        ->where('id_prestamo','=',$prestamo->id_prestamo)
                                        ->where('id_corte_semana','=',$corte_semana)
                                        ->get();
            
                                        if (count($abonado)==0) {
                                            
                                            // Como no hay abonos con la fecha del corte entonces, 
                                            // preguntamos si hay penalizaciones
                                            $tipo_penalizacion=DB::table('tbl_penalizacion')
                                            ->select('tbl_penalizacion.*')
                                            ->where('id_prestamo','=',$prestamo->id_prestamo)
                                            ->get();
            
                                            if (empty($producto[0]->pago_semanal)) {
                                                
                                                array_push($prestamos_sin_producto, array(
                                                    'id_prestamo' =>$prestamo->id_prestamo,
                                                    'id_grupo' => $grupo->id_grupo,
                                                    'grupo' =>$grupo->grupo,
                                                ));
        
                                                
                                            } else {
                                        
                                                // Contamos si hay penalizaciones
                                                if (count($tipo_penalizacion)==0) {
                                                    // No hay penalizaciones, por lo tanto la multa será de Multa 1
        
                                                    if ($semana_siguiente>$ultima_semana) {
                                                        $tipo_abono=2;
                                                        $cantidad_multa = 0;
                                                    } else {
                                                        $tipo_abono=4;
                                                        $cantidad_multa = $prestamo->cantidad*($producto[0]->pago_semanal/100)+$producto[0]->penalizacion;
                                                    }
        
                
                                                } else {
                                                    // Hay multas, por lo tanto será de multa 2
        
                                                    if ($semana_siguiente>$ultima_semana) {
                                                        $tipo_abono=2;
                                                        $cantidad_multa = 0;
                                                    } else {
                                                        $tipo_abono=5;
                                                        $cantidad_multa=$producto[0]->penalizacion;
                                                    }
        
                                                }
                                            
                                                // Agregamos a la lista la multa, porque no hay abonos con la fecha de corte
                                                array_push($multas_por_grupo, array(
                                                    'id_prestamo' => $prestamo->id_prestamo,
                                                    'tipo_abono' => $tipo_abono,
                                                    'id_corte_semana' => $corte_semana,
                                                    'fecha_corte'=>$fecha_corte,
                                                    'grupo' => $grupo->grupo,
                                                    'cantidad_multa'=>$cantidad_multa,
                                                    'semana_siguiente'=>$semana_siguiente
                                                    
                                                ));
                                                
                                            }
                                            
            
                                        } else {
                                            // dd('Si hay abonos '.json_encode($abonado));
                                        }
            
                                    }

                                } else {
                                    // dd('wao no se va aplicar multa');
                                }

                            }

                        }
                        
                    }

                    // Verificamos que el total de clientes activos no sea 0 
                    if ($total_clientes==0 && $corte_ideal==0) {
                        
                    } else {
                        array_push($grupos_corte, array(
                            'id_grupo' => $grupo->id_grupo,
                            'grupo' => $grupo->grupo,
                            'total_clientes' => $total_clientes,
                            'corte_ideal' => $corte_ideal,
                            'semana_siguiente' => $semana_siguiente
                        ));
                    }
                    

                }
                
                 
            }
            
            $multas_por_grupo=json_encode($multas_por_grupo);
            $multas_por_grupo=json_decode($multas_por_grupo);

            $grupos_sin_configuracion=json_encode($grupos_sin_configuracion);
            $grupos_sin_configuracion=json_decode($grupos_sin_configuracion);

            $prestamos_sin_producto=json_encode($prestamos_sin_producto);
            $prestamos_sin_producto=json_decode($prestamos_sin_producto);

            $grupos_corte=json_encode($grupos_corte);
            $grupos_corte=json_decode($grupos_corte);

            $multas_con_exito = array();

       

            // Aqui empieza la aplicación de multas
                if (count($multas_por_grupo)==0) {
                    // Si no hay multas no se hace nada
                } else {
                    // Si hay multas, entonces guardamos las multas
                    foreach ($multas_por_grupo as $multas_por_g) {
                        // Guardar las multas a la base de datos


                        $dato= new Abonos;
                        $dato->id_prestamo=$multas_por_g->id_prestamo;
                        $dato->semana =$multas_por_g->semana_siguiente;
                        $dato->cantidad =$multas_por_g->cantidad_multa;
                        $dato->fecha_pago =$fecha_hoy;
                        $dato->id_tipoabono = $multas_por_g->tipo_abono;
                        $dato->id_corte_semana = $multas_por_g->id_corte_semana;
                        $dato->save();
                        
                        $idA = Abonos::latest('id_abono')->first();
                        DB::table('tbl_log')->insert([
                            'id_log' => null, 
                            'id_tipo' => 1,
                            'id_plataforma' => 2,
                            'id_usuario' => '2743',
                            'id_tipo_movimiento' => 1,
                            'id_movimiento' =>  $idA->id_abono,
                            'descripcion' => "Se registró un abono",
                            'fecha_registro' => $fecha_hoy
                        ]);

                        if ($multas_por_g->tipo_abono==4) {
                                $idabono_ac = Abonos::latest('id_abono')->first();
                
                                $dato_pena= new Penalizacion;
                                $dato_pena->id_prestamo=$multas_por_g->id_prestamo;
                                $dato_pena->id_abono=$idabono_ac->id_abono;
                                $dato_pena->save();
                
                                $idP = Penalizacion::latest('id_penalizacion')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => '2743',
                                    'id_tipo_movimiento' => 8,
                                    'id_movimiento' =>  $idP->id_penalizacion,
                                    'descripcion' => "Se registró una penalización",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                        } elseif($multas_por_g->tipo_abono==5) {
                                $idabono_ac = Abonos::latest('id_abono')->first();
                
                                $dato_pena= new Penalizacion;
                                $dato_pena->id_prestamo=$multas_por_g->id_prestamo;
                                $dato_pena->id_abono=$idabono_ac->id_abono;
                                $dato_pena->save();
                
                                $idP = Penalizacion::latest('id_penalizacion')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => '2743',
                                    'id_tipo_movimiento' => 8,
                                    'id_movimiento' =>  $idP->id_penalizacion,
                                    'descripcion' => "Se registró una penalización",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                        } else {

                        }
                        
                        array_push($multas_con_exito, array(
                            'id_grupo' => $grupo->id_grupo,
                            'grupo' => $multas_por_g->grupo,
                            'id_prestamo' => $multas_por_g->id_prestamo,
                            'semana_siguiente' => $multas_por_g->semana_siguiente,
                            'mensaje' => 'Multa aplicado con éxito!'
                        ));


                    }
                }
            
            // Aqui termina la aplicación de multas

            // dd('Terminación de multas');




            // Aqui empieza el proceso de actualizar fechas de 
            
                // Actulizaremos el corte semana del grupo
                // Parametros a enviar id_grupo
             
                if (count($grupos_corte)==0) {
                    // Si no hay grupos para actualizar la fecha del corte no se hace nada
                } else {
                    foreach ($grupos_corte as $grupo_corte) {
                        
                        $ultimo_corte = DB::table('tbl_cortes_semanas')
                        ->where('id_grupo', $grupo_corte->id_grupo)
                        ->latest('fecha_final')
                        ->first(); // Buscamos el corte más actual
            
                        if (!empty($ultimo_corte)) {
            
                            //$array_data = array();
                            $nueva_fecha_inicio = date("Y-m-d",strtotime($ultimo_corte->fecha_final."+ 1 days")); 
                            $nueva_fecha_final = date("Y-m-d",strtotime($ultimo_corte->fecha_final."+ 1 week")); 
                            //$semana_ano = (int) date('W',strtotime($nueva_fecha_final)); // opcional
            
            
                            $date = explode("-", $ultimo_corte->fecha_final); // separamos la fecha del ultimo corte por año, mes y dia
                            $date2 = explode("-", $nueva_fecha_final); // separamos la fecha del ultimo corte por año, mes y dia
                            
                            if ($date2[0] > $date[0]) {
                                # Si la nueva fecha del corte es mayor en su año a la anterior se ejecuta la acción
            
                                $actualizar_corte = DB::table('tbl_cortes_semanas')->insertGetId([
                                    'id_corte_semana' => null, 
                                    'id_grupo' => $grupo_corte->id_grupo,
                                    'año' => ''.$date2[0],
                                    'fecha_inicio' => $nueva_fecha_inicio,
                                    'fecha_final' => $nueva_fecha_final,
                                    'numero_semana_corte' => 1,
                                    'corte_ideal' => $grupo_corte->corte_ideal,
                                    'total_clientes' => $grupo_corte->total_clientes
                                ]);
            
                                $corte_semana = DB::table('tbl_cortes_semanas')->where('id_grupo', $grupo_corte->id_grupo)
                                    ->orderByRaw('fecha_final DESC')->first();
            
                                $id_corte_semana = 0;
                                $fecha_corte = 'Sin fecha de corte';
            
                                if ($corte_semana != null) {
                                    $id_corte_semana = $corte_semana->id_corte_semana;
                                    $fecha_corte = date("d/m/Y", strtotime("{$corte_semana->fecha_inicio}")) . ' al '. date("d/m/Y", strtotime("{$corte_semana->fecha_final}"));
                                }
            
                                if ($actualizar_corte > 0) {
                                    // Log - Actualización Corte semana
                                    DB::table('tbl_log')->insert([
                                        'id_log' => null, 
                                        'id_tipo' => 1, // Registro
                                        'id_plataforma' => 1,
                                        'id_usuario' => '2743',
                                        'id_tipo_movimiento' => 37, // Conte semanal
                                        'id_movimiento' =>  "{$actualizar_corte}",
                                        'descripcion' => "Se ha generado el nuevo corte de la semana.",
                                        'fecha_registro' => $fecha_hoy
                                    ]);
            
                                    // return '{"status" : 100, "mensaje" : "Corte actualizado... el siguiente corte corresponde el '. $nueva_fecha_final .'", "numero_semana" : 1, "id_corte_semana" : "'.$id_corte_semana.'", "fecha_corte" : "'.$fecha_corte.'"}';
                                }
            
                                // return '{"status" : 200, "mensaje" : "Ocurrio un error durante el proceso de actualizacion"}';
                            }
            
                            $nuevo_numero_semana_corte = $ultimo_corte->numero_semana_corte + 1;
            
                            $actualizar_corte = DB::table('tbl_cortes_semanas')->insertGetId([
                                'id_corte_semana' => null, 
                                'id_grupo' => $grupo_corte->id_grupo,
                                'año' => ''.$date[0],
                                'fecha_inicio' => $nueva_fecha_inicio,
                                'fecha_final' => $nueva_fecha_final,
                                'numero_semana_corte' => $nuevo_numero_semana_corte,
                                'corte_ideal' => $grupo_corte->corte_ideal,
                                'total_clientes' => $grupo_corte->total_clientes
                            ]);
            
                            $corte_semana = DB::table('tbl_cortes_semanas')->where('id_grupo', $grupo_corte->id_grupo)
                                ->orderByRaw('fecha_final DESC')->first();
            
                            $id_corte_semana = 0;
                            $fecha_corte = 'Sin fecha de corte';
            
                            if ($corte_semana != null) {
                                $id_corte_semana = $corte_semana->id_corte_semana;
                                $fecha_corte = date("d/m/Y", strtotime("{$corte_semana->fecha_inicio}")) . ' al '. date("d/m/Y", strtotime("{$corte_semana->fecha_final}"));
                            }
            
                            if ($actualizar_corte > 0) {
                                // Log - Actualización Corte semana
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1, // Registro
                                    'id_plataforma' => 1,
                                    'id_usuario' => '2743',
                                    'id_tipo_movimiento' => 37, // Conte semanal
                                    'id_movimiento' =>  "{$actualizar_corte}",
                                    'descripcion' => "Se ha generado el nuevo corte de la semana.",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                                
                                // return '{"status" : 100, "mensaje" : "Corte actualizado... el siguiente corte corresponde el '. $nueva_fecha_final .'", "numero_semana" : '.$nuevo_numero_semana_corte.', "id_corte_semana" : "'.$id_corte_semana.'", "fecha_corte" : "'.$fecha_corte.'"}';
                            }
            
                            // return '{"status" : 200, "mensaje" : "Ocurrio un error durante el proceso de actualizacion"}';
                        }
                        // return '{"status" : 200, "mensaje" : "No se pudo generar el siguiente corte de la semana. Pida a un administrador que configure el corte semana de este grupo."}';
                    }
                    
                }

        
            // Aqui termina el proceso de actualizar fechas de cortes
        }
       
        // return 0;
    }
}
