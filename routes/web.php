<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\CreditNoteSalesController;
use App\Http\Controllers\debitNoteSupplierController;
use App\Http\Controllers\DetailPurchaseController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

//Rutas del login y registro
Route::get('/register', [RegisterController::class,'show']);
Route::post('/register', [RegisterController::class,'register']);
Route::get('/login', [LoginController::class,'show']);
Route::post('/login', [LoginController::class,'login']);
Route::get('/home', [HomeController::class,'index'])->name('home');
Route::post('/caja', [HomeController::class,'guardarCaja'])->name('caja.store');
Route::get('/logout', [LogoutController::class,'logout']);

//Rutas y funciones para el login y recuperar contraseña

// Formulario donde el usuario pone su email para que le enviemos el email de resetear la contraseña
Route::get('/formulario-recuperar-contrasenia', [AuthController::class, 'formularioRecuperarContrasenia'])->name('formulario-recuperar-contrasenia');
// Función que se ejecuta al enviar el formulario y que enviará el email al usuario
Route::post('/enviar-recuperar-contrasenia', [AuthController::class, 'enviarRecuperarContrasenia'])->name('enviar-recuperacion');
// Formulario donde se modificará la contraseña
Route::get('/reiniciar-contrasenia/{token}', [AuthController::class, 'formularioActualizacion'])->name('formulario-actualizar-contrasenia');
// Función que actualiza la contraseña del usuario
Route::post('/actualizar-contrasenia', [AuthController::class, 'actualizarContrasenia'])->name('actualizar-contrasenia');
//Rutas para la vista de administrador
Route::resource('usuarios', UsuariosController::class)->only(['index', 'edit', 'update'])->names('admin.usuarios');

//Ruta para editar los datos del usuario
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [UserController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/change', [UserController::class, 'changePassword'])->name('password.update');
});



// Funcion de Productos
Route::resource('products', ProductController::class);
Route::resource('brand', BrandController::class);
Route::resource('units', MeasurementUnitController::class);

//Funcion Personas
Route::resource('person', PersonController::class);
Route::resource('customer', CustomerController::class);
Route::resource('supplier', SupplierController::class);

//Funcion Municipios
Route::resource('municipalities', MunicipalityController::class);

//Funcion Ventas
Route::resource('sales', SalesController::class);
Route::resource('credit-note-sales', CreditNoteSalesController::class);
Route::get('/obtener-detalle-venta', [CreditNoteSalesController::class, 'obtenerDetalleVenta']);

//Funcion Importar
Route::post('/importbrands',[BrandController::class, 'importbrands'])->name('importbrands');
Route::post('/importPerson', [PersonController::class, 'importPerson'])->name('importPerson');
Route::post('/importProduct', [ProductController::class, 'importProduct'])->name('importProduct');

// Descarga de template importar
Route::get('/downloadFile',[TemplateController::class, 'downloadFile'])->name('downloadFile');
Route::get('/downloadFileBrands',[TemplateController::class, 'downloadFileBrands'])->name('downloadFileBrands');
Route::get('/downloadFileUnits',[TemplateController::class, 'downloadFileUnits'])->name('downloadFileUnits');
Route::get('/downloadFileProduct',[TemplateController::class, 'downloadFileProduct'])->name('downloadFileProduct');

//Informes
Route::get('export_index', [ExportController::class, 'index_informes'])->name('index_informes');

//Funcion Export Informes
Route::get('/export', [ExportController::class, 'export'])->name('export');
Route::get('/export_person', [ExportController::class, 'exportperson'])->name('export.person');
Route::get('/export_sale', [ExportController::class, 'exportsale'])->name('export.sale');
Route::get('/export_purchase', [ExportController::class, 'exportpurchase'])->name('export.purchase');
Route::get('/debit_note', [ExportController::class, 'exportdebitnote'])->name('export.debitnote');
Route::get('/export_creditnotesale', [ExportController::class, 'exportcreditnotesale'])->name('export.creditnotesale');
Route::get('/export_supplier', [ExportController::class, 'exportsupplier'])->name('export.supplier');
Route::get('/export_customer', [ExportController::class, 'exportcustomer'])->name('export.customer');
Route::get('/report', [ExportController::class,'report'])->name('report');

//rutas de historial de movimientos
Route::post('/buscar-historial', [App\Http\Controllers\HistorialMovimientoController::class, 'buscarMovimientos'])->name('buscar.historial');
Route::get('/historial', [App\Http\Controllers\HistorialMovimientoController::class, 'historialMovimientos'])->name('historial');
Route::get('/limpiar', [App\Http\Controllers\HistorialMovimientoController::class, 'limpiar'])->name('limpiar');

//Rutas de historial de precios
Route::get('/reportPriceHistoryProducts', [ExportController::class,'reportPriceHistoryProducts'])->name('reportPriceHistoryProducts');
Route::get('/reportPriceHistoryProductsPurchase', [ExportController::class,'reportPriceHistoryProductsPurchase'])->name('reportPriceHistoryProductsPurchase');


//Funcion de generar PDF
Route::get('Customer/pdf', [CustomerController::class, 'pdf'])->name('customer.pdf');
Route::get('Supplier/pdf', [SupplierController::class, 'pdf'])->name('supplier.pdf');
Route::get('Person/pdf', [PersonController::class, 'pdf'])->name('person.pdf');
Route::get('Products/pdf',[ProductController::class, 'pdf'])->name('products.pdf');
Route::get('Sales/pdf',[SalesController::class, 'pdf'])->name('sales.pdf');
Route::get('sales/{sale}/factura-pos', [SalesController::class, 'facturaPos'])->name('sales.factura-pos');
Route::get('Credit-note-sales/pdf', [CreditNoteSalesController::class, 'pdf'])->name('credit-note-sales.pdf');
Route::get('Detail-purchases/pdf',[DetailPurchaseController::class,'pdf'])->name('detail-purchases.pdf');
Route::get('Debit-note-supplier/pdf', [debitNoteSupplierController::class,'pdf'])->name('debit-note-supplier.pdf');

//Descargar el mapa de sitio
Route::get('/MapaSitio', [TemplateController::class, 'downloadMapaSitio'])->name('downloadMapa');

//Funciones De Compras
Route::resource('purchase_supplier', App\Http\Controllers\PurchaseSupplierController::class);
Route::post('/verificar-factura', [DetailPurchaseController::class, 'verificarFactura']);
Route::resource('detail-purchases', App\Http\Controllers\DetailPurchaseController::class);
Route::post('/verificar-nota-debito', [DebitNoteSupplierController::class, 'verificarNotaDebito']);
Route::resource('debit-note-supplier', App\Http\Controllers\DebitNoteSupplierController::class);

//Descarga del manual de usuario
Route::get('/downloadManualUser',[TemplateController::class,'downloadManualUser'])->name('downloadManualUser');
Route::get('/downloadManualAdmin',[TemplateController::class,'downloadManualAdmin'])->name('downloadManualAdmin');


//Ruta para la gestion de usuario con el rol de Administrador
Route::resource('usuarios', UsuariosController::class)->only(['index', 'edit', 'update'])->names('admin.usuarios');


//Filtrar historial de precios
Route::get('/filtrar/precios', [ExportController::class, 'filtrar'])->name('filtrar_por_fechas');
Route::get('/filtrar/precios/purchase', [ExportController::class, 'filtrarPurchase'])->name('filtrarPurchase');


