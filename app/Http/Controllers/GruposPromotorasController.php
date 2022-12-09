<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\GruposPromotoras;
use App\Grupos;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GruposPromotorasController extends Controller
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
        $grupospromotoras = DB::table('tbl_grupos_promotoras')
            ->Join('tbl_grupos', 'tbl_grupos_promotoras.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_datos_usuario', 'tbl_grupos_promotoras.id_usuario', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_grupos_promotoras.*', 'tbl_grupos.grupo','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_materno','tbl_datos_usuario.ap_paterno')
            ->get();
        return view('admin.grupospromotoras.index',compact('grupospromotoras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos = Grupos::orderBy('grupo', 'asc')->get();
        // $usuarios = User::orderBy('nombre_usuario', 'asc')->get();
        $usuarios = DB::table('tbl_usuarios')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_usuarios.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
            ->where('tbl_usuarios.id_tipo_usuario','=',4)
            ->get();
      
        return view('admin.grupospromotoras.create',compact('grupos'),compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           $this->validate($request,[
            'id_grupo' => 'required',
            'id_usuario' => 'required',
        ]);
  
        GruposPromotoras::create($request->all());

        $idPr = GruposPromotoras::latest('id_grupo_promotoras')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 7,
            'id_movimiento' =>  $idPr->id_grupo_promotoras,
            'descripcion' => "Se registró una promotora a un grupo",
            'fecha_registro' => $fecha_hoy
        ]);

        return redirect()->route('grupospromotoras.index')->with('status','Registro guardado con éxito.');
  
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
        $gruposN=Grupos::all();
        $usuario=User::all();
        $grupospromotoras=GruposPromotoras::findOrFail($id);
        return view('admin/grupospromotoras/edit', compact('grupospromotoras','gruposN','usuario'));
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
        GruposPromotoras::where('id_grupo_promotoras','=',$id)->update($datosAc);

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 7,
            'id_movimiento' =>  $id,
            'descripcion' => "Se cambió promotora de grupo",
            'fecha_registro' => $fecha_hoy
        ]);

        return redirect()->route('grupospromotoras.index')->with('status','¡Registro actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        GruposPromotoras::destroy($id);

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 7,
            'id_movimiento' =>  $request->id_promotora,
            'descripcion' => "Se eliminó promotora de grupo",
            'fecha_registro' => $fecha_hoy
        ]);

        return redirect()->route('grupospromotoras.index')->with('status','¡Registro eliminado con éxito!');
    }

    public function buscando_grupos_promotoras(Request $request){
        $promotoras = DB::table('tbl_grupos_promotoras')
        ->Join('tbl_datos_usuario', 'tbl_grupos_promotoras.id_usuario', '=', 'tbl_datos_usuario.id_usuario')
        ->select('tbl_grupos_promotoras.*','tbl_datos_usuario.*')
        ->where('tbl_grupos_promotoras.id_grupo','=',$request->id_grupo)
        ->where('tbl_grupos_promotoras.id_usuario','=',$request->id_usuario)
        ->get();

    

        echo json_encode($promotoras);
    }


}
