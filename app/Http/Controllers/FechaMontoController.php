<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\FechaMontoExport;
use App\FechaMonto;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FechaMontoController extends Controller
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
        $fechamonto=FechaMonto::all();
        return view('admin.fechamonto.index',compact('fechamonto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fechamonto.create');
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
            'fecha_credito' => 'required',
            'monto_credito' => 'required',
        ]);
        FechaMonto::create($request->all());
        $idFecha = FechaMonto::latest('id_referencia')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 23,
            'id_movimiento' =>  $idFecha->id_referencia,
            'descripcion' => "Se registró datos fecha monto",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de la fecha monto, guardado con éxito!');
        //return view('admin.fechamonto.create',['soci'=>$soci,'idSocio'=>$id]);
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
        return view('admin.fechamonto.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fechamonto=FechaMonto::findOrFail($id);
        return view('admin/fechamonto/edit', compact('fechamonto'));
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
        FechaMonto::where('id_referencia','=',$id)->update($datosAc);

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 23,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos fecha monto",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de la fecha monto, actualizado con éxito!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FechaMonto::destroy($id);
        return redirect()->route('fechamonto.index');
    }
    public function export(){
        return Excel::download(new FechaMontoExport, 'Fecha_de_monto.xlsx');
    }
}
