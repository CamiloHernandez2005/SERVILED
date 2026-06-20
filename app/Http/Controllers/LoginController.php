<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    //Ingreso de la pagina
    public function show(){
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        $credentials = $request->getCredentials();

        //Validacion si el correo electronico existe en la BD

        $user = User::where('email', $credentials['email'])->first();
        if(!$user){
            return redirect()->back()->withErrors([
                'email' => 'El correo electronico no está registrado.',
            ])->withInput();
        }

        if(!Auth::validate($credentials)) {
            return redirect()->back()->withErrors([
                'password' => __('auth.password'),
            ])->withInput();
        }

        Auth::login($user);

        return $this->authenticated($request, $user);
    }
    public function authenticated(Request $request, $user){
        return redirect('/home');
    }
}
