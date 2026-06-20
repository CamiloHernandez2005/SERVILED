<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'email' => 'required|unique:users,email',
            'phone_number' => 'required|digits:10',
            'document_type'=>'required',
            'identification_number'=>'required|digits_between:7,20|unique:users,identification_number',
            'password' => ['required',Password::min(8)->mixedCase()->letters()->numbers()->symbols()]
        ];
    }
    //Funcion para los mensajes de validacion.
    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'phone_number.required' => 'El campo número de teléfono es obligatorio.',
            'phone_number.digits' => 'El número de teléfono debe tener exactamente 10 dígitos.',
            'document_type.required' => 'El campo tipo de documento es obligatorio.',
            'identification_number.required' => 'El campo número de identificación es obligatorio.',
            'identification_number.unique' => 'El número de identificación ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.'
        ];
    }
}
