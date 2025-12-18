<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use App\Models\BrandMoto;
use Illuminate\Http\Request;

class MotoController extends Controller
{
    /**
     * Mostrar grid de marcas
     */
    public function index()
    {
        $brands = BrandMoto::where('status', 1)->orderBy('name')->get();
        $motos = Moto::where('status', 1)->get();
        return view('moto.index', compact('brands', 'motos'));
    }

    /**
     * Mostrar motos por marca
     */
    public function showByMarca($slug)
    {
        $brand = BrandMoto::where('slug', $slug)->firstOrFail();
        $marca = $brand->name;

        $motos = Moto::where('status', 1)
            ->where('marca', $marca)
            ->get()
            ->map(function($moto) {
                // Verificar si tiene garantía activa
                $garantia = \App\Models\Garantine::where('nro_motor', $moto->nro_motor)
                    ->where('status', 1)
                    ->first();
                $moto->esta_vendida = $garantia !== null;
                return $moto;
            });

        return view('moto.marca', compact('motos', 'marca', 'brand'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request)
    {
        $marca = $request->query('marca');
        return view('moto.create', compact('marca'));
    }

    /**
     * Guardar nueva moto
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nro_motor' => 'required|string|max:100',
                'nro_chasis' => 'nullable|string|max:100',
                'marca' => 'required|string|max:50',
                'modelo' => 'required|string|max:50',
                'anio' => 'nullable|string|max:10',
                'color' => 'nullable|string|max:50',
                'lugar_provisional' => 'nullable|string|max:255',
            ]);

            $validated['codigo'] = $this->generateCode();

            $moto = Moto::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Moto registrada exitosamente',
                'moto' => $moto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la moto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $moto = Moto::findOrFail($id);
        return view('moto.edit', compact('moto'));
    }

    /**
     * Actualizar moto
     */
    public function update(Request $request, $id)
    {
        try {
            $moto = Moto::findOrFail($id);

            $validated = $request->validate([
                'nro_motor' => 'required|string|max:100',
                'nro_chasis' => 'nullable|string|max:100',
                'marca' => 'required|string|max:50',
                'modelo' => 'required|string|max:50',
                'anio' => 'nullable|string|max:10',
                'color' => 'nullable|string|max:50',
                'lugar_provisional' => 'nullable|string|max:255',
            ]);

            $moto->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Moto actualizada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la moto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar (desactivar) moto
     */
    public function destroy($id)
    {
        try {
            $moto = Moto::findOrFail($id);
            $moto->status = 0;
            $moto->save();

            return redirect()->back()->with('success', 'Moto desactivada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al desactivar la moto');
        }
    }

    /**
     * Generar código único
     */
    private function generateCode()
    {
        $lastCodigo = Moto::max('codigo') ?? '0000000';
        $nextCodigo = intval($lastCodigo) + 1;
        return str_pad($nextCodigo, 7, '0', STR_PAD_LEFT);
    }
}
