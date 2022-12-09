<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Grupos;
use App\Zona;
use App\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class GruposController extends Controller
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
        //$tclientes = DB::select('select * from tbl_usuarios where id_tipo_usuario = ?', [3]);

        $tclientes = DB::table('tbl_usuarios')
            ->join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_datos_usuario')
            ->select('tbl_usuarios.*', 'tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
            ->get();
 
        $grupos = DB::table('tbl_grupos')
            ->join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
            ->select('tbl_grupos.*', 'tbl_zona.Zona')
            ->get();

        $supervisoras=DB::table('tbl_usuarios')
        ->join('tbl_tipo_usuario','tbl_usuarios.id_tipo_usuario','tbl_tipo_usuario.id_tipo_usuario')
        ->select('tbl_usuarios.*', 'tbl_tipo_usuario.nombre')
        ->where('tbl_usuarios.id_tipo_usuario','=',5)
        ->get();


        return view('admin.grupos.index',['grupos'=>$grupos,'tclientes'=>$tclientes,'supervisoras'=>$supervisoras]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zonas = DB::table('tbl_zona')
            ->select('tbl_zona.*')
            ->orderBy('Zona','ASC')
            ->get();
        return view('admin.grupos.create',['zonas'=>$zonas]);
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
            'grupo' => 'required',
            'localidad' => 'required',
            'municipio' => 'required',
            'estado' => 'required',
            'IdZona'=> 'required',
        ]);
        Grupos::create($request->all());

        $idGrupo = Grupos::latest('id_grupo')->first();

        $fecha_pago = $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 11,
            'id_movimiento' =>  $idGrupo->id_grupo,
            'descripcion' => "Se registró un nuevo grupo",
            'fecha_registro' => $fecha_pago
        ]);

        return  back()->with('status','¡Registro guardado con éxito!');
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
    public function edit($id_grupo)
    {
        $zonas = DB::table('tbl_zona')
            ->select('tbl_zona.*')
            ->orderBy('Zona','ASC')
            ->get();
        $grupos=Grupos::findOrFail($id_grupo);
        return view('admin/grupos/edit',['grupos'=>$grupos,'zonas'=>$zonas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_grupo)
    {
        $datosAc=request()->except(['_token','_method']);
        Grupos::where('id_grupo','=',$id_grupo)->update($datosAc);
        $fecha_pago = $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 11,
            'id_movimiento' =>  $id_grupo,
            'descripcion' => "Se actualizó grupo",
            'fecha_registro' => $fecha_pago
        ]);
        return back()->with('status','¡Registro actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_grupo)
    {
        Grupos::destroy($id_grupo);
        $fecha_pago = $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 11,
            'id_movimiento' =>  $id_grupo,
            'descripcion' => "Se eliminó grupo",
            'fecha_registro' => $fecha_pago
        ]);
        return back()->with('status','¡Registro eliminado con éxito!');
    }
    public function sinzona()
    {
        
        $grupos=Grupos::all()->where('IdZona','=','');

        $zonas=Zona::all();
        return view('admin.grupos.sinzona',['grupos'=>$grupos,'zonas'=>$zonas]);
    }

    public function agregarazona(Request $request)
    {
        $id_grupo=$request->id_grupo;

        //dd($id_grupo);
        $datosAc=request()->except(['_token','_method']);
        Grupos::where('id_grupo','=',$id_grupo)->update($datosAc);

        return back()->with('status', ' Zona agregado correctamente ');
    }

    public function filtroporzona($IdZona)
    {
        $zona=Zona::find($IdZona);
        $gruposfiltrado=Grupos::all()->where('IdZona','=',$IdZona);
        return view('admin.grupos.filtroporzona',['gruposfiltrado'=>$gruposfiltrado,'zona'=>$zona]);
        
    }
    public function pdf(){

        $tclientes = DB::table('tbl_usuarios')
            ->join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_datos_usuario')
            ->select('tbl_usuarios.*', 'tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
            ->get();
 
        $grupos = DB::table('tbl_grupos')
            ->join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
            ->select('tbl_grupos.*', 'tbl_zona.Zona')
            ->get();

        $pdf = PDF::loadView('admin.grupos.pdf',['grupos'=>$grupos,'tclientes'=>$tclientes]);
        return $pdf->stream();
    }

}
