<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ReferenciaLaboralExport;
use App\ReferenciaLaboral;
use App\ReferenciaLaboralPersonas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReferenciaLaboralController extends Controller
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
        $referencialaboral = DB::table('tbl_se_referencia_laboral')
            ->Join('tbl_socio_economico', 'tbl_se_referencia_laboral.id_socio_economico', '=', 'tbl_socio_economico.id_socio_economico')
            ->select('tbl_se_referencia_laboral.*', 'tbl_socio_economico.id_socio_economico')
            ->get();
        return view('admin.referencialaboral.index',compact('referencialaboral'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.referencialaboral.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = new ReferenciaLaboral;
        $datos->id_socio_economico = $request->id_socio_economico;
        $datos->save();

        $idRL = ReferenciaLaboral::latest('id_referencia_laboral')->first();

        $rlp = new ReferenciaLaboralPersonas;
            $rlp->id_referencia_laboral = $idRL->id_referencia_laboral;
            $rlp->nombre_empresa        = $request->nombre_empresa;
            $rlp->actividad_empresa     = $request->actividad_empresa;
            $rlp->cargo_empresa         = $request->cargo_empresa;
            $rlp->direccion             = $request->direccion;
            $rlp->numero_ext            = $request->numero_ext;
            $rlp->numero_int            = $request->numero_int;
            $rlp->entre_calles          = $request->entre_calles;
            $rlp->telefono_empresa      = $request->telefono_empresa;
            $rlp->tiempo_empresa        = $request->tiempo_empresa;
        $rlp->save();

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 26,
            'id_movimiento' =>  $idRL->id_referencia_laboral,
            'descripcion' => "Se registró datos referencia laboral",
            'fecha_registro' => $fecha_hoy
        ]);
        
        return back()->with('status', '!Datos de la referencia laboral guardado con éxito¡');
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
        return view('admin.referencialaboral.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $referencialaboral=ReferenciaLaboral::findOrFail($id);
        return view('admin/referencialaboral/edit', compact('referencialaboral'));
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
        // $f='referenci laboral';
        // dd($f);
        // $datosAc=request()->except(['_token','_method']);
        // ReferenciaLaboral::where('id_referencia_personal','=',$id)->update($datosAc);

        // return redirect()->route('referencialaboral.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ReferenciaLaboral::destroy($id);
        return redirect()->route('referencialaboral.index');
    }
    public function export(){
        return Excel::download(new ReferenciaLaboralExport, 'Referencia_laboral.xlsx');
    }
}
