<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DetalleRuta;
use App\Rutas;
use App\TipoVisita;

class DetalleRutaController extends Controller
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
        $detalleruta = DB::table('tbl_detalle_ruta')
            ->Join('tbl_rutas', 'tbl_detalle_ruta.id_ruta', '=', 'tbl_rutas.id_ruta')
            ->Join('tbl_tipo_visita', 'tbl_detalle_ruta.id_tipo_visita', '=', 'tbl_tipo_visita.id_tipo_visita')
            ->select('tbl_detalle_ruta.*', 'tbl_rutas.observaciones','tbl_tipo_visita.tipo_visita')
            ->get();
        return view('admin.detalleruta.index',compact('detalleruta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rutaO=Rutas::all();
        $tipV=TipoVisita::all();
        return view('admin.detalleruta.create',compact('rutaO','tipV'));
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
            'id_ruta' => 'required',
            'id_tipo_visita' => 'required',
            'prioridad' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'observaciones' => 'required',
            'tiempo_estimado' => 'required'
        ]);
        DetalleRuta::create($request->all());
        return redirect()->route('detalleruta.index')->with('Guardar','Registro Guardado con Exito !!!');
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
        $rutaN=Rutas::all();
        $tipoV=TipoVisita::all();
        $detalleruta=DetalleRuta::findOrFail($id);
        return view('admin/detalleruta/edit', compact('detalleruta','rutaN','tipoV'));
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
        DetalleRuta::where('id_detalle_ruta','=',$id)->update($datosAc);

        return redirect()->route('detalleruta.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DetalleRuta::destroy($id);
        return redirect()->route('detalleruta.index');
    }
}
