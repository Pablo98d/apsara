<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoUsuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TipoUsuarioController extends Controller
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
        $tipousuario=TipoUsuario::all();
        return view('admin.tipousuarios.index',compact('tipousuario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tipousuarios.create');
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
            'nombre' => 'required',
        ]);
        TipoUsuario::create($request->all());
        return redirect()->route('tipousuarios.index')->with('Guardar','Registro Guardado con Exito !!!');
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
        $tipoU=TipoUsuario::findOrFail($id);
        return view('admin/tipousuarios/edit', compact('tipoU'));
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
        TipoUsuario::where('id_tipo_usuario','=',$id)->update($datosAc);

        return redirect()->route('tipousuarios.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TipoUsuario::destroy($id);
        return redirect()->route('tipousuarios.index');
    }

    public function actualizar_nombre(Request $request){

        // dd($request->all());
        $datosAc=request()->except(['_token','_method']);
        TipoUsuario::where('id_tipo_usuario','=',$request->id_tipo_usuario)->update($datosAc);

        $fecha_pago = $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 36,
            'id_movimiento' =>$request->id_tipo_usuario,
            'descripcion' => "Se actulizó nombre tipo de usuario",
            'fecha_registro' => $fecha_pago
        ]);


        return back()->with('status', '¡Nombre tipo usuario actualizado con éxito!');

    }
}
