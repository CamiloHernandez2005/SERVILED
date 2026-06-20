<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\credit_note_sales;
use App\Models\DebitNoteSupplier;
use App\Models\DetailPurchase;
use App\Models\Person;
use App\Models\Product;
use App\Models\Sale;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home');
});

// Productos
Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->push('Productos', route('products.index'));
});

// Productos > Crear productos
Breadcrumbs::for('product.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Crear producto', route('products.create'));
});

//Productos > Modificar producto
Breadcrumbs::for('product.edit', function (BreadcrumbTrail $trail, Product $producto) {
    $trail->parent('products');
    $trail->push('Modificar');
    $trail->push($producto->name_product, route('products.edit', $producto));
});

//Productos > Ver producto
Breadcrumbs::for('product.show', function (BreadcrumbTrail $trail, Product $producto) {
    $trail->parent('products');
    $trail->push('Ver');
    $trail->push($producto->name_product, route('products.show', $producto));
});

//Productos > Crear categoria
Breadcrumbs::for('category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Categoria', route('category.index'));
});

//Productos > Craer categoria > Crear sub categorria
Breadcrumbs::for('sub-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('category.index');
    $trail->push('Subcategoría', route('categorySub.index'));
});

//Productos > Crear marca
Breadcrumbs::for('brand.index', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Marca', route('brand.index'));
});


//Compras > Mostrar
Breadcrumbs::for('compras.show', function (BreadcrumbTrail $trail, DetailPurchase $detailPurchase) {
    $trail->parent('compras.index');
    $trail->push('Mostrar');
    $trail->push($detailPurchase->id);
});

//Compra > Crear detalle de compra
Breadcrumbs::for('detail.purchase.create', function (BreadcrumbTrail $trail) {
    $trail->parent('compras.index');
    $trail->push('Crear detalle de la compra');
});

//Compras
Breadcrumbs::for('compras.index', function (BreadcrumbTrail $trail) {
    $trail->push('Compras', route('detail-purchases.index'));
});

//Compras > Mostrar nota debito
Breadcrumbs::for('debit-note-supplier.index', function (BreadcrumbTrail $trail) {
    $trail->parent('compras.index');
    $trail->push('Mostrar nota debito', route('debit-note-supplier.index'));
});

//Compras > Mostrar nota debito > Crear nota debito
Breadcrumbs::for('debit.note.supplier.create', function (BreadcrumbTrail $trail) {
    $trail->parent('debit-note-supplier.index');
    $trail->push('Crear nota debito');
});

//Compras > Mostrar nota debito > Mostrar
Breadcrumbs::for('debit.note.supplie.show', function (BreadcrumbTrail $trail, DebitNoteSupplier $debitNoteSupplier) {
    $trail->parent('debit-note-supplier.index');
    $trail->push('Mostrar');
    $trail->push($debitNoteSupplier->id);
});


//Terceros
Breadcrumbs::for('person.index', function (BreadcrumbTrail $trail) {
    $trail->push('Terceros', route('person.index'));
});

//Terceros > Crear
Breadcrumbs::for('person.create', function (BreadcrumbTrail $trail) {
    $trail->parent('person.index');
    $trail->push('Crear terceros');
});

//Terceros > Mostrar
Breadcrumbs::for('person.show', function (BreadcrumbTrail $trail, Person $person) {
    $trail->parent('person.index');
    $trail->push('Mostrar');
    $trail->push($person->identification_number);
});

// Terceross > Proveedores
Breadcrumbs::for('supplier.index', function (BreadcrumbTrail $trail) {
    $trail->parent('person.index');
    $trail->push('Proveedores', route('supplier.index'));
});

// Terceros > Clientes
Breadcrumbs::for('customer.index', function (BreadcrumbTrail $trail) {
    $trail->parent('person.index');
    $trail->push('Clientes', route('customer.index'));
});
// Terceros > Proveedores > Modificar
Breadcrumbs::for('supplier.edit', function (BreadcrumbTrail $trail, Person $person) {
    $trail->parent('supplier.index');
    $trail->push('Modificar');
    $trail->push($person->identification_number);
});

// Terceros > Proveedores > Mostrar
Breadcrumbs::for('supplier.show', function (BreadcrumbTrail $trail, Person $person) {
    $trail->parent('supplier.index');
    $trail->push('Mostrar');
    $trail->push($person->identification_number);
});

// Terceros > Clientes > Modificar
Breadcrumbs::for('customer.edit', function (BreadcrumbTrail $trail, Person $person) {
    $trail->parent('customer.index');
    $trail->push('Mofificar');
    $trail->push($person->identification_number);
});

//Terceros > Clientes > Mostrar
Breadcrumbs::for('customer.show', function (BreadcrumbTrail $trail, Person $person) {
    $trail->parent('customer.index');
    $trail->push('Mostrar');
    $trail->push($person->identification_number);
});



//Ventas
Breadcrumbs::for('sales.index', function (BreadcrumbTrail $trail) {
    $trail->push('Ventas', route('sales.index'));
});
// Ventas > Mostrar
Breadcrumbs::for('sales.show', function (BreadcrumbTrail $trail, Sale $sale) {
    $trail->parent('sales.index');
    $trail->push('Mostrar');
    $trail->push($sale->id);
});

// Ventas > Crear
Breadcrumbs::for('sales.create', function (BreadcrumbTrail $trail) {
    $trail->parent('sales.index');
    $trail->push('Crear venta');
});

//Ventas > Notas credito
Breadcrumbs::for('credit.note.sales', function (BreadcrumbTrail $trail) {
    $trail->parent('sales.index');
    $trail->push('Notas crédito', route('credit-note-sales.index'));
});

//Ventas > Notas credito > Mostrar
Breadcrumbs::for('credit.note.sales.show', function (BreadcrumbTrail $trail, credit_note_sales $credit_note_sale) {
    $trail->parent('credit.note.sales');
    $trail->push('Mostrar');
    $trail->push($credit_note_sale->id);
});

//Ventas > Crear nota credito
Breadcrumbs::for('credit.note.sales.create', function (BreadcrumbTrail $trail) {
    $trail->parent('sales.index');
    $trail->push('Crear nota crédito');
});

//Informes
Breadcrumbs::for('informes.index', function (BreadcrumbTrail $trail) {
    $trail->push('Informes', route('index_informes'));
});

//Informes > Historial precios de venta
Breadcrumbs::for('PriceHystoryProducts', function (BreadcrumbTrail $trail) {
    $trail->parent('informes.index');
    $trail->push('Historial de precios de venta', route('reportPriceHistoryProducts'));
});

//Informe > Historial precios de compra
Breadcrumbs::for('PriceHystoryProductsPurchase', function (BreadcrumbTrail $trail) {
    $trail->parent('informes.index');
    $trail->push('Historial de precios de compra', route('reportPriceHistoryProductsPurchase'));
});

//Informe > Historial de movimientos
Breadcrumbs::for('movement_history', function (BreadcrumbTrail $trail) {
    $trail->parent('informes.index');
    $trail->push('Historial de movimientos', route('historial'));
});

//Informes > Crear unidad
Breadcrumbs::for('units.index', function (BreadcrumbTrail $trail) {
    $trail->parent('informes.index');
    $trail->push('Unidades de medida', route('units.index'));
});

// //Informes > Crear municipio
Breadcrumbs::for('municipalities.index', function (BreadcrumbTrail $trail) {
    $trail->parent('informes.index');
    $trail->push('Consulta de Municipios', route('municipalities.index'));
});

//Administrador
Breadcrumbs::for('admin.index', function (BreadcrumbTrail $trail) {
    $trail->push('Administrador');
    $trail->push('Gestion de usuarios', route('admin.usuarios.index'));
});

//Administrador -> roles
Breadcrumbs::for('admin.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.index');
    $trail->push('Roles');
});


//Usuario -> Datos del usuario
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->push('Usuario');
    $trail->push('Configuración',route('profile.index'));
});

//Usario -> Datos del usuario -> modificar
Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('profile');
    $trail->push('Modificar datos');
});

//Usuario -> Datos del usuario -> Contraseña
Breadcrumbs::for('profile.password', function (BreadcrumbTrail $trail) {
    $trail->parent('profile');
    $trail->push('Cambiar contraseña');
});
