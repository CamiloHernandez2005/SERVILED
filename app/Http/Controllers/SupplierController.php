<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        // DataTables maneja búsqueda, orden y paginación en el navegador,
        // por eso traemos todos los proveedores (con su municipio para evitar N+1).
        $proveedores = Person::where('rol', 'Proveedor')
            ->with('municipality')
            ->get();

    return view('supplier.index', [
        'proveedores' => $proveedores
    ]);


        $proveedores = Person::where('rol','Proveedor')->get();
        return view('supplier.index', compact('proveedores'));
    }

    public function edit($id)
    {
        $person = Person::with('municipality')->findOrFail($id);
        $municipalities = Municipality::with('department.country')->get();
        $table = 'supplier';

        return view('person.edit', compact('person', 'municipalities', 'table'));
    }

public function show($id)
    {
        $person = Person::findOrFail($id);
        $table = 'supplier';
        return view('person.show', compact('person', 'table'));
    }
    // Funcion para inactivar un proveedor
    public function destroy($id)
    {
        $proveedores = Person::find($id);

        if ($proveedores->status == true) {
            Person::where('id', $proveedores->id)
                ->update([
                    'status' => false,
                ]);
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Atención!',
                'descripcion' => 'La persona se ha inactivado.',
                'autoCierre' => 'true'
            ]);
        } else {
            Person::where('id', $proveedores->id)
                ->update([
                    'status' => true,
                ]);
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Exito!',
                'descripcion' => 'La persona se  ha activado.',
                'autoCierre' => 'true'
            ]);
        }


        return redirect()->route('supplier.index');
    }

    public function pdf()
    {
        $proveedores = Person::where('rol','Proveedor')->get();

        $pdf = Pdf::loadView('supplier.pdf', ['proveedores' => $proveedores])
        ->setPaper('a4','landscape');

        // Funcion para devolver una vista del pdf en el navegador
        return $pdf->stream('Proveedores.pdf');

        //Descargar el pdf directamente
        // return $pdf->download('Informe de Proveedores.pdf');
    }
}
