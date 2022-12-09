<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ReferenciaPersonalExport;
use App\ReferenciaPersonal;
use App\ReferenciaPersonalPersonas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReferenciaPersonalController extends Controller
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
        $referenciapersonal = DB::table('tbl_se_referencia_personal')
            ->Join('tbl_socio_economico', 'tbl_se_referencia_personal.id_socio_economico', '=', 'tbl_socio_economico.id_socio_economico')
            ->select('tbl_se_referencia_personal.*', 'tbl_socio_economico.id_socio_economico')
            ->get();
        return view('admin.referenciapersonal.index',compact('referenciapersonal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.referenciapersonal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = new ReferenciaPersonal;
        $datos->id_socio_economico = $request->id_socio_economico;
        $datos->save();

        $idRL = ReferenciaPersonal::latest('id_referencia_personal')->first();

        $rlp = new ReferenciaPersonalPersonas;
            $rlp->id_referencia_personal = $idRL->id_referencia_personal;
            $rlp->relacion             = $request->relacion;
            $rlp->nombre        = $request->nombre;
            $rlp->calle_numero     = $request->calle_numero;
            $rlp->colonia     = $request->colonia;
            $rlp->municipio_ciudad     = $request->municipio_ciudad;
            $rlp->estado     = $request->estado;
            $rlp->celular         = $request->celular;
            $rlp->otro         = $request->otro;
            $rlp->save();

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 27,
            'id_movimiento' =>  $idRL->id_referencia_personal,
            'descripcion' => "Se registró datos referencia personal",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '!Datos de la referencia personal guardado con éxito¡');
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
        return view('admin.referenciapersonal.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $referenciapersonal=ReferenciaPersonal::findOrFail($id);
        return view('admin/referenciapersonal/edit', compact('referenciapersonal'));
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
        ReferenciaPersonal::where('id_referencia_personal','=',$id)->update($datosAc);

        return redirect()->route('referenciapersonal.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ReferenciaPersonal::destroy($id);
        return redirect()->route('referenciapersonal.index');
    }
    public function export(){
        return Excel::download(new ReferenciaPersonalExport, 'Referencia_personal.xlsx');
    }
}
