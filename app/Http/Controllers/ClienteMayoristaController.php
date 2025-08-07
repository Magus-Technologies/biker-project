<?php
// app/Http/Controllers/ClienteMayoristaController.php

namespace App\Http\Controllers;

use App\Models\ClienteMayorista;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class ClienteMayoristaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = ClienteMayorista::where('status', 1)->paginate(10);
        return view('clientes-mayoristas.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();
        return view('clientes-mayoristas.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.unique' => 'El número de documento ya está registrado.',
            'nombres.required' => 'Los nombres son obligatorios.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'nombre_negocio.required' => 'El nombre del negocio es obligatorio.',
            'telefono.required' => 'El número de teléfono es obligatorio.',
            'departamento.required' => 'El departamento es obligatorio.',
            'provincia.required' => 'La provincia es obligatoria.',
            'distrito.required' => 'El distrito es obligatorio.',
            'direccion_detalle.required' => 'La dirección detallada es obligatoria.',
        ];
        
        try {
            $request->validate([
                'nro_documento' => 'required|unique:clientes_mayoristas,nro_documento',
                'nombres' => 'required|string|max:255',
                'apellido_paterno' => 'required|string|max:255',
                'apellido_materno' => 'required|string|max:255',
                'nombre_negocio' => 'required|string|max:255',
                'telefono' => 'required|string|max:20',
                'departamento' => 'required|string|max:255',
                'provincia' => 'required|string|max:255',
                'distrito' => 'required|string|max:255',
                'direccion_detalle' => 'required|string|max:500',
                'correo' => 'nullable|email|max:255',
            ], $messages);
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
        try {
            $cliente = ClienteMayorista::create([
                'codigo' => $this->generarCodigo(),
                'tipo_doc' => $request->tipo_doc,
                'nro_documento' => $request->nro_documento,
                'nombres' => $request->nombres,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'nombre_negocio' => $request->nombre_negocio,
                'tienda' => $request->tienda,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'departamento' => $request->departamento,
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'direccion_detalle' => $request->direccion_detalle,
                'nombres_contacto' => $request->nombres_contacto,
                'telefono_contacto' => $request->telefono_contacto,
                'parentesco_contacto' => $request->parentesco_contacto,
                'foto' => $request->foto,
                'user_register' => auth()->user()->id,
            ]);
            
            if ($cliente) {
                return response()->json([
                    'success' => true,
                    'message' => '¡El cliente mayorista ' . $cliente->nombres . ' ha sido registrado con éxito!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al registrar el cliente mayorista',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    
    public function generarCodigo()
    {
        $ultimoCodigo = ClienteMayorista::max('codigo') ?? 'CM0000000';
        $numeroSiguiente = intval(substr($ultimoCodigo, 2)) + 1;
        return 'CM' . str_pad($numeroSiguiente, 7, '0', STR_PAD_LEFT);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = ClienteMayorista::with(['usuarioRegistro', 'usuarioActualizacion'])->find($id);
        
        if (!$cliente) {
            return redirect()->route('clientes-mayoristas.index')->with('error', 'Cliente mayorista no encontrado');
        }
        
        return view('clientes-mayoristas.show', compact('cliente'));
    }

    /**
     * Get client details for modal (AJAX)
     */
 public function obtenerDetalles(string $id)
{
    \Log::info('Método obtenerDetalles llamado con ID: ' . $id);
    
    try {
        $cliente = ClienteMayorista::with(['usuarioRegistro', 'usuarioActualizacion'])->find($id);
        
        \Log::info('Cliente encontrado: ' . ($cliente ? 'Sí' : 'No'));
        
        if (!$cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente mayorista no encontrado'
            ], 404);
        }
        
        \Log::info('Intentando renderizar vista...');
        $html = view('clientes-mayoristas.partials.detalles-cliente', compact('cliente'))->render();
        \Log::info('Vista renderizada exitosamente');
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error en obtenerDetalles: ' . $e->getMessage());
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
        $cliente = ClienteMayorista::find($id);
        if (!$cliente) {
            return redirect()->route('clientes-mayoristas.index');
        }
        $regions = Region::all();
        return view('clientes-mayoristas.edit', compact('cliente', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.unique' => 'El número de documento ya está registrado.',
            'nombres.required' => 'Los nombres son obligatorios.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'nombre_negocio.required' => 'El nombre del negocio es obligatorio.',
            'telefono.required' => 'El número de teléfono es obligatorio.',
            'departamento.required' => 'El departamento es obligatorio.',
            'provincia.required' => 'La provincia es obligatoria.',
            'distrito.required' => 'El distrito es obligatorio.',
            'direccion_detalle.required' => 'La dirección detallada es obligatoria.',
        ];
        
        try {
            $request->validate([
                'nro_documento' => [
                    'required',
                    Rule::unique('clientes_mayoristas', 'nro_documento')->ignore($id),
                ],
                'nombres' => 'required|string|max:255',
                'apellido_paterno' => 'required|string|max:255',
                'apellido_materno' => 'required|string|max:255',
                'nombre_negocio' => 'required|string|max:255',
                'telefono' => 'required|string|max:20',
                'departamento' => 'required|string|max:255',
                'provincia' => 'required|string|max:255',
                'distrito' => 'required|string|max:255',
                'direccion_detalle' => 'required|string|max:500',
                'correo' => 'nullable|email|max:255',
            ], $messages);
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
        $cliente = ClienteMayorista::find($id);

        if (!$cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente mayorista no encontrado'
            ], 404);
        }
        
        try {
            $cliente->update(array_merge(
                $request->except(['_method', '_token']),
                [
                    'user_update' => auth()->user()->id,
                    'fecha_actualizacion' => now()
                ]
            ));

            return response()->json([
                'success' => true,
                'message' => '¡El cliente mayorista ' . $cliente->nombres . ' ha sido actualizado con éxito!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cliente mayorista: ' . $e->getMessage(),
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