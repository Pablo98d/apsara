<?php

namespace App\Http\Controllers\promotora;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromotoraMiPerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','rol.promo']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('promotora/promotoramiperfil.index');
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
       return view('promotora/promotoramiperfil')->with('usuario', $usuario);
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
        $usuario = User::find(Auth::User()->id);
       if(empty($usuario)){
          Flash::error('mensaje error');
          return redirect()->back();
       }
       $usuario->fill($request->all());
       $usuario->save();
       Flash::success('Perfil actualizado con éxito.');
       return redirect(route('homepromotora'));
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
}
