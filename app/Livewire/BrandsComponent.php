<?php

namespace App\Livewire;

use App\Models\Brand;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;


class BrandsComponent extends Component
{
    use LivewireAlert;
    public $search='';
    public $Id, $name, $code, $abbrevation;

    protected $rules = [
        'name' => 'required|max:50',
        'code' => 'required|max:50',
        'abbrevation' => 'required|max:50'
    ];


    public function render()
    {
        $brands = Brand::where('name','like', '%'.$this->search.'%')
                        ->orWhere('code', 'like', '%' . $this->search . '%')
                        ->orWhere('abbrevation', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%')
                        ->get();
        return view('livewire.brands-component', compact('brands'));
    }

    public function store(){
        $this->validate([
            'name' => 'required|string|max:50|unique:brands,name',
            'code' => 'required|string|max:50|unique:brands,code',
            'abbrevation' => 'required|string|max:50|unique:brands,abbrevation'
        ],[
            'abbrevation.required' => 'La abreviación es requerida',
            'abbrevation.unique' => 'La abreviación ya exite!',
            'name.required' => 'El nombre es requerido',
            'name.unique' => 'La marca ya existe!',
            'code.required' => 'El codigo es requerido',
            'code.unique' => 'El codigo ya existe!',
        ]);
        $brand = New Brand();
        $brand->name = $this -> name;
        $brand->code = $this -> code;
        $brand->abbrevation = $this ->abbrevation;
        $brand->save();
        $this->clear();
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'La marca se ha creado exitosamente',
            'autoCierre' => 'true'
        ]);
        return redirect()->to('brand');
    }

    public function clear(){
        $this->name='';
        $this->code='';
        $this->abbrevation='';
    }

    public function limpiar($id){
        $this->reset(['name', 'code', 'abbrevation']);
        return redirect()->to('brand');
    }
    
    public function edit($id){
        $brand = Brand::find($id);
        $this->clear();
        $this->Id = $brand->id;
        $this->name = $brand->name;
        $this->code = $brand->code;
        $this->abbrevation = $brand->abbrevation;
    }

    public function update($id){
        $this->validate([
            'name' => 'required|max:50|unique:brands,name,' . $id,
            'code' => 'required|max:50|unique:brands,code,' . $id,
            'abbrevation' => 'required|max:50|unique:brands,abbrevation,' . $id,
        ],[
            'abbrevation.required' => 'La abreviación es requerida',
            'abbrevation.unique' => 'La abreviación ya exite!',
            'name.required' => 'El nombre es requerido',
            'name.unique' => 'La marca ya existe!',
            'code.required' => 'El codigo es requerido',
            'code.unique' => 'El codigo ya existe!',
        ]);
        $brand = Brand::find($id);
        $brand->name = $this->name;
        $brand->code = $this -> code;
        $brand->abbrevation = $this ->abbrevation;
        $brand->save();
        $this->clear();
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'La marca se ha modificado exitosamente',
            'autoCierre' => 'true'
        ]);
        return redirect()->to('brand');
    }
    
    public function delete($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Verificar si la unidad está asociada a otra tabla
            $associatedProductsCount = $brand->products()->count();

            if ($brand->status == true && $associatedProductsCount > 0) {
                // Si la unidad está activa y hay productos asociados, mostrar la alerta
                Session::flash('notificacion', [
                    'tipo' => 'error',
                    'titulo' => 'Error!',
                    'descripcion' => 'No se puede inactivar la marca porque está asociada a productos.',
                    'autoCierre' => 'true'
                ]);
            } else {
                // Si no hay productos asociados o si la unidad está inactiva, actualizar el estado de la unidad
                $brand->status = !$brand->status;
                $brand->save();

                // Mostrar la alerta de acuerdo al estado de la unidad
                if ($brand->status == true) {
                    Session::flash('notificacion', [
                        'tipo' => 'exito',
                        'titulo' => 'Exito!',
                        'descripcion' => 'La marca se ha activado exitosamente.',
                        'autoCierre' => 'true'
                    ]);
                } else {
                    Session::flash('notificacion', [
                        'tipo' => 'error',
                        'titulo' => 'Atencion!',
                        'descripcion' => 'La marca se ha inactivado exitosamente.',
                        'autoCierre' => 'true'
                    ]);
                }
            }
        } catch (ValidationException $e) {
            // Manejar la excepción de validación, mostrar el mensaje de error
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => $e->validator->errors()->first('marca_asociada'),
                'autoCierre' => 'true'
            ]);
        } catch (ModelNotFoundException $e) {
            // Manejar la excepción de no encontrar el modelo
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => 'La marca que intentas eliminar no existe.',
                'autoCierre' => 'true'
            ]);
        }

        return redirect()->to('brand');
    }
}
