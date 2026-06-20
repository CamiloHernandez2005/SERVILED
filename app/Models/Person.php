<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 *
 * @property $id
 * @property $rol
 * @property $identification_type
 * @property $identification_number
 * @property $person_type
 * @property $company_name
 * @property $comercial_name
 * @property $first_name
 * @property $other_name
 * @property $surname
 * @property $second_surname
 * @property $digit_verification
 * @property $email_address
 * @property $municipality_id
 * @property $address
 * @property $phone
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property Municipality $municipalities
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Person extends Model
{

    public static function staticRules($data = [])
    {
    $id = $data['id'] ?? null;

    $rules = [
        'rol' => 'required',
        'identification_type' => 'required',
        'identification_number' => 'required|string|unique:people,identification_number,' . $id,
        'person_type' => 'required',
        'company_name' => 'string|nullable',
        'comercial_name' => 'string|nullable',
        'first_name' => 'string|nullable',
        'other_name' => 'string|nullable',
        'surname' => 'string|nullable',
        'second_surname' => 'string|nullable',
        'digit_verification' => 'required_if:identification_type,NIT|nullable|string',
        'email_address' => 'required|string',
        'municipality_id' => 'required',
        'address' => 'required|string',
        'phone' => 'required|string',
        'status' => 'nullable',
    ];

    // Validación para el número de identificación
    if (isset($data['id']) && isset($data['identification_number']) && $data['identification_number'] == Person::find($data['id'])->identification_number) {
        $rules['identification_number'] = 'required|string';
    }

       // Validación para la razón social
    $person = Person::find($id);

    if (isset($data['company_name'])) {
        $existingCompanyNames = Person::where('company_name', $data['company_name'])->where('id', '!=', $id)->count();

        if ($existingCompanyNames > 0) {
            $rules['company_name'] = 'string|nullable|different:company_name,' . $id;
        } else {
            $rules['company_name'] = 'string|nullable';
        }
    }

       // Validación para el nombre comercial
    if ($person && isset($data['comercial_name']) && $data['comercial_name'] == $person->comercial_name) {
        $rules['comercial_name'] = 'string|nullable';
    } else {
        $rules['comercial_name'] = 'string|nullable|unique:people,comercial_name,' . $id;
    }

    return $rules;
    }

    /**
     * Mensajes de validación personalizados (en español).
     */
    public static function staticMessages()
    {
        return [
            'identification_number.required' => 'El campo número de identificación es obligatorio.',
            'identification_number.unique'   => 'El número de identificación ya está registrado en otro tercero.',
            'comercial_name.unique'          => 'El nombre comercial ya está registrado en otro tercero.',
        ];
    }

    /**
     * Nombres amigables de los campos para los mensajes de validación.
     */
    public static function staticAttributes()
    {
        return [
            'rol'                   => 'tercero',
            'identification_type'   => 'tipo de identificación',
            'identification_number' => 'número de identificación',
            'person_type'           => 'tipo de tercero',
            'company_name'          => 'razón social',
            'comercial_name'        => 'nombre comercial',
            'first_name'            => 'primer nombre',
            'other_name'            => 'otro nombre',
            'surname'               => 'apellido',
            'second_surname'        => 'segundo apellido',
            'digit_verification'    => 'dígito de verificación',
            'email_address'         => 'correo electrónico',
            'municipality_id'       => 'ciudad',
            'address'               => 'dirección',
            'phone'                 => 'teléfono',
        ];
    }


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['rol','identification_type','identification_number','person_type','company_name','comercial_name','first_name','other_name','surname','second_surname','digit_verification','email_address','municipality_id','address','phone','status'];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'clients_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }
}
