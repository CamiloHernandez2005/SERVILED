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
            <h1 class="NombreInforme">Informe nota débito de compra</h1>
        </div>
        <img src="{{ public_path('img/logo.png') }}" class="imgPDF">
        <h1 class="FerreteriaEx">SERVILED</h1>
        <p>NIT {{ config('company.nit') }}</p>
    </div>
<br>
<table id="datatable" class="table table-striped table-hover" style="width:100%">
    <thead class="table-dark">
        <tr style="text-align: center">
            <th>Nº</th>
            <th>Tipo Documento</th>
            <th>Número de documento</th>
            <th>Proveedor</th>
            <th>Número de nota</th>
            <th>Fecha de la nota</th>
            <th>Total</th>
            <th>Descuento total</th>
            <th>Impuesto producto</th>
            <th>Cantidad</th>
            <th>Método de pago</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($debitNoteSuppliers as $key => $debitNoteSupplier)
            <tr style="text-align: center;">
                <td>{{ $key + 1 }}</td>
                <td>{{ optional($debitNoteSupplier->detailPurchase->purchaseSupplier->person)->identification_type ?? 'Error: No se encontró el Empleado' }}
                </td>
                <td>{{ optional($debitNoteSupplier->detailPurchase->purchaseSupplier->person)->identification_number ?? 'Error: No se encontró el Empleado' }}
                </td>

                <td>
                    @if (optional($debitNoteSupplier->purchaseSupplier->person)->person_type === 'Persona jurídica')
                        {{ optional($debitNoteSupplier->purchaseSupplier->person)->company_name ?? 'Error: No se encontró la Empresa' }}
                    @else
                        {{ optional($debitNoteSupplier->purchaseSupplier->person)->first_name ?? 'Error: No se encontró el Empleado' }}
                        {{ optional($debitNoteSupplier->purchaseSupplier->person)->other_name ?? '' }}
                    @endif
                </td>
                <td>{{ $debitNoteSupplier->debit_note_code }}</td>
                <td>{{ $debitNoteSupplier->date_invoice }}</td>
                <td>{{ round($debitNoteSupplier->total, 2) }}</td>
                <td>{{ $debitNoteSupplier->detailPurchase ? $debitNoteSupplier->detailPurchase->discount_total : 'N/A' }}
                </td>
                <td>{{ $debitNoteSupplier->detailPurchase ? $debitNoteSupplier->detailPurchase->product_tax : 'N/A' }}
                </td>
                <td>{{ $debitNoteSupplier->quantity }}</td>
                <td>{{ $debitNoteSupplier->detailPurchase ? $debitNoteSupplier->detailPurchase->form_of_payment : 'N/A' }}
                </td>
                <td>
                    @if ($debitNoteSupplier->status == 1)
                        <p class="badge rounded-pill bg-success text-white"
                            style="font-size: 15px">Activo</p>
                    @else
                        <p class="badge rounded-pill bg-danger text-white" style="font-size: 15px">
                            Inactivo</p>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
