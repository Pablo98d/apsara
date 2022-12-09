<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ParejaExport;
use App\Pareja;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ParejaController extends Controller
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
        $pareja=Pareja::all();
        return view('admin.pareja.index',compact('pareja'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pareja=Pareja::all();
        return view('admin.pareja.create',compact('pareja'));
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
            'nombre' => 'required',
            'ap_paterno' => 'required',
            'ap_materno' => 'required',
            'telefono' => 'required',
            'edad' => 'required',
            'ocupacion' => 'required',
        ]);

        $pareja = Pareja::create($request->all());
      
        $idPar = Pareja::latest('id_pareja')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 19,
            'id_movimiento' =>  $idPar->id_pareja,
            'descripcion' => "Se registró datos pareja",
            'fecha_registro' => $fecha_hoy
        ]);


        return back()->with('status', '¡Datos de la pareja, guardada con éxito!');
        //return view('admin.pareja.create',['soci'=>$soci,'idSocio'=>$id]);
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
        return view('admin.pareja.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pareja=Pareja::findOrFail($id);
        return view('admin/pareja/edit', compact('pareja'));
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
        
        $pareja=request()->except(['_token','_method']);
        Pareja::where('id_pareja','=',$id)->update($pareja);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 19,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos pareja",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de la pareja, actualizado con éxito!');
        //return redirect()->route('pareja.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pareja=Pareja::findOrFail($id);
        $pareja->delete();
        return redirect()->route('pareja.index');
    }
    public function export(){
        return Excel::download(new ParejaExport, 'Pareja.xlsx');
    }
}
