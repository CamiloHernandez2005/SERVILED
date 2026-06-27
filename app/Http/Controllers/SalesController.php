<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalesRequest;
use App\Models\Person;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ventas = Sale::query()->with('cliente');

        if ($request->filled('filtervalue')) {
            $filtro = $request->input('filtervalue');
    
            // Realizar la búsqueda en todos los campos relevantes
            $ventas = $ventas->where(function($query) use ($filtro) {
                $query->where('id', 'like', "%{$filtro}%")
                      ->orWhere('dates', 'like', "%{$filtro}%")
                      ->orWhere('bill_numbers', 'like', "%{$filtro}%")
                      ->orWhere('gross_totals', 'like', "%{$filtro}%")
                      ->orWhere('taxes_total', 'like', "%{$filtro}%")
                      ->orWhere('total_discounts', 'like', "%{$filtro}%")
                      ->orWhere('net_total', 'like', "%{$filtro}%")
                      // Buscar por nombre de cliente
                      ->orWhereHas('cliente', function($query) use ($filtro) {
                          $query->where('company_name', 'like', "%{$filtro}%")
                                ->orWhere('first_name', 'like', "%{$filtro}%")
                                ->orWhere('other_name', 'like', "%{$filtro}%")
                                ->orWhere('surname', 'like', "%{$filtro}%")
                                ->orWhere('second_surname', 'like', "%{$filtro}%")
                                ->orWhere('identification_number', 'like', "%{$filtro}%");
                      });
            });
        }

        // Filtro por rango de fechas (sobre la fecha de la venta)
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        if ($fechaInicio && $fechaFin) {
            $ventas->whereBetween('dates', [$fechaInicio, $fechaFin]);
        } elseif ($fechaInicio) {
            $ventas->whereDate('dates', '>=', $fechaInicio);
        } elseif ($fechaFin) {
            $ventas->whereDate('dates', '<=', $fechaFin);
        }

        // Totales del conjunto filtrado (antes de paginar)
        $totalVentas = (clone $ventas)->sum('net_total');
        $totalGanancias = (clone $ventas)->sum('total_profit');

        // Obtener los resultados de la consulta paginados
        $ventasFiltradas = $ventas->orderBy('id', 'desc')->paginate(25)->withQueryString();

        // Devolver la vista con las ventas filtradas
        return view('sales.index', compact('ventasFiltradas', 'totalVentas', 'totalGanancias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Person::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        $users = User::all();
        $nextSaleId = Sale::max('id') + 1;

        return view('sales.create', compact('products', 'clients', 'users', 'nextSaleId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesRequest $request)
    {
        try{
            DB::beginTransaction();

        // Solo las columnas reales de la tabla sales (no los arrays de productos)
        $venta = Sale::create($request->safe()->only([
            'dates', 'bill_numbers', 'sellers', 'payments_methods',
            'gross_totals', 'taxes_total', 'total_discounts', 'net_total', 'clients_id',
        ]));

        $arrayProducto_id = $request->get('arrayidproducto');
        $arrayReferencia = $request->get('arrayname');
        $arrayCantidad = $request->get('arraycantidad');
        $arrayPrecioVenta = $request->get('arrayprecioventa');
        $arrayDescuento = $request->get('arraydescuento');
        $arrayImpuesto = $request->get('arrayimpuesto');
        $arrayimpuestoval = $request->get('arrayimpuestoval');

        $siseArray = count($arrayProducto_id);
            $cont = 0;
            $totalGanancias = 0;

        while($cont < $siseArray){
                $producto = Product::find($arrayProducto_id[$cont]);

                $cantidad = intval($arrayCantidad[$cont]);
                $precioVenta = (float) $arrayPrecioVenta[$cont];
                $precioCompra = (float) $producto->purchase_price;
                $descuento = (float) $arrayDescuento[$cont];

                // Ganancia = (precio_venta * cantidad) - descuentos - (precio_compra * cantidad)
                $ganancia = ($precioVenta * $cantidad) - $descuento - ($precioCompra * $cantidad);
                $totalGanancias += $ganancia;

            $venta->productos()->syncWithoutDetaching([
                $arrayProducto_id[$cont] => [
                    'amount' => $arrayCantidad[$cont],
                    'references' => $arrayReferencia[$cont],
                    'selling_price' => $arrayPrecioVenta[$cont],
                    'purchase_price' => $precioCompra,
                    'discounts' => $arrayDescuento[$cont],
                    'tax' => $arrayImpuesto[$cont],
                    'iva' =>  $arrayimpuestoval[$cont],
                    'profit' => $ganancia
                ]
             ]);

                $stockActual = $producto->stock;

                DB::table('products')
                ->where('id',$producto->id)
                ->update([
                    'stock' => $stockActual - $cantidad
                ]);

                $cont++;
        }

            $venta->update(['total_profit' => $totalGanancias]);

            DB::commit();

            // El éxito solo se muestra si la transacción se confirmó
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Éxito!',
                'descripcion' => 'Venta Creada Exitosamente',
                'autoCierre' => 'true'
            ]);

            // Marca la venta recién creada para abrir su factura POS automáticamente
            Session::flash('factura_pos_id', $venta->id);

            return redirect()->route('sales.index');

        }catch(\Throwable $e){
            DB::rollBack();
            report($e); // registra el error en storage/logs/laravel.log

            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Error!',
                'descripcion' => 'No se pudo registrar la venta: ' . $e->getMessage(),
                'autoCierre' => 'false'
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return view('sales.show',compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::find($id);
        if ($sale->status == 1) {
            Sale::where('id', $sale->id)
            ->update([
                'status' => 0
            ]);
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Atencion!',
                'descripcion' => 'La venta se ha inactivado correctamente.',
                'autoCierre' => 'true'
            ]);
        } else {
            Sale::where('id', $sale->id)
            ->update([
                'status' => 1
            ]);
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Éxito!',
                'descripcion' => 'La venta se ha vuelto a activar.',
                'autoCierre' => 'true'
            ]);
        }
        return redirect()->route('sales.index')->with('success','Venta inactivada');
    }

    public function pdf()
    {
        $ventas = Sale::with('cliente')->get();

        $pdf = Pdf::loadView('sales.pdf', ['ventas' => $ventas])
                    ->setPaper('a4','landscape');

        // Funcion para devolver una vista del pdf en el navegador
        return $pdf->stream('Ventas.pdf');

        //Descargar el pdf directamente
        // return $pdf->download('Informe de Personas.pdf');
    }

    /**
     * Genera la factura POS (recibo) de una venta con sus productos.
     */
    public function facturaPos(Sale $sale)
    {
        // Cargar los productos (con su pivote) y el cliente de la venta
        $sale->load('productos', 'cliente');

        // Tamaño tipo recibo POS: 80mm de ancho; el alto se ajusta a la cantidad de
        // productos para que TODO el recibo quede en una sola página (sin cortes).
        $alto = 350 + ($sale->productos->count() * 16);

        $pdf = Pdf::loadView('sales.factura-pos', compact('sale'))
                    ->setPaper([0, 0, 226.77, $alto], 'portrait');

        return $pdf->stream('factura-pos-' . $sale->bill_numbers . '.pdf');
    }
}
