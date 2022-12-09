<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\DomicilioExport;
use App\Domicilio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DomicilioController extends Controller
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
        $domicilio=Domicilio::all();
        return view('admin.domicilio.index',compact('domicilio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $domicilio=Domicilio::all();
        return view('admin.domicilio.create',compact('domicilio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'id_socio_economico' => 'required',
            'calle' => 'required',
            'numero_ext' => 'required',
            'numero_int' => 'required',
            'colonia_localidad' => 'required',
            'municipio' => 'required',
            'estado' => 'required',
            'c_p' => 'required',
            'pais' => 'required'
            
        ]);

        $domicilio = Domicilio::create($request->all());
        

        $idDom = Domicilio::latest('id_domicilio')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 20,
            'id_movimiento' =>  $idDom->id_domicilio,
            'descripcion' => "Se registró datos domicilio",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos del domicilio guardado con éxito!');
        //return view('admin.domicilio.create',['soci'=>$soci,'idSocio'=>$id]);
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
        return view('admin.domicilio.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $domicilio=Domicilio::findOrFail($id);
        return view('admin/domicilio/edit', compact('domicilio'));
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
        $domicilio=request()->except(['_token','_method']);
        Domicilio::where('id_domicilio','=',$id)->update($domicilio);

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 20,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos domicilio",
            'fecha_registro' => $fecha_hoy
        ]);


        return back()->with('status', '¡Datos del domicilio actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $domicilio=Domicilio::findOrFail($id);
        $domicilio->delete();
        return redirect()->route('domicilio.index');
    }
    public function export(){
        return Excel::download(new DomicilioExport, 'Domicilio.xlsx');
    }
}
