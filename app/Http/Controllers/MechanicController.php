<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class MechanicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mechanics = User::whereHas('roles', function ($query) {
            $query->where('name', 'mecanico');
        })->get();
        return view('mechanic.index', compact('mechanics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function MecanicosDisponibles()
    {
        $mechanics = User::where('status_mechanic', 1)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'mecanico');
            })
            ->whereDoesntHave('services', function ($query) {
                $query->where('status_service', 2); // Si tiene al menos un servicio con status_service = 2, lo excluye
            })
            ->get();

        return response()->json($mechanics);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Toggle mechanic status (disponible/no disponible)
     */
    public function toggleStatus(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Verificar que el usuario sea un mecánico
            if (!$user->hasRole('mecanico')) {
                return response()->json([
                    'success' => false,
                    'message' => 'El usuario no es un mecánico'
                ], 400);
            }

            // Cambiar el estado
            $user->status_mechanic = $request->status;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => $user->status_mechanic == 1
                    ? 'Mecánico activado correctamente'
                    : 'Mecánico desactivado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado del mecánico'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Verificar que el usuario sea un mecánico
            if (!$user->hasRole('mecanico')) {
                return redirect()->route('mechanics.index')->with('error', 'El usuario no es un mecánico');
            }

            // Desactivar permanentemente
            $user->status_mechanic = 0;
            $user->save();

            return redirect()->route('mechanics.index')->with('success', 'Mecánico desactivado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('mechanics.index')->with('error', 'Error al desactivar el mecánico');
        }
    }
}
