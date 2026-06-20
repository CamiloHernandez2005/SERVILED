<?php

namespace App\Livewire;

use App\Models\MeasurementUnit;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class UnitsComponent extends Component
{
    use LivewireAlert;
    public $search = '';
    public $Id, $name, $code;

    protected $rules = [
        'code' => 'required|max:50',
        'name' => 'required|max:50'
    ];

    public function render()
    {
        $units = MeasurementUnit::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orWhere('status', 'like', '%' . $this->search . '%')
            ->get();
        return view('livewire.units-component', compact('units'));
    }

    public function store()
    {
        $this->validate(
            [
                'code' => 'required|string|max:50|unique:measurement_units,code,',
                'name' => 'required|string|max:50'
            ],
            [
                'code.required' => 'El codigo es requerido',
                'code.unique' => 'El codigo ya existe!',
                'name.required' => 'El nombre es requerido'
            ]
        );

        $unit = new MeasurementUnit();
        $unit->name = $this->name;
        $unit->code = $this->code;
        $unit->save();
        $this->clear();
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'La unidad se ha creado exitosamente.',
            'autoCierre' => 'true'
        ]);
        return redirect()->to('units');
    }

    public function clear()
    {
        $this->name = '';
        $this->code = '';
    }

    public function limpiar($id){
        $this->reset(['name', 'code']);
        return redirect()->to('units');
    }

    public function edit($id)
    {
        $unit = MeasurementUnit::find($id);
        $this->clear();
        $this->Id = $unit->id;
        $this->name = $unit->name;
        $this->code = $unit->code;
    }

    public function update($id)
    {
        $this->validate(
            [
                'code' => 'required|string|max:50|unique:measurement_units,code,' . $id,
                'name' => 'required|string|max:50'
            ],
            [
                'code.required' => 'El codigo es requerido',
                'code.unique' => 'El codigo ya existe!',
                'name.required' => 'El nombre es requerido'
            ]
        );
        $unit = MeasurementUnit::find($id);
        $unit->name = $this->name;
        $unit->code = $this->code;
        $unit->save();
        $this->clear();
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'La unidad se ha modificado exitosamente.',
            'autoCierre' => 'true'
        ]);
        return redirect()->to('units');
    }


    public function delete($id)
    {
        try {
            $unit = MeasurementUnit::findOrFail($id);

            // Verificar si la unidad está asociada a otra tabla
            $associatedProductsCount = $unit->products()->count();

            if ($unit->status == true && $associatedProductsCount > 0) {
                // Si la unidad está activa y hay productos asociados, mostrar la alerta
                Session::flash('notificacion', [
                    'tipo' => 'error',
                    'titulo' => 'Error!',
                    'descripcion' => 'No se puede inactivar la unidad porque está asociada a productos.',
                    'autoCierre' => 'true'
                ]);
            } else {
                // Si no hay productos asociados o si la unidad está inactiva, actualizar el estado de la unidad
                $unit->status = !$unit->status;
                $unit->save();

                // Mostrar la alerta de acuerdo al estado de la unidad
                if ($unit->status == true) {
                    Session::flash('notificacion', [
                        'tipo' => 'exito',
                        'titulo' => 'Exito!',
                        'descripcion' => 'La unidad se ha activado exitosamente.',
                        'autoCierre' => 'true'
                    ]);
                } else {
                    Session::flash('notificacion', [
                        'tipo' => 'error',
                        'titulo' => 'Atencion!',
                        'descripcion' => 'La unidad se ha inactivado exitosamente.',
                        'autoCierre' => 'true'
                    ]);
                }
            }
        } catch (ValidationException $e) {
            // Manejar la excepción de validación, mostrar el mensaje de error
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => $e->validator->errors()->first('unidad_asociada'),
                'autoCierre' => 'true'
            ]);
        } catch (ModelNotFoundException $e) {
            // Manejar la excepción de no encontrar el modelo
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => 'La Unidad que intentas eliminar no existe.',
                'autoCierre' => 'true'
            ]);
        }

        return redirect()->to('units');
    }
}
