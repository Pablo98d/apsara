<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exports\DatosUsuariosExport;
use App\DatosUsuario;
use App\User;
use App\DatosGenerales;
use App\Zona;

class DatosUsuarioController extends Controller
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
    public function index(Request $request)
    {
        // dd('que hay de nevo datis usuario');
        $id_region_actual=\Cache::get('region');
        $id_ruta_actual=\Cache::get('ruta');
        $on=1;

        if ($id_region_actual==null) {
            $id_region_actual=0;
            $id_ruta_actual=0;
        } else {
            $id_region_actual=\Cache::get('region');
            $id_ruta_actual=\Cache::get('ruta');
        }


        $zona = Zona::find($id_ruta_actual);
        
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region_actual)
        ->orderBy('Zona','ASC')
        ->get();


        $id_tipo_usuario=$request->id_tipo_usuario;
        if (empty($id_tipo_usuario)) {

            $tipos_usuario = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->whereNotIn('id_tipo_usuario',[3])
            ->orderBy('nombre','ASC')
            ->get();

            $datosusu = DB::table('tbl_datos_usuario')
            ->Join('tbl_usuarios', 'tbl_datos_usuario.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_tipo_usuario', 'tbl_usuarios.id_tipo_usuario', '=', 'tbl_tipo_usuario.id_tipo_usuario')
            ->select('tbl_datos_usuario.*', 'tbl_usuarios.nombre_usuario','tbl_tipo_usuario.nombre as tipou')
            ->whereNotIn('tbl_tipo_usuario.id_tipo_usuario',[3])
            ->get();
            return view('admin.datosusuario.index',['datosusu'=>$datosusu,'tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'zona'=>$zona,'zonas'=>$zonas,'on'=>$on]);
            // return view('admin.users.index',['tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'usersss'=>$usersss]);

        } else {

            $datosusu = DB::table('tbl_datos_usuario')
            ->Join('tbl_usuarios', 'tbl_datos_usuario.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_tipo_usuario', 'tbl_usuarios.id_tipo_usuario', '=', 'tbl_tipo_usuario.id_tipo_usuario')
            ->select('tbl_datos_usuario.*', 'tbl_usuarios.nombre_usuario','tbl_tipo_usuario.nombre as tipou')
            ->where('tbl_usuarios.id_tipo_usuario','=',$id_tipo_usuario)
            ->get();

            $tipos_usuario = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->orderBy('nombre','ASC')
            ->get();

            return view('admin.datosusuario.index',['datosusu'=>$datosusu,'tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'zona'=>$zona,'zonas'=>$zonas,'on'=>$on]);
            // return view('admin.users.index',['tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'usersss'=>$usersss]);

        }





        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id_usuario=$request->id_usuario;
        $user=User::find($id_usuario);

        $tipoUsuario = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->orderBy('nombre','ASC')
            ->get();

        return view('admin.datosusuario.create',['tipoUsuario'=>$tipoUsuario,'user'=>$user]);
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
            'nombre' => 'required',
            'ap_paterno' => 'required',
            'ap_materno' => 'required',
            'telefono_casa' => 'required',
            'telefono_celular' => 'required',
            'direccion' => 'required',
            'numero_exterior' => 'required',
            'numero_interior' => 'required',
            'colonia' => 'required',
            'codigo_postal' => 'required',
            'localidad' => 'required',
            'municipio' => 'required',
            'estado' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
        ]);
        DatosUsuario::create($request->all());
        return redirect()->route('datosusuario.index')->with('Guardar','Registro Guardado con Exito !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$on)
    {
        $id_region_actual=\Cache::get('region');
        $id_ruta_actual=\Cache::get('ruta');

        if ($id_region_actual==null) {
            $id_region_actual=0;
            $id_ruta_actual=0;
        } else {
            $id_region_actual=\Cache::get('region');
            $id_ruta_actual=\Cache::get('ruta');
        }


        $zona = Zona::find($id_ruta_actual);
        
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region_actual)
        ->orderBy('Zona','ASC')
        ->get();


        $id_tipo_usuario=$request->id_tipo_usuario;
        if (empty($id_tipo_usuario)) {
            
            $tipos_usuario = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->orderBy('nombre','ASC')
            ->get();

            $datosusu = DB::table('tbl_datos_usuario')
            ->Join('tbl_usuarios', 'tbl_datos_usuario.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
            ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
            ->Join('tbl_tipo_usuario', 'tbl_usuarios.id_tipo_usuario', '=', 'tbl_tipo_usuario.id_tipo_usuario')
            ->select('tbl_datos_usuario.*', 'tbl_usuarios.nombre_usuario','tbl_tipo_usuario.nombre as tipou')
            ->where('tbl_zona.IdZona','=',$id_ruta_actual)
            ->distinct()
            ->get();
            // dd($datosusu);
            return view('admin.datosusuario.index',['datosusu'=>$datosusu,'tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'zona'=>$zona,'zonas'=>$zonas,'on'=>$on]);
            // return view('admin.users.index',['tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'usersss'=>$usersss]);

        } else {

            $datosusu = DB::table('tbl_datos_usuario')
            ->Join('tbl_usuarios', 'tbl_datos_usuario.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_tipo_usuario', 'tbl_usuarios.id_tipo_usuario', '=', 'tbl_tipo_usuario.id_tipo_usuario')
            ->select('tbl_datos_usuario.*', 'tbl_usuarios.nombre_usuario','tbl_tipo_usuario.nombre as tipou')
            ->where('tbl_usuarios.id_tipo_usuario','=',$id_tipo_usuario)
            ->get();

            $tipos_usuario = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->orderBy('nombre','ASC')
            ->get();
// dd('que hay de nevo');
            return view('admin.datosusuario.index',['datosusu'=>$datosusu,'tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'zona'=>$zona,'zonas'=>$zonas,'on'=>$on]);
            // return view('admin.users.index',['tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'usersss'=>$usersss]);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_usuario)
    {
        $tipUs = DB::table('tbl_tipo_usuario')
        ->select('tbl_tipo_usuario.*')
        ->orderBy('nombre','ASC')
        ->get();
        $usuario = DB::table('tbl_datos_usuario')
            ->Join('tbl_usuarios', 'tbl_datos_usuario.id_usuario', '=', 'tbl_usuarios.id')
            ->select('tbl_usuarios.*','tbl_datos_usuario.*')
            ->where('tbl_datos_usuario.id_usuario','=',$id_usuario)
            ->get();

        
        return view('admin/datosusuario/edit', ['tipUs'=>$tipUs,'datosusuario'=>$usuario]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_usuario)
    {

        // dd($id_usuario);
        // User::where('id','=',$id)->update([
        //     'email'=>$request->email,

        // ]);
        // $datosAc=request()->except(['_token','_method']);
        // DatosUsuario::where('id_datos_usuario','=',$id_datos_usuario)->update($datosAc);
        User::where('id','=',$id_usuario)->update([
            'password'=>Hash::make($request->password),

        ]);
        return redirect()->route('datosusuario.index')->with('Guardar','Contraseña actualizada del usuario');
        // return back()->with('Guardar','Contraseña actualizada del usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_usuario)
    {
        DB::table('tbl_datos_usuario')->where('id_usuario','=', $id_usuario)->delete();
        DB::table('tbl_usuarios')->where('id','=', $id_usuario)->delete();

        $fecha_r_movimiento = $fecha_hoy=Carbon::now();
        
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 3,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 6,
            'id_movimiento' => $id_usuario,
            'descripcion' => "Se eliminó un usuario/cliente",
            'fecha_registro' => $fecha_r_movimiento
        ]);

        return back()->with('Guardar', '¡Usuario eliminado con éxito!');
    }

    public function export(){
        return Excel::download(new DatosUsuariosExport, 'DatosUsers.xlsx');
    }


    public function create_datos_generales(Request $request){

        $curp=$request->curp;
        $comparar=DB::table('tbl_se_datos_generales')
        ->select('tbl_se_datos_generales.*')
        ->where('curp','=',$curp)
        ->get();

        if (empty($comparar[0]->curp)) {
            DatosGenerales::create($request->all());

            $idDG = DatosGenerales::latest('id_datos_generales')->first();
            $fecha_hoy=Carbon::now();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 1,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 28,
                'id_movimiento' =>  $idDG->id_datos_generales,
                'descripcion' => "Se registró datos generales",
                'fecha_registro' => $fecha_hoy
            ]);

            return back()->with('status', '¡Datos generales guardados con éxito!');
        } else {
            return back()->with('danger', '¡La CURP ya esta registrado, intente con otra!');
        }
        
    }

    public function update_datos_generales(Request $request,$id_datos_generales){
       
        // dd($request);

            $datosAc=request()->except(['_token']);
            DatosGenerales::where('id_datos_generales','=',$id_datos_generales)->update($datosAc);
            $fecha_hoy=Carbon::now();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 2,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 28,
                'id_movimiento' =>  $id_datos_generales,
                'descripcion' => "Se actualizó datos generales",
                'fecha_registro' => $fecha_hoy
            ]);
            return back()->with('status', '¡Datos generales actualizados con éxito!');
    }
    
    public function total_clientes(){
        $id_region_actual=\Cache::get('region');
        $id_ruta_actual=\Cache::get('ruta');

        if ($id_region_actual==null) {
            $id_region_actual=0;
            $id_ruta_actual=0;
        } else {
            $id_region_actual=\Cache::get('region');
            $id_ruta_actual=\Cache::get('ruta');
        }


        $zona = Zona::find($id_ruta_actual);
        
        $zonas = DB::table('tbl_zona')
        ->select('tbl_zona.*')
        ->where('IdPlaza','=',$id_region_actual)
        ->orderBy('Zona','ASC')
        ->get();

        $datosusu = DB::table('tbl_datos_usuario')
        ->Join('tbl_usuarios', 'tbl_datos_usuario.id_usuario', '=', 'tbl_usuarios.id')
        ->Join('tbl_tipo_usuario', 'tbl_usuarios.id_tipo_usuario', '=', 'tbl_tipo_usuario.id_tipo_usuario')
        ->select('tbl_datos_usuario.*', 'tbl_usuarios.nombre_usuario','tbl_tipo_usuario.nombre as tipou')
        ->where('tbl_usuarios.id_tipo_usuario','=',3)
        ->get();


        return view('admin.datosusuario.clientes_total',['datosusu'=>$datosusu,'zonas'=>$zonas,'zona'=>$zona]);
    }
    
}
