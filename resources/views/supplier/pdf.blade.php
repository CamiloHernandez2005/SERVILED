<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF - Informe de proveedores</title>
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}" type="text/css">
</head>
<body>
    <div class="encabezado">
        <div class="Title_Informe">
            <h1 class="NombreInforme">Informe de proveedores</h1>
        </div>
        <img src="{{ public_path('img/logo.png') }}" class="imgPDF">
        <h1 class="FerreteriaEx">SERVILED</h1>
        <p>NIT 9.524.275</p>
    </div>
<br>
<table>
    <thead>
        <tr>
            <th>Tercero</th>
            <th>Tipo ID</th>
            <th>Identificación</th>
            <th>DV</th>
            <th>Tipo de persona</th>
            <th>Razón social</th>
            <th>Primer nombre</th>
            <th>Otro nombre</th>
            <th>Apellido</th>
            <th>Segundo apellido</th>
            <th>Nombre comercial</th>
            <th>Correo electrónico</th>
            <th>Ciudad</th>
            <th>Dirección</th>
            <th>Celular</th>
            <th>Estado</th>
        </tr>
    </thead>
<tbody>
    @foreach ($proveedores as $proveedor)
        <tr style="text-align: center">
            <td>{{ $proveedor->rol }}</td>
            <td>{{ $proveedor->identification_type }}</td>
            <td>{{ $proveedor->identification_number }}</td>
            <td>{{ $proveedor->digit_verification }}</td>
            <td>{{ $proveedor->person_type }}</td>
            <td>{{ $proveedor->company_name }}</td>
            <td>{{ $proveedor->first_name }}</td>
            <td>{{ $proveedor->other_name }}</td>
            <td>{{ $proveedor->surname }}</td>
            <td>{{ $proveedor->second_surname }}</td>
            <td>{{ $proveedor->comercial_name }}</td>
            <td>{{ $proveedor->email_address }}</td>
            <td>{{ $proveedor->municipality_id }}</td>
            <td>{{ $proveedor->address }}</td>
            <td>{{ $proveedor->phone }}</td>
            <td>
                @if ($proveedor->status == true)
                    <p class="badge rounded-pill bg-success" style="font-size: 15px">
                        Activo</p>
                @else
                    <p class="badge rounded-pill bg-danger" style="font-size: 15px">
                        Inactivo</p>
                @endif
            </td>
        </tr>
        @endforeach
</tbody>
</table>
</body>
</html>
