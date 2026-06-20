@auth
    @include('include.barra', ['modo' => 'Nota Debito'])
    @can('debit-note-supplier')
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Agregar Persona</title>
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
            <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

        </head>
        <div class="bread_crumb">
            {{ Breadcrumbs::render('debit.note.supplie.show', $debitNoteSupplier) }}
        </div>
        <br>
        <div class="content container-fluid">
            <div class="page-body">
                <div class="container-x1">
                    <div class="row row-cards">
                        <div class="col-lg-12">
                            <div class="card card-default">
                                <div class="card-header d-flex">
                                    <h3 class="card-title">
                                        {{ 'Nota Debito' }}
                                    </h3>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const mensajeFlash = {!! json_encode(Session::get('notificacion')) !!};
                                        if (mensajeFlash) {
                                            agregarnotificacion(mensajeFlash);
                                        }
                                    });
                                </script>
                                <div class="contenedor-notificacion" id="contenedor-notificacion">
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
                                                <select id="factura" name="factura"
                                                    class="form-control selectpicker show-tick {{ $errors->has('factura') ? ' is-invalid' : '' }}" data-live-search="true"
                                                    data-size="5" title="Seleccione una factura" disabled> <!-- Añade el atributo 'disabled' aquí -->
                                                    <option value="">Seleccione un prefijo y número de factura</option>
                                                    @foreach ($purchaseSuppliers as $purchaseSupplier)
                                                        <option value="{{ $purchaseSupplier->id }}"
                                                            data-users-id="{{ $purchaseSupplier->users_id }}"
                                                            data-people-id="{{ $purchaseSupplier->people_id }}"
                                                            data-date-purchase="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->date_purchase : '' }}"
                                                            data-product-name="{{ $purchaseSupplier->detailPurchase && $purchaseSupplier->detailPurchase->product ? $purchaseSupplier->detailPurchase->product->name_product : '' }}"
                                                            data-product-tax="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->product_tax : '' }}"
                                                            data-price-unit="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->price_unit : '' }}"
                                                            data-discount-total="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->discount_total : '' }}"
                                                            data-quantity-units="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->discount_total : '' }}"
                                                            {{ $purchaseSupplier->id == $debitNoteSupplier->purchase_suppliers_id ? 'selected' : '' }}> <!-- Añade esta línea para seleccionar la factura correcta -->
                                                            {{ $purchaseSupplier->invoice_number_purchase }} </option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('factura', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        
                                        {{--  Fecha De Elaboracion Nota Debito  --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="md-3 mb-3">
                                                <label for="date_invoice" class="form-label fw-bolder">{{ __('Fecha de Creación Nota Debito') }} <span class="text-danger">*</span></label>
                                                <input type="text" id="date_invoice" name="date_invoice" value="{{ date('Y-m-d') }}" class="form-control{{ $errors->has('date_invoice') ? ' is-invalid' : '' }}" readonly>
                                                {!! $errors->first('date_invoice', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Numero de Nota Debito   --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="debit_note_code" class="form-label fw-bolder">{{ __('Número de Nota Debito') }} <span class="text-danger">*</span></label>
                                                <input type="text" id="debit_note_code" name="debit_note_code" value="{{ $debitNoteId }}" class="form-control{{ $errors->has('debit_note_code') ? ' is-invalid' : '' }}" placeholder="Número de Nota Debito" readonly>
                                                {!! $errors->first('debit_note_code', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Usuario A Cargo --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="users_id" class="form-label fw-bolder">{{ __('Empleado A Cargo') }} <span class="text-danger">*</span></label>
                                                <input type="text" id="users_id" name="users_id" class="form-control{{ $errors->has('users_id') ? ' is-invalid' : '' }}" value="{{ $debitNoteSupplier->user->name }}" readonly>
                                                {!! $errors->first('users_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Proveedor al que se le compro el producto --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="people_id" class="form-label fw-bolder">{{ __('Proveedor') }} <span class="text-danger">*</span></label>
                                                <input type="text" id="people_id" name="people_id" class="form-control{{ $errors->has('people_id') ? ' is-invalid' : '' }}" value="{{ optional($detailPurchase->purchaseSupplier->person)->identification_number ?? 'nn' }} - {{ optional($detailPurchase->purchaseSupplier->person)->first_name ?? 'nn' }} {{ optional($detailPurchase->purchaseSupplier->person)->other_name ?? 'nn' }} {{ optional($detailPurchase->purchaseSupplier->person)->surname ?? 'nn' }} {{ optional($detailPurchase->purchaseSupplier->person)->second_surname ?? 'nn' }} {{ optional($detailPurchase->purchaseSupplier->person)->company_name ?? 'nn' }}" readonly>

                                                {!! $errors->first('people_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        
                                        {{-- Fecha Detalle De Compra --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="md-3 mb-3">
                                                <label for="date_purchase" class="form-label fw-bolder">{{ __('Fecha de Compra') }} <span class="text-danger">*</span></label>
                                                <input type="date" id="date_purchase" name="date_purchase" class="form-control{{ $errors->has('date_purchase') ? ' is-invalid' : '' }}" value="{{ $detailPurchase->date_purchase instanceof \DateTime ? $detailPurchase->date_purchase->format('Y-m-d') : $detailPurchase->date_purchase }}" readonly>
                                                {!! $errors->first('date_purchase', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="motive" class="form-label fw-bolder">{{ __('Motivo')}} <span class="text-danger">*</span></label>
                                                <input type="text" id="motive" name="motive" class="form-control{{ $errors->has('motive') ? ' is-invalid' : '' }}" value="{{ $debitNoteSupplier->motive }}" readonly>
                                                @error('motive')
                                                    <small class="text-danger">{{ '*'.$message }}</small>
                                                @enderror
                                                <br>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <table id="tabla_detalle" class="table table-hover w-100">
                                                <style>
                                                    .bg-dark-blue {
                                                        background-color: #004080;
                                                    }
                                                </style>

                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Descripción</th>
                                                        <th>Precio Unitario</th>
                                                        <th>Descuento</th>
                                                        <th>%</th>
                                                        <th>Iva</th>
                                                        <th>Precio Unitario De Venta</th>
                                                    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($debitNoteSuppliers as $debitNoteSupplier)
                                                    <tr>
                                                        <?php
                                                            $porcentaje = $debitNoteSupplier->detailPurchase->product_tax / 100; 
                                                            $cantidad = $debitNoteSupplier->quantity;
                                                            $precio_unitario = $debitNoteSupplier->detailPurchase->price_unit;
                                                            $subtotal = round($cantidad * $precio_unitario * 100) / 100;
                                                            $ivaTotal = round($subtotal * $porcentaje * 100) / 100; 
                                                            $precio_unitario_venta = $cantidad*$precio_unitario; 
                                                        ?>

                                                        <td><input type="text" name="producto"
                                                                value="{{ $debitNoteSupplier->detailPurchase->product->name_product }}"
                                                                class="form-control" readonly></td>
                                                        <td><input type="number" name="cantidad"
                                                                value="{{ $cantidad }}"
                                                                class="form-control" readonly></td>
                                                        <td><input type="text" name="descripcion"
                                                                value="{{ $debitNoteSupplier->description }}"
                                                                class="form-control" readonly></td>
                                                        <td><input type="number" id="precio_unitario"
                                                                name="precio_unitario"
                                                                value="{{ $precio_unitario }}"
                                                                class="form-control" readonly></td>
                                                        <td><input type="number" id="descuento" name="descuento"
                                                                value="{{ $debitNoteSupplier->detailPurchase->discount_total }}"
                                                                class="form-control" readonly></td>
                                                                <td><input type="number" id="iva" name="iva"
                                                                    value="{{ $debitNoteSupplier->detailPurchase->product_tax }}"
                                                                    class="form-control" readonly></td>
                                                        <td><input type="number" id="iva" name="iva"
                                                                value="{{ $ivaTotal }}"
                                                                class="form-control" readonly></td>
                                                        <td><input type="number" id="precio_unitario_venta" name="precio_unitario_venta"
                                                                value="{{ $precio_unitario_venta }}"
                                                                class="form-control" readonly></td>
                                                    </tr>
                                                @endforeach
                                                
                                                </tbody>
                                                
                                            </table>
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <div class="row">
                                                        <div class="col-md-6 text-end">
                                                            <label for="total" class="form-label">SubTotal</label>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <input type="text" id="total" name="total" value="${{ number_format($debitNoteSupplier->total, 0, ',', '.') }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-end">
                                                            <label for="descuento" class="form-label">Descuento</label>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <input type="text" id="descuento" name="descuento" value="{{ number_format($descuentoTotal, 0, ',', '.') }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6 text-end">
                                                            <label for="totalBruto" class="form-label">Total Bruto</label>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <input type="text" id="totalBruto" name="gross_total" value="${{ number_format($debitNoteSupplier->gross_total, 0, ',', '.') }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-end">
                                                            <label for="iva" class="form-label">IVA %</label>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <input type="text" id="iva" name="iva" value="{{ $debitNoteSupplier->net_total - $debitNoteSupplier->gross_total   }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6 text-end">
                                                            <label for="totalNeto" class="form-label">Total Factura</label>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <input type="text" id="totalNeto" name="totalNeto" value="${{ number_format($debitNoteSupplier->net_total, 0, ',', '.') }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <a class="btn btn-primary" style="margin-right: 5rem"
                                        href="{{ route('debit-note-supplier.index') }}">Regresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
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

                        // Establecer el valor seleccionado en usersSelect
                        for (var i = 0; i < usersSelect.options.length; i++) {
                            if (usersSelect.options[i].value == String(usersId)) {
                                usersSelect.options[i].selected = true;
                                break;
                            }
                        }

                        // Establecer el valor seleccionado en peopleSelect
                        for (var i = 0; i < peopleSelect.options.length; i++) {
                            if (peopleSelect.options[i].value == String(peopleId)) {
                                peopleSelect.options[i].selected = true;
                                break;
                            }
                        }

                        // Obtener la fecha de detail_purchase desde el lado del cliente
                        var datePurchaseFromClient = @json($detailPurchaseDates)[purchaseSupplierId] || '';
                        datePurchaseInput.value = datePurchaseFromClient;

                        // Obtener el nombre del producto desde el lado del cliente
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

                            // Asignar los valores a los campos de entrada
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
    // Función para calcular los totales
    var calcularTotales = function() {
        var total = 0;
        var totalBruto = 0;
        var descuentoTotal = 0;
        var totalIva = 0;

        document.querySelectorAll('#tabla_detalle tbody tr').forEach(function(row) {
            var cantidad = Number(row.querySelector('input[name="cantidad[]"]').value);
            var precio_unitario = Number(row.querySelector('input[name="precio_unitario[]"]').value);
            var iva = Number(row.querySelector('input[name="iva[]"]').value) / 100;
            var descuento = Number(row.querySelector('input[name="descuento[]"]').value);
            var subtotal = Math.round(cantidad * precio_unitario * 100) / 100;
            var ivaTotal = Math.round(subtotal * iva * 100) / 100;

            total += subtotal;
            totalBruto += subtotal - descuento;
            descuentoTotal += descuento;
            totalIva += ivaTotal;
        });

        var totalNeto = Math.round((totalBruto + totalIva) * 100) / 100;

        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('totalBruto').value = totalBruto.toFixed(2);
        document.getElementById('totalNeto').value = totalNeto.toFixed(2);
        document.getElementById('Descuento').value = descuentoTotal.toFixed(2);
        document.getElementById('iva').value = totalIva.toFixed(2);
    };

    // Agregar el evento 'input' a los campos
    document.querySelectorAll('input[name="cantidad[]"], input[name="precio_unitario[]"], input[name="descuento[]"], input[name="iva[]"]').forEach(function(input) {
        input.addEventListener('input', calcularTotales);
    });

    // Llama a calcularTotales al cargar la página para calcular los totales iniciales
    calcularTotales();
});

        </script>
        
        </body>

        </html>
    @else
        <div class="mensaje_Rol">
            <img src="{{ asset('img/Rol_no_asignado.png') }}" class="img_rol" />
            <h2 class="texto_noRol">Pídele al administrador que se te asigne un rol.</h2>
        </div>
    @endcan
@endauth
@guest
    @include('include.falta_sesion')
@endguest
