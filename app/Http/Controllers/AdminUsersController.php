<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\TipoUsuario;
use App\User;
use App\DatosUsuario;
use App\SocioEconomico;
use App\Prestamos;
use App\DatosGenerales;
use App\Vivienda;
use App\ReferenciaLaboral;
use App\ReferenciaLaboralPersonas;


class AdminUsersController extends Controller
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
        $id_tipo_usuario=$request->id_tipo_usuario;

        if (empty($id_tipo_usuario)) {

            $tipos_usuario = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->orderBy('nombre','ASC')
            ->get();

            $usersss = DB::table('tbl_usuarios')
            ->Join('tbl_tipo_usuario', 'tbl_usuarios.id_tipo_usuario', '=', 'tbl_tipo_usuario.id_tipo_usuario')
            ->select('tbl_usuarios.*','tbl_tipo_usuario.nombre as n_tipo')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('tbl_datos_usuario')
                        ->whereRaw('tbl_datos_usuario.id_usuario = tbl_usuarios.id');
            })
            ->get();

            return view('admin.users.index',['tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'usersss'=>$usersss]);

        } else {

            $usersss = DB::table('tbl_usuarios')
            ->Join('tbl_tipo_usuario', 'tbl_usuarios.id_tipo_usuario', '=', 'tbl_tipo_usuario.id_tipo_usuario')
            ->select('tbl_usuarios.*','tbl_tipo_usuario.nombre as n_tipo')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                        ->from('tbl_datos_usuario')
                        ->whereRaw('tbl_datos_usuario.id_usuario = tbl_usuarios.id');
            })
            ->get();

            $tipos_usuario = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->orderBy('nombre','ASC')
            ->get();

  
            return view('admin.users.index',['tipos_usuario'=>$tipos_usuario,'id_tipo'=>$id_tipo_usuario,'usersss'=>$usersss]);

        }

        return view('admin.users.index',['users'=>$users,'tipos_usuario'=>$tipos_usuario]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('haaahahte busco');
       $tipoUsuario = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->orderBy('nombre','ASC')
            ->get();
            
        return view('admin.users.create',compact('tipoUsuario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $users = DB::table('tbl_usuarios')
            ->select('tbl_usuarios.*')
            ->where('email','=',$request->email)
            ->get();
            
        $request->validate([
            'nombre_usuario'=>'required|min:3|max:255',
            'email'=>'required|min:5|max:50',
            'password'=>'required|min:8|max:255',

            'ap_paterno'=>'required|min:3|max:50',
            'ap_materno'=>'required|min:3|max:50',
            'id_tipo_usuario'=>'required|min:1|max:50',

        ]);
        // dd($request->all());
        if (count($users)==0) {
            $dtosUser = new User;
            $dtosUser->id_tipo_usuario = $request->id_tipo_usuario;
            $dtosUser->nombre_usuario = $request->nombre_usuario;
            $dtosUser->email = $request->email;
            $dtosUser->password =  Hash::make($request->password);
            $dtosUser->save();

            $idU = User::latest('id')->first();
            
            $datosU = new DatosUsuario;
            $datosU->id_usuario = $idU->id;
            $datosU->nombre = $request->nombre_usuario;
            $datosU->ap_paterno = $request->ap_paterno;
            $datosU->ap_materno = $request->ap_materno;
            $datosU->telefono_casa = $request->telefono_casa;
            $datosU->telefono_celular = $request->telefono_celular;
            $datosU->direccion = $request->direccion;
            $datosU->numero_exterior = $request->numero_exterior;
            $datosU->numero_interior = $request->numero_interior;
            $datosU->colonia = $request->colonia;
            $datosU->codigo_postal = $request->codigo_postal;
            $datosU->localidad = $request->localidad;
            $datosU->municipio = $request->municipio;
            $datosU->estado = $request->estado;
            $datosU->latitud = $request->latitud;
            $datosU->longitud = $request->longitud;
            $datosU->save();
            
            $fecha_r_movimiento = $fecha_hoy=Carbon::now();
            $idUser = User::latest('id')->first();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 1,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 10,
                'id_movimiento' => $idUser->id,
                'descripcion' => "Se registró un nuevo usuario",
                'fecha_registro' => $fecha_r_movimiento
            ]);
        } else {
            // $mensaje='El correo ya existe';
            return back()->with('error', '¡El correo que ingresó ya existe!');
        }
        return back()->with('Guardar', '¡Usuario registrado con éxito!');
        // return redirect()->route('users.index')->with('Guardar','¡Registro Guardado con Exito!');
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
        $tipUs = DB::table('tbl_tipo_usuario')
            ->select('tbl_tipo_usuario.*')
            ->orderBy('nombre','ASC')
            ->get();

        $user=User::findOrFail($id);
        return view('admin/users/edit', ['tipUs'=>$tipUs,'user'=>$user]);

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
        // dd($request->all(),'kjhgfd');

        User::where('id','=',$id)->update([
            'id_tipo_usuario'=>$request->id_tipo_usuario,
            'nombre_usuario'=>$request->nombre,
            'email'=>$request->email,

        ]);

        DatosUsuario::where('id_usuario','=',$id)->update([
            'nombre'=>$request->nombre,
            'ap_paterno'=>$request->ap_paterno,
            'ap_materno'=>$request->ap_materno,
            'telefono_casa'=>$request->telefono_casa,
            'telefono_celular'=>$request->telefono_celular,
            'direccion'=>$request->direccion,
            'numero_exterior'=>$request->numero_exterior,
            'numero_interior'=>$request->numero_interior,
            'colonia'=>$request->colonia,
            'codigo_postal'=>$request->codigo_postal,
            'localidad'=>$request->localidad,
            'municipio'=>$request->municipio,
            'estado'=>$request->estado,
            'latitud'=>$request->latitud,
            'longitud'=>$request->longitud,

        ]);

        $fecha_pago = $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 6,
            'id_movimiento' => $id,
            'descripcion' => "Se actualizó datos de usuario/cliente",
            'fecha_registro' => $fecha_pago
        ]);


        return back()->with('Guardar', '¡Datos del usuario actualizado con éxito!');
        // return redirect()->route('users.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('Contacte a un administrador de sistemas para que configure la función de eliminar usuario ');
        // $user=User::findOrFail($id);
        // $user->delete();
        // $clave=DB::table('tbl_datos_usuario')->select('id_datos_usuario')->where('id_usuario','=',$id);
        // $datosus=DatosUsuario::findOrFail($clave);
        // $datosus->delete();

        // $fecha_r_movimiento = $fecha_hoy=Carbon::now();
        //     $idUser = User::latest('id')->first();
        //     DB::table('tbl_log')->insert([
        //         'id_log' => null, 
        //         'id_tipo' => 1,
        //         'id_plataforma' => 2,
        //         'id_usuario' => Auth::user()->id,
        //         'id_tipo_movimiento' => 10,
        //         'id_movimiento' => $idUser->id,
        //         'descripcion' => "Se registró un nuevo usuario",
        //         'fecha_registro' => $fecha_r_movimiento
        //     ]);
        // return redirect()->route('users.index');
    }

    public function export(){
        return Excel::download(new UsersExport, 'Users.xlsx');
    }
    
    public function formulario_prospecto(){

        $promotoras = DB::table('tbl_grupos_promotoras')
            ->Join('tbl_grupos', 'tbl_grupos_promotoras.id_grupo', '=', 'tbl_grupos.id_grupo')
            ->Join('tbl_usuarios', 'tbl_grupos_promotoras.id_usuario', '=', 'tbl_usuarios.id')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_grupos_promotoras.*','tbl_grupos.*','tbl_usuarios.*')
            ->get();

            return view('admin.users.registro_prospecto',['promotoras'=>$promotoras]);
    }
}
