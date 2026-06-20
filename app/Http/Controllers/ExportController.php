<?php

namespace App\Http\Controllers;

use App\Exports\CreditNoteExport;
use App\Exports\ProductsExport;
use App\Exports\DebitNoteExport;
use App\Exports\PeopleExport;
use App\Exports\PurchaseExport;
use App\Models\CategoryProduct;
use App\Models\DetailPurchase;
use App\Models\DetalleVenta;
use App\Models\Product;
use App\Models\Person;
use App\Models\Sale;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaleExport;
use Google\Service\VMwareEngine\Credentials;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index_informes()
    {
        return view('reports.export');
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'Informe General de los Productos.xlsx');
    }

    public function reportPriceHistoryProducts(Request $request)
    {   
        $product = Product::all();
        $salesQuery = DetalleVenta::all();
        $sales = $salesQuery;
        return view('reports.reportPriceHistoryProducts', compact('sales','product'));
    }

    public function filtrar(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'required|date',
            'product_id' => 'nullable|exists:products,id',
        ]);
    
        $fechaInicio = $request->input('fecha_inicio');
        $fechaCierre = $request->input('fecha_cierre');
        $productId = $request->input('product_id');
    
        $query = DetalleVenta::query();
    
        if ($fechaInicio) {
            $query->whereDate('created_at', '>=', $fechaInicio);
        }
    
        if ($fechaCierre) {
            $query->whereDate('created_at', '<=', $fechaCierre);
        }
    
        if ($productId) {
            $query->where('product_id', $productId);
        }
        $product = Product::all();
    
        $sales = $query->with(['producto.categoryProduct', 'venta'])->get();
        return view('reports.reportPriceHistoryProducts', compact('sales','product'));
    }

    public function reportPriceHistoryProductsPurchase(Request $request)
    {   
        $product = Product::all();
        $salesQuery = DetailPurchase::all();
        $sales = $salesQuery;
        return view('reports.reportPriceHistoryProductsPurchase', compact('sales','product'));
    }

    public function filtrarPurchase(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_cierre' => 'required|date',
            'product_id' => 'nullable|exists:products,id',
        ]);
    
        $fechaInicio = $request->input('fecha_inicio');
        $fechaCierre = $request->input('fecha_cierre');
        $productId = $request->input('product_id');
    
        $query = DetailPurchase::query();
    
        if ($fechaInicio) {
            $query->whereDate('created_at', '>=', $fechaInicio);
        }
    
        if ($fechaCierre) {
            $query->whereDate('created_at', '<=', $fechaCierre);
        }
    
        if ($productId) {
            $query->where('products_id', $productId);
        }
        $product = Product::all();
    
        $sales = $query->with(['product.categoryProduct', 'product'])->get();
        return view('reports.reportPriceHistoryProductsPurchase', compact('sales','product'));
    }

    public function show(Sale $sale)
    {
        return view('sales.show',compact('sale'));
    }

    public function exportperson()
    {
        return Excel::download(new PeopleExport('all'), 'Personas.xlsx');
    }

    public function exportsupplier()
    {
        return Excel::download(new PeopleExport('supplier'),'Proveedores.xlsx');
    }

    public function exportcustomer()
    {
        return Excel::download(new PeopleExport('customer'),'Clientes.xlsx');
    }

    public function exportcreditnotesale()
    {
        return Excel::download(new CreditNoteExport('credit_note_sales'),'Notas credito Ventas.xlsx');
    }


    public function exportsale()
    {
        return Excel::download(new SaleExport('sale'),'Ventas.xlsx');
    }
    
    public function exportpurchase()
    {
        return Excel::download(new PurchaseExport('purchase'),'Compras.xlsx');
    }

    public function exportdebitnote()
    {
        return Excel::download(new DebitNoteExport('debitnote'),'Nota Debito.xlsx');
    }


   


}
