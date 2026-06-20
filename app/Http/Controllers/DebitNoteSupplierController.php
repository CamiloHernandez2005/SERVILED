<?php

namespace App\Http\Controllers;
use App\Models\debitNoteSupplier;
use App\Models\PurchaseSupplier;
use App\Models\DetailPurchase;
use App\Models\Person;
use App\Models\People;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
/**
 * Class debitNoteSupplierController
 * @package App\Http\Controllers
 */
class debitNoteSupplierController extends Controller
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

        $uniqueDebitNoteSupplierIds = DB::table('debit_note_suppliers')
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('purchase_suppliers_id')
            ->pluck('id');

        $debitNoteSuppliers = DebitNoteSupplier::whereIn('id', $uniqueDebitNoteSupplierIds)
            ->when($filtervalue, function ($query) use ($filtervalue, $status) {
                $filtervalue = strtolower($filtervalue);
                return $query->whereRaw('LOWER(debit_note_code) LIKE ?', ['%' . $filtervalue . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $filtervalue . '%'])
                    ->orWhereRaw('LOWER(total) LIKE ?', ['%' . $filtervalue . '%'])
                    ->orWhere('quantity', intval($filtervalue))
                    ->orWhere('status', $status)
                    ->orWhereHas('detailPurchase', function ($query) use ($filtervalue) {
                        return $query->whereRaw('LOWER(discount_total) LIKE ?', ['%' . $filtervalue . '%'])
                            ->orWhereRaw('LOWER(product_tax) LIKE ?', ['%' . $filtervalue . '%'])
                            ->orWhereRaw('LOWER(form_of_payment) LIKE ?', ['%' . $filtervalue . '%']);
                    })
                    ->orWhereHas('purchaseSupplier', function ($query) use ($filtervalue) {
                        return $query->whereRaw('LOWER(invoice_number_purchase) LIKE ?', ['%' . $filtervalue . '%'])
                            ->orWhereHas('person', function ($query) use ($filtervalue) {
                                return $query->whereRaw('LOWER(identification_type) LIKE ?', ['%' . $filtervalue . '%'])
                                    ->orWhereRaw('LOWER(identification_number) LIKE ?', ['%' . $filtervalue . '%'])
                                    ->orWhereRaw('LOWER(company_name) LIKE ?', ['%' . $filtervalue . '%'])
                                    ->orWhereRaw('LOWER(first_name) LIKE ?', ['%' . $filtervalue . '%'])
                                    ->orWhereRaw('LOWER(other_name) LIKE ?', ['%' . $filtervalue . '%']);
                            });
                    });
            })
            ->get();

        return view('debit-note-supplier.index', compact('debitNoteSuppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $lastDebitNoteSupplier = DebitNoteSupplier::orderBy('id', 'desc')->first();

        
        $debitNoteId = $lastDebitNoteSupplier ? $lastDebitNoteSupplier->id + 1 : 1;

        $debitNoteSupplier = new debitNoteSupplier();
        $people = Person::where('rol', 'Proveedor')->get();
        $products = Product::all();
        $detailPurchases = DetailPurchase::with('purchaseSupplier', 'product')->get();
        $detailPurchase = DetailPurchase::all();
        $users = User::all();
        $purchaseSuppliers = PurchaseSupplier::all();

        $detailPurchaseDates = $detailPurchases->mapWithKeys(function ($item) {
            return [$item->purchaseSupplier->id => $item->date_purchase];
        });

        $detailPurchaseProducts = $detailPurchases->mapWithKeys(function ($item) {
            return [$item->purchaseSupplier->id => $item->product->name_product];
        });

        $detailPurchaseData = [];
        foreach ($detailPurchases as $detailPurchase) {
            $purchaseSupplierId = $detailPurchase->purchaseSupplier->id;
            if (!isset($detailPurchaseData[$purchaseSupplierId])) {
                $detailPurchaseData[$purchaseSupplierId] = [];
            }
            $detailPurchaseData[$purchaseSupplierId][] = [
                'product_name' => $detailPurchase->product->name_product,
                'price_unit' => $detailPurchase->price_unit,
                'product_tax' => $detailPurchase->product_tax,
                'discount_total' => $detailPurchase->discount_total,
                'descuento'=> $detailPurchase->description,
                'quantity_units' => $detailPurchase->quantity_units,
            ];
        }
        return view('debit-note-supplier.create', compact(
            'debitNoteSupplier',
            'debitNoteId',
            'purchaseSuppliers',
            'detailPurchases',
            'detailPurchase',
            'people',
            'products',
            'users',
            'detailPurchaseDates',
            'detailPurchaseProducts',
            'detailPurchaseData'
        ));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
        public function verificarNotaDebito(Request $request)
    {
        $lastRecord = DebitNoteSupplier::where('purchase_suppliers_id', $request->factura)->exists();
        return response()->json(['existe' => $lastRecord]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto.*' => 'required',
            'cantidad.*' => [
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value)) {
                        $fail('Se debe ingresar una cantidad.');
                        Session::flash('notificacion', [
                            'tipo' => 'error',
                            'titulo' => 'Atención!',
                            'descripcion' => 'Se debe ingresar una cantidad.',
                            'autoCierre' => 'true'
                        ]);
                    } elseif ($value <= 0) {
                        $fail('La cantidad ingresada no puede ser negativa o cero.');
                        Session::flash('notificacion', [
                            'tipo' => 'error',
                            'titulo' => 'Atención!',
                            'descripcion' => 'La cantidad ingresada no puede ser negativa o cero.',
                            'autoCierre' => 'true'
                        ]);
                    }
                },
            ],
            'descripcion.*' => [
                function ($attribute, $value, $fail) {
                    if (empty($value)) {
                        $fail('Se necesita agregar la descripción del porqué se va a realizar la nota débito.');
                        Session::flash('notificacion', [
                            'tipo' => 'error',
                            'titulo' => 'Atención!',
                            'descripcion' => 'Se necesita agregar la descripción del porqué se va a realizar la nota débito.',
                            'autoCierre' => 'true'
                        ]);
                    }
                },
            ],
            'precio_unitario.*' => 'required',
            'descuento.*' => 'required',
            'iva.*' => 'required',
            'totalNeto' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value < 0) {
                        $fail('El total neto no puede ser negativo.');
                        Session::flash('notificacion', [
                            'tipo' => 'error',
                            'titulo' => 'Atención!',
                            'descripcion' => 'El total neto no puede ser negativo.',
                            'autoCierre' => 'true'
                        ]);
                    }
                },
            ],
            'gross_total' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value < 0) {
                        $fail('El total bruto no puede ser negativo.');
                        Session::flash('notificacion', [
                            'tipo' => 'error',
                            'titulo' => 'Atención!',
                            'descripcion' => 'El total bruto no puede ser negativo.',
                            'autoCierre' => 'true'
                        ]);
                    }
                },
            ],
            'total' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value < 0) {
                        $fail('El total no puede ser negativo.');
                        Session::flash('notificacion', [
                            'tipo' => 'error',
                            'titulo' => 'Atención!',
                            'descripcion' => 'El total no puede ser negativo.',
                            'autoCierre' => 'true'
                        ]);
                    }
                },
            ],
            'motive' => 'required',
        ], [
            'motive.required' => 'El motivo por el cual se realiza la nota es obligatorio.',
        ]);

        $purchaseSupplierId = $request->input('factura');
        $lastRecord = DebitNoteSupplier::where('purchase_suppliers_id', $purchaseSupplierId)->exists();

        if ($lastRecord) {
            return redirect()->back()->withErrors(['factura' => 'El número de factura ya tiene una nota debito.']);
        }
        $detailPurchases = DetailPurchase::where('purchase_suppliers_id', $purchaseSupplierId)->get();

        if (count($detailPurchases) == 0) {
            return redirect()->back()->withErrors(['factura' => 'Porfavor Ingrese un Numero de factura.']);
        }

        $productos = $request->input('producto');
        $cantidades = $request->input('cantidad');

        if (count($cantidades) == 0) {
            return redirect()->back()->withErrors(['factura' => 'Por favor, ingrese una cantidad valida.']);
        }

        foreach ($cantidades as $cantidad) {
            if ($cantidad < 0) {
                return redirect()->back()->withErrors(['cantidad' => 'No se aceptan valores negativos.']);
            }
        }
        $descripciones = $request->input('descripcion');
        $precios_unitarios = $request->input('precio_unitario');
        $descuentos = $request->input('descuento');
        $ivas = $request->input('iva');

        for ($i = 0; $i < count($productos); $i++) {
            if (!isset($detailPurchases[$i])) {
                return redirect()->back()->withErrors(['producto' => 'No hay suficientes detailPurchases para los productos.']);
            }

            $debitNoteSupplier = new debitNoteSupplier;
            $debitNoteSupplier->debit_note_code = $request->input('debit_note_code');
            $debitNoteSupplier->date_invoice = $request->input('date_invoice');
            $debitNoteSupplier->users_id = $request->input('users_id');
            $debitNoteSupplier->description = $descripciones[$i];
            $debitNoteSupplier->quantity = $cantidades[$i];
            $debitNoteSupplier->total = $request->input('total');
            $debitNoteSupplier->net_total = $request->input('totalNeto');
            $debitNoteSupplier->gross_total = $request->input('gross_total');
            $debitNoteSupplier->updated_at = $request->input('updated_at');
            $debitNoteSupplier->created_at = $request->input('created_at');
            $debitNoteSupplier->purchase_suppliers_id = $purchaseSupplierId;
            $debitNoteSupplier->detail_purchase_id = $detailPurchases[$i]->id;
            $debitNoteSupplier->motive = $request->input('motive');
            $debitNoteSupplier->save();
        }
        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'Nota Debito Creada Exitosamente.',
            'autoCierre' => 'true'
        ]);
        return redirect()->route('debit-note-supplier.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $debitNoteSupplier = debitNoteSupplier::find($id);
        $debitNoteId = $debitNoteSupplier->id;
        $purchaseSupplierId = $debitNoteSupplier->purchase_suppliers_id;
        $debitNoteSuppliers = debitNoteSupplier::where('purchase_suppliers_id', $purchaseSupplierId)->get();

        $detailPurchases = DetailPurchase::with('purchaseSupplier', 'product')->get();
        $descuentoTotal = 0;
        foreach ($debitNoteSuppliers as $debitNoteSupplier) {
            $descuentoTotal += $debitNoteSupplier->detailPurchase->discount_total;
        }
        
        $detailPurchaseData = [];
        $detailPurchaseDates = [];
        $detailPurchaseProducts = [];
        foreach ($detailPurchases as $detailPurchase) {
            $purchaseSupplierId = $detailPurchase->purchaseSupplier->id;
            $detailPurchaseData[$purchaseSupplierId] = [
                'price_unit' => $detailPurchase->price_unit,
                'product_tax' => $detailPurchase->product_tax,
                'discount_total' => $detailPurchase->discount_total,
            ];
            $detailPurchaseDates[$purchaseSupplierId] = $detailPurchase->date_purchase;
            $detailPurchaseProducts[$purchaseSupplierId] = $detailPurchase->product->name_product;
        }

        if ($debitNoteSupplier !== null) {
            $detailPurchase = DetailPurchase::with('purchaseSupplier')->where('id', $debitNoteSupplier->detail_purchase_id)->first();
        }

        $people = Person::where('rol', 'Proveedor')->get();
        $products = Product::all();
        $detailPurchases = DetailPurchase::with('purchaseSupplier')->get();
        $users = User::all();
        $purchaseSuppliers = PurchaseSupplier::all();

        return view('debit-note-supplier.show', compact('debitNoteSuppliers', 'debitNoteSupplier', 'detailPurchase', 'detailPurchases', 'people', 'products', 'users', 'purchaseSuppliers', 'detailPurchaseData', 'detailPurchaseDates', 'detailPurchaseProducts','debitNoteId', 'descuentoTotal'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $debitNoteSupplier = debitNoteSupplier::find($id);
        if (!$debitNoteSupplier) {
            return redirect()->back()->withErrors(['error' => 'No se encontró el DebitNoteSupplier con el id proporcionado.']);
        }

        $purchaseSupplierId = $debitNoteSupplier->purchase_suppliers_id;
        $debitNoteSuppliers = DebitNoteSupplier::where('purchase_suppliers_id', $purchaseSupplierId)->get();

        $detailPurchases = DetailPurchase::with('purchaseSupplier', 'product')->get();

        $detailPurchaseData = [];
        foreach ($detailPurchases as $detailPurchase) {
            $purchaseSupplierId = $detailPurchase->purchaseSupplier->id;
            if (!isset($detailPurchaseData[$purchaseSupplierId])) {
                $detailPurchaseData[$purchaseSupplierId] = [];
            }
            $detailPurchaseData[$purchaseSupplierId][] = [
                'product_name' => $detailPurchase->product->name_product,
                'price_unit' => $detailPurchase->price_unit,
                'product_tax' => $detailPurchase->product_tax,
                'discount_total' => $detailPurchase->discount_total,
            ];
        }

        $detailPurchaseDates = $detailPurchases->mapWithKeys(function ($item) {
            return [$item->purchaseSupplier->id => $item->date_purchase];
        });

        $detailPurchaseProducts = $detailPurchases->mapWithKeys(function ($item) {
            return [$item->purchaseSupplier->id => $item->product->name_product];
        });

        $people = Person::where('rol', 'Proveedor')->get();
        $products = Product::all();
        $users = User::all();
        $purchaseSuppliers = PurchaseSupplier::all();

        
        $lastDebitNoteSupplier = DebitNoteSupplier::orderBy('id', 'desc')->first();

       
        $debitNoteId = $lastDebitNoteSupplier ? $lastDebitNoteSupplier->id + 1 : 1;

        return view('debit-note-supplier.edit', compact('debitNoteSuppliers', 'debitNoteSupplier', 'detailPurchases', 'people', 'products', 'users', 'purchaseSuppliers', 'detailPurchaseData', 'detailPurchaseDates', 'detailPurchaseProducts', 'debitNoteId'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  debitNoteSupplier $debitNoteSupplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([

            'producto' => 'required|array',
            'cantidad' => 'required|array',
            'descripcion' => 'required|array',
            'precio_unitario' => 'required|array',
            'descuento' => 'required|array',
            'iva' => 'required|array',
            'net_total' => 'required',
            'gross_total' => 'required',
        ]);

        $ids = $request->input('id');
        $productos = $request->input('producto');
        $cantidades = $request->input('cantidad');
        $descripciones = $request->input('descripcion');
        $precios_unitarios = $request->input('precio_unitario');
        $descuentos = $request->input('descuento');
        $ivas = $request->input('iva');

        for ($i = 0; $i < count($productos); $i++) {
            $debitNoteSupplier = DebitNoteSupplier::find($ids[$i]);

            $debitNoteSupplier->debit_note_code = $request->input('debit_note_code');
            $debitNoteSupplier->date_invoice = $request->input('date_invoice');
            $debitNoteSupplier->users_id = $request->input('users_id');
            $debitNoteSupplier->description = $descripciones[$i];
            $debitNoteSupplier->quantity = $cantidades[$i];
            $debitNoteSupplier->total = $precios_unitarios[$i] * $cantidades[$i]; 
            $debitNoteSupplier->net_total = $request->input('net_total');
            $debitNoteSupplier->gross_total = $request->input('gross_total');
            $debitNoteSupplier->updated_at = $request->input('updated_at');
            $debitNoteSupplier->created_at = $request->input('created_at');
            $debitNoteSupplier->purchase_suppliers_id = $request->input('factura');

            $detailPurchase = DetailPurchase::where('purchase_suppliers_id', $debitNoteSupplier->purchase_suppliers_id)->first();
            if ($detailPurchase) {
                $debitNoteSupplier->detail_purchase_id = $detailPurchase->id;
            } else {
                return redirect()->back()->withErrors(['factura' => 'No se encontró un detailPurchase para esta factura.']);
            }

            $debitNoteSupplier->save();
        }

        return redirect()->route('debit-note-supplier.index')
            ->with('success', 'DebitNoteSupplier updated successfully.');
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $debitNoteSupplier = DebitNoteSupplier::find($id);

        if ($debitNoteSupplier) {
            if ($debitNoteSupplier->status == 1) {
                DebitNoteSupplier::where('id', $debitNoteSupplier->id)
                    ->update([
                        'status' => 0
                    ]);

                Session::flash('notificacion', [
                    'tipo' => 'error',
                    'titulo' => 'Atencion!',
                    'descripcion' => 'La nota debito se ha inactivado correctamente.',
                    'autoCierre' => 'true'
                ]);
            } else {
                DebitNoteSupplier::where('id', $debitNoteSupplier->id)
                    ->update([
                        'status' => 1
                    ]);

                Session::flash('notificacion', [
                    'tipo' => 'exito',
                    'titulo' => 'Éxito!',
                    'descripcion' => 'La nota debito se ha vuelto a activar.',
                    'autoCierre' => 'true'
                ]);
            }
        }

        return redirect()->route('debit-note-supplier.index');
    }

    public function pdf()
    {
        $debitNoteSuppliers = debitNoteSupplier::all();

        $pdf = Pdf::loadView('debit-note-supplier.pdf', ['debitNoteSuppliers' => $debitNoteSuppliers])
                    ->setPaper('a4','landscape');

    
        return $pdf->stream('Compras - Nota debito.pdf');

    
    }
}
