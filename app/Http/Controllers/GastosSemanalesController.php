<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\GastosSemanalesExport;
use App\GastosSemanales;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GastosSemanalesController extends Controller
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
        $gastossemanales=GastosSemanales::all();
        return view('admin.gastossemanales.index',compact('gastossemanales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gastossemanales=GastosSemanales::all();
        return view('admin.gastossemanales.create',compact('gastossemanales'));
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
            'alimentos' => 'required',
            'transporte_publico' => 'required',
            'gasolina' => 'required',
            'educacion' => 'required',
            'diversion' => 'required',
            'medicamentos' => 'required',
            'deportes' => 'required',
        ]);

        $gastossemanales = GastosSemanales::create($request->all());
        $idGS = GastosSemanales::latest('id_gasto_semanal')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 25,
            'id_movimiento' =>  $idGS->id_gasto_semanal,
            'descripcion' => "Se registró datos gastos semanales",
            'fecha_registro' => $fecha_hoy
        ]);
        
        return back()->with('status', '¡Datos del gasto semanal, guardado con éxito!');
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
        return view('admin.gastossemanales.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gastossemanales=GastosSemanales::findOrFail($id);
        return view('admin/gastossemanales/edit', compact('gastossemanales'));
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
        $gastossemanales=request()->except(['_token','_method']);
        GastosSemanales::where('id_gasto_semanal','=',$id)->update($gastossemanales);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 25,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos gastos semanales",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Datos del gasto semanal, actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gastossemanales=GastosSemanales::findOrFail($id);
        $gastossemanales->delete();
        return redirect()->route('gastossemanales.index');
    }
    public function export(){
        return Excel::download(new GastosSemanalesExport, 'Gastos_semanales.xlsx');
    }
}
