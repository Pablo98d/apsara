<?php

namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DatosUsuario;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\SocioEconomico;
use App\Familiares;
use App\Aval;
use App\Se_Aval;
use App\Vivienda;
use App\Pareja;
use App\Domicilio;
use App\ArticulosHogar;
use App\Finanzas;
use App\FechaMonto;
use App\GastosMensuales;
use App\GastosSemanales;
use App\ReferenciaLaboral;
use App\ReferenciaLaboralPersonas;
use App\ReferenciaPersonal;
use App\ReferenciaPersonalPersonas;
use App\Tipoabono;
use App\DatosGenerales;
use App\DocImagenes;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class HomeClienteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','rol.cliente']);
    }

    public function index()
    {
        request()->session()->regenerate();
        // return $request->session()->all();
        // $user = Auth::user();
        $prestamo=DB::table('tbl_prestamos')
        ->join('tbl_productos','tbl_prestamos.id_producto','=','tbl_productos.id_producto')
        ->join('tbl_grupos','tbl_prestamos.id_grupo','=','tbl_grupos.id_grupo')
        ->join('tbl_usuarios','tbl_prestamos.id_promotora','=','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','=','tbl_datos_usuario.id_usuario')

        ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','=','tbl_status_prestamo.id_status_prestamo')
        ->select('tbl_prestamos.*','tbl_productos.*','tbl_status_prestamo.*','tbl_grupos.*','tbl_datos_usuario.*')
        ->where('tbl_prestamos.id_usuario','=',auth()->user()->id) 
        ->get();
        return view('cliente/homecliente',['prestamo'=>$prestamo]);

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
        //
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
        //
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
    public function datos_usuario(){
        
        return view('cliente/datos_usuario');
    }
    public function guardar_datos(Request $request){
        
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
        // dd($request->all());
        DatosUsuario::create($request->all());
        return back()->with('status', '¡Sus datos se guardaron correctamente!');
    }
    public function editar_datos(Request $request,$id_datos_usuario){
        $datosAc=request()->except(['_token','_method']);
        DatosUsuario::where('id_datos_usuario','=',$id_datos_usuario)->update($datosAc);
        $fecha_pago = $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 6,
            'id_movimiento' => $id_datos_usuario,
            'descripcion' => "Se actualizó datos de usuario/cliente",
            'fecha_registro' => $fecha_pago
        ]);
        return back()->with('status', '¡Sus datos se actualizaron correctamente!');
    }
    // public function realizar_socio(){
    //     return view();
    // }

    public function realizar_socio(){
        // $id_socioeconomico=$request->id_socioeconomico;
        // $now = Carbon::now(); 
        // $user = DB::table('tbl_usuarios')
        //     ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        //     ->select('tbl_usuarios.*', 'tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
        //     ->get();
        $now = Carbon::now(); 
        $promotores = DB::table('tbl_usuarios')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_usuarios.*', 'tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno')
            ->where('tbl_usuarios.id_tipo_usuario','=',4)
            ->orderBy('tbl_datos_usuario.nombre','ASC')
            ->get();


        $avales=DB::table('tbl_avales')
        ->select('tbl_avales.*')
        ->where('estatus_aval','=',0)
        ->orderBy('nombre','ASC')
        ->get();

        // $estatus=DB::table('tbl_socio_economico')
        // ->select('tbl_socio_economico.*')
        // ->where('id_socio_economico','=',$id_socioeconomico)
        // ->get();

        return view('cliente.socio_economico',['avales'=>$avales,'promotores'=>$promotores,'now'=>$now]);
    }
    public function guardar_socio(Request $request)
    {
        $this->validate($request,[
            'id_usuario' => 'required',
            'id_promotora'=>'required',
            'estatus'=>'required',
            'fecha_registro' => 'required'
        ]);
        SocioEconomico::create($request->all());
        return back()->with('status', '¡Socioeconomico se guardo correctamente!');
        // return redirect()->route('socioeconomico.index')->with('Guardar','Registro Guardado con Exito !!!');
    }

    public function familiares_guardar(Request $request){
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
    }

    public function familiares_update(Request $request,$id){
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
    // public function aval_guardar(Request $request){

    // }
    public function aval_guardar(Request $request)
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

    public function aval_guardar_se(Request $request){
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

    public function aval_update(Request $request, $id)
    {

        $fechanacimiento=$request->fecha_nacimiento;
        $fn = str_split($fechanacimiento);
        $dian=$fn[0].$fn[1];
        $mesn=$fn[3].$fn[4];
        $añon=$fn[6].$fn[7].$fn[8].$fn[9];
        $fecha_nacimiento = $añon.'-'.$mesn.'-'.$dian;

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
    public function vivienda_guardar(Request $request)
    {
        $this->validate($request,[
            'id_socio_economico' => 'required',
            'tipo_vivienda' => 'required',
            'tiempo_viviendo_domicilio' => 'required',
            'telefono_casa' => 'required',
            'telefono_celular' => 'required'
        ]);
        Vivienda::create($request->all());
        $idV = Vivienda::latest('id_vivienda')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 18,
            'id_movimiento' =>  $idV->id_vivienda,
            'descripcion' => "Se registró datos vivienda",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Datos de la vivienda guardados con éxito!');
        //return view('admin.vivienda.create',['soci'=>$soci,'idSocio'=>$id]);
    }
    public function vivienda_update(Request $request, $id)
    {
        $datosAc=request()->except(['_token','_method']);
        Vivienda::where('id_vivienda','=',$id)->update($datosAc);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 18,
            'id_movimiento' => $id,
            'descripcion' => "Se actualizó datos vivienda",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de la vivienda actualizados con éxito!');
        //return redirect()->route('vivienda.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    public function pareja_guardar(Request $request)
    {
        $this->validate($request,[
            'id_socio_economico' => 'required',
            'nombre' => 'required',
            'ap_paterno' => 'required',
            'ap_materno' => 'required',
            'telefono' => 'required',
            'edad' => 'required',
            'ocupacion' => 'required',
        ]);

        $pareja = Pareja::create($request->all());
        $idPar = Pareja::latest('id_pareja')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 19,
            'id_movimiento' =>  $idPar->id_pareja,
            'descripcion' => "Se registró datos pareja",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Datos de la pareja, guardada con éxito!');
        //return view('admin.pareja.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    public function pareja_update(Request $request, $id)
    {
        $pareja=request()->except(['_token','_method']);
        Pareja::where('id_pareja','=',$id)->update($pareja);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 19,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos pareja",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de la pareja, actualizado con éxito!');
        //return redirect()->route('pareja.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }
    public function domicilio_guardar(Request $request)
    {
        $this->validate($request,[
            'id_socio_economico' => 'required',
            'calle' => 'required',
            'numero_ext' => 'required',
            'numero_int' => 'required',
            'entre_calles' => 'required',
            'colonia_localidad' => 'required',
            'municipio' => 'required',
            'estado' => 'required',
            'referencia_visual' => 'required'
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
    public function domicilio_update(Request $request, $id)
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
    public function art_hogar_guardar(Request $request)
    {
        ArticulosHogar::create($request->all());
        $idArti = ArticulosHogar::latest('id_articulo')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 21,
            'id_movimiento' =>  $idArti->id_articulo,
            'descripcion' => "Se registró datos artículos hogar",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Datos de artículos del hogar, guardado con éxito!');
    }
    public function art_hogar_update(Request $request, $id)
    {
        $articuloshogar=request()->except(['_token','_method']);

        ArticulosHogar::where('id_articulo','=',$id)->update([
            'estufa'=>$request->estufa,
            'refrigerador'=>$request->refrigerador,
            'microondas'=>$request->microondas,
            'lavadora'=>$request->lavadora,
            'secadora'=>$request->secadora,
            'computadora_escritorio'=>$request->computadora_escritorio,
            'laptop'=>$request->laptop,
            'television'=>$request->television,
            'pantalla'=>$request->pantalla,
            'grabadora'=>$request->grabadora,
            'estereo'=>$request->estereo,
            'dvd'=>$request->dvd,
            'blue_ray'=>$request->blue_ray,
            'teatro_casa'=>$request->teatro_casa,
            'bocina_portatil'=>$request->bocina_portatil,
            'celular'=>$request->celular,
            'tablet'=>$request->tablet,
            'consola_videojuegos'=>$request->consola_videojuegos,
            'instrumentos'=>$request->instrumentos,
            'otros'=>$request->otros,
        ]);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 21,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos artículos hogar",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de artículos del hogar, actualizado con éxito!');
        //return redirect()->route('articuloshogar.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }

    public function finanzas_guardar(Request $request)
    {
        $this->validate($request,[
            'id_socio_economico' => 'required',
            'deuda_tarjeta_credito' => 'required',
            'deuda_otras_finanzas' => 'required',
            'pension_hijos' => 'required',
            'ingresos_mensuales' => 'required',
            'buro_credito' => 'required'
        ]);
        Finanzas::create($request->all());
        $idFin = Finanzas::latest('id_finanza')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 22,
            'id_movimiento' =>  $idFin->id_finanza,
            'descripcion' => "Se registró datos finanzas",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Datos de finanzas, guardado con éxito!');
        //return view('admin.finanzas.create',['soci'=>$soci,'idSocio'=>$id]);
    }
    public function finanzas_update(Request $request, $id)
    {
        $datosAc=request()->except(['_token','_method']);
        Finanzas::where('id_finanza','=',$id)->update($datosAc);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 22,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos finanzas",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de finanzas, actualizado con éxito!');

    }
    public function fecha_m_guardar(Request $request)
    {
        $this->validate($request,[
            'id_socio_economico' => 'required',
            'fecha_credito' => 'required',
            'monto_credito' => 'required',
        ]);
        FechaMonto::create($request->all());
        $idFecha = FechaMonto::latest('id_referencia')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 23,
            'id_movimiento' =>  $idFecha->id_referencia,
            'descripcion' => "Se registró datos fecha monto",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Datos de la fecha monto, guardado con éxito!');
        //return view('admin.fechamonto.create',['soci'=>$soci,'idSocio'=>$id]);
    }
    public function fecha_m_update(Request $request, $id)
    {
        $datosAc=request()->except(['_token','_method']);
        FechaMonto::where('id_referencia','=',$id)->update($datosAc);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 23,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos fecha monto",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos de la fecha monto, actualizado con éxito!');
    }
    public function g_mensuales_guardar(Request $request)
    {
        $this->validate($request,[
            'id_socio_economico' => 'required',
            'renta_hipoteca' => 'required',
            'telefono_fijo' => 'required',
            'internet' => 'required',
            'telefono_movil' => 'required',
            'cable' => 'required',
            'luz' => 'required',
            'gas' => 'required',
        ]);

        $gastosmensuales = GastosMensuales::create($request->all());
        $idGM = GastosMensuales::latest('id_gasto_mensual')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 24,
            'id_movimiento' =>  $idGM->id_gasto_mensual,
            'descripcion' => "Se registró datos gastos mensuales",
            'fecha_registro' => $fecha_hoy
        ]);
        
        return back()->with('status', '¡Datos del gasto mensual, guardado con éxito!');
    }

    public function g_mensual_update(Request $request, $id)
    {
        $gastosmensuales=request()->except(['_token','_method']);
        GastosMensuales::where('id_gasto_mensual','=',$id)->update($gastosmensuales);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 24,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos gastos mensuales",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '¡Datos del gasto mensual, actualizado con éxito!');
    }
    public function g_semanal_guardar(Request $request)
    {
        $this->validate($request,[
            'id_socio_economico' => 'required',
            'alimentos' => 'required',
            'transporte_publico' => 'required',
            'gasolina' => 'required',
            'educacion' => 'required',
            'diversion' => 'required',
            'medicamentos' => 'required',
            'deportes' => 'required',
        ]);

        $gastossemanales = GastosSemanales::create($request->all());
        $idGS = GastosSemanales::latest('id_gasto_semanal')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 25,
            'id_movimiento' =>  $idGS->id_gasto_semanal,
            'descripcion' => "Se registró datos gastos semanales",
            'fecha_registro' => $fecha_hoy
        ]);
        
        return back()->with('status', '¡Datos del gasto semanal, guardado con éxito!');
    }

    public function g_semanal_update(Request $request, $id)
    {
        $gastossemanales=request()->except(['_token','_method']);
        GastosSemanales::where('id_gasto_semanal','=',$id)->update($gastossemanales);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 25,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos gastos semanales",
            'fecha_registro' => $fecha_hoy
        ]);
        return back()->with('status', '¡Datos del gasto semanal, actualizado con éxito!');
    }
    public function r_laboral_guardar(Request $request)
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

    public function r_l_presonas_update(Request $request, $id)
    {
        $referencialbpersonas=request()->except(['_token','_method']);
        ReferenciaLaboralPersonas::where('id_rl_persona','=',$id)->update($referencialbpersonas);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 26,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos referencia laboral",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '!Datos de la referencia laboral actualizado con éxito¡');
        // return redirect()->route('referencialbpersonas.index')->with('Guardar','Registro Actualizado con Exito !!!');
    }
    public function r_personal_guardar(Request $request)
    {
        $datos = new ReferenciaPersonal;
        $datos->id_socio_economico = $request->id_socio_economico;
        $datos->save();

        $idRL = ReferenciaPersonal::latest('id_referencia_personal')->first();

        $rlp = new ReferenciaPersonalPersonas;
            $rlp->id_referencia_personal = $idRL->id_referencia_personal;
            $rlp->nombre        = $request->nombre;
            $rlp->domicilio     = $request->domicilio;
            $rlp->telefono         = $request->telefono;
            $rlp->relacion             = $request->relacion;
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
    public function r_personal_update(Request $request, $id)
    {
        $datosAc=request()->except(['_token','_method']);
        ReferenciaPersonalPersonas::where('id_rp_persona','=',$id)->update($datosAc);
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 2,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 27,
            'id_movimiento' =>  $id,
            'descripcion' => "Se actualizó datos referencia personal",
            'fecha_registro' => $fecha_hoy
        ]);

        return back()->with('status', '!Datos de la referencia personal actualizado con éxito¡');
    }
    public function c_finalizacion(Request $request){

        $id_socioeconomico=$request->id_socio_economico;

        $familiar=DB::table('tbl_familiares')->select(DB::raw('count(*) as ftotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();

        $aval=DB::table('tbl_se_aval')->select(DB::raw('count(*) as atotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $vivienda=DB::table('tbl_vivienda')->select(DB::raw('count(*) as vtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $pareja=DB::table('tbl_pareja')->select(DB::raw('count(*) as ptotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $domicilio=DB::table('tbl_domicilio')->select(DB::raw('count(*) as dtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();

        $arhogar=DB::table('tbl_se_articulos_hogar')->select(DB::raw('count(*) as arhtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $finanzas=DB::table('tbl_se_finanzas')->select(DB::raw('count(*) as fintotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $fechamonto=DB::table('tbl_fecha_monto')->select(DB::raw('count(*) as fmtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $gmensuales=DB::table('tbl_gastos_mensuales')->select(DB::raw('count(*) as gmtotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        $gsemanal=DB::table('tbl_gastos_semanales')->select(DB::raw('count(*) as gstotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $rlaboral=DB::table('tbl_se_referencia_laboral')->select(DB::raw('count(*) as rltotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();
        
        $rpersonal=DB::table('tbl_se_referencia_personal')->select(DB::raw('count(*) as rptotal'))
            ->where('id_socio_economico','=',$id_socioeconomico)
            ->get();

        if ($familiar[0]->ftotal>0) {
            if ($aval[0]->atotal>0) {
                if ($vivienda[0]->vtotal>0) {
                    if ($pareja[0]->ptotal>0) {
                        if ($domicilio[0]->dtotal>0) {
                            if ($arhogar[0]->arhtotal>0) {
                                if ($finanzas[0]->fintotal>0) {
                                    if ($fechamonto[0]->fmtotal>0) {
                                        if ($gmensuales[0]->gmtotal>0) {
                                            if ($gsemanal[0]->gstotal>0) {
                                                if ($rlaboral[0]->rltotal>0) {
                                                    if ($rpersonal[0]->rptotal>0) {
                                                        $fecha_hoy=Carbon::now(); 
                                                        SocioEconomico::where('id_socio_economico','=',$id_socioeconomico)->update([
                                                            'estatus'=>1,
                                                        ]);
                                                        DB::table('tbl_log')->insert([
                                                            'id_log' => null, 
                                                            'id_tipo' => 2,
                                                            'id_plataforma' => 2,
                                                            'id_usuario' => Auth::user()->id,
                                                            'id_tipo_movimiento' => 3,
                                                            'id_movimiento' =>  $id_socioeconomico,
                                                            'descripcion' => "Se actualizó socioeconómico, como terminado",
                                                            'fecha_registro' => $fecha_hoy
                                                        ]);
                                                        return back()->with('status', '¡Concluido con éxito!');
                                                    } else {
                                                        return back()->with('danger', '¡Datos de referencia personal aun no se ha registrado!');
                                                    }
                                                } else {
                                                    return back()->with('danger', '¡Datos de referencia laboral aun no se ha registrado!');
                                                }
                                            } else {
                                                return back()->with('danger', '¡Datos de gastos semanales aun no se ha registrado!');
                                            }
                                        } else {
                                            return back()->with('danger', '¡Datos de gastos mensuales aun no se ha registrado!');
                                        }
                                    } else {
                                        return back()->with('danger', '¡Datos de fecho monto aun no se ha registrado!');
                                    }
                                } else {
                                    return back()->with('danger', '¡Datos de finanzas aun no se ha registrado!');
                                }
                            } else {
                                return back()->with('danger', '¡Datos de los articulos del hogar aun no se ha registrado!');
                            }
                        } else {
                            return back()->with('danger', '¡Datos del domicilio aun no se ha registrado!');
                        }
                    } else {
                        return back()->with('danger', '¡Datos de la pareja aun no se ha registrado!');
                    }
                } else {
                    return back()->with('danger', '¡Datos de la vivienda aun no se ha registrado!');
                }
                
            } else {
                return back()->with('danger', '¡El aval aun no se ha registrado!');
            }
        } else {
            return back()->with('danger', '¡Datos del familiar aun no se ha registrado!');
        }
    }

    public function prestamo_cliente(){
        $presamo=DB::table('tbl_prestamos')
        ->join('tbl_productos','tbl_prestamos.id_producto','=','tbl_productos.id_producto')
        ->join('tbl_grupos','tbl_prestamos.id_grupo','=','tbl_grupos.id_grupo')
        ->join('tbl_usuarios','tbl_prestamos.id_promotora','=','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','=','tbl_datos_usuario.id_usuario')

        ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','=','tbl_status_prestamo.id_status_prestamo')
        ->select('tbl_prestamos.*','tbl_productos.*','tbl_status_prestamo.*','tbl_grupos.*','tbl_datos_usuario.*')
        ->where('tbl_prestamos.id_usuario','=',auth()->user()->id) 
        ->get();
        return view('cliente.prestamos_cliente',['prestamos'=>$presamo]);
    }

    public function historial_abono($id_prestamo){
        // dd('999999');
        $prestamo = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
        ->select('tbl_prestamos.*','tbl_productos.*','tbl_status_prestamo.status_prestamo')
        ->where('tbl_prestamos.id_prestamo','=',$id_prestamo)
        ->distinct()
        ->get();

        $region_zona_grupo = DB::table('tbl_prestamos')
        ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
        ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')
        ->select('tbl_grupos.*','tbl_zona.*','tbl_plaza.*')
        ->where('tbl_prestamos.id_prestamo','=',$id_prestamo)
        ->distinct()
        ->get();
    
        $cliente = DB::table('tbl_usuarios')
            ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
            ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
            ->select('tbl_usuarios.*','tbl_datos_usuario.nombre','tbl_datos_usuario.ap_paterno','tbl_datos_usuario.ap_materno','tbl_prestamos.id_prestamo')
            ->where('tbl_prestamos.id_prestamo','=',$id_prestamo)
            ->distinct()
            ->get();
    
        $datosabonos=DB::table('tbl_abonos')
        ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
        ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono')
        ->where('id_prestamo', '=', $id_prestamo)
        ->orderBy('tbl_abonos.semana','ASC')
        ->get();
    
        $tipoabono=Tipoabono::all();
            return view('cliente.historial_abono',['cliente'=>$cliente,'datosabonos'=>$datosabonos,'prestamo'=>$prestamo,'tipoabono'=>$tipoabono,'region_zona_grupo'=>$region_zona_grupo]);
        }

    public function historial_cliente(){

        
        $presamo=DB::table('tbl_prestamos')
        ->join('tbl_productos','tbl_prestamos.id_producto','=','tbl_productos.id_producto')
        ->join('tbl_grupos','tbl_prestamos.id_grupo','=','tbl_grupos.id_grupo')
        ->join('tbl_usuarios','tbl_prestamos.id_promotora','=','tbl_usuarios.id')
        ->join('tbl_datos_usuario','tbl_usuarios.id','=','tbl_datos_usuario.id_usuario')

        ->join('tbl_status_prestamo','tbl_prestamos.id_status_prestamo','=','tbl_status_prestamo.id_status_prestamo')
        ->select('tbl_prestamos.*','tbl_productos.*','tbl_status_prestamo.*','tbl_grupos.*','tbl_datos_usuario.*')
        ->where('tbl_prestamos.id_usuario','=',auth()->user()->id) 
        ->get();
        return view('cliente.historial_cliente',['prestamos'=>$presamo]);
       
    }
    public function recibo_abono($idprestamo){

        $region_zona = DB::table('tbl_prestamos')
        ->Join('tbl_grupos', 'tbl_prestamos.id_grupo', '=', 'tbl_grupos.id_grupo')
        ->Join('tbl_zona', 'tbl_grupos.IdZona', '=', 'tbl_zona.IdZona')
        ->Join('tbl_plaza', 'tbl_zona.IdPlaza', '=', 'tbl_plaza.IdPlaza')

        ->select('tbl_plaza.*','tbl_zona.*','tbl_grupos.*')
        ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
        ->get();
        // dd($region_zona);

        $prestamo = DB::table('tbl_prestamos')
        ->Join('tbl_productos', 'tbl_prestamos.id_producto', '=', 'tbl_productos.id_producto')
        ->Join('tbl_status_prestamo', 'tbl_prestamos.id_status_prestamo', '=', 'tbl_status_prestamo.id_status_prestamo')
        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        ->select('tbl_prestamos.*','tbl_productos.*','tbl_status_prestamo.status_prestamo')
        ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
        ->get();

        $cliente = DB::table('tbl_usuarios')
        ->Join('tbl_prestamos', 'tbl_usuarios.id', '=', 'tbl_prestamos.id_usuario')
        ->Join('tbl_datos_usuario', 'tbl_usuarios.id', '=', 'tbl_datos_usuario.id_usuario')
        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        ->select('tbl_usuarios.*','tbl_datos_usuario.*')
        ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
        // ->distinct()
        ->get();

        $aval = DB::table('tbl_socio_economico')
        ->Join('tbl_prestamos', 'tbl_socio_economico.id_usuario', '=', 'tbl_prestamos.id_usuario')
        ->Join('tbl_se_aval', 'tbl_socio_economico.id_socio_economico', '=', 'tbl_se_aval.id_socio_economico')
        ->Join('tbl_avales', 'tbl_se_aval.id_aval', '=', 'tbl_avales.id_aval')
        // ->Join('tbl_abonos', 'tbl_prestamos.id_prestamo', '=', 'tbl_abonos.id_prestamo')
        ->select('tbl_avales.*')
        ->where('tbl_prestamos.id_prestamo','=',$idprestamo)
        ->distinct()
        ->get();

        $datosabonos=DB::table('tbl_abonos')
        ->Join('tbl_tipoabono', 'tbl_abonos.id_tipoabono', '=', 'tbl_tipoabono.id_tipoabono')
        ->select('tbl_abonos.*','tbl_tipoabono.tipoAbono')
        ->where('id_prestamo', '=', $idprestamo)
        ->orderBy('tbl_abonos.semana','ASC')
        ->get();

        $pdf = PDF::loadView('cliente.pdf_abono',['region_zona'=>$region_zona,'cliente'=>$cliente,'datosabonos'=>$datosabonos,'prestamo'=>$prestamo,'aval'=>$aval]);

        return $pdf->stream();
        
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
    public function guardar_doc_aval(Request $request){
        if ($request->hasFile('imagen')) {
            $file=$request->file('imagen');
            $name=time().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/DocImagenes/',$name);
            
        }

        // dd($request->id_socio_economico,$request->tipo_persona,$request->tipo_foto,$name);
        $Docimagen=new DocImagenes();
               
        $Docimagen = DocImagenes::create([
            'id_socio_economico'        => $request->id_socio_economico,
            'tipo_persona'      => $request->tipo_persona,
            'tipo_foto'      => $request->tipo_foto,
            'path_url'    => 'DocImagenes/'.$name,
           
        ])->save();

        
        if ($request->tipo_persona==1) {
            $descripcion='Se registró imagen de documento de prospecto';
        } else if ($request->tipo_persona==2) {
            $descripcion='Se registró imagen de documento de aval';
        }
        

        $idDoc = DocImagenes::latest('id_documento')->first();
        $fecha_hoy=Carbon::now();
        DB::table('tbl_log')->insert([
            'id_log' => null, 
            'id_tipo' => 1,
            'id_plataforma' => 2,
            'id_usuario' => Auth::user()->id,
            'id_tipo_movimiento' => 29,
            'id_movimiento' =>  $idDoc->id_documento,
            'descripcion' => $descripcion,
            'fecha_registro' => $fecha_hoy
        ]);

       

        return back()->with('status', ' Se guardó correctamente la imagen');

    }
    public function update_doc(Request $request,$id_doc){
        //dd($request,$id_doc);
       

       if ($request->hasFile('imagen')) {
           
           $request->validate([
               'imagen'=> 'required|mimes:jpeg,png,jpg'
           ]);


           $file=$request->file('imagen');
           $name=time().'_'.$file->getClientOriginalName();
           $file->move(public_path().'/DocImagenes/',$name);

           // dd($request->id_socio_economico,$name);
       
           $id_socio=$request->id_socio_economico;
               
           $Docimagen = DocImagenes::where('id_documento','=',$id_doc)
           ->where('id_socio_economico','=',$id_socio)
           ->update([
               'path_url'    => 'DocImagenes/'.$name,
           ]);

           $fecha_hoy=Carbon::now();
           DB::table('tbl_log')->insert([
               'id_log' => null, 
               'id_tipo' => 2,
               'id_plataforma' => 2,
               'id_usuario' => Auth::user()->id,
               'id_tipo_movimiento' => 29,
               'id_movimiento' =>  $id_doc,
               'descripcion' => "Se actualizó imagen de documento",
               'fecha_registro' => $fecha_hoy
           ]);

           return back()->with('status', '¡Se actualizó la imagen correctamente!');
           
       }else{
           return back()->with('danger', '¡Seleccione una imagen porfavor!');
       }

   }

    

}
