<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF - Informe de notas crédito de ventas</title>
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}" type="text/css">
</head>
<body>
    <div class="encabezado">
        <div class="Title_Informe">
            <h1 class="NombreInforme">Informe de notas crédito de ventas</h1>
        </div>
        <img src="{{ public_path('img/logo.png') }}" class="imgPDF">
        <h1 class="FerreteriaEx">SERVILED</h1>
        <p>NIT 9.524.275</p>
    </div>
<br>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Fecha de venta</th>
                <th>Vendedor</th>
                <th>Forma de pago</th>
                <th>Total bruto</th>
                <th>Total impuesto</th>
                <th>Total neto</th>
                <th>Fecha nota crédito</th>
                <th>Motivo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $sale)
            <tr style="text-align: center">
                <td>{{$sale->id}}</td>
                <td>{{$sale->date_invoice}}</td>
                <td>{{$sale->sellers}}</td>
                <td>{{$sale->payments_methods}}</td>
                <td>{{ number_format($sale->gross_totals, 0, ",", ".") }}</td>
                <td>{{ number_format($sale->taxes_total, 0, ",", ".") }}</td>
                <td>{{ number_format($sale->net_total, 0, ",", ".") }}</td>
                <td>{{$sale->date_credit_notes}}</td>
                <td>{{$sale->reason}}</td>
                <td>
                    @if($sale->status == True)
                    <p class="badge rounded-pill bg-success" style="font-size: 15px">Activo</p>
                    @else
                    <p class="badge rounded-pill bg-danger" style="font-size: 15px">Inactivo</p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
