<?php

namespace App\Http\Controllers\analista;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DatosUsuario;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\SocioEconomico;
use App\Familiares;
use App\Prestamos;
use Illuminate\Support\Facades\Auth;



class HomeAnalistaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','rol.analista']);
    }

    public function index()
    {
        $grupo_socio = DB::table('tbl_prestamos')
        ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')
        ->Join('tbl_socio_economico', 'tbl_usuarios.id', '=', 'tbl_socio_economico.id_usuario')
        ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
        ->select('tbl_grupos.*')
        ->where('tbl_prestamos.id_status_prestamo','=',1)
        ->where('tbl_socio_economico.estatus','=',100)
        ->distinct()
        ->orderBy('tbl_grupos.grupo','ASC')
        ->get();

        $filtro_grupos = DB::table('tbl_grupos')
        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
        ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
        ->select('tbl_grupos.*','tbl_zona.*','tbl_plaza.*')
        ->orderBy('tbl_grupos.grupo','ASC')
        ->get();
        return view('analista.homeanalista',['grupo_socio'=>$grupo_socio,'filtro_grupos'=>$filtro_grupos]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

   
    public function socio_eco_analista(Request $request,$idgrupo){
        $id_estatus_p=$request->id_estatus_p;

        if (empty($id_estatus_p)) {
            $id_estatus_p='3';
            $socioeconomicos=DB::table('v_socioeco_completado')
            ->join('tbl_datos_usuario as cliente','v_socioeco_completado.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_completado.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_completado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_completado.id_grupo','=',$idgrupo)
            ->get();
            return view('analista.socio_aprobar',['socioeconomicos'=>$socioeconomicos,'id_status'=>$id_estatus_p]);
        } elseif ($id_estatus_p==11) {
            $socioeconomicos=DB::table('v_socioeco_negado')
            ->join('tbl_datos_usuario as cliente','v_socioeco_negado.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_negado.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_negado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_negado.id_grupo','=',$idgrupo)
            ->get();
        }

        return view('analista.socio_aprobar',['socioeconomicos'=>$socioeconomicos,'id_status'=>$id_estatus_p]);
    }

    public function crear_socio_eco(Request $request){
        $id_socioeconomico=$request->id_socioeconomico;
        $soci=DB::table('tbl_socio_economico')
                ->join('tbl_usuarios','tbl_socio_economico.id_usuario','=','tbl_usuarios.id')
                ->select('tbl_socio_economico.*','tbl_usuarios.nombre_usuario')
                ->where('tbl_socio_economico.id_socio_economico','=',$id_socioeconomico)
                ->get();

        $avales=DB::table('tbl_avales')
        ->select('tbl_avales.*')
        ->where('estatus_aval','=',0)
        ->orderBy('nombre','ASC')
        ->get();

        $estatus=DB::table('tbl_socio_economico')
        ->select('tbl_socio_economico.*')
        ->where('id_socio_economico','=',$id_socioeconomico)
        ->get();

        return view('analista.socio_economico',['soci'=>$soci,'avales'=>$avales,'estatus'=>$estatus]);
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
            'id_tipo_movimiento' => 3,
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
        return back()->with('danger', '¡Socioeconómico fue negado!');

    }

    public function socio_pendientes($idgrupo){
        $id_status='3'; 
        $socio_pendientes=DB::table('v_socioeco_completado')
            ->join('tbl_datos_usuario as cliente','v_socioeco_completado.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_completado.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_completado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_completado.id_grupo','=',$idgrupo)
            ->get();

        return view('analista.socio_eco_pendientes',['socioeconomicos'=>$socio_pendientes,'id_status'=>$id_status]);
    }
    public function socio_aprobados($idgrupo){
        $id_status='10'; 
        $socio_aprobados=DB::table('v_socioeco_aprobado')
            ->join('tbl_datos_usuario as cliente','v_socioeco_aprobado.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_aprobado.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_aprobado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_aprobado.id_grupo','=',$idgrupo)
            ->get();
        return view('analista.socio_eco_aprobados',['socioeconomicos'=>$socio_aprobados,'id_status'=>$id_status]);
    }
    public function socio_negados($idgrupo){
        $id_status ='11';
        $socio_negados=DB::table('v_socioeco_negado')
            ->join('tbl_datos_usuario as cliente','v_socioeco_negado.id_usuario','=','cliente.id_usuario')
            ->join('tbl_datos_usuario as promotora','v_socioeco_negado.id_promotora','=','promotora.id_usuario')
            ->select('v_socioeco_negado.*','cliente.nombre as n_cliente','cliente.ap_paterno as p_cliente','cliente.ap_materno as m_cliente','promotora.nombre as n_promotora','promotora.ap_paterno as p_promotora','promotora.ap_materno as m_promotora')
            ->where('v_socioeco_negado.id_grupo','=',$idgrupo)
            ->get();
        return view('analista.socio_eco_negados',['socioeconomicos'=>$socio_negados,'id_status'=>$id_status]);
    }
    public function mi_perfil(){
        return view('analista.mi_perfil');
    }

}
