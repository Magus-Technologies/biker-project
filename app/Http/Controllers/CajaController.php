<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CajaMovimiento;
use App\Models\PaymentMethod;
use App\Models\Tienda;
use App\Exports\CajasExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class CajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-cajas', ['only' => ['index']]);
        $this->middleware('permission:abrir-caja', ['only' => ['create', 'store']]);
        $this->middleware('permission:cerrar-caja', ['only' => ['close', 'cerrar']]);
    }

    /**
     * Mostrar listado de cajas
     */
    public function index()
    {
        $cajas = Caja::with(['usuario', 'tienda', 'usuarioCierre'])
            ->orderBy('fecha_apertura', 'desc')
            ->paginate(20);

        // Verificar si el usuario tiene una caja abierta
        $cajaAbierta = Caja::cajaAbiertaDelUsuario(auth()->id());

        return view('cajas.index', compact('cajas', 'cajaAbierta'));
    }

    /**
     * Mostrar formulario para abrir caja
     */
    public function create()
    {
        // Verificar si ya tiene una caja abierta
        if (Caja::usuarioTieneCajaAbierta(auth()->id())) {
            return redirect()->route('cajas.index')
                ->with('error', 'Ya tienes una caja abierta. Debes cerrarla antes de abrir una nueva.');
        }

        $tiendas = Tienda::where('status', 1)->get();
        
        return view('cajas.create', compact('tiendas'));
    }

    /**
     * Abrir una nueva caja
     */
    public function store(Request $request)
    {
        $request->validate([
            'monto_inicial' => 'required|numeric|min:0',
            'tienda_id' => 'nullable|exists:tiendas,id',
            'observaciones_apertura' => 'nullable|string|max:500',
        ], [
            'monto_inicial.required' => 'El monto inicial es obligatorio',
            'monto_inicial.numeric' => 'El monto inicial debe ser un número',
            'monto_inicial.min' => 'El monto inicial no puede ser negativo',
        ]);

        // Verificar nuevamente que no tenga caja abierta
        if (Caja::usuarioTieneCajaAbierta(auth()->id())) {
            return redirect()->route('cajas.index')
                ->with('error', 'Ya tienes una caja abierta.');
        }

        DB::beginTransaction();
        try {
            // Crear la caja
            $caja = Caja::create([
                'codigo' => Caja::generarCodigo(),
                'user_id' => auth()->id(),
                'tienda_id' => $request->tienda_id,
                'fecha_apertura' => now(),
                'monto_inicial' => $request->monto_inicial,
                'monto_final_esperado' => $request->monto_inicial,
                'estado' => 'abierta',
                'observaciones_apertura' => $request->observaciones_apertura,
            ]);

            // Registrar movimiento de apertura
            CajaMovimiento::create([
                'caja_id' => $caja->id,
                'tipo' => 'ingreso',
                'concepto' => 'apertura',
                'monto' => $request->monto_inicial,
                'descripcion' => 'Apertura de caja - Fondo inicial',
                'user_id' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('cajas.show', $caja->id)
                ->with('success', 'Caja abierta exitosamente. Código: ' . $caja->codigo);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al abrir la caja: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar detalle de una caja
     */
    public function show($id)
    {
        $caja = Caja::with(['usuario', 'tienda', 'usuarioCierre', 'movimientos.metodoPago', 'movimientos.usuario'])
            ->findOrFail($id);

        $metodosPago = PaymentMethod::where('status', 1)->get();

        return view('cajas.show', compact('caja', 'metodosPago'));
    }

    /**
     * Mostrar formulario para cerrar caja
     */
    public function close($id)
    {
        $caja = Caja::findOrFail($id);

        // Validar que solo el dueño pueda cerrar
        if ($caja->user_id !== auth()->id()) {
            return redirect()->route('cajas.index')
                ->with('error', 'Solo puedes cerrar tu propia caja.');
        }

        // Validar que esté abierta
        if ($caja->estaCerrada()) {
            return redirect()->route('cajas.index')
                ->with('error', 'Esta caja ya está cerrada.');
        }

        // Calcular monto esperado
        $caja->monto_final_esperado = $caja->calcularMontoFinalEsperado();
        $caja->save();

        return view('cajas.close', compact('caja'));
    }

    /**
     * Cerrar la caja
     */
    public function cerrar(Request $request, $id)
    {
        $request->validate([
            'monto_final_real' => 'required|numeric|min:0',
            'observaciones_cierre' => 'nullable|string|max:500',
        ], [
            'monto_final_real.required' => 'Debes ingresar el monto contado',
            'monto_final_real.numeric' => 'El monto debe ser un número',
        ]);

        $caja = Caja::findOrFail($id);

        // Validar que solo el dueño pueda cerrar
        if ($caja->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Solo puedes cerrar tu propia caja.'
            ], 403);
        }

        // Validar que esté abierta
        if ($caja->estaCerrada()) {
            return response()->json([
                'success' => false,
                'message' => 'Esta caja ya está cerrada.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Calcular diferencia
            $caja->monto_final_esperado = $caja->calcularMontoFinalEsperado();
            $caja->monto_final_real = $request->monto_final_real;
            $caja->diferencia = $caja->calcularDiferencia();
            $caja->fecha_cierre = now();
            $caja->estado = 'cerrada';
            $caja->user_cierre = auth()->id();
            $caja->observaciones_cierre = $request->observaciones_cierre;
            $caja->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Caja cerrada exitosamente',
                'diferencia' => $caja->diferencia,
                'redirect' => route('cajas.show', $caja->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar la caja: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registrar un movimiento manual (gasto, retiro, depósito)
     */
    public function registrarMovimiento(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'concepto' => 'required|in:gasto,retiro,deposito,ajuste',
            'monto' => 'required|numeric|min:0.01',
            'metodo_pago_id' => 'nullable|exists:payment_methods,id',
            'descripcion' => 'required|string|max:500',
            'comprobante' => 'nullable|string|max:255',
        ]);

        $caja = Caja::findOrFail($id);

        // Validar que esté abierta
        if ($caja->estaCerrada()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes registrar movimientos en una caja cerrada.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Crear el movimiento
            $movimiento = CajaMovimiento::create([
                'caja_id' => $caja->id,
                'tipo' => $request->tipo,
                'concepto' => $request->concepto,
                'monto' => $request->monto,
                'metodo_pago_id' => $request->metodo_pago_id,
                'descripcion' => $request->descripcion,
                'comprobante' => $request->comprobante,
                'user_id' => auth()->id(),
            ]);

            // Actualizar totales de la caja
            switch ($request->concepto) {
                case 'gasto':
                    $caja->monto_gastos += $request->monto;
                    break;
                case 'retiro':
                    $caja->monto_retiros += $request->monto;
                    break;
                case 'deposito':
                    $caja->monto_depositos += $request->monto;
                    break;
            }

            $caja->monto_final_esperado = $caja->calcularMontoFinalEsperado();
            $caja->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Movimiento registrado exitosamente',
                'movimiento' => $movimiento->load('metodoPago', 'usuario')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el movimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar PDF del reporte de caja
     */
    public function reportePDF($id)
    {
        $caja = Caja::with(['usuario', 'tienda', 'usuarioCierre', 'movimientos.metodoPago', 'movimientos.usuario'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('cajas.pdf', compact('caja'));
        
        return $pdf->stream('reporte-caja-' . $caja->codigo . '.pdf');
    }

    /**
     * Exportar listado de cajas a Excel
     */
    public function exportarExcel()
    {
        $cajas = Caja::with(['usuario', 'tienda', 'usuarioCierre'])
            ->orderBy('fecha_apertura', 'desc')
            ->get();

        return Excel::download(
            new CajasExport($cajas),
            'listado-cajas-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Filtrar cajas por fecha
     */
    public function filtrar(Request $request)
    {
        $query = Caja::with(['usuario', 'tienda']);

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_apertura', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_apertura', '<=', $request->fecha_hasta);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $cajas = $query->orderBy('fecha_apertura', 'desc')->get();

        return response()->json($cajas);
    }
}
