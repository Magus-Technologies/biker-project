<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Drive;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Obtener métricas principales
        $totalServicios = Service::where('status', 1)->count();
        $serviciosEnProceso = Service::where('status_service', 'en_proceso')->count();
        $serviciosCompletados = Service::where('status_service', 'completado')->count();
        $totalConductores = Drive::where('status', 1)->count();
        
        // Productos con stock bajo (menos de 10 unidades)
        $productosStockBajo = Product::with(['brand', 'unit', 'stocks'])  // ← 'stocks' plural
            ->whereHas('stocks', function($query) {  // ← 'stocks' plural
                $query->where('quantity', '<', 10);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Servicios pendientes (últimos 10)
        $serviciosPendientes = Service::with(['drive', 'car', 'user'])
            ->where('status_service', '!=', 'completado')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Conductores registrados recientemente
        $conductoresRecientes = Drive::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('dashboard', compact(
            'totalServicios',
            'serviciosEnProceso', 
            'serviciosCompletados',
            'totalConductores',
            'productosStockBajo',
            'serviciosPendientes',
            'conductoresRecientes'
        ));
    }
}