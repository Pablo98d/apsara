<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\FamiliaresExport;
use App\Familiares;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class FamiliaresController extends Controller
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
        $familiares=Familiares::all();
        return view('admin.familiares.index',compact('familiares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.familiares.create');
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
            'numero_personas' => 'required',
            'numero_personas_trabajando' => 'required',
            'aportan_dinero_mensual' => 'required',
        ]);
        Familiares::create($request->all());
        $idF = Familiares::latest('id_familiar')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 16,
            'id_movimiento' =>  $idF->id_familiar,
            'descripcion' => "Se registró datos familiar S.E",
            'fecha_registro' => $fecha_hoy
        ]);

        
        return back()->with('status', '¡Datos de familar guardados con éxito!');
        //return view('admin.familiares.create',['soci'=>$soci,'idSocio'=>$id]);
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
        return view('admin.familiares.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $familiares=Familiares::findOrFail($id);
        return view('admin/familiares/edit', compact('familiares'));
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
        Familiares::where('id_familiar','=',$id)->update($datosAc);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 16,
            'id_movimiento' => $id,
            'descripcion' => "Se actualizó datos familiar S.E",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Datos del familiar actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Familiares::destroy($id);
        return redirect()->route('familiares.index');
    }
    public function export(){
        return Excel::download(new FamiliaresExport, 'Familiares.xlsx');
    }
}
