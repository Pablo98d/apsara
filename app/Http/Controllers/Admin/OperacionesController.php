<?php

namespace App\Http\Controllers\admin;

use App\Zona;
use App\Grupos;
use App\Plaza;
use App\Negociacion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class OperacionesController extends Controller
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

        $id_estatus_p=$request->id_estatus_p;
        if (empty($id_estatus_p)) {
            $prospectos=DB::table('v_prospectos')
            ->select('v_prospectos.*')
            ->get();

            return view('admin.operaciones.prospectos',['prospectos'=>$prospectos,'id_status'=>$id_estatus_p]);
        } elseif($id_estatus_p==1) {
            $prospectos=DB::table('v_prospectos_pendientes')
            ->select('v_prospectos_pendientes.*')
            ->get();
            return view('admin.operaciones.prospectos',['prospectos'=>$prospectos,'id_status'=>$id_estatus_p]);
        } elseif($id_estatus_p==10){
            $prospectos=DB::table('v_prospectos_aprobados')
            ->select('v_prospectos_aprobados.*')
            ->get();
            return view('admin.operaciones.prospectos',['prospectos'=>$prospectos,'id_status'=>$id_estatus_p]);
        } elseif($id_estatus_p==11){
            $prospectos=DB::table('v_prospectos_negados')
            ->select('v_prospectos_negados.*')
            ->get();
            return view('admin.operaciones.prospectos',['prospectos'=>$prospectos,'id_status'=>$id_estatus_p]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plazas=Plaza::all();
        return view('admin.zona.nuevazona',['plazas'=>$plazas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('kjhhgfd');
        $this->validate($request,[
            //'IdZona' => 'required',
            'Zona' => 'required',
            'Fecha_apertura' => 'required',
            'IdPlaza',
        ]);
        Zona::create($request->all());

        

        return redirect()->route('admin-zona.index')->with('Guardar','¡Registro Guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdZona)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdZona)
    {
        $zona=Zona::find($IdZona);
        return view('admin.zona.editarzona',['zona'=>$zona]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdZona)
    {
        $datosAc=request()->except(['_token','_method']);
        Zona::where('IdZona','=',$IdZona)->update($datosAc);

        return redirect()->route('admin-zona.index')->with('Guardar','Registro actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdZona)
    {
        Zona::destroy($IdZona);
        return redirect()->route('admin-zona.index')->with('Guardar','Registro eliminado con éxito');
    }
    
    public function buscarz(Request $request){
        $IdPlaza=$request->IdPlaza;
        $zonas=Zona::all()->where('IdPlaza','=',$IdPlaza);

        return view('admin.operaciones.prospectos',['zonas'=>$zonas,'idzona'=>$idzona,'IdPlaza'=>$IdPlaza]);
    }

    public function buscarg(Request $request){
        $idzona=$request->IdZona;
        
        $zonas=Zona::all();
        $idgrupo='0';
        $grupos=Grupos::all()->where('IdZona','=',$idzona);
        return view('admin.operaciones.prospectos',['zonas'=>$zonas,'idzona'=>$idzona,'grupos'=>$grupos,'idgrupo'=>$idgrupo]);
    }

    public function prospectos_admin(Request $request,$idregion,$idzona,$idgrupos){

        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        // $grupo= Grupos::find($idgrupo);

        if ($idgrupos==0) {
            $idgrupo=$request->id_grupo;
        } else {
            $idgrupo=$idgrupos;
            // dd('no es cero jajaj');
        }
        
        $grupo= Grupos::find($idgrupo);

        $grupos=DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->where('IdZona','=',$idzona)
        ->get();

        $id_estatus_p=$request->id_estatus_p;
        if (empty($id_estatus_p)) {
            $id_estatus_p='1';
            $prospectos=DB::table('v_prospectos_pendientes')
            ->select('v_prospectos_pendientes.*')
            ->where('v_prospectos_pendientes.id_grupo','=',$idgrupo)
            ->get();

            // dd('hgfdsdfghjkl');
            // return view('admin.operaciones.prospectos',['prospectos'=>$prospectos,'id_status'=>$id_estatus_p,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo]);
        } elseif($id_estatus_p==1) {
            $prospectos=DB::table('v_prospectos_pendientes')
            ->select('v_prospectos_pendientes.*')
            ->where('v_prospectos_pendientes.id_grupo','=',$idgrupo)
            ->get();
            // return view('admin.operaciones.prospectos',['prospectos'=>$prospectos,'id_status'=>$id_estatus_p,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo]);
        } elseif($id_estatus_p==10){
            $prospectos=DB::table('v_prospectos_aprobados')
            ->select('v_prospectos_aprobados.*')
            ->where('v_prospectos_aprobados.id_grupo','=',$idgrupo)
            ->get();
            // return view('admin.operaciones.prospectos',['prospectos'=>$prospectos,'id_status'=>$id_estatus_p,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo]);
        } elseif($id_estatus_p==11){
            $prospectos=DB::table('v_prospectos_negados')
            ->select('v_prospectos_negados.*')
            ->where('v_prospectos_negados.id_grupo','=',$idgrupo)
            ->get();
        }
        return view('admin.operaciones.prospectos',['prospectos'=>$prospectos,'id_status'=>$id_estatus_p,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'grupos'=>$grupos]);
    }

    public function socio_eco_admin(Request $request,$idregion,$idzona,$idgrupos){
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        

        if ($idgrupos==0) {
            $idgrupo=$request->id_grupo;
            $grupo= Grupos::find($idgrupo);
        } else {
            $idgrupo=$idgrupos;
            $grupo= Grupos::find($idgrupo);
            // dd('no es cero jajaj');
        }
        
        $grupos=DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->where('IdZona','=',$idzona)
        ->get();

        $id_estatus_p=$request->id_estatus_p;
        if (empty($id_estatus_p)) {
            $id_estatus_p='1';
            $socioeconomicos=DB::table('v_socioeco_pendiente')
            ->join('tbl_datos_usuario as cliente','v_socioeco_pendiente.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_pendiente.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_pendiente.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_pendiente.id_grupo','=',$idgrupo)
            ->get();
        }  elseif ($id_estatus_p==1) {
            $socioeconomicos=DB::table('v_socioeco_pendiente')
            ->join('tbl_datos_usuario as cliente','v_socioeco_pendiente.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_pendiente.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_pendiente.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_pendiente.id_grupo','=',$idgrupo)
            ->get();
        } elseif ($id_estatus_p==2) {
            $socioeconomicos=DB::table('v_socioeco_en_proceso')
            ->join('tbl_datos_usuario as cliente','v_socioeco_en_proceso.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_en_proceso.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_en_proceso.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_en_proceso.id_grupo','=',$idgrupo)
            ->get();
        } elseif ($id_estatus_p==3) {
            $socioeconomicos=DB::table('v_socioeco_completado')
            ->join('tbl_datos_usuario as cliente','v_socioeco_completado.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_completado.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_completado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_completado.id_grupo','=',$idgrupo)
            ->get();
        } elseif ($id_estatus_p==10) {
            $socioeconomicos=DB::table('v_socioeco_aprobado')
            ->join('tbl_datos_usuario as cliente','v_socioeco_aprobado.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_aprobado.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_aprobado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_aprobado.id_grupo','=',$idgrupo)
            ->get();
        } elseif ($id_estatus_p==11) {
            $socioeconomicos=DB::table('v_socioeco_negado')
            ->join('tbl_datos_usuario as cliente','v_socioeco_negado.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_negado.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_negado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_negado.id_grupo','=',$idgrupo)
            ->get();
        }
        
        

        return view('admin.operaciones.estudios_socio_eco',['socioeconomicos'=>$socioeconomicos,'id_status'=>$id_estatus_p,'region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'grupos'=>$grupos]);
    }
    public function clientes_operacion(){

        $negociaciones_pendinte=DB::table('tbl_negociacion')
            ->join('tbl_prestamos','tbl_negociacion.id_prestamo','tbl_prestamos.id_prestamo')
            ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
            ->join('tbl_zona','tbl_grupos.IdZona','tbl_zona.IdZona')
            ->join('tbl_productos','tbl_prestamos.id_producto','=','tbl_productos.id_producto')
            ->join('tbl_usuarios','tbl_prestamos.id_usuario','=','tbl_usuarios.id')
            ->join('tbl_datos_usuario','tbl_usuarios.id','=','tbl_datos_usuario.id_usuario')
            ->select('tbl_productos.producto as n_producto','tbl_datos_usuario.*','tbl_prestamos.*','tbl_negociacion.*','tbl_zona.Zona','tbl_grupos.grupo')
            ->where('tbl_negociacion.estatus','=','Pendiente')
            // ->groupBy('grupo')
            ->get();
            $negociaciones=DB::table('tbl_negociacion')
            ->join('tbl_prestamos','tbl_negociacion.id_prestamo','tbl_prestamos.id_prestamo')
            ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
            ->join('tbl_zona','tbl_grupos.IdZona','tbl_zona.IdZona')
            ->join('tbl_productos','tbl_prestamos.id_producto','=','tbl_productos.id_producto')
            ->join('tbl_usuarios','tbl_prestamos.id_usuario','=','tbl_usuarios.id')
            ->join('tbl_datos_usuario','tbl_usuarios.id','=','tbl_datos_usuario.id_usuario')
            ->select('tbl_productos.producto as n_producto','tbl_datos_usuario.*','tbl_prestamos.*','tbl_negociacion.*','tbl_zona.Zona','tbl_grupos.grupo')
            // ->groupBy('grupo')
            ->get();

        return view('admin.operaciones.clientes_operacion',['negociaciones'=>$negociaciones,'negociaciones_pendinte'=>$negociaciones_pendinte]);
    }

    public function detalle_propuesta($id_nego){
        $propuesta=DB::table('tbl_negociacion')
            ->join('tbl_prestamos','tbl_negociacion.id_prestamo','tbl_prestamos.id_prestamo')
            ->join('tbl_grupos','tbl_prestamos.id_grupo','tbl_grupos.id_grupo')
            ->join('tbl_productos','tbl_prestamos.id_producto','=','tbl_productos.id_producto')
            ->join('tbl_usuarios','tbl_prestamos.id_usuario','=','tbl_usuarios.id')
            ->join('tbl_datos_usuario','tbl_usuarios.id','=','tbl_datos_usuario.id_usuario')
            ->select('tbl_productos.*','tbl_datos_usuario.*','tbl_prestamos.*','tbl_negociacion.*','tbl_grupos.*')
            ->where('tbl_negociacion.id_negociacion','=',$id_nego)
            ->groupBy('grupo')
            ->get();
        return view('admin.operaciones.detalle_propuestas',['propuesta'=>$propuesta]);
    }
    public function guardar_estatus(Request $request){
        $id_nego=$request->id_negociacion;
        $a=$request->all();
        // dd($a);
        $datosAc=request()->except(['_token','_method']);
        Negociacion::where('id_negociacion','=',$id_nego)->update($datosAc);

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 12,
            'id_movimiento' =>  $id_nego,
            'descripcion' => "Se actualizó una negociación",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡La propuesta fue guardado con éxito!');
    }

    public function clientes_opciones(){

        $clientes=DB::table('tbl_usuarios')
            // ->join('tbl_prestamos','tbl_negociacion.id_prestamo','tbl_prestamos.id_prestamo')
            ->select('tbl_usuarios.*')
            ->where('id_tipo_usuario','=',3)
            ->groupBy('grupo')
            ->get();

        return view('admin.operaciones.clientes_opciones',['clientes'=>$clientes]);
    }
}
