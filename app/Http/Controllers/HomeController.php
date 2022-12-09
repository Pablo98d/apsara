<?php

namespace App\Http\Controllers;
use Http;
use GuzzleHttp\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Abonos;
use App\Penalizacion;
use App\Grupos;
use App\Plaza;
use App\Zona;
use App\Corte_fecha;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Collection;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','rol.admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $id_region_actual=\Cache::get('region');
        $id_ruta_actual=\Cache::get('ruta');

        

        // dd($id_region_actual);

        if ($id_region_actual==null) {
            $id_region_actual=0;
            $id_ruta_actual=0;
        } else {
            $id_region_actual=\Cache::get('region');
            $id_ruta_actual=\Cache::get('ruta');
        }
        

        $region=Plaza::find($id_region_actual);
        // dd($region);
        $zona = Zona::find($id_ruta_actual);
        
        $grupos = DB::table('tbl_plaza')
        ->Join('tbl_zona', 'tbl_plaza.IdPlaza', '=', 'tbl_zona.IdPlaza')
        ->Join('tbl_grupos', 'tbl_zona.IdZona', '=', 'tbl_grupos.IdZona')
        ->select('tbl_grupos.*','tbl_zona.Zona','tbl_zona.IdZona')
        ->where('tbl_plaza.IdPlaza','=',$id_region_actual)
        ->orderBy('tbl_grupos.grupo','ASC')
        ->distinct()
        ->get();

        // dd($grupos );
        
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region_actual)
        ->orderBy('Zona','ASC')
        ->get();
        
        $total_clientes = DB::table('tbl_datos_usuario')
        ->Join('tbl_usuarios', 'tbl_datos_usuario.id_usuario', '=', 'tbl_usuarios.id')
        ->Join('tbl_tipo_usuario', 'tbl_usuarios.id_tipo_usuario', '=', 'tbl_tipo_usuario.id_tipo_usuario')
        ->select('tbl_datos_usuario.*', 'tbl_usuarios.nombre_usuario','tbl_tipo_usuario.nombre as tipou')
        ->where('tbl_usuarios.id_tipo_usuario','=',3)
        ->count();
        
       
        return view('home',['region'=>$region,'zonas'=>$zonas,'zona'=>$zona,'grupos'=>$grupos,'total_clientes'=>$total_clientes]);
    }
    public function vista_estadisticas(){
        
        $fecha_actual=Carbon::now();

        // $ultimos_abonos = DB::table('v_estadisticas')
        // ->select('v_estadisticas.*')
        // ->get();

        $prestamos= DB::table('tbl_prestamos')
        ->select('tbl_prestamos.*')
        ->whereNotIn('id_status_prestamo', [8, 6])
        ->orderby('id_prestamo','ASC')
        ->get();

        $ultimos_abonos = array();
        if(count($prestamos)==0){

        } else {
            foreach ($prestamos as $prestamo) {

                $abono = DB::table('tbl_abonos')
                ->select('tbl_abonos.id_abono')
                ->where('id_prestamo','=',$prestamo->id_prestamo)
                ->orderby('semana','ASC')
                ->get();
                if(count($abono)==0){
                   
                } else {
                    array_push($ultimos_abonos, array(
                        'id_prestamo' => $prestamo->id_prestamo, 
                        'grupo' => $prestamo->id_grupo, 
                        'cantidad' => $prestamo->cantidad, 
                        'ultimo_abono' => $abono->last()->id_abono, 
                        'id_status_prestamo' => $prestamo->id_status_prestamo
                    ));
                }
                
            }
        }
        $ultimos_abonos=json_encode($ultimos_abonos);




        $prestamos_suma = DB::table('tbl_prestamos')
        ->select(DB::raw('SUM(cantidad) as total_prestamos'))
        ->get();

        $abonos_suma = DB::table('tbl_abonos')
        ->select(DB::raw('SUM(cantidad) as total_abonos'))
        ->whereBetween('id_tipoabono',[2,3])
        ->get();


        return view('home_estadisticas',['ultimos_abonos'=>$ultimos_abonos,'fecha_actual'=>$fecha_actual,'abonos_suma'=>$abonos_suma,'prestamos_suma'=>$prestamos_suma]);
    }
    public function pruebas(){
        // dd('es enserio que mes estas buscando');
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->get();
        $grupos = DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->get();
        $fecha_actual=Carbon::now();

        return view('prueba',['zonas'=>$zonas,'fecha_actual'=>$fecha_actual]);
    }

    public function reportes($id_grupo){
        // dd('khsdgcf');
        
        $fecha_actual=Carbon::now();
        $grupo=Grupos::find($id_grupo);

        $prestamos= DB::table('tbl_prestamos')
        ->select('tbl_prestamos.*')
        ->whereIn('id_status_prestamo', [2,3,4,5,9,18])
        // ->whereNotIn('id_status_prestamo', [8, 6])
        ->where('tbl_prestamos.id_grupo','=',$id_grupo)
        ->orderby('id_prestamo','ASC')
        ->get();

        $ultimos_abonos = array();
        if(count($prestamos)==0){

        } else {
            foreach ($prestamos as $prestamo) {

                $abono = DB::table('tbl_abonos')
                ->select('tbl_abonos.id_abono')
                ->where('id_prestamo','=',$prestamo->id_prestamo)
                ->orderby('semana','ASC')
                ->get();
                if(count($abono)==0){
                   
                } else {
                    array_push($ultimos_abonos, array(
                        'id_prestamo' => $prestamo->id_prestamo, 
                        'grupo' => $prestamo->id_grupo, 
                        'cantidad' => $prestamo->cantidad, 
                        'ultimo_abono' => $abono->last()->id_abono, 
                        'id_status_prestamo' => $prestamo->id_status_prestamo
                    ));
                }
                
            }
        }
        $ultimos_abonos=json_encode($ultimos_abonos);

        $prestamos_suma = DB::table('tbl_prestamos')
        ->select(DB::raw('SUM(cantidad) as total_prestamos'))
        ->where('id_grupo','=',$id_grupo)
        ->whereIn('id_status_prestamo', [2,3,4,5,9,8])
        ->get();
        

        $abonos_suma = DB::table('tbl_abonos')
        ->join('tbl_prestamos','tbl_abonos.id_prestamo','tbl_prestamos.id_prestamo')
        ->select(DB::raw('SUM(tbl_abonos.cantidad) as total_abonos'))
        // ->select('tbl_abonos.*')
        ->whereBetween('tbl_abonos.id_tipoabono',[2,3])
        ->where('tbl_prestamos.id_grupo','=',$id_grupo)
        ->whereIn('tbl_prestamos.id_status_prestamo', [2,3,4,5,9,8])
        ->get();


        $abonos_suma_ajuste = DB::table('tbl_abonos')
        ->join('tbl_prestamos','tbl_abonos.id_prestamo','tbl_prestamos.id_prestamo')
        ->select(DB::raw('SUM(tbl_abonos.cantidad) as total_abonos_ajuste'))
        ->whereIn('tbl_abonos.id_tipoabono',[6])
        ->where('tbl_prestamos.id_grupo','=',$id_grupo)
        ->whereIn('tbl_prestamos.id_status_prestamo', [2,3,4,5,9,8])
        ->get();


        $abonos_total=$abonos_suma[0]->total_abonos-$abonos_suma_ajuste[0]->total_abonos_ajuste;


        // $pdf->load_html(utf8_decode($html));
        $pdf = PDF::loadView('reportes_grupos',['ultimos_abonos'=>$ultimos_abonos,'fecha_actual'=>$fecha_actual,'prestamos_suma'=>$prestamos_suma,'abonos_total'=>$abonos_total,'grupo'=>$grupo]);

        return $pdf->stream();
    }

    public function hacer_corte(){
        // dd('estamos haciendo pruebas');
        $fecha_actual=Carbon::now();
        $fec= $fecha_actual->format('D');
        $hora= $fecha_actual->format('H:i');
        $date=Carbon::now();
        $ayer=$date->subDay();
        $hoy= $ayer->format('Y-m-d');

//         dd($hoy);
// // dd($fec);

        if ($fec=='Mon') {
            $dia='Domingo';
        } elseif($fec=='Tue') {
            $dia='Lunes';
        } elseif($fec=='Wed') {
            $dia='Martes';
        } elseif($fec=='Thu') {
            $dia='Miercoles';
        } elseif($fec=='Fri') {
            $dia='Jueves';
        } elseif($fec=='Sat') {
            $dia='Viernes';
        } elseif($fec=='Sun') {
            $dia='Sabado';
        }
        

        // dd($dia);

       $corte = DB::table('tbl_corte')
       ->select('tbl_corte.*')
       ->where('nombre_dia','=',$dia)
       ->get();

       if (count($corte)==0){
                // {{-- return back()->with('status', '¡No hay corte para este dia!'); --}}
                return back()->with('status', '¡No hay corte para este dia!');
       } 
        else{
                
                foreach ($corte as $cor) {
                    
                    if ($hora>=$cor->hora){
                            // dd($cor->hora,$cor->nombre_dia);
                        // dd('ya es hora');
                        $ultimos_abonoac = DB::table('v_estadisticas')
                        ->select('v_estadisticas.*')
                        ->where('grupo','=',$cor->id_grupo)
                        ->get();

                        // return view('prueba_de_corte',['ultimos_abono'=>$ultimos_abono]);
                        foreach ($ultimos_abonoac as $value){
                            
                            $prestamo_activo = DB::table('tbl_prestamos')
                            ->join('tbl_abonos','tbl_prestamos.id_prestamo','tbl_abonos.id_prestamo')
                            ->select('tbl_prestamos.*','tbl_abonos.*')
                            ->where('tbl_abonos.id_abono','=',$value->ultimo_abono)
                            ->where('tbl_prestamos.id_status_prestamo','=',2)
                            ->get();
                            if (count($prestamo_activo)==0){

                                // dd('no hay datos');
                                
                            } else{

                                foreach ($prestamo_activo as $p_activo){
                                    $fecha_a_existente = $p_activo->fecha_pago;
                                    $array = str_split($fecha_a_existente);
                                    $fecha_listo = $array[0].$array[1].$array[2].$array[3].$array[4].$array[5].$array[6].$array[7].$array[8].$array[9];

                                    // dd($fecha_listo,$hoy,$p_activo->id_prestamo,$hora);
                                    if ($fecha_listo==$hoy){
                                        // dd('ya abonaron');
                                    } else{
                                        // dd('creo que se merecen una multa');

                                        $producto = DB::table('tbl_productos')
                                        ->select('tbl_productos.ultima_semana')
                                        ->where('id_producto','=',$p_activo->id_producto)
                                        ->get();

                                        $semana=$p_activo->semana+1;

                                        $multas = DB::table('tbl_penalizacion')
                                        ->select('tbl_penalizacion.*')
                                        ->where('id_prestamo','=',$p_activo->id_prestamo)
                                        ->get();

                                        if ($semana>$producto[0]->ultima_semana) {

                                            $dato= new Abonos;
                                            $dato->id_prestamo=$p_activo->id_prestamo;
                                            $dato->semana =$semana;
                                            $dato->cantidad ='0';
                                            $dato->fecha_pago =$hoy.' '.$hora.':00';
                                            $dato->id_tipoabono = '2';
                                            $dato->save();
                                            // return back()->with('status', '¡Abono agregado con éxito!');
                    
                                        } else {
                                            if (count($multas)==0) {
                                                $dato= new Abonos;
                                                $dato->id_prestamo=$p_activo->id_prestamo;
                                                $dato->semana =$semana;
                                                $dato->cantidad ='0';
                                                $dato->fecha_pago =$hoy.' '.$hora.':00';
                                                $dato->id_tipoabono = '4';
                                                $dato->save();

                                                $idabono_ac = Abonos::latest('id_abono')->first();
            
                                                $dato_pena= new Penalizacion;
                                                $dato_pena->id_prestamo=$p_activo->id_prestamo;
                                                $dato_pena->id_abono=$idabono_ac->id_abono;
                                                $dato_pena->save();

                                            } else {
                                                $dato= new Abonos;
                                                $dato->id_prestamo=$p_activo->id_prestamo;
                                                $dato->semana =$semana;
                                                $dato->cantidad ='0';
                                                $dato->fecha_pago =$hoy.' '.$hora.':00';
                                                $dato->id_tipoabono = '5';
                                                $dato->save();

                                                $idabono_ac = Abonos::latest('id_abono')->first();
            
                                                $dato_pena= new Penalizacion;
                                                $dato_pena->id_prestamo=$p_activo->id_prestamo;
                                                $dato_pena->id_abono=$idabono_ac->id_abono;
                                                $dato_pena->save();
                                            }
                                            
                                        }

                                    }
                                    
                                }
                            }

                        }

                        $ultimos_abonore = DB::table('v_estadisticas')
                        ->select('v_estadisticas.*')
                        ->where('grupo','=',$cor->id_grupo)
                        ->get();


                        foreach ($ultimos_abonore as $value){
                            // aqui empieza los de renovados
                            $prestamo_renovados = DB::table('tbl_prestamos')
                            ->join('tbl_abonos','tbl_prestamos.id_prestamo','tbl_abonos.id_prestamo')
                            ->select('tbl_prestamos.*','tbl_abonos.*')
                            ->where('tbl_abonos.id_abono','=',$value->ultimo_abono)
                            ->where('tbl_prestamos.id_status_prestamo','=',9)
                            ->get();

                            if (count($prestamo_renovados)==0){
                                // <label for="">no hay datos prestamos renovados</label><br>
                            } else {
                                foreach ($prestamo_renovados as $prestamo_r) {

                                    $fecha_a_existente = $prestamo_r->fecha_pago;
                                    $array = str_split($fecha_a_existente);
                                    $fecha_listo = $array[0].$array[1].$array[2].$array[3].$array[4].$array[5].$array[6].$array[7].$array[8].$array[9];

                                    // dd($fecha_listo,$hoy,$p_activo->id_prestamo,$hora);
                                    if ($fecha_listo==$hoy){
                                        // dd('ya abonaron');
                                    } else{

                                        $prestamo_en_espera = DB::table('tbl_prestamos')
                                        ->select('tbl_prestamos.*')
                                        ->where('id_usuario','=',$prestamo_r->id_usuario)
                                        ->whereBetween('tbl_prestamos.id_status_prestamo', [9, 10])
                                        ->distinct()
                                        ->get();
                                        $pr=count($prestamo_en_espera);
                                        if ($pr>=2){
                                            // <label for="">total es {{$pr}} {{$prestamo_r->id_prestamo}}</label> <br>
                                        } elseif($pr==1){
                                                $pr_status=$prestamo_en_espera[0]->id_status_prestamo;

                                            if ($pr_status==9) {
                                                // <label for="">es igual a uno {{$pr_status}}=renovacion y  {{$prestamo_r->id_prestamo}}</label><br>


                                                // {{-- aqui es donde se genera una multa --}}
                                                $productor = DB::table('tbl_productos')
                                                ->select('tbl_productos.ultima_semana')
                                                ->where('id_producto','=',$prestamo_r->id_producto)
                                                ->get();
                                                

                                                $semanr=$prestamo_r->semana+1;


                                                $multasr = DB::table('tbl_penalizacion')
                                                ->select('tbl_penalizacion.*')
                                                ->where('id_prestamo','=',$prestamo_r->id_prestamo)
                                                ->get();

                                                if ($semanr>$productor[0]->ultima_semana) {


                                                    $dato= new Abonos;
                                                    $dato->id_prestamo=$prestamo_r->id_prestamo;
                                                    $dato->semana =$semanr;
                                                    $dato->cantidad ='0';
                                                    $dato->fecha_pago =$hoy.' '.$hora.':00';
                                                    $dato->id_tipoabono = '2';
                                                    $dato->save();
                                                    // return back()->with('status', '¡Abono agregado con éxito!');
                            
                                                } else {
                                                    if (count($multasr)==0) {
                                                        $dato= new Abonos;
                                                        $dato->id_prestamo=$prestamo_r->id_prestamo;
                                                        $dato->semana =$semanr;
                                                        $dato->cantidad ='0';
                                                        $dato->fecha_pago =$hoy.' '.$hora.':00';
                                                        $dato->id_tipoabono = '4';
                                                        $dato->save();

                                                        $idabono_acr = Abonos::latest('id_abono')->first();
                    
                                                        $dato_pena= new Penalizacion;
                                                        $dato_pena->id_prestamo=$prestamo_r->id_prestamo;
                                                        $dato_pena->id_abono=$idabono_acr->id_abono;
                                                        $dato_pena->save();

                                                    } else {
                                                        $dato= new Abonos;
                                                        $dato->id_prestamo=$prestamo_r->id_prestamo;
                                                        $dato->semana =$semanar;
                                                        $dato->cantidad ='0';
                                                        $dato->fecha_pago =$hoy.' '.$hora.':00';
                                                        $dato->id_tipoabono = '5';
                                                        $dato->save();

                                                        $idabono_acr = Abonos::latest('id_abono')->first();
                    
                                                        $dato_pena= new Penalizacion;
                                                        $dato_pena->id_prestamo=$prestamo_r->id_prestamo;
                                                        $dato_pena->id_abono=$idabono_acr->id_abono;
                                                        $dato_pena->save();
                                                    }
                                                    
                                                }

                                            } else {
                                                // <label for="">no es igual</label><br>
                                            }
                                            
                                        }
                                    }
                                }
                            }

                        }

                        // aqui termina el primer grupo

                    } else{
                        // return back()->with('status', '¡aun no es la hora!');
                    }
                }

                return back()->with('status', '¡Operacion se ejecutó con éxito!');
        }

       
    }

    public function prueba_corte_varios_dias(){
         // dd('estamos haciendo pruebas');
         $fecha_actual=Carbon::now();
         $fec= $fecha_actual->format('D');
         $hora= $fecha_actual->format('H:i');
         $date=Carbon::now();
         $ayer=$date->subDay();
         $hoy= $ayer->format('Y-m-d');

 
         if ($fec=='Mon') {
            //  lunes
            $dias_anterior = collect(['dia1' => 'Domingo']);
            
         } elseif($fec=='Tue') {
            //  martes
            $dias_anterior = collect(['dia1' => 'Lunes','dia2' => 'Domingo']);
            
         } elseif($fec=='Wed') {
            //  miercoles
            $dias_anterior = collect(['dia1' => 'Martes','dia2' => 'Lunes','dia3' => 'Domingo']);
            
         } elseif($fec=='Thu') {
            //  jueves
            $dias_anterior = collect(['dia1' =>'Miercoles','dia2' => 'Martes','dia3' => 'Lunes','dia4' => 'Domingo']);
            
         } elseif($fec=='Fri') {
            //  viernes
            $dias_anterior = collect(['dia1' => 'Jueves','dia2' => 'Miercoles','dia3' => 'Martes','dia4' => 'Lunes','dia5' => 'Domingo']);
       
         } elseif($fec=='Sat') {
            //  sabado
            $dias_anterior = collect(['dia1' => 'Viernes','dia2' => 'Jueves','dia3' => 'Miercoles','dia4' => 'Martes','dia5' => 'Lunes','dia6' => 'Domingo']);
    
         } elseif($fec=='Sun') {
            //  domingo
            $dias_anterior = collect(['dia1' => 'Sabado','dia2' => 'Viernes','dia3' => 'Jueves','dia4' => 'Miercoles','dia5' => 'Martes','dia6' => 'Lunes','dia7' => 'Domingo']);

         }

         
        $dias_corte= collect($dias_anterior);
        // dd($dias_corte);
        $f_actual=Carbon::now();
        

        return view('admin.corte_grupos.vista_previa_grupos',['fec'=>$fec,'dias_corte'=>$dias_corte,'f_actual'=>$f_actual,'hora'=>$hora]);
    }


    public function fechas_corte(){

        $fecha_corte = DB::table('tbl_corte')
        ->join('tbl_grupos','tbl_corte.id_grupo','tbl_grupos.id_grupo')
        ->select('tbl_corte.*','tbl_grupos.*')
        ->orderBy('tbl_grupos.grupo','ASC')
        ->get();

        $grupos = DB::table('tbl_grupos')
        // ->join('tbl_corte','tbl_grupos.id_grupo','tbl_corte.id_grupo')
           ->whereNotExists(function ($query) {
               $query->select(DB::raw(1))
                     ->from('tbl_corte')
                     ->whereRaw('tbl_corte.id_grupo = tbl_grupos.id_grupo');
           })
           ->orderBy('tbl_grupos.grupo','ASC')
           ->get();

        return view('prueba_de_corte',['fecha_corte'=>$fecha_corte,'grupos'=>$grupos]);
    }

    public function corte_editar($id_corte){

        $fecha_corte = Corte_fecha::find($id_corte);

        $grupos = DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->orderBy('grupo','ASC')
        ->get();

           return view('edit_corte',['fecha_corte'=>$fecha_corte,'grupos'=>$grupos]);
    }

    public function corte_store(Request $request){
        $corte = Corte_fecha::create([
            'id_grupo'    => $request->id_grupo,
            'nombre_dia'  => $request->nombre_dia,
            'hora'        => $request->hora
        ])->save();

        return back()->with('status', '¡Fecha de corte guardado con éxito!');
    }

    public function corte_update($id_corte){

            $datosAc=request()->except(['_token','_method']);
            Corte_fecha::where('id_corte','=',$id_corte)->update($datosAc);
            return redirect()->to('fecha-de-corte')->with('status', '¡Fecha de corte actualizado con éxito!');
    }
    public function corte_delete($id_corte){
        
        Corte_fecha::destroy($id_corte);
        return back()->with('status', '¡Registro eliminado con éxito!');
    }

    public function corte_mes(){
        $fecha_actual=Carbon::now();
        $fecha_de_hoy=Carbon::now();
         $fec= $fecha_actual->format('D');
         $hora= $fecha_actual->format('H:i');
         $date=Carbon::now();
         $ayer=$date->subDay();
         $hoy= $ayer->format('Y-m-d');

 
         if ($fec=='Mon') {
            //  lunes
            // $dias_anterior = collect(['dia1' => 'Domingo']);
            $dias_anterior = collect(['dia1' => 'Sabado','dia2' => 'Viernes','dia3' => 'Jueves','dia4' => 'Miercoles','dia5' => 'Martes','dia6' => 'Lunes','dia7' => 'Domingo']);


            
         } elseif($fec=='Tue') {
            //  martes
            // $dias_anterior = collect(['dia1' => 'Sabado','dia2' => 'Viernes','dia3' => 'Jueves','dia4' => 'Miercoles','dia5' => 'Martes','dia6' => 'Lunes','dia7' => 'Domingo']);
            
            
            $dias_anterior = collect(['dia1' => 'Lunes','dia2' => 'Domingo']);
            
         } elseif($fec=='Wed') {
            //  miercoles
            $dias_anterior = collect(['dia1' => 'Martes','dia2' => 'Lunes','dia3' => 'Domingo']);
            
         } elseif($fec=='Thu') {
            //  jueves
            $dias_anterior = collect(['dia1' =>'Miercoles','dia2' => 'Martes','dia3' => 'Lunes','dia4' => 'Domingo']);
            
         } elseif($fec=='Fri') {
            //  viernes
            $dias_anterior = collect(['dia1' => 'Jueves','dia2' => 'Miercoles','dia3' => 'Martes','dia4' => 'Lunes','dia5' => 'Domingo']);
       
         } elseif($fec=='Sat') {
            //  sabado
            $dias_anterior = collect(['dia1' => 'Viernes','dia2' => 'Jueves','dia3' => 'Miercoles','dia4' => 'Martes','dia5' => 'Lunes','dia6' => 'Domingo']);
    
         } elseif($fec=='Sun') {
            //  domingo
            $dias_anterior = collect(['dia1' => 'Sabado','dia2' => 'Viernes','dia3' => 'Jueves','dia4' => 'Miercoles','dia5' => 'Martes','dia6' => 'Lunes','dia7' => 'Domingo']);

         }

         
        $dias_corte= collect($dias_anterior);
        // dd($dias_corte);
        $f_actual=Carbon::now();
        // dd($f_actual);
        $cant_dias=count($dias_anterior);
        
        // dd('hola estamos en pruebas');
        return view('admin.corte_grupos.corte_por_mes',['fec'=>$fec,'dias_corte'=>$dias_corte,'f_actual'=>$f_actual,'hora'=>$hora,'cant_dias'=>$cant_dias,'fecha_de_hoy'=>$fecha_de_hoy]);

    }

    public function guardar_multas(Request $request){

        $input=$request->all();
        dd($input);
        dd('Falta hacer pruebas, porfavor avisame si esta listo para hacer la prueba del corte');
            foreach ($input["id_prestamo"] as $key => $value) {

                $id_prestamo=$value;
                dd($id_prestamo);
                $semana=$input["semana"][$key];
                $fecha_pago=$input["fecha_pago"][$key];
                $cantidad='0';
                $t_abono=$input["id_tipoabono"][$key];


                $producto = DB::table('tbl_prestamos')
                ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                ->select('tbl_productos.ultima_semana')
                ->where('tbl_prestamos.id_prestamo','=',$id_prestamo)
                ->get();

                $ultima_semana=$producto[0]->ultima_semana;
                dd($ultima_semana);

                // dd($t_abono,$ultima_semana,$semana);
                if ($t_abono=='4') {

                    $dato= new Abonos;
                    $dato->id_prestamo=$id_prestamo;
                    $dato->semana =$semana;
                    $dato->cantidad ='0';
                    $dato->fecha_pago =$fecha_pago;
                    $dato->id_tipoabono = '4';
                    $dato->save();
                    
                    $idabono_ac = Abonos::latest('id_abono')->first();
    
                    $dato_pena= new Penalizacion;
                    $dato_pena->id_prestamo=$id_prestamo;
                    $dato_pena->id_abono=$idabono_ac->id_abono;
                    $dato_pena->save();

                } elseif($t_abono=='5'){

                    $dato= new Abonos;
                    $dato->id_prestamo=$id_prestamo;
                    $dato->semana =$semana;
                    $dato->cantidad ='0';
                    $dato->fecha_pago =$fecha_pago;
                    $dato->id_tipoabono = '5';
                    $dato->save();
                    
                    $idabono_ac = Abonos::latest('id_abono')->first();
    
                    $dato_pena= new Penalizacion;
                    $dato_pena->id_prestamo=$id_prestamo;
                    $dato_pena->id_abono=$idabono_ac->id_abono;
                    $dato_pena->save();
                    
                } elseif($t_abono=='2') {

                    $dato= new Abonos;
                    $dato->id_prestamo=$id_prestamo;
                    $dato->semana =$semana;
                    $dato->cantidad ='0';
                    $dato->fecha_pago =$fecha_pago;
                    $dato->id_tipoabono = '2';
                    $dato->save();

                }
            }

        return back()->with('status', '¡Corte realizado con éxito!');
    }

    public function mapa_calor(){


        $prestamos = DB::table('tbl_prestamos')
        ->join('tbl_abonos','tbl_prestamos.id_prestamo','tbl_abonos.id_prestamo')
        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select(DB::raw('count(*) as total_m ,tbl_datos_usuario.id_usuario as idus, tbl_prestamos.id_prestamo as id_prestamo, tbl_datos_usuario.nombre as nombre, tbl_datos_usuario.latitud as latitud, tbl_datos_usuario.longitud as longitud '))
        ->whereIn('tbl_abonos.id_tipoabono', [4, 5])
        ->groupBy('tbl_datos_usuario.id_usuario','tbl_prestamos.id_prestamo','tbl_datos_usuario.nombre','tbl_datos_usuario.latitud','tbl_datos_usuario.longitud')
        ->get();

        $pretsamos_todo_bien = DB::table('tbl_prestamos')
        ->join('tbl_abonos','tbl_prestamos.id_prestamo','tbl_abonos.id_prestamo')
        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_prestamos.id_status_prestamo as estatus','tbl_datos_usuario.id_usuario as idur','tbl_prestamos.id_prestamo as id_prestamo','tbl_datos_usuario.nombre as nombre','tbl_datos_usuario.latitud as latitud', 'tbl_datos_usuario.longitud as longitud')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                    ->from('tbl_penalizacion')
                    ->whereRaw('tbl_penalizacion.id_prestamo = tbl_prestamos.id_prestamo');
        })
        ->whereIn('tbl_prestamos.id_status_prestamo',[2,9])
        // ->where('tbl_abonos.semana','>=',1)
        ->groupBy('tbl_prestamos.id_status_prestamo','tbl_datos_usuario.id_usuario','tbl_prestamos.id_prestamo','tbl_datos_usuario.nombre','tbl_datos_usuario.latitud','tbl_datos_usuario.longitud')
        ->get();

        

        // dd($pretsamos_reno);
        // $collection = collect([]);
        //     foreach ($pretsamos_reno as $pretsamos_r) {
        //         $p_aprobado=DB::table('tbl_prestamos')
        //         ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
        //         ->select('tbl_prestamos.*','tbl_productos.*')
        //         ->where('tbl_prestamos.id_usuario','=',$pretsamos_r->id_usuario)
        //         ->whereBetween('tbl_prestamos.id_status_prestamo', [9, 10])
        //         ->get();

        //         if (count($p_aprobado)==1) {


        //             $collection[] = $pretsamos_r->id_prestamo;

        //         } else {
        //             # code...
        //         }
                
        //     }
        
        // dd($collection);

        
    

        return view('admin.corte_grupos.vista_mapa_calor',['prestamos'=>$prestamos,'pretsamos_todo_bien'=>$pretsamos_todo_bien]);
    }

    public function ubicacion_gerente_zona(Request $request){
        // dd($request->all());
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.indacar.io/',
            'timeout'  => 9.0,
        ]);
    
        $response = $client->post('https://api.indacar.io/api/auth/login/web',[

            'form_params'=>
            [
                'email'=>$request->email,
                'password'=>$request->password
            ]
        ]);
            
        $respuesta =json_decode( $response->getBody()->getContents());

        // dd($respuesta);

        
        
        return view('ubicacion_zona_gerente',['respuesta'=>$respuesta]);
    }

    public function buscar_autos(Request $request){
        
        // $token=$token;
        return view('monitor',['token'=>$request->token]);

    }
    public function buscar_autos_prueba(Request $request){
        return view('prueba_monitoreo',['token'=>$request->token]);
    }
    
    public function configuracion_corte_semana(Request $request,$idregion,$idzona,$idgrupo){
        
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        
        if (empty($request->link)) {
            $link=0;
        } else {
            $link=$request->link;
        }

        if ($idgrupo==0) {
            $idgrupo=$request->id_grupo;
        } else {
            $idgrupo=$idgrupo;
            // dd('no es cero jajaj');
        }
        
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$idregion)
        ->orderBy('Zona','ASC')
        ->get();

        $grupo= Grupos::find($idgrupo);
        $grupos = DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->where('IdZona','=',$idzona)
        ->orderBy('grupo','ASC')
        ->get();
        
        
        $cortes_semana = DB::table('tbl_cortes_semanas')
        ->join('tbl_grupos','tbl_cortes_semanas.id_grupo','tbl_grupos.id_grupo')
        ->select('tbl_cortes_semanas.*','tbl_grupos.grupo')
        ->where('tbl_cortes_semanas.id_grupo','=',$idgrupo)
        ->orderBy('tbl_cortes_semanas.fecha_final','DESC')
        ->get();
        
        
        
        return view('configuracion_corte_semana',['link'=>$link,'cortes_semana'=>$cortes_semana,'id_grupo'=>$idgrupo,'grupos'=>$grupos,'grupo'=>$grupo,'region'=>$region,'zona'=>$zona,'zonas'=>$zonas]);
    }
    
    public function guardar_corte_semana(Request $request){
        // dd($request->all());
        $fecha_fin=$request->fecha_final;
        $paramFecha = explode("/",$fecha_fin);
        $fecha_final=$paramFecha[2].'-'.$paramFecha[1].'-'.$paramFecha[0];
        // dd($fecha_final);

        $fecha_actual=Carbon::now();
        $anio= $fecha_actual->format('Y');
        $diaSemana = date("w");
        $semana = date("W",strtotime($fecha_actual));
        // dd($semana);
        // dd(Auth::user()->id);
        $id_corte_semana = DB::table('tbl_cortes_semanas')->insertGetId([
                'id_corte_semana' => null, 
                'id_grupo' => $request->id_grupo,
                'año' => $anio,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_final' => $fecha_final,
                'numero_semana_corte' => $semana,
                'corte_ideal' => $request->corte_ideal,
                'total_clientes' => $request->total_clientes,
                
            ]);
            $registromovomiento=DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 1,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 37,
                'id_movimiento' => $id_corte_semana,
                'descripcion' => "Se registró una fecha de corte semanal",
                'fecha_registro' => $fecha_actual,
            ]);
            return back()->with('status', '¡Fecha de corte registrado con éxito!');
    }

    public function edit_corte_semana(Request $request,$id_corte_semana){
        $id_region_actual=\Cache::get('region');
        $id_ruta_actual=\Cache::get('ruta');

        
        if ($id_region_actual==null) {
            $id_region_actual=0;
            $id_ruta_actual=0;
        } else {
            $id_region_actual=\Cache::get('region');
            $id_ruta_actual=\Cache::get('ruta');
        }
        

        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region_actual)
        ->orderBy('Zona','ASC')
        ->get();

        $zona = Zona::find($id_region_actual);
        
        if (empty($request->link)) {
            $link=0;
        } else {
            $link=$request->link;
            
        }
        
        if ($id_corte_semana==0) {
            $vista_editar='nuevo';
        } else {
            $vista_editar='editar';
        }
        // dd($vista_editar);
        if (empty($request->id_grupo)) {
            $grupo= Grupos::find(0);
        } else {
            $grupo= Grupos::find($request->id_grupo);
        }
        
        
       
        

        $corte_semana = DB::table('tbl_cortes_semanas')
        ->join('tbl_grupos','tbl_cortes_semanas.id_grupo','tbl_grupos.id_grupo')
        ->select('tbl_cortes_semanas.*','tbl_grupos.grupo')
        ->where('tbl_cortes_semanas.id_corte_semana','=',$id_corte_semana)
        ->get();
        // dd($vista_editar,$corte_semana);

        return view('configuracion_corte_semana',['link'=>$link,'vista_editar'=>$vista_editar,'corte_semana'=>$corte_semana,'zonas'=>$zonas,'zona'=>$zona,'grupo'=>$grupo]);
       
    }

    public function update_corte_semana(Request $request){

        // dd($request->all());
        $fecha_ini=$request->fecha_inicio;
        $paramFechaini = explode("-",$fecha_ini);
        $anio=$paramFechaini[0];

        // dd($request->all(),$anio);
        $fecha_fin=$request->fecha_final;
        $paramFecha = explode("/",$fecha_fin);
        $fecha_final=$paramFecha[2].'-'.$paramFecha[1].'-'.$paramFecha[0];

        $fecha_actual=Carbon::now();
        
        $corte_semana = DB::table('tbl_cortes_semanas')
              ->where('id_corte_semana', $request->id_corte_semana)
              ->update([
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_final' => $fecha_final,
                'numero_semana_corte' => $request->numero_semana_corte,
                'corte_ideal' => $request->corte_ideal,
                'total_clientes' => $request->total_clientes,
                'año' =>$anio
                
            ]);
            $registromovomiento=DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 2,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 37,
                'id_movimiento' => $request->id_corte_semana,
                'descripcion' => "Se actualizó una fecha de corte semanal",
                'fecha_registro' => $fecha_actual,
            ]);

        return back()->with('status', '¡Fecha de corte actualizado con éxito!');
    }

    public function delete_corte_semana($id_corte_semana){

        
        $fecha_hoy=Carbon::now(); 
        DB::table('tbl_cortes_semanas')->where('id_corte_semana', '=',$id_corte_semana)->delete();

        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 37,
            'id_movimiento' =>  $id_corte_semana,
            'descripcion' => "Se eliminó una fecha de corte semanal",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Fecha  corte semana, se eliminó con éxito!');
    }

    public function pdf_estadisticas_general(){
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->get();
        $grupos = DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->get();
        $fecha_actual=Carbon::now();
        

        $pdf = PDF::loadView('home_estadisticas.estadisticas_general',['zonas'=>$zonas,'grupos'=>$grupos,'fecha_actual'=>$fecha_actual]);

        return $pdf->stream();
    }

    public function cambiar_corte_abono($id_corte_semana){

        $region_zona_grupo = DB::table('tbl_abonos')
        ->join('tbl_prestamos','tbl_abonos.id_prestamo','tbl_prestamos.id_prestamo')
        ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
        ->join('tbl_zona','tbl_grupos.IdZona','tbl_zona.IdZona')
        ->join('tbl_plaza','tbl_zona.IdPlaza','tbl_plaza.IdPlaza')
        ->select('tbl_plaza.Plaza','tbl_plaza.IdPlaza','tbl_zona.Zona','tbl_zona.IdZona','tbl_grupos.grupo','tbl_grupos.id_grupo')
        ->where('tbl_abonos.id_corte_semana','=',$id_corte_semana)
        ->distinct()
        ->get();

        $abonos_corte = DB::table('tbl_abonos')
        ->join('tbl_prestamos','tbl_abonos.id_prestamo','tbl_prestamos.id_prestamo')
        ->join('tbl_datos_usuario','tbl_prestamos.id_usuario','tbl_datos_usuario.id_usuario')
        ->join('tbl_tipoabono','tbl_abonos.id_tipoabono','tbl_tipoabono.id_tipoabono')
        ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
        
        ->select('tbl_abonos.*','tbl_prestamos.id_grupo','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_tipoabono.tipoAbono','tbl_grupos.grupo')
        // ->where('tbl_cortes_semanas.id_grupo','=',$idgrupo)
        ->where('tbl_abonos.id_corte_semana','=',$id_corte_semana)
        ->orderBy('tbl_abonos.id_corte_semana','DESC')
        ->get();

        // dd($abonos_corte);



        return view('admin.abonos.cambiar_fecha_corte',['abonos_corte'=>$abonos_corte,'region_zona_grupo'=>$region_zona_grupo]);
        
    }
    
    public function guardar_cambios_fecha_corte(Request $request){
        
        $fecha_hoy=Carbon::now(); 
        $input = $request->all();
        // dd($input);


        if (empty($request->id_abono)) {
            return back()->with('error', '¡No hay abonos para actualizar fechas de corte!');
        } else {
            foreach ($input["id_abono"] as $key => $value) {
                $id_abono_cambiar=$value;
                $nueva_fecha_corte=$input["nueva_fecha_corte"][$key];

                if($nueva_fecha_corte==null){
                } else {

                    Abonos::where('id_abono','=',$id_abono_cambiar)->update([
                        'id_corte_semana'   => $nueva_fecha_corte
                    ]);
                    
                    DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 2,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 1,
                        'id_movimiento' =>  $id_abono_cambiar,
                        'descripcion' => "Se actualizó la fecha de corte de abono",
                        'fecha_registro' => $fecha_hoy
                    ]);
                }
                
            }
            return back()->with('status', '¡Fechas de corte de los abonos se actualizaron con éxito!');
        }
    }

    public function buscar_fecha_corte(Request $request){
        $fecha_buscar1=$request->fecha_inicio;
        $fecha_buscar2=$request->fecha_final;


        
        $fechas_corte=DB::table('tbl_cortes_semanas')
        ->select('tbl_cortes_semanas.*')
        ->where('id_grupo','=',$request->id_grupo)
        ->whereBetween('fecha_final', [$fecha_buscar1, $fecha_buscar2])
        ->get();



        echo json_encode($promotoras);
    }

    public function logs_feriecita(Request $request){
        $date = Carbon::now();
        $fecha_hoy = $date->format('Y-m-d');

        
        $id_region_actual=\Cache::get('region');
        $id_ruta_actual=\Cache::get('ruta');

        

        // dd($id_region_actual);

        if ($id_region_actual==null) {
            $id_region_actual=0;
            $id_ruta_actual=0;
        } else {
            $id_region_actual=\Cache::get('region');
            $id_ruta_actual=\Cache::get('ruta');
        }
        

        $region=Plaza::find($id_region_actual);
        // dd($region);
        $zona = Zona::find($id_ruta_actual);
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region_actual)
        ->orderBy('Zona','ASC')
        ->get();

        if (empty($request->fecha_inicio)) {

                $logs= DB::table('v_log')
                ->select('v_log.*')
                ->where('fecha_registro', 'LIKE', '%'.$fecha_hoy.'%')
                ->orderBy('id_log','DESC')
                ->get();
            
        } else {
            if (empty($request->fecha_final)) {
                $logs= DB::table('v_log')
                ->select('v_log.*')
                ->where('fecha_registro','LIKE','%'.$request->fecha_inicio.'%')
                ->orderBy('id_log','DESC')
                ->get();
            } else {
                $logs= DB::table('v_log')
                ->select('v_log.*')
                ->whereBetween('fecha_registro',[$request->fecha_inicio, $request->fecha_final])
                ->orderBy('id_log','DESC')
                ->get();
            }
            
        }
        

        $tipo_log=DB::table('tbl_log_tipo')
        ->select('tbl_log_tipo.*')
        ->get();

        
        return view('logs',['logs'=>$logs,'tipo_log'=>$tipo_log,'zona'=>$zona,'zonas'=>$zonas]);
    }

    public function actualizar_datos_corte(Request $request){

        // dd($request->all());
        $prestamos=DB::table('tbl_prestamos')
        ->select('tbl_prestamos.*')
        ->where('id_grupo','=',$request->id_grupo)
        ->whereIn('id_status_prestamo', [2,9])
        ->get();

        $total_clientes=0;
        $monto_ideal=0;


        if (count($prestamos)==0) {
            $total_clientes=0;
            $monto_ideal=0;
        } else {
            foreach ($prestamos as $prestamo) {

                $producto=DB::table('tbl_productos')
                ->select('tbl_productos.pago_semanal')
                ->where('id_producto','=',$prestamo->id_producto)
                ->get();

                if (empty($producto[0]->pago_semanal)) {
                    return back()->with('error', 'Ocurrio un error, vuelve a intentar');
                } else {
                    $total_ideal=$prestamo->cantidad*($producto[0]->pago_semanal/100);

                    $monto_ideal+=$total_ideal;
                    
                }
                
            }

            $total_clientes=count($prestamos);


            $actualizando_datos = DB::table('tbl_cortes_semanas')
              ->where('id_corte_semana', $request->id_corte)
              ->update([
                  'corte_ideal' => $monto_ideal,
                  'total_clientes' => $total_clientes
            ]);

            return back()->with('status', 'Datos actualizados con éxito');

        }
        return back()->with('error', 'No se encontraron préstamos');
        // dd($prestamos);
    }


    public function nueva_pagina(Request $request){

        if (empty($request->id_region)) {
            $id_region=3;
        } else {
            $id_region=$request->id_region;
        }

        $regiones= DB::table('tbl_plaza')
        ->select('tbl_plaza.*')
        ->orderBy('Plaza','ASC')
        ->get();

        $zonas= DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region)
        ->orderBy('Zona','ASC')
        ->get();

        return view('cobrax_admin.contenido.inicio',['regiones'=>$regiones,'id_region'=>$id_region,'zonas'=>$zonas]);
    }

    public function lista_grupos(Request $request){

        
        if (empty($request->id_region)) {
            $id_region=3;
        } else {
            $id_region=$request->id_region;
        }
        

        $id_zona=$request->id_zona;

        

        $regiones= DB::table('tbl_plaza')
        ->select('tbl_plaza.*')
        ->orderBy('Plaza','ASC')
        ->get();

        
        $zonas= DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region)
        ->orderBy('Zona','ASC')
        ->get();

        $grupos = DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->where('IdZona','=',$id_zona)
        ->orderBy('grupo','ASC')
        ->get();
        
        $region=Plaza::find($id_region);

        $zona=Zona::find($id_zona);


        // dd($request->all(),$id_region,$id_zona,$regiones,$zonas,$region,$zona,$grupos);
        
        
        return view('cobrax_admin.contenido.lista_grupos',['id_region'=>$id_region,'regiones'=>$regiones,'region'=>$region,'zonas'=>$zonas,'zona'=>$zona,'grupos'=>$grupos]);
    }

    public function configuracion_region($id_region){
        \Cache::forever('region', $id_region);
        \Cache::forever('ruta', 0);

        return redirect('home');
    }
    public function configuracion_zona($id_zona){

        // $id_region_actual=\Cache::get('region');
        

        // \Cache::forever('region', $id_region_actual, 1440);
        \Cache::forever('ruta', $id_zona);

        return redirect('home');
    }
    
    public function corte_general(){
        // dd('Fechas actualizadas');
        $fecha_hoy=Carbon::now();  

        $grupos = DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->orderBy('grupo','ASC')
        ->where('id_grupo','=',101)
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
                ->where('id_prestamo','=',3040)
                ->get();

                
                $semana_corte_actual=DB::table('tbl_cortes_semanas')
                ->select('tbl_cortes_semanas.*')
                ->where('id_grupo','=',$grupo->id_grupo)
                ->orderBy('numero_semana_corte','ASC')
                ->get();
                
                
                if(count($semana_corte_actual)==0){
                    // return back()->with('error', '¡Se necesita configuración de fecha de corte semana!');
                    // dd('ninguna fecha de corte '.$grupo->id_grupo,$grupo->grupo);

                    array_push($grupos_sin_configuracion, array(
                        'id_grupo' => $grupo->id_grupo,
                        'grupo' =>$grupo->grupo,
                    ));

                } else {


                    // dd(count($semana_corte_actual));
                    $corte_semana=$semana_corte_actual->last()->id_corte_semana;
                    $fecha_inicio=$semana_corte_actual->last()->fecha_inicio;
                    $fecha_corte=$semana_corte_actual->last()->fecha_final;
                    // dd($semana_corte_actual,$fecha_inicio,$fecha_corte);
                    if (count($prestamos)==0) {
                        
                    } else {
    
                        
                        foreach ($prestamos as $prestamo) {
                            
                            $tipo_abono=0;
                            $cantidad_multa=0;
                            $ultima_semana=0;

                            
                            
                            $producto=DB::table('tbl_productos')
                            ->select('tbl_productos.pago_semanal','tbl_productos.ultima_semana')
                            ->where('id_producto','=',$prestamo->id_producto)
                            ->get();

                            $semana=DB::table('tbl_abonos')
                            ->select('tbl_abonos.semana','tbl_abonos.id_abono')
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
                                                            $cantidad_multa = $prestamo->cantidad*($producto[0]->pago_semanal/100);
                                                        }
                                                        
                
                                                    } else {
                                                        // Hay multas, por lo tanto será de multa 2
        
                                                        if ($semana_siguiente>$ultima_semana) {
                                                            $tipo_abono=2;
                                                            $cantidad_multa = 0;
                                                        } else {
                                                            $tipo_abono=5;
                                                            $cantidad_multa=50;
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
                                                        $cantidad_multa = $prestamo->cantidad*($producto[0]->pago_semanal/100);
                                                    }
        
                
                                                } else {
                                                    // Hay multas, por lo tanto será de multa 2
        
                                                    if ($semana_siguiente>$ultima_semana) {
                                                        $tipo_abono=2;
                                                        $cantidad_multa = 0;
                                                    } else {
                                                        $tipo_abono=5;
                                                        $cantidad_multa=50;
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

            // dd('grupos: corte',$grupos_corte,'Grupos sin conf',$grupos_sin_configuracion,'Multas',$multas_por_grupo);

            // dd($multas_por_grupo);
       

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
                // $user = $request->user(); 
                // información del usuario
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

        // dd('Grupos',$grupos,'Prestamos', $prestamos,'Id corte semana '.$corte_semana,'Multas: ',$multas_por_grupo,'Grupos sin configuracion',$grupos_sin_configuracion,'Prestamos sin producto', $prestamos_sin_producto,'Grupos para corte',$grupos_corte); 

        dd($grupos_corte_exito,$grupos_corte_error);

        return view('admin.corte_grupos.corte_general',['multas_por_grupo'=>$multas_por_grupo,'grupos_sin_configuracion'=>$grupos_sin_configuracion,'prestamos_sin_producto'=>$prestamos_sin_producto,'grupos_corte'=>$grupos_corte,'grupos_corte_exito'=>$grupos_corte_exito,'grupos_corte_error'=>$grupos_corte_error]);
    }

    public function terminal_corte_general(Request $request){
        $grupos_corte=$request->all();

    }



    public function actualizar_fechas_corte(){
       dd('Fechas actualizadas');
        $fecha_sin_f_sabado ="2021-09-19";
        $actualizar_fechas = array();
        


        $grupos=DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        // ->whereIn('id_grupo',[78,101])
        ->orderBy('grupo','ASC')
        ->get();

        if (count($grupos)==0) {
            dd('No hay grupos, jajajaj');
        } else {
            foreach ($grupos as $grupo) {
                
                $fechas_de_corte=DB::table('tbl_cortes_semanas')
                ->select('tbl_cortes_semanas.*')
                // ->whereIn('id_grupo',[78,101])
                ->where('id_grupo','=',$grupo->id_grupo)
                ->orderBy('fecha_final','asc')
                ->get();
                
                if (count($fechas_de_corte)==0) {
                
                } else {


                    $fecha_sin=$fechas_de_corte->last()->fecha_final;
                    $date = date_create($fecha_sin);
                    $fecha_con_f= date_format($date,"d-m-Y");

                    array_push($actualizar_fechas, array(
                            'id_grupo' => $grupo->id_grupo,
                            'grupo' => $grupo->grupo,
                            'id_corte_semana' => $fechas_de_corte->last()->id_corte_semana,
                            'fecha_final' => $fechas_de_corte->last()->fecha_final,
                            'fecha_actualizar' => $fecha_sin_f_sabado,
                        ));
                    
                    
                    
                   
                }

            }
            

            $actualizar_fechas=json_encode($actualizar_fechas);
            $actualizar_fechas=json_decode($actualizar_fechas);

            // dd($actualizar_fechas);
                if (count($actualizar_fechas)==0) {
                    # code...
                } else {
                    foreach ($actualizar_fechas as $actualizar_fecha) {
                        $corte_semana = DB::table('tbl_cortes_semanas')
                        ->where('id_corte_semana', $actualizar_fecha->id_corte_semana)
                        ->update([
                            'fecha_final' => $actualizar_fecha->fecha_actualizar,
                        ]); 
                    }
                    
                    dd('Fechas actualizado con éxito');
                }
                

        }
        


        // $fechas_de_corte=DB::table('tbl_cortes_semanas')
        //     ->select('tbl_cortes_semanas.*')
        //     ->get();

        // array_push($grupos_corte, array(
        //     'id_grupo' => $grupo->id_grupo,
        //     'grupo' => $grupo->grupo,
        //     'total_clientes' => $total_clientes,
        //     'corte_ideal' => $corte_ideal,
        //     'semana_siguiente' => $semana_siguiente
        // ));


        dd('Estamos trabajando en ello',$grupos,$fechas_de_corte);
    }

    public function admin_carrousel(){
        $imagenes_carrousel = DB::table('tbl_inicio_app')
        ->select('tbl_inicio_app.*')
        ->get();

        return view('admin_corrousel_app',['imagenes_carrousel'=>$imagenes_carrousel]);
    }

   public function actualizar_carrousel(Request $request){

        if ($request->tipo_actualizar=='img') {
            if ($request->hasFile('path_img')) {
            
                $request->validate([
                    'path_img'=> 'required|mimes:jpeg,png,jpg'
                ]);
    
    
                $file=$request->file('path_img');
                $name=time().'_'.$file->getClientOriginalName();

                if ($request->tipo_imagen==1) {
                    $carpeta='inicio_app/principal';
                    $url = $_SERVER['DOCUMENT_ROOT'].'/'.$carpeta;

                } else {
                    $carpeta='inicio_app/carrusel';
                    $url = $_SERVER['DOCUMENT_ROOT'].'/'.$carpeta;
                }
                
                
    
                $file->move($url,$name);
    
                // return back()->with('status', '¡Se actualizó la imagen correctamente!');
                
            }else{
                return back()->with('danger', '¡Seleccione una imagen o archivo porfavor!');
            }

            DB::table('tbl_inicio_app')
            ->where('id', $request->id_c)
            ->update([
                'path_img' => $carpeta.'/'.$name,
            ]); 
            return back()->with('status', '¡Se actualizó la imagen correctamente!');
        } elseif($request->tipo_actualizar=='pdf') {
            if ($request->hasFile('path_pdf')) {
            
                $request->validate([
                    'path_pdf'=> 'required|mimes:pdf'
                ]);
    
    
                $file=$request->file('path_pdf');
                $name=time().'_'.$file->getClientOriginalName();
                $url = $_SERVER['DOCUMENT_ROOT'].'/inicio_app/pdf';
    
                $file->move($url,$name);
    
                // return back()->with('status', '¡Se actualizó la imagen correctamente!');
                
            }else{
                return back()->with('danger', '¡Seleccione un archivo porfavor!');
            }


            DB::table('tbl_inicio_app')
            ->where('id', $request->id_c)
            ->update([
                'path_pdf' => 'inicio_app/pdf/'.$name,
            ]); 

            return back()->with('status', '¡Se actualizó el archivo correctamente!');
        } elseif($request->tipo_actualizar=='texto') {


            if (empty($request->habilitar_pdf)) {
                $habilitar=0;
            } else {
                $habilitar=1;
            }
            
            DB::table('tbl_inicio_app')
            ->where('id', $request->id_c)
            ->update([
                'titulo' => $request->titulo,
                'habilitar_pdf' => $habilitar,
            ]); 

            return back()->with('status', '¡Se actualizó el titulo y/o habilitar contendo correctamente!');
        }
        
    }
    
    public function validacion_sms(){
        $validaciones=DB::table('tbl_validaciones')
        ->select('tbl_validaciones.*')
        // ->where('id_grupo','=',$grupo->id_grupo)
        ->orderBy('fecha_hora','desc')
        ->get();
        
       return view('admin.app.validacion_sms',compact('validaciones'));
        
    }
      public function enviar_de_nuevo(Request $request){
        

        $enviar_nuevamente = DB::table('tbl_validaciones')
        ->where('id_validacion', $request->id_validacion)
        ->update([
            'codigo_generado' => null,
            'validado' => 0,
        ]);
        return back()->with('status', 'Código enviado nuevamente');
    }

    public function validar_sms(Request $request){
        
        $validacion=DB::table('tbl_validaciones')
        ->select('tbl_validaciones.*')
        ->where('codigo_generado','=',$request->codigo_generado)
        ->get();
        // return json_encode(array('results' => ['status' => 200, 'mensaje' =>$validacion ]), JSON_UNESCAPED_UNICODE);

        if (count($validacion)==0) {
            return back()->with('error', 'Hubo un error de petición al WS. No encontramos registros con el código proporcionado. Genera otro cógigo');
            // return json_encode(array('results' => ['status' => 200, 'mensaje' => "Hubo un error de petición al WS. No encontramos registros con el código proporcionado. Genera otro cógigo"]), JSON_UNESCAPED_UNICODE);
        } else {
            foreach ($validacion as $valida) {
                
                // Actualizar los datos del registro encontrado solo en validado como validado
                DB::table('tbl_validaciones')->where('id_validacion','=',$valida->id_validacion)->update([
                    'validado'=>1,
                ]);

                // Actualizar el campo de validacion de socioeconomico validado
                DB::table('tbl_vivienda')->where('id_socio_economico','=',$valida->id_socio_economico)->update([
                    'telefono_validado'=>1,
                ]);

            }
            return back()->with('status', '¡Número de teléfono validado con éxito!.');
        
        }

    }
    public function exportar(){
        
        $contenido_excel=array();

        $id_grupo=97;
        $idregion=\Cache::get('region');
        $zona = Zona::find($idregion);

        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$idregion)
        ->orderBy('Zona','ASC')
        ->get();

        $total_prestamos=0;
        $total_saldo=0;
        // dd($zonas);

        if (count($zonas)==0) {
            dd('sin zonas');
        } else {
            foreach ($zonas as $zona) {
                $grupos = DB::table('tbl_grupos')
                ->select('tbl_grupos.*')
                ->where('IdZona','=',$zona->IdZona)
                ->orderBy('grupo','ASC')
                ->get();
                if (count($grupos)==0) {
                    
                } else {
                    foreach ($grupos as $key => $grupo) {
                        $id_grupo=$grupo->id_grupo;
                                // Para el pdf 

                        
                                $fecha_actual=Carbon::now();
                                $grupo=Grupos::find($id_grupo);
                        
                                $prestamos= DB::table('tbl_prestamos')
                                ->select('tbl_prestamos.*')
                                ->whereIn('id_status_prestamo', [2,3,4,5,9,18])
                                // ->whereNotIn('id_status_prestamo', [8, 6])
                                ->where('tbl_prestamos.id_grupo','=',$id_grupo)
                                ->orderby('id_prestamo','ASC')
                                ->get();
                        
                                $ultimos_abonos = array();
                                // dd($ultimos_abonos);
                                if(count($prestamos)==0){
                        
                                } else {
                                    foreach ($prestamos as $prestamo) {
                        
                                        $abono = DB::table('tbl_abonos')
                                        ->select('tbl_abonos.id_abono')
                                        ->where('id_prestamo','=',$prestamo->id_prestamo)
                                        ->orderby('semana','ASC')
                                        ->get();
                                        if(count($abono)==0){
                                           
                                        } else {
                                            array_push($ultimos_abonos, array(
                                                'id_prestamo' => $prestamo->id_prestamo, 
                                                'grupo' => $prestamo->id_grupo, 
                                                'cantidad' => $prestamo->cantidad, 
                                                'ultimo_abono' => $abono->last()->id_abono, 
                                                'id_status_prestamo' => $prestamo->id_status_prestamo
                                            ));
                                        }
                                        
                                    }
                                }
                                $ultimos_abonos=json_encode($ultimos_abonos);
                        
                                $prestamos_suma = DB::table('tbl_prestamos')
                                ->select(DB::raw('SUM(cantidad) as total_prestamos'))
                                ->where('id_grupo','=',$id_grupo)
                                ->whereIn('id_status_prestamo', [2,3,4,5,9,8])
                                ->get();
                                
                        
                                $abonos_suma = DB::table('tbl_abonos')
                                ->join('tbl_prestamos','tbl_abonos.id_prestamo','tbl_prestamos.id_prestamo')
                                ->select(DB::raw('SUM(tbl_abonos.cantidad) as total_abonos'))
                                // ->select('tbl_abonos.*')
                                ->whereBetween('tbl_abonos.id_tipoabono',[2,3])
                                ->where('tbl_prestamos.id_grupo','=',$id_grupo)
                                ->whereIn('tbl_prestamos.id_status_prestamo', [2,3,4,5,9,8])
                                ->get();
                        
                        
                                $abonos_suma_ajuste = DB::table('tbl_abonos')
                                ->join('tbl_prestamos','tbl_abonos.id_prestamo','tbl_prestamos.id_prestamo')
                                ->select(DB::raw('SUM(tbl_abonos.cantidad) as total_abonos_ajuste'))
                                ->whereIn('tbl_abonos.id_tipoabono',[6])
                                ->where('tbl_prestamos.id_grupo','=',$id_grupo)
                                ->whereIn('tbl_prestamos.id_status_prestamo', [2,3,4,5,9,8])
                                ->get();
                        
                                $abonos_total=$abonos_suma[0]->total_abonos-$abonos_suma_ajuste[0]->total_abonos_ajuste;
                        
                                $t_semana_negra=0;
                                $t_semana_morado=0;
                                $t_semana_rojo=0;
                                $t_semana_naranja=0;
                                $t_semana_amarillo=0;
                                $t_semana_verde=0;
                                $t_saldo_irrecuperable=0;
                                $ultimos_abonos=json_decode($ultimos_abonos);
                                // @endphp
                                foreach ($ultimos_abonos as $ultimos_a){
                                
                                    // @php
                                        // Para decir vencido, la ultima semana debe estar en 14 y despues preguntar si tiene saldo o noo?
                                        $semana_negra = DB::table('tbl_abonos')
                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                        ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                        ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                                        ->where('tbl_abonos.semana','=',14)
                                        ->distinct()
                                        ->get();
                                    
                                        // Su ultima semana debe ser mayor de 14 semanas, 
                                        // preguntar si la semana es 15 entonces preguntamos si el tipo de abono no es multa
                                        // si la semana es mayor de 15 entonces preguntamos si el abono tiene alguna cantidad
                                        $semana_morado = DB::table('tbl_abonos')
                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                        ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                        ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                                        ->where('tbl_abonos.semana','>',14)
                                        ->get();
                        
                                        $semana_amarillo = DB::table('tbl_abonos')
                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                        ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                        ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                                        ->where('tbl_abonos.semana','<',14)
                                        ->get();
        
                                        $prestamos_irrecuperable = DB::table('tbl_abonos')
                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                        ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                        ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                                        ->get();
                                        
                                    // @endphp 
        
                                    if ($ultimos_a->id_status_prestamo==18){
                                        if (count($prestamos_irrecuperable)==0){
                                            
                                        }else{
                                            foreach ($prestamos_irrecuperable as $prestamo_irrecuperable){
                                                // {{-- Se coloca en estatus rojo --}}
                                                
                                                    $cliente = DB::table('tbl_prestamos')
                                                        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                        ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                        ->where('tbl_prestamos.id_prestamo','=',$prestamo_irrecuperable->id_prestamo)
                                                        ->distinct()
                                                        ->get();
                                                // |{{-- <tr><td> roja{{$semana_n->cantidad}}</td> <td>{{$semana_n->id_prestamo}}</td></tr> --}}
                                                foreach ($cliente as $cli){
                                                    // {{-- calculamos el saldo --}}
                                                    
                                                        $producto = DB::table('tbl_productos')   
                                                        ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                        ->select('tbl_productos.*')
                                                        ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                        ->get();
                                                        $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                        ->select('cantidad')
                                                        ->where('id_prestamo','=',$cli->id_prestamo)
                                                        ->get();
                                                        $tipo_liquidacion = DB::table('tbl_abonos')
                                                        ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',1)
                                                        ->get();
                                                        $tipo_abono = DB::table('tbl_abonos')
                                                        ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',2)
                                                        ->get();
                                                        $tipo_ahorro = DB::table('tbl_abonos')
                                                        ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',3)
                                                        ->get();
                                                        $tipo_multa_1 = DB::table('tbl_abonos')
                                                        ->select(DB::raw('count(*) as tipo_multa_1'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',4)
                                                        ->get();
                                                            if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                $multa1=0;
                                                            }else {
                                                                $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                            }
                                                        $tipo_multa_2 = DB::table('tbl_abonos')
                                                        ->select(DB::raw('count(*) as tipo_multa_2'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',5)
                                                        ->get();
                                                            if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                $multa2=0;
                                                            }else {
                                                                $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                            }
                                                        $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                        $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                        // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                        $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                        $s_multa2=$producto[0]->penalizacion*$multa2;
                                                        $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                        $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                        $saldo_irrecuperable=$sistema_total_cobrar-$cliente_pago;
                                                        
                                                        //$t_semana_rojo+=$semana_n->cantidad;
                                                        $t_saldo_irrecuperable+=$saldo_irrecuperable;
                                                    
                                                    if ($saldo_irrecuperable==0){
                                                        
                                                    }else{
                                                        
                                                        // <tr>
                                                        //     <td style="color: gray; background: gray ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                        //     <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                        //     <td>{{$cli->id_prestamo}}</td>
                                                        //     <td>
                                                        //         @php
                                                                    $originalDate = $cli->fecha_entrega_recurso;
                                                                    $newDate = date("d/m/Y", strtotime($originalDate));
                                                                // @endphp
                                                                // {{$newDate}}
                                                        //     </td>
                                                        //     <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                        //     <td style="color:red;">
                                                        //             $ {{number_format($saldo_irrecuperable,1)}}
                                                        //     </td>
                                                        // </tr>

                                                        array_push($contenido_excel, array(
                                                            'zona' => $zona->Zona, 
                                                            'grupo' => $grupo->grupo,
                                                            'color'=> 'Gris',
                                                            'nombre_completo' => $cli->nombre.' '.$cli->ap_paterno.' '.$cli->ap_materno, 
                                                            'id_prestamo' => $cli->id_prestamo, 
                                                            'fecha_entrega_recurso' => $newDate, 
                                                            'cantidad' => number_format($cli->cantidad,1), 
                                                            'saldo' => number_format($saldo_irrecuperable,1)
                                                        ));
                                                        $total_prestamos+=$cli->cantidad;
                                                        $total_saldo+=$saldo_irrecuperable;
                                                        
                                                    }
                                                }
                                            }
                                        }
                                    }else{
        
                                        if (count($semana_negra)==0){
                                            
                                        }else{
                                        // {{-- Estado negro y rojo solucionado---}}
                                            foreach ($semana_negra as $semana_n){
                                                // @php
                                                    $dias_transcurrido = $fecha_actual->diffInDays($semana_n->fecha_pago);
                                                    
                                                // @endphp
                                                if ($dias_transcurrido<45){
                                                
                                                    // {{-- Se coloca en estatus rojo --}}
                                                        // @php
                                                            $cliente = DB::table('tbl_prestamos')
                                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$semana_n->id_prestamo)
                                                                ->distinct()
                                                                ->get();
                                                        // @endphp
                                                        // {{-- <tr><td> roja{{$semana_n->cantidad}}</td> <td>{{$semana_n->id_prestamo}}</td></tr> --}}
                                                        foreach ($cliente as $cli){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$cli->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                //$t_semana_rojo+=$semana_n->cantidad;
                                                                $t_semana_rojo+=$saldo_rojo;
                                                            // @endphp
                                                            if ($saldo_rojo==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: red; background:red ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                                //     <td>{{$cli->id_prestamo}}</td>
                                                                //     <td>
                                                                        // @php
                                                                            $originalDate = $cli->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                        // @endphp
                                                                        // {{$newDate}}
                                                                    // </td>
                                                                    // <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                                    // <td style="color:red;">
                                                                    //         $ {{number_format($saldo_rojo,1)}}
                                                                    // </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'zona' => $zona->Zona, 
                                                                    'grupo' => $grupo->grupo,
                                                                    'color'=> 'Rojo',
                                                                    'nombre_completo' => $cli->nombre.' '.$cli->ap_paterno.' '.$cli->ap_materno, 
                                                                    'id_prestamo' => $cli->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($cli->cantidad,1), 
                                                                    'saldo' => number_format($saldo_rojo,1)
                                                                ));
                                                                $total_prestamos+=$cli->cantidad;
                                                                $total_saldo+=$saldo_rojo;
                                                                
                                                            }
                                                        }
                                                    
                                                    // {{-- menos de 45 dias : d: {{$dias_transcurrido}} s:{{$semana_n->semana}} c:{{$semana_n->cantidad}}  <br> --}}
                                                }elseif($dias_transcurrido>45){
                                                    // {{-- Se coloca ne estatus negro --}}
                                                        // @php
                                                            $clienten = DB::table('tbl_prestamos')
                                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$semana_n->id_prestamo)
                                                                ->distinct()
                                                                ->get();
                                                        // @endphp
                                                        foreach ($clienten as $clin){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$clin->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$clin->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                
                                                                //$t_semana_negra+=$semana_n->cantidad;
                                                                $t_semana_negra+=$saldo_negro;
                                                                
                                                            // @endphp
                                                            if ($saldo_negro==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: #000; background:black ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$clin->nombre}} {{$clin->ap_paterno}} {{$clin->ap_materno}}</td>
                                                                //     <td>{{$clin->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $clin->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                //         @endphp
                                                                //         {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($clin->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                            
                                                                //             $ {{number_format($saldo_negro,1)}}
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'zona' => $zona->Zona, 
                                                                    'grupo' => $grupo->grupo,
                                                                    'color'=> 'Negro',
                                                                    'nombre_completo' => $clin->nombre.' '.$clin->ap_paterno.' '.$clin->ap_materno, 
                                                                    'id_prestamo' => $clin->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($clin->cantidad,1), 
                                                                    'saldo' => number_format($saldo_negro,1)
                                                                ));
                                                                $total_prestamos+=$clin->cantidad;
                                                                $total_saldo+=$saldo_negro;
                                                                
                                                            }
                                                        } 
                                                }else{
                                                    // {{-- <label>no hay datos</label> --}}
                                                }
                                            }
                                        }
                            
                                        if (count($semana_morado)==0){
                                            
                                        }else{
                                            foreach ($semana_morado as $semana_m){
                                            // {{-- Se coloca en estatus morado  --}}
                                                // @php
                                                    $dias_transcurrido_m = $fecha_actual->diffInDays($semana_m->fecha_pago);
                                                // @endphp
                                                if ($dias_transcurrido_m>45){
                                                    // {{-- Consultamos las semanas despues de 14 --}}
                                                    // @php
                                                        $abono_buscar=0;
                                                        $verificar_semanas=DB::table('tbl_abonos')
                                                        ->select('tbl_abonos.*')
                                                        ->where('semana','>',14)
                                                        ->where('id_prestamo','=',$semana_m->id_prestamo)
                                                        ->get();
                                                    // @endphp
                                                    // {{-- Preguntamos si hay elementos en la consulta --}}
                                                    if (count($verificar_semanas)==0){
                                                        
                                                    }else{
                                                        // {{-- Si hay elementos entonces recorremos y preguntamos si el tipo de abono
                                                        // no es multa  --}}
                                                        foreach ($verificar_semanas as $verificar_semana){
                                                            if ($verificar_semana->id_tipoabono==4){
                                                                
                                                            }elseif ($verificar_semana->id_tipoabono==5){
        
                                                            }else{
                                                                // @php
                                                                    $abono_buscar+=$verificar_semana->cantidad;
                                                                // @endphp
                                                            }
                                                            
                                                        }
                                                    }
                                                    if ($abono_buscar==0){
                                                    // {{-- Preguntamos si no hay cantidad de abono, para pasarlo a estado negro  --}}
                                                        // @php
                                                            $clienten = DB::table('tbl_prestamos')
                                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                                ->distinct()
                                                                ->get();
                                                        // @endphp
                                                        foreach ($clienten as $clin){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$clin->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$clin->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                
                                                                //$t_semana_negra+=$semana_n->cantidad;
                                                                $t_semana_negra+=$saldo_negro;
                                                                
                                                            // @endphp
                                                            if ($saldo_negro==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: #000; background:black ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$clin->nombre}} {{$clin->ap_paterno}} {{$clin->ap_materno}}</td>
                                                                //     <td>{{$clin->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $clin->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                        // @endphp
                                                                        // {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($clin->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                            
                                                                //             $ {{number_format($saldo_negro,1)}}
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'zona' => $zona->Zona, 
                                                                    'grupo' => $grupo->grupo,
                                                                    'color'=> 'Negro',
                                                                    'nombre_completo' => $clin->nombre.' '.$clin->ap_paterno.' '.$clin->ap_materno, 
                                                                    'id_prestamo' => $clin->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($clin->cantidad,1), 
                                                                    'saldo' => number_format($saldo_negro,1)
                                                                ));
                                                                $total_prestamos+=$clin->cantidad;
                                                                $total_saldo+=$saldo_negro;
                                                            }
                                                        }
                                                    }else{
                                                        // {{-- Si hay cantidad abono entonces lo pasamos a estado morado porque  --}}
                                                        // @php
                                                            //$t_semana_morado+=$semana_m->cantidad;
                                                            $clientem = DB::table('tbl_prestamos')
                                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                            ->distinct()
                                                            ->get();
                                                        // @endphp
                                                        foreach ($clientem as $clim){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$clim->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$clim->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_morado=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                
                                                                //$t_semana_morado+=$semana_m->cantidad;
                                                                $t_semana_morado+=$saldo_morado;
                                                                
                                                            // @endphp
                                                            if ($saldo_morado==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: purple; background:purple ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$clim->nombre}} {{$clim->ap_paterno}} {{$clim->ap_materno}}</td>
                                                                //     <td>{{$clim->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $clim->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                //         @endphp
                                                                //         {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($clim->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                        
                                                                //         $ {{number_format($saldo_morado,1)}}    
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'zona' => $zona->Zona, 
                                                                    'grupo' => $grupo->grupo,
                                                                    'color'=> 'Morado',
                                                                    'nombre_completo' => $clim->nombre.' '.$clim->ap_paterno.' '.$clim->ap_materno, 
                                                                    'id_prestamo' => $clim->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($clim->cantidad,1), 
                                                                    'saldo' => number_format($saldo_morado,1)
                                                                ));
                                                                $total_prestamos+=$clim->cantidad;
                                                                $total_saldo+=$saldo_morado;
                                                            }
                                                        }
                                                        
                                                    }
                                                
            
                                                }elseif($dias_transcurrido_m<45){
                                                    // {{-- Se coloca en estatus naranja --}}
                                                    // @php
                                                        $abono_buscar=0;
                                                        $verificar_semanas=DB::table('tbl_abonos')
                                                        ->select('tbl_abonos.*')
                                                        ->where('semana','>',14)
                                                        ->where('id_prestamo','=',$semana_m->id_prestamo)
                                                        ->get();
                                                    // @endphp
                                                    // {{-- Preguntamos si hay elementos en la consulta --}}
                                                    if (count($verificar_semanas)==0){
                                                        
                                                    }else{
                                                        // {{-- Si hay elementos entonces recorremos y preguntamos si el tipo de abono
                                                        // no es multa  --}}
                                                        foreach ($verificar_semanas as $verificar_semana){
                                                            if ($verificar_semana->id_tipoabono==4){
                                                                
                                                            }elseif ($verificar_semana->id_tipoabono==5){
        
                                                            }else{
                                                                // @php
                                                                    $abono_buscar+=$verificar_semana->cantidad;
                                                                // @endphp
                                                            }
                                                            
                                                        }
        
                                                    }
        
                                                    if ($abono_buscar==0){
                                                        // {{-- Se coloca en estatus rojo --}}
                                                        // @php
                                                            $cliente = DB::table('tbl_prestamos')
                                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                                ->distinct()
                                                                ->get();
                                                        // @endphp
                                                        // {{-- <tr><td> roja{{$semana_n->cantidad}}</td> <td>{{$semana_n->id_prestamo}}</td></tr> --}}
                                                        foreach ($cliente as $cli){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$cli->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                //$t_semana_rojo+=$semana_n->cantidad;
                                                                $t_semana_rojo+=$saldo_rojo;
                                                            // @endphp
                                                            if ($saldo_rojo==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: red; background:red ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                                //     <td>{{$cli->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $cli->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                //         @endphp
                                                                //         {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                //             $ {{number_format($saldo_rojo,1)}}
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'zona' => $zona->Zona, 
                                                                    'grupo' => $grupo->grupo,
                                                                    'color'=> 'Rojo',
                                                                    'nombre_completo' => $cli->nombre.' '.$cli->ap_paterno.' '.$cli->ap_materno, 
                                                                    'id_prestamo' => $cli->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($cli->cantidad,1), 
                                                                    'saldo' => number_format($saldo_rojo,1)
                                                                ));
                                                                $total_prestamos+=$cli->cantidad;
                                                                $total_saldo+=$saldo_rojo;
                                                                
                                                            }
                                                        }
                                                    }else{
                                                        // {{-- Si tiene movimiento entonces lo pasamos al color naranja --}}
                                                        // @php
                                                            $clientena = DB::table('tbl_prestamos')
                                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                            ->distinct()
                                                            ->get();
                                                        // @endphp
                                                        foreach ($clientena as $clina){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$clina->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$clina->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_naranja=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                $t_semana_naranja+=$saldo_naranja;
                                                            // @endphp
                                                            if ($saldo_naranja==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: orange; background:orange ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$clina->nombre}} {{$clina->ap_paterno}} {{$clina->ap_materno}}</td>
                                                                //     <td>{{$clina->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $clina->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                //         @endphp
                                                                //         {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($clina->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                        
                                                                //         $ {{number_format($saldo_naranja,1)}}
                                                                    
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'zona' => $zona->Zona, 
                                                                    'grupo' => $grupo->grupo,
                                                                    'color'=> 'Naranja',
                                                                    'nombre_completo' => $clina->nombre.' '.$clina->ap_paterno.' '.$clina->ap_materno, 
                                                                    'id_prestamo' => $clina->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($clina->cantidad,1), 
                                                                    'saldo' => number_format($saldo_naranja,1)
                                                                ));
                                                                $total_prestamos+=$clina->cantidad;
                                                                $total_saldo+=$saldo_naranja;
                                                                
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                            
                                        if (count($semana_amarillo)==0){
                                            
                                        }else{     
                                            foreach ($semana_amarillo as $semana_a){
                                                // @php
                                                    $dias_transcurrido_am = $fecha_actual->diffInDays($semana_a->fecha_pago);
        
                                                    $semanas_restantes=(14-$semana_a->semana)*7;
                                                    $vencido=$semanas_restantes+45;
                                                    
                                                // @endphp
                                                
                                                if ($dias_transcurrido_am>$vencido){
                                                    // {{-- Estado negro --}}
                                                    // @php
                                                        $clienten = DB::table('tbl_prestamos')
                                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                            ->distinct()
                                                            ->get();
                                                    // @endphp
                                                    foreach ($clienten as $clin){
                                                        // {{-- calculamos el saldo --}}
                                                        // @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$clin->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$clin->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                            
                                                            
                                                            //$t_semana_negra+=$semana_n->cantidad;
                                                            $t_semana_negra+=$saldo_negro;
                                                            
                                                        // @endphp
                                                        if ($saldo_negro==0){
                                                            
                                                        }else{
                                                            // <tr>
                                                            //     <td style="color: #000; background:black ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                            //     <td>{{$clin->nombre}} {{$clin->ap_paterno}} {{$clin->ap_materno}}</td>
                                                            //     <td>{{$clin->id_prestamo}}</td>
                                                            //     <td>
                                                            //         @php
                                                                        $originalDate = $clin->fecha_entrega_recurso;
                                                                        $newDate = date("d/m/Y", strtotime($originalDate));
                                                            //         @endphp
                                                            //         {{$newDate}}
                                                            //     </td>
                                                            //     <td>$ {{number_format($clin->cantidad,1)}}</td>
                                                            //     <td style="color:red;">
                                                                        
                                                            //             $ {{number_format($saldo_negro,1)}}
                                                            //     </td>
                                                            // </tr>
                                                            array_push($contenido_excel, array(
                                                                'zona' => $zona->Zona, 
                                                                'grupo' => $grupo->grupo,
                                                                'color'=> 'Negro',
                                                                'nombre_completo' => $clin->nombre.' '.$clin->ap_paterno.' '.$clin->ap_materno, 
                                                                'id_prestamo' => $clin->id_prestamo, 
                                                                'fecha_entrega_recurso' => $newDate, 
                                                                'cantidad' => number_format($clin->cantidad,1), 
                                                                'saldo' => number_format($saldo_negro,1)
                                                            ));
                                                            $total_prestamos+=$clin->cantidad;
                                                            $total_saldo+=$saldo_negro;
                                                        }
                                                    }
                                                    
                                                }elseif($dias_transcurrido_am<$vencido && $dias_transcurrido_am>=$semanas_restantes){
                                                    // {{-- Estado rojo --}}
                                                    
                                                    // @php
        
                                                        $cliente = DB::table('tbl_prestamos')
                                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                            ->distinct()
                                                            ->get();
                                                            // dd($dias_transcurrido_am);
                                                    // @endphp
                                                    foreach ($cliente as $cli){
                                                        // {{-- calculamos el saldo --}}
                                                        // @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$cli->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                            
                                                            //$t_semana_rojo+=$semana_n->cantidad;
                                                            $t_semana_rojo+=$saldo_rojo;
                                                        // @endphp
                                                        if ($saldo_rojo==0){
                                                            
                                                        }else{
                                                            // <tr>
                                                            //     <td style="color: red; background:red; margin: 3px; width: 20px; height: 15px;" >{{$dias_transcurrido_am}}</td>
                                                            //     <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                            //     <td>{{$cli->id_prestamo}}</td>
                                                            //     <td>
                                                            //         @php
                                                                        $originalDate = $cli->fecha_entrega_recurso;
                                                                        $newDate = date("d/m/Y", strtotime($originalDate));
                                                            //         @endphp
                                                            //         {{$newDate}}
                                                            //     </td>
                                                            //     <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                            //     <td style="color:red;">
                                                            //             $ {{number_format($saldo_rojo,1)}}
                                                            //     </td>
                                                            // </tr>
                                                            array_push($contenido_excel, array(
                                                                'zona' => $zona->Zona, 
                                                                'grupo' => $grupo->grupo,
                                                                'color'=> 'Rojo',
                                                                'nombre_completo' => $cli->nombre.' '.$cli->ap_paterno.' '.$cli->ap_materno, 
                                                                'id_prestamo' => $cli->id_prestamo, 
                                                                'fecha_entrega_recurso' => $newDate, 
                                                                'cantidad' => number_format($cli->cantidad,1), 
                                                                'saldo' => number_format($saldo_rojo,1)
                                                            ));
                                                            $total_prestamos+=$cli->cantidad;
                                                            $total_saldo+=$saldo_rojo;
                                                            
                                                            
                                                        }
                                                    }
                                                }elseif($dias_transcurrido_am<$semanas_restantes && $dias_transcurrido_am>7){
                                                        // {{-- estatus a amarillo --}}
                                                    // @php
                                                        //$t_semana_amarillo+=$abonos_in->cantidad;
                                                        $clienteam = DB::table('tbl_prestamos')
                                                        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                        ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                        ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                        ->distinct()
                                                        ->get();
                                                    // @endphp
                                                    foreach ($clienteam as $cliam){
                                                        // {{-- calculamos el saldo --}}
                                                        // @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$cliam->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$cliam->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_amarillo=$sistema_total_cobrar-$cliente_pago;
                                                            
                                                            $t_semana_amarillo+=$saldo_amarillo;
                                                        // @endphp
                                                        if ($saldo_amarillo==0){
                                                            
                                                        }else{
                                                            // <tr>
                                                            //     <td style="color: yellow; background:yellow ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                            //     <td>{{$cliam->nombre}} {{$cliam->ap_paterno}} {{$cliam->ap_materno}}</td>
                                                            //     <td>{{$cliam->id_prestamo}}</td>
                                                            //     <td>
                                                            //         @php
                                                                        $originalDate = $cliam->fecha_entrega_recurso;
                                                                        $newDate = date("d/m/Y", strtotime($originalDate));
                                                            //         @endphp
                                                            //         {{$newDate}}
                                                            //     </td>
                                                            //     <td>$ {{number_format($cliam->cantidad,1)}}</td>
                                                            //     <td style="color:red;">
                                                                    
                                                            //         $ {{number_format($saldo_amarillo,1)}}
                                                            //     </td>
                                                            // </tr>
                                                            array_push($contenido_excel, array(
                                                                'zona' => $zona->Zona, 
                                                                'grupo' => $grupo->grupo,
                                                                'color'=> 'Amarillo',
                                                                'nombre_completo' => $cliam->nombre.' '.$cliam->ap_paterno.' '.$cliam->ap_materno, 
                                                                'id_prestamo' => $cliam->id_prestamo, 
                                                                'fecha_entrega_recurso' => $newDate, 
                                                                'cantidad' => number_format($cliam->cantidad,1), 
                                                                'saldo' => number_format($saldo_amarillo,1)
                                                            ));
                                                            $total_prestamos+=$cliam->cantidad;
                                                            $total_saldo+=$saldo_amarillo;
                                                            
                                                        }
                                                    }
        
        
                                                }elseif($dias_transcurrido_am<=7){
                                                    // @php
                                                        $abonos_incumplimiento = DB::table('tbl_abonos')
                                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                                        ->select('tbl_prestamos.id_prestamo as pp','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                                        ->where('tbl_abonos.id_prestamo','=',$semana_a->id_prestamo)
                                                        ->whereBetween('tbl_abonos.id_tipoabono', [4, 5])
                                                        ->distinct()
                                                        ->get();
                                                    // @endphp
                                                    if (count($abonos_incumplimiento)==0){
                                                        
                                                            // @php
                                                                //$t_semana_verde+=$semana_a->cantidad;
                                                                $clientev = DB::table('tbl_prestamos')
                                                                        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                        ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                        ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                                        ->distinct()
                                                                        ->get();
                                                            // @endphp
                                                            foreach ($clientev as $cliv){
                                                                // {{-- calculamos el saldo --}}
                                                                // @php
                                                                    $producto = DB::table('tbl_productos')   
                                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                    ->select('tbl_productos.*')
                                                                    ->where('tbl_prestamos.id_prestamo','=',$cliv->id_prestamo)
                                                                    ->get();
                                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                    ->select('cantidad')
                                                                    ->where('id_prestamo','=',$cliv->id_prestamo)
                                                                    ->get();
                                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',1)
                                                                    ->get();
                                                                    $tipo_abono = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',2)
                                                                    ->get();
                                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',3)
                                                                    ->get();
                                                                    $tipo_multa_1 = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',4)
                                                                    ->get();
                                                                        if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                            $multa1=0;
                                                                        }else {
                                                                            $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                        }
                                                                    $tipo_multa_2 = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',5)
                                                                    ->get();
                                                                        if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                            $multa2=0;
                                                                        }else {
                                                                            $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                        }
                                                                    $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                    $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                    // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                    $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                    $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                    $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                    $saldo_verde=$sistema_total_cobrar-$cliente_pago;
                                                                    
                                                                    $t_semana_verde+=$saldo_verde;
                                                                // @endphp
                                                                if ($saldo_verde==0){
                                                                    
                                                                }else{
                                                                    // <tr>
                                                                    //     <td style="color: green; background:green ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                    //     <td>{{$cliv->nombre}} {{$cliv->ap_paterno}} {{$cliv->ap_materno}}</td>
                                                                    //     <td>{{$cliv->id_prestamo}}</td>
                                                                    //     <td>
                                                                    //         @php
                                                                                $originalDate = $cliv->fecha_entrega_recurso;
                                                                                $newDate = date("d/m/Y", strtotime($originalDate));
                                                                    //         @endphp
                                                                    //         {{$newDate}}
                                                                    //     </td>
                                                                    //     <td>$ {{number_format($cliv->cantidad,1)}}</td>
                                                                    //     <td style="color:red;">
                                                                            
                                                                    //         $ {{number_format($saldo_verde,1)}}
                                                                            
                                                                    //     </td>
                                                                    // </tr>
                                                                    array_push($contenido_excel, array(
                                                                        'zona' => $zona->Zona, 
                                                                        'grupo' => $grupo->grupo,
                                                                        'color'=> 'Verde',
                                                                        'nombre_completo' => $cliv->nombre.' '.$cliv->ap_paterno.' '.$cliv->ap_materno, 
                                                                        'id_prestamo' => $cliv->id_prestamo, 
                                                                        'fecha_entrega_recurso' => $newDate, 
                                                                        'cantidad' => number_format($cliv->cantidad,1), 
                                                                        'saldo' => number_format($saldo_verde,1)
                                                                    ));
                                                                    $total_prestamos+=$cliv->cantidad;
                                                                    $total_saldo+=$saldo_verde;
                                                                    
                                                                }
                                                            }
                                                    }else{
                                                    
                                                        foreach ($abonos_incumplimiento as $abonos_in){
                                                            
                                                                // @php
                                                                    //$t_semana_amarillo+=$abonos_in->cantidad;
                                                                    $clienteam = DB::table('tbl_prestamos')
                                                                    ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                    ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                    ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                    ->where('tbl_prestamos.id_prestamo','=',$abonos_in->pp)
                                                                    ->distinct()
                                                                    ->get();
                                                                // @endphp
                                                                foreach ($clienteam as $cliam){
                                                                    // {{-- calculamos el saldo --}}
                                                                    // @php
                                                                        $producto = DB::table('tbl_productos')   
                                                                        ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                        ->select('tbl_productos.*')
                                                                        ->where('tbl_prestamos.id_prestamo','=',$cliam->id_prestamo)
                                                                        ->get();
                                                                        $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                        ->select('cantidad')
                                                                        ->where('id_prestamo','=',$cliam->id_prestamo)
                                                                        ->get();
                                                                        $tipo_liquidacion = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',1)
                                                                        ->get();
                                                                        $tipo_abono = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',2)
                                                                        ->get();
                                                                        $tipo_ahorro = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',3)
                                                                        ->get();
                                                                        $tipo_multa_1 = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',4)
                                                                        ->get();
                                                                            if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                                $multa1=0;
                                                                            }else {
                                                                                $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                            }
                                                                        $tipo_multa_2 = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',5)
                                                                        ->get();
                                                                            if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                                $multa2=0;
                                                                            }else {
                                                                                $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                            }
                                                                        $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                        $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                        // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                        $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                        $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                        $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                        $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                        $saldo_amarillo=$sistema_total_cobrar-$cliente_pago;
                                                                        
                                                                        $t_semana_amarillo+=$saldo_amarillo;
                                                                    // @endphp
                                                                    if ($saldo_amarillo==0){
                                                                        
                                                                    }else{
                                                                        // <tr>
                                                                        //     <td style="color: yellow; background:yellow ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                        //     <td>{{$cliam->nombre}} {{$cliam->ap_paterno}} {{$cliam->ap_materno}}</td>
                                                                        //     <td>{{$cliam->id_prestamo}}</td>
                                                                        //     <td>
                                                                        //         @php
                                                                                    $originalDate = $cliam->fecha_entrega_recurso;
                                                                                    $newDate = date("d/m/Y", strtotime($originalDate));
                                                                        //         @endphp
                                                                        //         {{$newDate}}
                                                                        //     </td>
                                                                        //     <td>$ {{number_format($cliam->cantidad,1)}}</td>
                                                                        //     <td style="color:red;">
                                                                                
                                                                        //         $ {{number_format($saldo_amarillo,1)}}
                                                                        //     </td>
                                                                        // </tr>
                                                                        array_push($contenido_excel, array(
                                                                            'zona' => $zona->Zona, 
                                                                            'grupo' => $grupo->grupo,
                                                                            'color'=> 'Amarillo',
                                                                            'nombre_completo' => $cliam->nombre.' '.$cliam->ap_paterno.' '.$cliam->ap_materno, 
                                                                            'id_prestamo' => $cliam->id_prestamo, 
                                                                            'fecha_entrega_recurso' => $newDate, 
                                                                            'cantidad' => number_format($cliam->cantidad,1), 
                                                                            'saldo' => number_format($saldo_amarillo,1)
                                                                        ));
                                                                        $total_prestamos+=$cliam->cantidad;
                                                                        $total_saldo+=$saldo_amarillo;
                                                                    }
                                                                }
                                                            
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }



                    }
                }
                
                
            }
        }
        
        $contenido_excel=json_encode($contenido_excel);
        $contenido_excel=json_decode($contenido_excel);
        

        return view('excel',compact('contenido_excel','zona','zonas','total_prestamos','total_saldo'));

        dd($contenido_excel,count($contenido_excel));




        // Aqui vamos a construir el pdf ------------------------------

        // <!DOCTYPE html>
        // <html lang="en">
        // <head>
        //     <meta charset="UTF-8">
        //     <meta name="viewport" content="width=device-width, initial-scale=1.0">
        //     <meta http-equiv="X-UA-Compatible" content="ie=edge">
        //     <title>Reporte del grupo {{$grupo->grupo}}</title>
        //     <link rel="stylesheet" href="{{asset('css/estiloper.css')}}"/>
        //     <style>
        //         @page {
        //             margin: 0cm 0cm;
        //             font-family: Arial;
        //         }
        
        //         body {
        //             margin: 2.5cm 2cm 2cm;
        //         }
        
        //         header {
        //             position: fixed;
        //             top: 0cm;
        //             left: 0cm;
        //             right: 0cm;
        //             height: 1.8cm;
        //             background-color: transparent;
        //             border-bottom: #3728A2 solid 2px;
        //             color: #3728A2;
        //             text-align: left;
        //             line-height: 35px;
        //         }
        //         header h4 {
        //             margin-left: 75px;
        //         }
        //     </style>
        // </head>
        // <body style="font-family: 'Sans-serif';">
        //     @php
        //         $fechaActual = $fecha_actual;
        //         setlocale(LC_TIME, "spanish");
        //         $fecha_a = $fechaActual;
        //         $fecha_a = str_replace("/", "-", $fecha_a);
        //         $Nueva_Fecha_a = date("d-m-Y H:i", strtotime($fecha_a));
        //     @endphp
        //     <header>
        //         <h4>Lista de clientes del grupo {{$grupo->grupo}}<br><span style="font-size: 10px">Reporte generado {{$Nueva_Fecha_a}}</span></h4>
        //         <img src="{{asset('img/logoferiecita.png')}}" width="70px" style="position: fixed; margin-left: 645px; margin-top: 15px" alt="">
                
        //     </header>
        //     <div>
        //         <div style="float: left; width: 75%;">
                    
        //             <div style="width: 96%">
        //                 <style>
        //                     table th,td{
        //                         font-size: 11px;
        //                         text-align: left;
        //                         padding: 2px;
        //                     }
        //                 </style>
                       
        //                 <table class="estilo-tabla">
        //                     <thead>
        //                         <tr>
        //                             <th>Cat.</th>
        //                             <th style="width: 190px">Cliente</th>
        //                             <th style="width: 45px">No.P</th>
        //                             <th style="width: 80px">F. Entregado</th>
        //                             <th style="width: 60px">Monto</th>
        //                             <th style="width: 60px">Saldo</th>
                                    
        //                         </tr>
                                
        //                     </thead>
        //                     <tbody>
        //                         @php
                                    
                                    $t_semana_negra=0;
                                    $t_semana_morado=0;
                                    $t_semana_rojo=0;
                                    $t_semana_naranja=0;
                                    $t_semana_amarillo=0;
                                    $t_semana_verde=0;
                                    $t_saldo_irrecuperable=0;
                                    $ultimos_abonos=json_decode($ultimos_abonos);
                                // @endphp
                                foreach ($ultimos_abonos as $ultimos_a){
                                
                                    // @php
                                        // Para decir vencido, la ultima semana debe estar en 14 y despues preguntar si tiene saldo o noo?
                                        $semana_negra = DB::table('tbl_abonos')
                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                        ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                        ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                                        ->where('tbl_abonos.semana','=',14)
                                        ->distinct()
                                        ->get();
                                    
                                        // Su ultima semana debe ser mayor de 14 semanas, 
                                        // preguntar si la semana es 15 entonces preguntamos si el tipo de abono no es multa
                                        // si la semana es mayor de 15 entonces preguntamos si el abono tiene alguna cantidad
                                        $semana_morado = DB::table('tbl_abonos')
                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                        ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                        ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                                        ->where('tbl_abonos.semana','>',14)
                                        ->get();
                        
                                        $semana_amarillo = DB::table('tbl_abonos')
                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                        ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                        ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                                        ->where('tbl_abonos.semana','<',14)
                                        ->get();
        
                                        $prestamos_irrecuperable = DB::table('tbl_abonos')
                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                        ->select('tbl_abonos.*','tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                        ->where('tbl_abonos.id_abono','=',$ultimos_a->ultimo_abono)
                                        ->get();
                                         
                                    // @endphp 
        
                                    if ($ultimos_a->id_status_prestamo==18){
                                        if (count($prestamos_irrecuperable)==0){
                                            
                                        }else{
                                            foreach ($prestamos_irrecuperable as $prestamo_irrecuperable){
                                                // {{-- Se coloca en estatus rojo --}}
                                                
                                                    $cliente = DB::table('tbl_prestamos')
                                                        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                        ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                        ->where('tbl_prestamos.id_prestamo','=',$prestamo_irrecuperable->id_prestamo)
                                                        ->distinct()
                                                        ->get();
                                                // |{{-- <tr><td> roja{{$semana_n->cantidad}}</td> <td>{{$semana_n->id_prestamo}}</td></tr> --}}
                                                foreach ($cliente as $cli){
                                                    // {{-- calculamos el saldo --}}
                                                    
                                                        $producto = DB::table('tbl_productos')   
                                                        ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                        ->select('tbl_productos.*')
                                                        ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                        ->get();
                                                        $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                        ->select('cantidad')
                                                        ->where('id_prestamo','=',$cli->id_prestamo)
                                                        ->get();
                                                        $tipo_liquidacion = DB::table('tbl_abonos')
                                                        ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',1)
                                                        ->get();
                                                        $tipo_abono = DB::table('tbl_abonos')
                                                        ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',2)
                                                        ->get();
                                                        $tipo_ahorro = DB::table('tbl_abonos')
                                                        ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',3)
                                                        ->get();
                                                        $tipo_multa_1 = DB::table('tbl_abonos')
                                                        ->select(DB::raw('count(*) as tipo_multa_1'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',4)
                                                        ->get();
                                                            if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                $multa1=0;
                                                            }else {
                                                                $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                            }
                                                        $tipo_multa_2 = DB::table('tbl_abonos')
                                                        ->select(DB::raw('count(*) as tipo_multa_2'))
                                                        ->where('id_prestamo', '=', $cli->id_prestamo)
                                                        ->where('id_tipoabono','=',5)
                                                        ->get();
                                                            if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                $multa2=0;
                                                            }else {
                                                                $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                            }
                                                        $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                        $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                        // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                        $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                        $s_multa2=$producto[0]->penalizacion*$multa2;
                                                        $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                        $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                        $saldo_irrecuperable=$sistema_total_cobrar-$cliente_pago;
                                                        
                                                        //$t_semana_rojo+=$semana_n->cantidad;
                                                        $t_saldo_irrecuperable+=$saldo_irrecuperable;
                                                    
                                                    if ($saldo_irrecuperable==0){
                                                        
                                                    }else{
                                                        
                                                        // <tr>
                                                        //     <td style="color: gray; background: gray ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                        //     <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                        //     <td>{{$cli->id_prestamo}}</td>
                                                        //     <td>
                                                        //         @php
                                                                    $originalDate = $cli->fecha_entrega_recurso;
                                                                    $newDate = date("d/m/Y", strtotime($originalDate));
                                                                // @endphp
                                                                // {{$newDate}}
                                                        //     </td>
                                                        //     <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                        //     <td style="color:red;">
                                                        //             $ {{number_format($saldo_irrecuperable,1)}}
                                                        //     </td>
                                                        // </tr>

                                                        array_push($contenido_excel, array(
                                                            'color'=> 'Gris',
                                                            'nombre_completo' => $cli->nombre.' '.$cli->ap_paterno.' '.$cli->ap_materno, 
                                                            'id_prestamo' => $cli->id_prestamo, 
                                                            'fecha_entrega_recurso' => $newDate, 
                                                            'cantidad' => number_format($cli->cantidad,1), 
                                                            'saldo' => number_format($saldo_irrecuperable,1)
                                                        ));
                                                        
                                                    }
                                                }
                                            }
                                        }
                                    }else{
        
                                        if (count($semana_negra)==0){
                                            
                                        }else{
                                        // {{-- Estado negro y rojo solucionado---}}
                                            foreach ($semana_negra as $semana_n){
                                                // @php
                                                    $dias_transcurrido = $fecha_actual->diffInDays($semana_n->fecha_pago);
                                                    
                                                // @endphp
                                                if ($dias_transcurrido<45){
                                                
                                                    // {{-- Se coloca en estatus rojo --}}
                                                        // @php
                                                            $cliente = DB::table('tbl_prestamos')
                                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$semana_n->id_prestamo)
                                                                ->distinct()
                                                                ->get();
                                                        // @endphp
                                                        // {{-- <tr><td> roja{{$semana_n->cantidad}}</td> <td>{{$semana_n->id_prestamo}}</td></tr> --}}
                                                        foreach ($cliente as $cli){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$cli->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                //$t_semana_rojo+=$semana_n->cantidad;
                                                                $t_semana_rojo+=$saldo_rojo;
                                                            // @endphp
                                                            if ($saldo_rojo==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: red; background:red ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                                //     <td>{{$cli->id_prestamo}}</td>
                                                                //     <td>
                                                                        // @php
                                                                            $originalDate = $cli->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                        // @endphp
                                                                        // {{$newDate}}
                                                                    // </td>
                                                                    // <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                                    // <td style="color:red;">
                                                                    //         $ {{number_format($saldo_rojo,1)}}
                                                                    // </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'color'=> 'Rojo',
                                                                    'nombre_completo' => $cli->nombre.' '.$cli->ap_paterno.' '.$cli->ap_materno, 
                                                                    'id_prestamo' => $cli->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($cli->cantidad,1), 
                                                                    'saldo' => number_format($saldo_rojo,1)
                                                                ));
                                                                
                                                            }
                                                        }
                                                    
                                                    // {{-- menos de 45 dias : d: {{$dias_transcurrido}} s:{{$semana_n->semana}} c:{{$semana_n->cantidad}}  <br> --}}
                                                }elseif($dias_transcurrido>45){
                                                    // {{-- Se coloca ne estatus negro --}}
                                                        // @php
                                                            $clienten = DB::table('tbl_prestamos')
                                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$semana_n->id_prestamo)
                                                                ->distinct()
                                                                ->get();
                                                        // @endphp
                                                        foreach ($clienten as $clin){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$clin->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$clin->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                
                                                                //$t_semana_negra+=$semana_n->cantidad;
                                                                $t_semana_negra+=$saldo_negro;
                                                                
                                                            // @endphp
                                                            if ($saldo_negro==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: #000; background:black ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$clin->nombre}} {{$clin->ap_paterno}} {{$clin->ap_materno}}</td>
                                                                //     <td>{{$clin->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $clin->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                //         @endphp
                                                                //         {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($clin->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                            
                                                                //             $ {{number_format($saldo_negro,1)}}
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'color'=> 'Negro',
                                                                    'nombre_completo' => $clin->nombre.' '.$clin->ap_paterno.' '.$clin->ap_materno, 
                                                                    'id_prestamo' => $clin->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($clin->cantidad,1), 
                                                                    'saldo' => number_format($saldo_negro,1)
                                                                ));
                                                                
                                                            }
                                                        } 
                                                }else{
                                                    // {{-- <label>no hay datos</label> --}}
                                                }
                                            }
                                        }
                            
                                        if (count($semana_morado)==0){
                                            
                                        }else{
                                            foreach ($semana_morado as $semana_m){
                                            // {{-- Se coloca en estatus morado  --}}
                                                // @php
                                                    $dias_transcurrido_m = $fecha_actual->diffInDays($semana_m->fecha_pago);
                                                // @endphp
                                                if ($dias_transcurrido_m>45){
                                                    // {{-- Consultamos las semanas despues de 14 --}}
                                                    // @php
                                                        $abono_buscar=0;
                                                        $verificar_semanas=DB::table('tbl_abonos')
                                                        ->select('tbl_abonos.*')
                                                        ->where('semana','>',14)
                                                        ->where('id_prestamo','=',$semana_m->id_prestamo)
                                                        ->get();
                                                    // @endphp
                                                    // {{-- Preguntamos si hay elementos en la consulta --}}
                                                    if (count($verificar_semanas)==0){
                                                        
                                                    }else{
                                                        // {{-- Si hay elementos entonces recorremos y preguntamos si el tipo de abono
                                                        // no es multa  --}}
                                                        foreach ($verificar_semanas as $verificar_semana){
                                                            if ($verificar_semana->id_tipoabono==4){
                                                                
                                                            }elseif ($verificar_semana->id_tipoabono==5){
        
                                                            }else{
                                                                // @php
                                                                    $abono_buscar+=$verificar_semana->cantidad;
                                                                // @endphp
                                                            }
                                                            
                                                        }
                                                    }
                                                    if ($abono_buscar==0){
                                                    // {{-- Preguntamos si no hay cantidad de abono, para pasarlo a estado negro  --}}
                                                        // @php
                                                            $clienten = DB::table('tbl_prestamos')
                                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                                ->distinct()
                                                                ->get();
                                                        // @endphp
                                                        foreach ($clienten as $clin){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$clin->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$clin->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $clin->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                
                                                                //$t_semana_negra+=$semana_n->cantidad;
                                                                $t_semana_negra+=$saldo_negro;
                                                                
                                                            // @endphp
                                                            if ($saldo_negro==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: #000; background:black ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$clin->nombre}} {{$clin->ap_paterno}} {{$clin->ap_materno}}</td>
                                                                //     <td>{{$clin->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $clin->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                        // @endphp
                                                                        // {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($clin->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                            
                                                                //             $ {{number_format($saldo_negro,1)}}
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'color'=> 'Negro',
                                                                    'nombre_completo' => $clin->nombre.' '.$clin->ap_paterno.' '.$clin->ap_materno, 
                                                                    'id_prestamo' => $clin->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($clin->cantidad,1), 
                                                                    'saldo' => number_format($saldo_negro,1)
                                                                ));
                                                            }
                                                        }
                                                    }else{
                                                        // {{-- Si hay cantidad abono entonces lo pasamos a estado morado porque  --}}
                                                        // @php
                                                            //$t_semana_morado+=$semana_m->cantidad;
                                                            $clientem = DB::table('tbl_prestamos')
                                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                            ->distinct()
                                                            ->get();
                                                        // @endphp
                                                        foreach ($clientem as $clim){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$clim->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$clim->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $clim->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_morado=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                
                                                                //$t_semana_morado+=$semana_m->cantidad;
                                                                $t_semana_morado+=$saldo_morado;
                                                                
                                                            // @endphp
                                                            if ($saldo_morado==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: purple; background:purple ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$clim->nombre}} {{$clim->ap_paterno}} {{$clim->ap_materno}}</td>
                                                                //     <td>{{$clim->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $clim->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                //         @endphp
                                                                //         {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($clim->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                        
                                                                //         $ {{number_format($saldo_morado,1)}}    
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'color'=> 'Morado',
                                                                    'nombre_completo' => $clim->nombre.' '.$clim->ap_paterno.' '.$clim->ap_materno, 
                                                                    'id_prestamo' => $clim->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($clim->cantidad,1), 
                                                                    'saldo' => number_format($saldo_morado,1)
                                                                ));
                                                            }
                                                        }
                                                        
                                                    }
                                                
            
                                                }elseif($dias_transcurrido_m<45){
                                                    // {{-- Se coloca en estatus naranja --}}
                                                    // @php
                                                        $abono_buscar=0;
                                                        $verificar_semanas=DB::table('tbl_abonos')
                                                        ->select('tbl_abonos.*')
                                                        ->where('semana','>',14)
                                                        ->where('id_prestamo','=',$semana_m->id_prestamo)
                                                        ->get();
                                                    // @endphp
                                                    // {{-- Preguntamos si hay elementos en la consulta --}}
                                                    if (count($verificar_semanas)==0){
                                                        
                                                    }else{
                                                        // {{-- Si hay elementos entonces recorremos y preguntamos si el tipo de abono
                                                        // no es multa  --}}
                                                        foreach ($verificar_semanas as $verificar_semana){
                                                            if ($verificar_semana->id_tipoabono==4){
                                                                
                                                            }elseif ($verificar_semana->id_tipoabono==5){
        
                                                            }else{
                                                                // @php
                                                                    $abono_buscar+=$verificar_semana->cantidad;
                                                                // @endphp
                                                            }
                                                            
                                                        }
        
                                                    }
        
                                                    if ($abono_buscar==0){
                                                        // {{-- Se coloca en estatus rojo --}}
                                                        // @php
                                                            $cliente = DB::table('tbl_prestamos')
                                                                ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                                ->distinct()
                                                                ->get();
                                                        // @endphp
                                                        // {{-- <tr><td> roja{{$semana_n->cantidad}}</td> <td>{{$semana_n->id_prestamo}}</td></tr> --}}
                                                        foreach ($cliente as $cli){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$cli->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $cli->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                //$t_semana_rojo+=$semana_n->cantidad;
                                                                $t_semana_rojo+=$saldo_rojo;
                                                            // @endphp
                                                            if ($saldo_rojo==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: red; background:red ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                                //     <td>{{$cli->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $cli->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                //         @endphp
                                                                //         {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                //             $ {{number_format($saldo_rojo,1)}}
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'color'=> 'Rojo',
                                                                    'nombre_completo' => $cli->nombre.' '.$cli->ap_paterno.' '.$cli->ap_materno, 
                                                                    'id_prestamo' => $cli->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($cli->cantidad,1), 
                                                                    'saldo' => number_format($saldo_rojo,1)
                                                                ));
                                                                
                                                            }
                                                        }
                                                    }else{
                                                        // {{-- Si tiene movimiento entonces lo pasamos al color naranja --}}
                                                        // @php
                                                            $clientena = DB::table('tbl_prestamos')
                                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_m->id_prestamo)
                                                            ->distinct()
                                                            ->get();
                                                        // @endphp
                                                        foreach ($clientena as $clina){
                                                            // {{-- calculamos el saldo --}}
                                                            // @php
                                                                $producto = DB::table('tbl_productos')   
                                                                ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                ->select('tbl_productos.*')
                                                                ->where('tbl_prestamos.id_prestamo','=',$clina->id_prestamo)
                                                                ->get();
                                                                $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                ->select('cantidad')
                                                                ->where('id_prestamo','=',$clina->id_prestamo)
                                                                ->get();
                                                                $tipo_liquidacion = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',1)
                                                                ->get();
                                                                $tipo_abono = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',2)
                                                                ->get();
                                                                $tipo_ahorro = DB::table('tbl_abonos')
                                                                ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',3)
                                                                ->get();
                                                                $tipo_multa_1 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',4)
                                                                ->get();
                                                                    if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                        $multa1=0;
                                                                    }else {
                                                                        $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                    }
                                                                $tipo_multa_2 = DB::table('tbl_abonos')
                                                                ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                ->where('id_prestamo', '=', $clina->id_prestamo)
                                                                ->where('id_tipoabono','=',5)
                                                                ->get();
                                                                    if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                        $multa2=0;
                                                                    }else {
                                                                        $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                    }
                                                                $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                $saldo_naranja=$sistema_total_cobrar-$cliente_pago;
                                                                
                                                                $t_semana_naranja+=$saldo_naranja;
                                                            // @endphp
                                                            if ($saldo_naranja==0){
                                                                
                                                            }else{
                                                                // <tr>
                                                                //     <td style="color: orange; background:orange ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                //     <td>{{$clina->nombre}} {{$clina->ap_paterno}} {{$clina->ap_materno}}</td>
                                                                //     <td>{{$clina->id_prestamo}}</td>
                                                                //     <td>
                                                                //         @php
                                                                            $originalDate = $clina->fecha_entrega_recurso;
                                                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                                                //         @endphp
                                                                //         {{$newDate}}
                                                                //     </td>
                                                                //     <td>$ {{number_format($clina->cantidad,1)}}</td>
                                                                //     <td style="color:red;">
                                                                        
                                                                //         $ {{number_format($saldo_naranja,1)}}
                                                                    
                                                                //     </td>
                                                                // </tr>
                                                                array_push($contenido_excel, array(
                                                                    'color'=> 'Naranja',
                                                                    'nombre_completo' => $clina->nombre.' '.$clina->ap_paterno.' '.$clina->ap_materno, 
                                                                    'id_prestamo' => $clina->id_prestamo, 
                                                                    'fecha_entrega_recurso' => $newDate, 
                                                                    'cantidad' => number_format($clina->cantidad,1), 
                                                                    'saldo' => number_format($saldo_naranja,1)
                                                                ));
                                                                
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                            
                                        if (count($semana_amarillo)==0){
                                            
                                        }else{     
                                            foreach ($semana_amarillo as $semana_a){
                                                // @php
                                                    $dias_transcurrido_am = $fecha_actual->diffInDays($semana_a->fecha_pago);
        
                                                    $semanas_restantes=(14-$semana_a->semana)*7;
                                                    $vencido=$semanas_restantes+45;
                                                    
                                                // @endphp
                                                
                                                if ($dias_transcurrido_am>$vencido){
                                                    // {{-- Estado negro --}}
                                                    // @php
                                                        $clienten = DB::table('tbl_prestamos')
                                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                            ->distinct()
                                                            ->get();
                                                    // @endphp
                                                    foreach ($clienten as $clin){
                                                        // {{-- calculamos el saldo --}}
                                                        // @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$clin->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$clin->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $clin->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_negro=$sistema_total_cobrar-$cliente_pago;
                                                            
                                                            
                                                            //$t_semana_negra+=$semana_n->cantidad;
                                                            $t_semana_negra+=$saldo_negro;
                                                            
                                                        // @endphp
                                                        if ($saldo_negro==0){
                                                            
                                                        }else{
                                                            // <tr>
                                                            //     <td style="color: #000; background:black ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                            //     <td>{{$clin->nombre}} {{$clin->ap_paterno}} {{$clin->ap_materno}}</td>
                                                            //     <td>{{$clin->id_prestamo}}</td>
                                                            //     <td>
                                                            //         @php
                                                                        $originalDate = $clin->fecha_entrega_recurso;
                                                                        $newDate = date("d/m/Y", strtotime($originalDate));
                                                            //         @endphp
                                                            //         {{$newDate}}
                                                            //     </td>
                                                            //     <td>$ {{number_format($clin->cantidad,1)}}</td>
                                                            //     <td style="color:red;">
                                                                        
                                                            //             $ {{number_format($saldo_negro,1)}}
                                                            //     </td>
                                                            // </tr>
                                                            array_push($contenido_excel, array(
                                                                'color'=> 'Negro',
                                                                'nombre_completo' => $clin->nombre.' '.$clin->ap_paterno.' '.$clin->ap_materno, 
                                                                'id_prestamo' => $clin->id_prestamo, 
                                                                'fecha_entrega_recurso' => $newDate, 
                                                                'cantidad' => number_format($clin->cantidad,1), 
                                                                'saldo' => number_format($saldo_negro,1)
                                                            ));
                                                        }
                                                    }
                                                    
                                                }elseif($dias_transcurrido_am<$vencido && $dias_transcurrido_am>=$semanas_restantes){
                                                    // {{-- Estado rojo --}}
                                                    
                                                    // @php
        
                                                        $cliente = DB::table('tbl_prestamos')
                                                            ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                            ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                            ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                            ->distinct()
                                                            ->get();
                                                            // dd($dias_transcurrido_am);
                                                    // @endphp
                                                    foreach ($cliente as $cli){
                                                        // {{-- calculamos el saldo --}}
                                                        // @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$cli->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$cli->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $cli->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_rojo=$sistema_total_cobrar-$cliente_pago;
                                                            
                                                            //$t_semana_rojo+=$semana_n->cantidad;
                                                            $t_semana_rojo+=$saldo_rojo;
                                                        // @endphp
                                                        if ($saldo_rojo==0){
                                                            
                                                        }else{
                                                            // <tr>
                                                            //     <td style="color: red; background:red; margin: 3px; width: 20px; height: 15px;" >{{$dias_transcurrido_am}}</td>
                                                            //     <td>{{$cli->nombre}} {{$cli->ap_paterno}} {{$cli->ap_materno}}</td>
                                                            //     <td>{{$cli->id_prestamo}}</td>
                                                            //     <td>
                                                            //         @php
                                                                        $originalDate = $cli->fecha_entrega_recurso;
                                                                        $newDate = date("d/m/Y", strtotime($originalDate));
                                                            //         @endphp
                                                            //         {{$newDate}}
                                                            //     </td>
                                                            //     <td>$ {{number_format($cli->cantidad,1)}}</td>
                                                            //     <td style="color:red;">
                                                            //             $ {{number_format($saldo_rojo,1)}}
                                                            //     </td>
                                                            // </tr>
                                                            array_push($contenido_excel, array(
                                                                'color'=> 'Rojo',
                                                                'nombre_completo' => $cli->nombre.' '.$cli->ap_paterno.' '.$cli->ap_materno, 
                                                                'id_prestamo' => $cli->id_prestamo, 
                                                                'fecha_entrega_recurso' => $newDate, 
                                                                'cantidad' => number_format($cli->cantidad,1), 
                                                                'saldo' => number_format($saldo_rojo,1)
                                                            ));
                                                            
                                                            
                                                        }
                                                    }
                                                }elseif($dias_transcurrido_am<$semanas_restantes && $dias_transcurrido_am>7){
                                                        // {{-- estatus a amarillo --}}
                                                    // @php
                                                        //$t_semana_amarillo+=$abonos_in->cantidad;
                                                        $clienteam = DB::table('tbl_prestamos')
                                                        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                        ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                        ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                        ->distinct()
                                                        ->get();
                                                    // @endphp
                                                    foreach ($clienteam as $cliam){
                                                        // {{-- calculamos el saldo --}}
                                                        // @php
                                                            $producto = DB::table('tbl_productos')   
                                                            ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                            ->select('tbl_productos.*')
                                                            ->where('tbl_prestamos.id_prestamo','=',$cliam->id_prestamo)
                                                            ->get();
                                                            $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                            // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                            ->select('cantidad')
                                                            ->where('id_prestamo','=',$cliam->id_prestamo)
                                                            ->get();
                                                            $tipo_liquidacion = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',1)
                                                            ->get();
                                                            $tipo_abono = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',2)
                                                            ->get();
                                                            $tipo_ahorro = DB::table('tbl_abonos')
                                                            ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',3)
                                                            ->get();
                                                            $tipo_multa_1 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_1'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',4)
                                                            ->get();
                                                                if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                    $multa1=0;
                                                                }else {
                                                                    $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                }
                                                            $tipo_multa_2 = DB::table('tbl_abonos')
                                                            ->select(DB::raw('count(*) as tipo_multa_2'))
                                                            ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                            ->where('id_tipoabono','=',5)
                                                            ->get();
                                                                if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                    $multa2=0;
                                                                }else {
                                                                    $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                }
                                                            $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                            $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                            // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                            $s_multa2=$producto[0]->penalizacion*$multa2;
                                                            $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                            $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                            $saldo_amarillo=$sistema_total_cobrar-$cliente_pago;
                                                            
                                                            $t_semana_amarillo+=$saldo_amarillo;
                                                        // @endphp
                                                        if ($saldo_amarillo==0){
                                                            
                                                        }else{
                                                            // <tr>
                                                            //     <td style="color: yellow; background:yellow ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                            //     <td>{{$cliam->nombre}} {{$cliam->ap_paterno}} {{$cliam->ap_materno}}</td>
                                                            //     <td>{{$cliam->id_prestamo}}</td>
                                                            //     <td>
                                                            //         @php
                                                                        $originalDate = $cliam->fecha_entrega_recurso;
                                                                        $newDate = date("d/m/Y", strtotime($originalDate));
                                                            //         @endphp
                                                            //         {{$newDate}}
                                                            //     </td>
                                                            //     <td>$ {{number_format($cliam->cantidad,1)}}</td>
                                                            //     <td style="color:red;">
                                                                    
                                                            //         $ {{number_format($saldo_amarillo,1)}}
                                                            //     </td>
                                                            // </tr>
                                                            array_push($contenido_excel, array(
                                                                'color'=> 'Amarillo',
                                                                'nombre_completo' => $cliam->nombre.' '.$cliam->ap_paterno.' '.$cliam->ap_materno, 
                                                                'id_prestamo' => $cliam->id_prestamo, 
                                                                'fecha_entrega_recurso' => $newDate, 
                                                                'cantidad' => number_format($cliam->cantidad,1), 
                                                                'saldo' => number_format($saldo_amarillo,1)
                                                            ));
                                                            
                                                        }
                                                    }
        
        
                                                }elseif($dias_transcurrido_am<=7){
                                                    // @php
                                                        $abonos_incumplimiento = DB::table('tbl_abonos')
                                                        ->join('tbl_prestamos','tbl_abonos.id_prestamo','=','tbl_prestamos.id_prestamo')
                                                        ->select('tbl_prestamos.id_prestamo as pp','tbl_prestamos.cantidad','tbl_prestamos.id_status_prestamo')
                                                        ->where('tbl_abonos.id_prestamo','=',$semana_a->id_prestamo)
                                                        ->whereBetween('tbl_abonos.id_tipoabono', [4, 5])
                                                        ->distinct()
                                                        ->get();
                                                    // @endphp
                                                    if (count($abonos_incumplimiento)==0){
                                                        
                                                            // @php
                                                                //$t_semana_verde+=$semana_a->cantidad;
                                                                $clientev = DB::table('tbl_prestamos')
                                                                        ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                        ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                        ->where('tbl_prestamos.id_prestamo','=',$semana_a->id_prestamo)
                                                                        ->distinct()
                                                                        ->get();
                                                            // @endphp
                                                            foreach ($clientev as $cliv){
                                                                // {{-- calculamos el saldo --}}
                                                                // @php
                                                                    $producto = DB::table('tbl_productos')   
                                                                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                    ->select('tbl_productos.*')
                                                                    ->where('tbl_prestamos.id_prestamo','=',$cliv->id_prestamo)
                                                                    ->get();
                                                                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                    ->select('cantidad')
                                                                    ->where('id_prestamo','=',$cliv->id_prestamo)
                                                                    ->get();
                                                                    $tipo_liquidacion = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',1)
                                                                    ->get();
                                                                    $tipo_abono = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',2)
                                                                    ->get();
                                                                    $tipo_ahorro = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',3)
                                                                    ->get();
                                                                    $tipo_multa_1 = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',4)
                                                                    ->get();
                                                                        if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                            $multa1=0;
                                                                        }else {
                                                                            $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                        }
                                                                    $tipo_multa_2 = DB::table('tbl_abonos')
                                                                    ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                    ->where('id_prestamo', '=', $cliv->id_prestamo)
                                                                    ->where('id_tipoabono','=',5)
                                                                    ->get();
                                                                        if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                            $multa2=0;
                                                                        }else {
                                                                            $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                        }
                                                                    $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                    $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                    // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                    $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                    $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                    $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                    $saldo_verde=$sistema_total_cobrar-$cliente_pago;
                                                                    
                                                                    $t_semana_verde+=$saldo_verde;
                                                                // @endphp
                                                                if ($saldo_verde==0){
                                                                    
                                                                }else{
                                                                    // <tr>
                                                                    //     <td style="color: green; background:green ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                    //     <td>{{$cliv->nombre}} {{$cliv->ap_paterno}} {{$cliv->ap_materno}}</td>
                                                                    //     <td>{{$cliv->id_prestamo}}</td>
                                                                    //     <td>
                                                                    //         @php
                                                                                $originalDate = $cliv->fecha_entrega_recurso;
                                                                                $newDate = date("d/m/Y", strtotime($originalDate));
                                                                    //         @endphp
                                                                    //         {{$newDate}}
                                                                    //     </td>
                                                                    //     <td>$ {{number_format($cliv->cantidad,1)}}</td>
                                                                    //     <td style="color:red;">
                                                                            
                                                                    //         $ {{number_format($saldo_verde,1)}}
                                                                            
                                                                    //     </td>
                                                                    // </tr>
                                                                    array_push($contenido_excel, array(
                                                                        'color'=> 'Verde',
                                                                        'nombre_completo' => $cliv->nombre.' '.$cliv->ap_paterno.' '.$cliv->ap_materno, 
                                                                        'id_prestamo' => $cliv->id_prestamo, 
                                                                        'fecha_entrega_recurso' => $newDate, 
                                                                        'cantidad' => number_format($cliv->cantidad,1), 
                                                                        'saldo' => number_format($saldo_verde,1)
                                                                    ));
                                                                    
                                                                }
                                                            }
                                                    }else{
                                                    
                                                        foreach ($abonos_incumplimiento as $abonos_in){
                                                            
                                                                // @php
                                                                    //$t_semana_amarillo+=$abonos_in->cantidad;
                                                                    $clienteam = DB::table('tbl_prestamos')
                                                                    ->join('tbl_usuarios','tbl_prestamos.id_usuario','tbl_usuarios.id')
                                                                    ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
                                                                    ->select('tbl_datos_usuario.*','tbl_prestamos.*')
                                                                    ->where('tbl_prestamos.id_prestamo','=',$abonos_in->pp)
                                                                    ->distinct()
                                                                    ->get();
                                                                // @endphp
                                                                foreach ($clienteam as $cliam){
                                                                    // {{-- calculamos el saldo --}}
                                                                    // @php
                                                                        $producto = DB::table('tbl_productos')   
                                                                        ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                                                                        ->select('tbl_productos.*')
                                                                        ->where('tbl_prestamos.id_prestamo','=',$cliam->id_prestamo)
                                                                        ->get();
                                                                        $cantidad_prestamo = DB::table('tbl_prestamos')   
                                                                        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                                                                        ->select('cantidad')
                                                                        ->where('id_prestamo','=',$cliam->id_prestamo)
                                                                        ->get();
                                                                        $tipo_liquidacion = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',1)
                                                                        ->get();
                                                                        $tipo_abono = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',2)
                                                                        ->get();
                                                                        $tipo_ahorro = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',3)
                                                                        ->get();
                                                                        $tipo_multa_1 = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('count(*) as tipo_multa_1'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',4)
                                                                        ->get();
                                                                            if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                                                                                $multa1=0;
                                                                            }else {
                                                                                $multa1=$tipo_multa_1[0]->tipo_multa_1;
                                                                            }
                                                                        $tipo_multa_2 = DB::table('tbl_abonos')
                                                                        ->select(DB::raw('count(*) as tipo_multa_2'))
                                                                        ->where('id_prestamo', '=', $cliam->id_prestamo)
                                                                        ->where('id_tipoabono','=',5)
                                                                        ->get();
                                                                            if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                                                                                $multa2=0;
                                                                            }else {
                                                                                $multa2=$tipo_multa_2[0]->tipo_multa_2;
                                                                            }
                                                                        $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                                                                        $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                                                                        // $s_multa1=($cantidad_prestamo[0]->cantidad*0.1+$producto[0]->penalizacion)*$multa1;
                                                                        $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;
                                                                        $s_multa2=$producto[0]->penalizacion*$multa2;
                                                                        $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                                                                        $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                                                                        $saldo_amarillo=$sistema_total_cobrar-$cliente_pago;
                                                                        
                                                                        $t_semana_amarillo+=$saldo_amarillo;
                                                                    // @endphp
                                                                    if ($saldo_amarillo==0){
                                                                        
                                                                    }else{
                                                                        // <tr>
                                                                        //     <td style="color: yellow; background:yellow ; margin: 3px; width: 20px; height: 15px;" >000</td>
                                                                        //     <td>{{$cliam->nombre}} {{$cliam->ap_paterno}} {{$cliam->ap_materno}}</td>
                                                                        //     <td>{{$cliam->id_prestamo}}</td>
                                                                        //     <td>
                                                                        //         @php
                                                                                    $originalDate = $cliam->fecha_entrega_recurso;
                                                                                    $newDate = date("d/m/Y", strtotime($originalDate));
                                                                        //         @endphp
                                                                        //         {{$newDate}}
                                                                        //     </td>
                                                                        //     <td>$ {{number_format($cliam->cantidad,1)}}</td>
                                                                        //     <td style="color:red;">
                                                                                
                                                                        //         $ {{number_format($saldo_amarillo,1)}}
                                                                        //     </td>
                                                                        // </tr>
                                                                        array_push($contenido_excel, array(
                                                                            'color'=> 'Amarillo',
                                                                            'nombre_completo' => $cliam->nombre.' '.$cliam->ap_paterno.' '.$cliam->ap_materno, 
                                                                            'id_prestamo' => $cliam->id_prestamo, 
                                                                            'fecha_entrega_recurso' => $newDate, 
                                                                            'cantidad' => number_format($cliam->cantidad,1), 
                                                                            'saldo' => number_format($saldo_amarillo,1)
                                                                        ));
                                                                    }
                                                                }
                                                            
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
        //                     </tbody>
        //                 </table>
        //             </div> 
                                
        //                         @php
                                
        //                             $prestamos_total=0;
        //                             $cobrado_total=0;
        //                         @endphp
        
        //                         @foreach ($prestamos_suma as $p_suma)
        //                             @php
        //                                 $prestamos_total=$p_suma->total_prestamos;
        //                             @endphp
        //                         @endforeach
                               
        //                         @php
        //                             $cobrado_total+=$abonos_total;
        //                         @endphp
        //                         @php
        //                             $vigente=$t_semana_amarillo+$t_semana_verde;
        //                             $vencido=$t_semana_naranja+$t_semana_rojo+$t_semana_morado;
        //                             // $vencido_t=$t_semana_naranja+$t_semana_rojo+$t_semana_morado+$t_semana_negra;
        //                             $vencido_t=$t_semana_naranja+$t_semana_rojo+$t_semana_morado+$t_semana_negra;
        //                             // dd($vencido_t);
        
        //                             if ($prestamos_total==0) {
        //                                 $actual=0;
        //                                 $teorico=0;
        //                                 $irrecuperable=$t_saldo_irrecuperable;
        //                             } else {
                                        
        
        //                                 $r_teorico= (($vigente+$vencido_t + $cobrado_total -$prestamos_total)*100)/$prestamos_total;
        
        
        //                                 // $a=($vigente+$vencido_t)-$vencido_t;
        //                                 // $b=$vigente+$vencido_t;
        
        //                                 // $r_teorico= ($a*100)/$b;
                
        //                                 // $actual=round(((($cobrado_total-$prestamos_total)/$prestamos_total)*100),0);
        //                                 $actual=round(($cobrado_total-$prestamos_total)*100/$prestamos_total,0);
        //                                 // $actual=round(((($cobrado_total-$prestamos_total)/$prestamos_total)*100),0);
        //                                 $teorico=round(($r_teorico),0);
        //                                 $irrecuperable=round((($t_saldo_irrecuperable/$prestamos_total)*100),0);
        //                             }
                                
        //                         @endphp
        //                         {{-- aqui termina --}}
                      
        //         </div>
                                    
                               
        //         <div style="float: right; width: 25%;">
        //             <div style="margin-top: 10px">
                            
                            
        //                     <div style="border: solid 1px black; padding: 3px;">
                                
        //                         <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: gray"></div>
        //                         <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;"> $ {{number_format($t_saldo_irrecuperable,2)}}</div><br>
        //                         <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: black"></div>
        //                         <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;"> $ {{number_format($t_semana_negra,2)}}</div><br>
        //                         <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: purple"></div>
        //                         <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;"> $ {{number_format($t_semana_morado,2)}}</div><br>
        //                         <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: red"></div>
        //                         <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;"> $ {{number_format($t_semana_rojo,2)}}</div><br>
        //                         <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: orange"></div>
        //                         <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;"> $ {{number_format($t_semana_naranja,2)}}</div><br>
        //                         <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: yellow"></div>
        //                         <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;">$ {{number_format($t_semana_amarillo,2)}}</div><br>
        //                         <div style="font-size: 12px; float: left; width:  30%; padding: 0; margin: 0; height: 15px; background: green"></div>
        //                         <div style="font-size: 12px; text-align: right;        padding: 0; margin: 0; float: right; width: 70%;">$ {{number_format($t_semana_verde,2)}}</div><br>
        //                     </div>
        
        //                     <div style="padding: 2px; margin-top: 3px; border: black solid 1px">
        //                         <div style="font-size: 12px;  width: 50%; float: left;">Vigente</div>
        //                         <div style="font-size: 12px;  width: 50%; float: right; text-align: right">$ {{number_format($vigente,2)}}</div><br>
        //                         <div style="font-size: 12px;  width: 50%; float: left;">Vencido</div>
        //                         <div style="font-size: 12px;  width: 50%; float: right; text-align: right">$ {{number_format($vencido_t,2)}}</div><br>
        //                         {{-- <div style="font-size: 12px;  width: 50%; float: right; text-align: right">$ {{number_format($vencido,2)}}</div><br> --}}
        //                     </div>
        //                     <div style="padding: 2px; margin-top: 3px; border: solid black 1px">
        //                         <div style="font-size: 12px;  width: 50%; float: left;">Préstamos</div>
        //                         <div style="font-size: 12px;  width: 50%; float: right; text-align: right">$ {{number_format($prestamos_total,2)}}</div><br>
        //                         <div style="font-size: 12px;  width: 50%; float: left;">Total cobrado</div>
        //                         <div style="font-size: 12px;  width: 50%; float: right; text-align: right">$ {{number_format($cobrado_total,2)}}</div><br>
        //                     </div>
        //                     <div style="padding: 2px; margin-top: 3px; border: solid black 1px">
        //                         <div style="font-size: 12px;  width: 50%; float: left;">Actual</div>
        //                         <div style="font-size: 12px;  width: 50%; float: right; text-align: right">{{$actual}}%</div><br>
        //                         <div style="font-size: 12px;  width: 50%; float: left;">Teórico</div>
        //                         <div style="font-size: 12px;  width: 50%; float: right; text-align: right">{{$teorico}}%</div><br>
        //                         <div style="font-size: 12px;  width: 50%; float: left;">Irrecuperable</div>
        //                         <div style="font-size: 12px;  width: 50%; float: right; text-align: right">{{$irrecuperable}}%</div><br>
        //                     </div>
                            
                            
                       
        //             </div>
        //         </div>
        //     </div>   
        // </body>
        // </html>



            




        // Aqui termina la construccion del pdf 
        $pdf = PDF::loadView('reportes_grupos',['ultimos_abonos'=>$ultimos_abonos,'fecha_actual'=>$fecha_actual,'prestamos_suma'=>$prestamos_suma,'abonos_total'=>$abonos_total,'grupo'=>$grupo]);

        
        return $pdf->stream();

        // Aqui termina para el pdf 



        dd($zonas);


        // return Excel::download(new UserExport, 'user-list.xlsx');

    }

}
