<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\AvalExport;
use App\DocImagenes;
use App\Se_Aval;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DocImagenesController extends Controller
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

    public function guardar_doc_prospecto(){
        dd('Hola ya estas en la funcion de guardar doc prospecti');
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
