@auth
@include('include.barra', ['modo'=>'Nota Debito'])
@can('debit-note-supplier')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Persona</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet' >
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

</head>
<br>
<style>
    #box-razon-social{
        display: none;
    }
    #box-first-name{
        display: none;
    }
    #box-other-name{
        display: none;
    }
    #box-surname{
        display: none;
    }
    #box-second-surname{
        display: none;
    }
    overflow-x{
        height: 0%;
    }
</style>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form method="POST" action="{{ route('debit-note-supplier.update', $debitNoteSupplier->id) }}"  role="form" enctype="multipart/form-data">
    {{ method_field('PATCH') }}
    @csrf
    <div class="content container-fluid">
        <div class="page-body">
            <div class="container-x1">
                <div class="row row-cards">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-default">
                                    <div class="card-header d-flex">
                                        <h3 class="card-title">
                                            {{__('Nota Debito')}}
                                        </h3>
                                        <div class="card-actions" style="padding-top: 9px; padding-left: 20px" >
                                            <a href="" class="btn-action">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row row-cards">
                                    {{--  Buscar Un Numero De Factura  --}}
                                    <div class="col-sm-6 md-6">
                                        <div class="md-3 mb-3">
                                            <label for="factura" class="form-label fw-bolder">
                                                {{ __('Buscar Factura') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select id="factura" name="factura" class="form-control{{ $errors->has('factura') ? ' is-invalid' : '' }}">
                                                <option value="">Seleccione un prefijo y número de factura</option>
                                                @foreach($purchaseSuppliers as $purchaseSupplier)
                                                    <option value="{{ $purchaseSupplier->id }}"
                                                            data-users-id="{{ $purchaseSupplier->users_id }}"
                                                            data-people-id="{{ $purchaseSupplier->people_id }}"
                                                            data-date-purchase="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->date_purchase : '' }}"
                                                            data-product-name="{{ $purchaseSupplier->detailPurchase && $purchaseSupplier->detailPurchase->product ? $purchaseSupplier->detailPurchase->product->name_product : '' }}"
                                                            data-product-tax="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->product_tax : '' }}"
                                                            data-price-unit="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->price_unit : '' }}"
                                                            data-discount-total="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->discount_total : '' }}"
                                                            {{ $purchaseSupplier->id == $debitNoteSupplier->purchaseSupplier->id ? 'selected' : '' }}>
                                                        {{ $purchaseSupplier->code . '-' . $purchaseSupplier->invoice_number_purchase }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('factura', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>
                                            {{--  Fecha De Elaboracion Nota Debito  --}}
                                            <div class="col-sm-6 md-6">
                                                <div class="md-3 mb-3">
                                                    <label for="date_invoice" class="form-label fw-bolder">
                                                        {{ __('Fecha de Creación Nota Debito') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date" id="date_invoice" name="date_invoice" value="{{ date('Y-m-d') }}" class="form-control{{ $errors->has('date_invoice') ? ' is-invalid' : '' }}">
                                                    {!! $errors->first('date_invoice', '<div class="invalid-feedback">:message</div>') !!}
                                                </div>
                                            </div>
                                        {{--  Numero de Nota Debito   --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="debit_note_code" class="form-label fw-bolder">
                                                    {{ __('Número de Nota Debito') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" id="debit_note_code" name="debit_note_code" value="{{ old('debit_note_code', $debitNoteSupplier->debit_note_code) }}" class="form-control{{ $errors->has('debit_note_code') ? ' is-invalid' : '' }}" placeholder="Número de Nota Debito">
                                                {!! $errors->first('debit_note_code', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Usuario A Cargo --}}

                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="users_id" class="form-label fw-bolder">
                                                    {{ __('Empleado A Cargo') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select id="users_id" name="users_id" class="form-control{{ $errors->has('users_id') ? ' is-invalid' : '' }}">
                                                    <option value="">Seleccione un Empleado</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ $user->id == $debitNoteSupplier->users_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('users_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Proveedor al que se le compro el producto --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="people_id" class="form-label fw-bolder">
                                                    {{ __('Proveedor')}}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select id="people_id" name="people_id" class="form-control{{ $errors->has('people_id') ? ' is-invalid' : '' }}">
                                                    <option value="">Seleciona una opción</option>
                                                    @foreach($people as $person)
                                                        <option value="{{ $person->id }}" {{ $person->id == $debitNoteSupplier->purchaseSupplier->people_id ? 'selected' : '' }}>{{ $person->first_name }}</option>
                                                    @endforeach
                                                </select>


                                                {!! $errors->first('people_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Fecha Detalle De Compra  --}}

                                        <div class="col-sm-6 md-6">
                                            <div class="md-3 mb-3">
                                                <label for="date_purchase" class="form-label fw-bolder">
                                                    {{ __('Fecha de Compra') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="date_purchase" name="date_purchase" value="{{ $debitNoteSupplier->detailPurchase->date_purchase }}" class="form-control{{ $errors->has('date_purchase') ? ' is-invalid' : '' }}" readonly>
                                                {!! $errors->first('date_purchase', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <table id="tabla_detalle" class="table table-hover w-100">
                                                <style>
                                                    .bg-dark-blue {
                                                        background-color: #004080; /* Este es el código de color hexadecimal para azul oscuro */
                                                    }
                                                </style>

                                                <thead class="bg-dark-blue">


                                                    <tr>
                                                        <th class="text-white">Producto</th>
                                                        <th class="text-white">Cantidad</th>
                                                        <th class="text-white">Descripcion</th>
                                                        <th class="text-white">Precio Unitario</th>
                                                        <th class="text-white">Descuento</th>
                                                        <th class="text-white">Iva</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="text" name="producto" value="{{ $debitNoteSupplier->detailPurchase->product->name_product }}" class="form-control"></td>
                                                        <td><input type="number" name="cantidad" value="{{ $debitNoteSupplier->quantity }}" class="form-control"></td>
                                                        <td><input type="text" name="descripcion" value="{{ $debitNoteSupplier->description }}" class="form-control"></td>
                                                        <td><input type="number" id="precio_unitario" name="precio_unitario" value="{{ $debitNoteSupplier->detailPurchase->price_unit }}" class="form-control"></td>
                                                        <td><input type="number" id="descuento" name="descuento" value="{{ $debitNoteSupplier->detailPurchase->discount_total }}" class="form-control"></td>
                                                        <td><input type="number" id="iva" name="iva" value="{{ $debitNoteSupplier->detailPurchase->product_tax }}" class="form-control"></td>



                                                    </tr>
                                                </tbody>
                                            </table>


                        <div class="row">
                            <div class="col-md-12 text-end">
                                <div class="row">
                                    <div class="col-md-6 text-end">
                                        <label for="total" class="form-label">Total</label>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <input type="number" id="total" name="total" value="{{ $debitNoteSupplier->total }}" class="form-control{{ $errors->has('total') ? ' is-invalid' : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 text-end">
                                        <label for="totalBruto" class="form-label">Total Bruto</label>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <input type="number" id="totalBruto" name="gross_total" value="{{ $debitNoteSupplier->gross_total }}" class="form-control{{ $errors->has('gross_total') ? ' is-invalid' : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 text-end">
                                        <label for="totalNeto" class="form-label">Total Neto</label>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <input type="number" id="totalNeto" name="net_total" value="{{ $debitNoteSupplier->net_total }}" class="form-control{{ $errors->has('net_total') ? ' is-invalid' : '' }}">
                                    </div>
                                </div>


                        <div class="card-footer text-end">
                            <a class="btn btn-primary" style="margin-right: 5rem" href="{{ route('debit-note-supplier.index') }}">Regresar</a>
                            <button type="submit" class="btn btn-success">{{ __('Guardar') }}</button>
                        </div>
                    </div>
                </form>
<script>
var detailPurchaseData = @json($detailPurchaseData);
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
var facturaSelect = document.getElementById('factura');
if (facturaSelect) {
facturaSelect.addEventListener('change', function() {
var selectedOption = this.options[this.selectedIndex];
var usersId = selectedOption.getAttribute('data-users-id');
var peopleId = selectedOption.getAttribute('data-people-id');
var datePurchase = selectedOption.getAttribute('data-date-purchase');
var purchaseSupplierId = selectedOption.value;
var productName = selectedOption.getAttribute('data-product-name');
var productTax = selectedOption.getAttribute('data-product-tax');
var priceUnit = selectedOption.getAttribute('data-price-unit');
var discountTotal = selectedOption.getAttribute('data-discount-total');

var usersSelect = document.getElementById('users_id');
var peopleSelect = document.getElementById('people_id');
var datePurchaseInput = document.getElementById('date_purchase');
var productInput = document.querySelector('input[name="producto"]');

for (var i = 0; i < usersSelect.options.length; i++) {
if (usersSelect.options[i].value == String(usersId)) {
usersSelect.options[i].selected = true;
break;
}
}

for (var i = 0; i < peopleSelect.options.length; i++) {
if (peopleSelect.options[i].value == String(peopleId)) {
peopleSelect.options[i].selected = true;
break;
}
}

var datePurchaseFromClient = @json($detailPurchaseDates)[purchaseSupplierId] || '';
datePurchaseInput.value = datePurchaseFromClient;

var productNameFromClient = @json($detailPurchaseProducts)[purchaseSupplierId] || '';
productInput.value = productNameFromClient;

var precioUnitarioInput = document.getElementById('precio_unitario');
var descuentoInput = document.getElementById('descuento');
var ivaInput = document.getElementById('iva');

if (precioUnitarioInput && descuentoInput && ivaInput) {
var purchaseData = detailPurchaseData[purchaseSupplierId] || {};
var priceUnit = purchaseData.price_unit || '';
var productTax = purchaseData.product_tax || '';
var discountTotal = purchaseData.discount_total || '';

precioUnitarioInput.value = priceUnit;
descuentoInput.value = discountTotal;
ivaInput.value = productTax;

}
});
}
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
var cantidadInput = document.querySelector('input[name="cantidad"]');
var precioUnitarioInput = document.getElementById('precio_unitario');
var descuentoInput = document.getElementById('descuento');
var ivaInput = document.getElementById('iva');

var totalInput = document.getElementById('total');
var totalBrutoInput = document.getElementById('totalBruto');
var totalNetoInput = document.getElementById('totalNeto');

var calcularTotales = function() {
var cantidad = parseFloat(cantidadInput.value) || 0;
var precioUnitario = parseFloat(precioUnitarioInput.value) || 0;
var descuento = parseFloat(descuentoInput.value) || 0;
var iva = parseFloat(ivaInput.value) || 0;

var totalBruto = cantidad * precioUnitario;
var total = totalBruto - descuento;
var totalNeto = total + total * iva / 100;

totalInput.value = total.toFixed(2);
totalBrutoInput.value = totalBruto.toFixed(2);
totalNetoInput.value = totalNeto.toFixed(2);
};

cantidadInput.addEventListener('input', calcularTotales);
precioUnitarioInput.addEventListener('input', calcularTotales);
descuentoInput.addEventListener('input', calcularTotales);
ivaInput.addEventListener('input', calcularTotales);
});

</script>
</body>
</html>
@else
    <div class="mensaje_Rol">
        <img src="{{ asset('img/Rol_no_asignado.png')}}" class="img_rol"/>
        <h2 class="texto_noRol">Pídele al administrador que se te asigne un rol.</h2>
    </div>
@endcan
@endauth
@guest
    @include('include.falta_sesion')
@endguest

