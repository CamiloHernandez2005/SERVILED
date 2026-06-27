<?php

namespace App\Http\Controllers;

use App\Models\DetailPurchase;
use App\Models\Person;
use App\Models\People;
use App\Models\PurchaseSupplier;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
/**
 * Class DetailPurchaseController
 * @package App\Http\Controllers
 */
class DetailPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $filtervalue = $request->get('filtervalue');
    $status = $filtervalue == 'activo' ? 1 : ($filtervalue == 'inactivo' ? 0 : null);

    $uniqueDetailPurchaseIds = DB::table('detail_purchase')
        ->select(DB::raw('MAX(id) as id'))
        ->groupBy('purchase_suppliers_id')
        ->pluck('id');

    $detailPurchases = DetailPurchase::with(['purchaseSupplier.person', 'product'])
        ->whereIn('id', $uniqueDetailPurchaseIds)
        ->when($filtervalue, function ($query) use ($filtervalue, $status) {
            $filtervalue = strtolower($filtervalue); 
            return $query->whereRaw('LOWER(description) LIKE ?', ['%' . $filtervalue . '%'])
                ->orWhereRaw('LOWER(price_unit) LIKE ?', ['%' . $filtervalue . '%'])
                ->orWhere('product_tax', $filtervalue)
                ->orWhereRaw('LOWER(net_total) LIKE ?', ['%' . $filtervalue . '%'])
                ->orWhereRaw('LOWER(total_value) LIKE ?', ['%' . $filtervalue . '%'])
                ->orWhereRaw('LOWER(gross_total) LIKE ?', ['%' . $filtervalue . '%'])
                ->orWhereRaw('LOWER(discount_total) LIKE ?', ['%' . $filtervalue . '%'])
                ->orWhereRaw('LOWER(form_of_payment) LIKE ?', ['%' . $filtervalue . '%'])
                ->orWhere('status', $status) 
                ->orWhereHas('purchaseSupplier', function ($query) use ($filtervalue) {
                    return $query->whereHas('person', function ($query) use ($filtervalue) {
                        return $query->whereRaw('LOWER(identification_type) LIKE ?', ['%' . $filtervalue . '%'])
                            ->orWhereRaw('LOWER(identification_number) LIKE ?', ['%' . $filtervalue . '%'])
                            ->orWhereRaw('LOWER(company_name) LIKE ?', ['%' . $filtervalue . '%'])
                            ->orWhereRaw('LOWER(first_name) LIKE ?', ['%' . $filtervalue . '%'])
                            ->orWhereRaw('LOWER(other_name) LIKE ?', ['%' . $filtervalue . '%']);
                    })
                    ->orWhereRaw('LOWER(invoice_number_purchase) LIKE ?', ['%' . $filtervalue . '%']); 
                })
                ->orWhereHas('product', function ($query) use ($filtervalue) {
                    if ($filtervalue) {
                        return $query->whereRaw('LOWER(name_product) LIKE ?', ['%' . $filtervalue . '%']);
                    }
                });
        })
        ->orderBy('id', 'desc')
        ->paginate(25)
        ->withQueryString();

    return view('detail-purchase.index', compact('detailPurchases'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $detailPurchase = new DetailPurchase();
        $people = Person::where('rol', 'Proveedor')->get();
        $products = Product::where('status', '1')->get();
        $users = User::all();
        $purchase_suppliers = PurchaseSupplier::all();

        return view('detail-purchase.create', compact('detailPurchase', 'people', 'products', 'purchase_suppliers', 'users'));
    }

    /**
     * Almacena una nueva compra en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // app/Http/Controllers/DetailPurchaseController.php
            public function verificarFactura(Request $request)
            {
                $existe = PurchaseSupplier::where('invoice_number_purchase', $request->invoice_number_purchase)->exists();
                return response()->json(['existe' => $existe]);
            }

    public function store(Request $request)

    {

        DB::beginTransaction();
        $request->validate([
            'user_id' => 'required',
            'people_id' => 'nullable',
            'invoice_number_purchase' => 'required',
            'code' => 'required',
            'form_of_payment' => 'required',
            'method_of_payment' => 'required',
        ], [
            'user_id.required' => 'El empleado a cargo de la compra es obligatorio',
            'people_id.required' => 'Seleccionar un proveedor es obligatorio',
            'invoice_number_purchase.required' => 'El número de factura es obligatorio',
            'code.required' => 'El prefijo es obligatorio',
            'form_of_payment.required' => 'La forma de pago es obligatoria',
            'method_of_payment.required' => 'El método de pago es obligatorio',
        ]);
        

        try {
            $invoice_number = $request->input('code') . $request->input('invoice_number_purchase');

            $existingPurchase = PurchaseSupplier::where('invoice_number_purchase', $invoice_number)->first();

            if ($existingPurchase) {
                return redirect()->back()->withInput()->withErrors(['invoice_number_purchase' => 'El número de factura ya existe.']);
            }

            $purchaseSupplier = new PurchaseSupplier;
            $purchaseSupplier->invoice_number_purchase = $invoice_number;
            $purchaseSupplier->date_invoice_purchase = $request->input('fecha');
            $purchaseSupplier->people_id = $request->input('people_id');
            $purchaseSupplier->users_id = $request->input('user_id');
            $purchaseSupplier->save();
            $arrayIdProducto = $request->get('arrayidproducto');
            $arrayImpuesto = $request->get('arrayimpuesto');
            $arrayDescripcion = $request->get('arrayprecioventa');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            $arraydescuento = $request->get('arraydescuento');
        
            if (!$arrayIdProducto || !$arrayImpuesto || !$arrayDescripcion || !$arrayCantidad || !$arrayPrecioCompra || !$arrayPrecioVenta || !$arraydescuento) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Faltan datos en el formulario.']);
            }
            $sizeArray = count($arrayIdProducto);
            $cont = 0;
            while ($cont < $sizeArray) {
                $input = [];
                $input['purchase_suppliers_id'] = $purchaseSupplier->id;
                $input['products_id'] = $arrayIdProducto[$cont];
                $input['quantity_units'] = $arrayCantidad[$cont];
                $input['price_unit'] = $arrayPrecioCompra[$cont];
                $input['description'] = $arrayDescripcion[$cont];
                $input['product_tax'] = $arrayImpuesto[$cont];
                $input['date_purchase'] = $request->input('fecha');
                $input['form_of_payment'] = $request->input('form_of_payment');
                $input['method_of_payment'] = $request->input('method_of_payment');
                $input['discount_total'] = $arraydescuento[$cont];
                $input['total_tax'] = $request->input('igv');
                $input['total_value'] = $request->input('total_value_raw');
                $input['gross_total'] = $request->input('totalBruto');
                $input['net_total'] = $request->input('totalNeto');
                $validatedData = Validator::make($input, [
                    'description' => 'required|string',
                    'price_unit' => 'required|numeric',
                    'product_tax' => 'required|numeric|between:0,19',
                    'quantity_units' => 'required|numeric',
                    'date_purchase' => 'required|date',
                    'form_of_payment' => 'required|string',
                    'method_of_payment' => 'required|string',
                    'discount_total' => 'required|numeric',
                    'gross_total' => 'required|numeric',
                    'total_tax' => 'required|numeric',
                    'net_total' => 'required|numeric',
                    'total_value' => 'required|numeric',
                    'products_id' => 'required|exists:products,id',
                    'purchase_suppliers_id' => 'required|exists:purchase_suppliers,id',
                ])->validate();
            
                $detailPurchase = DetailPurchase::create($validatedData);
                $producto = Product::find($arrayIdProducto[$cont]);
                $stockActual = $producto->stock;
                $stockNuevo = intval($arrayCantidad[$cont]);
                DB::table('products')
                    ->where('id', $producto->id)
                    ->update([
                        'stock' => $stockActual + $stockNuevo
                    ]);
                $producto = Product::find($arrayIdProducto[$cont]);
                if ($producto) {
                    $producto->purchase_price = $arrayPrecioCompra[$cont];
                    $producto->save();
                }
                $cont++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withInput()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'Compra Creada Exitosamente.',
            'autoCierre' => 'true'
        ]);

        return redirect()->route('detail-purchases.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
{
    $detailPurchase = DetailPurchase::with('purchaseSupplier.user')->find($id);
    $invoice_number = $detailPurchase->purchaseSupplier->invoice_number_purchase;
    $gross_total = $detailPurchase->gross_total;
    $total_value = $detailPurchase->total_value;
    $total_tax = $detailPurchase->total_tax;
    $net_total = $detailPurchase->net_total;
    $subtotal = $detailPurchase->quantity_units * $detailPurchase->price_unit;
    $igv = $subtotal * 0.18;
    $product = Product::find($detailPurchase->products_id);
    $users = User::all();
    $purchaseSupplierId = $detailPurchase->purchase_suppliers_id;
    $detailPurchases = DetailPurchase::where('purchase_suppliers_id', $purchaseSupplierId)->get();
    $totalNeto = DetailPurchase::find($id);
    $products = Product::all();
    $people = Person::all();
    return view('detail-purchase.show', compact('detailPurchases', 'detailPurchase', 'product', 'users', 'totalNeto', 'products', 'people', 'invoice_number', 'gross_total', 'total_tax', 'total_value','net_total','subtotal','igv'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detailPurchase = DetailPurchase::find($id);
        $people = Person::all(); 
        $products = Product::all();
        $purchase_suppliers = PurchaseSupplier::all();
        $users = User::all();
        return view('detail-purchase.edit', compact('detailPurchase', 'people', 'products', 'purchase_suppliers', 'users'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  DetailPurchase $detailPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailPurchase $detailPurchase)
    {
        $input = $request->all();
        $input['price_unit'] = $input['precio_compra'];
        $input['quantity_units'] = $input['cantidad'];
        $input['date_purchase'] = $input['fecha'];

        $input['gross_total'] = $input['quantity_units'] * $input['price_unit'];
        $input['total_tax'] = $input['gross_total'] * ($input['product_tax'] / 100);
        $input['net_total'] = $input['gross_total'] + $input['total_tax'];
        $input['total_value'] = $input['net_total'] - $input['discount_total'];
        $input['products_id'] = $input['producto_id'];
        $input['purchase_suppliers_id'] = $input['people_id'];
        $purchaseSupplier = PurchaseSupplier::where('invoice_number_purchase', $input['factura'])->first();
        if ($purchaseSupplier) {
            $input['purchase_suppliers_id'] = $purchaseSupplier->id;
        }
        $validatedData = Validator::make($input, [
            'price_unit' => 'required|numeric',
            'gross_total' => 'required|numeric',
            'total_tax' => 'required|numeric',
            'product_tax' => 'required|numeric|between:0,19',
            'net_total' => 'required|numeric',
            'total_value' => 'required|numeric',
            'quantity_units' => 'required|numeric',
            'date_purchase' => 'required|date',
            'form_of_payment' => 'required|in:tarjeta,efectivo',
            'discount_total' => 'required|numeric',
            'method_of_payment' => 'required|in:cuotas,contado',
            'products_id' => 'required|exists:products,id',
            'purchase_suppliers_id' => 'required|exists:purchase_suppliers,id',
        ])->validate();
        $detailPurchase->fill($validatedData);
        $detailPurchase->save();
        return redirect()->route('detail-purchases.index')->with('success', 'Compra actualizada con éxito.');
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $detailPurchase = DetailPurchase::find($id);
    
        if ($detailPurchase) {
            if ($detailPurchase->status == true) {
                DetailPurchase::where('id', $detailPurchase->id)
                    ->update([
                        'status' => false
                    ]);
    
            
                PurchaseSupplier::where('id', $detailPurchase->purchase_suppliers_id)
                    ->update([
                        'status' => false
                    ]);
                Session::flash('notificacion', [
                    'tipo' => 'error',
                    'titulo' => 'Atencion!',
                    'descripcion' => 'La Compra se ha inactivado.',
                    'autoCierre' => 'true'
                ]);
            } else {
                DetailPurchase::where('id', $detailPurchase->id)
                    ->update([
                        'status' => true
                    ]);
                PurchaseSupplier::where('id', $detailPurchase->purchase_suppliers_id)
                    ->update([
                        'status' => true
                    ]);
    
                Session::flash('notificacion', [
                    'tipo' => 'exito',
                    'titulo' => 'Éxito!',
                    'descripcion' => 'La compra se ha vuelto a activar.',
                    'autoCierre' => 'true'
                ]);
            }
        }
    
        return redirect()->route('detail-purchases.index');
    }
    
    public function pdf()
    {
        $detailPurchases = DetailPurchase::all();

        $pdf = Pdf::loadView('detail-purchase.pdf', ['detailPurchases' => $detailPurchases])
                    ->setPaper('a4','landscape');

        
        return $pdf->stream('Detalle de compra.pdf');

    
    }
}
