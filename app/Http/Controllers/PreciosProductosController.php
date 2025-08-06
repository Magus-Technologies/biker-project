<?php

namespace App\Http\Controllers;

use App\Exports\PreciosProductosExport;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BuyItem;
use App\Models\Buy;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PreciosProductosController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        // Obtener productos con sus precios por mes basado en compras
        $preciosProductos = $this->getPreciosPorMes($year);
        
        // Obtener años disponibles para el filtro
        $yearsAvailable = Buy::selectRaw('YEAR(fecha_registro) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        return view('product.preciosProductos.index', compact('preciosProductos', 'year', 'yearsAvailable'));
    }
    
    private function getPreciosPorMes($year)
    {
        // Obtener todos los productos que tuvieron compras en el año seleccionado
        $productos = Product::select('products.*')
            ->join('buy_items', 'products.id', '=', 'buy_items.product_id')
            ->join('buys', 'buy_items.buy_id', '=', 'buys.id')
            ->whereYear('buys.fecha_registro', $year)
            ->distinct()
            ->get();
        
        $preciosData = [];
        
        foreach ($productos as $producto) {
            $preciosPorMes = [];
            
            // Para cada mes del año
            for ($mes = 1; $mes <= 12; $mes++) {
                // Obtener el precio promedio del producto en ese mes
                $precioPromedio = BuyItem::join('buys', 'buy_items.buy_id', '=', 'buys.id')
                    ->where('buy_items.product_id', $producto->id)
                    ->whereYear('buys.fecha_registro', $year)
                    ->whereMonth('buys.fecha_registro', $mes)
                    ->avg('buy_items.price');
                
                $preciosPorMes[$mes] = $precioPromedio ? round($precioPromedio, 2) : null;
            }
            
            // Solo agregar productos que tengan al menos un precio
            if (array_filter($preciosPorMes)) {
                $preciosData[] = [
                    'producto' => $producto,
                    'precios' => $preciosPorMes
                ];
            }
        }
        
        return $preciosData;
    }
    
    public function exportExcel(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $preciosProductos = $this->getPreciosPorMes($year);
        
        return Excel::download(new PreciosProductosExport($preciosProductos, $year), "precios_productos_{$year}.xlsx");
    }
    
    public function exportPdf(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $preciosProductos = $this->getPreciosPorMes($year);
        
        $pdf = Pdf::loadView('product.preciosProductos.pdf', compact('preciosProductos', 'year'));
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'Arial',
            'isRemoteEnabled' => true,
            'chroot' => public_path(),
            'enable_php' => true
        ]);
            
        return $pdf->download("precios_productos_{$year}.pdf");
    }
    
    public function getDetallesPrecio(Request $request)
    {
        $productId = $request->product_id;
        $year = $request->year;
        $month = $request->month;
        
        $compras = BuyItem::with(['buy.supplier', 'buy.tienda'])
            ->join('buys', 'buy_items.buy_id', '=', 'buys.id')
            ->where('buy_items.product_id', $productId)
            ->whereYear('buys.fecha_registro', $year)
            ->whereMonth('buys.fecha_registro', $month)
            ->select('buy_items.*')
            ->get();
        
        return response()->json($compras);
    }
}