@auth
@can('sales')

<div class="bread_crumb">
    {{ Breadcrumbs::render('sales.show', $sale) }}
</div>
<br>

@extends('template')

@section('title','Ver venta')

@section('content')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush
<div class="container-fluid">

    <div class="card mb-4">

        <div class="card-header">
            Datos generales de la venta
        </div>

        <div class="card-body">
     <!---Numero comprobante--->
     <div class="row mb-4">
        <div class="col-sm-6">
            <div class="input-group" id="hide-group">
                <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                <input disabled type="text" class="form-control" value="Comprobante: ">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group">
                <span title="Número de comprobante" id="icon-form" class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                <input disabled type="text" class="form-control" value="{{$sale->bill_numbers}}">
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
                <input disabled type="text" class="form-control" value="{{ \Carbon\Carbon::parse($sale->fecha_hora)->format('d-m-Y') }}">
            </div>
        </div>
    </div>
    <!---Cliente--->
    <div class="row mb-4">
        <div class="col-sm-6">
            <div class="input-group" id="hide-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input disabled type="text" class="form-control" value="Cliente: ">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group">   
                <span title="Cliente" class="input-group-text" id="icon-form"><i class="fa-solid fa-user"></i></span>
                <input disabled type="text" class="form-control" value="{{$sale->cliente?->identification_number}} - {{$sale->cliente?->company_name}}{{$sale->cliente?->first_name}} {{$sale->cliente?->other_name}} {{$sale->cliente?->surname}} {{$sale->cliente?->second_surname}}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-sm-6">
            <div class="input-group" id="hide-group">
                <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                <input disabled type="text" class="form-control" value="Vendedor: ">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group">
                <span title="Vendedor" class="input-group-text" id="icon-form"><i class="fa-solid fa-user-tie"></i></span>
                <input disabled type="text" class="form-control" value="{{$sale->sellers}}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-sm-6">
            <div class="input-group" id="hide-group">
                <span class="input-group-text"><i class="fa-solid fa-credit-card"></i></span>
                <input disabled type="text" class="form-control" value="Forma de pago: ">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group">
                <span title="Forma de pago" class="input-group-text" id="icon-form"><i class="fa-solid fa-credit-card"></i></span>
                <input disabled type="text" class="form-control" value="{{$sale->payments_methods}}">
            </div>
        </div>
    </div>

   

        <div class="col-sm-6">
            <div class="input-group">
                <input type="hidden"   id="input-impuesto" disabled type="text" class="form-control" value="{{ $sale->taxes_total }}">
            </div>

        </div>

        <div class="col-sm-6">
            <div class="input-group">
                <input type="hidden"   id="input-descuentos" disabled type="text" class="form-control" value="{{ $sale->total_discounts }}">
            </div>

        </div>
    </div>
</div>
</div>
    <!---Tabla--->
    <div class="card mb-2">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla de detalle de la venta
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr class="align-top">
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Referencia</th>
                        <th>Precio unitario</th>
                        <th>Descuento</th>
                        <th>%</th>
                        <th>IVA</th> 
                        <th>Precio unitario de venta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->productos as $item)
                    <tr>
                        <td>{{$item->name_product}}</td>
                        <td>{{$item->pivot->amount}}</td>
                        <td>{{$item->pivot->references}}</td>
                        <td class="td-selling-price">${{ number_format($item->pivot->selling_price, 0, ',', '.') }}</td>
                        <td class="td-discount">${{ number_format($item->pivot->discounts, 0, ',', '.') }}</td>
                        <td>{{$item->pivot->tax}}</td>
                        <td class="td-iva">${{ number_format($item->pivot->iva, 0, ',', '.') }}</td>
                        <td class="td-subtotal">
                            ${{ number_format(($item->pivot->amount) * ($item->pivot->selling_price), 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7"></th>
                    </tr>
                    <tr>
                        <th colspan="7">Subtotal:</th>
                        <th id="th-suma"></th>
                    </tr>
                    <tr>
                        <th colspan="7">Total Descuentos:</th>
                        <th id="th-descuentos"></th>
                    </tr>
                    <tr>
                        <th colspan="7">Total Bruto:</th>
                        <th id="th-gross"></th>
                    </tr>
                    <tr>
                        <th colspan="7">IVA:</th>
                        <th id="th-igv"></th>
                    </tr>
                    <tr>
                        <th colspan="7">Total Factura:</th>
                        <th id="th-total"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer text-end">
        <a class="btn btn-primary" style="margin-right: 2rem" href="{{ route('sales.index') }}">Regresar</a>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        calcularValores();
    });

    function calcularValores() {
        let filasSubtotal = document.getElementsByClassName('td-subtotal');
        let filasDescuento = document.getElementsByClassName('td-discount');
        let filasIVA = document.getElementsByClassName('td-iva');
        let cont = 0;
        let totalDescuentos = 0;
        let igv = 0;

        // Calcular el subtotal
        for (let i = 0; i < filasSubtotal.length; i++) {
            cont += parseFloat(filasSubtotal[i].innerHTML.replace(/[$.\s]/g, ''));
            totalDescuentos += parseFloat(filasDescuento[i].innerHTML.replace(/[$.\s]/g, ''));
            igv += parseFloat(filasIVA[i].innerHTML.replace(/[$.\s]/g, ''));
        }

        // Calcular total bruto
        let totalbruto = cont - totalDescuentos;

        // Redondear los valores si es necesario
        let sumaRedondeada = round(cont);
        let totalBrutoRedondeado = round(totalbruto);
        let igvRedondeado = round(igv);
        let totalRedondeado = round(totalbruto + igv);

        // Mostrar los valores en las celdas correspondientes
        $('#th-suma').html(formatCurrency(sumaRedondeada));
        $('#th-descuentos').html(formatCurrency(totalDescuentos));
        $('#th-gross').html(formatCurrency(totalBrutoRedondeado));
        $('#th-igv').html(formatCurrency(igvRedondeado));
        $('#th-total').html(formatCurrency(totalRedondeado));
    }

    function round(num, decimales = 2) {
        return Math.round(num * Math.pow(10, decimales)) / Math.pow(10, decimales);
    }

    function formatCurrency(value) {
        // Formato colombiano: $2.856.000 (punto de miles, sin decimales)
        return '$' + Math.round(value).toLocaleString('es-CO', { maximumFractionDigits: 0 });
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
