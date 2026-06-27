<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF - Informe de clientes</title>
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}" type="text/css">
</head>
<body>
    <div class="encabezado">
        <div class="Title_Informe">
            <h1 class="NombreInforme">Informe de clientes</h1>
        </div>
        <img src="{{ public_path('img/logo.png') }}" class="imgPDF">
        <h1 class="FerreteriaEx">SERVILED</h1>
        <p>NIT {{ config('company.nit') }}</p>
    </div>
<br>
    <table>
        <thead>
            <tr>
                <th>Tercero</th>
                <th>Tipo ID</th>
                <th>Identificacion</th>
                <th>DV</th>
                <th>Tipo de persona</th>
                <th>Razon social</th>
                <th>Primer nombre</th>
                <th>Otro nombre</th>
                <th>Apellido</th>
                <th>Segundo apellido</th>
                <th>Nombre comercial</th>
                <th>Correo electronico</th>
                <th>Ciudad</th>
                <th>Direccion</th>
                <th>Celular</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->rol }}</td>
                    <td>{{ $cliente->identification_type }}</td>
                    <td>{{ $cliente->identification_number }}</td>
                    <td>{{ $cliente->digit_verification }}</td>
                    <td>{{ $cliente->person_type }}</td>
                    <td>{{ $cliente->company_name }}</td>
                    <td>{{ $cliente->first_name }}</td>
                    <td>{{ $cliente->other_name }}</td>
                    <td>{{ $cliente->surname }}</td>
                    <td>{{ $cliente->second_surname }}</td>
                    <td>{{ $cliente->comercial_name }}</td>
                    <td>{{ $cliente->email_address }}</td>
                    <td>{{ $cliente->municipality_id }}</td>
                    <td>{{ $cliente->address }}</td>
                    <td>{{ $cliente->phone }}</td>
                    <td>
                        @if ($cliente->status == true)
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
