<?php

namespace App\Http\Controllers;

use App\Models\VentaPendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaPendienteController extends Controller
{
    /**
     * Guardar venta pendiente (autoguardado)
     */
    public function guardar(Request $request)
    {
        try {
            $request->validate([
                'tipo' => 'required|in:create,bulk_create',
                'datos' => 'required|array',
            ]);

            $userId = Auth::id();
            $tipo = $request->tipo;
            $datos = $request->datos;

            $ventaPendiente = VentaPendiente::guardarVentaPendiente($userId, $tipo, $datos);

            return response()->json([
                'success' => true,
                'message' => 'Venta pendiente guardada',
                'id' => $ventaPendiente->id,
                'fecha_guardado' => $ventaPendiente->fecha_guardado->format('d/m/Y H:i:s'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar venta pendiente',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener venta pendiente por tipo
     */
    public function obtener(Request $request)
    {
        try {
            $request->validate([
                'tipo' => 'required|in:create,bulk_create',
            ]);

            $userId = Auth::id();
            $tipo = $request->tipo;

            $ventaPendiente = VentaPendiente::obtenerPorUsuarioYTipo($userId, $tipo);

            if (!$ventaPendiente) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay venta pendiente',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'venta_pendiente' => [
                    'id' => $ventaPendiente->id,
                    'datos' => $ventaPendiente->datos,
                    'fecha_guardado' => $ventaPendiente->fecha_guardado->format('d/m/Y H:i:s'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener venta pendiente',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Limpiar venta pendiente (después de guardar exitosamente)
     */
    public function limpiar(Request $request)
    {
        try {
            $request->validate([
                'tipo' => 'required|in:create,bulk_create',
            ]);

            $userId = Auth::id();
            $tipo = $request->tipo;

            VentaPendiente::limpiarVentaPendiente($userId, $tipo);

            return response()->json([
                'success' => true,
                'message' => 'Venta pendiente eliminada',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al limpiar venta pendiente',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verificar si existe venta pendiente
     */
    public function verificar(Request $request)
    {
        try {
            $request->validate([
                'tipo' => 'required|in:create,bulk_create',
            ]);

            $userId = Auth::id();
            $tipo = $request->tipo;

            $ventaPendiente = VentaPendiente::obtenerPorUsuarioYTipo($userId, $tipo);

            return response()->json([
                'success' => true,
                'existe' => $ventaPendiente !== null,
                'fecha_guardado' => $ventaPendiente ? $ventaPendiente->fecha_guardado->format('d/m/Y H:i:s') : null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar venta pendiente',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
