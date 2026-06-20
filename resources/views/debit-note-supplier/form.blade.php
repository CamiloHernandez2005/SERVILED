@auth
    @include('include.barra', ['modo' => 'Nota Debito'])
    @can('debit-note-supplier')
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Nota Débito</title>
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
            <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
            <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css"
                rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
            <link href="{{ asset('css/estilos_notificacion.css') }}" rel="stylesheet" />

            <script src="{{ asset('js/notificaciones.js') }}" defer></script>
            <meta name="csrf-token" content="{{ csrf_token() }}">

        </head>
        <br>
        <style>
            #box-razon-social {
                display: none;
            }

            #box-first-name {
                display: none;
            }

            #box-other-name {
                display: none;
            }

            #box-surname {
                display: none;
            }

            #box-second-surname {
                display: none;
            }

            overflow-x {
                height: 0%;
            }
        </style>
        <div class="content container-fluid">
            <div class="page-body">
                <div class="container-x1">
                    <div class="row row-cards">
                        <div class="col-lg-12">
                            <div class="card card-default">
                                <div class="card-header d-flex">
                                    <h3 class="card-title">
                                        {{ 'Nota Débito' }}
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
                                    <form action="{{ route('debit-note-supplier.store') }}" method="post" id="create">
                                    <div class="row row-cards">
                                        {{--  Buscar Un Numero De Factura  --}}
                                        
                                        <div class="col-sm-6 md-6">
                                            <div class="md-3 mb-3">
                                                <label for="factura" class="form-label fw-bolder">
                                                    {{ __('Buscar Factura De Compra') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select id="factura" name="factura"
                                                    class="form-control selectpicker show-tick {{ $errors->has('factura') ? ' is-invalid' : '' }}"data-live-search="true"
                                                    data-size="5" title="Seleccione una factura">
                                                    <option value="">Seleccione un prefijo y número de factura</option>
                                                    @foreach ($purchaseSuppliers as $purchaseSupplier)
                                                        @if($purchaseSupplier->status != false)
                                                            <option value="{{ $purchaseSupplier->id }}"
                                                                data-users-id="{{ $purchaseSupplier->users_id }}"
                                                                data-people-id="{{ $purchaseSupplier->people_id }}"
                                                                data-date-purchase="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->date_purchase : '' }}"
                                                                data-product-name="{{ $purchaseSupplier->detailPurchase && $purchaseSupplier->detailPurchase->product ? $purchaseSupplier->detailPurchase->product->name_product : '' }}"
                                                                data-product-tax="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->product_tax : '' }}"
                                                                data-price-unit="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->price_unit : '' }}"
                                                                data-discount-total="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->discount_total : '' }}"
                                                                data-quantity-units="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->discount_total : '' }}"
                                                                data-description="{{ $purchaseSupplier->detailPurchase ? $purchaseSupplier->detailPurchase->description : '' }}"
                                                                {{ old('factura') == $purchaseSupplier->id ? 'selected' : '' }}>
                                                                {{ $purchaseSupplier->invoice_number_purchase }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('factura', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        
                                        {{--  Fecha De Elaboracion Nota Debito  --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="md-3 mb-3">
                                                <label for="date_invoice" class="form-label fw-bolder">
                                                    {{ __('Fecha de Creación Nota Débito') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="date_invoice" name="date_invoice"
                                                    value="{{ date('Y-m-d') }}"
                                                    class="form-control{{ $errors->has('date_invoice') ? ' is-invalid' : '' }}">
                                                {!! $errors->first('date_invoice', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Numero de Nota Debito   --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="debit_note_code" class="form-label fw-bolder">
                                                    {{ __('Número de Nota Débito') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" id="debit_note_code" name="debit_note_code"
                                                    value="{{ $debitNoteId }}"
                                                    class="form-control{{ $errors->has('debit_note_code') ? ' is-invalid' : '' }}"
                                                    placeholder="Número de Nota Débito">
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
                                                <select id="users_id" name="users_id"
                                                    class="form-control{{ $errors->has('users_id') ? ' is-invalid' : '' }}">
                                                    <option value="">Seleccione un Empleado</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('users_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Proveedor al que se le compro el producto --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="people_id" class="form-label fw-bolder">
                                                    {{ __('Proveedor') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select id="people_id" name="people_id"
                                                    class="form-control{{ $errors->has('people_id') ? ' is-invalid' : '' }}">
                                                    <option value="">Seleciona una opción</option>
                                                    @foreach ($people as $person)
                                                        <option value="{{ $person->id }}">
                                                            {{ $person->identification_number }} - {{ $person->first_name }}
                                                            {{ $person->other_name }} {{ $person->surname }}
                                                            {{ $person->second_surname }} {{ $person->company_name }}</option>
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
                                                <input type="date" id="date_purchase" name="date_purchase"
                                                    class="form-control{{ $errors->has('date_purchase') ? ' is-invalid' : '' }}"readonly>
                                                {!! $errors->first('date_purchase', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="motive" class="form-label fw-bolder">
                                                    {{ __('Motivo')}}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select name="motive" id="motive" class="form-control selectpicker" data-live-search="true" data-size="6" title="Motivo ...">
                                                    <option value="Devolucion de parte de los bienes">Devolución de parte de los bienes</option>
                                                    <option value="Anulacion de factura electronica">Anulación de factura electrónica</option>
                                                    <option value="Rebaja o descuento parcial o total">Rebaja o descuento parcial o total</option>
                                                    <option value="Ajuste de precio">Ajuste de precio</option>
                                                    <option value="Otros">Otros</option>
                                                </select>
                                            </div>
                                            @error('motive')
                                            <small class="text-danger">{{ '*'.$message }}</small>
                                            @enderror
                                            <br>
                                        </div>
                                        
                                        <div class="col-12">
                                            <table id="tabla_detalle" class="table table-hover w-100">
                                                <style>
                                                    .bg-dark-blue {
                                                        background-color: #004080;
                                                    }
                                                    .bg-primary.text-white th {
                                                        text-align: center;
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
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="text" name="producto" class="form-control"></td>
                                                        <td><input type="number" name="cantidad" class="form-control"></td>
                                                        <td><input type="text" name="descripcion" class="form-control"> </td>       
                                                        <td><input type="number" id="precio_unitario" name="precio_unitario"
                                                                class="form-control"></td>
                                                        <td><input type="number" id="descuento" name="descuento"
                                                                class="form-control"></td>
                                                        <td><input type="number" id="iva" name="iva"
                                                                class="form-control"></td>
                                                                <td><input type="number" id="%" name="%"
                                                                    class="form-control"></td>
                                                                    <td><input type="number" id="PrecioUniVenta" name="PrecioUniVenta"
                                                                        class="form-control"></td>
                                                        <td><button class="btn btn-danger" type="button"><i
                                                                    class="fa-solid fa-trash"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                                <div class="row">
                                                    <div class="col-md-12 text-end">
                                                        <div class="row">
                                                            <div class="col-md-6 text-end">
                                                                <label for="total" class="form-label">Subtotal</label>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <input type="number" id="total" name="total" value="0" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 text-end">
                                                                <label for="Descuento" class="form-label">Descuento</label>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <input type="number" id="Descuento" name="Descuento" value="0" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 text-end">
                                                                <label for="totalBruto" class="form-label">Total Bruto</label>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <input type="number" id="totalBruto" name="gross_total" value="0" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 text-end">
                                                                <label for="iva" class="form-label">IVA%</label>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <input type="number" id="iva" name="iva" value="0" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 text-end">
                                                                <label for="totalNeto" class="form-label">Total Factura</label>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <input type="number" id="totalNeto" name="totalNeto" value="0" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <br>
                                    <a class="btn btn-primary" style="margin-right: 5rem"
                                        href="{{ route('debit-note-supplier.index') }}">Regresar</a>
                                    <button type="submit" class="btn btn-success">{{ __('Guardar') }}</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

        <script>
            var detailPurchaseData = @json($detailPurchaseData);
        </script>
        <script>
            console.log(detailPurchaseData);
        </script>

        {{-- SEGUN EL ID DE FACTURA  SE TRAEN LOS DATOS QUE SON EL EMPLEADO COMO USER
EL PROVEEDOR COMO PEOPLE LA FECHA DE COMPRA EL NOMBRE DEL PRODUCTO
EL PRECIO DEL PRODUCTO EL DESCUENTO Y EL IVA --}}
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

                        var usersSelect = document.getElementById('users_id');
                        var peopleSelect = document.getElementById('people_id');
                        var datePurchaseInput = document.getElementById('date_purchase');

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
                    });
                }
            });
        </script>

        {{-- EN ESTA PARTE DE CODIGO SEGUN EL NUMERO DE FACTURA Y LA VARIABLE.JSON
NOS TRAEMOS TODOS LOS DATOS EN UN ARREGLO CONCATENADO Y DEPENDIENDO DEL
ARREGLO ASOCIATIVO GENERAMOS LAS FILAS QUE NECESITAMOS MOSTRAR --}}
        <script>
        document.addEventListener('DOMContentLoaded', function() {
    var facturaSelect = document.getElementById('factura');
    if (facturaSelect) {
        facturaSelect.addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var purchaseSupplierId = selectedOption.value;

            var detailData = detailPurchaseData[purchaseSupplierId] || [];

            var tbody = document.querySelector('#tabla_detalle tbody');
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

            detailData.forEach(function(detail) {
                var newRow = document.createElement('tr');

                newRow.innerHTML =
                '<td><input type="text" name="producto[]" class="form-control" value="' +
                detail.product_name + '"readonly></td>' +
                '<td><input type="number" name="cantidad[]" class="form-control" value="' +
                detail.quantity_units + '"></td>' +
                '<td><input type="text" name="descripcion[]" class="form-control" value="' +
                detail.descuento + '"></td>' +
                '<td><input type="number" name="precio_unitario[]" class="form-control" value="' +
                detail.price_unit + '"readonly></td>' +
                '<td><input type="number" name="descuento[]" class="form-control" value="' +
                detail.discount_total + '"readonly></td>' +
                '<td><input type="number" name="iva[]" class="form-control" value="' +
                detail.product_tax + '"readonly></td>' +
                '<td><input type="number" name="porcentaje[]" class="form-control"readonly></td>' + 
                '<td><input type="number" name="precio_unitario_venta[]" class="form-control"readonly></td>' + 
                '<td><button class="btn btn-danger" type="button"><i class="fa-solid fa-trash"></i></button></td>';

                tbody.appendChild(newRow);

                var calcularValores = function() {
                    var cantidad = Number(newRow.querySelector('input[name="cantidad[]"]').value);
                    var precio_unitario = Number(newRow.querySelector('input[name="precio_unitario[]"]').value);
                    var iva = Number(newRow.querySelector('input[name="iva[]"]').value) / 100;
                    var subtotal = Math.round(cantidad * precio_unitario * 100) / 100;
                    var ivaTotal = Math.round(subtotal * iva * 100) / 100;

                    newRow.querySelector('input[name="precio_unitario_venta[]"]').value = subtotal;
                    newRow.querySelector('input[name="porcentaje[]"]').value = ivaTotal;
                };

                newRow.querySelector('input[name="cantidad[]"]').addEventListener('input', calcularValores);

                newRow.querySelector('button').addEventListener('click', function() {
                    newRow.remove();
                    calcularTotales();
                });

                newRow.querySelectorAll('input[type=number]').forEach(function(input) {
                    input.addEventListener('input', function(e) {
                        calcularTotales();
                    });
                });

                calcularValores();
            });

            calcularTotales();
        });
    }
});

function calcularTotales() {
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

    document.getElementById('total').value = Math.round(total * 100) / 100;
    document.getElementById('totalBruto').value = Math.round(totalBruto * 100) / 100;
    document.getElementById('totalNeto').value = Math.round(totalNeto * 100) / 100;
    document.getElementById('Descuento').value = Math.round(descuentoTotal * 100) / 100;
    document.getElementById('iva').value = Math.round(totalIva * 100) / 100;
}
</script>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();

    var isValid = true;
    var message = '';

    document.querySelectorAll('input[name="producto[]"]').forEach(function(input) {
        if (input.value.trim() === '') {
            isValid = false;
            message = 'El producto es obligatorio.';
            showModal(message);
            return;
        }
    });
    document.querySelectorAll('input[name="cantidad[]"]').forEach(function(input) {
        var cantidad = Number(input.value);
        if (!isNumeric(cantidad)) {
            isValid = false;
            message = 'Se debe ingresar una cantidad válida.';
            showModal(message);
            return;
        } else if (cantidad <= 0) {
            isValid = false;
            message = 'La cantidad ingresada no puede ser negativa o cero.';
            showModal(message);
            return;
        }
    });

    document.querySelectorAll('input[name="descripcion[]"]').forEach(function(input) {
        var descripcion = input.value;
        if (descripcion.trim() === '') {
            isValid = false;
            message = 'Se necesita agregar la descripción del porqué se va a realizar la nota débito.';
            showModal(message);
            return;
        }
    });

    var totalNetoInput = document.getElementById('totalNeto');
    var totalNeto = totalNetoInput ? totalNetoInput.value : 0;
    if (totalNeto < 0) {
        isValid = false;
        message = 'El total factura no puede ser negativo.';
        showModal(message);
        return;
    }

    var grossTotalInput = document.getElementById('gross_total');
    var grossTotal = grossTotalInput ? grossTotalInput.value : 0;
    if (grossTotal < 0) {
        isValid = false;
        message = 'El total bruto no puede ser negativo.';
        showModal(message);
        return;
    }

    var totalInput = document.getElementById('total');
    var total = totalInput ? totalInput.value : 0;
    if (total < 0) {
        isValid = false;
        message = 'El subtotal no puede ser negativo.';
        showModal(message);
        return;
    }

    var motiveInput = document.getElementById('motive');
    var motive = motiveInput ? motiveInput.value : '';
    if (motive.trim() === '') {
        isValid = false;
        message = 'El motivo por el cual se realiza la nota es obligatorio.';
        showModal(message);
        return;
    }

    if (isValid) {
        this.submit();
    }
});

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function showModal(message, icon = 'error') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        showClass: {
            popup: 'animate__animated animate__fadeInUp'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutDown'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: icon,
        title: message
    });
}
</script>
        <script>
            $(document).ready(function() {
    var formListoParaEnviar = false;

    $('.btn-success').on('click', function(event) {
        if (!formListoParaEnviar) {
            event.preventDefault();

            var purchaseSupplierId = $('#factura').val();

            $.ajax({
                url: '/verificar-nota-debito',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    factura: purchaseSupplierId
                },
                success: function(response) {
                    if(response.existe) {
                        showModal('El número de factura ya tiene una nota débito.', 'error');
                    } else {
                        formListoParaEnviar = true;
                        $('.btn-success').trigger('click'); 
                    }
                },
                error: function(xhr, status, error) {
                    showModal('Ocurrió un error al verificar la nota débito.', 'error');
                }
            });
        }
    });
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
