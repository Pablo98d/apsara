<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
use Carbon\Carbon;


class Registro_prospecto extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        User::create([
            'id_tipo_usuario'   => $request->id_tipo_usuario,
            'nombre_usuario'    => $request->nombre_usuario,
            'email'             => $request->email,
            'password'          => Hash::make($request->password)
        ])->save();

        return redirect()->route('users.index')->with('Guardar','Registro Guardado con Exito !!!');
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

        User::where('id','=',$id)->update([
            'id_tipo_usuario'=>$request->id_tipo_usuario,
            'nombre_usuario'=>$request->nombre_usuario,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),

        ]);

        // $datosAc=request()->except(['_token','_method']);
        // User::where('id','=',$id)->update($datosAc);

        return redirect()->route('users.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();
        $clave=DB::table('tbl_datos_usuario')->select('id_datos_usuario')->where('id_usuario','=',$id);
        $datosus=DatosUsuario::findOrFail($clave);
        $datosus->delete();
        return redirect()->route('users.index');
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

        return view('auth.register_prospecto',['promotoras'=>$promotoras]);
    }

    public function guardar_prospecto(Request $request){


        $hoy=Carbon::now();
        
        $f_hoy=$hoy->format('dm');

        try {
            
        

            $nombre=explode(" ",$request->name);
            if (empty($nombre[1])) {
                $nombre_final=$nombre[0];
            } else {
                $nombre_final=$nombre[0].$nombre[1];
            }
        
            // dd($nombre_final);
            $correo_generico=strtolower($nombre_final).$f_hoy.'@admindecreditos.com.mx';
            // dd($correo_generico);

            $users = DB::table('tbl_usuarios')
                ->select('tbl_usuarios.*')
                // ->where('nombre_usuario','=',$request->name)
                ->where('email','=',$correo_generico)
                ->get();

            $request->validate([
                'name'=>'required|min:3|max:255',
                // 'email'=>'required|min:5|max:50',
                'password'=>'required|min:8|max:255',

                'ap_paterno'=>'required|min:3|max:50',
                'ap_materno'=>'required|min:3|max:50',
                'id_promotora'=>'required|min:1|max:20',
                'id_grupo'=>'required|min:1|max:20',

                'curp'=>'required|min:18|max:20',
                'fecha_nacimiento'=>'required|min:8|max:255',
                'edad'=>'required|min:1|max:20',

                'ocupacion'=>'required|min:5|max:255',
                'genero'=>'required|min:3|max:50',

                'estado_civil'=>'required|min:3|max:255',
                'tiempo_vivienda'=>'required|min:1|max:255',
                'tiempo_trabajo'=>'required|min:1|max:255',
            ]);

            if (count($users)==0) {
                $dtosUser = new User;
                $dtosUser->id_tipo_usuario = '3';
                $dtosUser->nombre_usuario = $request->name;
                $dtosUser->email = $correo_generico;
                $dtosUser->password =  Hash::make($request->password);
                $dtosUser->save();


                $idU = User::latest('id')->first();

                $datosU = new DatosUsuario;
                $datosU->id_usuario = $idU->id;
                $datosU->nombre = $request->name;
                $datosU->ap_paterno = $request->ap_paterno;
                $datosU->ap_materno = $request->ap_materno;
                $datosU->telefono_casa = null;
                $datosU->telefono_celular = null;
                $datosU->direccion = null;
                $datosU->numero_exterior = null;
                $datosU->numero_interior = null;
                $datosU->colonia = null;
                $datosU->codigo_postal = null;
                $datosU->localidad = null;
                $datosU->municipio = null;
                $datosU->estado = null;
                $datosU->latitud = null;
                $datosU->longitud = null;
                $datosU->save();

                $datosSocio = new SocioEconomico;
                $datosSocio->id_usuario = $idU->id;
                $datosSocio->id_promotora = $request->id_promotora;
                $datosSocio->estatus = '0';
                $datosSocio->fecha_registro = $hoy;
                $datosSocio->fecha_actualizacion = $hoy;
                $datosSocio->save();

                $idSocio = SocioEconomico::latest('id_socio_economico')->first();

                $datosPres = new Prestamos;
                $datosPres->id_usuario = $idU->id;
                $datosPres->fecha_solicitud = $hoy;
                $datosPres->id_status_prestamo = '1';
                $datosPres->id_grupo = $request->id_grupo;
                $datosPres->id_promotora = $request->id_promotora;
                $datosPres->id_producto = '1';
                $datosPres->id_autorizo = null;
                $datosPres->fecha_aprovacion = null;
                $datosPres->fecha_entrega_recurso = null;
                $datosPres->save();

                $datosGe = new DatosGenerales;
                $datosGe->id_socio_economico = $idSocio->id_socio_economico;
                $datosGe->curp = $request->curp;
                $datosGe->nombre = $request->name;
                $datosGe->ap_paterno = $request->ap_paterno;
                $datosGe->ap_materno = $request->ap_materno;
                $datosGe->fecha_nacimiento = $request->fecha_nacimiento;
                $datosGe->edad = $request->edad;
                $datosGe->ocupacion = $request->ocupacion;
                $datosGe->genero = $request->genero;
                $datosGe->estado_civil = $request->estado_civil;
                $datosGe->save();

                $datosVi = new Vivienda;
                $datosVi->id_socio_economico = $idSocio->id_socio_economico;
                $datosVi->tipo_vivienda = '';
                $datosVi->tiempo_viviendo_domicilio = $request->tiempo_vivienda;
                $datosVi->telefono_casa = '';
                $datosVi->telefono_celular = '';
                $datosVi->save();

                $datosRefL = new ReferenciaLaboral;
                $datosRefL->id_socio_economico = $idSocio->id_socio_economico;
                $datosRefL->save();

                $idRefL = ReferenciaLaboral::latest('id_referencia_laboral')->first();

                $datosRefLP = new ReferenciaLaboralPersonas;
                $datosRefLP->id_referencia_laboral = $idRefL->id_referencia_laboral;
                $datosRefLP->nombre_empresa = '';
                $datosRefLP->actividad_empresa = '';
                $datosRefLP->cargo_empresa = '';
                $datosRefLP->direccion = '';
                $datosRefLP->numero_ext = '';
                $datosRefLP->numero_int = '';
                $datosRefLP->entre_calles = '';
                $datosRefLP->telefono_empresa = '';
                $datosRefLP->tiempo_empresa = $request->tiempo_trabajo;
                $datosRefLP->jefe_inmediato = '';
                $datosRefLP->save();

            } else {
                $mensaje='El correo ya existe';
                return back()->with('error', '¡El correo que ingresó ya existe!');
            }
        } catch (Exception $e) {
            return back()->with('error', $e);
        }
        return redirect('prestamo/socio/admin/socioeconomico')->with('status', '¡Se ha registrado correctamente, solo espere la aprobación de su solicitud! su correo es: '.$correo_generico);
        // return back()->with();
    }
}
