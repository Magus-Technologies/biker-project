<?php

use App\Http\Controllers\ClienteMayoristaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WholesaleController;
use App\Http\Controllers\CustomerController;
use App\Models\Product;
use App\Models\Wholesaler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:administrador|mecanico|ventas'])
    ->name('dashboard');
Route::group(
    ['middleware' => ['role:administrador|mecanico|ventas']],
    function () {
        Route::resource('permissions', App\Http\Controllers\PermissionController::class);
        Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

        Route::resource('roles', App\Http\Controllers\RoleController::class);
        Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
        Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
        Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
        //CLIENTES
        Route::resource('drives', App\Http\Controllers\CustomerController::class);
        Route::get('/drives/{id}/details', [CustomerController::class, 'getDetails'])->name('drives.details');
        //MECANICOS
        Route::resource('mechanics', App\Http\Controllers\MechanicController::class);
        Route::get('mechanic/MecanicosDisponibles', [App\Http\Controllers\MechanicController::class, 'MecanicosDisponibles'])->name('obtener.MecanicosDisponibles');
        //VEHICULOS
        Route::resource('cars', App\Http\Controllers\CarController::class);
        Route::get('car/buscarPorPlaca', [App\Http\Controllers\CarController::class, 'searchDriverPorPlaca'])->name('buscar.DriverPorPlaca');
        Route::get('car/buscarDrive', [App\Http\Controllers\CarController::class, 'searchBuscarDriver'])->name('buscar.Driver');
        Route::get('car/buscarPornroMotor', [App\Http\Controllers\CarController::class, 'searchBuscarVehiculo'])->name('buscar.Vehiculo');
        // PRODUCTOS
        Route::resource('products', App\Http\Controllers\ProductController::class);
        Route::post('/products/{product}/manage-stock', [App\Http\Controllers\ProductController::class, 'manageStock'])->name('products.manage-stock');
        Route::get('/products/{productId}/stock-codes', [App\Http\Controllers\ProductController::class, 'getStockCodes']);
        Route::get('product/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
        Route::get('product/export', [App\Http\Controllers\ProductController::class, 'export'])->name('products.export');
        Route::get('/productos/{id}/imagenes', function ($id) {
            $product = Product::findOrFail($id);
            return response()->json($product->images);
        });
        
        // Route::get('product/import', [App\Http\Controllers\ProductController::class, 'import'])->name('products.import');
        Route::get('/plantilla-descargar', [App\Http\Controllers\ProductController::class, 'descargarPlantilla'])->name('plantilla.descargar');
        Route::post('/product/import', [App\Http\Controllers\ProductController::class, 'import'])->name('products.import');

        // Busca la sección de productos y agrega esta línea después:
        Route::get('/warehouses/by-tienda', [App\Http\Controllers\ProductController::class, 'getWarehousesByTienda'])->name('warehouses.by-tienda');
        
        //SERVICIOS
        Route::resource('services', App\Http\Controllers\ServiceController::class);
        Route::get('/service/listado', [ServiceController::class, 'filtroPorfecha'])->name('service.filtroPorfecha');
        Route::post('/service/cambiarEstado', [ServiceController::class, 'cambiarEstado'])->name('service.cambiarEstado');
        Route::get('/service/detalles', [ServiceController::class, 'verDetalles'])->name('service.verDetalles');

        //GARANTIAS
        Route::resource('garantines', App\Http\Controllers\GarantineController::class);
        //TRABAJADORES CON SUS ROLES
        Route::resource('workers', App\Http\Controllers\UserController::class);
        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
        //VENTAS
        Route::resource('sales', SaleController::class);
        Route::get('/sale/listado', [SaleController::class, 'filtroPorfecha'])->name('sales.filtroPorfecha');
        Route::get('/sale/detalles/{id}', [SaleController::class, 'detallesVenta'])->name('sale.detallesVenta');
        Route::get('/sale/pdf/{id}', [SaleController::class, 'generatePDF'])->name('sales.pdf');

        Route::get('/sale/pdf/nota/{id}', [SaleController::class, 'generatePDFNotaVenta'])->name('salesNota.pdf');
        Route::post('/sale/enviar-sunat/{id}', [SaleController::class, 'enviarSunat'])->name('sales.enviarSunat');
        //UNIDAD MEDIDA
        Route::resource('units', App\Http\Controllers\UnitController::class);
        Route::get('/units', [UnitController::class, 'search']);
        // COTIZACIONES
        Route::resource('quotations', QuotationController::class);
        Route::get('/quotation/listado', [QuotationController::class, 'filtroPorfecha'])->name('quotations.filtroPorfecha');
        Route::get('/quotation/detalles/{id}', [QuotationController::class, 'detallesQuotation'])->name('quotations.detallesQuotation');
        Route::get('/quotation/pdf/{id}', [QuotationController::class, 'generatePDF'])->name('quotations.pdf');
        Route::post('/quotation/cotizacion/vender/{id}', [QuotationController::class, 'vender'])->name('quotations.vender');
        Route::get('mechanic/MecanicosDisponibles', [App\Http\Controllers\QuotationController::class, 'MecanicosDisponibles'])->name('mecanicosDisponibles');
        //MAYORISTA
        Route::resource('wholesalers', WholesaleController::class);
        Route::get('/wholesaler/listado', [WholesaleController::class, 'filtroPorfecha'])->name('wholesalers.filtroPorfecha');
        Route::get('/wholesaler/detalles/{id}', [WholesaleController::class, 'detallesWholesaler'])->name('wholesalers.detallesWholesaler');
        Route::get('/wholesaler/pdf/{id}', [WholesaleController::class, 'generatePDF'])->name('wholesalers.pdf');
        // compras
        Route::resource('buys', BuyController::class);
        Route::post('/buy/producto/addStock', [BuyController::class, 'addStock'])->name('buy.addStock');
        Route::get('buy/search', [App\Http\Controllers\BuyController::class, 'search'])->name('buy.search');
        Route::get('/buy/detalles/{id}', [BuyController::class, 'detallesBuy'])->name('buy.detallesBuy');
        Route::get('/buy/pdf/{id}', [BuyController::class, 'generatePDF'])->name('buy.pdf');
        // Dentro del grupo de middleware, después de las rutas existentes de buy:
        Route::post('/buy/receive-products/{buyId}', [BuyController::class, 'receiveProducts'])->name('buy.receiveProducts');
        Route::get('/buy/export-excel', [BuyController::class, 'exportExcel'])->name('buy.exportExcel');
        Route::get('/buy/detailed-report', [BuyController::class, 'generateDetailedPDF'])->name('buy.detailedReport');
        Route::get('/buy/download-template', [BuyController::class, 'downloadImportTemplate'])->name('buy.downloadTemplate');
        Route::post('/buy/import', [BuyController::class, 'importBuys'])->name('buy.import');
        // Dentro del grupo de rutas de compras, agrega:
        Route::post('/buy/process-import', [BuyController::class, 'processImportFile'])->name('buy.processImport');
        Route::post('/buy/import-selected', [BuyController::class, 'importSelectedBuys'])->name('buy.importSelected');
        Route::get('/buy/price-history/{productId}', [BuyController::class, 'getPriceHistory'])->name('buy.priceHistory');
        // Dentro del grupo de rutas de buy, agrega:
        Route::get('/buy/modal-details/{id}', [BuyController::class, 'getModalDetails'])->name('buy.modalDetails');
        Route::post('/buy/installment/{id}/mark-paid', [BuyController::class, 'markInstallmentAsPaid'])->name('buy.markInstallmentPaid');
        Route::post('/buy/installment/{id}/mark-pending', [BuyController::class, 'markInstallmentAsPending'])->name('buy.markInstallmentPending');
        // Dentro del grupo de rutas de buy, agrega:
        Route::get('/buy/{id}/reception-data', [BuyController::class, 'getReceptionData'])->name('buy.receptionData');
        Route::post('/buy/{id}/process-reception', [BuyController::class, 'processReception'])->name('buy.processReception');

        // NUEVAS RUTAS - Agregar estas líneas adicionales:
        Route::get('/buy/search-products', [BuyController::class, 'searchProducts'])->name('buy.search-products');
        Route::get('/buy/buscar-documento/{doc}', [BuyController::class, 'buscarDocumento'])->name('buy.buscar-documento');
        Route::post('/buy/create-quick-supplier', [BuyController::class, 'createQuickSupplier'])->name('buy.create-quick-supplier');
        Route::post('/buy/store-purchase', [BuyController::class, 'storePurchase'])->name('buy.store-purchase');
        Route::get('/buy/statistics', [BuyController::class, 'getStatistics'])->name('buy.statistics');
        Route::post('/buy/update-prices-massive', [BuyController::class, 'updatePricesMassive'])->name('buy.update-prices-massive');
        Route::get('/buy/supplier-report', [BuyController::class, 'supplierReport'])->name('buy.supplier-report');
        Route::get('/buy/top-products-report', [BuyController::class, 'topProductsReport'])->name('buy.top-products-report');

        Route::get('/buy/receive/{buyId}', function($buyId) {
            $buy = App\Models\Buy::with(['supplier', 'tienda', 'buyItems.product'])->findOrFail($buyId);
            
            if ($buy->delivery_status === 'received') {
                return redirect()->route('buys.index')->with('error', 'Esta compra ya fue recepcionada');
            }
            
            $tiendas = App\Models\Tienda::where('status', 1)->get();
            
            return view('buy.receive', compact('buy', 'tiendas'));
        })->name('buy.receive');


        // Agregar estas nuevas rutas:
        Route::get('/buy/filtered-list', [BuyController::class, 'filteredList'])->name('buy.filteredList');
        Route::get('/buy/export-reports', [BuyController::class, 'exportReports'])->name('buy.exportReports');

        Route::resource('clientes-mayoristas', ClienteMayoristaController::class);
        Route::get('/clientes-mayoristas/{id}/detalles', [ClienteMayoristaController::class, 'obtenerDetalles'])
        ->name('clientes-mayoristas.detalles');

        Route::get('/buy/receive/{buyId}', function($buyId) {
        $buy = App\Models\Buy::with(['supplier', 'tienda', 'buyItems.product'])->findOrFail($buyId);
        
        if ($buy->delivery_status === 'received') {
            return redirect()->route('buys.index')->with('error', 'Esta compra ya fue recepcionada');
        }
        
        $tiendas = App\Models\Tienda::where('status', 1)->get();
        
        return view('buy.receive', compact('buy', 'tiendas'));
    })->name('buy.receive');
    }
);
require __DIR__ . '/auth.php';
