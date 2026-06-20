@auth
@can('sales')

@extends('template')

@section('title','Ver nota crédito')
<div class="bread_crumb">
    {{ Breadcrumbs::render('credit.note.sales.show', $credit_note_sale) }}
</div>
<br>
@section('content')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush

<div class="content container-fluid">
    <div class="page-body">
        <div class="container-x1">
            <div class="row row-cards">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default">
                            <div class="card-header d-flex">
                                <h3 class="card-title">
                                    {{__('Nota Crédito Ventas')}}
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('credit-note-sales.store') }}" method="post">
                                    @csrf
                                    <div class="row row-cards">
                                        {{--  Buscar Un Numero De Factura  --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="md-3 mb-3">
                                                <label for="datos" class="form-label fw-bolder">
                                                    {{ __('Venta') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input disabled type="text" name="clients_id" id="clients_id" value="{{$credit_note_sale->venta->bill_numbers}}" class="form-control">
                                                {!! $errors->first('datos', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                            {{--  Fecha De Elaboracion Nota Credito  --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="md-3 mb-3">
                                                <label for="date_credit_notes" class="form-label fw-bolder">
                                                    {{ __('Fecha de Creación Nota Credito') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input disabled  type="date" name="date_invoice" id="date_invoice" class="form-control" value="{{$credit_note_sale->date_credit_notes}}">
                                                {!! $errors->first('date_credit_notes', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Cliente  --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="clients_id" class="form-label fw-bolder">
                                                    {{ __('Cliente') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input disabled type="text" name="clients_id" id="clients_id" value="{{$credit_note_sale->cliente->identification_number}} - {{$credit_note_sale->cliente->company_name}}{{$credit_note_sale->cliente->first_name}} {{$credit_note_sale->cliente->other_name}} {{$credit_note_sale->cliente->surname}} {{$credit_note_sale->cliente->second_surname}} " class="form-control">
                                                {!! $errors->first('clients_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Vendedor --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="sellers" class="form-label fw-bolder">
                                                    {{ __('Vendedor') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input disabled type="text" name="sellers" id="sellers" value="{{$credit_note_sale->sellers}}" class="form-control">
                                                {!! $errors->first('sellers', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Metodo de pago --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="payments_methods" class="form-label fw-bolder">
                                                    {{ __('Método de Pago')}}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input disabled type="text" name="payments_methods" id="payments_methods" value="{{$credit_note_sale->payments_methods}}" class="form-control">
                                                {!! $errors->first('payments_methods', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Fecha Detalle De Compra  --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="md-3 mb-3">
                                                <label for="date_invoice" class="form-label fw-bolder">
                                                    {{ __('Fecha de Compra') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input disabled  type="date" name="date_invoice" id="date_invoice" class="form-control" value="{{$credit_note_sale->date_invoice}}">
                                                {!! $errors->first('date_invoice', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        {{--  Motivo --}}
                                        <div class="col-sm-6 md-6">
                                            <div class="mb-3">
                                                <label for="reason" class="form-label fw-bolder">
                                                    {{ __('Motivo')}}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input disabled  type="text" name="reason" id="reason" class="form-control" value="{{$credit_note_sale->reason}}">
                                                {!! $errors->first('reason', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </form>
                                {{-- Tabla de detalles de venta --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tablaDetalleVenta" class="table table-hover w-100">
                                            <style>
                                                .bg-dark-blue {
                                                    background-color: #004080; /* Este es el código de color hexadecimal para azul oscuro */
                                                }
                                            </style>
                                            <thead class="bg-dark-blue">
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Referencia</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Descuento</th>
                                                    <th>%</th>
                                                    <th>Iva</th>
                                                    <th>Precio unitario de venta</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($credit_note_sale->productos as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->name_product}}
                                                    </td>
                                                    <td>
                                                        {{$item->pivot->amount}}
                                                    </td>
                                                    <td>
                                                        {{$item->pivot->references}}
                                                    </td>
                                                    <td>
                                                        ${{ number_format($item->pivot->selling_price, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        ${{ number_format($item->pivot->discounts, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        {{$item->pivot->tax}}
                                                    </td>
                                                    <td>
                                                        ${{ number_format($item->pivot->iva, 0, ',', '.') }}
                                                    </td>
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
                                            {{-- Input oculto para el ID de venta --}}
                                            <input type="hidden" name="sale_id" id="sale_id">
                                        </div>
                                    </div>
                                </div>
                                {{-- Footer de la tarjeta --}}
                                <div class="card-footer text-end">
                                    <a class="btn btn-primary" style="margin-right: 2rem" href="{{ route('credit-note-sales.index') }}">Regresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @push('js')
    <script>
        let filasSubtotal = document.getElementsByClassName('td-subtotal');
        let cont = 0;
        let impuesto = parseFloat("{{ $credit_note_sale->taxes_total }}");
        let descuento = parseFloat("{{ $credit_note_sale->total_discounts }}");
        let totalbruto = parseFloat("{{ $credit_note_sale->gross_totals }}");
    
        $(document).ready(function() {
            calcularValores();
        });
    
        function calcularValores() {
            cont = 0;
            for (let i = 0; i < filasSubtotal.length; i++) {
    cont += parseFloat(filasSubtotal[i].innerHTML.replace('$', '').replace(/,/g, ''));
}
    
            let sumaFormateada = formatCurrency(cont.toFixed(2));
            let igvFormateado = formatCurrency(impuesto.toFixed(2));
            let descuentoFormateado = formatCurrency(descuento.toFixed(2));
            let totalbrutoFormateado = formatCurrency(totalbruto.toFixed(2));
            let totalFormateado = formatCurrency(round(totalbruto + impuesto, 2).toFixed(2));
    
            $('#th-suma').text(sumaFormateada);
            $('#th-igv').text(igvFormateado);
            $('#th-descuentos').text(descuentoFormateado);
            $('#th-gross').text(totalbrutoFormateado);
            $('#th-total').text(totalFormateado);
        }
    
        function round(num, decimales = 2) {
            var signo = (num >= 0 ? 1 : -1);
            num = num * signo;
            if (decimales === 0)
                return signo * Math.round(num);
            // round(x * 10 ^ decimales)
            num = num.toString().split('e');
            num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
            // x * 10 ^ (-decimales)
            num = num.toString().split('e');
            return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
        }
        function formatCurrency(value) {
            let formattedValue = new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(value);
            return formattedValue.replace('S/', '$');
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
