<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF - Informe detalle de compra</title>
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}" type="text/css">
</head>
<body>
    <div class="encabezado">
        <div class="Title_Informe">
            <h1 class="NombreInforme">Informe detalle de compra</h1>
        </div>
        <img src="{{ public_path('img/logo.png') }}" class="imgPDF">
        <h1 class="FerreteriaEx">SERVILED</h1>
        <p>NIT 9.524.275</p>
    </div>
<br>
<table>
    <thead>
        <tr >
            <th>Fecha</th>
            <th>N° de factura</th>
            <th>Identificación</th>
            <th>Tipo de identificación</th>
            <th>Proveedor</th>
            <th>Forma de Pago</th>
            <th>Total Neto</th>
            <th>Iva</th>
            <th>Total</th>
            <th>Descuento</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($detailPurchases as $detailPurchase)
            <tr style="text-align: center;">
                <td>{{$detailPurchase->date_purchase}}</td>
                <td>{{$detailPurchase->purchaseSupplier->invoice_number_purchase}}</td>
                <td>{{ optional($detailPurchase->purchaseSupplier->person)->identification_number ?? 'Error: No se encontró el proveedor' }}
                </td>
                <td>{{ optional($detailPurchase->purchaseSupplier->person)->identification_type ?? 'Error: No se encontró el proveedor' }}
                </td>
                <td>
                    @if($detailPurchase->purchaseSupplier->person?->person_type === 'Persona jurídica')
                        {{ $detailPurchase->purchaseSupplier->person?->company_name }}
                    @else
                        {{ $detailPurchase->purchaseSupplier->person?->first_name }} {{ $detailPurchase->purchaseSupplier->person?->other_name }}
                    @endif
                </td>
                <td>{{ $detailPurchase->form_of_payment }}</td>
                <td>{{ number_format($detailPurchase->gross_total, 0, ",", ".") }}</td>
                <td>{{$detailPurchase->total_tax}}</td>
                <td>{{ number_format($detailPurchase->net_total, 0, ",", ".") }}</td>



                <td>{{ number_format($detailPurchase->gross_total, 0, ",", ".") }}</td>
                <td>{{$detailPurchase->total_tax}}</td>
                <td>{{ number_format($detailPurchase->net_total, 0, ",", ".") }}</td>




            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
