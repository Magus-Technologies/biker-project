<?php
// app/Http/Controllers/TiendaController.php

namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TiendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-trabajadores');
        $this->middleware('permission:agregar-trabajadores', ['only' => ['store']]);
    }

    public function index()
    {
        $tiendas = Tienda::with(['usuarioRegistro', 'usuarioActualizacion'])
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        return response()->json([
            'success' => true,
            'tiendas' => $tiendas
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:tiendas,nombre',
            ], [
                'nombre.required' => 'El nombre de la tienda es obligatorio.',
                'nombre.unique' => 'Ya existe una tienda con este nombre.',
                'nombre.max' => 'El nombre no puede exceder 255 caracteres.'
            ]);

            $tienda = Tienda::create([
                'nombre' => $request->nombre,
                'user_register' => auth()->id(),
                'status' => 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tienda creada exitosamente.',
                'tienda' => $tienda->load('usuarioRegistro')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la tienda: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTiendasActivas(): JsonResponse
    {
        $tiendas = Tienda::activas()
                        ->select('id', 'nombre')
                        ->orderBy('nombre')
                        ->get();

        return response()->json([
            'success' => true,
            'tiendas' => $tiendas
        ]);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $tienda = Tienda::findOrFail($id);
            
            // Verificar si tiene usuarios asignados
            if ($tienda->usuarios()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la tienda porque tiene usuarios asignados.'
                ], 400);
            }

            $tienda->status = !$tienda->status;
            $tienda->user_update = auth()->id();
            $tienda->save();

            $message = $tienda->status ? 'Tienda activada exitosamente.' : 'Tienda desactivada exitosamente.';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }
}