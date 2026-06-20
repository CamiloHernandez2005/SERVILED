<?php

namespace App\Http\Controllers;

use App\Models\PurchaseSupplier;
use App\Models\User;
use App\Models\Person;
use Illuminate\Http\Request;

/**
 * Class PurchaseSupplierController
 * @package App\Http\Controllers
 */
class PurchaseSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DataTables maneja búsqueda, orden y paginación en el navegador,
        // por eso traemos todas las compras (con su proveedor para evitar N+1).
        $purchaseSuppliers = PurchaseSupplier::with('person')->get();

        return view('purchase-supplier.index', compact('purchaseSuppliers'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $users = User::all();
        $people = Person::all();
        $purchaseSupplier = new PurchaseSupplier();
        return view('purchase-supplier.create', compact('purchaseSupplier','users','people'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number_purchase' => 'required|unique:purchase_suppliers',
            'date_invoice_purchase' => 'required|date',
            'code'=> 'required',
            'users_id' => 'required|exists:users,id',
            'people_id' => 'required|exists:people,id',
        ], [
            'invoice_number_purchase.required' => 'Por favor, inserte un número de factura.',
            'invoice_number_purchase.unique' => 'El número de factura ya existe.',
            'date_invoice_purchase.required' => 'Por favor, inserte la fecha de la factura.',
            'code'=>'porfavor inserte el prefijo parala factura creada',
            'date_invoice_purchase.date' => 'Por favor, inserte una fecha válida.',
            'users_id.required' => 'Por favor, seleccione un empleado.',
            'users_id.exists' => 'El empleado seleccionado no existe.',
            'people_id.required' => 'Por favor, seleccione un proveedor.',
            'people_id.exists' => 'El proveedor seleccionado no existe.',
        ]);
    
        $data = $request->all();
       // dd($request->all());
    
        $purchaseSupplier = PurchaseSupplier::create($data);
    
        return redirect()->route('purchase_supplier.index')
            ->with('success', 'Datos almacenados correctamente.');
    }
    
    


    

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchaseSupplier = PurchaseSupplier::find($id);
        $users = User::all();
        $people = Person::all();
        return view('purchase-supplier.show', compact('purchaseSupplier','users','people'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $users = User::all();
    $people = Person::all();
    $purchaseSupplier = PurchaseSupplier::find($id);
    return view('purchase-supplier.edit', compact('purchaseSupplier','users','people'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  PurchaseSupplier $purchaseSupplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseSupplier $purchaseSupplier)
    {
        request()->validate(PurchaseSupplier::$rules);
    
        $purchaseSupplier->update($request->all());
    
        return redirect()->route('purchase_supplier.index')
            ->with('success', 'datos actualizados correctamente');
    }
    

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
{
    $purchaseSupplier = PurchaseSupplier::find($id);

    if ($purchaseSupplier) {
        $purchaseSupplier->delete();
        return redirect()->route('purchase_supplier.index')
            ->with('success', 'Datos Eliminados Correctamente');
    } else {
        return redirect()->route('purchase_supplier.index')
            ->with('error', 'PurchaseSupplier not found');
    }
}
}
