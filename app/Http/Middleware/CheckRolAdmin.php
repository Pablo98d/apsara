<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;


use Closure;

class CheckRolAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = Auth::user()->id_tipo_usuario;
        if ($role=='1') {
            return $next($request);
        } else if ($role=='6') {
            return $next($request);
        } elseif($role=='3'){
            return 'homecliente';
        } else{
            return redirect('/');
        }

        
    }
}
