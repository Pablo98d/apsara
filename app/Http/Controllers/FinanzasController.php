<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\FinanzasExport;
use App\Finanzas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FinanzasController extends Controller
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
        $finanzas=Finanzas::all();
        return view('admin.finanzas.index',compact('finanzas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.finanzas.create');
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
            'id_socio_economico' => 'required',
            'deuda_tarjeta_credito' => 'required',
            'deuda_otras_finanzas' => 'required',
            'pension_hijos' => 'required',
            'ingresos_mensuales' => 'required',
            'buro_credito' => 'required'
        ]);
        Finanzas::create($request->all());
        $idFin = Finanzas::latest('id_finanza')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 22,
            'id_movimiento' =>  $idFin->id_finanza,
            'descripcion' => "Se registró datos finanzas",
            'fecha_registro' => $fecha_hoy
        ]);


        return back()->with('status', '¡Datos de finanzas, guardado con éxito!');
        //return view('admin.finanzas.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $soci=DB::table('tbl_socio_economico')
                ->join('tbl_usuarios','tbl_socio_economico.id_usuario','=','tbl_usuarios.id')
                ->select('tbl_socio_economico.*','tbl_usuarios.nombre_usuario')
                ->get();
        return view('admin.finanzas.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finanzas=Finanzas::findOrFail($id);
        return view('admin/finanzas/edit', compact('finanzas'));
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
        Finanzas::where('id_finanza','=',$id)->update($datosAc);

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 22,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos finanzas",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de finanzas, actualizado con éxito!');
        //return redirect()->route('finanzas.index')->with('Guardar','Registro Actualizado con Exito !!!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Finanzas::destroy($id);
        return redirect()->route('finanzas.index');
    }
    public function export(){
        return Excel::download(new FinanzasExport, 'Finanzas.xlsx');
    }
}
