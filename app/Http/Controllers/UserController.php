<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{

    public function register(Request $request){
        //Validar los datos
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        Auth::login($user);

        return redirect(route('privada'));
    }


    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }

    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone_number' => 'required|digits:10',
        'document_type' => 'required|string|max:3',
        'identification_number' => 'required|digits_between:7,20|unique:users,identification_number,' . $user->id,
        'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()]
    ], [], [
        'name' => 'Nombre',
        'email' => 'Correo electrónico',
        'phone_number' => 'Número de teléfono',
        'document_type' => 'Tipo de documento',
        'identification_number' => 'Número de identificación',
        'password' => 'Contraseña'
    ]);

    if ($validator->fails()) {
        $errores = $validator->errors()->all();
        foreach ($errores as $error) {
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => $error,
                'autoCierre' => 'true'
            ]);
        }
        return redirect()->route('profile.edit')->withErrors($validator)->withInput();
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone_number = $request->phone_number;
    $user->document_type = $request->document_type;
    $user->identification_number = $request->identification_number;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    Session::flash('notificacion', [
        'tipo' => 'exito',
        'titulo' => 'Exito!',
        'descripcion' => 'La Información del perfil se ha actualizado exitosamente.',
        'autoCierre' => 'true'
    ]);

    return redirect()->route('profile.index');
}


public function showChangePasswordForm()
{
    return view('profile.change_password');
}

public function changePassword(Request $request)
{
    // Validar los campos
    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => ['required', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()]
    ], [
        'new_password.confirmed' => 'La confirmacion de la nueva contraseña no coincide.'
    ]);

    $validator->setAttributeNames([
        'new_password' => 'nueva contraseña',
    ]);

    if ($validator->fails()) {
        return redirect()->route('password.update')
            ->withErrors($validator)
            ->withInput();
    }

    $user = Auth::user();

    // Verificar la contraseña actual
    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->route('password.update')
            ->withErrors(['current_password' => 'La contraseña actual no es correcta.'])
            ->withInput();
    }

    // Guardar la nueva contraseña
    $user->password = Hash::make($request->new_password);
    $user->save();

    Session::flash('notificacion', [
        'tipo' => 'exito',
        'titulo' => 'Éxito!',
        'descripcion' => 'Contraseña actualizada exitosamente.',
        'autoCierre' => 'true'
    ]);

    return redirect()->route('profile.index');
}


}
