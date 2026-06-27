<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura POS {{ $sale->bill_numbers }}</title>
    <style>
        * { font-family: 'DejaVu Sans', sans-serif; box-sizing: border-box; }
        body { margin: 0; padding: 4px 6px; color: #000; font-size: 8px; line-height: 1.35; }
        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .logo { width: 55px; margin: 0 auto 2px; display: block; }
        .empresa { font-size: 12px; font-weight: bold; letter-spacing: 1px; }
        .eslogan { font-size: 7px; }
        hr { border: none; border-top: 1px dashed #000; margin: 4px 0; }
        .info p { margin: 0; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .items { margin-top: 5px; }
        .items th { text-align: left; border-bottom: 1px solid #000; padding: 2px 0; font-size: 7.5px; }
        .items td { padding: 2px 0; vertical-align: top; font-size: 8px; word-wrap: break-word; }
        .col-prod { width: 44%; }
        .col-cant { width: 12%; }
        .col-unit { width: 22%; }
        .col-tot  { width: 22%; }
        .tot td { padding: 1px 0; font-size: 9px; }
        .tot .total td { font-size: 11px; border-top: 1px solid #000; padding-top: 3px; }
        .footer { margin-top: 6px; font-size: 8px; }
    </style>
</head>
<body>
    <div class="center">
        <img src="{{ public_path('img/logo.png') }}" class="logo">
        <div class="empresa">SERVILED</div>
        <div class="eslogan">Materiales Eléctricos · Iluminación LED</div>
        <div>NIT {{ config('company.nit') }}</div>
    </div>

    <hr>

    <div class="info">
        <p><span class="bold">Factura POS:</span> {{ $sale->bill_numbers }}</p>
        <p><span class="bold">Fecha:</span> {{ $sale->dates }}</p>
        <p><span class="bold">Cliente:</span>
            {{ trim(($sale->cliente?->company_name ?? '') . ' ' . ($sale->cliente?->first_name ?? '') . ' ' . ($sale->cliente?->surname ?? '')) ?: 'Consumidor final' }}
        </p>
        <p><span class="bold">Identificación:</span> {{ $sale->cliente?->identification_number ?? '—' }}</p>
        <p><span class="bold">Vendedor:</span> {{ $sale->sellers }}</p>
        <p><span class="bold">Forma de pago:</span> {{ $sale->payments_methods }}</p>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th class="col-prod">Producto</th>
                <th class="col-cant center">Cant</th>
                <th class="col-unit right">V.Unit</th>
                <th class="col-tot right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->productos as $item)
                <tr>
                    <td class="col-prod">{{ $item->name_product }}</td>
                    <td class="col-cant center">{{ $item->pivot->amount }}</td>
                    <td class="col-unit right">${{ number_format($item->pivot->selling_price, 0, ',', '.') }}</td>
                    <td class="col-tot right">${{ number_format($item->pivot->amount * $item->pivot->selling_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <table class="tot">
        <tr>
            <td>Subtotal (bruto):</td>
            <td class="right">${{ number_format($sale->gross_totals, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Descuentos:</td>
            <td class="right">${{ number_format($sale->total_discounts, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>IVA:</td>
            <td class="right">${{ number_format($sale->taxes_total, 0, ',', '.') }}</td>
        </tr>
        <tr class="total bold">
            <td>TOTAL:</td>
            <td class="right">${{ number_format($sale->net_total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="center footer">
        <p class="bold">¡Gracias por su compra!</p>
        <p>Documento equivalente a factura POS</p>
    </div>
</body>
</html>
