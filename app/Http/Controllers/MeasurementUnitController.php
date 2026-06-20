<?php

namespace App\Http\Controllers;

use App\Imports\UnitsImpot;
use App\Models\MeasurementUnit;
use Illuminate\Http\Request;



/**
 * Class MeasurementUnitController
 * @package App\Http\Controllers
 */
class MeasurementUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $measurementUnits = MeasurementUnit::paginate();

        return view('measurement-unit.index', compact('measurementUnits'))
            ->with('i', (request()->input('page', 1) - 1) * $measurementUnits->perPage());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => 'required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => 'Archivo incorrecto, debe de ser de extensión xlsx.',
                'autoCierre' => 'true'
            ]);
            return redirect()->route('units.index');
        }
        try {
            $file = $request->file('import_file');

            Excel::import(new UnitsImpot, $file, 'xlsx');
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Éxito!',
                'descripcion' => 'Los datos se han agregado exitosamente',
                'autoCierre' => 'true'
            ]);
            return redirect()->route('units.index');
        } catch (\Exception $e) {
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => 'Los datos no se han agregado exitosamente, verifique el archivo de excel',
                'autoCierre' => 'true'
            ]);
            return redirect()->to('units.index');
        }
    }

    public function import()
    {
        return view('measurement-unit.importUnits');
    }
}
