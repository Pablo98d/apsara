<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ArticulosHogarExport;
use App\ArticulosHogar;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ArticulosHogarController extends Controller
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
        $articuloshogar = DB::table('tbl_se_articulos_hogar')
            ->Join('tbl_socio_economico', 'tbl_se_articulos_hogar.id_socio_economico', '=', 'tbl_socio_economico.id_socio_economico')
            ->select('tbl_se_articulos_hogar.*', 'tbl_socio_economico.id_usuario')
            ->get();
        return view('admin.articuloshogar.index',compact('articuloshogar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.articuloshogar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        return view('admin.articuloshogar.create',['soci'=>$soci,'idSocio'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articuloshogar=ArticulosHogar::findOrFail($id);
        return view('admin/articuloshogar/edit', compact('articuloshogar'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        articuloshogar::destroy($id);
        return redirect()->route('articuloshogar.index');
    }
    public function export(){
        return Excel::download(new ArticulosHogarExport, 'Articulos_del_hogar.xlsx');
    }

    public function guardar_garantias(Request $request){

        $http = new \GuzzleHttp\Client; // Cliente http

        try {

            if ($request->id_garantia != null || $request->id_garantia != '' || !empty($request->id_garantia)) {
                // dd('iioiioioioii');
                if ($request->hasFile('foto_garantia')) {
                    $file_temporal = base64_encode(file_get_contents($request->file('foto_garantia')));
                    // if ($request->foto_garantia != null || $request->foto_garantia != '' || !empty($request->foto_garantia)) {

                    //     $foto=$request->foto_garantia;

                    $response = $http->post('http://laferiecita.com/documentos/set_foto_garantia.php', [
                        'form_params' => [
                            'foto' => $file_temporal
                        ]
                    ]); // Enviamos la foto al webservices
        
                    $data = $response->getBody(); // Recuperamos la respuesta
                    $jsonData = json_decode($data, true); // Damos formato json a la respuesta

                    if ($jsonData['status'] != 200) {
                        $id_garantia = DB::table('tbl_se_garantias')
                            ->where('id_garantia', $request->id_garantia)
                            ->update([
                                //'id_garantia' => $request->id_garantia, 
                                // 'id_socio_economico' => $request->id_socio_economico,
                                'tipo_garantia' => $request->id_articulo,
                                'marca' => $request->marca_articulo,
                                'modelo' => $request->modelo_articulo,
                                'descripcion' => $request->descripcion_articulo,
                                'foto' => $jsonData['path_foto'],
                            ]); // Insertamos la información de la garantía
                            $fecha_hoy=Carbon::now();
                            DB::table('tbl_log')->insert([
                                'id_log' => null, 
                                'id_tipo' => 2,
                                'id_plataforma' => 2,
                                'id_usuario' => Auth::user()->id,
                                'id_tipo_movimiento' => 32,
                                'id_movimiento' =>  $request->id_garantia,
                                'descripcion' => "Se actualizó foto/datos de garantía",
                                'fecha_registro' => $fecha_hoy
                            ]);

                            return back()->with('status', '¡Garantía actualizada con éxito.!');
                        // return json_encode(array('results' => ['status' => 100, 'mensaje' => "Garantía actualizada con éxito."]), JSON_UNESCAPED_UNICODE);
                    }
                    return back()->with('error', 'Hubo un error durante el proceso de actualización de la foto. Intente de nuevo.');
                    // return json_encode(array('results' => ['status' => 200, 'mensaje' => "Hubo un error durante el proceso de actualización de la foto. Intente de nuevo."]), JSON_UNESCAPED_UNICODE);

                }
                // dd('kkjkjkjkjjk');
                $id_garantia = DB::table('tbl_se_garantias')
                    ->where('id_garantia', $request->id_garantia)
                    ->update([
                        //'id_garantia' => $request->id_garantia, 
                        // 'id_socio_economico' => $request->id_socio_economico,
                        'tipo_garantia' => $request->id_articulo,
                        'marca' => $request->marca_articulo,
                        'modelo' => $request->modelo_articulo,
                        'descripcion' => $request->descripcion_articulo,
                        //'foto' => $jsonData['path_foto'],
                    ]); // Insertamos la información de la garantía
                    $fecha_hoy=Carbon::now();
                    DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 2,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 32,
                        'id_movimiento' =>  $request->id_garantia,
                        'descripcion' => "Se actualizó datos de garantía",
                        'fecha_registro' => $fecha_hoy
                    ]);
                    
                    return back()->with('status', '¡No se encontró nueva foto, solo se actualizó los datos de garantía con éxito!');
                // return json_encode(array('results' => ['status' => 100, 'mensaje' => "Garantía actualizada con éxito."]), JSON_UNESCAPED_UNICODE);
            }
            
            if ($request->hasFile('foto_garantia')) {
                $file_temporal = base64_encode(file_get_contents($request->file('foto_garantia')));


                $response = $http->post('http://laferiecita.com/documentos/set_foto_garantia.php', [
                    'form_params' => [
                        'foto' => $file_temporal
                    ]
                ]); // Enviamos la foto al webservices
    
                $data = $response->getBody(); // Recuperamos la respuesta
                $jsonData = json_decode($data, true); // Damos formato json a la respuesta
    
                if ($jsonData['status'] != 200) { // Validamos si hay path de foto
                    //return $jsonData['path_foto'];
                    // Ya obteniendo el path de la foto continuamos con el proceso de la carga de información de la garantía
                    $id_garantia = DB::table('tbl_se_garantias')->insertGetId(
                        [
                            'id_garantia' => null, 
                            'id_socio_economico' => $request->id_socio_economico,
                            'tipo_garantia' => $request->id_articulo,
                            'marca' => $request->marca_articulo,
                            'modelo' => $request->modelo_articulo,
                            'descripcion' => $request->descripcion_articulo,
                            'foto' => $jsonData['path_foto'],
                            
                        ]
                    ); // Insertamos la información de la garantía

                    $fecha_hoy=Carbon::now();
                    DB::table('tbl_log')->insert([
                        'id_log' => null, 
                        'id_tipo' => 1,
                        'id_plataforma' => 2,
                        'id_usuario' => Auth::user()->id,
                        'id_tipo_movimiento' => 32,
                        'id_movimiento' =>  $id_garantia,
                        'descripcion' => "Se registró una nueva garantia",
                        'fecha_registro' => $fecha_hoy
                    ]);
    
                    return back()->with('status', '¡Garantía guardado con éxito!');
                    // return json_encode(array('results' => ['status' => 100, 'mensaje' => "Garantía guardado correctamente."]), JSON_UNESCAPED_UNICODE);
    
                }

            }
            
            return back()->with('error', 'Hubo un error durante el proceso de carga de la foto. Intente de nuevo.');
            // return json_encode(array('results' => ['status' => 200, 'mensaje' => "Hubo un error durante el proceso de carga de la foto. Intente de nuevo."]), JSON_UNESCAPED_UNICODE);

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return back()->with('error', 'Hubo un error de petición al WS. Intente de nuevo.');
            // return json_encode(array('results' => ['status' => 200, 'mensaje' => "Hubo un error de petición al WS. Intente de nuevo."]), JSON_UNESCAPED_UNICODE);
        }
            return back()->with('error', 'Hubo un error durante el proceso. Intente de nuevo.');
        // return json_encode(array('results' => ['status' => 200, 'mensaje' => "Hubo un error durante el proceso. Intente de nuevo."]), JSON_UNESCAPED_UNICODE);

      
    }


    public function eliminar_garantia(Request $request){
        
        // dd($request->all());
        DB::table('tbl_se_garantias')->where('id_garantia', '=', $request->id_garantia)->delete();

        $fecha_hoy=Carbon::now();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 3,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 32,
                'id_movimiento' =>  $request->id_garantia,
                'descripcion' => "Se eliminó una garantía",
                'fecha_registro' => $fecha_hoy
            ]);
            return back()->with('status', '¡Garantía eliminado con éxito!');
    }

    public function setGarantia(Request $request) {
        $http = new \GuzzleHttp\Client; // Cliente http

        try {

            if ($request->id_garantia != null || $request->id_garantia != '' || !empty($request->id_garantia)) {

                if ($request->foto != null || $request->foto != '' || !empty($request->foto)) {

                    $response = $http->post('http://laferiecita.com/documentos/set_foto_garantia.php', [
                        'form_params' => [
                            'foto' => $request->foto
                        ]
                    ]); // Enviamos la foto al webservices
        
                    $data = $response->getBody(); // Recuperamos la respuesta
                    $jsonData = json_decode($data, true); // Damos formato json a la respuesta

                    if ($jsonData['status'] != 200) {
                        $id_garantia = DB::table('tbl_se_garantias')
                            ->where('id_garantia', $request->id_garantia)
                            ->update([
                                //'id_garantia' => $request->id_garantia, 
                                'id_socio_economico' => $request->id_socio_economico,
                                'tipo_garantia' => $request->tipo_garantia,
                                'marca' => $request->marca,
                                'modelo' => $request->modelo,
                                'descripcion' => $request->descripcion,
                                'foto' => $jsonData['path_foto'],
                            ]); // Insertamos la información de la garantía

                        return json_encode(array('results' => ['status' => 100, 'mensaje' => "Garantía actualizada con éxito."]), JSON_UNESCAPED_UNICODE);
                    }

                    return json_encode(array('results' => ['status' => 200, 'mensaje' => "Hubo un error durante el proceso de actualización de la foto. Intente de nuevo."]), JSON_UNESCAPED_UNICODE);

                }

                $id_garantia = DB::table('tbl_se_garantias')
                    ->where('id_garantia', $request->id_garantia)
                    ->update([
                        //'id_garantia' => $request->id_garantia, 
                        'id_socio_economico' => $request->id_socio_economico,
                        'tipo_garantia' => $request->tipo_garantia,
                        'marca' => $request->marca,
                        'modelo' => $request->modelo,
                        'descripcion' => $request->descripcion,
                        //'foto' => $jsonData['path_foto'],
                    ]); // Insertamos la información de la garantía

                return json_encode(array('results' => ['status' => 100, 'mensaje' => "Garantía actualizada con éxito."]), JSON_UNESCAPED_UNICODE);
            }

            $response = $http->post('http://laferiecita.com/documentos/set_foto_garantia.php', [
                'form_params' => [
                    'foto' => $request->foto
                ]
            ]); // Enviamos la foto al webservices

            $data = $response->getBody(); // Recuperamos la respuesta
            $jsonData = json_decode($data, true); // Damos formato json a la respuesta

            if ($jsonData['status'] != 200) { // Validamos si hay path de foto
                //return $jsonData['path_foto'];
                // Ya obteniendo el path de la foto continuamos con el proceso de la carga de información de la garantía
                $id_garantia = DB::table('tbl_se_garantias')->insertGetId(
                    [
                        'id_garantia' => null, 
                        'id_socio_economico' => $request->id_socio_economico,
                        'tipo_garantia' => $request->tipo_garantia,
                        'marca' => $request->marca,
                        'modelo' => $request->modelo,
                        'descripcion' => $request->descripcion,
                        'foto' => $jsonData['path_foto'],
                    ]
                ); // Insertamos la información de la garantía

                return json_encode(array('results' => ['status' => 100, 'mensaje' => "Garantía guardado correctamente."]), JSON_UNESCAPED_UNICODE);

            }

            return json_encode(array('results' => ['status' => 200, 'mensaje' => "Hubo un error durante el proceso de carga de la foto. Intente de nuevo."]), JSON_UNESCAPED_UNICODE);

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return json_encode(array('results' => ['status' => 200, 'mensaje' => "Hubo un error de petición al WS. Intente de nuevo."]), JSON_UNESCAPED_UNICODE);
        }

        return json_encode(array('results' => ['status' => 200, 'mensaje' => "Hubo un error durante el proceso. Intente de nuevo."]), JSON_UNESCAPED_UNICODE);

    }


    public function guardar_garantia(Request $request){
      
        if ($request->hasFile('foto_garantia')) {
            $file=$request->file('foto_garantia');
            $name=time().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/socio_economico/garantias/',$name);
            
            $id_garantia = DB::table('tbl_se_garantias')->insertGetId(
                [
                    'id_socio_economico' => $request->id_socio_economico,
                    'propietario' => $request->propietario,
                    'tipo_garantia' => $request->tipo_garantia,
                    'descripcion' => $request->descripcion,
                    'foto' => 'socio_economico/garantias/'.$name,
                ]
            ); // Insertamos la información de la garantía
    
            $fecha_hoy=Carbon::now();
            DB::table('tbl_log')->insert([
                'id_log' => null, 
                'id_tipo' => 1,
                'id_plataforma' => 2,
                'id_usuario' => Auth::user()->id,
                'id_tipo_movimiento' => 32,
                'id_movimiento' =>  $id_garantia,
                'descripcion' => "Se registró una nueva garantia",
                'fecha_registro' => $fecha_hoy
            ]);
            return back()->with('status', '¡Garantía agregado con éxito!');
        }
        return back()->with('danger', '¡Selecciona una imagen porfavor!');


    }


}


