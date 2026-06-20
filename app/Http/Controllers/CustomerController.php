<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // DataTables maneja búsqueda, orden y paginación en el navegador,
        // por eso traemos todos los clientes (con su municipio para evitar N+1).
        $clientes = Person::where('rol', 'Cliente')
            ->with('municipality')
            ->get();

        return view('customer.index', [
            'clientes' => $clientes
        ]);
    }

    public function edit($id)
    {
        $person = Person::findOrFail($id);
        $municipalities = Municipality::with('department.country')->get();
        $table = 'customer';
        return view('person.edit', compact('person', 'table','municipalities'));
    }

    public function update(Request $request, Person $person)
    {
        $data = $request->all();
        $data['id'] = $person->id;
        

        $rules = Person::staticRules($data);

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // request()->validate(Person::staticRules($data));

        $person->update($request->all());

        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'La persona se ha modificado exitosamente.',
            'autoCierre' => 'true'
        ]);

        return redirect()->route('customer.index');
    }

    public function show($id)
    {
        $person = Person::findOrFail($id);
        $table = 'customer';
        return view('person.show', compact('person', 'table'));
    }

    public function destroy($id)
    {
        $clientes = Person::find($id);

        if ($clientes->status == true) {
            Person::where('id', $clientes->id)
                ->update([
                    'status' => false,
                ]);
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Atencion!',
                'descripcion' => 'La persona se ha inactivado.',
                'autoCierre' => 'true'
            ]);
        } else {
            Person::where('id', $clientes->id)
                ->update([
                    'status' => true,
                ]);
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Exito!',
                'descripcion' => 'La persona se activado.',
                'autoCierre' => 'true'
            ]);
        }

        return redirect()->route('customer.index');
    }
    public function pdf()
    {
        $clientes = Person::where('rol','Cliente')->get();

        $pdf = Pdf::loadView('customer.pdf', ['clientes' => $clientes])
                    ->setPaper('a4','landscape');

        // Funcion para devolver una vista del pdf en el navegador
        return $pdf->stream('Clientes.pdf');

        //Descargar el pdf directamente
        // return $pdf->download('Informe de Clientes.pdf');
    }
}
