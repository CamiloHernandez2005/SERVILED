<?php

namespace App\Http\Controllers;

use App\Imports\SubcategoryImport;
use App\Models\SubCategory;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

/**
 * Class SubCategoryController
 * @package App\Http\Controllers
 */
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        $subCategories = SubCategory::all();

        return view('sub-category.indexAll', compact('subCategories'));
    }

    public function index()
    {
        $subCategories = SubCategory::where('category_id', Session::get("category_id") )->get();

        return view('sub-category.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subCategory = new SubCategory();
        return view('sub-category.create' , compact('subCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos = [
                'name' => 'required|string|max:100|unique:sub_categories,name,',
                'description' => 'required|max:100',
        ];
        $mensaje = [
            'name.required'=>'Escriba el nombre de la Subcategoría',
            'name.unique'=>'Esta Subcategoría ya existte!',
            'description.required'=>'Escriba una breve descripción',
        ];
        $this->validate($request, $campos, $mensaje);
        $subCategory = new SubCategory($request->all());
        $subCategory->category_id = Session::get("category_id");
        $subCategory->save();
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'La subcategoría se ha creado exitosamente',
            'autoCierre' => 'true'
        ]);
         return redirect()->route('categorySub.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subCategory = SubCategory::find($id);

        return view('sub-category.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subCategory = SubCategory::find($id);

        return view('sub-category.edit', compact('subCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  SubCategory $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory, $id)
    {
        $campos = [
            'name' => 'required|string|max:100|unique:sub_categories,name,' . $id,
            'description' => 'required|max:100',
    ];
    $mensaje = [
        'name.required'=>'Escriba el nombre de la Subcategoría',
        'name.unique'=>'Esta Subcategoría ya existte!',
        'description.required'=>'Escriba una breve descripción',
    ];
        $this->validate($request, $campos, $mensaje);
        $subCategory = SubCategory::find($id);
        $subCategory->update($request->all());
        $subCategory->save();
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'La subcategoría se ha modificado exitosamente',
            'autoCierre' => 'true'
        ]);
        return redirect()->route('categorySub.index');
        }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::find($id);
        if ($subCategory->status == 1) {
            SubCategory::where('id', $subCategory->id)
                ->update([
                    'status' => 0
                ]);
                Session::flash('notificacion', [
                    'tipo' => 'exito',
                    'titulo' => 'Éxito!',
                    'descripcion' => 'La subcategoría se ha inactivado',
                    'autoCierre' => 'true'
                ]);
        } else {
            SubCategory::where('id', $subCategory->id)
                ->update([
                    'status' => 1
                ]);
                Session::flash('notificacion', [
                    'tipo' => 'exito',
                    'titulo' => 'Éxito!',
                    'descripcion' => 'La subcategoría se ha activado',
                    'autoCierre' => 'true'
                ]);
        }
        
        return redirect()->route('categorySub.index');
    }

    public function importSubcategory(Request $request){
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
            return redirect()->route('indexAll');
        }
        try {
            $file = $request->file('import_file');

            Excel::import(new SubcategoryImport, $file, 'xlsx');
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Éxito!',
                'descripcion' => 'Los datos se han agregado exitosamente',
                'autoCierre' => 'true'
            ]);
            return redirect()->route('indexAll');
        }catch (\Exception $e){
            Excel::import(new SubcategoryImport, $file, 'xlsx');
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => 'Los datos no se han agregado exitosamente',
                'autoCierre' => 'true'
            ]);
            return redirect()->route('indexAll');
        }
    }
}
