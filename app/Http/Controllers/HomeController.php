<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\DetailPurchase;
use App\Models\Person;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\PurchaseSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    //
    public function index(Request $request, User $usuario)
    {
        $users = User::all();
        $productos = count(Product::all());
        $sales = count(Sale::all());
        $purchase = count(PurchaseSupplier::all());
        $salesToday = Sale::whereDate('created_at', Carbon::today())->paginate(5);
        $purchaseToday = DetailPurchase::whereDate('created_at', Carbon::today())->paginate(5);
        $dataProduct = Product::where('stock', '<', 5)->paginate(2);
        $person = count(Person::all());
        $rolesUsuario = optional($users->first())->roles()?->pluck('name')->all() ?? [];
        $roles = Role::all();
        $totalVentasHoy = Sale::whereDate('created_at', Carbon::today())->sum('net_total');

        // Valor de caja del dia. Si aun no se ha registrado hoy, el dashboard
        // mostrara un modal pidiendolo (solo la primera vez del dia).
        $cajaHoy = CashRegister::whereDate('date', Carbon::today())->first();

        return view('home.index', compact('totalVentasHoy', 'salesToday', 'purchaseToday', 'users', 'productos', 'sales', 'purchase', 'person', 'dataProduct', 'roles', 'rolesUsuario', 'cajaHoy'));
    }

    /**
     * Registra el valor de caja del dia (base de caja). Solo se guarda una vez
     * por dia; si ya existe se actualiza.
     */
    public function guardarCaja(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ], [
            'amount.required' => 'Ingresa el valor de caja',
            'amount.numeric' => 'El valor de caja debe ser numérico',
            'amount.min' => 'El valor de caja no puede ser negativo',
        ]);

        CashRegister::updateOrCreate(
            ['date' => Carbon::today()->toDateString()],
            ['amount' => $request->input('amount'), 'user_id' => auth()->id()]
        );

        Session::flash('notificacion', [
            'tipo' => 'exito',
            'titulo' => 'Éxito!',
            'descripcion' => 'El valor de caja se ha registrado.',
            'autoCierre' => 'true'
        ]);

        return redirect()->route('home');
    }

    public function calcularTotalVentasHoy()
    {
        // Obtener la fecha actual
        $fechaHoy = Carbon::today()->toDateString();

        // Consulta para obtener el total de ventas para el día de hoy
        $totalVentasHoy = Sale::whereDate('created_at', $fechaHoy)->sum('net_total');

        return $totalVentasHoy;
    }
}
