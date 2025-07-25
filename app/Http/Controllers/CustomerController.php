<?php

namespace App\Http\Controllers;

use App\Models\Drive;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drives = Drive::where('status', 1)->get();
        return view('driver.index', compact('drives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();
        return view('driver.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.unique' => 'El número de documento ya está registrado.',
            'telefono.required' => 'El número de teléfono es obligatorio.',
            'nro_chasis.required' => 'El número de chasis es obligatorio.',
            'nro_chasis.unique' => 'El número de chasis ya está registrado.',
            'nro_placa.required' => 'El número de placa es obligatorio.',
            'nro_placa.unique' => 'El número de placa ya está registrado.',
            'nro_motor.unique' => 'El número de motor ya está registrado.',
        ];
        
        try {
            $request->validate([
                'nro_documento' => 'required|unique:drives,nro_documento',
                'telefono' => 'required',
                'nro_chasis' => 'required|unique:drives,nro_chasis',
                'nro_placa' => 'required|unique:drives,nro_placa',
                'nro_motor' => 'nullable|unique:drives,nro_motor',
            ], $messages);
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
        try {
            $driver = Drive::create([
                'codigo' => $this->generateCode(),
                'tipo_doc' => $request->tipo_doc,
                'nro_documento' => $request->nro_documento,
                'nombres' => $request->nombres,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'nro_motor' => $request->nro_motor,
                'nro_chasis' => $request->nro_chasis,
                'nro_placa' => $request->nro_placa,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'departamento' => $request->departamento,
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'direccion_detalle' => $request->direccion_detalle,
                'nombres_contacto' => $request->nombres_contacto,
                'telefono_contacto' => $request->telefono_contacto,
                'parentesco_contacto' => $request->parentesco_contacto,
                'photo' => $request->photo,
                'user_register' => auth()->user()->id,
            ]);
            
            if ($driver) {
                return response()->json([
                    'success' => true,
                    'message' => '¡El conductor ' . $driver->nombres . ' ha sido registrado con éxito!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al registrar el conductor',
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
        $lastCodigo = Drive::max('codigo') ?? '0000000';
        $nextCodigo = intval($lastCodigo) + 1;
        return str_pad($nextCodigo, 7, '0', STR_PAD_LEFT);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = Drive::with(['userRegistered', 'userUpdated'])->find($id);
        
        if (!$driver) {
            return redirect()->route('drives.index')->with('error', 'Conductor no encontrado');
        }
        
        return view('driver.show', compact('driver'));
    }

    /**
     * Get driver details for modal (AJAX)
     */
    public function getDetails(string $id)
    {
        try {
            $driver = Drive::with(['userRegistered', 'userUpdated'])->find($id);
            
            if (!$driver) {
                return response()->json([
                    'success' => false,
                    'message' => 'Conductor no encontrado'
                ], 404);
            }
            
            $html = view('driver.partials.driver-details', compact('driver'))->render();
            
            return response()->json([
                'success' => true,
                'html' => $html
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los detalles: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $driver = Drive::find($id);
        if (!$driver) {
            return redirect()->route('drives.index');
        }
        $regions = Region::all();
        return view('driver.edit', compact('driver', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.unique' => 'El número de documento ya está registrado.',
            'telefono.required' => 'El número de teléfono es obligatorio.',
            'nro_chasis.required' => 'El número de chasis es obligatorio.',
            'nro_chasis.unique' => 'El número de chasis ya está registrado.',
            'nro_placa.required' => 'El número de placa es obligatorio.',
            'nro_placa.unique' => 'El número de placa ya está registrado.',
            'nro_motor.unique' => 'El número de motor ya está registrado.',
        ];
        
        try {
            $request->validate([
                'nro_documento' => [
                    'required',
                    Rule::unique('drives', 'nro_documento')->ignore($id),
                ],
                'telefono' => 'required',
                'nro_chasis' => [
                    'required',
                    Rule::unique('drives', 'nro_chasis')->ignore($id),
                ],
                'nro_placa' => [
                    'required',
                    Rule::unique('drives', 'nro_placa')->ignore($id),
                ],
                'nro_motor' => [
                    'nullable',
                    Rule::unique('drives', 'nro_motor')->ignore($id),
                ],
            ], $messages);
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
        $driver = Drive::find($id);

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Conductor no encontrado'
            ], 404);
        }
        
        try {
            $driver->update($request->except(['_method', '_token']));

            return response()->json([
                'success' => true,
                'message' => '¡El conductor ' . $driver->nombres . ' ha sido actualizado con éxito!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el conductor: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}