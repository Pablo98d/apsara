<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Flash;



class MiPerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mis_datos=DB::table('tbl_usuarios')
        ->join('tbl_datos_usuario','tbl_usuarios.id','tbl_datos_usuario.id_usuario')
        ->select('tbl_datos_usuario.*','tbl_usuarios.*')
        ->where('tbl_usuarios.id',auth::user()->id)
        ->get();
       
        return view('miperfil.index',['mis_datos'=>$mis_datos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $usuario = User::find(Auth::User()->id);
       if(empty($usuario)){
          Flash::error('mensaje error');
          return redirect()->back();
       }
       return view('miperfil')->with('usuario', $usuario);
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
        // dd('jhjhjhjhj');
        

        // dd($request->id_socio_economico,$request->tipo_persona,$request->tipo_foto,$name);
               
        


        // User::where('id','=',$id)->update([
        //     'id_tipo_usuario'=>'1',
        //     'nombre_usuario'=>$request->nombre_usuario,
        //     'email'=>$request->email,
        //     'password'=>Hash::make($request->password),
        // ]);
        // return back()->with('status', '¡Datos del perfil actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function actualizar_foto(Request $request){
        if ($request->hasFile('foto_perfil')) {
            $file=$request->file('foto_perfil');
            $name=time().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/Foto_perfil/',$name);


            $foto_perfil = DB::table('tbl_datos_usuario')
            ->where('id_usuario', Auth::user()->id)
            ->update(['foto_perfil' => 'Foto_perfil/'.$name]);

            $fecha_pago = $fecha_hoy=Carbon::now();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 2,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 35,
                'id_movimiento' => Auth::user()->id,
                'descripcion' => "Se actulizó foto de perfil",
                'fecha_registro' => $fecha_pago
            ]);
            return back()->with('status', '¡Foto perfil actualizado con éxito!');
        }
        return back()->with('error', 'Ocurrio un error, intente otra vez');
    }
}
