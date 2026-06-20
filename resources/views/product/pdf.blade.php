<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF - Informe de productos</title>
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}" type="text/css">
</head>
<body>
    <div class="encabezado">
        <div class="Title_Informe">
            <h1 class="NombreInforme">Informe de productos</h1>
        </div>
        <img src="{{ public_path('img/logo.png') }}" class="imgPDF">
        <h1 class="FerreteriaEx">SERVILED</h1>
        <p>NIT 9.524.275</p>
    </div>
<br>
<table>
    <thead>
        <tr>
            <th>Categoría </th>
            <th>Subcategoría</th>
            <th>Nombre</th>
            <th>Referencia Fabrica</th>
            <th>Clasificación tributaria</th>
            <th>Precio de compra</th>
            <th>Precio de venta</th>
            <th>Marca</th>
            <th>Unidad de Medida</th>
            <th>Existencias</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)
            <tr >
                <td style="text-align: center">{{ $producto->categoryProduct->name}}</td>
                <td style="text-align: center">{{ $producto->subcategory_product}}</td>
                <td style="text-align: center">{{ $producto->name_product }}</td>
                <td style="text-align: center">{{ $producto->factory_reference }}</td>
                <td style="text-align: center">{{ $producto->classification_tax }}</td>
                <td style="text-align: center">{{ number_format($producto->purchase_price, 0, ",", ".") }}</td>
                <td style="text-align: center">{{ number_format($producto->selling_price, 0, ",", ".") }}</td>
                <td style="text-align: center">{{ $producto->brand->name }}</td>
                <td style="text-align: center">{{ $producto->measurementUnit->name }}</td>
                <td style="text-align: center">
                    @if ($producto->stock < 5)
                        <span class="badge rounded-pill bg-danger" style="font-size: 14px" tooltip="tooltip"
                        title="Pocas Existencias" >{{ $producto->stock }}</span>
                    @else
                        <span>{{ $producto->stock }}</span>
                    @endif
                </td>
                <td style="text-align: center">
                    @if ($producto->status == 1)
                        <p class="badge rounded-pill bg-success text-white" style="font-size: 15px">Activo</p>
                    @else
                        <p class="badge rounded-pill bg-danger"  style="font-size: 15px">Inactivo</p>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
