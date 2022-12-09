<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ReferenciaPersonalPersonasExport;
use App\ReferenciaPersonalPersonas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReferenciaPersonalPersonasController extends Controller
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
        $referenciappersonas=ReferenciaPersonalPersonas::all();
        return view('admin.referenciappersonas.index',compact('referenciappersonas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.referenciappersonas.create');
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
            'id_referencia_personal' => 'required',
            'nombre' => 'required',
            'domicilio' => 'required',
            'telefono' => 'required',
            'relacion' => 'required'
        ]);
        ReferenciaPersonalPersonas::create($request->all());
        return redirect()->route('referenciappersonas.index')->with('Guardar','Registro Guardado con Exito !!!');
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
        $referenciappersonas=ReferenciaPersonalPersonas::findOrFail($id);
        return view('admin/referenciappersonas/edit', compact('referenciappersonas'));
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
        ReferenciaPersonalPersonas::where('id_rp_persona','=',$id)->update($datosAc);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 27,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos referencia personal",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '!Datos de la referencia personal actualizado con éxito¡');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ReferenciaPersonalPersonas::destroy($id);
        return redirect()->route('referenciappersonas.index');
    }
    public function export(){
        return Excel::download(new ReferenciaPersonalPersonasExport, 'Referencia_personal_personas.xlsx');
    }
}
