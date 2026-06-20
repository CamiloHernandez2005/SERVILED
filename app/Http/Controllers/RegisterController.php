<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    //

    public function show(){
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('auth.login');
    }

    public function register(RegisterRequest $request){
        try {
            $user = User::create($request->validated());
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Éxito!',
                'descripcion' => 'Se ha creado el usuario correctamente.',
                'autoCierre' => 'true'
            ]);
            //Asignar el rol de administrador para el primer registro dentro del proyecto.
            if (User::count() === 1) {
                $user->assignRole('Administrador');
            }
            return redirect('/login');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
