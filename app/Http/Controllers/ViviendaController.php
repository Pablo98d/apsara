<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ViviendaExport;
use App\Vivienda;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ViviendaController extends Controller
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
        $vivienda=Vivienda::all();
        return view('admin.vivienda.index',compact('vivienda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vivienda.create');
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
            'tipo_vivienda' => 'required',
            'tiempo_viviendo_domicilio' => 'required',
            'telefono_casa' => 'required',
            'telefono_celular' => 'required'
        ]);
        Vivienda::create($request->all());
        $idV = Vivienda::latest('id_vivienda')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 18,
            'id_movimiento' =>  $idV->id_vivienda,
            'descripcion' => "Se registró datos vivienda",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Datos de la vivienda guardados con éxito!');
        //return view('admin.vivienda.create',['soci'=>$soci,'idSocio'=>$id]);
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
        return view('admin.vivienda.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vivienda=Vivienda::findOrFail($id);
        return view('admin/vivienda/edit', compact('vivienda'));
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
        Vivienda::where('id_vivienda','=',$id)->update($datosAc);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 18,
            'id_movimiento' => $id,
            'descripcion' => "Se actualizó datos vivienda",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de la vivienda actualizados con éxito!');
        //return redirect()->route('vivienda.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Vivienda::destroy($id);
        return redirect()->route('vivienda.index');
    }
    public function export(){
        return Excel::download(new ViviendaExport, 'Vivienda.xlsx');
    }
}
