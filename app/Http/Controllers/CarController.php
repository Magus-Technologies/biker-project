<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Drive;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use COM;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::with('driver')->where('status', 1)->get();
        $brands = \App\Models\BrandMoto::where('status', 1)->get();
        return view('car.index', compact('cars', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $marca = $request->query('marca', null);
        return view('car.datos-vehiculo', compact('marca'));
    }

    public function searchBuscarVehiculo(Request $request)
    {
        try {
            $nro_motor = $request->nro_motor;
            $driver = Drive::where('nro_motor', $nro_motor)->select('id', 'nombres', 'apellido_paterno', 'apellido_materno')->first();
            if ($driver) {
                $car = Car::where('drives_id', $driver->id)->where('status', 1)->get();
                if ($car) {
                    return response()->json([
                        'car' => $car,
                        'drive' => $driver
                    ]);
                } else {
                    return response()->json(['error' => 'No esta registrado el cliente con el numero de motor ingresado.']);
                }
            } else {
                return response()->json([
                    'error' => 'No esta registrado el cliente con el numero de motor ingresado.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function generateCode()
    {
        $lastCodigo = Car::max('codigo') ?? '0000000';
        $nextCodigo = intval($lastCodigo) + 1;
        return str_pad($nextCodigo, 7, '0', STR_PAD_LEFT);
    }

    public function searchBuscarDriver(Request $request)
    {
        try {
            $nro_motor = $request->nro_motor;
            $drive = Drive::where('nro_motor', $nro_motor)->select('id', 'nombres', 'apellido_paterno', 'apellido_materno')->first();
            if ($drive) {
                return response()->json(['drive' => $drive]);
            } else {
                return response()->json(['error' => 'El número de motor no se encuentra registrado.']);
            }
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Mensajes personalizados de validación
        $messages = [
            'marca.required' => 'La marca es obligatoria.',
            'modelo.required' => 'El modelo es obligatorio.',
            'n_placa.unique' => 'La placa ya está registrada.',
            'nro_chasis.required' => 'El numero de chasis es obligatorio.',
            // 'nro_motor.unique' => 'El numero de motor ya esta registrado.',
            'drive_id.required' => 'El numero de documento es obligatorio.',
        ];
        try {
            $request->validate([
                'marca' => 'required|string',
                'modelo' => 'required|string',
                'n_placa' => 'nullable|string|unique:cars,placa',
                // 'nro_motor' => 'unique:cars,nro_motor',
                'drive_id' => 'required|string',
                'nro_chasis' => 'required|string'
            ], $messages);
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        try {
            $car = Car::create([
                'codigo' => $this->generateCode(),
                'placa' => $request->n_placa,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'anio' => $request->anio,
                'condicion' => $request->tipo_condicion,
                'nro_chasis' => $request->nro_chasis,
                'fecha_soat' => $request->fecha_soat,
                'fecha_seguro' => $request->fecha_seguro,
                'color' => $request->color,
                'lugar_provisional' => $request->lugar_provisional,
                'user_register' => auth()->user()->id,
                'drives_id' => $request->drive_id
            ]);
            if ($car->save()) {
                return response()->json([
                    'success' => true,
                    'message' => '¡El vehiculo con la placa ' . $car->placa . ' ha sido registrado con éxito!',
                ]);
            } else {
                return response()->json(['error' => 'No se pudo registrar el vehiculo']);
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $car = Car::findOrFail($id);
            return view('car.edit', compact('car'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        return view('car.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Mensajes personalizados de validación
        $messages = [
            'marca.required' => 'La marca es obligatoria.',
            'modelo.required' => 'El modelo es obligatorio.',
            'n_placa.unique' => 'La placa ya está registrada.',
            'nro_chasis.required' => 'El número de chasis es obligatorio.',
            'drive_id.required' => 'El número de documento es obligatorio.',
        ];

        try {
            $request->validate([
                'marca' => 'required|string',
                'modelo' => 'required|string',
                'n_placa' => 'nullable|string|unique:cars,placa,' . $id,
                'drive_id' => 'required|string',
                'nro_chasis' => 'required|string'
            ], $messages);
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        try {
            $car = Car::findOrFail($id);
            $car->update([
                'placa' => $request->n_placa,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'anio' => $request->anio,
                'condicion' => $request->tipo_condicion,
                'nro_chasis' => $request->nro_chasis,
                'fecha_soat' => $request->fecha_soat,
                'fecha_seguro' => $request->fecha_seguro,
                'color' => $request->color,
                'drives_id' => $request->drive_id
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡El vehículo con la placa ' . $car->placa . ' ha sido actualizado con éxito!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->status = 0;
            $car->save();
            return redirect()->route('cars.index')->with('success', 'Vehiculo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('cars.index')->with('error', 'Error al eliminar el Vehiculo.');
        }
    }

    /**
     * Mostrar motos por marca usando slug
     */
    public function showByMarcaSlug($slug)
    {
        $brand = \App\Models\BrandMoto::where('slug', $slug)->firstOrFail();
        $marca = $brand->name;

        $cars = Car::with('driver')
            ->where('status', 1)
            ->where('marca', $marca)
            ->get();

        return view('car.marca', compact('cars', 'marca'));
    }

    /**
     * Guardar nueva marca de moto
     */
    public function storeBrand(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'color_from' => 'required|string|max:7',
                'color_to' => 'required|string|max:7'
            ]);

            $slug = \Str::slug($validated['name']);

            $brand = \App\Models\BrandMoto::create([
                'name' => strtoupper($validated['name']),
                'slug' => $slug,
                'color_from' => $validated['color_from'],
                'color_to' => $validated['color_to'],
                'status' => 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Marca creada correctamente',
                'brand' => $brand
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar marca de moto
     */
    public function updateBrand(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'color_from' => 'required|string|max:7',
                'color_to' => 'required|string|max:7'
            ]);

            $brand = \App\Models\BrandMoto::findOrFail($id);

            $brand->update([
                'name' => strtoupper($validated['name']),
                'slug' => \Str::slug($validated['name']),
                'color_from' => $validated['color_from'],
                'color_to' => $validated['color_to']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Marca actualizada correctamente',
                'brand' => $brand
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desactivar/Activar marca de moto
     */
    public function toggleBrand($id)
    {
        try {
            $brand = \App\Models\BrandMoto::findOrFail($id);
            $brand->status = !$brand->status;
            $brand->save();

            return response()->json([
                'success' => true,
                'message' => $brand->status ? 'Marca activada correctamente' : 'Marca desactivada correctamente',
                'brand' => $brand
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
