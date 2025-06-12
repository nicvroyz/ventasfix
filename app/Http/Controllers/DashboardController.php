<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard con estadísticas del sistema
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'usuarios' => User::count(),
            'productos' => Producto::count(),
            'clientes' => Cliente::count(),
            'productos_bajo_stock' => Producto::whereRaw('stock_actual <= stock_bajo')->count(),
            'ultimos_productos' => Producto::latest()->take(5)->get(),
            'ultimos_clientes' => Cliente::latest()->take(5)->get(),
        ];

        return view('dashboard', compact('stats'));
    }
}
