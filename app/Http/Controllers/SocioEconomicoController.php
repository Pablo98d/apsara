<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\SocioEconomicoExport;
use App\SocioEconomico;
use App\User;
use Carbon\Carbon;
use App\Prestamos;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use App\Zona;

class SocioEconomicoController extends Controller
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
    public function index(Request $request)
    {
        

        $id_region_actual=\Cache::get('region');
        $id_ruta_actual=\Cache::get('ruta');

        if ($id_region_actual==null) {
            $id_region_actual=0;
            $id_ruta_actual=0;
        } else {
            $id_region_actual=\Cache::get('region');
            $id_ruta_actual=\Cache::get('ruta');
        }

        $zona = Zona::find($id_ruta_actual);
        
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region_actual)
        ->orderBy('Zona','ASC')
        ->get();



        $fecha_actual = Carbon::now(); 
        if (empty($request->busqueda_cliente_nombre)) {
            $socioeconomico = DB::table('tbl_socio_economico')
            ->Join('tbl_usuarios', 'tbl_socio_economico.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_prestamos', 'tbl_socio_economico.id_usuario', '=', 'tbl_prestamos.id_usuario')
            ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_socio_economico.*','tbl_socio_economico.fecha_actualizacion as f_actualizacion', 'tbl_datos_usuario.*','tbl_grupos.grupo','tbl_zona.Zona')
            // ->where('tbl_zona.IdZona','=',$id_ruta_actual)
            ->orderby('tbl_socio_economico.fecha_registro','DESC')
            ->distinct()
            ->get();
        } else {
            $socioeconomico = DB::table('tbl_socio_economico')
            ->Join('tbl_usuarios', 'tbl_socio_economico.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_prestamos', 'tbl_socio_economico.id_usuario', '=', 'tbl_prestamos.id_usuario')
            ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_socio_economico.*','tbl_socio_economico.fecha_actualizacion as f_actualizacion', 'tbl_datos_usuario.*','tbl_grupos.grupo','tbl_zona.Zona')
            // ->where('tbl_zona.IdZona','=',$id_ruta_actual)
            ->orWhere(DB::raw('CONCAT(tbl_datos_usuario.nombre, " ",tbl_datos_usuario.ap_paterno," ", tbl_datos_usuario.ap_materno)'),'like','%'.$request->busqueda_cliente_nombre.'%')
            ->orderby('tbl_socio_economico.fecha_registro','DESC')
            ->distinct()
            ->get();
        }
        
        
            // ->get();


        return view('admin.socioeconomico.index',compact('socioeconomico','fecha_actual','zona','zonas'));
    }

    public function registro_cliente(){
        $tipoUsuario = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->whereNotIn('id_tipo_usuario',[3])
            ->orderBy('nombre','ASC')
            ->get();
            // $tipoUsuario='ejemplo';
        return view('admin.datosusuario.create',compact('tipoUsuario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $now = Carbon::now(); 
        $user = DB::table('tbl_usuarios')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_usuarios.*', 'tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
            ->orderBy('tbl_datos_usuario.nombre','ASC')
            ->get();
        $promotores = DB::table('tbl_usuarios')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_usuarios.*', 'tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
            ->where('tbl_usuarios.id_tipo_usuario','=',4)
            ->get();
        return view('admin.socioeconomico.create',compact('user','now','promotores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('jhgfdsasdfghjkl');
        $this->validate($request,[
            'id_usuario' => 'required',
            'id_promotora'=>'required',
            'estatus'=>'required',
            'fecha_registro' => 'required'
        ]);
        SocioEconomico::create($request->all());
        return redirect()->route('socioeconomico.index')->with('Guardar','Registro Guardado con Exito !!!');
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
    public function edit($id)
    {
        $usuario=User::all();
        $socioeconomico=SocioEconomico::findOrFail($id);
        return view('admin/socioeconomico/edit', compact('socioeconomico','usuario'));
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
        $datosAc=request()->except(['_token','_method']);
        SocioEconomico::where('id_socio_economico','=',$id)->update($datosAc);

        return redirect()->route('socioeconomico.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SocioEconomico::destroy($id);
        return redirect()->route('socioeconomico.index');
    }
    public function export(){
        return Excel::download(new SocioEconomicoExport, 'Socio_economico.xlsx');
    }

    public function crearsocio(Request $request){
        $fecha_actual = Carbon::now(); 
        $id_socioeconomico=$request->id_socioeconomico;
        $soci=DB::table('tbl_socio_economico')
        ->join('tbl_usuarios','tbl_socio_economico.id_usuario','=','tbl_usuarios.id')
        ->select('tbl_socio_economico.*','tbl_usuarios.nombre_usuario','tbl_usuarios.email')
        ->where('tbl_socio_economico.id_socio_economico','=',$id_socioeconomico)
        ->get();

        // dd($soci);
        $avales=DB::table('tbl_avales')
        ->select('tbl_avales.*')
        ->where('estatus_aval','=',0)
        ->orderBy('nombre','ASC')
        ->get();

        $estatus=DB::table('tbl_socio_economico')
        ->select('tbl_socio_economico.*')
        ->where('id_socio_economico','=',$id_socioeconomico)
        ->get();

       
        $articulos=DB::table('tbl_articulos')
        ->select('tbl_articulos.*')
        ->orderby('Nombre_articulo','asc')
        ->get();
        
        $productos=DB::table('tbl_productos')
        ->select('tbl_productos.*')
        ->orderby('producto','asc')
        ->get();

        // dd('Estas en el lugar correcto');
        return view('admin.socioeconomico.crearsocioeconomico',['soci'=>$soci,'avales'=>$avales,'estatus'=>$estatus,'fecha_actual'=>$fecha_actual,'articulos'=>$articulos,'productos'=>$productos]);
    }

    public function finalizacion(Request $request){

        $id_socioeconomico=$request->id_socio_economico;

        $familiar=DB::table('tbl_familiares')->select(DB::raw('count(*) as ftotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();

        $aval=DB::table('tbl_se_aval')->select(DB::raw('count(*) as atotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $vivienda=DB::table('tbl_vivienda')->select(DB::raw('count(*) as vtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $pareja=DB::table('tbl_pareja')->select(DB::raw('count(*) as ptotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $domicilio=DB::table('tbl_domicilio')->select(DB::raw('count(*) as dtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();

        $arhogar=DB::table('tbl_se_articulos_hogar')->select(DB::raw('count(*) as arhtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $finanzas=DB::table('tbl_se_finanzas')->select(DB::raw('count(*) as fintotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $fechamonto=DB::table('tbl_fecha_monto')->select(DB::raw('count(*) as fmtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $gmensuales=DB::table('tbl_gastos_mensuales')->select(DB::raw('count(*) as gmtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        $gsemanal=DB::table('tbl_gastos_semanales')->select(DB::raw('count(*) as gstotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $rlaboral=DB::table('tbl_se_referencia_laboral')->select(DB::raw('count(*) as rltotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $rpersonal=DB::table('tbl_se_referencia_personal')->select(DB::raw('count(*) as rptotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();

        $dt_general=DB::table('tbl_se_datos_generales')->select(DB::raw('count(*) as dt_total'))
        ->where('id_socio_economico','=',$id_socioeconomico)
        ->get();

        // if ($familiar[0]->ftotal>0) {
        //     if ($aval[0]->atotal>0) {
        //         if ($vivienda[0]->vtotal>0) {
        //             if ($pareja[0]->ptotal>0) {
        //                 if ($domicilio[0]->dtotal>0) {
        //                     if ($arhogar[0]->arhtotal>0) {
        //                         if ($finanzas[0]->fintotal>0) {
        //                             if ($fechamonto[0]->fmtotal>0) {
        //                                 if ($gmensuales[0]->gmtotal>0) {
        //                                     if ($gsemanal[0]->gstotal>0) {
        //                                         if ($rlaboral[0]->rltotal>0) {
        //                                             if ($rpersonal[0]->rptotal>0) {
        //                                                 if ($dt_general[0]->dt_total>0) {
                                                            $fecha_hoy=Carbon::now(); 
                                                            SocioEconomico::where('id_socio_economico','=',$id_socioeconomico)->update([
                                                                'estatus'=>100,
                                                                'fecha_actualizacion'=>$fecha_hoy
                                                            ]);
                                                            DB::table('tbl_log')->insert([
                                                                'id_log' => null, 
                                                                'id_tipo' => 2,
                                                                'id_plataforma' => 2,
                                                                'id_usuario' => Auth::user()->id,
                                                                'id_tipo_movimiento' => 3,
                                                                'id_movimiento' =>  $id_socioeconomico,
                                                                'descripcion' => "Se actualizó socioeconómico, como terminado",
                                                                'fecha_registro' => $fecha_hoy
                                                            ]);
                                                            return back()->with('status', '¡Concluido con éxito!');
        //                                                 } else {
        //                                                     return back()->with('danger', '¡Datos generales aun no se ha registrado!');
        //                                                 }
                                                        
        //                                             } else {
        //                                                 return back()->with('danger', '¡Datos de referencia personal aun no se ha registrado!');
        //                                             }
        //                                         } else {
        //                                             return back()->with('danger', '¡Datos de referencia laboral aun no se ha registrado!');
        //                                         }
        //                                     } else {
        //                                         return back()->with('danger', '¡Datos de gastos semanales aun no se ha registrado!');
        //                                     }
        //                                 } else {
        //                                     return back()->with('danger', '¡Datos de gastos mensuales aun no se ha registrado!');
        //                                 }
        //                             } else {
        //                                 return back()->with('danger', '¡Datos de fecho monto aun no se ha registrado!');
        //                             }
        //                         } else {
        //                             return back()->with('danger', '¡Datos de finanzas aun no se ha registrado!');
        //                         }
        //                     } else {
        //                         return back()->with('danger', '¡Datos de los articulos del hogar aun no se ha registrado!');
        //                     }
        //                 } else {
        //                     return back()->with('danger', '¡Datos del domicilio aun no se ha registrado!');
        //                 }
        //             } else {
        //                 return back()->with('danger', '¡Datos de la pareja aun no se ha registrado!');
        //             }
        //         } else {
        //             return back()->with('danger', '¡Datos de la vivienda aun no se ha registrado!');
        //         }
                
        //     } else {
        //         return back()->with('danger', '¡El aval aun no se ha registrado!');
        //     }
        // } else {
        //     return back()->with('danger', '¡Datos del familiar aun no se ha registrado!');
        // }
    }

    public function actualizacion_socio(Request $request){
        $id_socioeconomico=$request->id_socio;
        $fecha_actual = Carbon::now(); 
        SocioEconomico::where('id_socio_economico','=',$id_socioeconomico)->update([
            'fecha_actualizacion'=>$fecha_actual,
        ]);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 3,
            'id_movimiento' =>  $id_socioeconomico,
            'descripcion' => "Se actualizó socioeconómico",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Actualización concluido con éxito!');

    }

    public function aprobar_socio(Request $request){
        $id_prestamo=$request->id_préstamo;
        Prestamos::where('id_prestamo','=',$id_prestamo)->update([
            'id_status_prestamo'=>10,
        ]);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 2,
            'id_movimiento' =>  $id_prestamo,
            'descripcion' => "Se aprobó socioeconómico y préstamo",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Socioeconómico aprobado con éxito!');

    }

    public function negar_socio(Request $request){
        $id_prestamo=$request->id_préstamo;
        Prestamos::where('id_prestamo','=',$id_prestamo)->update([
            'id_status_prestamo'=>11,
        ]);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 3,
            'id_movimiento' =>  $id_prestamo,
            'descripcion' => "Se negó socioeconómico y préstamo",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Socioeconómico fue negado!');

    }

    public function informacion_socio_pdf($id_socio){
        
         $datos_generales=DB::table('tbl_se_datos_generales')
        ->select('tbl_se_datos_generales.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $docs_perfil=DB::table('tbl_se_documentos')
        ->select('tbl_se_documentos.*')
        ->where('id_socio_economico','=',$id_socio)
        ->where('tipo_persona','=',1)
        ->where('tipo_foto','=',4)
        ->get();

        $familiar=DB::table('tbl_familiares')
        ->select('tbl_familiares.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $aval=DB::table('tbl_avales')
        ->Join('tbl_se_aval', 'tbl_avales.id_aval', '=', 'tbl_se_aval.id_aval')
        ->select('tbl_avales.*')
        ->where('tbl_se_aval.id_socio_economico','=',$id_socio)
        ->get();

        $vivienda=DB::table('tbl_vivienda')
        ->select('tbl_vivienda.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $pareja=DB::table('tbl_pareja')
        ->select('tbl_pareja.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $domicilio=DB::table('tbl_domicilio')
        ->select('tbl_domicilio.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $articuloshogar=DB::table('tbl_se_articulos_hogar')
        ->select('tbl_se_articulos_hogar.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $finanzas=DB::table('tbl_se_finanzas')
        ->select('tbl_se_finanzas.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $fechamonto=DB::table('tbl_fecha_monto')
        ->select('tbl_fecha_monto.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $gastosmensuales=DB::table('tbl_gastos_mensuales')
        ->select('tbl_gastos_mensuales.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $gastossemanales=DB::table('tbl_gastos_semanales')
        ->select('tbl_gastos_semanales.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $referencialbpersonas=DB::table('tbl_se_rl_personas')
        ->join('tbl_se_referencia_laboral','tbl_se_rl_personas.id_referencia_laboral','=','tbl_se_referencia_laboral.id_referencia_laboral')
        ->select('tbl_se_rl_personas.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $referenciappersonas=DB::table('tbl_se_rp_personas')
        ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_referencia_personal.id_referencia_personal')
        ->select('tbl_se_rp_personas.*')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $docs_ine_1=DB::table('tbl_se_documentos')
        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
        ->select('tbl_se_documentos.*')
        ->where('id_socio_economico','=',$id_socio)
        ->where('tipo_persona','=',1)
        ->where('tipo_foto','=',1)
        ->get();

        $docs_ine_2=DB::table('tbl_se_documentos')
        ->select('tbl_se_documentos.*')
        ->where('id_socio_economico','=',$id_socio)
        ->where('tipo_persona','=',1)
        ->where('tipo_foto','=',2)
        ->get();

        $docs_comprobante=DB::table('tbl_se_documentos')
        ->select('tbl_se_documentos.*')
        ->where('id_socio_economico','=',$id_socio)
        ->where('tipo_persona','=',1)
        ->where('tipo_foto','=',3)
        ->get();
        $docs_referencia=DB::table('tbl_se_documentos')
        ->select('tbl_se_documentos.*')
        ->where('id_socio_economico','=',$id_socio)
        ->where('tipo_persona','=',1)
        ->where('tipo_foto','=',5)
        ->get();

        $docs_ine_1a=DB::table('tbl_se_documentos')
        ->select('tbl_se_documentos.*')
        ->where('id_socio_economico','=',$id_socio)
        ->where('tipo_persona','=',2)
        ->where('tipo_foto','=',1)
        ->get();

        $docs_ine_2a=DB::table('tbl_se_documentos')
        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
        ->select('tbl_se_documentos.*')
        ->where('id_socio_economico','=',$id_socio)
        ->where('tipo_persona','=',2)
        ->where('tipo_foto','=',2)
        ->get();

        $docs_comprobantea=DB::table('tbl_se_documentos')
        // ->join('tbl_se_referencia_personal','tbl_se_rp_personas.id_referencia_personal','=','tbl_se_rp_personas.id_referencia_personal')
        ->select('tbl_se_documentos.*')
        ->where('id_socio_economico','=',$id_socio)
        ->where('tipo_persona','=',2)
        ->where('tipo_foto','=',3)
        ->get();

        $datosgarantias=DB::table('tbl_se_garantias')
        ->join('tbl_articulos','tbl_se_garantias.tipo_garantia','tbl_articulos.id_articulo')
        ->select('tbl_se_garantias.*','tbl_articulos.Nombre_articulo')
        ->where('id_socio_economico','=',$id_socio)
        ->get();

        $datos_usuario=DB::table('tbl_socio_economico')
        ->join('tbl_usuarios','tbl_socio_economico.id_usuario','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_datos_usuario.*')
        ->where('tbl_socio_economico.id_socio_economico','=',$id_socio)
        ->get();

        $prestamo_aprobado=DB::table('tbl_socio_economico')
        ->join('tbl_usuarios','tbl_socio_economico.id_usuario','tbl_usuarios.id')
        ->join('tbl_prestamos','tbl_usuarios.id','tbl_prestamos.id_usuario')
        ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
        ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
        ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','tbl_status_prestamo.id_status_prestamo')
        ->select('tbl_prestamos.*','tbl_grupos.grupo as grupo','tbl_productos.producto as producto','tbl_status_prestamo.status_prestamo as estatus_prestamo')
        ->where('tbl_socio_economico.id_socio_economico','=',$id_socio)
        ->where('tbl_prestamos.id_status_prestamo','=',10)
        ->get();

        $prestamo_activos=DB::table('tbl_socio_economico')
        ->join('tbl_usuarios','tbl_socio_economico.id_usuario','tbl_usuarios.id')
        ->join('tbl_prestamos','tbl_usuarios.id','tbl_prestamos.id_usuario')
        ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
        ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
        ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','tbl_status_prestamo.id_status_prestamo')
        ->select('tbl_prestamos.*','tbl_grupos.grupo as grupo','tbl_productos.producto as producto','tbl_status_prestamo.status_prestamo as estatus_prestamo')
        ->where('tbl_socio_economico.id_socio_economico','=',$id_socio)
        ->where('tbl_prestamos.id_status_prestamo','=',2)
        ->get();

        $prestamo=[];

        if (count($prestamo_activos)==0) {
            $prestamo_renovacion=DB::table('tbl_socio_economico')
            ->join('tbl_usuarios','tbl_socio_economico.id_usuario','tbl_usuarios.id')
            ->join('tbl_prestamos','tbl_usuarios.id','tbl_prestamos.id_usuario')
            ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
            ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
            ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','tbl_status_prestamo.id_status_prestamo')
            ->select('tbl_prestamos.*','tbl_grupos.grupo as grupo','tbl_productos.producto as producto','tbl_status_prestamo.status_prestamo as estatus_prestamo')
            ->where('tbl_socio_economico.id_socio_economico','=',$id_socio)
            ->where('tbl_prestamos.id_status_prestamo','=',9)
            ->get();

            if (count($prestamo_renovacion)==0) {
                
                if (count($prestamo_aprobado)==0) {
                    $prestamo_pre_aprobados=DB::table('tbl_socio_economico')
                    ->join('tbl_usuarios','tbl_socio_economico.id_usuario','tbl_usuarios.id')
                    ->join('tbl_prestamos','tbl_usuarios.id','tbl_prestamos.id_usuario')
                    ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
                    ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                    ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','tbl_status_prestamo.id_status_prestamo')
                    ->select('tbl_prestamos.*','tbl_grupos.grupo as grupo','tbl_productos.producto as producto','tbl_status_prestamo.status_prestamo as estatus_prestamo')
                    ->where('tbl_socio_economico.id_socio_economico','=',$id_socio)
                    ->where('tbl_prestamos.id_status_prestamo','=',14)
                    ->get();

                    if (count($prestamo_pre_aprobados)==0) {
                        $prestamo_pre_requiere_aprobacion=DB::table('tbl_socio_economico')
                        ->join('tbl_usuarios','tbl_socio_economico.id_usuario','tbl_usuarios.id')
                        ->join('tbl_prestamos','tbl_usuarios.id','tbl_prestamos.id_usuario')
                        ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
                        ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                        ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','tbl_status_prestamo.id_status_prestamo')
                        ->select('tbl_prestamos.*','tbl_grupos.grupo as grupo','tbl_productos.producto as producto','tbl_status_prestamo.status_prestamo as estatus_prestamo')
                        ->where('tbl_socio_economico.id_socio_economico','=',$id_socio)
                        ->where('tbl_prestamos.id_status_prestamo','=',13)
                        ->get();

                        if (count($prestamo_pre_requiere_aprobacion)==0) {
                            $prestamo_pagados=DB::table('tbl_socio_economico')
                            ->join('tbl_usuarios','tbl_socio_economico.id_usuario','tbl_usuarios.id')
                            ->join('tbl_prestamos','tbl_usuarios.id','tbl_prestamos.id_usuario')
                            ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
                            ->join('tbl_productos','tbl_prestamos.id_producto','tbl_productos.id_producto')
                            ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','tbl_status_prestamo.id_status_prestamo')
                            ->select('tbl_prestamos.*','tbl_grupos.grupo as grupo','tbl_productos.producto as producto','tbl_status_prestamo.status_prestamo as estatus_prestamo')
                            ->where('tbl_socio_economico.id_socio_economico','=',$id_socio)
                            ->where('tbl_prestamos.id_status_prestamo','=',8)
                            ->orderBy('tbl_prestamos.id_prestamo','DESC')
                            ->get();

                            $prestamo=$prestamo_pagados->first();


                        } else {
                            $prestamo=$prestamo_pre_requiere_aprobacion->first();
                        }
                        


                    } else {
                        $prestamo=$prestamo_pre_aprobados->first();
                    }
                    



                } else {
                    $prestamo=$prestamo_aprobado->first();
                }
                

            } else {
                if (count($prestamo_aprobado)==0) {
                    $prestamo=$prestamo_renovacion->first();
                } else {
                    $prestamo=$prestamo_aprobado->first();
                }
                
            }
            

        } else {
            $prestamo=$prestamo_activos->first();
        }
        

        // $pdf = PDF::loadView('admin.socioeconomico.informacion_socioeconomico_pdf',['datosgarantias'=>$datosgarantias,'familiar'=>$familiar,'aval'=>$aval,'vivienda'=>$vivienda,'pareja'=>$pareja,'domicilio'=>$domicilio,'articuloshogar'=>$articuloshogar,'finanzas'=>$finanzas,'fechamonto'=>$fechamonto,'gastosmensuales'=>$gastosmensuales,'gastossemanales'=>$gastossemanales,'referencialbpersonas'=>$referencialbpersonas,'referenciappersonas'=>$referenciappersonas,'datos_generales'=>$datos_generales,'docs_perfil'=>$docs_perfil,'docs_ine_1'=>$docs_ine_1,'docs_ine_2'=>$docs_ine_2,'docs_comprobante'=>$docs_comprobante,'docs_ine_1a'=>$docs_ine_1a,'docs_ine_2a'=>$docs_ine_2a,'docs_comprobantea'=>$docs_comprobantea]);
        $pdf = PDF::loadView('admin.socioeconomico.reporte_socioeconomico',['prestamo'=>$prestamo,'datos_usuario'=>$datos_usuario,'docs_referencia'=>$docs_referencia,'id_socio'=>$id_socio,'datosgarantias'=>$datosgarantias,'familiar'=>$familiar,'aval'=>$aval,'vivienda'=>$vivienda,'pareja'=>$pareja,'domicilio'=>$domicilio,'articuloshogar'=>$articuloshogar,'finanzas'=>$finanzas,'fechamonto'=>$fechamonto,'gastosmensuales'=>$gastosmensuales,'gastossemanales'=>$gastossemanales,'referencialbpersonas'=>$referencialbpersonas,'referenciappersonas'=>$referenciappersonas,'datos_generales'=>$datos_generales,'docs_perfil'=>$docs_perfil,'docs_ine_1'=>$docs_ine_1,'docs_ine_2'=>$docs_ine_2,'docs_comprobante'=>$docs_comprobante,'docs_ine_1a'=>$docs_ine_1a,'docs_ine_2a'=>$docs_ine_2a,'docs_comprobantea'=>$docs_comprobantea]);
        return $pdf->stream();
    }
}
