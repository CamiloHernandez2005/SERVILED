@auth
    @can('detail-purchases')
        <!DOCTYPE html>
        <html>

        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css"
                rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
            <meta name="csrf-token" content="{{ csrf_token() }}">
        </head>
        <body>
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                    </ul>
                </div>
                </nav>
                <div class="container">
                    <form action="{{ route('detail-purchases.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="container-lg mt-4">
                                <div class="row gy-4">
                                    <!------Compra producto---->
                                    <div class="col-xl-8">
                                        <div class="text-white bg-primary p-1 text-center fs-5">
                                            Detalles de la compra
                                        </div>
                                        <div class="p-3 border border-3 border-primary">
                                            <div class="row">

                                                <div class="col-12 mb-4">
                                                    <label for="producto_id" class="form-label">Producto:</label>
                                                    <select name="producto_id" id="producto_id"
                                                        class="form-control selectpicker {{ $errors->has('producto_id') ? ' is-invalid' : '' }}"
                                                        data-live-search="true" data-size="5" title="Seleccione un producto">
                                                        @foreach ($products as $item)
                                                            @if($item->status != 0 && $item->status != 'inactivo')
                                                                <option value="{{ $item->id }}"
                                                                    data-purchase-price="{{ $item->purchase_price }}"
                                                                    data-classification-tax="{{ $item->classification_tax }}"
                                                                    {{ old('producto_id') == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->name_product }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('producto_id', '<div class="invalid-feedback">:message</div>') !!}
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <label for="precio_compra" class="form-label">Precio Unitario:</label>
                                                    <input type="text" name="precio_compra" id="precio_compra"
                                                        class="form-control" inputmode="numeric">
                                                </div>
                                                <br>
                                                <div class="col-sm-4 mb-2">
                                                    <label for="cantidad" class="form-label">Cantidad:</label>
                                                    <input type="number" name="cantidad" id="cantidad" class="form-control">
                                                </div>
                                                <div class="col-sm-4 mb-2">
                                                    <label for="precio_venta" class="form-label"> Descripción:</label>
                                                    <input type="text" name="precio_venta" id="precio_venta"
                                                        class="form-control" step="0.1">
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <label for="discount_total" class="form-label">Descuento</label>
                                                    <input type="number" id="discount_total" name="discount_total"
                                                        min="0" max="100" step="1" class="form-control"
                                                        placeholder="Ingrese el valor de descuento"
                                                        oninput="this.value = Math.round(this.value)"
                                                        value="{{ old('discount_total', isset($detailPurchase) ? $detailPurchase->discount_total : '0') }}">
                                                    @error('discount_total')
                                                        <small class="text-danger">{{ '*' . $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-6 mb-4">
                                                    <label for="product_tax" class="form-label">Impuesto a cargo del
                                                        producto</label>
                                                    <select id="product_tax" name="product_tax" class="form-control">
                                                        <option value="0"
                                                            {{ old('product_tax', isset($detailPurchase) ? $detailPurchase->product_tax : '') == 0 ? 'selected' : '' }}>
                                                            0%</option>
                                                        <option value="5"
                                                            {{ old('product_tax', isset($detailPurchase) ? $detailPurchase->product_tax : '') == 5 ? 'selected' : '' }}>
                                                            5%</option>
                                                        <option value="19"
                                                            {{ old('product_tax', isset($detailPurchase) ? $detailPurchase->product_tax : '') == 19 ? 'selected' : '' }}>
                                                            19%</option>
                                                    </select>
                                                    @error('product_tax')
                                                        <small class="text-danger">{{ '*' . $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-4 mt-2 text-end">
                                                    <button id="btn_agregar" class="btn btn-primary"
                                                        type="button">Agregar</button>
                                                </div>
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <table id="tabla_detalle" class="table table-hover">
                                                            <thead class="bg-primary text-white">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Producto</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Descripción</th>
                                                                    <th>Precio Unitario</th>
                                                                    <th>Descuento</th>
                                                                    <th>%</th>
                                                                    <th>Iva</th>
                                                                    <th>Precio Unitario De Venta</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th></th>
                                                                    <th colspan="7">Subtotal</th>
                                                                    <th colspan="2">
                                                                        <input type="hidden" id="total_value_raw" name="total_value_raw" value="">
                                                                        <span id="sumas">0</span>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th></th>
                                                                    <th colspan="7">Descuento</th>
                                                                    <th colspan="2"><span id="descuento">0</span></th>
                                                                </tr>

                                                                <tr>
                                                                    <th></th>
                                                                    <th colspan="7">Total Bruto</th>
                                                                    <th colspan="2"><input type="hidden" name="totalBruto"
                                                                            id="hiddenTotalBruto"><span id="totalBruto">
                                                                            0</span></th>
                                                                </tr>
                                                                <tr>
                                                                    <th></th>
                                                                    <th colspan="7">IVA %</th>
                                                                    <th colspan="2">
                                                                        <input type="hidden" id="igv_input" name="igv" value="">
                                                                        <span id="igv">0</span>
                                                                    </th>
                                                                </tr>


                                                                <tr>
                                                                    <th></th>
                                                                    <th colspan="7">Total Factura</th>
                                                                    <th colspan="2"><input type="hidden" name="totalNeto"
                                                                            id="hiddenTotalNeto"> <span
                                                                            id="totalNeto">0</span></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button id="cancelar" type="button" class="btn btn-danger"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Cancelar compra
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="text-white bg-success p-1 text-center fs-5">
                                            Datos generales
                                        </div>
                                        <div class="p-3 border border-3 border-success">
                                            <div class="row">
                                                <!--Proveedor-->
                                                <div class="col-12">
                                                    <label for="people_id" class="form-label">Proveedor <small class="text-muted">(opcional)</small>:</label>
                                                    <select name="people_id" id="people_id"
                                                        class="form-control selectpicker show-tick" data-live-search="true"
                                                        title="Selecciona el Proveedor (opcional)" data-size='3'>
                                                        <option value="">— Ninguno (sin proveedor) —</option>
                                                        @foreach ($people as $person)
                                                            @if($person->status != 0 && $person->status != 'inactivo')
                                                                <option value="{{ $person->id }}">
                                                                    {{ $person->identification_number }} -
                                                                    {{ $person->first_name }} {{ $person->other_name }}
                                                                    {{ $person->surname }} {{ $person->second_surname }}
                                                                    {{ $person->company_name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('people_id')
                                                        <small class="text-danger">{{ '*' . $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-2">
                                                    <label for="user_id" class="form-label">Empleado:</label>
                                                    <select name="user_id" id="user_id"
                                                        class="form-control selectpicker show-tick" data-live-search="true"
                                                        title="Selecciona un Empleado" data-size='2'required>
                                                        
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                        <small class="text-danger">{{ '*' . $message }}</small>
                                                    @enderror
                                                </div>
                                                <!--Impuesto---->
                                                <div class="col-sm-12 mb-2">
                                                    <label for="fecha" class="form-label">Fecha:</label>
                                                    <input readonly type="date" name="fecha" id="fecha"
                                                        class="form-control border-success" value="<?php echo date('Y-m-d'); ?>">
                                                </div>



                                                <div class="col-6 mb-2">
                                                    <label for="code" class="form-label">Prefijo:</label>
                                                    <div class="input-group">
                                                        <input type="text" name="code" id="code" class="form-control" placeholder="Ingrese el prefijo"required>
                                                    </div>
                                                    @error('code')
                                                        <small class="text-danger">{{ '*' . $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-6 mb-2">
                                                    <label for="invoice_number_purchase" class="form-label">Número de
                                                        factura</label>
                                                    <input type="number" id="invoice_number_purchase"
                                                        name="invoice_number_purchase"
                                                        class="form-control {{ $errors->has('invoice_number_purchase') ? ' is-invalid' : '' }}"
                                                        placeholder="Ingrese el número de factura"
                                                        value="{{ old('invoice_number_purchase', isset($purchaseSupplier) ? $purchaseSupplier->invoice_number_purchase : '') }}"required>
                                                    @error('invoice_number_purchase')
                                                        <small class="text-danger">{{ '*' . $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <label for="form_of_payment" class="form-label">Formas de pago:</label>
                                                    <select id="form_of_payment" name="form_of_payment" class="form-control"required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="Tarjeta"
                                                            {{ old('form_of_payment', isset($detailPurchase) ? $detailPurchase->form_of_payment : '') == 'tarjeta' ? 'selected' : '' }}>
                                                            Tarjeta</option>
                                                        <option value="Efectivo"
                                                            {{ old('form_of_payment', isset($detailPurchase) ? $detailPurchase->form_of_payment : '') == 'efectivo' ? 'selected' : '' }}>
                                                            Efectivo</option>
                                                        <option value="Transferencia"
                                                            {{ old('form_of_payment', isset($detailPurchase) ? $detailPurchase->form_of_payment : '') == 'transferencia' ? 'selected' : '' }}>
                                                            Transferencia Bancaria</option>
                                                    </select>
                                                    @error('form_of_payment')
                                                        <small class="text-danger">{{ '*' . $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-6 mb-2">
                                                    <label for="method_of_payment" class="form-label">Método de Pago:</label>
                                                    <select id="method_of_payment" name="method_of_payment" class="form-control"required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="Cuotas"
                                                            {{ old('method_of_payment', isset($detailPurchase) ? $detailPurchase->method_of_payment : '') == 'cuotas' ? 'selected' : '' }}>
                                                            Cuotas</option>
                                                        <option value="Contado"
                                                            {{ old('method_of_payment', isset($detailPurchase) ? $detailPurchase->method_of_payment : '') == 'contado' ? 'selected' : '' }}>
                                                            Contado</option>
                                                        <option value=Crédito"
                                                            {{ old('method_of_payment', isset($detailPurchase) ? $detailPurchase->method_of_payment : '') == 'credito' ? 'selected' : '' }}>
                                                            Crédito</option>
                                                    </select>
                                                    @error('method_of_payment')
                                                        <small class="text-danger">{{ '*' . $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mt-4 text-center d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-success mr-3" id="guardar">Realizar compra</button>
                                                    <a class="btn btn-primary" href="{{ route('detail-purchases.index') }}">Regresar</a>
                                                </div>
                                                <style>
                                                    .btn-success {
                                                    margin-right: 1rem;
                                                    }

                                                    .btn-primary {
                                                    margin-left: 1rem;
                                                    }
                                                </style>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="examplebtnModalLabel">Advertencia</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Seguro que quieres cancelar la compra?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button id="btnCancelarCompra" type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#btn_agregar').click(function() {
                        agregarProducto();
                    });

                    $('#btnCancelarCompra').click(function() {
                        cancelarCompra();
                    });
                    disableButtons();
                });

                let cont = 0;
                let subtotal = [];
                let sumas = 0;
                let igv = 0;
                let total = 0;
                let totalBruto = 0;
                let totalNeto = 0;
                let descuentoTotal = 0;



                function cancelarCompra() {
                    $('#tabla_detalle tbody').empty();
                    let fila = '<tr>' +
                        '<th></th>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '</tr>';
                    $('#tabla_detalle').append(fila);
                    cont = 0;
                    subtotal = [];
                    sumas = 0;
                    igv = 0;
                    total = 0;
                    totalBruto = 0;
                    totalNeto = 0;
                    descuentoTotal = 0;

                    $('#sumas').html(sumas);
                    $('#igv').html(igv);
                    $('#total').val(sumas);
                    $('#totalBruto').html(totalBruto);
                    $('#totalNeto').html(totalNeto);
                    $('#descuento').html(descuentoTotal);
                    $('#inputTotal').val(total);
                    $('#hiddenTotalBruto').val(totalBruto);
                    $('#igv_input').val(igv);
                    $('#hiddenTotalNeto').val(totalNeto);


                    limpiarCampos();
                    disableButtons();
                }

                function disableButtons() {
                    if (total == 0) {
                        $('#guardar').hide();
                    } else {
                        $('#guardar').show();
                    }
                }


                function agregarProducto() {
                    let idProducto = $('#producto_id').val();
                    if ($("#tabla_detalle input[name='arrayidproducto[]']").filter(function() {
                            return $(this).val() == idProducto;
                        }).length > 0) {
                        showModal('El producto ya está en la lista');
                        return;
                    }
                    let nameProducto = $('#producto_id option:selected').text();
                    let cantidad = $('#cantidad').val();
                    let descripcion = $('#precio_venta').val();
                    let impuesto = $('#product_tax').val();
                    let precioCompra = parseValor($('#precio_compra').val());
                    let descuentoProducto = $('#discount_total').val();
                    let ivaProducto = Math.round(cantidad * precioCompra * impuesto / 100 * 100) / 100;
                    if (descuentoProducto == '') {
                        descuentoProducto = 0;
                    }
                    if (descripcion === '' || descripcion === undefined) {
                        descripcion = nameProducto;
                    } else {

                        descripcion = nameProducto + " / " + descripcion;
                    }
                    if (idProducto === '' || idProducto === undefined || nameProducto === '' || nameProducto === undefined ||
                        cantidad === '' || cantidad === undefined || descripcion === '' || descripcion === undefined || impuesto ===
                        '' || impuesto === undefined || precioCompra === '' || precioCompra === undefined || descuentoProducto ===
                        '' || descuentoProducto === undefined) {
                        showModal('Le faltan campos por llenar');
                    } else if (!(parseInt(cantidad) > 0 && (cantidad % 1 === 0) && parseFloat(precioCompra) > 0)) {
                        showModal('Valores incorrectos');
                    } else if (descuentoProducto > cantidad * precioCompra) {
                        showModal('El descuento no puede ser mayor que el valor de la compra');
                    } else if (cantidad > 999){
                        showModal('La cantidad es demasiado alta')
                    } else {
                        igv += ivaProducto;
                        descuentoTotal += parseFloat(descuentoProducto);
                        subtotal[cont] = Math.round(cantidad * precioCompra * 100) / 100;
                        sumas += subtotal[cont];
                        total = sumas + igv;
                        totalBruto = sumas-descuentoTotal;
                        totalNeto = totalBruto+igv;


                        $('#gross_total').val(totalBruto);



                        let fila = '<tr id="fila' + cont + '">' +
                            '<th>' + (cont + 1) + '</th>' +
                            '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' + nameProducto +
                            '</td>' +
                            '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad + '</td>' +
                            '<td><input type="hidden" name="arrayprecioventa[]" value="' + descripcion + '">' + descripcion +
                            '</td>' +
                            '<td><input type="hidden" name="arraypreciocompra[]" value="' + precioCompra + '">' + formatearMoneda(precioCompra) +
                            '</td>' +
                            '<td><input type="hidden" name="arraydescuento[]" value="' + descuentoProducto + '">' +
                            formatearMoneda(descuentoProducto) + '</td>' +
                            '<td><input type="hidden" name="arrayimpuesto[]" value="' + impuesto + '">' + impuesto + '%</td>' +
                            '<td><input type="hidden" name="arrayiva[]" value="' + ivaProducto + '">' + formatearMoneda(ivaProducto) + '</td>' +
                            '<td>' + formatearMoneda(subtotal[cont]) + '</td>' +
                            '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto(' + cont + ', ' + impuesto + ', \'' + descuentoProducto + '\')"><i class="fa-solid fa-trash"></i></button></td>' +                            '</tr>';

                        $('#tabla_detalle').append(fila);
                        limpiarCampos();
                        cont++;
                        disableButtons();
                        $('#sumas').html(formatearMoneda(sumas));
                        $('#igv').html(formatearMoneda(igv));
                        $('#total_value_raw').val(sumas);
                        $('#totalBruto').html(formatearMoneda(totalBruto));
                        $('#totalNeto').html(formatearMoneda(totalNeto));
                        $('#descuento').html(formatearMoneda(descuentoTotal));
                        $('#inputTotal').val(formatearMoneda(total));
                        $('#hiddenTotalBruto').val(totalBruto);
                        $('#igv_input').val(igv);
                        $('#hiddenTotalNeto').val(totalNeto);

                    }

                }
                function formatearMoneda(valor) {
                    // Formato colombiano: $2.856.000 (punto de miles, sin decimales)
                    return '$' + (Math.round(parseFloat(valor)) || 0).toLocaleString('es-CO', { maximumFractionDigits: 0 });
                }

                // Convierte un valor mostrado ("$600.000") a número (600000)
                function parseValor(valor) {
                    return parseFloat(String(valor).replace(/[$.\s]/g, '')) || 0;
                }
                function eliminarProducto(indice, impuesto, descuentoProductoParam) {
                    descuentoTotal -= parseFloat(descuentoProductoParam);
                    sumas -= round(subtotal[indice]);
                    igv = round(sumas / 100 * impuesto);
                    total = round(sumas + igv);
                    totalBruto = round(sumas);
                    totalNeto = total;

                    $('#sumas').html(formatearMoneda(sumas));
                    $('#igv').html(formatearMoneda(igv));
                    $('#total_value').val(formatearMoneda(sumas));
                    $('#totalBruto').html(formatearMoneda(totalBruto));
                    $('#totalNeto').html(formatearMoneda(totalNeto));
                    $('#descuento').html(formatearMoneda(descuentoTotal));
                    $('#inputTotal').val(formatearMoneda(total));
                    $('#hiddenTotalBruto').val(totalBruto);
                    $('#igv_input').val(igv);
                    $('#hiddenTotalNeto').val(totalNeto);
                    $('#fila' + indice).remove();
                }

                function limpiarCampos() {
                    let select = $('#producto_id');
                    select.selectpicker('val', '');
                    $('#cantidad').val('');
                    $('#precio_venta').val('');
                    $('#product_tax').val('');
                    $('#precio_compra').val('');
                    $('#discount_total').val('');
                }

                function round(num, decimales = 2) {
                    var signo = (num >= 0 ? 1 : -1);
                    num = num * signo;
                    if (decimales === 0) 
                        return signo * Math.round(num);
                    num = num.toString().split('e');
                    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
                    num = num.toString().split('e');
                    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
                }

                function showModal(message, icon = 'error') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: icon,
                        title: message
                    })
                }
            </script>
            <script>
        $(document).ready(function() {
    var formListoParaEnviar = false; 

    $('#guardar').on('click', function(event) {
        if (!formListoParaEnviar) {
            event.preventDefault(); 

            var code = $('#code').val();
            var invoiceNumber = $('#invoice_number_purchase').val();
            var fullInvoiceNumber = code + invoiceNumber;

        
            $.ajax({
                url: '/verificar-factura',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    invoice_number_purchase: fullInvoiceNumber
                },
                success: function(response) {
                    if(response.existe) {
                        showModal('El número de factura ya existe.', 'error');
                    } else {
                        
                        formListoParaEnviar = true;
                        $('#guardar').trigger('click'); 
                    }
                },
                error: function(xhr, status, error) {
                    showModal('Ocurrió un error al verificar el número de factura.', 'error');
                }
            });
        }
    });
});
            </script>
            <script>
                document.getElementById('producto_id').addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];
                    var purchasePrice = selectedOption.getAttribute('data-purchase-price');
                    var classificationTax = Number(selectedOption.getAttribute('data-classification-tax').replace('%', ''));

                    if (isNaN(classificationTax)) {
                        console.log('classification_tax no es un número');
                    } else {
                        console.log('classification_tax es un número:', classificationTax);
                    }

                    document.getElementById('precio_compra').value = formatearMoneda(purchasePrice);

                    var productTaxSelect = document.getElementById('product_tax');
                    for (var i = 0; i < productTaxSelect.options.length; i++) {
                        if (Number(productTaxSelect.options[i].value) === classificationTax) {
                            productTaxSelect.options[i].selected = true;
                            break;
                        }
                    }
                });
            </script>

        @endcan
    @endauth
    @guest
        @include('include.falta_sesion')
    @endguest
