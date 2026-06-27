@auth
@include('include.barra', ['modo'=>'Detalle de Compra'])
@can('detail-purchases')

<!DOCTYPE html>
<html>
<body>
    <div class="bread_crumb">
        {{ Breadcrumbs::render('compras.show', $detailPurchase)}}
    </div>
@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush
<br>
<div class="container-fluid">

    <div class="card mb-4">
        <div class="card-header">
            Datos generales de la Compra
        </div>
            <div class="card-body">
                <!---Numero De Factura--->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                            <input disabled type="text" class="form-control" value="Número de Factura: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                            <input disabled type="text" class="form-control" value="{{ $invoice_number }}" readonly>
                        </div>
                    </div>
                </div>
                <!---Proveedor--->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                            <input disabled type="text" class="form-control" value="Proveedor: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Proveedor" class="input-group-text" id="icon-form"><i class="fa-solid fa-user-tie"></i></span>
                            <input disabled type="text" class="form-control" value="{{ optional($detailPurchase->purchaseSupplier->person)->identification_number ?? 'Sin proveedor' }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input disabled type="text" class="form-control" value="Empleado: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Empleado A Cargo" class="input-group-text" id="icon-form"><i class="fa-solid fa-user"></i></span>
                            <input disabled type="text" class="form-control" value="{{ $detailPurchase->purchaseSupplier->user->name ?? 'Sin empleado' }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="input-group" id="hide-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                            <input disabled type="text" class="form-control" value="Fecha: ">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span title="Fecha" class="input-group-text" id="icon-form"><i class="fa-solid fa-calendar-days"></i></span>
                            <input disabled type="text" class="form-control" value="{{ \Carbon\Carbon::parse($detailPurchase->purchaseSupplier->fecha_hora)->format('d-m-Y') }}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <div class="input-group">
                    <input type="hidden" id="product_tax" name="product_tax" class="form-control" value="{{ isset($detailPurchase) ? $detailPurchase->product_tax.'%' : '' }}" readonly>
                </div>
            </div>
            
        </div>
    </div>

    <!---Tabla--->
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla de detalle de la Compra
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr class="align-top">
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Descripcion</th>
                        <th>Precio Unitario</th>
                        <th>Descuento</th>
                        <th>%</th>
                        <th>Iva</th>
                        <th>Precio Unitario De Venta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailPurchases as $detailPurchase)
                        <tr class="detailPurchase">
                            <td>{{ $detailPurchase->product->name_product }}</td>
                            <td class="quantity_units">{{ $detailPurchase->quantity_units }}</td>
                            <td>{{ $detailPurchase->description }}</td>
                            <td class="price_unit">{{ round($detailPurchase->price_unit, 2) }}</td>
                            <td>{{ $detailPurchase->discount_total }}</td>
                            <td class="product_tax">{{ round($detailPurchase->product_tax, 2).'%' }}</td>
                            <td class="iva">{{ $iva = $detailPurchase->quantity_units * $detailPurchase->price_unit * $detailPurchase->product_tax / 100 }}</td>
                            <td class="subtotal">{{ $detailPurchase->quantity_units * $detailPurchase->price_unit }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="8"></th>
                    </tr>
                    <tr>
                        <th colspan="7">Subtotal:</th>
                        <th id="th-igv">${{ number_format($total_value, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="7">Descuento:</th>
                        <th id="th-discount">${{ number_format($detailPurchases->sum('discount_total'), 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="7">Total Bruto:</th>
                        <th id="th-total">${{ number_format($gross_total, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="7">IVA %</th>
                        <th id="th-igv">${{ number_format($total_tax, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="7">Total Factura:</th>
                        <th id="th-total">${{ number_format($net_total, 0, ',', '.') }}</th>
                    </tr>
                    
                    
                </tfoot>
            </table>
        </div>
    </div>
<div class="card-footer text-end">
    <a class="btn btn-primary" style="margin-right: 2rem" href="{{ route('detail-purchases.index') }}">Regresar</a>
</div>
</div>
@push('js')
<script>
    //Variables
    let filasSubtotal = document.getElementsByClassName('td-subtotal');
    let cont = 0;
    let impuesto = $('#input-impuesto').val();

    $(document).ready(function() {
        calcularValores();
    });

    function calcularValores() {
        for (let i = 0; i < filasSubtotal.length; i++) {
            cont += parseFloat(filasSubtotal[i].innerHTML);
        }

        // Los totales (Subtotal, Descuento, Total Bruto, IVA, Total Factura) ya vienen
        // calculados y formateados desde el servidor; no se sobreescriben aquí.
    }

    function round(num, decimales = 2) {
        var signo = (num >= 0 ? 1 : -1);
        num = num * signo;
        if (decimales === 0) //con 0 decimales
            return signo * Math.round(num);
        // round(x * 10 ^ decimales)
        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
        // x * 10 ^ (-decimales)
        num = num.toString().split('e');
        return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
    }
    //Fuente: https://es.stackoverflow.com/questions/48958/redondear-a-dos-decimales-cuando-sea-necesario
</script>
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
