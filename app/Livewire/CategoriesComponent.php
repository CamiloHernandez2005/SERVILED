<?php

namespace App\Livewire;

use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CategoriesComponent extends Component
{
    use LivewireAlert;
    public $search='';
    public $Id, $name, $description;

    protected $rules = [
        'name' => 'required|max:50',
        'description' => 'required|max:50'
    ];

    public function render()
    {   
        $categories = CategoryProduct::where('name','like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->get();
        return view('livewire.categories-component', compact('categories'));
    }

    public function store(){
        $this->validate([
            'name' => 'required|max:50|unique:category_products,name',
            'description' => 'required|max:50'
        ],[
            'name.required' => 'El nombre es requerido',
            'name.unique' => 'Esta categoría ya existe',
            'description.required' => 'La descripción es requerida'
        ]);
        $category = New CategoryProduct();
        $category->name = $this -> name;
        $category->description = $this -> description;
        $category->save();
        $this->clear();
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'La categoría se ha creado exitosamente',
            'autoCierre' => 'true'
        ]);        return redirect()->to('category');
    }

    public function clear(){
        $this->name='';
        $this->description='';
    }

    public function limpiar($id){
        $this->reset(['name', 'description']);
        return redirect()->to('category');
    }

    public function show($id){
        Session::put("category_id", $id);
        return redirect()->route('categorySub.index');
    }

    public function edit($id){
        $category = CategoryProduct::find($id);
        $this->clear();
        $this->Id = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
    }

    public function update($id){
        $this->validate([
            'name' => 'required|max:50|unique:category_products,name,' . $id,
            'description' => 'required|max:50'
        ],[
            'name.required' => 'El nombre es requerido',
            'name.unique' => 'Esta categoría ya existe',
            'description.required' => 'La descripción es requerida'
        ]);
        $category = CategoryProduct::find($id);
        $category->name = $this->name;
        $category->description = $this->description;
        $category->save();
        $this->clear();
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'La categoría se ha modificado exitosamente',
            'autoCierre' => 'true'
        ]);        
        return redirect()->to('category');
    }
    
    public function delete($id)
    {
        try {
            $category = CategoryProduct::find($id);

            // Verificar si la unidad está asociada a otra tabla
            $associatedProductsCount = $category->products()->count();

            if ($category->status == true && $associatedProductsCount > 0) {
                // Si la unidad está activa y hay productos asociados, mostrar la alerta
                Session::flash('notificacion', [
                    'tipo' => 'error',
                    'titulo' => 'Error!',
                    'descripcion' => 'No se puede inactivar la categoría porque está asociada a productos.',
                    'autoCierre' => 'true'
                ]);
            } else {
                // Si no hay productos asociados o si la unidad está inactiva, actualizar el estado de la unidad
                $category->status = !$category->status;
                $category->save();

                // Mostrar la alerta de acuerdo al estado de la unidad
                if ($category->status == true) {
                    Session::flash('notificacion', [
                        'tipo' => 'exito',
                        'titulo' => 'Exito!',
                        'descripcion' => 'La categoría se ha activado exitosamente.',
                        'autoCierre' => 'true'
                    ]);
                } else {
                    Session::flash('notificacion', [
                        'tipo' => 'error',
                        'titulo' => 'Atencion!',
                        'descripcion' => 'La categoría se ha inactivado exitosamente.',
                        'autoCierre' => 'true'
                    ]);
                }
            }
        } catch (ValidationException $e) {
            // Manejar la excepción de validación, mostrar el mensaje de error
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => $e->validator->errors()->first('categoría_asociada'),
                'autoCierre' => 'true'
            ]);
        } catch (ModelNotFoundException $e) {
            // Manejar la excepción de no encontrar el modelo
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => 'La categoría que intentas eliminar no existe.',
                'autoCierre' => 'true'
            ]);
        }

        return redirect()->to('category');
    }
}
