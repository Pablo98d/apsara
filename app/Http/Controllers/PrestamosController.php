<?php

namespace App\Http\Controllers;
use App\Exports;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Prestamos;
use App\Grupos;
use App\Plaza;
use App\Zona;
use Carbon\Carbon;
use App\Abonos;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Http;

class PrestamosController extends Controller
{
    
    public function eliminar()
    {
        Cache:flush();
        dd('Se ejecutó elminar caché');
        
    }
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
        $prestamos = DB::table('tbl_prestamos')
            ->Join('tbl_usuarios as cliente', 'tbl_prestamos.id_usuario', '=', 'cliente.id')
            ->Join('tbl_datos_usuario as datos_cliente', 'cliente.id', '=', 'datos_cliente.id_usuario')

            ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
            ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_usuarios as promotora', 'tbl_prestamos.id_promotora', '=', 'promotora.id')
            ->Join('tbl_datos_usuario as datos_promotora', 'promotora.id', '=', 'datos_promotora.id_usuario')

            ->Join('tbl_usuarios as administrador', 'tbl_prestamos.id_autorizo', '=', 'administrador.id')
            ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
            ->select('tbl_prestamos.*', 'cliente.nombre_usuario as cliente','datos_promotora.nombre as pro_nombre','datos_promotora.ap_paterno as pro_paterno','datos_promotora.ap_materno as pro_materno','datos_cliente.nombre as cli_nombre','datos_cliente.ap_paterno as cli_paterno','datos_cliente.ap_materno as cli_materno','tbl_productos.producto','cliente.id as id','tbl_status_prestamo.status_prestamo','tbl_grupos.grupo','promotora.nombre_usuario as promotora','administrador.nombre_usuario as administrador')
            ->orderBy('id_prestamo','DESC')
            ->limit(50)
            ->get();
            
        return view('admin.prestamos.index',compact('prestamos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos = DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->orderBy('grupo','ASC')
        ->get();
        
        $clientes = DB::table('tbl_usuarios')
            ->Join('tbl_tipo_usuario', 'tbl_usuarios.id_tipo_usuario', '=', 'tbl_tipo_usuario.id_tipo_usuario')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_datos_usuario')
            
            ->select('tbl_usuarios.*','tbl_datos_usuario.*','tbl_tipo_usuario.nombre as n_tipo')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('tbl_prestamos')
                        ->whereRaw('tbl_prestamos.id_usuario = tbl_usuarios.id');
            })
            ->orderBy('tbl_datos_usuario.nombre','ASC')
            ->get();


        $administradores = DB::table('tbl_usuarios')
        ->where('id_tipo_usuario','=',1)
        ->get();

        $productos = DB::table('tbl_productos')
        ->get();

        $statusp=DB::table('tbl_status_prestamo')->get();
        return view('admin.prestamos.create',['grupos'=>$grupos,'clientes'=>$clientes,'statusp'=>$statusp,'administradores'=>$administradores,'productos'=>$productos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fechas=$request->fecha_solicitud;
        $fs = str_split($fechas);
       
        if (count($fs)<15) {
                return back()->with('error', 'Por favor la fecha debe contener la hora');
        } else {
            $dias=$fs[0].$fs[1];
            $mess=$fs[3].$fs[4];
            $años=$fs[6].$fs[7].$fs[8].$fs[9];
            $hs=$fs[11].$fs[12];
            $ms=$fs[14].$fs[15];
        }
        
        $fecha_solicitud = $años.'-'.$mess.'-'.$dias.' '.$hs.':'.$ms.':00';

        $fechaa=$request->fecha_aprovacion;
        $fe = str_split($fechaa);
        
        if (count($fe)<15) {
                return back()->with('error', 'Por favor la fecha debe contener la hora');
        } else {
           $dia=$fe[0].$fe[1];
            $mes=$fe[3].$fe[4];
            $año=$fe[6].$fe[7].$fe[8].$fe[9];
            $h=$fe[11].$fe[12];
            $m=$fe[14].$fe[15];
        }
        
        $fecha_aprovacion = $año.'-'.$mes.'-'.$dia.' '.$h.':'.$m.':00';

        $fechaentrega=$request->fecha_entrega_recurso;
        $fe = str_split($fechaentrega);
        
        if (count($fe)<15) {
                return back()->with('error', 'Por favor la fecha debe contener la hora');
        } else {
           $diae=$fe[0].$fe[1];
            $mese=$fe[3].$fe[4];
            $añoe=$fe[6].$fe[7].$fe[8].$fe[9];
            $he=$fe[11].$fe[12];
            $me=$fe[14].$fe[15];
        }
        
        $fecha_entrega_recurso = $añoe.'-'.$mese.'-'.$diae.' '.$he.':'.$me.':00';

       
        $prestamo = Prestamos::create([
            'id_usuario'        => $request->id_usuario,
            'id_status_prestamo'      => $request->id_status_prestamo,
            'id_grupo'      => $request->id_grupo,
            'id_promotora'    => $request->id_promotora,
            'id_producto' => $request->id_producto,
            'id_autorizo' => $request->id_autorizo,
            'cantidad' => $request->cantidad,
            'fecha_solicitud' => $fecha_solicitud,
            'fecha_entrega_recurso' => $fecha_entrega_recurso,
            'fecha_aprovacion' => $fecha_aprovacion

        ])->save();
        
        $idP = Prestamos::latest('id_prestamo')->first();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 2,
            'id_movimiento' =>  $idP->id_prestamo,
            'descripcion' => "Se registró un préstamo",
            'fecha_registro' => null
        ]);

        return redirect()->route('prestamos.index')->with('Guardar','Registro Guardado con Exito !!!');
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
        // dd($request->all(),$id);
        if (empty($request->link)) {
            $link_retroceder=0;
        } else {
            $link_retroceder=$request->link;
        }
        
        $grupos = DB::table('tbl_grupos')
        ->orderby('grupo','ASC')
        ->get();
        $clientes = DB::table('tbl_usuarios')
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        ->select('tbl_usuarios.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
        ->orderBy('tbl_datos_usuario.nombre','ASC')
        ->get();

        $administradores = DB::table('tbl_usuarios')
        ->where('id_tipo_usuario','=',1)
        ->get();

        $productos = DB::table('tbl_productos')
        ->get();

        $statusp=DB::table('tbl_status_prestamo')->orderBy('status_prestamo','ASC')->get();

        $prestamo=Prestamos::find($id);
        //dd($prestamo);
        $promotoras = DB::table('tbl_grupos_promotoras')
        ->Join('tbl_datos_usuario', 'tbl_grupos_promotoras.id_usuario', '=', 'tbl_datos_usuario.id_usuario')
        ->select('tbl_grupos_promotoras.*','tbl_datos_usuario.*')
        ->where('tbl_grupos_promotoras.id_grupo','=',$prestamo->id_grupo)
        ->get();


        return view('admin.prestamos.edit',['grupos'=>$grupos,'clientes'=>$clientes,'promotoras'=>$promotoras,'statusp'=>$statusp,'administradores'=>$administradores,'productos'=>$productos,'prestamo'=>$prestamo,'link_retroceder'=>$link_retroceder]);
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
        $fecha_pago = $fecha_hoy=Carbon::now();
       dd($request->all());
       
        $fechas=$request->fecha_solicitud;
        $fs = str_split($fechas);
        $dias=$fs[0].$fs[1];
        $mess=$fs[3].$fs[4];
        $años=$fs[6].$fs[7].$fs[8].$fs[9];
        $hs=$fs[11].$fs[12];
        $ms=$fs[14].$fs[15];
        $fecha_solicitud = $años.'-'.$mess.'-'.$dias.' '.$hs.':'.$ms.':00';

        $fechaa=$request->fecha_aprovacion;
        $fe = str_split($fechaa);
        $dia=$fe[0].$fe[1];
        $mes=$fe[3].$fe[4];
        $año=$fe[6].$fe[7].$fe[8].$fe[9];
        $h=$fe[11].$fe[12];
        $m=$fe[14].$fe[15];
        $fecha_aprovacion = $año.'-'.$mes.'-'.$dia.' '.$h.':'.$m.':00';

        $fechaentrega=$request->fecha_entrega_recurso;
        $fe = str_split($fechaentrega);
        $diae=$fe[0].$fe[1];
        $mese=$fe[3].$fe[4];
        $añoe=$fe[6].$fe[7].$fe[8].$fe[9];
        $he=$fe[11].$fe[12];
        $me=$fe[14].$fe[15];
        $fecha_entrega_recurso = $añoe.'-'.$mese.'-'.$diae.' '.$he.':'.$me.':00';
        
        if ($request->id_status_prestamo==6) {
            // dd('es inactivo');

            $verificar_mas_prestamos= DB::table('tbl_prestamos')
            ->select('tbl_prestamos.*')
            ->where('tbl_prestamos.id_usuario','=',$request->id_usuario)
            ->where('tbl_prestamos.id_status_prestamo','=',9)
            ->get();

            //preguntamos si hay prestamos renovados
            if (count($verificar_mas_prestamos)==0) {
                Prestamos::where('id_prestamo','=',$id)->update([
                    'id_usuario'=>$request->id_usuario,
                    'fecha_solicitud'=>$fecha_solicitud,
                    'id_status_prestamo'=>$request->id_status_prestamo,
                    'id_grupo'=>$request->id_grupo,
                    'id_promotora'=>$request->id_promotora,
                    'id_producto'=>$request->id_producto,
                    'id_autorizo'=>$request->id_autorizo,
                    'fecha_aprovacion'=>$fecha_aprovacion,
                    'fecha_entrega_recurso'=>$fecha_entrega_recurso,
                    'cantidad'=>$request->cantidad,
        
                ]);
                $fecha_pago = $fecha_hoy=Carbon::now();
                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 2,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 2,
                    'id_movimiento' =>  $id,
                    'descripcion' => "Se actualizó un préstamo, a inactivo",
                    'fecha_registro' => $fecha_pago
                ]);
            } else {
                
                // dd('tiene prestamos 9');
                //si hay entonces proseguimos a aplicar estas funciones
                foreach ($verificar_mas_prestamos as $verificar_mas_p) {
                    $producto = DB::table('tbl_productos')   
                    ->Join('tbl_prestamos', 'tbl_productos.id_producto', '=', 'tbl_prestamos.id_producto')
                    ->select('tbl_productos.*')
                    ->where('tbl_prestamos.id_prestamo','=',$verificar_mas_p->id_prestamo)
                    ->get();
                    $cantidad_prestamo = DB::table('tbl_prestamos')   
                    // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
                    ->select('cantidad')
                    ->where('id_prestamo','=',$verificar_mas_p->id_prestamo)
                    ->get();
                    $tipo_liquidacion = DB::table('tbl_abonos')
                    ->select(DB::raw('SUM(cantidad) as tipo_liquidacion'))
                    ->where('id_prestamo', '=', $verificar_mas_p->id_prestamo)
                    ->where('id_tipoabono','=',1)
                    ->get();
                    $tipo_abono = DB::table('tbl_abonos')
                    ->select(DB::raw('SUM(cantidad) as tipo_abono'))
                    ->where('id_prestamo', '=', $verificar_mas_p->id_prestamo)
                    ->where('id_tipoabono','=',2)
                    ->get();
                    $tipo_ahorro = DB::table('tbl_abonos')
                    ->select(DB::raw('SUM(cantidad) as tipo_ahorro'))
                    ->where('id_prestamo', '=', $verificar_mas_p->id_prestamo)
                    ->where('id_tipoabono','=',3)
                    ->get();
                    $tipo_multa_1 = DB::table('tbl_abonos')
                    ->select(DB::raw('count(*) as tipo_multa_1'))
                    ->where('id_prestamo', '=', $verificar_mas_p->id_prestamo)
                    ->where('id_tipoabono','=',4)
                    ->get();
                        if (empty($tipo_multa_1[0]->tipo_multa_1)) {
                            $multa1=0;
                        }else {
                            $multa1=$tipo_multa_1[0]->tipo_multa_1;
                        }
                    $tipo_multa_2 = DB::table('tbl_abonos')
                    ->select(DB::raw('count(*) as tipo_multa_2'))
                    ->where('id_prestamo', '=', $verificar_mas_p->id_prestamo)
                    ->where('id_tipoabono','=',5)
                    ->get();
                        if (empty($tipo_multa_2[0]->tipo_multa_2)) {
                            $multa2=0;
                        }else {
                            $multa2=$tipo_multa_2[0]->tipo_multa_2;
                        }
                    $interes=$cantidad_prestamo[0]->cantidad*($producto[0]->reditos/100);
                    $papeleo=$cantidad_prestamo[0]->cantidad*($producto[0]->papeleria/100);
                    $s_multa1=(($producto[0]->pago_semanal/100)*$cantidad_prestamo[0]->cantidad+$producto[0]->penalizacion)*$multa1;

                    $s_multa2=$producto[0]->penalizacion*$multa2;
                    $sistema_total_cobrar=$cantidad_prestamo[0]->cantidad+$interes+$papeleo+$s_multa1+$s_multa2;
                    $cliente_pago=$tipo_liquidacion[0]->tipo_liquidacion+$tipo_abono[0]->tipo_abono+$tipo_ahorro[0]->tipo_ahorro;
                    $liquidar=$sistema_total_cobrar-$cliente_pago;
                    $liquidacion=$liquidar;


                    $prestamos_pagados=DB::table('tbl_prestamos')
                    ->select('tbl_prestamos.*')
                    ->where('tbl_prestamos.id_prestamo','=',$request->id_usuario)
                    ->where('tbl_prestamos.id_status_prestamo','=',8)
                    ->get();

                    if ($liquidacion<=0) {
                        Prestamos::where('id_prestamo','=',$verificar_mas_p->id_prestamo)->update([
                            'id_status_prestamo'=>8,
                
                        ]);
                        $fecha_pago = $fecha_hoy=Carbon::now();
                        DB::table('tbl_log')->insert([
                            'id_log' => null, 
                            'id_tipo' => 2,
                            'id_plataforma' => 2,
                            'id_usuario' => Auth::user()->id,
                            'id_tipo_movimiento' => 2,
                            'id_movimiento' =>  $verificar_mas_p->id_prestamo,
                            'descripcion' => "Se actualizó préstamo a pagado, por motivo del préstamo aprobado que se pasó a inactivo",
                            'fecha_registro' => $fecha_pago
                        ]);


                    } else if($liquidacion>0){
                        if (count( $prestamos_pagados)==0) {
                            Prestamos::where('id_prestamo','=',$verificar_mas_p->id_prestamo)->update([
                                'id_status_prestamo'=>2,
                    
                            ]);
                            $fecha_pago = $fecha_hoy=Carbon::now();
                            DB::table('tbl_log')->insert([
                                'id_log' => null, 
                                'id_tipo' => 2,
                                'id_plataforma' => 2,
                                'id_usuario' => Auth::user()->id,
                                'id_tipo_movimiento' => 2,
                                'id_movimiento' =>  $verificar_mas_p->id_prestamo,
                                'descripcion' => "Se actualizó préstamo a activo, por motivo del préstamo aprobado que se pasó a inactivo",
                                'fecha_registro' => $fecha_pago
                            ]);
                        } else {
                            Prestamos::where('id_prestamo','=',$verificar_mas_p->id_prestamo)->update([
                                'id_status_prestamo'=> 9,
                    
                            ]);
                            $fecha_pago = $fecha_hoy=Carbon::now();
                            DB::table('tbl_log')->insert([
                                'id_log' => null, 
                                'id_tipo' => 2,
                                'id_plataforma' => 2,
                                'id_usuario' => Auth::user()->id,
                                'id_tipo_movimiento' => 2,
                                'id_movimiento' =>  $verificar_mas_p->id_prestamo,
                                'descripcion' => "Se actualizó préstamo a renovación, por motivo del préstamo aprobado que se pasó a inactivo",
                                'fecha_registro' => $fecha_pago
                            ]);
                        }
                        
                    }
                    
                }

                Prestamos::where('id_prestamo','=',$id)->update([
                    'id_usuario'=>$request->id_usuario,
                    'fecha_solicitud'=>$fecha_solicitud,
                    'id_status_prestamo'=>$request->id_status_prestamo,
                    'id_grupo'=>$request->id_grupo,
                    'id_promotora'=>$request->id_promotora,
                    'id_producto'=>$request->id_producto,
                    'id_autorizo'=>$request->id_autorizo,
                    'fecha_aprovacion'=>$fecha_aprovacion,
                    'fecha_entrega_recurso'=>$fecha_entrega_recurso,
                    'cantidad'=>$request->cantidad,
        
                ]);
                $fecha_pago = $fecha_hoy=Carbon::now();
                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 2,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 2,
                    'id_movimiento' =>  $id,
                    'descripcion' => "Se actualizó préstamo a inactivo",
                    'fecha_registro' => $fecha_pago
                ]);


            }
            

        } else {
            Prestamos::where('id_prestamo','=',$id)->update([
                'id_usuario'=>$request->id_usuario,
                'fecha_solicitud'=>$fecha_solicitud,
                'id_status_prestamo'=>$request->id_status_prestamo,
                'id_grupo'=>$request->id_grupo,
                'id_promotora'=>$request->id_promotora,
                'id_producto'=>$request->id_producto,
                'id_autorizo'=>$request->id_autorizo,
                'fecha_aprovacion'=>$fecha_aprovacion,
                'fecha_entrega_recurso'=>$fecha_entrega_recurso,
                'cantidad'=>$request->cantidad,
    
            ]);
            
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 2,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 2,
                'id_movimiento' =>  $id,
                'descripcion' => "Se actualizó préstamo",
                'fecha_registro' => $fecha_pago
            ]);
        
            if ($request->id_autorizo_actual==$request->id_autorizo) {
                
            } else {

                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 2,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 2,
                    'id_movimiento' =>  $id,
                    'descripcion' => "El préstamo #".$id." fué autorizado por el usuario: #".$request->id_autorizo,
                    'fecha_registro' => $fecha_pago
                ]);
            }
                
        }
        
        return back()->with('status', '¡Registro actualizado con éxito!');

        // return redirect()->route('prestamos.index')->with('Guardar','¡Registro Actualizado con Exito!');
    }

    public function update_prestamo_se(Request $request){
        

        // foreach ($variable as $key => $value) {
        //     # code...
        // }
        // Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'Authorization' => 'key=AAAAvjiJblE:APA91bGkQ7E6gd8B4piMDYR8o8srtz7jLrTShGPldYYn1MA_9gEbLlHycg93LBFXOSGlqXsQ1w3FXlLCDxPcGaH-yQphr07bbj9o8PQ_WBDiMR0fiSAjB2KQHbnx_rTuEkJxug_yaXN8'
        // ])->post('https://fcm.googleapis.com/fcm/send',
        // [
        //     "notification"=> [
        //         "title"=> "Prueba desde Postman",
        //         "body"=> "Prueba para el J8"
        //     ],
        //     "priority"=>"high",
        //     "data" => [
        //         "product"=>"Pruebas desde Guadalajara"
        //     ],
        //     "to" => "eOIbIP9QQrOSh63DBEEgd2:APA91bEdnx_ERh0220eym1qx-0peNzr6vLI97w0yoSaJ1rWr2Kh8vcdKTpixgPSvEAZQXxdvfUP8C4Gi3mNSz7TYq6yoRZUQig6WPOYotwONn3ekSlTgiZMejTxJ2jRXNRB8HFFm42Ce"
        // ]);


        // dd($request->all());
        $fecha_solicitud_listo=$request->fecha_solicitud.' '.$request->hora_solicitud;
        // dd($fecha_solicitud_listo);

        Prestamos::where('id_prestamo','=',$request->id_prestamo)->update([
            'fecha_solicitud'=>$fecha_solicitud_listo,
            'cantidad'=>$request->cantidad,
            'id_producto'=>$request->id_producto,
        ]);
        return back()->with('status', '¡Detalles de préstamo actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Prestamos::destroy($id);
        $fecha_pago = $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 2,
            'id_movimiento' =>  $id,
            'descripcion' => "Se eliminó un préstamo",
            'fecha_registro' => $fecha_pago
        ]);
        return redirect()->route('prestamos.index')->with('Guardar','¡Registro eliminado con Exito !');
    }
    public function filtroabonos(Request $request){
        
        $id_grupo=$request->id_grupo;
        //dd($idGrupo);
        $prestamos='0';

        $clientes = DB::table('tbl_usuarios')
            ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_usuarios.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
            ->where('tbl_prestamos.id_grupo','=',$id_grupo)
            ->distinct()
            ->get();

        $fgrupo=$id_grupo;
        $id='';
      
        return view('admin.abonos.create',['grupos'=>$grupos,'gclientes'=>$clientes,'fgrupo'=>$fgrupo,'prestamos'=>$prestamos,'idcliente'=>$id]);
    }

    public function buscar_zonas(Request $request){
        $idregion=$request->id_region;
        $regiones=Plaza::all();
        if(empty($idregion)){
            $zonas = '';
            return view('admin.prestamos.buscar_prestamo1',['regiones'=>$regiones,'zonas'=>$zonas,'idregion'=>$idregion]);

        } else {
            $zonas = DB::table('tbl_zona')
                ->select('tbl_zona.*')
                ->where('IdPlaza','=',$idregion)
                ->orderBy('Zona','ASC')
                ->get();

                // dd($zonas);
            return view('admin.prestamos.buscar_prestamo1',['regiones'=>$regiones,'zonas'=>$zonas,'idregion'=>$idregion]);
        }

    }
    public function buscar_grupos(Request $request,$idzona,$idregion){
        $region=Plaza::find($idregion);
        // dd('que pasó me estas buscando');
        
        // dd($idzona);
        if(empty($request->id_zona)) {
            $idzona=$idzona;
        }elseif($idzona==0){
            $idzona=$request->id_zona;
            // dd($idzona);
        }
        
        $zona = Zona::find($idzona);

        // dd($idzona);
        
        $zonas = DB::table('tbl_grupos')
        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
        ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
        // ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
        ->select('tbl_zona.*')
        ->where('tbl_plaza.IdPlaza','=',$idregion)
        ->orderBy('tbl_zona.Zona','ASC')
        ->distinct()
        ->get();

        // dd($zonas);

        $grupos = DB::table('tbl_grupos')
        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
        // ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
        ->select('tbl_grupos.*','tbl_zona.Zona','tbl_zona.IdZona')
        ->where('tbl_grupos.IdZona','=',$idzona)
        ->orderBy('tbl_grupos.grupo','ASC')
        ->distinct()
        ->get();

        return view('admin.prestamos.buscar_gruposp',['region'=>$region,'zona'=>$zona,'grupos'=>$grupos,'zonas'=>$zonas]);
    }
    public function buscar_clientes(Request $request,$idzona,$idregion,$idgrupo){
      
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $fecha_actual=Carbon::now();
        // dd($fecha_actual);
        // $grupo= Grupos::find($idgrupo);

        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$idregion)
        ->orderBy('Zona','ASC')
        ->get();



        if ($idgrupo==0) {
            $idgrupo=$request->id_grupo;
        } else {
            $idgrupo=$idgrupo;
            // dd('no es cero jajaj');
        }
        if (empty($request->id_estatus_buscar)) {
            $id_status=2;
        } else {
            $id_status=$request->id_estatus_buscar;
        }
        
        
        $grupo= Grupos::find($idgrupo);

        $grupos=DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->where('IdZona','=',$idzona)
        ->get();

        $estatus_prestamo=DB::table('tbl_status_prestamo')
        ->select('tbl_status_prestamo.*')
        ->get();


        $prestamos_sin_producto = DB::table('tbl_prestamos')
            ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_datos_usuario.*','tbl_prestamos.*','tbl_status_prestamo.*')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('tbl_productos')
                        ->whereRaw('tbl_productos.id_producto = tbl_prestamos.id_producto');
            })
            ->where('tbl_prestamos.id_grupo','=',$idgrupo)
            ->get();

            // dd($prestamos_sin_producto);
        $prestamos_aprobados = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->select('tbl_prestamos.*')
        ->where('id_status_prestamo','=',10)
        ->where('id_grupo','=',$idgrupo)
        ->get();

        $prestamos_devolucion = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->select('tbl_prestamos.*')
        ->where('id_status_prestamo','=',17)
        ->where('id_grupo','=',$idgrupo)
        ->get();
        

        $ultimos_abonos = DB::table('v_estadisticas')
        ->select('v_estadisticas.*')
        ->where('grupo','=',$idgrupo)
        ->get();

        $prestamos_liquidacion_renovacion = DB::table('tbl_prestamos')
        ->select('tbl_prestamos.*')
        ->where('id_grupo','=',$idgrupo)
        ->where('id_status_prestamo','=',19)
        ->get();
        // dd($prestamos_liquidacion_renovacion);
        // dd($ultimos_abonos);

        // dd($prestamos_aprobados);
            if($id_status=='todo')
                $clientes = DB::table('tbl_usuarios')
                ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
                ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
                ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
                ->select('tbl_usuarios.*','tbl_productos.producto','tbl_status_prestamo.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_prestamos.*')
                ->where('tbl_prestamos.id_grupo','=',$idgrupo)
                ->orderBy('tbl_prestamos.fecha_entrega_recurso','DESC')
                ->get();
            elseif ($id_status==2) {
                $clientes = DB::table('tbl_usuarios')
                ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
                ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
                ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
                ->select('tbl_usuarios.*','tbl_productos.producto','tbl_status_prestamo.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_prestamos.*')
                ->where('tbl_prestamos.id_grupo','=',$idgrupo)
                ->whereIn('tbl_prestamos.id_status_prestamo',[2,9,20])
                ->orderBy('tbl_prestamos.fecha_entrega_recurso','DESC')
                ->get();
                
            } else {
                $clientes = DB::table('tbl_usuarios')
                ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
                ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
                ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
                ->select('tbl_usuarios.*','tbl_productos.producto','tbl_status_prestamo.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_prestamos.*')
                ->where('tbl_prestamos.id_grupo','=',$idgrupo)
                ->where('tbl_prestamos.id_status_prestamo','=',$id_status)
                ->orderBy('tbl_prestamos.fecha_entrega_recurso','DESC')
                ->get();
            }
            

        return view('admin.prestamos.buscar_cliente',['prestamos_liquidacion_renovacion'=>$prestamos_liquidacion_renovacion,'region'=>$region,'zona'=>$zona,'idzona'=>$idzona,'grupo'=>$grupo,'clientes'=>$clientes,'prestamos_sin_producto'=>$prestamos_sin_producto,'prestamos_devolucion'=>$prestamos_devolucion,'prestamos_aprobados'=>$prestamos_aprobados,'grupos'=>$grupos,'fecha_actual'=>$fecha_actual,'ultimos_abonos'=>$ultimos_abonos,'estatus_prestamo'=>$estatus_prestamo,'id_status'=>$id_status,'zonas'=>$zonas]);
    }

    public function prestamo_nuevo($idregion,$idzona,$idgrupo){

        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $grupo= Grupos::find($idgrupo);

        $gerente_zona= DB::table('tbl_zonas_gerentes')
        ->Join('tbl_usuarios', 'tbl_zonas_gerentes.id_usuario', '=', 'tbl_usuarios.id')
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        ->Join('tbl_zona', 'tbl_zonas_gerentes.id_zona', '=', 'tbl_zona.IdZona')
        ->select('tbl_datos_usuario.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->get();
        

        $prestamos = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_usuarios as cliente', 'tbl_prestamos.id_usuario', '=', 'cliente.id')
        ->Join('tbl_datos_usuario as clientedatos', 'cliente.id', '=', 'clientedatos.id_usuario')
        ->Join('tbl_usuarios as promotor', 'tbl_prestamos.id_promotora', '=', 'promotor.id')
        ->Join('tbl_datos_usuario as promotordatos', 'promotor.id', '=', 'promotordatos.id_usuario')

        ->select('tbl_prestamos.*','tbl_productos.*','cliente.id as id_cliente','clientedatos.nombre as nombre_cliente','clientedatos.ap_paterno as paterno_cliente','clientedatos.ap_materno as materno_cliente','promotordatos.nombre as nombre_pro','promotordatos.ap_paterno as paterno_pro','promotordatos.ap_materno as materno_pro')
        ->where('id_status_prestamo','=',10)
        ->where('id_grupo','=',$idgrupo)
        ->get();
        return view('admin.prestamos.prestamos_nuevos',['prestamos'=>$prestamos,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'gerente_zona'=>$gerente_zona]);
    }

    public function prestamo_devolucion($idregion,$idzona,$idgrupo){

        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $grupo= Grupos::find($idgrupo);

        $gerente_zona= DB::table('tbl_zonas_gerentes')
        ->Join('tbl_usuarios', 'tbl_zonas_gerentes.id_usuario', '=', 'tbl_usuarios.id')
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        ->Join('tbl_zona', 'tbl_zonas_gerentes.id_zona', '=', 'tbl_zona.IdZona')
        ->select('tbl_datos_usuario.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->get();

        $prestamos = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_usuarios as cliente', 'tbl_prestamos.id_usuario', '=', 'cliente.id')
        ->Join('tbl_datos_usuario as clientedatos', 'cliente.id', '=', 'clientedatos.id_usuario')
        ->Join('tbl_usuarios as promotor', 'tbl_prestamos.id_promotora', '=', 'promotor.id')
        ->Join('tbl_datos_usuario as promotordatos', 'promotor.id', '=', 'promotordatos.id_usuario')

        ->select('tbl_prestamos.*','tbl_productos.*','cliente.id as id_cliente','clientedatos.nombre as nombre_cliente','clientedatos.ap_paterno as paterno_cliente','clientedatos.ap_materno as materno_cliente','promotordatos.nombre as nombre_pro','promotordatos.ap_paterno as paterno_pro','promotordatos.ap_materno as materno_pro')
        ->where('id_status_prestamo','=',17)
        ->where('id_grupo','=',$idgrupo)
        ->get();
        return view('admin.prestamos.devolucion_prestamo',['prestamos'=>$prestamos,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'gerente_zona'=>$gerente_zona]);
    }

    public function pdf_reciboprestamos($idregion,$idzona,$idgrupo){

        //Imprime recibo pdf---------------------
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $grupo= Grupos::find($idgrupo);

        $gerente_zona= DB::table('tbl_zonas_gerentes')
        ->Join('tbl_usuarios', 'tbl_zonas_gerentes.id_usuario', '=', 'tbl_usuarios.id')
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        ->Join('tbl_zona', 'tbl_zonas_gerentes.id_zona', '=', 'tbl_zona.IdZona')
        ->select('tbl_datos_usuario.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->get();

        $prestamos = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_usuarios as cliente', 'tbl_prestamos.id_usuario', '=', 'cliente.id')
        ->Join('tbl_datos_usuario as clientedatos', 'cliente.id', '=', 'clientedatos.id_usuario')
        ->Join('tbl_usuarios as promotor', 'tbl_prestamos.id_promotora', '=', 'promotor.id')
        ->Join('tbl_datos_usuario as promotordatos', 'promotor.id', '=', 'promotordatos.id_usuario')

        ->select('tbl_prestamos.*','tbl_productos.*','cliente.id as id_cliente','clientedatos.nombre as nombre_cliente','clientedatos.ap_paterno as paterno_cliente','clientedatos.ap_materno as materno_cliente','promotordatos.nombre as nombre_pro','promotordatos.ap_paterno as paterno_pro','promotordatos.ap_materno as materno_pro')
        ->where('id_status_prestamo','=',10)
        ->where('id_grupo','=',$idgrupo)
        ->get();
        $fecha_hoy=Carbon::now(); 

        $pdf = PDF::loadView('admin.prestamos.pdf_reciboprestamos',['prestamos'=>$prestamos,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'gerente_zona'=>$gerente_zona,'fecha_hoy'=>$fecha_hoy]);
        return $pdf->stream();
        
    }

    public function r_prestamo_entrega(Request $request,$idregion,$idzona,$idgrupo){
        
        // dd($request->all());
        
        // Capturamos todos los campos que tienen vallor
        $input =$request->all();
        if (empty($request->id_prestamo_renovacion)) {
            // preguntamos si hay un valor en el campo id_prestamo_renovacion
        } else {
            
            // aqui guardamos todos los abonos de liquidación
                // Si hay id_prestamos_liquidacion entonces lo recorremos
                foreach ($input["id_prestamo_renovacion"] as $key => $value) {

                    // Capturamos todos los datos que en variables o podemos pasarlos directamente
                    $id_prestamo=$value;
                    
                    $ultima_semana=DB::table('tbl_abonos')
                    ->select('tbl_abonos.*')
                    ->where('id_prestamo','=',$id_prestamo)
                    ->orderBy('semana','ASC')
                    ->get();
                    
                    $semana=$ultima_semana->last()->semana+1;
                    
                    $semana_corte_actual=DB::table('tbl_cortes_semanas')
                    ->select('tbl_cortes_semanas.*')
                    ->where('id_grupo','=',$idgrupo)
                    ->orderBy('numero_semana_corte','ASC')
                    ->get();
                    
                    if(count($semana_corte_actual)==0){
                        return back()->with('error', '¡Se necesita configuración de fecha de corte semana!');
                    } else {
                        // dd(count($semana_corte_actual));
                        $corte_semana=$semana_corte_actual->last()->id_corte_semana;
                        
                        //  dd($semana,$corte_semana);
                        
                        $semana = $semana;
                        $cantidad = $input["catidad_liquidacion"][$key];
                        $id_usuario = $input["id_usuario"][$key];
                        $fecha_pago = $fecha_hoy=Carbon::now();
                        $corte_semana = $corte_semana;
                        
                        if($cantidad==0){
                            DB::table('tbl_prestamo_liquidacion_temporal')->insert([
                                'id_p_liquidacion' => null, 
                                'id_usuario' =>$id_usuario,
                                'id_prestamo' => $id_prestamo,
                                'id_abono' =>  1,
                            ]);
                        } else {
                            // Agregamos un abono de tipo liquidación
                            $liquidacion = Abonos::create([
                                'id_prestamo'    => $id_prestamo,
                                'semana'         => $semana,
                                'cantidad'       => $cantidad,
                                'fecha_pago'     => $fecha_pago,
                                'id_tipoabono'   => '1',
                                'id_corte_semana'   => $corte_semana
                            ])->save();
                                $idAd = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idAd->id_abono,
                                    'descripcion' => "Se registró abono liquidación. Renovación",
                                    'fecha_registro' => $fecha_pago
                                ]);
                                DB::table('tbl_prestamo_liquidacion_temporal')->insert([
                                    'id_p_liquidacion' => null, 
                                    'id_usuario' =>$id_usuario,
                                    'id_prestamo' => $id_prestamo,
                                    'id_abono' =>  $idAd->id_abono,
                                ]);
                        }
                        
                        
                    }
                    
                }
        }
        
        // dd('haciendo pruebas');
        $actualizar_pagado= DB::table('tbl_prestamos')
        ->select('id_usuario')
        ->where('id_grupo','=',$idgrupo)
        ->where('id_status_prestamo','=',10)
        ->get();

        foreach ($actualizar_pagado as $id_prestamo_9) {
                $id_pres=DB::table('tbl_prestamos')
                ->select('id_usuario')
                ->where('id_usuario','=',$id_prestamo_9->id_usuario)
                ->where('id_status_prestamo','=',9)
                ->get();

                // actualiza todos los prestamos que estan como renovacion a pagados
                foreach ($id_pres as $id_pre) {
                    
                    Prestamos::where('id_usuario','=',$id_pre->id_usuario)
                    ->where('id_status_prestamo','=',9)
                    ->update(['id_status_prestamo'=>'8']);
                }

                // actualiza todos los prestamos aprobados que se renovaron a estado renovacion
                foreach ($id_pres as $id_pre) {
                    $id_producto=DB::table('tbl_prestamos')
                    ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
                    ->select('tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_productos.papeleria','tbl_productos.pago_semanal')
                    ->where('tbl_prestamos.id_usuario','=',$id_pre->id_usuario)
                    ->where('tbl_prestamos.id_status_prestamo','=',10)
                    ->get();
                    foreach ($id_producto as $id_product) {
                        $cantidad_abono=$id_product->cantidad*($id_product->papeleria/100);
                        $c_abono_ahorro=$id_product->cantidad*($id_product->pago_semanal/100);
                        $fecha_abono=Carbon::now();
                        
                        // Agregamos un abono de papeleria
                        $documentos = Abonos::create([
                            'id_prestamo'    => $id_product->id_prestamo,
                            'semana'         => '0',
                            'cantidad'       => $cantidad_abono,
                            'fecha_pago'     => $fecha_abono,
                            'id_tipoabono'   => '2',
                            'id_corte_semana'   => '0'
                        ])->save();
                        
                            $idA = Abonos::latest('id_abono')->first();
                            DB::table('tbl_log')->insert([
                                'id_log' => null, 
                                'id_tipo' => 1,
                                'id_plataforma' => 2,
                                'id_usuario' => Auth::user()->id,
                                'id_tipo_movimiento' => 1,
                                'id_movimiento' =>  $idA->id_abono,
                                'descripcion' => "Se registró abono papelería, de nuevo préstamo. Renovación",
                                'fecha_registro' => $fecha_abono
                            ]);
                            
                        // Agregamos un abono de ahorro
                        $ahorro = Abonos::create([
                            'id_prestamo'    => $id_product->id_prestamo,
                            'semana'         => '0',
                            'cantidad'       => $c_abono_ahorro,
                            'fecha_pago'     => $fecha_abono,
                            'id_tipoabono'   => '3',
                            'id_corte_semana'   => '0'
                        ])->save();
                            $idAa = Abonos::latest('id_abono')->first();
                            DB::table('tbl_log')->insert([
                                'id_log' => null, 
                                'id_tipo' => 1,
                                'id_plataforma' => 2,
                                'id_usuario' => Auth::user()->id,
                                'id_tipo_movimiento' => 1,
                                'id_movimiento' =>  $idAa->id_abono,
                                'descripcion' => "Se registró abono ahorro, de nuevo préstamo. Renovación",
                                'fecha_registro' => $fecha_abono
                            ]);
                        
                        DB::table('tbl_log')->insert([
                            'id_log' => null, 
                            'id_tipo' => 2,
                            'id_plataforma' => 2,
                            'id_usuario' => Auth::user()->id,
                            'id_tipo_movimiento' => 2,
                            'id_movimiento' =>  $id_product->id_prestamo,
                            'descripcion' => "Se entregó un nuevo préstamo. Renovación",
                            'fecha_registro' => $fecha_abono
                        ]);
                        
                    }

                    // actualiza los prestamos aprobados(renovados) a renovacion
                    Prestamos::where('id_usuario','=',$id_pre->id_usuario)
                    ->where('id_status_prestamo','=',10)
                    ->update([
                        'id_status_prestamo'=>'15',
                        'fecha_entrega_recurso'=>$fecha_abono
                    ]);
                }
        }

        // activa los prestamos que estan como prospecto=nuevos
        $activar_prestamos= DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->select('tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_productos.papeleria','tbl_productos.pago_semanal')
        ->where('id_grupo','=',$idgrupo)
        ->where('id_status_prestamo','=',10)
        ->get();

        foreach ($activar_prestamos as $ac_p_2) {

            $cantidad_abono=$ac_p_2->cantidad*($ac_p_2->papeleria/100);
            $c_abono_ahorro=$ac_p_2->cantidad*($ac_p_2->pago_semanal/100);
            $fecha_abono=Carbon::now();
            $documentos = Abonos::create([
                'id_prestamo'    => $ac_p_2->id_prestamo,
                'semana'         => '0',
                'cantidad'       => $cantidad_abono,
                'fecha_pago'     => $fecha_abono,
                'id_tipoabono'   => '2',
                'id_corte_semana'   => '0'
            ])->save();
            
                $idAn = Abonos::latest('id_abono')->first();
                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 1,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 1,
                    'id_movimiento' =>  $idAn->id_abono,
                    'descripcion' => "Se registró abono papelería, de nuevo préstamo. Activo",
                    'fecha_registro' => $fecha_abono
                ]);
            
            $ahorro = Abonos::create([
                'id_prestamo'    => $ac_p_2->id_prestamo,
                'semana'         => '0',
                'cantidad'       => $c_abono_ahorro,
                'fecha_pago'     => $fecha_abono,
                'id_tipoabono'   => '3',
                'id_corte_semana'   => '0'
            ])->save();
                $idAan = Abonos::latest('id_abono')->first();
                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 1,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 1,
                    'id_movimiento' =>  $idAn->id_abono,
                    'descripcion' => "Se registró abono ahorro, de nuevo préstamo. Activo",
                    'fecha_registro' => $fecha_abono
                ]);
                
                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 2,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 2,
                    'id_movimiento' =>  $ac_p_2->id_prestamo,
                    'descripcion' => "Se entregó un nuevo préstamo. Activo",
                    'fecha_registro' => $fecha_abono
                ]);
                
                

            Prestamos::where('id_prestamo','=',$ac_p_2->id_prestamo)->update([
                'id_status_prestamo'=>'15',
                'fecha_entrega_recurso'=>$fecha_abono
            ]);

        }

        return back()->with('status', '¡Préstamos entregados con éxito!');
    }

    public function pdf_reciboprestamos_devolucion($idregion,$idzona,$idgrupo){
        //Imprime recibo pdf---------------------
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $grupo= Grupos::find($idgrupo);

        $gerente_zona= DB::table('tbl_zonas_gerentes')
        ->Join('tbl_usuarios', 'tbl_zonas_gerentes.id_usuario', '=', 'tbl_usuarios.id')
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        ->Join('tbl_zona', 'tbl_zonas_gerentes.id_zona', '=', 'tbl_zona.IdZona')
        ->select('tbl_datos_usuario.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->get();

        $prestamos = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_usuarios as cliente', 'tbl_prestamos.id_usuario', '=', 'cliente.id')
        ->Join('tbl_datos_usuario as clientedatos', 'cliente.id', '=', 'clientedatos.id_usuario')
        ->Join('tbl_usuarios as promotor', 'tbl_prestamos.id_promotora', '=', 'promotor.id')
        ->Join('tbl_datos_usuario as promotordatos', 'promotor.id', '=', 'promotordatos.id_usuario')

        ->select('tbl_prestamos.*','tbl_productos.*','cliente.id as id_cliente','clientedatos.nombre as nombre_cliente','clientedatos.ap_paterno as paterno_cliente','clientedatos.ap_materno as materno_cliente','promotordatos.nombre as nombre_pro','promotordatos.ap_paterno as paterno_pro','promotordatos.ap_materno as materno_pro')
        ->where('id_status_prestamo','=',17)
        ->where('id_grupo','=',$idgrupo)
        ->get();
        $fecha_hoy=Carbon::now(); 

        $pdf = PDF::loadView('admin.prestamos.pdf_reciboprestamos_devolucion',['prestamos'=>$prestamos,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'gerente_zona'=>$gerente_zona,'fecha_hoy'=>$fecha_hoy]);
        return $pdf->stream();
    }

    public function devolucion_prestamos(Request $request){

        $input =$request->all();
        
        // dd($request->all());

        if (empty($request->id_prestamo)) {
            return back()->with('error', '¡No hay préstamos rechazados por el cliente!');
        } else {
            
            // aqui guardamos todos los abonos de liquidación
                // Si hay id_prestamos_liquidacion entonces lo recorremos
                foreach ($input["id_prestamo"] as $key => $value) {

                    // Capturamos todos los datos que en variables o podemos pasarlos directamente
                        $id_prestamo=$value;
                    
                    
                        //  dd($semana,$corte_semana);
                        $id_prestamo_anterior=$input["id_prestamo_anterior"][$key];
                        $id_cliente=$input["id_cliente"][$key];
                        $semana = 0;
                        $cantidad = $input["cantidad_abono"][$key];
                        $id_abono_eliminar = $input["id_abono"][$key];
                        $fecha_pago = $fecha_hoy=Carbon::now();
                        // $corte_semana = $corte_semana;
                        
                        if($cantidad==0){
                            // dd('es cero');
                        } else {
                                // Agregamos un abono de tipo ajuste
                                $abono_ajuste = Abonos::create([
                                    'id_prestamo'    => $id_prestamo,
                                    'semana'         => $semana,
                                    'cantidad'       => $cantidad,
                                    'fecha_pago'     => $fecha_pago,
                                    'id_tipoabono'   => '6',
                                    'id_corte_semana'   => 0
                                ])->save();
                                $idAd = Abonos::latest('id_abono')->first();
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 1,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 1,
                                    'id_movimiento' =>  $idAd->id_abono,
                                    'descripcion' => "Se registró abono de ajuste. Devolución",
                                    'fecha_registro' => $fecha_pago
                                ]);
                                
                        // }
                        
                        }

                        if ($id_abono_eliminar==0) {
                                    
                        } else {
                            DB::table('tbl_abonos')
                            ->where('id_abono','=', $id_abono_eliminar)
                            ->delete();

                            DB::table('tbl_prestamo_liquidacion_temporal')
                            ->where('id_abono','=', $id_abono_eliminar)
                            ->where('id_prestamo','=', $id_prestamo_anterior)
                            ->delete();

                            DB::table('tbl_log')->insert([
                                'id_log' => null, 
                                'id_tipo' => 3,
                                'id_plataforma' => 2,
                                'id_usuario' => Auth::user()->id,
                                'id_tipo_movimiento' => 1,
                                'id_movimiento' =>  $id_abono_eliminar,
                                'descripcion' => "Se eliminó abono de liquidacion del préstamo anterior. Devolución",
                                'fecha_registro' => $fecha_pago
                            ]);

                        
                        }

                        // Cambiamos a renovacion el estatus anterior
                        if ($id_prestamo_anterior==0) {
                            
                        } else {

                            $total_prestamos= DB::table('tbl_prestamos')
                            ->select('tbl_prestamos.*')
                            ->where('id_usuario','=',$id_cliente)
                            ->where('id_status_prestamo','=',8)
                            ->get();
                            
                            if (count($total_prestamos)==1) {
                                Prestamos::where('id_prestamo','=',$id_prestamo_anterior)->update([
                                    'id_status_prestamo'=>'2',
                                ]);
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 2,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 2,
                                    'id_movimiento' =>  $id_prestamo_anterior,
                                    'descripcion' => "Se actulizó el préstamo a activo. Por rechazo del nuevo préstamo",
                                    'fecha_registro' => $fecha_pago
                                ]);
                            } elseif (count($total_prestamos)>1) {
                                Prestamos::where('id_prestamo','=',$id_prestamo_anterior)->update([
                                    'id_status_prestamo'=>'9',
                                ]);
                                DB::table('tbl_log')->insert([
                                    'id_log' => null, 
                                    'id_tipo' => 2,
                                    'id_plataforma' => 2,
                                    'id_usuario' => Auth::user()->id,
                                    'id_tipo_movimiento' => 2,
                                    'id_movimiento' =>  $id_prestamo_anterior,
                                    'descripcion' => "Se actulizó el préstamo a renovación. Por rechazo del nuevo préstamo",
                                    'fecha_registro' => $fecha_pago
                                ]);
                            }
                            
                        }
                        
                        

                        Prestamos::where('id_prestamo','=',$id_prestamo)->update([
                            'id_status_prestamo'=>'16',
                        ]);

                        DB::table('tbl_log')->insert([
                            'id_log' => null, 
                            'id_tipo' => 2,
                            'id_plataforma' => 2,
                            'id_usuario' => Auth::user()->id,
                            'id_tipo_movimiento' => 2,
                            'id_movimiento' =>  $id_prestamo,
                            'descripcion' => "Se actulizó un préstamo de rechazado por el cliente a  devolución",
                            'fecha_registro' => $fecha_pago
                        ]);
                    
                }
                return back()->with('status', '¡Devolución de préstamos recibidos con éxito!');
        }
    }

    public function renovacion(Request $request){

        Prestamos::where('id_prestamo','=',$request->id_pre)->update([
            'id_status_prestamo'=>'9',
        ]);

        $fecha_so=Carbon::now();
        // dd($fecha_so,$request->all());

        $prestamo = Prestamos::create([
            'id_usuario'          => $request->id_usuario,
            'id_status_prestamo'  => '10',
            'id_grupo'            => $request->id_grupo,
            'id_promotora'        => $request->id_promotora,
            'id_producto'         => $request->id_producto,
            'id_autorizo'         => $request->id_autorizo,
            'cantidad'            => $request->cantidad,
            'fecha_solicitud'     => $fecha_so,
            'fecha_entrega_recurso' => $fecha_so,
            'fecha_aprovacion' => $fecha_so
        ])->save();

        $id_prestamo = Prestamos::latest('id_prestamo')->first();

        $fecha_pago = $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 2,
            'id_movimiento' =>  $id_prestamo->id_prestamo,
            'descripcion' => "Solicitud de renovación de préstamo",
            'fecha_registro' => $fecha_pago
        ]);

        return back()->with('status', '¡Renovación solicitada con éxito!');
    }

    public function entregado(){


        return back()->with('status', '¡Préstamos entregados!');
    }

    public function detalle_prestamo($id_prestamo){

        $datos_prestamo = DB::table('tbl_prestamos')
            ->Join('tbl_usuarios as cliente', 'tbl_prestamos.id_usuario', '=', 'cliente.id')
            ->Join('tbl_datos_usuario as datos_cliente', 'cliente.id', '=', 'datos_cliente.id_usuario')

            ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
            ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_usuarios as promotora', 'tbl_prestamos.id_promotora', '=', 'promotora.id')
            ->Join('tbl_datos_usuario as datos_promotora', 'promotora.id', '=', 'datos_promotora.id_usuario')

            ->Join('tbl_usuarios as administrador', 'tbl_prestamos.id_autorizo', '=', 'administrador.id')
            ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
            ->select('tbl_prestamos.*', 'cliente.nombre_usuario as cliente','datos_promotora.nombre as pro_nombre','datos_promotora.ap_paterno as pro_paterno','datos_promotora.ap_materno as pro_materno','datos_cliente.id_usuario as no_usuario','datos_cliente.nombre as cli_nombre','datos_cliente.ap_paterno as cli_paterno','datos_cliente.ap_materno as cli_materno','datos_cliente.telefono_casa as cli_telefono_casa','datos_cliente.telefono_celular as cli_telefono_celular','datos_cliente.direccion as cli_direccion','datos_cliente.numero_exterior as cli_numero_exterior','datos_cliente.numero_interior as cli_numero_interior','datos_cliente.colonia as cli_colonia','datos_cliente.codigo_postal as cli_codigo_postal','datos_cliente.localidad as cli_localidad','datos_cliente.municipio as cli_municipio','datos_cliente.estado as cli_estado','tbl_productos.producto','cliente.id as id','tbl_status_prestamo.status_prestamo','tbl_grupos.grupo','promotora.nombre_usuario as promotora','administrador.nombre_usuario as administrador')
            ->where('tbl_prestamos.id_prestamo','=',$id_prestamo)
            ->get();


        $pdf = PDF::loadView('admin.prestamos.detalles_prestamo_pdf',['datos_prestamo'=>$datos_prestamo]);
        return $pdf->stream();
    }

    public function morosidad_prestamos(Request $request){
        
        $input =$request->all();
        // dd($input);

        foreach ($input["id_prestamo"] as $key => $value) {

            $id_prestamo=$value;

            Prestamos::where('id_prestamo','=',$id_prestamo)->update([
                // 'id_prestamo'    => $request->id_prestamo,
                'id_status_prestamo' => '3',
            ]);

        }

        return back()->with('status', '¡Los préstamos pasaron a morosidad con éxito!');
    }
    
    public function buscar_cliente(Request $request)
    {
        // dd($request->all());
        if (empty($request->estatus)) {
            $resultado_cliente= DB::table('tbl_usuarios')
                ->select('tbl_usuarios.*')
                ->orWhere('nombre_usuario','like','%'.$request->nombre_cliente.'%')
                ->get();
                
            $resultado_ap_paterno= DB::table('tbl_usuarios')
                    ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                    ->select('tbl_usuarios.*')
                    ->orWhere('tbl_datos_usuario.ap_paterno','like','%'.$request->nombre_cliente.'%')
                    ->get();
                    
            $resultado_ap_materno= DB::table('tbl_usuarios')
                    ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
                    ->select('tbl_usuarios.*')
                    ->orWhere('tbl_datos_usuario.ap_materno','like','%'.$request->nombre_cliente.'%')
                    ->get();
                    $datelle_prestamo_estatus=[];
        } else {
            // dd($request->estatus);
            $datelle_prestamo_estatus= DB::table('tbl_usuarios')
                ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
                ->select('tbl_usuarios.*','tbl_prestamos.id_prestamo')
                ->Where('tbl_prestamos.id_status_prestamo','=',$request->estatus)
                ->get();
                // dd($datelle_prestamo_estatus,$request->estatus);
            
            $resultado_cliente=[];
            $resultado_ap_paterno= [];    
            $resultado_ap_materno= [];
        }
 
                
        return view('admin.resultados_busqueda',['resultado_cliente'=>$resultado_cliente,'resultado_ap_paterno'=>$resultado_ap_paterno,'resultado_ap_materno'=>$resultado_ap_materno,'datelle_prestamo_estatus'=>$datelle_prestamo_estatus]);
        
    }
    
    public function exportar_clientes_activos(Request $request,$idzona,$idgrupo){
        
        // dd($zona,$grupo);
        $estatus=$request->id_estatus_prestamo;
        $zona = Zona::find($idzona);
        $grupo= Grupos::find($idgrupo);
        if($request->id_estatus_prestamo==2){
            $prestamos = DB::table('tbl_prestamos')
            ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_prestamos.*','tbl_usuarios.*','tbl_datos_usuario.*')
            ->where('tbl_prestamos.id_grupo','=',$idgrupo)
            ->whereIn('tbl_prestamos.id_status_prestamo', [2, 9])
            ->get();
        } elseif($request->id_estatus_prestamo==6){
            $prestamos = DB::table('tbl_prestamos')
            ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_prestamos.*','tbl_usuarios.*','tbl_datos_usuario.*')
            ->where('tbl_prestamos.id_grupo','=',$idgrupo)
            ->where('tbl_prestamos.id_status_prestamo','=',6)
            ->get();
        }elseif($request->id_estatus_prestamo==3){
            $prestamos = DB::table('tbl_prestamos')
            ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_prestamos.*','tbl_usuarios.*','tbl_datos_usuario.*')
            ->where('tbl_prestamos.id_grupo','=',$idgrupo)
            ->where('tbl_prestamos.id_status_prestamo','=',3)
            ->get();
        }
        
        
        $pdf = PDF::loadView('admin.prestamos.pdf_clientes_activos',['prestamos'=>$prestamos,'zona'=>$zona,'grupo'=>$grupo,'estatus'=>$estatus]);
        return $pdf->stream();
    }

    public function buscando_promotoras(Request $request){
        $promotoras = DB::table('tbl_grupos_promotoras')
        ->Join('tbl_datos_usuario', 'tbl_grupos_promotoras.id_usuario', '=', 'tbl_datos_usuario.id_usuario')
        ->select('tbl_grupos_promotoras.*','tbl_datos_usuario.*')
        ->where('tbl_grupos_promotoras.id_grupo','=',$request->id_grupo)
        ->get();


        echo json_encode($promotoras);
    }
    
    public function pdf_clientes(Request $request){
        dd($request->all());
    }

    public function actualizar_promotora_de_prestamos(Request $request){
        
        $prestamos_activos=DB::table('tbl_prestamos')
        ->select('tbl_prestamos.*')
        ->where('id_grupo','=',$request->id_grupo)
        ->where('id_promotora','=',$request->id_promotora_actual)
        ->whereIn('id_status_prestamo',[10,9,2])
        ->get();

        if (count($prestamos_activos)==0) {
            return back()->with('error', '¡No se encontraron préstamos activos!');
        } else {

            foreach ($prestamos_activos as $prestamos_activo) {
                $affected = DB::table('tbl_prestamos')
                ->where('id_prestamo', $prestamos_activo->id_prestamo)
                ->where('id_promotora', $request->id_promotora_actual)
                ->update(['id_promotora' => $request->nueva_promotora]);

                $fecha_pago = $fecha_hoy=Carbon::now();
                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 2,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 7,
                    'id_movimiento' =>  $prestamos_activo->id_prestamo,
                    'descripcion' => "Se le cambió promotora a este préstamo de #".$prestamos_activo->id_prestamo." de ".$request->id_promotora_actual." a ".$request->nueva_promotora,
                    'fecha_registro' => $fecha_pago
                ]);

            }

            return back()->with('status', '¡Cambio de promotora realizado con éxito!');
        }
        
    }

    public function liquidacion_renovacion(Request $request){
        // dd($request->all());

        $prestamos=DB::table('tbl_prestamos')
        ->select('tbl_prestamos.*')
        ->where('id_prestamo','=',$request->id_prestamo)
        ->get();

        $fecha_pago = $fecha_hoy=Carbon::now();

        // dd($prestamos);
        if (count($prestamos)==0) {
            return back()->with('error', 'No se encontraron préstamos, intenta de nuevo.');
        } else {
            foreach ($prestamos as $prestamo) {
                DB::table('tbl_prestamos')->insert([
                    'id_usuario' => $prestamo->id_usuario, 
                    'fecha_solicitud' => $fecha_pago,
                    'id_status_prestamo' => 19,
                    'id_grupo' => $prestamo->id_grupo,
                    'id_promotora' => $prestamo->id_promotora,
                    'id_producto' => $prestamo->id_producto,
                ]);

            }

            Prestamos::where('id_prestamo','=',$request->id_prestamo)->update([
                'id_status_prestamo' => '20',
            ]);

            return back()->with('status', '¡Liquidación renovación aprobado con éxito!');
        }
        
        


    }

    public function prestamos_anticipados($idregion,$idzona,$idgrupo){

        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $grupo= Grupos::find($idgrupo);

        $gerente_zona= DB::table('tbl_zonas_gerentes')
        ->Join('tbl_usuarios', 'tbl_zonas_gerentes.id_usuario', '=', 'tbl_usuarios.id')
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        ->Join('tbl_zona', 'tbl_zonas_gerentes.id_zona', '=', 'tbl_zona.IdZona')
        ->select('tbl_datos_usuario.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->get();

        $prestamos = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_usuarios as cliente', 'tbl_prestamos.id_usuario', '=', 'cliente.id')
        ->Join('tbl_datos_usuario as clientedatos', 'cliente.id', '=', 'clientedatos.id_usuario')
        ->Join('tbl_usuarios as promotor', 'tbl_prestamos.id_promotora', '=', 'promotor.id')
        ->Join('tbl_datos_usuario as promotordatos', 'promotor.id', '=', 'promotordatos.id_usuario')
        ->select('tbl_prestamos.*','tbl_productos.*','cliente.id as id_cliente','clientedatos.nombre as nombre_cliente','clientedatos.ap_paterno as paterno_cliente','clientedatos.ap_materno as materno_cliente','promotordatos.nombre as nombre_pro','promotordatos.ap_paterno as paterno_pro','promotordatos.ap_materno as materno_pro')
        ->where('id_status_prestamo','=',19)
        ->where('id_grupo','=',$idgrupo)
        ->get();

        return view('admin.prestamos.prestamos_anticipados',['prestamos'=>$prestamos,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'gerente_zona'=>$gerente_zona]);

        
    }

    public function pdf_reciboprestamos_anticipados($idregion,$idzona,$idgrupo){
        // dd('sjdlkasdkjalk');
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $grupo= Grupos::find($idgrupo);

        $gerente_zona= DB::table('tbl_zonas_gerentes')
        ->Join('tbl_usuarios', 'tbl_zonas_gerentes.id_usuario', '=', 'tbl_usuarios.id')
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        ->Join('tbl_zona', 'tbl_zonas_gerentes.id_zona', '=', 'tbl_zona.IdZona')
        ->select('tbl_datos_usuario.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->get();

        $prestamos = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_usuarios as cliente', 'tbl_prestamos.id_usuario', '=', 'cliente.id')
        ->Join('tbl_datos_usuario as clientedatos', 'cliente.id', '=', 'clientedatos.id_usuario')
        ->Join('tbl_usuarios as promotor', 'tbl_prestamos.id_promotora', '=', 'promotor.id')
        ->Join('tbl_datos_usuario as promotordatos', 'promotor.id', '=', 'promotordatos.id_usuario')
        ->select('tbl_prestamos.*','tbl_productos.*','cliente.id as id_cliente','clientedatos.nombre as nombre_cliente','clientedatos.ap_paterno as paterno_cliente','clientedatos.ap_materno as materno_cliente','promotordatos.nombre as nombre_pro','promotordatos.ap_paterno as paterno_pro','promotordatos.ap_materno as materno_pro')
        ->where('id_status_prestamo','=',19)
        ->where('id_grupo','=',$idgrupo)
        ->get();
        $fecha_hoy=Carbon::now(); 

        $pdf = PDF::loadView('admin.prestamos.pdf_prestamos_anticipados',['prestamos'=>$prestamos,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'gerente_zona'=>$gerente_zona,'fecha_hoy'=>$fecha_hoy]);
        return $pdf->stream();
    }
    
    public function entrega_prestamos_anticipados(Request $request,$idregion,$idzona,$idgrupo){
        //  dd($request->all());
        
        // Capturamos todos los campos que tienen vallor
        $input =$request->all();
        if (empty($request->id_prestamo_renovacion)) {
            // preguntamos si hay un valor en el campo id_prestamo_renovacion
        } else {
            
            // aqui guardamos todos los abonos de liquidación
                // Si hay id_prestamos_liquidacion entonces lo recorremos
                foreach ($input["id_prestamo_renovacion"] as $key => $value) {

                    // Capturamos todos los datos que en variables o podemos pasarlos directamente
                    $id_prestamo=$value;
                      
                    $id_usuario = $input["id_usuario"][$key];
                        
                    DB::table('tbl_prestamo_liquidacion_temporal')->insert([
                        'id_p_liquidacion' => null, 
                        'id_usuario' =>$id_usuario,
                        'id_prestamo' => $id_prestamo,
                        'id_abono' =>  1,
                    ]);
                    
                }
        }
        
       
        // activa los prestamos que estan como renovacion anticipada 
        $activar_prestamos= DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->select('tbl_prestamos.id_prestamo','tbl_prestamos.cantidad','tbl_productos.papeleria','tbl_productos.pago_semanal')
        ->where('id_grupo','=',$idgrupo)
        ->where('id_status_prestamo','=',19)
        ->get();

        foreach ($activar_prestamos as $ac_p_2) {

            $cantidad_abono=$ac_p_2->cantidad*($ac_p_2->papeleria/100);
            $c_abono_ahorro=$ac_p_2->cantidad*($ac_p_2->pago_semanal/100);
            $fecha_abono=Carbon::now();
            $documentos = Abonos::create([
                'id_prestamo'    => $ac_p_2->id_prestamo,
                'semana'         => '0',
                'cantidad'       => $cantidad_abono,
                'fecha_pago'     => $fecha_abono,
                'id_tipoabono'   => '2',
                'id_corte_semana'   => '0'
            ])->save();
            
                $idAn = Abonos::latest('id_abono')->first();
                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 1,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 1,
                    'id_movimiento' =>  $idAn->id_abono,
                    'descripcion' => "Se registró abono papelería, de nuevo préstamo. Anticipado",
                    'fecha_registro' => $fecha_abono
                ]);
            
            $ahorro = Abonos::create([
                'id_prestamo'    => $ac_p_2->id_prestamo,
                'semana'         => '0',
                'cantidad'       => $c_abono_ahorro,
                'fecha_pago'     => $fecha_abono,
                'id_tipoabono'   => '3',
                'id_corte_semana'   => '0'
            ])->save();
                $idAan = Abonos::latest('id_abono')->first();
                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 1,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 1,
                    'id_movimiento' =>  $idAn->id_abono,
                    'descripcion' => "Se registró abono ahorro, de nuevo préstamo. Anticipado",
                    'fecha_registro' => $fecha_abono
                ]);
                
                

            Prestamos::where('id_prestamo','=',$ac_p_2->id_prestamo)->update([
                'id_status_prestamo'=>'15',
                'fecha_entrega_recurso'=>$fecha_abono
            ]);

            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 2,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 38,
                'id_movimiento' =>  $ac_p_2->id_prestamo,
                'descripcion' => "Se entregó un nuevo préstamo. Anticipado",
                'fecha_registro' => $fecha_abono
            ]);

        }

        return back()->with('status', '¡Préstamos anticipados entregados con éxito!');
    }

    public function nuevo_prestamo_extra(Request $request){
        $prestamos=DB::table('tbl_prestamos')
        ->select('tbl_prestamos.*')
        ->where('id_prestamo','=',$request->id_prestamo)
        ->get();

        $fecha_pago = $fecha_hoy=Carbon::now();

        // dd($prestamos);
        if (count($prestamos)==0) {
            return back()->with('error', 'No se encontraron préstamos, intenta de nuevo.');
        } else {
            foreach ($prestamos as $prestamo) {
                DB::table('tbl_prestamos')->insert([
                    'id_usuario' => $prestamo->id_usuario, 
                    'fecha_solicitud' => $fecha_pago,
                    'id_status_prestamo' => 1,
                    'id_grupo' => $prestamo->id_grupo,
                    'id_promotora' => $prestamo->id_promotora,
                    'id_producto' => $prestamo->id_producto,
                ]);

            }
            return back()->with('status', '¡Nuevo préstamo solicitado con éxito!. Espere a que un administrador lo autorice');
        }
        
    }
    
    public function mejor_panorama($idregion,$idzona){
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$idregion)
        ->orderBy('Zona','ASC')
        ->get();

        $grupos = DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->where('IdZona','=',$idzona)
        ->orderBy('grupo','ASC')
        ->get();


        $gerentes_de_zona = DB::table('tbl_zonas_gerentes')
        ->join('tbl_usuarios','tbl_zonas_gerentes.id_usuario','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_zonas_gerentes.*','tbl_usuarios.id','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
        ->where('id_zona','=',$idzona)
        ->orderBy('tbl_datos_usuario.nombre','ASC')
        ->get();
        // $fecha_actual=Carbon::now();

        // dd($idregion,$idzona,$region,$zona);

        return view('admin.prestamos.mejor_panorama',compact('region','zona','zonas','grupos','gerentes_de_zona','gerentes_de_zona'));

    }
    
    public function buscando_producto(Request $request){
        
        $producto = DB::table('tbl_productos')
        ->select('tbl_productos.rango_inicial','tbl_productos.rango_final')
        ->where('id_producto','=',$request->id_producto)
        ->get();

        echo json_encode($producto);
    }
    
}
