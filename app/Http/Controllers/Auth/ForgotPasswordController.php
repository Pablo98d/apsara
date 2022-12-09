<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function postEmail(Request $request){
        $request->validate([
            'email'=>'required|email|exists:tbl_usuarios',
        ]);
        $token = Str::random(60);
        DB::table('password_resets')->insert(
            ['email'=>$request->email,'token'=>$token, 'created_at'=>Carbon::now()]
        );

        Mail::send('auth.password.verify',['token'=>$token], function($message) use ($request) {
            $message->from($request->email);
            // $message->sender('john@johndoe.com', 'John Doe');
            $message->to('soporte.laferiecita@gmail.com');
            // $message->cc('john@johndoe.com', 'John Doe');
            // $message->bcc('john@johndoe.com', 'John Doe');
            // $message->replyTo('john@johndoe.com', 'John Doe');
            $message->subject('Reestablecimiento de contraseña');
            // $message->priority(3);
            // $message->attach('pathToFile');

        });
        return back()->with('message','¡Hemos enviado su enlace de restablecimiento de contraseña por correo electrónico!');
    }


    use SendsPasswordResetEmails;
}
