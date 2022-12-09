<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoVisita;

class TipoVisitaController extends Controller
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
        $tipovisita=TipoVisita::all();
        return view('admin.tipovisita.index',compact('tipovisita'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tipovisita.create');
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
            'tipo_visita' => 'required',
        ]);
        TipoVisita::create($request->all());
        return redirect()->route('tipovisita.index')->with('Guardar','Registro Guardado con Exito !!!');
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
        $tipovisita=TipoVisita::findOrFail($id);
        return view('admin/tipovisita/edit', compact('tipovisita'));
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
        TipoVisita::where('id_tipo_visita','=',$id)->update($datosAc);

        return redirect()->route('tipovisita.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TipoVisita::destroy($id);
        return redirect()->route('tipovisita.index');
    }
}
