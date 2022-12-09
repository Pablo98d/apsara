<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ReferenciaLaboralPersonasExport;
use App\ReferenciaLaboralPersonas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReferenciaLaboralPersonasController extends Controller
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
        $referencialbpersonas=ReferenciaLaboralPersonas::all();
        return view('admin.referencialbpersonas.index',compact('referencialbpersonas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $referencialbpersonas=ReferenciaLaboralPersonas::all();
        return view('admin.referencialbpersonas.create',compact('referencialbpersonas'));
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
            'id_referencia_laboral' => 'required',
            'nombre_empresa' => 'required',
            'actividad_empresa' => 'required',
            'cargo_empresa' => 'required',
            'direccion' => 'required',
            'numero_ext' => 'required',
            'numero_int' => 'required',
            'entre_calles' => 'required',
            'telefono_empresa' => 'required',
            'tiempo_empresa' => 'required',
            'jefe_inmediato' => 'required'
        ]);

        $referencialbpersonas = ReferenciaLaboralPersonas::create($request->all());
        
        return redirect()->route('referencialbpersonas.index')->with('Guardar','Registro Guardado con Exito !!!');
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
        $referencialbpersonas=ReferenciaLaboralPersonas::findOrFail($id);
        return view('admin/referencialbpersonas/edit', compact('referencialbpersonas'));
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
        $referencialbpersonas=request()->except(['_token','_method']);
        ReferenciaLaboralPersonas::where('id_rl_persona','=',$id)->update($referencialbpersonas);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 26,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos referencia laboral",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '!Datos de la referencia laboral actualizado con éxito¡');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $referencialbpersonas=ReferenciaLaboralPersonas::findOrFail($id);
        $referencialbpersonas->delete();
        return redirect()->route('referencialbpersonas.index');
    }
    public function export(){
        return Excel::download(new ReferenciaLaboralPersonasExport, 'Referencia_laboral_personas.xlsx');
    }
}
