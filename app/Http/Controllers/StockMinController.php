<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Tienda;
use Illuminate\Support\Facades\DB;

class StockMinController extends Controller
{
    public function index(Request $request) 
    {
        $tiendaId = $request->get('tienda_id', 'all');
        
        // Obtener todas las tiendas activas
        $tiendas = Tienda::where('status', 1)->get();
        
        // Query base para productos con stock mínimo
        $query = Product::with(['tienda', 'brand', 'unit', 'stocks'])
            ->join('stocks', 'products.id', '=', 'stocks.product_id')
            ->whereRaw('stocks.quantity <= stocks.minimum_stock')
            ->where('stocks.minimum_stock', '>', 0);
        
        // Filtrar por tienda si se selecciona una específica
        if ($tiendaId !== 'all') {
            $query->where('stocks.tienda_id', $tiendaId);
        }
        
        // Obtener productos con stock mínimo
        $productosStockMin = $query->select('products.*', 'stocks.quantity', 'stocks.minimum_stock', 'stocks.tienda_id')
            ->orderBy('products.description')
            ->get();
        
        // Estadísticas
        $totalProductos = $productosStockMin->count();
        $totalTiendas = $tiendas->count();
        $productosAgotados = $productosStockMin->where('quantity', 0)->count();
        
        return view('product.stockMin.index', compact(
            'productosStockMin',
            'tiendas',
            'tiendaId',
            'totalProductos',
            'totalTiendas',
            'productosAgotados'
        ));
    }
    
  public function exportExcel(Request $request)
{
    $tiendaId = $request->get('tienda_id', 'all');
    
    $query = Product::with(['tienda', 'brand', 'unit', 'stocks'])
        ->join('stocks', 'products.id', '=', 'stocks.product_id')
        ->whereRaw('stocks.quantity <= stocks.minimum_stock')
        ->where('stocks.minimum_stock', '>', 0);
    
    if ($tiendaId !== 'all') {
        $query->where('stocks.tienda_id', $tiendaId);
    }
    
    $productos = $query->select('products.*', 'stocks.quantity', 'stocks.minimum_stock', 'stocks.tienda_id')
        ->orderBy('products.description')
        ->get();
    
    // Obtener nombre de la tienda para el título
    $tiendaNombre = 'Todas las Tiendas';
    if ($tiendaId !== 'all') {
        $tienda = Tienda::find($tiendaId);
        $tiendaNombre = $tienda ? $tienda->nombre : 'Tienda Seleccionada';
    }
    
    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\StockMinExport($productos, $tiendaNombre), 
        'stock_minimo_' . date('Y-m-d_H-i-s') . '.xlsx'
    );
}

}
