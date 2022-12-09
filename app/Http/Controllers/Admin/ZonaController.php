<?php

namespace App\Http\Controllers\admin;

use App\Zona;
use App\Plaza;
use App\ZonaGerente;
use Carbon\Carbon;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class ZonaController extends Controller
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
        //$zonas=Zona::orderBy('Fecha_apertura','desc')->paginate(5);

        $zonas = DB::table('tbl_zona')
            ->join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
            ->select('tbl_zona.*', 'tbl_plaza.Plaza')
            ->paginate(5);

        $gerenteszona=DB::table('tbl_usuarios')
        ->join('tbl_tipo_usuario','tbl_usuarios.id_tipo_usuario','tbl_tipo_usuario.id_tipo_usuario')
        ->select('tbl_usuarios.*', 'tbl_tipo_usuario.nombre')
        ->where('tbl_usuarios.id_tipo_usuario','=',2)
        ->get();

        //dd($gerenteszona);
        return view('admin.zona.index',['zonas'=>$zonas,'gerenteszona'=>$gerenteszona]);
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
        $this->validate($request,[
            //'IdZona' => 'required',
            'Zona' => 'required',
            'Fecha_apertura' => 'required',
            'IdPlaza',
        ]);
        Zona::create($request->all());
        $idZ = Zona::latest('IdZona')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 14,
            'id_movimiento' =>  $idZ->IdZona,
            'descripcion' => "Se registró una nueva zona",
            'fecha_registro' => $fecha_hoy
        ]);

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
        $zona=Zona::find($IdZona);
        return view('admin.zona.showzona',['zona'=>$zona]); 
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
        
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 14,
            'id_movimiento' =>  $IdZona,
            'descripcion' => "Se actualizó una zona",
            'fecha_registro' => $fecha_hoy
        ]);

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

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 14,
            'id_movimiento' =>  $IdZona,
            'descripcion' => "Se eliminó una zona",
            'fecha_registro' => $fecha_hoy
        ]);
        return redirect()->route('admin-zona.index')->with('Guardar','Registro eliminado con éxito');
    }
    public function agregar_gerente(Request $request){

        if (empty($request->id_usuario_g)) {
            return back()->with('error', '¡No seleccionó ningun gerente!');
        } else {
            $prestamo = ZonaGerente::create([
                'id_zona'     => $request->IdZona,
                'id_usuario'  => $request->id_usuario_g,
            ])->save();
            $idZG = ZonaGerente::latest('id_zona_gerente')->first();
            $fecha_hoy=Carbon::now();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 1,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 15,
                'id_movimiento' =>  $idZG->id_zona_gerente,
                'descripcion' => "Se registró nuevo gerente de zona",
                'fecha_registro' => $fecha_hoy
            ]);

            return redirect()->route('admin-zona.index')->with('Guardar','Gerente agregado correctamente a la zona');
        }
        

    }

    public function showgerenteszona($idzona){

        $gerenteszona=DB::table('tbl_usuarios')
        ->join('tbl_zonas_gerentes','tbl_usuarios.id','tbl_zonas_gerentes.id_usuario')
        ->join('tbl_zona','tbl_zonas_gerentes.id_zona','tbl_zona.IdZona')
        ->select('tbl_usuarios.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->get();

        $zona=Zona::find($idzona);

        return view('admin.zona.gerenteszona',['zona'=>$zona,'gerenteszona'=>$gerenteszona]);
    }

    public function allgerentesdezona(){

        $zonas=Zona::all();
        $gerenteszona=DB::table('tbl_usuarios')
        ->join('tbl_tipo_usuario','tbl_usuarios.id_tipo_usuario','tbl_tipo_usuario.id_tipo_usuario')
        ->select('tbl_usuarios.*', 'tbl_tipo_usuario.nombre')
        ->where('tbl_usuarios.id_tipo_usuario','=',2)
        ->get();

        $allgerentes=DB::table('tbl_usuarios')
        ->join('tbl_tipo_usuario','tbl_usuarios.id_tipo_usuario','tbl_tipo_usuario.id_tipo_usuario')
        ->join('tbl_zonas_gerentes','tbl_usuarios.id','tbl_zonas_gerentes.id_usuario')
        ->join('tbl_zona','tbl_zonas_gerentes.id_zona','tbl_zona.IdZona')
        //->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_usuarios.*','tbl_zona.Zona','tbl_zona.IdZona','tbl_zonas_gerentes.id_zona_gerente')
        ->get();
        return view('admin.zona.allgerentezona',['allgerentes'=>$allgerentes,'zonas'=>$zonas,'gerenteszona'=>$gerenteszona]);
    }

    public function updatezona(Request $request){
        
        $id_zona_gerente=$request->id_zona_gerente;

        $datosAc=request()->except(['_token','_method']);
        ZonaGerente::where('id_zona_gerente','=',$id_zona_gerente)->update($datosAc);
            $fecha_hoy=Carbon::now();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 2,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 15,
                'id_movimiento' =>  $id_zona_gerente,
                'descripcion' => "Se actualizó gerente de zona",
                'fecha_registro' => $fecha_hoy
            ]);

        return back()->with('status', '¡Registro actualizado con éxito!');
        //return redirect()->route('admin-zona.index')->with('Guardar','Zona del gerente actualizado');   
    }
    public function deletezona($id_zona_gerente){

        ZonaGerente::destroy($id_zona_gerente);
            $fecha_hoy=Carbon::now();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 3,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 15,
                'id_movimiento' =>  $id_zona_gerente,
                'descripcion' => "Se eliminó gerente de zona",
                'fecha_registro' => $fecha_hoy
            ]);

        return back()->with('status', '¡Registro eliminado con éxito!');
        //return redirect()->route('admin-zona.index')->with('Guardar','Zona del gerente actualizado');   
    }

    public function reporte_corte($idregion,$idzona){
        // dd('estas en el controlador');
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

        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        

        $grupos = DB::table('tbl_grupos')
            ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
            ->select('tbl_grupos.*')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('tbl_prestamos')
                        ->whereRaw('tbl_prestamos.id_grupo = tbl_grupos.id_grupo');
            })
            ->where('tbl_grupos.IdZona','=',$idzona)
            ->distinct()
            ->orderby('tbl_grupos.grupo','asc')
            ->get();

        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region_actual)
        ->orderBy('Zona','ASC')
        ->get();

        return view('admin.zona.corte_por_zona',['region'=>$region,'zona'=>$zona,'grupos'=>$grupos,'zonas'=>$zonas]);
    }

    public function reporte_corte_pdf($idregion,$idzona){

        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        
        $grupos = DB::table('tbl_grupos')
            ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
            ->select('tbl_grupos.*')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('tbl_prestamos')
                        ->whereRaw('tbl_prestamos.id_grupo = tbl_grupos.id_grupo');
            })
            ->where('tbl_grupos.IdZona','=',$idzona)
            ->distinct()
            ->orderby('tbl_grupos.grupo','asc')
            ->get();
            
            $pdf = PDF::loadView('admin.zona.pdf_corte_por_zona',['region'=>$region,'zona'=>$zona,'grupos'=>$grupos])
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function reporte_corte_por_fechas(Request $request,$idregion,$idzona,$semanas){
        
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $fecha_actual=Carbon::now();
        
        $grupos = DB::table('tbl_grupos')
            ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
            ->select('tbl_grupos.*')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('tbl_prestamos')
                        ->whereRaw('tbl_prestamos.id_grupo = tbl_grupos.id_grupo');
            })
            ->where('tbl_grupos.IdZona','=',$idzona)
            ->distinct()
            ->orderby('tbl_grupos.grupo','asc')
            ->get();
        // return view('admin.zona.corte_por_zona',['region'=>$region,'zona'=>$zona,'grupos'=>$grupos,'dias_corte'=>$dias_corte,'f_actual'=>$f_actual,'cant_dias'=>$cant_dias]);
        $pdf = PDF::loadView('admin.zona.pdf_corte_por_fechas',['region'=>$region,'zona'=>$zona,'grupos'=>$grupos,'semanas'=>$semanas,'fecha_actual'=>$fecha_actual]);
        return $pdf->stream();

    }

    public function cortes_semanas_pagos(Request $request,$idregion,$idzona){
        
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);

        $semanas=$request->txf_semanas;
        
        $fecha_actual=Carbon::now();
        $f_actual= $fecha_actual->format('d-M-Y');
        

        $grupos = DB::table('tbl_grupos')
            ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
            ->select('tbl_grupos.*')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('tbl_prestamos')
                        ->whereRaw('tbl_prestamos.id_grupo = tbl_grupos.id_grupo');
            })
            ->where('tbl_grupos.IdZona','=',$idzona)
            ->distinct()
            ->orderby('tbl_grupos.grupo','asc')
            ->get();
        
        return view('admin.zona.corte_por_zona_semanas',['region'=>$region,'zona'=>$zona,'grupos'=>$grupos,'f_actual'=>$f_actual,'semanas'=>$semanas]);
        
    }

    public function excluir_grupos(Request $request){
        // dd('Estamos trabajando en las actualizaciones');

        if (empty($request->id_gerente)) {
            $id_gerente=0;
        } else {
            $id_gerente=$request->id_gerente;
        }
        

        $excluir_grupos=DB::table('tbl_grupos_gerentes_excluir')
        ->join('tbl_usuarios','tbl_grupos_gerentes_excluir.id_gerente','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->join('tbl_grupos','tbl_grupos_gerentes_excluir.id_grupo','tbl_grupos.id_grupo')
        ->select('tbl_grupos_gerentes_excluir.id_grupo_gerente_excluir','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_grupos.grupo')
        ->where('tbl_usuarios.id_tipo_usuario','=',2)
        ->get();

        $gerenteszona=DB::table('tbl_usuarios')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_usuarios.email','tbl_usuarios.id','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
        ->where('tbl_usuarios.id_tipo_usuario','=',2)
        ->orderby('tbl_datos_usuario.nombre','ASC')
        ->get();

        $zonas=DB::table('tbl_zonas_gerentes')
        ->join('tbl_zona','tbl_zonas_gerentes.id_zona','tbl_zona.IdZona')
        ->select('tbl_zona.*')
        ->where('tbl_zonas_gerentes.id_usuario','=',$id_gerente)
        ->orderBy('tbl_zona.Zona','ASC')
        ->get();
        
        
    
        return view('admin.grupos.excluir_grupos',['id_gerente'=>$id_gerente,'zonas'=>$zonas,'excluir_grupos'=>$excluir_grupos,'gerenteszona'=>$gerenteszona]);
    }

    public function guardar_grupos_excluidos(Request $request){
        // dd($request->all());
        $input =$request->all();

        if (empty($request->id_grupo)) {
            return back()->with('error', '¡No seleccionó grupos para excluir!');
        } else {

            foreach ($input["id_grupo"] as $key => $value) {
        
                $id_grupo=$value;
                $id_gerente_zona=$request->id_gerente_zona;

                $fecha_hoy=Carbon::now();

                $id_grupo_excluido = DB::table('tbl_grupos_gerentes_excluir')->insertGetId(
                    ['id_gerente' => $id_gerente_zona, 'id_grupo' => $id_grupo]
                );

                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 2,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 33,
                    'id_movimiento' =>  $id_grupo,
                    'descripcion' => "Grupo excluido del gerente de zona #".$id_gerente_zona,
                    'fecha_registro' => $fecha_hoy
                ]);

            }
            return back()->with('status', '¡Grupos excluidos con éxito!');
        }
    }

    public function guardar_grupos_inluir(Request $request){
        // dd($request->all());
        DB::table('tbl_grupos_gerentes_excluir')
        ->where('id_gerente', '=', $request->id_gerente)
        ->where('id_grupo','=',$request->id_grupo)
        ->delete();

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 34,
            'id_movimiento' =>  $request->id_grupo,
            'descripcion' => "Grupo incluido al gerente de zona #".$request->id_gerente,
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Grupo incluido con éxito!');
    }
}
