<?php

namespace App\Http\Controllers\promotora;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomePromotoraController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','rol.promo']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $request->session()->regenerate();
        // return $request->session()->all();
        // $user = Auth::user();
        return view('promotora/homepromotora');
    }
}
