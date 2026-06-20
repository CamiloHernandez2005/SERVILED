<?php

namespace App\Http\Controllers;

use App\Imports\BrandsImport;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

/**
 * Class BrandController
 * @package App\Http\Controllers
 */
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::paginate();

        return view('brand.index', compact('brands'))
            ->with('i', (request()->input('page', 1) - 1) * $brands->perPage());
    }

    public function importbrands(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => 'required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => 'Archivo incorrecto, debe de ser de extensión xlsx o excel.',
                'autoCierre' => 'true'
            ]);
            return redirect()->route('brand.index');
        }
        try {
            $file = $request->file('import_file');

            Excel::import(new BrandsImport, $file, 'xlsx');
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Éxito!',
                'descripcion' => 'Los datos se han agregado exitosamente',
                'autoCierre' => 'true'
            ]);
            return redirect()->route('brand.index');
        } catch (\Exception $e) {
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => 'Los datos no se han agregado exitosamente, verifique el archivo de excel',
                'autoCierre' => 'true'
            ]);
            return redirect()->to('brand.index');
        }
    }
}
