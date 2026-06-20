<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(){
        Session::flush();

        Auth::logout();
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'Sesión cerrada exitosamente',
            'autoCierre' => 'true'
        ]);
        return redirect()->to('/login');
    }
}
