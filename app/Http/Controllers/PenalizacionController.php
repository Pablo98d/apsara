<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Penalizacion;

class PenalizacionController extends Controller
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
        $penalizacion = DB::table('tbl_penalizacion')
            ->Join('tbl_prestamos', 'tbl_penalizacion.id_prestamo', '=', 'tbl_prestamos.id_prestamo')
            ->Join('tbl_usuarios', 'tbl_prestamos.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
            ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
            ->select('tbl_penalizacion.id_penalizacion','tbl_abonos.id_abono','tbl_prestamos.id_prestamo','tbl_tipoabono.tipoAbono','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
            ->take(1500)
            
            ->orderBy('tbl_abonos.id_abono','DESC')
            ->get();
        return view('admin.penalizacion.index',compact('penalizacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.penalizacion.create');
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
            'id_prestamo' => 'required',
        ]);
        Penalizacion::create($request->all());
        return redirect()->route('penalizacion.index')->with('Guardar','Registro Guardado con Exito !!!');
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
        $penalizacion=Penalizacion::findOrFail($id);
        return view('admin/penalizacion/edit', compact('penalizacion'));
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
        Penalizacion::where('id_penalizacion','=',$id)->update($datosAc);

        return redirect()->route('penalizacion.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penalizacion::destroy($id);
        return redirect()->route('penalizacion.index');
    }
}
