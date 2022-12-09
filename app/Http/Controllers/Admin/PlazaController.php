<?php

namespace App\Http\Controllers\admin;

use App\Plaza;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PlazaController extends Controller
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
        
        $plaza = DB::table('tbl_plaza')
            ->select('tbl_plaza.*')
            ->orderBy('Plaza','ASC')
            ->get();

       return view('admin.plaza.index',['plazas'=>$plaza]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plaza.nuevaplaza');
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
            //'IdPlaza' => 'required',
            'Plaza' => 'required',
            'Fecha_apertura' => 'required',
        ]);
        Plaza::create($request->all());

        $idP = Plaza::latest('IdPlaza')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 13,
            'id_movimiento' =>  $idP->IdPlaza,
            'descripcion' => "Se regitró una nueva región",
            'fecha_registro' => $fecha_hoy
        ]);

        return redirect()->route('admin-region.index')->with('Guardar','Registro guardado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdPlaza)
    {
        $plaza=Plaza::find($IdPlaza);
        return view('admin.plaza.showplaza',['plaza'=>$plaza]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdPlaza)
    {
       
        $plaza=Plaza::find($IdPlaza);
        return view('admin.plaza.editarplaza',['plaza'=>$plaza]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdPlaza)
    {
        $datosAc=request()->except(['_token','_method']);
        Plaza::where('IdPlaza','=',$IdPlaza)->update($datosAc);

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 13,
            'id_movimiento' =>  $IdPlaza,
            'descripcion' => "Se actualizó una región",
            'fecha_registro' => $fecha_hoy
        ]);

        return redirect()->route('admin-region.index')->with('Guardar','Registro actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdPlaza)
    {
        Plaza::destroy($IdPlaza);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 13,
            'id_movimiento' =>  $IdPlaza,
            'descripcion' => "Se eliminó una región",
            'fecha_registro' => $fecha_hoy
        ]);
        return redirect()->route('admin-region.index')->with('Guardar','Registro eliminado con éxito');
    }
}
