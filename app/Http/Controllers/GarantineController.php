<?php

namespace App\Http\Controllers;

use App\Models\Garantine;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class GarantineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $garantias = Garantine::where('status', 1)->get();
        return view('garantine.index', compact('garantias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('garantine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'n_documento.required' => 'El número de documento es obligatorio.',
            'datos_cliente.required' => 'Los datos del cliente son obligatorios.',
            'nro_motor.required' => 'El número de motor es obligatorio.',
            'nro_motor.unique' => 'Esta moto ya tiene una garantía registrada. El número de motor ya fue vendido anteriormente.',
            'boleta_dua.*.mimes' => 'Solo se permiten archivos PDF para la boleta y DUA.',
        ];
        try {
            $request->validate([
                'n_documento' => 'required|string',
                'datos_cliente' => 'required|string',
                'nro_motor' => 'required|unique:garantines,nro_motor,NULL,id,status,1',
                'boleta_dua.*' => 'nullable|mimes:pdf',
            ], $messages);
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        // Manejo de PDFs
        $pdfPaths = [];
        if ($request->hasFile('boleta_dua')) {
            foreach ($request->file('boleta_dua') as $file) {
                $filename = uniqid('boleta_dua_') . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('garantias/boleta_dua', $filename, 'public');
                $pdfPaths[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_path' => $path,
                    'url' => \Storage::disk('public')->url($path),
                ];
            }
        }

        try {
            $garantine = Garantine::create([
                'codigo' => $this->generateCode(),
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'anio' => $request->anio,
                'nro_chasis' => $request->nro_chasis,
                'nro_motor' => $request->nro_motor,
                'color' => $request->color,
                'user_register' => auth()->user()->id,
                'nro_documento' => $request->n_documento,
                'nombres_apellidos' => $request->datos_cliente,
                'celular' => $request->celular,
                'kilometrajes' => $request->kilometrajes,
                'boleta_dua_pdfs' => json_encode($pdfPaths),
                'lugar_destino_final' => $request->lugar_destino_final,
            ]);
            if ($garantine) {
                return response()->json([
                    'success' => true,
                    'message' => 'La Garantia ha sido registrada con exito!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al registrar la Garantia',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function generateCode()
    {
        $lastCodigo = Garantine::max('codigo') ?? '0000000';
        $nextCodigo = intval($lastCodigo) + 1;
        return str_pad($nextCodigo, 7, '0', STR_PAD_LEFT);
    }

    /**
     * Buscar moto por número de motor o chasis
     */
    public function buscarMoto(Request $request)
    {
        try {
            $nro_motor = $request->query('nro_motor');
            $nro_chasis = $request->query('nro_chasis');

            if (!$nro_motor && !$nro_chasis) {
                return response()->json([
                    'error' => 'Debe proporcionar un número de motor o chasis para buscar'
                ], 400);
            }

            $moto = null;

            if ($nro_motor) {
                // Buscar por número de motor en la tabla motos
                $moto = \App\Models\Moto::where('nro_motor', $nro_motor)->first();
            } elseif ($nro_chasis) {
                // Buscar por número de chasis en la tabla motos
                $moto = \App\Models\Moto::where('nro_chasis', $nro_chasis)->first();
            }

            if (!$moto) {
                $mensaje = $nro_motor 
                    ? "No se encontró ninguna moto registrada con el N° de Motor: {$nro_motor}" 
                    : "No se encontró ninguna moto registrada con el N° de Chasis: {$nro_chasis}";
                
                return response()->json([
                    'error' => $mensaje
                ], 404);
            }

            // Preparar datos de la moto
            $motoData = [
                'id' => $moto->id,
                'marca' => $moto->marca,
                'modelo' => $moto->modelo,
                'anio' => $moto->anio,
                'color' => $moto->color,
                'nro_chasis' => $moto->nro_chasis,
                'nro_motor' => $moto->nro_motor,
                'lugar_provisional' => $moto->lugar_provisional,
            ];

            return response()->json([
                'success' => true,
                'moto' => $motoData
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en buscarMoto: ' . $e->getMessage());
            return response()->json([
                'error' => 'Ocurrió un error al buscar la moto. Por favor, intente nuevamente.'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $garantine = Garantine::findOrFail($id);
            return view('garantine.edit', compact('garantine'));
        } catch (\Throwable $th) {
            return redirect()->route('garantines.index')->with('error', 'Garantía no encontrada');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'n_documento.required' => 'El número de documento es obligatorio.',
            'datos_cliente.required' => 'Los datos del cliente son obligatorios.',
            'nro_motor.required' => 'El número de motor es obligatorio.',
            'nro_motor.unique' => 'Esta moto ya tiene una garantía registrada activa.',
            'boleta_dua.*.mimes' => 'Solo se permiten archivos PDF para la boleta y DUA.',
        ];

        try {
            $request->validate([
                'n_documento' => 'required|string',
                'datos_cliente' => 'required|string',
                'nro_motor' => 'required|unique:garantines,nro_motor,' . $id . ',id,status,1',
                'boleta_dua.*' => 'nullable|mimes:pdf',
            ], $messages);
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        try {
            $garantine = Garantine::findOrFail($id);

            // Manejo de PDFs
            $pdfPaths = json_decode($garantine->boleta_dua_pdfs, true) ?? [];

            if ($request->hasFile('boleta_dua')) {
                foreach ($request->file('boleta_dua') as $file) {
                    $filename = uniqid('boleta_dua_') . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('garantias/boleta_dua', $filename, 'public');
                    $pdfPaths[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'stored_path' => $path,
                        'url' => \Storage::disk('public')->url($path),
                    ];
                }
            }

            $garantine->update([
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'anio' => $request->anio,
                'nro_chasis' => $request->nro_chasis,
                'nro_motor' => $request->nro_motor,
                'color' => $request->color,
                'nro_documento' => $request->n_documento,
                'nombres_apellidos' => $request->datos_cliente,
                'celular' => $request->celular,
                'kilometrajes' => $request->kilometrajes,
                'boleta_dua_pdfs' => json_encode($pdfPaths),
                'lugar_destino_final' => $request->lugar_destino_final,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'La Garantía ha sido actualizada con éxito!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la garantía: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $garantine = Garantine::findOrFail($id);
            $garantine->status = 0;
            $garantine->save();

            return redirect()->route('garantines.index')->with('success', 'Garantía desactivada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('garantines.index')->with('error', 'Error al desactivar la garantía');
        }
    }
}
