<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class InicioController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth','rol.admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guest()){
            // dd('klkk');
            // dd('lakslaklsklas');
            return redirect('/login');
            // return redirect('/index');
        }else{
            return redirect('/home');
        }
        // return view('bienvenido_a_feriecita');
    }

    public function inicio(){
        $imagenes_carrousel = DB::table('tbl_inicio_app')
        ->select('tbl_inicio_app.*')
        ->where('tipo_imagen','=',2)
        ->get();

        return view('landing.index',['imagenes_carrousel'=>$imagenes_carrousel]);
    }
    public function nosotros(){
        return view('landing.nosotros');
    }
    public function articulo_1(){
        return view('landing.articulo1');
    }

    public function articulo_2(){
        return view('landing.articulo2');
    }
    public function articulo_3(){
        return view('landing.articulo3');
    }
    public function centro_ayuda(){
        return view('landing.centroayuda');
    }
    
}
