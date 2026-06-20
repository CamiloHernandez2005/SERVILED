<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.usuarios.index')->only('index');
        $this->middleware('can:admin.usuarios.edit')->only('edit','update');
    }

    public function index(Request $request)
{
    // DataTables maneja búsqueda, orden y paginación en el navegador,
    // por eso traemos todos los usuarios (con sus roles para evitar N+1).
    $usuarios = User::with('roles')->get();

    return view('admin.usuarios.index', [
        'usuarios' => $usuarios,
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //Traer el usuario por medio del id
        $usuario = User::findOrFail($id);

        //Traer los roles pormedio del modelo y gurdarlos en la variable
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
    $usuario->roles()->sync($request->roles);

    Session::flash('notificacion', [
        'tipo' => 'exito',
        'titulo' => 'Éxito!',
        'descripcion' => 'Se asignaron los roles correctamente.',
        'autoCierre' => 'true'
    ]);
    return redirect()->route('admin.usuarios.index', $usuario);

    }

}
