<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\GastosMensualesExport;
use App\GastosMensuales;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GastosMensualesController extends Controller
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
        $gastosmensuales=GastosMensuales::all();
        return view('admin.gastosmensuales.index',compact('gastosmensuales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gastosmensuales=GastosMensuales::all();
        return view('admin.gastosmensuales.create',compact('gastosmensuales'));
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
            'renta_hipoteca' => 'required',
            'telefono_fijo' => 'required',
            'internet' => 'required',
            'telefono_movil' => 'required',
            'cable' => 'required',
            'luz' => 'required',
            'gas' => 'required',
        ]);

        $gastosmensuales = GastosMensuales::create($request->all());
        
        $idGM = GastosMensuales::latest('id_gasto_mensual')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 24,
            'id_movimiento' =>  $idGM->id_gasto_mensual,
            'descripcion' => "Se registró datos gastos mensuales",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos del gasto mensual, guardado con éxito!');
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
        return view('admin.gastosmensuales.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gastosmensuales=GastosMensuales::findOrFail($id);
        return view('admin/gastosmensuales/edit', compact('gastosmensuales'));
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
        $gastosmensuales=request()->except(['_token','_method']);
        GastosMensuales::where('id_gasto_mensual','=',$id)->update($gastosmensuales);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 24,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos gastos mensuales",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos del gasto mensual, actualizado con éxito!');
        // return redirect()->route('gastosmensuales.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gastosmensuales=GastosMensuales::findOrFail($id);
        $gastosmensuales->delete();
        return redirect()->route('gastosmensuales.index');
    }
    public function export(){
        return Excel::download(new GastosMensualesExport, 'Gastos_mensuales.xlsx');
    }
}
