<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditNotePostRequest;
use App\Models\credit_note_sales;
use App\Models\DetalleVenta;
use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class CreditNoteSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ventas = credit_note_sales::query();
    
        if ($request->filled('filtervalue')) {
            $filtro = $request->input('filtervalue');
    
            // Realizar la búsqueda en todos los campos relevantes
            $ventas = $ventas->where(function($query) use ($filtro) {
                $query->where('id', 'like', "%{$filtro}%")
                      ->orWhere('date_invoice', 'like', "%{$filtro}%")
                      ->orWhere('sellers', 'like', "%{$filtro}%")
                      ->orWhere('payments_methods', 'like', "%{$filtro}%")
                      ->orWhere('gross_totals', 'like', "%{$filtro}%")
                      ->orWhere('taxes_total', 'like', "%{$filtro}%")
                      ->orWhere('net_total', 'like', "%{$filtro}%")
                      ->orWhere('date_credit_notes', 'like', "%{$filtro}%")
                      ->orWhere('reason', 'like', "%{$filtro}%");
            });
        }
    
        // Obtener los resultados de la consulta paginados
        $ventasFiltradas = $ventas->orderBy('id', 'desc')->paginate(25)->withQueryString();

        // Devolver la vista con las ventas filtradas
        return view('credit-note-sales.index', compact('ventasFiltradas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Sale $sale)
    {
        $sales = Sale::where('status', 1)->get();
        return view('credit-note-sales.create', compact('sales','sale'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreditNotePostRequest $request)
    {
        try{
            DB::beginTransaction();

        $venta = credit_note_sales::create($request->validated());

        $arrayProducto_id = $request->get('arrayidproducto');
        $arrayCantidad = $request->get('amount');
        $arrayReferencia = $request->get('arrayreference');
        $arrayPrecioVenta = $request->get('selling_price');
        $arrayDescuento = $request->get('discounts');
        $arrayImpuesto = $request->get('tax');
        $arrayimpuestoval = $request->get('arrayimpuestoval');

        $siseArray = count($arrayProducto_id);
            $cont = 0;

        while($cont < $siseArray){
            $venta->productos()->syncWithoutDetaching([
                $arrayProducto_id[$cont] => [
                    'amount' => $arrayCantidad[$cont],
                    'references' => $arrayReferencia[$cont],
                    'selling_price' => $arrayPrecioVenta[$cont],
                    'discounts' => $arrayDescuento[$cont],
                    'tax' => $arrayImpuesto[$cont],
                    'iva' =>  $arrayimpuestoval[$cont]
                ]
             ]);

                $cont++;
        }

            DB::commit();

            // El éxito solo se muestra si la transacción se confirmó
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Éxito!',
                'descripcion' => 'Nota Credito Creada Exitosamente.',
                'autoCierre' => 'true'
            ]);

            return redirect()->route('credit-note-sales.index')->with('success','Nota exitosa');

    }catch(\Throwable $e){
        DB::rollBack();
        report($e); // registra el error en storage/logs/laravel.log

        Session::flash('notificacion', [
            'tipo' => 'error',
            'titulo' => 'Error!',
            'descripcion' => 'No se pudo registrar la nota crédito: ' . $e->getMessage(),
            'autoCierre' => 'false'
        ]);

        return redirect()->back()->withInput();
    }

    }

    /**
     * Display the specified resource.
     */
    public function show(credit_note_sales $credit_note_sale)
    {
        return view('credit-note-sales.show',compact('credit_note_sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(credit_note_sales $credit_note_sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, credit_note_sales $credit_note_sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale =credit_note_sales::find($id);
        if ($sale->status == 1) {
            credit_note_sales::where('id', $sale->id)
            ->update([
                'status' => 0
            ]);
            Session::flash('notificacion', [
                'tipo' => 'error',
                'titulo' => 'Atencion!',
                'descripcion' => 'La nota crédito se ha inactivado correctamente.',
                'autoCierre' => 'true'
            ]);
        } else {
            credit_note_sales::where('id', $sale->id)
            ->update([
                'status' => 1
            ]);
            Session::flash('notificacion', [
                'tipo' => 'exito',
                'titulo' => 'Éxito!',
                'descripcion' => 'La nota crédito se ha vuelto a activar.',
                'autoCierre' => 'true'
            ]);
        }
        return redirect()->route('credit-note-sales.index')->with('success','Nota crédito inactivada.');
    }

    public function obtenerDetalleVenta(Request $request)
    {
        // Obtener el ID de la venta del parámetro sale_id enviado desde la solicitud AJAX
        $saleId = $request->input('sale_id');

        // Obtener los detalles de la venta correspondientes al ID de la venta
        $detallesVenta = DetalleVenta::where('sale_id', $saleId)->with('producto')->get();

        // Devolver los detalles de la venta en formato JSON
        return response()->json(['detallesVenta' => $detallesVenta]);
    }

    public function pdf()
    {
        $ventas = credit_note_sales::all();

        $pdf = Pdf::loadView('credit-note-sales.pdf', ['ventas' => $ventas])
                    ->setPaper('a4','landscape');

        // Funcion para devolver una vista del pdf en el navegador
        return $pdf->stream('credit-note-sales.pdf');

        //Descargar el pdf directamente
        // return $pdf->download('Informe de Personas.pdf');
    }
}
