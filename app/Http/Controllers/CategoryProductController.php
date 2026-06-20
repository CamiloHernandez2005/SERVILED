<?php

namespace App\Http\Controllers;

use App\Imports\CategoryImport;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

/**
 * Class CategoryProductController
 * @package App\Http\Controllers
 */
class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category-product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryProduct = new CategoryProduct();
        return view('category-product.create', compact('categoryProduct'));
    }

    public function importCategory(Request $request)
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
            return redirect()->route('category.index');
        }
        try {
            $file = $request->file('import_file');

            Excel::import(new CategoryImport, $file, 'xlsx');
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Éxito!',
                'descripcion' => 'Categorías Agregadas Correctamente!',
                'autoCierre' => 'true'
            ]);
            return redirect()->route('category.index');
        } catch (\Exception $e) {
        }
    }

    public function subCategories(categoryProduct $categoryProduct)
    {
        return response()->json($categoryProduct->subCategories);
    }
}
