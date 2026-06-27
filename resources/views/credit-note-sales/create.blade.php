@auth
@can('sales')

@extends('template')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<div class="bread_crumb">
    {{ Breadcrumbs::render('credit.note.sales.create') }}
</div>
<br>
@section('content')

<div class="content container-fluid">
    <div class="page-body">
        <div class="container-x1">
            <div class="row row-cards">
                <div class="col-lg-12">
                    <div class="card card-default">
                        <div class="card-header d-flex">
                            <h3 class="card-title">
                                {{__('Nota Crédito Ventas')}}
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('credit-note-sales.store') }}" method="post" id="create">
                                @csrf
                                <div class="row row-cards">
                                    {{--  Buscar Un Numero De Factura  --}}
                                    <div class="col-sm-6 md-6">
                                        <div class="md-3 mb-3">
                                            <label for="datos" class="form-label fw-bolder">
                                                {{ __('Venta') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="datos" id="datos" class="form-control selectpicker" data-live-search="true" data-size="3" title="Busque una venta aquí">
                                                @foreach ($sales as $key => $sale)
                                                    <option value="{{$sale->id}}-{{$sale->dates}}-{{$sale->sellers}}-{{$sale->cliente->identification_number}}-{{$sale->clients_id}}-{{$sale->payments_methods}}">{{$sale->bill_numbers}}</option>
                                                @endforeach
                                            </select>
                                            @error('datos')
                                            <small class="text-danger">{{ '*'.$message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  Fecha De Elaboracion Nota Credito  --}}
                                    <div class="col-sm-6 md-6">
                                        <div class="md-3 mb-3">
                                            <label for="date_credit_notes" class="form-label fw-bolder">
                                                {{ __('Fecha de Creación Nota Crédito') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" id="date_credit_notes" name="date_credit_notes" value="{{ date('Y-m-d') }}" class="form-control" readonly>
                                            @error('date_credit_notes')
                                            <small class="text-danger">{{ '*'.$message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  Cliente  --}}
                                    <div class="col-sm-6 md-6">
                                        <div class="mb-3">
                                            <label for="cliente-id" class="form-label fw-bolder">
                                                {{ __('Cliente') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="cliente-id" id="cliente-id" class="form-control" readonly>
                                            @error('cliente-id')
                                            <small class="text-danger">{{ '*'.$message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  Vendedor --}}
                                    <div class="col-sm-6 md-6">
                                        <div class="mb-3">
                                            <label for="sellers" class="form-label fw-bolder">
                                                {{ __('Vendedor') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="sellers" id="sellers" class="form-control" readonly>
                                            @error('sellers')
                                            <small class="text-danger">{{ '*'.$message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  Metodo de pago --}}
                                    <div class="col-sm-6 md-6">
                                        <div class="mb-3">
                                            <label for="payments_methods" class="form-label fw-bolder">
                                                {{ __('Método de Pago')}}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="payments_methods" id="payments_methods" class="form-control" readonly>
                                            @error('payments_methods')
                                            <small class="text-danger">{{ '*'.$message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  Fecha Detalle De Compra  --}}
                                    <div class="col-sm-6 md-6">
                                        <div class="md-3 mb-3">
                                            <label for="date_invoice" class="form-label fw-bolder">
                                                {{ __('Fecha de Compra') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="date_invoice" id="date_invoice" class="form-control" readonly>
                                            @error('date_invoice')
                                            <small class="text-danger">{{ '*'.$message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    {{--  Motivo  --}}
                                    <div class="col-sm-6 md-6">
                                        <div class="mb-3">
                                            <label for="reason" class="form-label fw-bolder">
                                                {{ __('Motivo')}}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="reason" id="reason" class="form-control selectpicker" data-live-search="true" data-size="6" title="Motivo ...">
                                                <option value="Devolución  de parte de los bienes">Devolución de parte de los bienes</option>
                                                <option value="Anulación  de factura electrónica">Anulación de factura electrónica</option>
                                                <option value="Rebaja o descuento parcial o total">Rebaja o descuento parcial o total</option>
                                                <option value="Ajuste de precio">Ajuste de precio</option>
                                                <option value="Otros">Otros</option>
                                            </select>
                                        </div>
                                        @error('reason')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                        <br>
                                    </div>

                                    <div class="col-12">
                                        <table id="tablaDetalleVenta" class="table table-hover w-100">
                                            <thead class="bg-dark-blue">
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Referencia</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Descuento</th>
                                                    <th>%</th>
                                                    <th>Iva</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-12 text-end">
                                                <div class="row">
                                                    <div class="col-md-6 text-end">
                                                        <label for="subtotal" class="form-label">Subtotal:</label>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <input type="number" id="subtotal" name="subtotal" value="0" class="form-control transparent-input" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 text-end">
                                                        <label for="total_discounts" class="form-label">Total Descuento:</label>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <input type="number" id="total_discounts" name="total_discounts" value="0" class="form-control transparent-input" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 text-end">
                                                        <label for="gross_totals" class="form-label">Total Bruto:</label>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <input type="number" id="gross_totals" name="gross_totals" value="0" class="form-control transparent-input" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 text-end">
                                                        <label for="taxes_total" class="form-label">Iva:</label>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <input type="number" id="taxes_total" name="taxes_total" value="0" class="form-control transparent-input" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 text-end">
                                                        <label for="net_total" class="form-label">Total Factura:</label>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <input type="number" id="net_total" name="net_total" value="0" class="form-control transparent-input" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="sale_id" id="sale_id">
                                        <input type="hidden" name="clients_id" id="clients_id">
                                    </div>
                                </div>

                        </div>
                        <div class="card-footer text-end">
                            <br>
                                <a class="btn btn-primary" style="margin-right: 2rem" href="{{ route('credit-note-sales.index') }}">Regresar</a>
                                <button type="submit" class="btn btn-success">Realizar Nota</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script>
   $(document).ready(function() {
    $('#datos').change(mostrarValores);

    $(document).on('input', 'input[name="amount[]"], input[name="selling_price[]"]', recalcularPrecios);

    $('.selectpicker').selectpicker();
});

    function mostrarValores() {
    let dataVenta = document.getElementById('datos').value.split('-');
    let fecha = dataVenta.slice(1, 4).join('-');
    $('#cliente-id').val(dataVenta[5]);
    $('#clients_id').val(dataVenta[6]); 
    $('#date_invoice').val(fecha);
    $('#sellers').val(dataVenta[4]); 
    $('#payments_methods').val(dataVenta[7]); 
    let selectedSaleId = dataVenta[0]; 
    $('#sale_id').val(selectedSaleId);
    let totalSubtotales = 0; 
    let totalDescuentos = 0; 
    let totalImpuestos = 0; 

   
    $.ajax({
        url: '/obtener-detalle-venta',
        type: 'GET',
        data: { sale_id: selectedSaleId },
        success: function(response) {
         
            $('#tablaDetalleVenta tbody').empty();

           
            response.detallesVenta.forEach(function(detalle) {
               
                var subtotal = (detalle.amount * detalle.selling_price);
                totalSubtotales += subtotal;

               
                var impuesto = detalle.tax;
                totalImpuestos += (subtotal * impuesto) / 100;

             
                totalDescuentos += parseFloat(detalle.discounts);

                $('#tablaDetalleVenta tbody').append(`
                    <tr>
                        <input type="hidden" name="arrayidproducto[]" class="form-control" value="${detalle.product_id}" readonly>
                        <td><input type="text" name="arrayname[]" class="form-control" value="${detalle.producto.name_product}" readonly></td>
                        <td><input type="text" name="amount[]" class="form-control" value="${detalle.amount}"></td>
                        <td><input type="text" name="arrayreference[]" class="form-control" value="${detalle.references}" readonly></td>
                        <td><input type="text" name="selling_price[]" class="form-control" value="${detalle.selling_price}"></td>
                        <td><input type="text" name="discounts[]" class="form-control" value="${detalle.discounts}" readonly></td>
                        <td><input type="text" name="tax[]" class="form-control" value="${detalle.tax}" readonly></td>
                        <td><input type="text" name="arrayimpuestoval[]" class="form-control" value="${((subtotal * impuesto) / 100).toFixed(2)}" readonly></td>
                        <td class="td-subtotal">${subtotal.toFixed(2)}</td>
                    </tr>
                `);
            });

           
            var totalBruto = totalSubtotales - totalDescuentos;
            var totalFactura = totalBruto + totalImpuestos;
            

           
            $('#subtotal').val(totalSubtotales.toFixed(2));

         
            $('#total_discounts').val(totalDescuentos.toFixed(2));

           
            $('#gross_totals').val(totalBruto.toFixed(2));

           
            $('#taxes_total').val(totalImpuestos.toFixed(2));

        
            $('#net_total').val(totalFactura.toFixed(2));
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}


function recalcularPrecios() {
    $('#tablaDetalleVenta tbody tr').each(function() {
        var fila = $(this);

        var cantidad = parseInt(fila.find('input[name="amount[]"]').val());
        var precioVenta = parseFloat(fila.find('input[name="selling_price[]"]').val());
        var descuento = parseFloat(fila.find('input[name="discounts[]"]').val());
        var impuesto = parseFloat(fila.find('input[name="tax[]"]').val());

        var subtotal = (cantidad * precioVenta);
        var impuestoval = (subtotal * impuesto) / 100;

        fila.find('.td-subtotal').text(subtotal.toFixed(2));
        fila.find('input[name="arrayimpuestoval[]"]').val(impuestoval.toFixed(2));
    });

    recalcularTotales(); 
}

function recalcularTotales() {
    var totalSubtotales = 0;
    var totalDescuentos = 0;
    var totalImpuestos = 0;

    $('#tablaDetalleVenta tbody tr').each(function() {
        var subtotalFila = parseFloat($(this).find('.td-subtotal').text());
        var descuentoFila = parseFloat($(this).find('input[name="discounts[]"]').val());
        var impuestoFila = parseFloat($(this).find('input[name="arrayimpuestoval[]"]').val());

        totalSubtotales += subtotalFila;
        totalDescuentos += descuentoFila;
        totalImpuestos += impuestoFila;
    });

    var totalBruto = totalSubtotales - totalDescuentos;
    var totalFactura = totalBruto + totalImpuestos;



    $('#subtotal').val(totalSubtotales.toFixed(2));
    $('#total_discounts').val(totalDescuentos.toFixed(2));
    $('#gross_totals').val(totalBruto.toFixed(2));
    $('#taxes_total').val(totalImpuestos.toFixed(2));
    $('#net_total').val(totalFactura.toFixed(2));
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
        });

        Toast.fire({
            icon: icon,
            title: message
        });
    }

   
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('create'); 

        form.addEventListener('submit', function (event) {
            const reason = document.getElementById('reason').value;
            const ventaSeleccionada = document.getElementById('datos').value;

            // Verificar motivo
            if (!reason) {
                event.preventDefault(); 
                showModal('Por favor, selecciona el motivo.', 'error');
                return; 
            }

          
            if (ventaSeleccionada === '') {
                event.preventDefault();
                showModal('Por favor, seleccione una venta.', 'error');
                return; 
            }

            
            const cantidadInputs = document.querySelectorAll('input[name="amount[]"]');
for (let i = 0; i < cantidadInputs.length; i++) {
    const cantidad = parseInt(cantidadInputs[i].value);
    if (!cantidad || cantidad < 1) {
        event.preventDefault(); 
        const productName = cantidadInputs[i].closest('tr').querySelector('input[name="arrayname[]"]').value;
        showModal(`Por favor, ingresa una cantidad válida (mayor o igual a 1) para el producto "${productName}".`, 'error');
        return;
    }

    const precioVenta = parseFloat(cantidadInputs[i].closest('tr').querySelector('input[name="selling_price[]"]').value);
    if (!precioVenta || precioVenta <= 0) {
        event.preventDefault();
        const productName = cantidadInputs[i].closest('tr').querySelector('input[name="arrayname[]"]').value;
        showModal(`Por favor, ingresa un precio de venta válido (mayor a 0) para el producto "${productName}".`, 'error');
        return;
    }
}
        });
    });
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
