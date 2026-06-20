<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPurchase;
use App\Models\SubCategory;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Sale;

class HistorialMovimientoController extends Controller
{
    public function historialMovimientos(Request $request)
    {
        $detailPurchases = collect();
        $products = Product::all();
        $ventas = collect();
        $subCategories = SubCategory::all();
        $categories = CategoryProduct::all();
        $estados = ['Activo', 'Inactivo'];
        $resultados = collect();
        $datos = collect(); 
        $fecha_inicio = null;
        $fecha_cierre = null;
    
        return view('reports.historial', compact('resultados', 'detailPurchases', 'products', 'ventas', 'subCategories', 'categories', 'estados', 'fecha_inicio', 'fecha_cierre', 'request', 'datos')); 
        }
    
        public function buscarMovimientos(Request $request)
        {
            $products = Product::all();
            $subCategories = SubCategory::all();
            $categories = CategoryProduct::all();
            $estados = ['Activo', 'Inactivo'];
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_cierre = $request->input('fecha_cierre');
            $subcategoria = $request->input('subcategoria');
            $categoria = $request->input('categoria');
            $producto = $request->input('producto');
            $estado = $request->input('estado');
        
            $datos = [];
        
            $detallesComprasQuery = DetailPurchase::with('product');
            $ventasQuery = Sale::with('productos');
        
            if ($request->isMethod('post') && !is_null($estado)) {
                $detallesComprasQuery = $detallesComprasQuery->whereHas('product', function ($query) use ($estado) {
                    $query->where('status', $estado);
                });
                $ventasQuery = $ventasQuery->whereHas('productos', function ($query) use ($estado) {
                    $query->where('status', $estado);
                });
            }
        
            if ($request->isMethod('post') && $fecha_inicio && $fecha_cierre) {
                $detallesComprasQuery = $detallesComprasQuery->whereHas('product', function ($query) use ($fecha_inicio, $fecha_cierre) {
                    $query->whereBetween('products.created_at', [$fecha_inicio, $fecha_cierre]);
                });
                $ventasQuery = $ventasQuery->whereHas('productos', function ($query) use ($fecha_inicio, $fecha_cierre) {
                    $query->whereBetween('products.created_at', [$fecha_inicio, $fecha_cierre]);
                });
            }
        
            if ($request->isMethod('post') && $producto) {
                $detallesComprasQuery = $detallesComprasQuery->whereHas('product', function ($query) use ($producto) {
                    $query->where('products.id', $producto);
                });
                $ventasQuery = $ventasQuery->whereHas('productos', function ($query) use ($producto) {
                    $query->where('products.id', $producto);
                });
            
                $detallesCompras = $detallesComprasQuery->get();
                $ventas = $ventasQuery->get();
            }
            if ($request->isMethod('post') && $categoria) {
                $detallesComprasQuery = $detallesComprasQuery->whereHas('product', function ($query) use ($categoria) {
                    $query->where('category_products_id', $categoria);
                });
                $ventasQuery = $ventasQuery->whereHas('productos', function ($query) use ($categoria) {
                    $query->where('category_products_id', $categoria);
                });
            }
        
            if ($request->isMethod('post') && $subcategoria) {
                $subcategoriaNombre = SubCategory::find($subcategoria)->name;
                $detallesComprasQuery = $detallesComprasQuery->whereHas('product', function ($query) use ($subcategoriaNombre) {
                    $query->where('subcategory_product', $subcategoriaNombre);
                });
                $ventasQuery = $ventasQuery->whereHas('productos', function ($query) use ($subcategoriaNombre) {
                    $query->where('subcategory_product', $subcategoriaNombre);
                });
            }
        
            $detallesCompras = $detallesComprasQuery->get();
            $ventas = $ventasQuery->get();
        
            $datos = [];

            foreach ($products as $product) {
                $detallesComprasProducto = $detallesCompras->where('products_id', $product->id);
                $ventasProducto = $ventas->filter(function ($venta) use ($product) {
                    return $venta->productos->contains('id', $product->id);
                });
                    
                $filtrarProducto = $request->isMethod('post') && $producto; 
                $ultimaCantidadIngresada = '0';
                $productoVendido = false;
                $ultimoDetalleCompra = null;

        foreach ($ventasProducto as $venta) {
            foreach ($venta->productos as $producto) {
                if ($producto->id == $product->id) {
                    if (!$detallesComprasProducto->isEmpty()) {
                        $ultimoDetalleCompra = $detallesComprasProducto->shift();
                    }
                    $fechaInicial = $producto->created_at->format('Y-m-d H:i:s');
                    $fechaFinal = $venta->created_at->format('Y-m-d H:i:s');
                    $fechaFactura = $ultimoDetalleCompra ? $ultimoDetalleCompra->created_at->format('Y-m-d H:i:s') : 'N/A';
                    $cantidadIngresada = $ultimoDetalleCompra ? $ultimoDetalleCompra->quantity_units : '0';
                    $datos[] = [
                        'nombre_del_producto' => $producto->name_product,
                        'referencia_de_fabrica' => $producto->factory_reference,
                        'cantidad_inicial' => '0',
                        'cantidad_entrada' => $cantidadIngresada,
                        'fecha_inicial' => $fechaInicial,
                        'fecha_final' => $fechaFinal,
                        'fecha_de_la_factura' => $fechaFactura,
                        'cantidad_de_salida' => $producto->pivot->amount,
                        'saldo_de_cantidades' => $producto->stock,
                    ];
                }
            }
        }

        while (!$detallesComprasProducto->isEmpty()) {
            $detalleCompra = $detallesComprasProducto->shift();
            $datos[] = [
                'nombre_del_producto' => $product->name_product,
                'referencia_de_fabrica' => $product->factory_reference,
                'cantidad_inicial' => '0',
                'cantidad_entrada' => $detalleCompra->quantity_units,
                'fecha_inicial' => $product->created_at->format('Y-m-d H:i:s'),
                'fecha_final' => 'N/A',
                'fecha_de_la_factura' => $detalleCompra->created_at->format('Y-m-d H:i:s'),
                'cantidad_de_salida' => '0',
                'saldo_de_cantidades' => $product->stock,
            ];
        }
    }        
        
            return view('reports.historial', compact('products', 'subCategories', 'categories', 'estados', 'fecha_inicio', 'fecha_cierre', 'request', 'datos'));
        }
    
public function limpiar(Request $request)
{
    $detailPurchases = collect();
    $products = Product::all();
    $ventas = collect();
    $subCategories = SubCategory::all();
    $categories = CategoryProduct::all();
    $estados = ['Activo', 'Inactivo'];
    $resultados = collect();
    $fecha_inicio = null;
    $fecha_cierre = null;
    $datos = [];  

    return view('reports.historial', compact('resultados', 'detailPurchases', 'products', 'ventas', 'subCategories', 'categories', 'estados', 'fecha_inicio', 'fecha_cierre', 'request', 'datos'));  
}

}