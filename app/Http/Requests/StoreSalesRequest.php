<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dates' => 'required',
            'bill_numbers' => 'required|unique:sales,bill_numbers', // Asegura que el número de factura sea único en la tabla sales
            'sellers' => 'required',
            'payments_methods' => 'required' ,
            'gross_totals' => 'required' ,
            'taxes_total' => 'required' ,
            'total_discounts' => 'required' ,
            'net_total' => 'required' ,
            'clients_id'=> 'nullable|exists:people,id',
            'arrayidproducto.*' => 'required|exists:products,id',
            'arraycantidad.*' => 'required|integer|min:1',
            'arrayprecioventa.*' => 'required|numeric|min:0',
            'arraydescuento.*' => 'required|numeric|min:0',
            'arrayimpuesto.*' => 'required|numeric|min:0',
            'arrayimpuestoval.*' => 'required|numeric|min:0',
        ];
    }   
    protected function prepareForValidation()
    {
        $this->merge([
            'bill_numbers' => $this->bill_prefix . $this->bill_numbers,
        ]);
}

public function attributes(): array
{
    return [
        'dates' => 'fecha',
        'bill_numbers' => 'número de factura',
        'sellers' => 'vendedor',
        'payments_methods' => 'método de pago',
        'gross_totals' => 'total bruto',
        'taxes_total' => 'total impuesto',
        'net_total' => 'total neto',
        'clients_id' => 'cliente',
        'arrayidproducto.*' => 'producto',
        'arraycantidad.*' => 'cantidad',
        'arrayprecioventa.*' => 'precio de venta',
        'arraydescuento.*' => 'descuento',
        'arrayimpuesto.*' => 'impuesto',
        'arrayimpuestoval.*' => 'valor del impuesto',
    ];
}

}