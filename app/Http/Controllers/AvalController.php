<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\AvalExport;
use App\Aval;
use App\Se_Aval;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AvalController extends Controller
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
        $aval=Aval::all();
        return view('admin.aval.index',compact('aval'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.aval.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existencia = DB::table('tbl_avales')
        ->select('tbl_avales.*')
        ->where('curp','=',$request->curp)
        ->get();

        $fechanacimiento=$request->fecha_nacimiento;
        $edad = Carbon::parse($fechanacimiento)->age;

        if (empty($existencia[0]->curp)) {
            $aval = Aval::create([
                'curp'=>$request->curp,
                'nombre' => $request->nombre,
                'ap_paterno' => $request->ap_paterno,
                'ap_materno' => $request->ap_materno,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'edad'=>$edad,
                'ocupacion' => $request->ocupacion,
                'genero' => $request->genero,
                'estado_civil' => $request->estado_civil,
                'calle' => $request->calle,
                'numero_ext' => $request->numero_ext,
                'numero_int' => $request->numero_int,
                'entre_calles' => $request->entre_calles,
                'colonia' => $request->colonia,
                'municipio' => $request->municipio,
                'estado' => $request->estado,
                'referencia_visual' => $request->referencia_visual,
                'vivienda' => $request->vivienda,
                'tiempo_viviendo_domicilio' => $request->tiempo_viviendo_domicilio,
                'telefono_casa' => $request->telefono_casa,
                'telefono_movil' => $request->telefono_movil,
                'telefono_trabajo' => $request->telefono_trabajo,
                'estatus_aval'=>'0',
            ])->save();

            $idA = Aval::latest('id_aval')->first();
            $fecha_hoy=Carbon::now();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 1,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 17,
                'id_movimiento' =>  $idA->id_aval,
                'descripcion' => "Se registró un nuevo aval",
                'fecha_registro' => $fecha_hoy
            ]);

            return back()->with('status', 'Aval agregado con éxito!, Ahora regístralo como su aval en -> aval -> Seleccione su aval -> Registrar mi aval');

        } else {
            
            return back()->with('danger', '!El aval ya está registrado en el sistema, registre otro aval¡');
        }
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
        return view('admin.aval.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aval=Aval::findOrFail($id);
        return view('admin/aval/edit', compact('aval'));
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
        
        $fechanacimiento=$request->fecha_nacimiento;
        $fn = str_split($fechanacimiento);
        $dian=$fn[0].$fn[1];
        $mesn=$fn[3].$fn[4];
        $añon=$fn[6].$fn[7].$fn[8].$fn[9];
        $fecha_nacimiento = $dian.'-'.$mesn.'-'.$añon;

        $fecharegistro=$request->fecha_registro;
        $fr = str_split($fecharegistro);
        $dias=$fr[0].$fr[1];
        $mess=$fr[3].$fr[4];
        $años=$fr[6].$fr[7].$fr[8].$fr[9];
        $hs=$fr[11].$fr[12];
        $ms=$fr[14].$fr[15];
        $fecha_registro = $años.'-'.$mess.'-'.$dias.' '.$hs.':'.$ms.':00';


        // dd($request->fecha_nacimiento,$request->fecha_registro,$fecharegistro);

        $datosAc=request()->except(['_token','_method']);
        Aval::where('id_aval','=',$id)->update([
            'curp'=>$request->curp,
            'nombre'=>$request->nombre,
            'ap_paterno'=>$request->ap_paterno,
            'ap_materno'=>$request->ap_materno,
            'fecha_nacimiento'=>$fecha_nacimiento,
            'ocupacion'=>$request->ocupacion,
            'genero'=>$request->genero,
            'estado_civil'=>$request->estado_civil,
            'calle'=>$request->calle,
            'numero_ext'=>$request->numero_ext,
            'numero_int'=>$request->numero_int,
            'entre_calles'=>$request->entre_calles,
            'colonia'=>$request->colonia,
            'municipio'=>$request->municipio,
            'estado'=>$request->estado,
            'referencia_visual'=>$request->referencia_visual,
            'vivienda'=>$request->vivienda,
            'tiempo_viviendo_domicilio'=>$request->tiempo_viviendo_domicilio,
            'telefono_casa'=>$request->telefono_casa,
            'telefono_movil'=>$request->telefono_movil,
            'telefono_trabajo'=>$request->telefono_trabajo,
            'fecha_registro'=>$fecha_registro,
        ]);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 17,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos de aval",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos del aval actualizado con éxito!');
        //return redirect()->route('aval.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Aval::destroy($id);
        return redirect()->route('aval.index');
    }
    public function export(){
        return Excel::download(new AvalExport, 'Aval.xlsx');
    }

    public function relacioncrear(Request $request){
        $id_aval=$request->id_aval;
        $se_aval = Se_Aval::create([
            'id_socio_economico'=>$request->id_socio_economico,
            'id_aval'=>$request->id_aval,
            'relacion_solicitante' => $request->relacion_solicitante,
        ])->save();
        
        Aval::where('id_aval','=',$id_aval)->update([
            'estatus_aval'=>'1',
        ]);
        $idA = Se_Aval::latest('id_sc_aval')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 17,
            'id_movimiento' =>  $idA->id_sc_aval,
            'descripcion' => "Se le asignó aval a un prospecto/cliente",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '!Su aval se registró con éxito¡');
    }
    public function actualizar_aval(Request $request){
        // dd($request->all());
        Se_Aval::where('id_sc_aval','=',$request->id_sc_aval)->update([
            // 'id_socio_economico'=>$request->id_socio_economico,
            'id_aval'=>$request->id_aval,
            'relacion_solicitante' => $request->relacion_solicitante,
        ]);

        Aval::where('id_aval','=',$request->id_aval_actual)->update([
            'estatus_aval'=>'0',
        ]);

        Aval::where('id_aval','=',$request->id_aval)->update([
            'estatus_aval'=>'1',
        ]);

        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 17,
            'id_movimiento' =>  $request->id_sc_aval,
            'descripcion' => "Se le cambió aval a un prospecto/cliente",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '!El cambio del aval se actualizó con éxito¡');

    }
}
