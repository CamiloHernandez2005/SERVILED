<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditNotePostRequest extends FormRequest
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
            'date_invoice' => 'required',
            'sellers' => 'required',
            'payments_methods' => 'required',
            'gross_totals' => 'required',
            'taxes_total' => 'required',
            'total_discounts' => 'required',
            'net_total' => 'required',
            'date_credit_notes'=> 'required',
            'reason' => 'required',
            'clients_id'=> 'required',
            'sale_id'=> 'required'
        ];
    }

    public function attributes(): array
{
    return [
        'date_invoice' => 'fecha de factura',
        'sellers' => 'vendedor',
        'payments_methods' => 'método de pago',
        'gross_totals' => 'total bruto',
        'taxes_total' => 'total impuesto',
        'net_total' => 'total neto',
        'date_credit_notes' => 'fecha de nota de crédito',
        'reason' => 'razón',
        'clients_id' => 'cliente',
        'sale_id' => 'venta',
    ];
}
}
