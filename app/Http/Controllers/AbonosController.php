<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Abonos;
use App\Grupos;
use App\User;
use App\Plaza;
use App\Zona;
use App\Tipoabono;
use App\Penalizacion;
use Carbon\Carbon;
use App\Prestamos;
use Barryvdh\DomPDF\Facade as PDF;

class AbonosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','rol.admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abonos = DB::table('tbl_abonos')
            ->Join('tbl_prestamos', 'tbl_abonos.id_prestamo', '=', 'tbl_prestamos.id_prestamo')
            ->select('tbl_abonos.*', 'tbl_prestamos.id_prestamo')
            ->get();
        return view('admin.abonos.index',compact('abonos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $fidplaza='0';
        $regiones=Plaza::all();

        $fgrupo='0';
        $grupos = DB::table('tbl_grupos')
            ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
            ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
            ->select('tbl_grupos.*')
            ->where('tbl_grupos.IdZona','=',$fidplaza)
            ->distinct()
            ->get();
            return view('admin.abonos.create',['fgrupo'=>$fgrupo,'regiones'=>$regiones,'fidplaza'=>$fidplaza]);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('estas en store, contacta a un administrador de sistemas para que confiure la función');
        // $t_abono=$request->id_tipoabono;
        // $fecha_actual = Carbon::now();
        // $ultima_semana=$request->ultima_semana;
        // $semana=$request->semana;

        // $producto = DB::table('tbl_prestamos')
        // ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        // ->select('tbl_productos.*')
        // ->where('tbl_prestamos.id_prestamo','=',$request->id_prestamo)
        // ->get();

        // $multa_1=$producto[0]->cantidad*($producto[0]->pago_semanal/100)+$producto[0]->penalizacion;
        // $multa_2=$producto[0]->penalizacion;

        // if ($t_abono=='4') {

        //     $multas = DB::table('tbl_penalizacion')
        //     ->select('tbl_penalizacion.*')
        //     ->where('id_prestamo','=',$request->id_prestamo)
        //     ->get();
            
        //     if (count($multas)==0) {
        //         // dd('igual a cero'.$request->id_prestamo);
                
        //         if ($semana>=$ultima_semana) {
        //             $dato= new Abonos;
        //             $dato->id_prestamo=$request->id_prestamo;
        //             $dato->semana =$request->semana;
        //             $dato->cantidad ='0';
        //             $dato->fecha_pago =$request->fecha_pago;
        //             $dato->id_tipoabono = '2';
        //             $dato->save();
        //             return back()->with('status', '¡Abono agregado con éxito!');

        //         } else {
                    
        //             $dato= new Abonos;
        //             $dato->id_prestamo=$request->id_prestamo;
        //             $dato->semana =$request->semana;
        //             $dato->cantidad ='0';
        //             $dato->fecha_pago =$request->fecha_pago;
        //             $dato->id_tipoabono = '4';
        //             $dato->save();
                    
        //             $idabono_ac = Abonos::latest('id_abono')->first();
    
        //             $dato_pena= new Penalizacion;
        //             $dato_pena->id_prestamo=$request->id_prestamo;
        //             $dato_pena->id_abono=$idabono_ac->id_abono;
        //             $dato_pena->save();
    
        //             return back()->with('status', '¡Abono agregado con éxito!');
        //         }
                
        //     } else {


        //         if ($semana>=$ultima_semana) {
        //             $dato= new Abonos;
        //             $dato->id_prestamo=$request->id_prestamo;
        //             $dato->semana =$request->semana;
        //             $dato->cantidad ='0';
        //             $dato->fecha_pago =$request->fecha_pago;
        //             $dato->id_tipoabono = '2';
        //             $dato->save();
        //             return back()->with('status', '¡Abono agregado con éxito!');

        //         } else {
                    
        //             $dato= new Abonos;
        //             $dato->id_prestamo=$request->id_prestamo;
        //             $dato->semana =$request->semana;
        //             $dato->cantidad ='0';
        //             $dato->fecha_pago =$request->fecha_pago;
        //             $dato->id_tipoabono = '5';
        //             $dato->save();
                    
        //             $idabono_ac = Abonos::latest('id_abono')->first();
    
        //             $dato_pena= new Penalizacion;
        //             $dato_pena->id_prestamo=$request->id_prestamo;
        //             $dato_pena->id_abono=$idabono_ac->id_abono;
        //             $dato_pena->save();
    
        //             return back()->with('status', '¡Abono agregado con éxito!');
        //         }

        //     }
        // } elseif($t_abono=='5'){
        //     $multas = DB::table('tbl_penalizacion')
        //     ->select('tbl_penalizacion.*')
        //     ->where('id_prestamo','=',$request->id_prestamo)
        //     ->get();
        //     if (count($multas)==0) {
                
                
        //         if ($semana>=$ultima_semana) {
        //             $dato= new Abonos;
        //             $dato->id_prestamo=$request->id_prestamo;
        //             $dato->semana =$request->semana;
        //             $dato->cantidad ='0';
        //             $dato->fecha_pago =$request->fecha_pago;
        //             $dato->id_tipoabono = '2';
        //             $dato->save();
        //             return back()->with('status', '¡Abono agregado con éxito!');

        //         } else {
                    
        //             $dato= new Abonos;
        //             $dato->id_prestamo=$request->id_prestamo;
        //             $dato->semana =$request->semana;
        //             $dato->cantidad ='0';
        //             $dato->fecha_pago =$request->fecha_pago;
        //             $dato->id_tipoabono = '4';
        //             $dato->save();
                    
        //             $idabono_ac = Abonos::latest('id_abono')->first();
    
        //             $dato_pena= new Penalizacion;
        //             $dato_pena->id_prestamo=$request->id_prestamo;
        //             $dato_pena->id_abono=$idabono_ac->id_abono;
        //             $dato_pena->save();
    
        //             return back()->with('status', '¡Abono agregado con éxito!');
        //         }
                
        //     } else {


        //         if ($semana>=$ultima_semana) {
        //             $dato= new Abonos;
        //             $dato->id_prestamo=$request->id_prestamo;
        //             $dato->semana =$request->semana;
        //             $dato->cantidad ='0';
        //             $dato->fecha_pago =$request->fecha_pago;
        //             $dato->id_tipoabono = '2';
        //             $dato->save();
        //             return back()->with('status', '¡Abono agregado con éxito!');

        //         } else {
                    
        //             $dato= new Abonos;
        //             $dato->id_prestamo=$request->id_prestamo;
        //             $dato->semana =$request->semana;
        //             $dato->cantidad ='0';
        //             $dato->fecha_pago =$request->fecha_pago;
        //             $dato->id_tipoabono = '5';
        //             $dato->save();
                    
        //             $idabono_ac = Abonos::latest('id_abono')->first();
    
        //             $dato_pena= new Penalizacion;
        //             $dato_pena->id_prestamo=$request->id_prestamo;
        //             $dato_pena->id_abono=$idabono_ac->id_abono;
        //             $dato_pena->save();
    
        //             return back()->with('status', '¡Abono agregado con éxito!');
        //         }

        //     }
            
        // } else {

        //     $dato= new Abonos;
        //     $dato->id_prestamo=$request->id_prestamo;
        //     $dato->semana =$request->semana;
        //     $dato->cantidad =$request->cantidad;
        //     $dato->fecha_pago =$request->fecha_pago;
        //     $dato->id_tipoabono =$request->id_tipoabono;
        //     $dato->save();

        //     return back()->with('status', '¡Abono agregado con éxito!');
        // }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        // dd($request->all());

        if (empty($request->link)) {
            $link=0;
        } else {
            $link=$request->link;
        }

        $datos_prestamo = DB::table('tbl_abonos')
            ->Join('tbl_prestamos', 'tbl_abonos.id_prestamo', '=', 'tbl_prestamos.id_prestamo')
            ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
            ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
            ->select('tbl_grupos.*','tbl_prestamos.*','tbl_abonos.*','tbl_plaza.*','tbl_zona.*')
            ->where('tbl_abonos.id_abono','=',$id)
            ->get();
            // dd($datos);
        if (count($datos_prestamo)==0) {
            $id_grupo=null;
        } else {
            $id_grupo=$datos_prestamo[0]->id_grupo;
        }

        $abonos=Abonos::findOrFail($id);
        $tipoabono=Tipoabono::all();

        $penalizacion= DB::table('tbl_penalizacion')
        ->select('tbl_penalizacion.*')
        ->where('id_abono','=',$id)
        ->get();

        $cortes_semanas=DB::table('tbl_cortes_semanas')
        ->select('tbl_cortes_semanas.*')
        ->where('tbl_cortes_semanas.id_grupo','=',$id_grupo)
        ->orderBy('tbl_cortes_semanas.fecha_final','DESC')
        ->limit(15)
        ->get();

        return view('admin/abonos/edit', ['link'=>$link,'abonos'=>$abonos,'tipoabono'=>$tipoabono,'datos_prestamo'=>$datos_prestamo,'penalizacion'=>$penalizacion,'cortes_semanas'=>$cortes_semanas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd('Editando abono');
        // dd($request->all());
        $fecha_hoy=Carbon::now(); 
        $id_tipoabono=$request->id_tipoabono;

        $idZona=$request->idZona;
        $idregion=$request->idPlaza;
        $idGrupo=$request->idGrupo;
        $idPrestamo=$request->idPrestamo;
        $idCorte=$request->id_corte_semana;
        $cont=strlen($request->fecha_pago);
        
        // dd($cont);
        if ($cont<=9) {
            return back()->with('error', '¡La fecha de pago no es válido!');
        } else {
            $fecha_pago=$request->fecha_pago;
            $fe = str_split($fecha_pago);
            $diae=$fe[0].$fe[1];
            $mese=$fe[3].$fe[4];
            $añoe=$fe[6].$fe[7].$fe[8].$fe[9];
            
            $fecha_pago_fin = $añoe.'-'.$mese.'-'.$diae.' 00:00:00';

            $veficar_existencia_fecha= checkdate($mese,$diae,$añoe);

            // dd($veficar_existencia_fecha);
        }


       

      if ($veficar_existencia_fecha) {
          
      }
      else{
        return back()->with('error', '¡La fecha no existe en el calendario!');
      }


        $producto = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->select('tbl_productos.*','tbl_prestamos.*')
        ->where('tbl_prestamos.id_prestamo','=',$request->idPrestamo)
        ->get();

        $multa_1=$producto[0]->cantidad*($producto[0]->pago_semanal/100)+$producto[0]->penalizacion;
        $multa_2=$producto[0]->penalizacion;

        if ($id_tipoabono==4) {

            if ($request->tipo=='ninguno') {
                // Insertar una penalizacion
                $dato_pena= new Penalizacion;
                $dato_pena->id_prestamo=$idPrestamo;
                $dato_pena->id_abono=$id;
                $dato_pena->save();
                
                $idP = Penalizacion::latest('id_penalizacion')->first();
                
                  DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 1,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 8,
                        'id_movimiento' =>  $idP->id_penalizacion,
                        'descripcion' => "Se registró una penalización",
                        'fecha_registro' => $fecha_hoy
                    ]);
                
                

                // $datosAc=request()->except(['_token','_method','idZona','idPlaza','idGrupo','idPrestamo']);
                Abonos::where('id_abono','=',$id)->update([
                    // 'id_prestamo'    => $request->id_prestamo,
                    'semana'         => $request->semana,
                    'cantidad'       => $multa_1,
                    'fecha_pago'     => $fecha_pago_fin,
                    'id_tipoabono'   => $request->id_tipoabono,
                    'id_corte_semana'   => $idCorte
                ]);


                DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 2,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 1,
                        'id_movimiento' =>  $id,
                        'descripcion' => "Se actualizó un abono",
                        'fecha_registro' => $fecha_hoy
                    ]);


                
            } else {
                // $datosAc=request()->except(['_token','_method','idZona','idPlaza','idGrupo','idPrestamo']);
                Abonos::where('id_abono','=',$id)->update([
                    // 'id_prestamo'    => $request->id_prestamo,
                    'semana'         => $request->semana,
                    'cantidad'       => $multa_1,
                    'fecha_pago'     => $fecha_pago_fin,
                    'id_tipoabono'   => $request->id_tipoabono,
                    'id_corte_semana'   => $idCorte
                ]);
                
                    DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 2,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 1,
                        'id_movimiento' =>  $id,
                        'descripcion' => "Se actualizó un abono",
                        'fecha_registro' => $fecha_hoy
                    ]);
            }
            
        }else if($id_tipoabono==5){
            if ($request->tipo=='ninguno') {
                $dato_pena= new Penalizacion;
                $dato_pena->id_prestamo=$idPrestamo;
                $dato_pena->id_abono=$id;
                $dato_pena->save();
                
                $idP = Penalizacion::latest('id_penalizacion')->first();
                
                  DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 1,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 8,
                        'id_movimiento' => $idP->id_penalizacion,
                        'descripcion' => "Se registró una penalización",
                        'fecha_registro' => $fecha_hoy
                    ]);

                // $datosAc=request()->except(['_token','_method','idZona','idPlaza','idGrupo','idPrestamo']);
                Abonos::where('id_abono','=',$id)->update([
                    // 'id_prestamo'    => $request->id_prestamo,
                    'semana'         => $request->semana,
                    'cantidad'       => $multa_2,
                    'fecha_pago'     => $fecha_pago_fin,
                    'id_tipoabono'   => $request->id_tipoabono,
                    'id_corte_semana'   => $idCorte
                ]);
                
                DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 2,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 1,
                        'id_movimiento' =>  $id,
                        'descripcion' => "Se actualizó un abono",
                        'fecha_registro' => $fecha_hoy
                    ]);

            } else {
                // $datosAc=request()->except(['_token','_method','idZona','idPlaza','idGrupo','idPrestamo']);
                Abonos::where('id_abono','=',$id)->update([
                    // 'id_prestamo'    => $request->id_prestamo,
                    'semana'         => $request->semana,
                    'cantidad'       => $multa_2,
                    'fecha_pago'     => $fecha_pago_fin,
                    'id_tipoabono'   => $request->id_tipoabono,
                    'id_corte_semana'   => $idCorte
                ]);
                
                DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 2,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 1,
                        'id_movimiento' =>  $id,
                        'descripcion' => "Se actualizó un abono",
                        'fecha_registro' => $fecha_hoy
                    ]);
            }
            
        }else {
            // dd('Tipo abono');
            if ($request->tipo=='ninguno') {
                Abonos::where('id_abono','=',$id)->update([
                    // 'id_prestamo'    => $request->id_prestamo,
                    'semana'         => $request->semana,
                    'cantidad'       => $request->cantidad,
                    'fecha_pago'     => $fecha_pago_fin,
                    'id_tipoabono'   => $request->id_tipoabono,
                    'id_corte_semana'   => $idCorte
                ]);
                    DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 2,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 1,
                        'id_movimiento' =>  $id,
                        'descripcion' => "Se actualizó un abono",
                        'fecha_registro' => $fecha_hoy
                    ]);
            } else {
                DB::table('tbl_penalizacion')->where('id_abono', '=',$id)->delete();
                
                DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 3,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 8,
                        'id_movimiento' =>  $id,
                        'descripcion' => "Se eliminó una penalización",
                        'fecha_registro' => $fecha_hoy
                    ]);
            
                Abonos::where('id_abono','=',$id)->update([
                    // 'id_prestamo'    => $request->id_prestamo,
                    'semana'         => $request->semana,
                    'cantidad'       => $request->cantidad,
                    'fecha_pago'     => $fecha_pago_fin,
                    'id_tipoabono'   => $request->id_tipoabono,
                    'id_corte_semana'   => $idCorte
                ]);
                
                DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 2,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 1,
                        'id_movimiento' =>  $id,
                        'descripcion' => "Se actualizó un abono",
                        'fecha_registro' => $fecha_hoy
                    ]);
            }
        }

        return redirect('prestamo/abono/agregar-abono-c/'.$idZona.'/'.$idregion.'/'.$idGrupo.'/'.$idPrestamo)->with('status', '¡Registro Actualizado con éxito!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $fecha_hoy=Carbon::now(); 

        
        // Penalizacion::where('id_abono','=',)->destroy($id);
        DB::table('tbl_aportacion_empresa')->where('id_abono', '=',$id)->delete();
        DB::table('tbl_penalizacion')->where('id_abono', '=',$id)->delete();
        

        Abonos::destroy($id);
        
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 1,
            'id_movimiento' =>  $id,
            'descripcion' => "Se eliminó un abono",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Registro eliminado con éxito!');
    }


    public function abonosclientes(Request $request){

        $grupos=DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->orderBy('grupo','ASC')
        ->get();
        $f1=Carbon::now()->subweek();
        $f2=Carbon::now();
        $idgrupo=$request->idgrupo;
        $ultimasemana=$request->ultimasemana;

        if (empty($idgrupo)) {

            if (empty($ultimasemana)) {
                $idgrupo='';
                $ultimasemana='';
                $abonos_region=DB::table('tbl_abonos')
                ->Join('tbl_prestamos', 'tbl_abonos.id_prestamo', '=', 'tbl_prestamos.id_prestamo')
                ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')        
                ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
                ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
                ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
                ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
                ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono','tbl_datos_usuario.*','tbl_usuarios.id','tbl_grupos.id_grupo','tbl_grupos.grupo','tbl_usuarios.id')
                ->orderBy('id_abono','DESC')
                ->take(250)
                ->get();
                return view('admin.abonos.abonosclientes',['abonos_region'=>$abonos_region,'grupos'=>$grupos,'idgrupo'=>$idgrupo,'ultimasemana'=>$ultimasemana]);    
            } else {

                $abonos_region=DB::table('tbl_abonos')
                ->Join('tbl_prestamos', 'tbl_abonos.id_prestamo', '=', 'tbl_prestamos.id_prestamo')
                ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')        
                ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
                ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
                ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
                ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
                ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono','tbl_datos_usuario.*','tbl_usuarios.id','tbl_grupos.id_grupo','tbl_grupos.grupo')
                ->whereBetween('tbl_abonos.fecha_pago', [$f1, $f2])
                ->orderBy('id_abono','DESC')
                // ->take(250)
                ->get();
                return view('admin.abonos.abonosclientes',['abonos_region'=>$abonos_region,'grupos'=>$grupos,'idgrupo'=>$idgrupo,'ultimasemana'=>$ultimasemana]);
            }
            
            
        } else {

            if (empty($ultimasemana)) {
                $ultimasemana='';
                $abonos_region=DB::table('tbl_abonos')
                ->Join('tbl_prestamos', 'tbl_abonos.id_prestamo', '=', 'tbl_prestamos.id_prestamo')
                ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')        
                ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
                ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
                ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
                ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
                ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono','tbl_datos_usuario.*','tbl_usuarios.id','tbl_grupos.id_grupo','tbl_grupos.grupo')
                ->where('tbl_prestamos.id_grupo','=',$idgrupo)
                ->orderBy('id_abono','DESC')
                ->take(250)
                ->get();
                return view('admin.abonos.abonosclientes',['abonos_region'=>$abonos_region,'grupos'=>$grupos,'idgrupo'=>$idgrupo,'ultimasemana'=>$ultimasemana]);
            } else {
                $abonos_region=DB::table('tbl_abonos')
                ->Join('tbl_prestamos', 'tbl_abonos.id_prestamo', '=', 'tbl_prestamos.id_prestamo')
                ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')        
                ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
                ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
                ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
                ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
                ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono','tbl_datos_usuario.*','tbl_usuarios.id','tbl_grupos.id_grupo','tbl_grupos.grupo')
                ->where('tbl_prestamos.id_grupo','=',$idgrupo)
                ->whereBetween('tbl_abonos.fecha_pago', [$f1, $f2])
                ->orderBy('id_abono','DESC')
                ->take(250)
                ->get();
                return view('admin.abonos.abonosclientes',['abonos_region'=>$abonos_region,'grupos'=>$grupos,'idgrupo'=>$idgrupo,'ultimasemana'=>$ultimasemana]);
            }
            

        }
        
        
    }

    public function pdfabonosemana(){
        $f1=Carbon::now()->subweek();
        $f2=Carbon::now();
        $abonos_semana=DB::table('tbl_abonos')
        ->Join('tbl_prestamos', 'tbl_abonos.id_prestamo', '=', 'tbl_prestamos.id_prestamo')
        ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')        
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
        ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
        ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
        ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono','tbl_datos_usuario.*','tbl_grupos.grupo','tbl_plaza.Plaza','tbl_zona.Zona')
        ->whereBetween('tbl_abonos.fecha_pago', [$f1, $f2])
        ->orderBy('id_abono','DESC')
        ->get();

        $pdf = PDF::loadView('admin.abonos.pdf_semana',['fecha_hoy'=>$f2,'abonos_semana'=>$abonos_semana,'fecha1'=>$f1,'fecha2'=>$f2]);
        return $pdf->stream();
        
    }


    public function agregar_abono_c(Request $request,$idzona,$idregion,$idgrupo,$id_prestamo){
        // dd('Trabajando en esta pagina');
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $grupo= Grupos::find($idgrupo);

        if ($id_prestamo==0) {
            $id_prestamo=$request->id_presta;
        } else {
            $id_prestamo=$id_prestamo;
            // dd('no es cero jajaj');
        }

        $prestamo = DB::table('tbl_prestamos')
            ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
            ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
            ->select('tbl_prestamos.*','tbl_productos.*','tbl_status_prestamo.status_prestamo')
            ->where('tbl_prestamos.id_prestamo','=',$id_prestamo)
            ->distinct()
            ->get();

        $multa1 = DB::table('tbl_prestamos')
        ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        // ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
        ->select('tbl_abonos.*')
        ->where('tbl_prestamos.id_prestamo','=',$id_prestamo)
        ->where('tbl_abonos.id_tipoabono','=',4)
        ->distinct()
        ->get();
        // dd($multa1);

        $cliente = DB::table('tbl_usuarios')
            ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_usuarios.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_prestamos.id_prestamo')
            ->where('tbl_prestamos.id_prestamo','=',$id_prestamo)
            ->distinct()
            ->get();

        $clientesp = DB::table('tbl_usuarios')
        ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
        ->select('tbl_usuarios.*','tbl_productos.producto','tbl_status_prestamo.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_prestamos.*')
        ->where('tbl_prestamos.id_grupo','=',$idgrupo)
        ->orderBy('tbl_prestamos.fecha_entrega_recurso','DESC')
        ->get();


        $datosabonos=DB::table('tbl_abonos')
        ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
        ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono')
        ->where('id_prestamo', '=', $id_prestamo)
        ->orderBy('tbl_abonos.semana','ASC')
        ->get();

        $cortes_semanas=DB::table('tbl_cortes_semanas')
        ->select('tbl_cortes_semanas.*')
        ->where('tbl_cortes_semanas.id_grupo','=',$idgrupo)
        ->orderBy('tbl_cortes_semanas.fecha_final','DESC')
        ->limit(15)
        ->get();

        // dd($cortes_semanas);


        $tipoabono=Tipoabono::all();

        return view('admin.abonos.agrega_abonos',['region'=>$region,'zona'=>$zona,'idzona'=>$idzona,'grupo'=>$grupo,'cliente'=>$cliente,'datosabonos'=>$datosabonos,'prestamo'=>$prestamo,'tipoabono'=>$tipoabono,'clientesp'=>$clientesp,'multa1'=>$multa1,'cortes_semanas'=>$cortes_semanas]);
    }

    public function recibo_abono($idprestamo){
// dd('dfsdfsdfds');
        $region_zona = DB::table('tbl_prestamos')
        ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
        ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')

        ->select('tbl_plaza.*','tbl_zona.*','tbl_grupos.*')
        ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
        ->get();
        // dd($region_zona);

        $prestamo = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        ->select('tbl_prestamos.*','tbl_productos.*','tbl_status_prestamo.status_prestamo')
        ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
        ->get();

        // $cliente = DB::table('tbl_usuarios')
        // ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
        // ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        // // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        // ->select('tbl_usuarios.*','tbl_datos_usuario.*')
        // ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
        // // ->distinct()
        // ->get();
        
        $cliente = DB::table('tbl_prestamos')
            ->join('tbl_datos_usuario','tbl_prestamos.id_usuario','tbl_datos_usuario.id_usuario')
            ->Join('tbl_socio_economico', 'tbl_prestamos.id_usuario', '=', 'tbl_socio_economico.id_usuario')
            ->Join('tbl_se_datos_generales', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_se_datos_generales.id_socio_economico')
            ->Join('tbl_domicilio', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_domicilio.id_socio_economico')
            ->Join('tbl_vivienda', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_vivienda.id_socio_economico')
            ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
            ->select('tbl_datos_usuario.id_usuario as id','tbl_se_datos_generales.*','tbl_vivienda.*','tbl_domicilio.*')
            ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
            ->distinct()
            ->get();

            // dd($cliente);


        $aval = DB::table('tbl_socio_economico')
        ->Join('tbl_prestamos', 'tbl_socio_economico.id_usuario', '=', 'tbl_prestamos.id_usuario')
        ->Join('tbl_se_aval', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_se_aval.id_socio_economico')
        ->Join('tbl_avales', 'tbl_se_aval.id_aval', '=', 'tbl_avales.id_aval')
        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        ->select('tbl_avales.*')
        ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
        ->distinct()
        ->get();

        $datosabonos=DB::table('tbl_abonos')
        ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
        ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono')
        ->where('id_prestamo', '=', $idprestamo)
        ->orderBy('tbl_abonos.semana','ASC')
        ->get();

        $fecha_de_hoy=Carbon::now();

        $pdf = PDF::loadView('admin.abonos.pdf_abono',['fecha_de_hoy'=>$fecha_de_hoy,'region_zona'=>$region_zona,'cliente'=>$cliente,'datosabonos'=>$datosabonos,'prestamo'=>$prestamo,'aval'=>$aval]);

        // $pdf = PDF::loadView('admin.abonos.pdf_abono',['datoscliente'=>$datoscliente,'abonos'=>$abonos]);
        return $pdf->stream();
        
    }

    public function ahorro(Request $request){
       dd('Contacta un administrador de sistemas para que configure la función de ahorro');
        // $fecha_ahorro=Carbon::now();
        // $ahorro = Abonos::create([
        //     'id_prestamo'    => $request->id_prestamo,
        //     'semana'         => '0',
        //     'cantidad'       => $request->cantidad,
        //     'fecha_pago'     => $fecha_ahorro,
        //     'id_tipoabono'   => '3'
        // ])->save();

        // return back()->with('status', '¡Felicidades por ahorrar!');
    }


    public function historial_abonos_cliente($idgrupo,$id_abono){
// dd('okjhgf');

        $region_zona = DB::table('tbl_plaza')
            ->Join('tbl_zona', 'tbl_plaza.IdPlaza', '=', 'tbl_zona.IdPlaza')
            ->Join('tbl_grupos', 'tbl_zona.IdZona', '=', 'tbl_grupos.IdZona')
            
            ->select('tbl_plaza.*','tbl_zona.*','tbl_grupos.*')
            ->where('tbl_grupos.id_grupo','=',$idgrupo)
            ->get();
            // dd($region_zona);

        $prestamo = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
        ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        ->select('tbl_prestamos.*','tbl_productos.*','tbl_status_prestamo.status_prestamo')
        ->where('tbl_abonos.id_abono','=',$id_abono)
        ->get();

        // $cliente = DB::table('tbl_usuarios')
        //     ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
        //     ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        //     ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        //     ->select('tbl_usuarios.*','tbl_datos_usuario.*')
        //     ->where('tbl_abonos.id_abono','=',$id_abono)
        //     // ->distinct()
        //     ->get();

        $cliente = DB::table('tbl_prestamos')
            ->join('tbl_datos_usuario','tbl_prestamos.id_usuario','tbl_datos_usuario.id_usuario')
            ->Join('tbl_socio_economico', 'tbl_prestamos.id_usuario', '=', 'tbl_socio_economico.id_usuario')
            ->Join('tbl_se_datos_generales', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_se_datos_generales.id_socio_economico')
            ->Join('tbl_domicilio', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_domicilio.id_socio_economico')
            ->Join('tbl_vivienda', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_vivienda.id_socio_economico')
            ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
            ->select('tbl_se_datos_generales.*','tbl_vivienda.*','tbl_domicilio.*')
            // ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
            ->where('tbl_abonos.id_abono','=',$id_abono)
            ->distinct()
            ->get();


        // $cliente = DB::table('tbl_prestamos')
        //     ->Join('tbl_socio_economico', 'tbl_prestamos.id_usuario', '=', 'tbl_socio_economico.id_usuario')
        //     ->Join('tbl_se_datos_generales', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_se_datos_generales.id_socioeconomico')
        //     ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        //     ->select('tbl_se_datos_generales.*')
        //     ->where('tbl_abonos.id_abono','=',$id_abono)
        //     ->get();

            // dd($cliente);

        $aval = DB::table('tbl_socio_economico')
        ->Join('tbl_prestamos', 'tbl_socio_economico.id_usuario', '=', 'tbl_prestamos.id_usuario')
        ->Join('tbl_se_aval', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_se_aval.id_socio_economico')
        ->Join('tbl_avales', 'tbl_se_aval.id_aval', '=', 'tbl_avales.id_aval')
        ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        ->select('tbl_avales.*')
        ->where('tbl_abonos.id_abono','=',$id_abono)
        ->distinct()
        ->get();


        $datosabonos=DB::table('tbl_abonos')
        ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
        ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono')
        ->where('id_prestamo', '=', $prestamo[0]->id_prestamo)
        ->orderBy('tbl_abonos.semana','ASC')
        ->get();
        $fecha_de_hoy=Carbon::now();

        $pdf = PDF::loadView('admin.abonos.prueba_pdf',['fecha_de_hoy'=>$fecha_de_hoy,'region_zona'=>$region_zona,'cliente'=>$cliente,'datosabonos'=>$datosabonos,'prestamo'=>$prestamo,'aval'=>$aval]);
    
        // $pdf = PDF::loadView('admin.abonos.pdf_abono',['datoscliente'=>$datoscliente,'abonos'=>$abonos]);
        return $pdf->stream();

    }
    
    
    public function abonosguardarvarios(Request $request){
// dd('akjskasjkjj');
        $fecha_hoy=Carbon::now(); 
        $input =$request->all();
        
        $semana_corte_actual=DB::table('tbl_cortes_semanas')
        ->select('tbl_cortes_semanas.*')
        ->where('id_grupo','=',$request->id_grupo)
        ->orderBy('numero_semana_corte','ASC')
        ->get();
        
        if(count($semana_corte_actual)==0){
            return back()->with('error', '¡Se necesita configuración de la fecha de corte semana!');
        } else {
            
            // dd($corte_semana);
    
            if (empty($request->semana_e)) {
                return back()->with('error', '¡No hay abonos que registrar!');
            } else {
                foreach ($input["semana_e"] as $key => $value) {
    
                    $t_abono=$input["id_tipoabono_e"][$key];
                    $fecha_actual = Carbon::now();
                    $id_prestamo=$request->id_prestamo;
                    $ultima_semana=$request->ultima_semana;
                    $semana=$value;
                    $fecha_pago=$input["fecha_pago_e"][$key];
                    $cantidad=$input["cantidad_e"][$key];

                    // $corte_semana=$semana_corte_actual->last()->id_corte_semana;
                    $corte_semana=$input["corte_e"][$key];


        
                    $producto = DB::table('tbl_prestamos')
                    ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
                    ->select('tbl_productos.*','tbl_prestamos.*')
                    ->where('tbl_prestamos.id_prestamo','=',$id_prestamo)
                    ->get();
        
                    $multa_1=$producto[0]->cantidad*($producto[0]->pago_semanal/100)+$producto[0]->penalizacion;
                    $multa_2=$producto[0]->penalizacion;
                    // dd('espere unos minutos porfavor'.$multa_1,$multa_2);
        
                    // dd($t_abono,$ultima_semana,$semana);
                    if ($t_abono=='4') {
        
                        $multas = DB::table('tbl_penalizacion')
                        ->select('tbl_penalizacion.*')
                        ->where('id_prestamo','=',$request->id_prestamo)
                        ->get();
                        
                        if (count($multas)==0) {
                            // dd('igual a cero'.$request->id_prestamo);
                            
                            if ($semana>$ultima_semana) {
                                $dato= new Abonos;
                                $dato->id_prestamo=$request->id_prestamo;
                                $dato->semana =$semana;
                                $dato->cantidad ='0';
                                $dato->fecha_pago =$fecha_pago;
                                $dato->id_tipoabono = '2';
                                $dato->id_corte_semana = $corte_semana;
                                $dato->save();
                                
                                $idA = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idA->id_abono,
                                    'descripcion' => "Se registró un abono",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                                
                                
                                // return back()->with('status', '¡Abono agregado con éxito!');
        
                            } else {
                                
                                $dato= new Abonos;
                                $dato->id_prestamo=$request->id_prestamo;
                                $dato->semana =$semana;
                                $dato->cantidad =$multa_1;
                                $dato->fecha_pago =$fecha_pago;
                                $dato->id_tipoabono = '4';
                                $dato->id_corte_semana = $corte_semana;
                                $dato->save();
                                
                                $idA = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idA->id_abono,
                                    'descripcion' => "Se registró un abono",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                                
                                $idabono_ac = Abonos::latest('id_abono')->first();
                
                                $dato_pena= new Penalizacion;
                                $dato_pena->id_prestamo=$request->id_prestamo;
                                $dato_pena->id_abono=$idabono_ac->id_abono;
                                $dato_pena->save();
                                
                                $idP = Penalizacion::latest('id_penalizacion')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 8,
                                    'id_movimiento' =>  $idP->id_penalizacion,
                                    'descripcion' => "Se registró una penalización",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                
                                // return back()->with('status', '¡Abono agregado con éxito!');
                            }
                            
                        } else {
        
        
                            if ($semana>$ultima_semana) {
                                $dato= new Abonos;
                                $dato->id_prestamo=$request->id_prestamo;
                                $dato->semana =$semana;
                                $dato->cantidad ='0';
                                $dato->fecha_pago =$fecha_pago;
                                $dato->id_tipoabono = '2';
                                $dato->id_corte_semana = $corte_semana;
                                $dato->save();
                                
                                $idA = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idA->id_abono,
                                    'descripcion' => "Se registró un abono",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                                // return back()->with('status', '¡Abono agregado con éxito!');
        
                            } else {
                                
                                $dato= new Abonos;
                                $dato->id_prestamo=$request->id_prestamo;
                                $dato->semana =$semana;
                                $dato->cantidad =$multa_2;
                                $dato->fecha_pago =$fecha_pago;
                                $dato->id_tipoabono = '5';
                                $dato->id_corte_semana = $corte_semana;
                                $dato->save();
                                
                                $idA = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idA->id_abono,
                                    'descripcion' => "Se registró un abono",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                                
                                $idabono_ac = Abonos::latest('id_abono')->first();
                
                                $dato_pena= new Penalizacion;
                                $dato_pena->id_prestamo=$request->id_prestamo;
                                $dato_pena->id_abono=$idabono_ac->id_abono;
                                $dato_pena->save();
                                
                                $idP = Penalizacion::latest('id_penalizacion')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 8,
                                    'id_movimiento' =>  $idP->id_penalizacion,
                                    'descripcion' => "Se registró una penalización",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                
                                // return back()->with('status', '¡Abono agregado con éxito!');
                            }
        
                        }
                    } elseif($t_abono=='5'){
                        $multas = DB::table('tbl_penalizacion')
                        ->select('tbl_penalizacion.*')
                        ->where('id_prestamo','=',$request->id_prestamo)
                        ->get();
                        if (count($multas)==0) {
                            
                            
                            if ($semana>$ultima_semana) {
                                $dato= new Abonos;
                                $dato->id_prestamo=$request->id_prestamo;
                                $dato->semana =$semana;
                                $dato->cantidad ='0';
                                $dato->fecha_pago =$fecha_pago;
                                $dato->id_tipoabono = '2';
                                $dato->id_corte_semana = $corte_semana;
                                $dato->save();
                                
                                $idA = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idA->id_abono,
                                    'descripcion' => "Se registró un abono",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                                
                                // return back()->with('status', '¡Abono agregado con éxito!');
        
                            } else {
                                
                                $dato= new Abonos;
                                $dato->id_prestamo=$request->id_prestamo;
                                $dato->semana =$semana;
                                $dato->cantidad =$multa_1;
                                $dato->fecha_pago =$fecha_pago;
                                $dato->id_tipoabono = '4';
                                $dato->id_corte_semana = $corte_semana;
                                $dato->save();
                                
                                $idA = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idA->id_abono,
                                    'descripcion' => "Se registró un abono",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                                
                                $idabono_ac = Abonos::latest('id_abono')->first();
                
                                $dato_pena= new Penalizacion;
                                $dato_pena->id_prestamo=$request->id_prestamo;
                                $dato_pena->id_abono=$idabono_ac->id_abono;
                                $dato_pena->save();
                
                                $idP = Penalizacion::latest('id_penalizacion')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 8,
                                    'id_movimiento' =>  $idP->id_penalizacion,
                                    'descripcion' => "Se registró una penalización",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                
                                // return back()->with('status', '¡Abono agregado con éxito!');
                            }
                            
                        } else {
        
        
                            if ($semana>$ultima_semana) {
                                $dato= new Abonos;
                                $dato->id_prestamo=$request->id_prestamo;
                                $dato->semana =$semana;
                                $dato->cantidad ='0';
                                $dato->fecha_pago =$fecha_pago;
                                $dato->id_tipoabono = '2';
                                $dato->id_corte_semana = $corte_semana;
                                $dato->save();
                                
                                $idA = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idA->id_abono,
                                    'descripcion' => "Se registró un abono",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                                
                                // return back()->with('status', '¡Abono agregado con éxito!');
        
                            } else {
                                
                                $dato= new Abonos;
                                $dato->id_prestamo=$request->id_prestamo;
                                $dato->semana =$semana;
                                $dato->cantidad =$multa_2;
                                $dato->fecha_pago =$fecha_pago;
                                $dato->id_tipoabono = '5';
                                $dato->id_corte_semana = $corte_semana;
                                $dato->save();
                                
                                $idA = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idA->id_abono,
                                    'descripcion' => "Se registró un abono",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                                
                                $idabono_ac = Abonos::latest('id_abono')->first();
                
                                $dato_pena= new Penalizacion;
                                $dato_pena->id_prestamo=$request->id_prestamo;
                                $dato_pena->id_abono=$idabono_ac->id_abono;
                                $dato_pena->save();
                                
                                $idP = Penalizacion::latest('id_penalizacion')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 8,
                                    'id_movimiento' =>  $idP->id_penalizacion,
                                    'descripcion' => "Se registró una penalización",
                                    'fecha_registro' => $fecha_hoy
                                ]);
                
                                // return back()->with('status', '¡Abono agregado con éxito!');
                            }
        
                        }
                        
                    } elseif($t_abono=='1') {
        
                        $dato= new Abonos;
                        $dato->id_prestamo=$request->id_prestamo;
                        $dato->semana =$semana;
                        $dato->cantidad =$cantidad;
                        $dato->fecha_pago =$fecha_pago;
                        $dato->id_tipoabono =$t_abono;
                        $dato->id_corte_semana = $corte_semana;
                        $dato->save();
                        
                        $idA = Abonos::latest('id_abono')->first();
                        DB::table('tbl_log')->insert([
                            'id_log' => null, 
                            'id_tipo' => 1,
                            'id_plataforma' => 2,
                            'id_usuario' => Auth::user()->id,
                            'id_tipo_movimiento' => 1,
                            'id_movimiento' =>  $idA->id_abono,
                            'descripcion' => "Se registró un abono",
                            'fecha_registro' => $fecha_hoy
                        ]);
    
                        Prestamos::where('id_prestamo','=',$id_prestamo)->update([
                            'id_status_prestamo'=>'8',
                        ]);
                        
                        DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 2,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 2,
                                    'id_movimiento' =>  $id_prestamo,
                                    'descripcion' => "Se actualizó un préstamo a pagado",
                                    'fecha_registro' => $fecha_hoy
                                ]);
        
                        // return back()->with('status', '¡Abono agregado con éxito!');
                    } else {
        
                        $dato= new Abonos;
                        $dato->id_prestamo=$request->id_prestamo;
                        $dato->semana =$semana;
                        $dato->cantidad =$cantidad;
                        $dato->fecha_pago =$fecha_pago;
                        $dato->id_tipoabono =$t_abono;
                        $dato->id_corte_semana = $corte_semana;
                        $dato->save();
                        
                        $idA = Abonos::latest('id_abono')->first();
                        DB::table('tbl_log')->insert([
                            'id_log' => null, 
                            'id_tipo' => 1,
                            'id_plataforma' => 2,
                            'id_usuario' => Auth::user()->id,
                            'id_tipo_movimiento' => 1,
                            'id_movimiento' =>  $idA->id_abono,
                            'descripcion' => "Se registró un abono",
                            'fecha_registro' => $fecha_hoy
                        ]);
        
                        // return back()->with('status', '¡Abono agregado con éxito!');
                    }
                }
                return back()->with('status', '¡Abonos guardados con éxito!');
            }
        }

    }

}
