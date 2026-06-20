<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF - Informe de ventas</title>
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}" type="text/css">
</head>
<body>
    <div class="encabezado">
        <div class="Title_Informe">
            <h1 class="NombreInforme">Informe de ventas</h1>
        </div>
        <img src="{{ public_path('img/logo.png') }}" class="imgPDF">
        <h1 class="FerreteriaEx">SERVILED</h1>
        <p>NIT 9.524.275</p>
    </div>
<br>
<table>
    <thead >
        <tr>
            <th>Fecha</th>
            <th>Nº de factura</th>
            <th>Identificación</th>
            <th>Tipo de identificación</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Razon social</th>
            <th>Forma de pago</th>
            <th>Total Bruto</th>
            <th>Total Impuesto</th>
            <th>Total Neto</th>
    </thead>
    <tbody>
        @foreach ($ventas as $sale)
        <tr style="text-align: center">
            <td>{{$sale->dates}}</td>
            <td>{{$sale->bill_numbers}}</td>
            <td>{{$sale->cliente?->identification_number}}</td>
            <td>{{$sale->cliente?->identification_type}}</td>
            <td>{{$sale->cliente?->first_name}}</td>
            <td>{{$sale->cliente?->surname}}</td>
            <td>{{$sale->cliente?->company_name}}</td>
            <td>{{$sale->payments_methods}}</td>
            <td>{{ number_format($sale->gross_totals, 0, ",", ".") }}</td>
            <td>{{ number_format($sale->taxes_total, 0, ",", ".") }}</td>
            <td>{{ number_format($sale->net_total, 0, ",", ".") }}</td>
            {{--  Lo que se ha agregado  --}}

        </tr>
        @endforeach
</body>
</html>
