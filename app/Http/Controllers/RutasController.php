<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Rutas;
use App\User;
use App\TipoVisita;
use Carbon\Carbon;
use App\Grupos;
use App\Plaza;
use App\Zona;
use App\RutaZona;
use Illuminate\Support\Facades\Auth;

class RutasController extends Controller
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
        $rutas = DB::table('tbl_rutas')
            ->Join('tbl_usuarios as tbl1', 'tbl_rutas.id_usuario', '=', 'tbl1.id')
            ->Join('tbl_usuarios as tbl2', 'tbl_rutas.id_gerente', '=', 'tbl2.id')
            ->select('tbl_rutas.*', 'tbl1.nombre_usuario as usuario','tbl2.nombre_usuario as gerente')
            ->get();
        return view('admin.rutas.index',compact('rutas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('nombre_usuario', 'asc')->get();
        $users2 = User::select('nombre_usuario')->where('id_tipo_usuario','=','2')
        ->orderBy('nombre_usuario', 'asc')
        ->get();
        $now = Carbon::now();
        $tipV=TipoVisita::all();
        return view('admin.rutas.create',compact(['users','users2','now','tipV']));

//orderBy('nombre_usuario', 'asc')->get();
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
            'id_usuario' => 'required',
            'fecha' => 'required',
            'observaciones' => 'required'
        ]);
        Rutas::create($request->all());
        return redirect()->route('rutas.index')->with('Guardar','Registro Guardado con Exito !!!');
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
        $usuario=User::all();
        $gerente=User::all();
        $rutas=Rutas::findOrFail($id);
        return view('admin/rutas/edit', compact('rutas','usuario','gerente'));
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
        Rutas::where('id_ruta','=',$id)->update($datosAc);

        return redirect()->route('rutas.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd('ya estamos aqui en la nueva pestaña');
        Rutas::destroy($id);
        return redirect()->route('rutas.index');
    }

    public function visitas_zona(Request $request){
        $id_gerente=$request->id_gerente;
        $id_grupo=$request->id_grupo;
    
        $allgerentes=DB::table('tbl_usuarios')
        ->join('tbl_zonas_gerentes','tbl_usuarios.id','tbl_zonas_gerentes.id_usuario')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_usuarios.*','tbl_datos_usuario.*')
        ->distinct()
        ->orderBy('tbl_datos_usuario.nombre','ASC')
        ->get();

        $grupos=DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->orderBy('grupo','ASC')
        ->get();

        if (empty($id_gerente)) {
            if (empty($id_grupo)) {

                $visitas=DB::table('v_rutas_zonas')
                ->join('tbl_zona','v_rutas_zonas.id_zona','tbl_zona.IdZona')
                ->join('tbl_plaza','tbl_zona.IdPlaza','tbl_plaza.IdPlaza')
                ->join('tbl_grupos','v_rutas_zonas.id_grupo','tbl_grupos.id_grupo')
                ->join('tbl_datos_usuario','v_rutas_zonas.id_gerente_zona','tbl_datos_usuario.id_usuario')
                ->select('v_rutas_zonas.*','tbl_plaza.*','tbl_zona.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_grupos.grupo')
                ->get();
                
                return view('admin.rutas.visitas_zona',['visitas'=>$visitas,'gerenteszonas'=>$allgerentes,'id_gerente'=>$id_gerente,'id_grupo'=>$id_grupo,'grupos'=>$grupos]);
            } else {

                $visitas=DB::table('v_rutas_zonas')
                ->join('tbl_zona','v_rutas_zonas.id_zona','tbl_zona.IdZona')
                ->join('tbl_plaza','tbl_zona.IdPlaza','tbl_plaza.IdPlaza')
                ->join('tbl_grupos','v_rutas_zonas.id_grupo','tbl_grupos.id_grupo')
                ->join('tbl_datos_usuario','v_rutas_zonas.id_gerente_zona','tbl_datos_usuario.id_usuario')
                ->select('v_rutas_zonas.*','tbl_plaza.*','tbl_zona.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_grupos.grupo')
                ->where('v_rutas_zonas.id_grupo','=',$id_grupo)
                ->get();
                
                return view('admin.rutas.visitas_zona',['visitas'=>$visitas,'gerenteszonas'=>$allgerentes,'id_gerente'=>$id_gerente,'id_grupo'=>$id_grupo,'grupos'=>$grupos]);
            }
            
        } else {
            if (empty($id_grupo)) {

                $visitas=DB::table('v_rutas_zonas')
                ->join('tbl_zona','v_rutas_zonas.id_zona','tbl_zona.IdZona')
                ->join('tbl_plaza','tbl_zona.IdPlaza','tbl_plaza.IdPlaza')
                ->join('tbl_grupos','v_rutas_zonas.id_grupo','tbl_grupos.id_grupo')
                ->join('tbl_datos_usuario','v_rutas_zonas.id_gerente_zona','tbl_datos_usuario.id_usuario')
                ->select('v_rutas_zonas.*','tbl_plaza.*','tbl_zona.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_grupos.grupo')
                ->where('v_rutas_zonas.id_gerente_zona','=',$id_gerente)
                ->get();
                return view('admin.rutas.visitas_zona',['visitas'=>$visitas,'gerenteszonas'=>$allgerentes,'id_gerente'=>$id_gerente,'id_grupo'=>$id_grupo,'grupos'=>$grupos]);
            } else {

                $visitas=DB::table('v_rutas_zonas')
                ->join('tbl_zona','v_rutas_zonas.id_zona','tbl_zona.IdZona')
                ->join('tbl_plaza','tbl_zona.IdPlaza','tbl_plaza.IdPlaza')
                ->join('tbl_grupos','v_rutas_zonas.id_grupo','tbl_grupos.id_grupo')
                ->join('tbl_datos_usuario','v_rutas_zonas.id_gerente_zona','tbl_datos_usuario.id_usuario')
                ->select('v_rutas_zonas.*','tbl_plaza.*','tbl_zona.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_grupos.grupo')
                ->where('v_rutas_zonas.id_gerente_zona','=',$id_gerente)
                ->where('v_rutas_zonas.id_grupo','=',$id_grupo)
                ->get();
                return view('admin.rutas.visitas_zona',['visitas'=>$visitas,'gerenteszonas'=>$allgerentes,'id_gerente'=>$id_gerente,'id_grupo'=>$id_grupo,'grupos'=>$grupos]);
            }                
        }
        
        
    }
    public function visitas_filtrado(Request $request,$idregion,$idzona,$idgrupo){
        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);

        if ($idgrupo==0) {
            $idgrupo=$request->id_grupo;
        } else {
            $idgrupo=$idgrupo;
            // dd('no es cero jajaj');
        }

        $grupo= Grupos::find($idgrupo);

        $grupos=DB::table('tbl_grupos')
        ->select('tbl_grupos.*')
        ->where('IdZona','=',$idzona)
        ->get();

        $visitas=DB::table('v_rutas_zonas')
        ->join('tbl_zona','v_rutas_zonas.id_zona','tbl_zona.IdZona')
        ->join('tbl_plaza','tbl_zona.IdPlaza','tbl_plaza.IdPlaza')
        

        ->join('tbl_datos_usuario','v_rutas_zonas.id_gerente_zona','tbl_datos_usuario.id_usuario')
        ->select('v_rutas_zonas.*','tbl_plaza.*','tbl_zona.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
        ->where('v_rutas_zonas.id_zona','=',$idzona)
        ->where('v_rutas_zonas.id_grupo','=',$idgrupo)
        ->get();


        $dias_sin_visita = DB::table('tbl_dias_semana')
        ->select('tbl_dias_semana.*')
        ->whereNotExists(function ($query) use ($idzona,$idgrupo) {
            $query->select(DB::raw(1))
                    ->from('v_rutas_zonas')
                    ->whereRaw('v_rutas_zonas.id_dia = tbl_dias_semana.id_dia')
                    ->where('v_rutas_zonas.id_zona','=',$idzona)
                    ->where('v_rutas_zonas.id_grupo','=',$idgrupo);
        })
        ->get();


        $allgerentes=DB::table('tbl_usuarios')
        ->join('tbl_zonas_gerentes','tbl_usuarios.id','tbl_zonas_gerentes.id_usuario')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_usuarios.*','tbl_datos_usuario.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->distinct()
        ->orderBy('tbl_datos_usuario.nombre','ASC')
        ->get();

        $dias=DB::table('tbl_dias_semana')
        ->select('tbl_dias_semana.*')
        ->get();

        $promotoras=DB::table('tbl_grupos_promotoras')
        ->join('tbl_usuarios','tbl_grupos_promotoras.id_usuario','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')

        ->join('tbl_grupos','tbl_grupos_promotoras.id_grupo','tbl_grupos.id_grupo')
        
        ->select('tbl_usuarios.*','tbl_datos_usuario.*','tbl_grupos_promotoras.id_grupo_promotoras','tbl_grupos.grupo','tbl_grupos.id_grupo')
        ->where('tbl_grupos.id_grupo','=',$idgrupo)
        ->get();

        return view('admin.rutas.visitas_filtrado',['region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'gerenteszonas'=>$allgerentes,'visitas'=>$visitas,'promotoras'=>$promotoras,'dias'=>$dias,'dias_sin_visita'=>$dias_sin_visita,'grupos'=>$grupos]);
    }
    public function nueva_visita(Request $request){

        $this->validate($request,[
            'id_dia' => 'required',
            'id_gerente_zona' => 'required',
            'id_grupo_promotora' => 'required'
        ]);
        RutaZona::create($request->all());

        $idRZ = RutaZona::latest('id_ruta_zona')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 31,
            'id_movimiento' =>  $idRZ->id_ruta_zona,
            'descripcion' => "Se registró una nueva visita de zona",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Visita guardado con éxito!');
    }

    public function edit_visita($idv,$idregion,$idzona,$idgrupo){

        $visita=RutaZona::find($idv);

        $region=Plaza::find($idregion);
        $zona = Zona::find($idzona);
        $grupo= Grupos::find($idgrupo);

        $dias=DB::table('tbl_dias_semana')
        ->select('tbl_dias_semana.*')
        ->get();

        $allgerentes=DB::table('tbl_usuarios')
        ->join('tbl_zonas_gerentes','tbl_usuarios.id','tbl_zonas_gerentes.id_usuario')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_usuarios.*','tbl_datos_usuario.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->distinct()
        ->orderBy('tbl_datos_usuario.nombre','ASC')
        ->get();

        $promotoras=DB::table('tbl_grupos_promotoras')
        ->join('tbl_usuarios','tbl_grupos_promotoras.id_usuario','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')

        ->join('tbl_grupos','tbl_grupos_promotoras.id_grupo','tbl_grupos.id_grupo')
        
        ->select('tbl_usuarios.*','tbl_datos_usuario.*','tbl_grupos_promotoras.id_grupo_promotoras','tbl_grupos.grupo','tbl_grupos.id_grupo')
        ->where('tbl_grupos.id_grupo','=',$idgrupo)
        ->get();


        return view('admin.rutas.editar_visita',['region'=>$region,'zona'=>$zona,'grupo'=>$grupo,'dias'=>$dias,'gerenteszonas'=>$allgerentes,'promotoras'=>$promotoras,'visita'=>$visita]);
    }

    public function update_visita($idv,$idregion,$idzona,$idgrupo){
        $datosAc=request()->except(['_token','_method']);
        RutaZona::where('id_ruta_zona','=',$idv)->update($datosAc);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 31,
            'id_movimiento' =>  $idv,
            'descripcion' => "Se actualizó una visita de zona",
            'fecha_registro' => $fecha_hoy
        ]);
        
        return redirect()->to('rutas/visitas/visitas-porgrupo/'.$idregion.'/'.$idzona.'/'.$idgrupo)->with('status', 'Visita actualizado con éxito!');
        // return back()->with('status', 'Visita actualizado con éxito!');
    }

    public function deletevisita($id_ruta_zona){

        // dd('jjjjjjjj');
        RutaZona::destroy($id_ruta_zona);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 31,
            'id_movimiento' =>  $idv,
            'descripcion' => "Se eliminó una visita de zona",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', 'Visita eliminado con éxito!');
    }

    public function delete_varias_visita(Request $request){
       
        $input= $request->all();
        $input2= $request->id_ruta_zona;
        if ($input2==null) {
            return back()->with('warning', 'Seleccione las visitas que quiere eliminar por favor');
        } else {
            
            foreach ($input["id_ruta_zona"] as $key => $value) {
                $id_ruta_zona=$value;
                RutaZona::destroy($id_ruta_zona);
                $fecha_hoy=Carbon::now();
                DB::table('tbl_log')->insert([
                    'id_log' => null, 
                    'id_tipo' => 3,
                    'id_plataforma' => 2,
                    'id_usuario' => Auth::user()->id,
                    'id_tipo_movimiento' => 31,
                    'id_movimiento' =>  $id_ruta_zona,
                    'descripcion' => "Se eliminó una visita de zona",
                    'fecha_registro' => $fecha_hoy
                ]);
            }
    
            return back()->with('status', '¡Visitas eliminados con éxito!');
        }
        
    }

    public function varias_visita_zona(Request $request,$idzona,$idregion){
        
        $region=Plaza::find($idregion);

        if(empty($request->id_zona)) {
            $idzona=$idzona;
        }elseif($idzona==0){
            $idzona=$request->id_zona;
        }

        $zona = Zona::find($idzona);

        $zonas = DB::table('tbl_grupos')
        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
        ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
        // ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
        ->select('tbl_zona.*')
        ->where('tbl_plaza.IdPlaza','=',$idregion)
        ->orderBy('tbl_zona.Zona','ASC')
        ->distinct()
        ->get();

        $grupos = DB::table('tbl_grupos')
                ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
                // ->Join('tbl_prestamos', 'tbl_grupos.id_grupo', '=', 'tbl_prestamos.id_grupo')
                ->select('tbl_grupos.*','tbl_zona.Zona','tbl_zona.IdZona')
                ->where('tbl_grupos.IdZona','=',$idzona)
                ->orderBy('tbl_grupos.grupo','ASC')
                ->distinct()
                ->get();

        $allgerentes=DB::table('tbl_usuarios')
        ->join('tbl_zonas_gerentes','tbl_usuarios.id','tbl_zonas_gerentes.id_usuario')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_usuarios.*','tbl_datos_usuario.*')
        ->where('tbl_zonas_gerentes.id_zona','=',$idzona)
        ->distinct()
        ->orderBy('tbl_datos_usuario.nombre','ASC')
        ->get();

        $dias=DB::table('tbl_dias_semana')
        ->select('tbl_dias_semana.*')
        ->get();

        return view('admin.rutas.muchas_visitas',['region'=>$region,'zona'=>$zona,'grupos'=>$grupos,'dias'=>$dias,'allgerentes'=>$allgerentes,'zonas'=>$zonas]);
        
    }

    public function guardar_varias_visita(Request $request){
        $input= $request->all();
        // dd($input);
        $input2= $request->id_grupo;
        if ($input2==null) {
            return back()->with('warning', 'Seleccione las visitas que quiere eliminar por favor');
        } else {

            
            # code...
            // dd($input);
            // dd('jjjjjjjj');
            foreach ($input["id_grupo"] as $key => $value) {
                $dia=$input["id_dia"][$key];
                $gerente=$input["id_gerente_zona"][$key];
                $promotor=$input["id_grupo_promotora"][$key];
                $fecha = Carbon::now();

                if (empty($dia)||empty($gerente)||empty($promotor)) {
                    // dd('esta vacio');
                } else {
                    // dd($dia,$gerente,$promotor);
                    $visitas = RutaZona::create([
                        'id_dia'    => $dia,
                        'id_gerente_zona'    => $gerente,
                        'id_grupo_promotora' => $promotor,
                    ])->save();
                }
            }
    
            return back()->with('status', '¡Visitas guardados con éxito!');
        }
        
    }
    
    
}
