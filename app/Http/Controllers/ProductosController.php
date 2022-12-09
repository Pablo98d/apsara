<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Productos;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
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
        $productos=Productos::all();
        return view('admin.productos.index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos=Productos::all();
        return view('admin.productos.create',compact('productos'));
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
            'producto' => 'required',
            'rango_inicial' => 'required',
            'rango_final' => 'required',
            'semanas' => 'required',
            'papeleria' => 'required',
            'comision_promotora' => 'required',
            'comision_cobro_perfecto' => 'required',
            'penalizacion' => 'required',
            'pago_semanal' => 'required',
            'reditos'=>'required',
            'ultima_semana'=>'required'
        ]);

        $productos = Productos::create($request->all());

        $idP = Productos::latest('id_producto')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 30,
            'id_movimiento' =>  $idP->id_producto,
            'descripcion' => "Se registró un nuevo producto",
            'fecha_registro' => $fecha_hoy
        ]);
        
        return redirect()->route('productos.index')->with('Guardar','¡Registro guardado con éxito !');
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
        $productos=Productos::findOrFail($id);
        return view('admin/productos/edit', compact('productos'));
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
        $productos=request()->except(['_token','_method']);
        Productos::where('id_producto','=',$id)->update($productos);

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 30,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó un producto",
            'fecha_registro' => $fecha_hoy
        ]);

        return redirect()->route('productos.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productos=Productos::findOrFail($id);
        $productos->delete();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 30,
            'id_movimiento' =>  $id,
            'descripcion' => "Se eliminó un producto",
            'fecha_registro' => $fecha_hoy
        ]);
        return redirect()->route('productos.index');
    }
    public function buscar_producto(Request $request){
        $producto=Productos::where('id_producto',$request->id_producto)->get();
        return $producto;
    }
}
