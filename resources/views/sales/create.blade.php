    @auth
    @extends('template')
    @can('sales')
        

    @push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <div class="bread_crumb">
        {{ Breadcrumbs::render('sales.create') }}
    </div>
    <br>

    </div>
        
    @section('content')
    <<div class="table-responsive px-3">
        <div class="card-body">
            <form action="{{ route('sales.store') }}" method="post">
                @csrf
                <div class="container-lg mt-4">
                    <div class="row gy-4">
                        <!------venta producto---->
                        <div class="col-xl-8">
                            <div class="text-white bg-primary p-1 text-center fs-5">
                                Detalles de la venta
                            </div>
                            <div class="p-3 border border-3 border-primary">
                                <div class="row gy-4">
                                    <!-----Producto---->
                                    <div class="col-12">
                                        <select name="product_id" id="product_id" class="form-control selectpicker" data-live-search="true" data-size="3" title="Busque un producto aquí">
                                            @foreach ($products as $item)
                                            <option data-purchase="{{ $item->purchase_price }}" value="{{$item->id}}-{{$item->stock}}-{{$item->selling_price}}-{{$item->classification_tax}}-{{$item->factory_reference}}">{{$item->name_product}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-----Impuesto---->
                                    <div class="col-sm-4">
                                        <label for="tax" class="form-label">Impuesto:</label>
                                        <input disabled type="text" name="tax" id="tax" class="form-control" step="0.1">
                                        @error('tax')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>
                                    <!-----Stock--->
                                    <div class="col-sm-4">
                                        <label for="stock" class="form-label">Existencias:</label>
                                        <input disabled type="number" name="stock" id="stock" class="form-control" step="0.1">
                                    </div>
                                    <!-----Precio de venta---->
                                    <div class="col-sm-4">
                                        <label for="selling_price" class="form-label">Precio de venta:</label>
                                        <input type="text" name="selling_price" id="selling_price" class="form-control" inputmode="numeric">
                                    </div>
                                    <!-----Cantidad---->
                                    <div class="col-sm-4">
                                        <label for="amount" class="form-label">Cantidad:</label>
                                        <input type="number" name="amount" id="amount" class="form-control">
                                    </div>
                                    <!----Descuento---->
                                    <div class="col-sm-4">
                                        <label for="discounts" class="form-label">Descuento:</label>
                                        <input type="number" name="discounts" id="discounts" class="form-control">
                                    </div>
                                    <!-----botón para agregar--->
                                    <div class="col-12 text-end">
                                        <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
                                    </div>
                                    <!-----Tabla para el detalle de la venta--->
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="tabla_detalle" class="table table-hover">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Referencia</th>
                                                        <th>Precio Unitario</th>
                                                        <th>Descuento</th>
                                                        <th>%</th>
                                                        <th>Iva</th>
                                                        <th>Subtotal</th>
                                                        <th>Ganancia</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        @foreach (old('arrayidproducto', []) as $index => $idProducto)
                                                        <tr id="fila{{ $index }}">
                                                            <th>{{ $index + 1 }}</th>
                                                            <td>
                                                                <input type="hidden" name="arrayidproducto[]" value="{{ $idProducto }}">
                                                                {{ old('arrayname')[$index] }}
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="arraycantidad[]" value="{{ old('arraycantidad')[$index] }}">
                                                                {{ old('arraycantidad')[$index] }}
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="arrayname[]" value="{{ old('arrayname')[$index] }}">
                                                                {{ old('arrayname')[$index] }}
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="arrayprecioventa[]" value="{{ old('arrayprecioventa')[$index] }}">
                                                                {{ old('arrayprecioventa')[$index] }}
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="arraydescuento[]" value="{{ old('arraydescuento')[$index] }}">
                                                                {{ old('arraydescuento')[$index] }}
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="arrayimpuesto[]" value="{{ old('arrayimpuesto')[$index] }}">
                                                                {{ old('arrayimpuesto')[$index] }}%
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="arrayimpuestoval[]" value="{{ old('arrayimpuestoval')[$index] }}">
                                                                {{ old('arrayimpuestoval')[$index] }}
                                                            </td>
                                                            <td>
                                                                {{ old('arrayprecioventa')[$index] * old('arraycantidad')[$index] }}
                                                            </td>
                                                            <td></td>
                                                            <td>
                                                                <button class="btn btn-danger" type="button" onClick="eliminarProducto('{{ $index }}', '{{ old('arrayprecioventa')[$index] * old('arraycantidad')[$index] }}', '{{ old('arrayimpuestoval')[$index] }}', '{{ old('arraydescuento')[$index] }}', 0)">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th colspan="7">Subtotal</th>
                                                        <th colspan="2"><input type="hidden" name="subtotal" value="0" id="inputSubtotal"><span id="subtotal">0</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th colspan="7">Total Descuentos</th>
                                                        <th colspan="2"><input type="hidden" name="total_discounts" value="0" id="inputTotal_discounts"><span id="total_discounts">0</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th colspan="7">Total Bruto</th>
                                                        <th colspan="2"><input type="hidden" name="gross_totals" value="0" id="inputGross"><span id="gross_totals">0</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th colspan="7">IVA</th>
                                                        <th colspan="2"><input type="hidden" name="taxes_total" value="0" id="inputTaxes"><span id="taxes_total">0</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th colspan="7">Total Factura</th>
                                                        <th colspan="2"> <input type="hidden" name="net_total" value="0" id="inputTotal"><span id="net_total">0</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th colspan="7">Total Ganancias</th>
                                                        <th colspan="2"><span id="total_ganancias">0</span></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <!--Boton para cancelar venta--->
                                    <div class="col-12">
                                        <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Cancelar venta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-----Venta---->
                        <div class="col-xl-4">
                            <div class="text-white bg-success p-1 text-center fs-5">
                                Datos generales
                            </div>
                            <div class="p-3 border border-3 border-success">
                                <div class="row gy-4">
                                    <!--Cliente-->
                                    <div class="col-12">
                                        <label for="clients_id" class="form-label">Cliente <small class="text-muted">(opcional)</small>:</label>
                                        <select name="clients_id" id="clients_id" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona el cliente (opcional)" data-size='3'>
                                            <option value="">— Ninguno (sin cliente) —</option>
                                            @foreach ($clients as $item)
                                            <option value="{{$item->id}}">{{$item->identification_number}} -    {{$item->first_name}} {{$item->other_name}} {{$item->surname}} {{$item->second_surname}} {{$item->company_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('clients_id')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>                                
                                    <!--Fecha--->
                                    <div class="col-sm-12">
                                        <label for="dates" class="form-label">Fecha:</label>
                                        <input readonly type="date" name="dates" id="dates" class="form-control border-success" value="{{ date('Y-m-d') }}">
                                        <input type="hidden" name="dates_hidden" value="{{ \Carbon\Carbon::now()->toDateTimeString() }}">
                                    </div>

                                    <!-- Documento Soporte: prefijo fijo DS + número automático -->
                                    <div class="col-12">
                                        <label for="bill_numbers" class="form-label">Documento Soporte (DS):</label>
                                        <div class="input-group">
                                            <span class="input-group-text fw-bold">DS-</span>
                                            <input type="number" name="bill_numbers" id="bill_numbers" class="form-control bg-light" value="{{ $nextSaleId }}" readonly tabindex="-1" style="cursor: not-allowed;">
                                        </div>
                                        <small class="text-muted">El prefijo es fijo (DS) y el número se asigna automáticamente.</small>
                                        {{-- El prefijo real que se guarda --}}
                                        <input type="hidden" name="bill_prefix" value="DS-">
                                        @error('bill_numbers')
                                            <small class="text-danger d-block">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>


                                    <!--Forma de pago-->
                                    <div class="col-12">
                                        <label for="payments_methods" class="form-label">Forma de pago:</label>
                                        <select required name="payments_methods" class="form-control selectpicker" title="Selecciona la forma de pago">
                                            <option value="Efectivo">Efectivo</option>
                                            <option value="Consignación">Consignación</option>
                                            <option value="Tarjeta">Tarjeta</option>
                                        </select>
                                        @error('payments_methods')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>
                                    <!--Vendedor-->
                                    <div class="col-12">
                                        <label for="sellers" class="form-label">Vendedor:</label>
                                        <select required name="sellers" id="sellers" class="form-control selectpicker" title="Selecciona el vendedor" data-size='3'>
                                            @foreach ($users as $item)
                                            <option value="{{$item->name}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('sellers')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="factory_reference" id="factory_reference">
                                    <!--Botones--->
                                    <div class="col-12 text-center">
                <br>
                                        <button type="submit" class="btn btn-success" id="guardar">Realizar venta</button>
                                    
                                                <a class="btn btn-primary" style="margin-right: 2rem" href="{{ route('sales.index') }}">Regresar</a>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                
            </form>
        
        </div>
    
        <!-- Modal para cancelar la venta -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Advertencia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que quieres cancelar la venta?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button id="btnCancelarVenta" type="button" class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    
    @endsection
    {{-- @endcan --}}
    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#product_id').change(mostrarValores);
            $('#btn_agregar').click(agregarProducto);
            $('#btnCancelarVenta').click(cancelarVenta);
            disableButtons();
        });

        let cont = 0;
        let subtotal = [];
        let sumas = 0;
        let igv = 0;
        let total = 0;
        let totalDescuentos = 0;
        let totalGanancias = 0;

        // Formato colombiano: $2.856.000 (punto de miles, sin decimales)
        function formatoMoneda(valor) {
            return '$' + Math.round(parseFloat(valor) || 0).toLocaleString('es-CO', { maximumFractionDigits: 0 });
        }

        // Convierte un valor mostrado ("$600.000") a número (600000)
        function parseValor(valor) {
            return parseFloat(String(valor).replace(/[$.\s]/g, '')) || 0;
        }

        function mostrarValores() {
            let dataProducto = document.getElementById('product_id').value.split('-');
            $('#stock').val(dataProducto[1]);
            $('#selling_price').val(formatoMoneda(dataProducto[2]));
            $('#tax').val(dataProducto[3]);
            $('#factory_reference').val(dataProducto[4]);
        }

        function agregarProducto() {
            let dataProducto = document.getElementById('product_id').value.split('-');
            let idProducto = dataProducto[0];
            let nameProducto = $('#product_id option:selected').text();
            let cantidad = $('#amount').val();
            let precioVenta = parseValor($('#selling_price').val());
            let descuento = $('#discounts').val();
            let stock = $('#stock').val();
            let factoryreference = $('#factory_reference').val();
            let impuesto = parseFloat(dataProducto[3]);
            let precioCompra = parseFloat($('#product_id option:selected').data('purchase')) || 0;


            if (descuento === '') {
                descuento = 0;
            }

            if ($("#tabla_detalle input[name='arrayidproducto[]']").filter(function() {
                return $(this).val() == idProducto;
            }).length > 0) {
                showModal('El producto ya está en la lista');
                return;
            }

            if (parseFloat(descuento) > parseFloat(precioVenta)) {
                showModal('El descuento no puede ser mayor que el precio del producto');
                return;
            }

            if (idProducto !== '' && cantidad !== '') {
                if (parseInt(cantidad) > 0 && (cantidad % 1 === 0) && parseFloat(descuento) >= 0) {
                    if (parseInt(cantidad) <= parseInt(stock)) {
                        let subtotalProducto = round(cantidad * precioVenta);
                        subtotal[cont] = subtotalProducto;
                        sumas += subtotal[cont];
                        let impuestoval = round(subtotalProducto / 100 * impuesto);
                        igv += impuestoval;
                        totalDescuentos += parseFloat(descuento);
                        let totalbruto = round(sumas - totalDescuentos);
                        total = round(totalbruto + igv);

                        // Ganancia = (precio_venta * cantidad) - descuento - (precio_compra * cantidad)
                        let ganancia = round((precioVenta * cantidad) - parseFloat(descuento) - (precioCompra * cantidad));
                        totalGanancias += ganancia;

                        let fila = '<tr id="fila' + cont + '">' +
                            '<th>' + (cont + 1) + '</th>' +
                            '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' + nameProducto + '</td>' +
                            '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad + '</td>' +
                            '<td><input type="hidden" name="arrayname[]" value="' + factoryreference + '">' + factoryreference + '</td>' +
                            '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' + formatoMoneda(precioVenta) + '</td>' +
                            '<td><input type="hidden" name="arraydescuento[]" value="' + descuento + '">' + formatoMoneda(descuento) + '</td>' +
                            '<td><input type="hidden" name="arrayimpuesto[]" value="' + impuesto + '">' + impuesto + '%</td>' +
                            '<td><input type="hidden" name="arrayimpuestoval[]" value="' + impuestoval + '">' + formatoMoneda(impuestoval) + '</td>' +
                            '<td>' + formatoMoneda(subtotalProducto) + '</td>' +
                            '<td>' + formatoMoneda(ganancia) + '</td>' +
                            '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto(' + cont + ', ' + subtotalProducto + ', ' + impuestoval + ', ' + descuento + ', ' + ganancia + ')"><i class="fa-solid fa-trash"></i></button></td>' +
                            '</tr>';

                        $('#tabla_detalle').append(fila);
                        limpiarCampos();
                        cont++;
                        disableButtons();

                        actualizarTotales();
                    } else {
                        showModal('Cantidad incorrecta');
                    }
                } else {
                    showModal('Valores incorrectos');
                }
            } else {
                showModal('Faltan campos por llenar');
            }
        }

        function eliminarProducto(index, subtotalProducto, impuestoval, descuento, ganancia) {
            sumas -= subtotalProducto;
            igv -= impuestoval;
            totalDescuentos -= parseFloat(descuento);
            totalGanancias -= parseFloat(ganancia) || 0;
            let totalbruto = round(sumas - totalDescuentos);
            total = round(totalbruto + igv);

            $('#fila' + index).remove();

            actualizarTotales();
        }

        function cancelarVenta() {
            $('#tabla_detalle tbody').empty();

            cont = 0;
            subtotal = [];
            sumas = 0;
            igv = 0;
            total = 0;
            totalDescuentos = 0;
            totalGanancias = 0;

            actualizarTotales();
            limpiarCampos();
            disableButtons();
        }

        function actualizarTotales() {
            $('#subtotal').html(formatoMoneda(sumas));
            $('#inputSubtotal').val(sumas);
            $('#taxes_total').html(formatoMoneda(igv));
            $('#inputTaxes').val(igv);
            $('#gross_totals').html(formatoMoneda(sumas - totalDescuentos));
            $('#inputGross').val(sumas - totalDescuentos);
            $('#net_total').html(formatoMoneda(total));
            $('#inputTotal').val(total);
            $('#total_discounts').html(formatoMoneda(totalDescuentos));
            $('#inputTotal_discounts').val(totalDescuentos);
            $('#total_ganancias').html(formatoMoneda(totalGanancias));

            disableButtons();
        }

        function disableButtons() {
            if (total == 0) {
                $('#guardar').hide();
                $('#cancelar').hide();
            } else {
                $('#guardar').show();
                $('#cancelar').show();
            }
        }

        function limpiarCampos() {
            let select = $('#product_id');
            select.selectpicker('val', '');
            $('#amount').val('');
            $('#selling_price').val('');
            $('#discounts').val('');
            $('#stock').val('');
            $('#tax').val('');
            $('#factory_reference').val('');
        }

        function showModal(message, icon = 'error') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: icon,
                title: message
            });
        }

        function round(num, decimales = 2) {
            return Math.round(num * Math.pow(10, decimales)) / Math.pow(10, decimales);
        }
    </script>
    @endpush

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


