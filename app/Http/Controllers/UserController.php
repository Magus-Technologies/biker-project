<?php
// Actualizar app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-trabajadores', ['only' => ['index']]);
        $this->middleware('permission:agregar-trabajadores', ['only' => ['create', 'store']]);
        $this->middleware('permission:actualizar-trabajadores', ['only' => ['update', 'edit']]);
        $this->middleware('permission:eliminar-trabajadores', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::with(['roles', 'tienda'])->get();
        return view('role-permission.workers.index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $tiendas = Tienda::activas()->select('id', 'nombre')->orderBy('nombre')->get();
        return view('role-permission.workers.create', [
            'roles' => $roles,
            'tiendas' => $tiendas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'dni' => 'required|string|unique:users,dni|size:8',
            'correo' => 'required|email|max:255|unique:users,correo',
            'tienda_id' => 'nullable|exists:tiendas,id'
        ], [
            // Mensajes personalizados para name
            'name.required' => 'El campo nombres es obligatorio.',
            'name.string' => 'El campo nombres debe ser texto.',
            'name.max' => 'El campo nombres no puede tener más de 255 caracteres.',
            
            // Mensajes personalizados para email
            'email.required' => 'El correo de usuario es obligatorio.',
            'email.email' => 'El correo de usuario debe ser una dirección válida.',
            'email.max' => 'El correo de usuario no puede tener más de 255 caracteres.',
            'email.unique' => 'Este correo de usuario ya está registrado en el sistema.',
            
            // Mensajes personalizados para password
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede tener más de 20 caracteres.',
            
            // Mensajes personalizados para roles
            'roles.required' => 'Debe seleccionar al menos un perfil.',
            
            // Mensajes personalizados para apellidos
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.string' => 'El campo apellidos debe ser texto.',
            'apellidos.max' => 'El campo apellidos no puede tener más de 255 caracteres.',
            
            // Mensajes personalizados para telefono
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.string' => 'El campo teléfono debe ser texto.',
            'telefono.max' => 'El campo teléfono no puede tener más de 255 caracteres.',
            
            // Mensajes personalizados para direccion
            'direccion.required' => 'El campo dirección es obligatorio.',
            'direccion.string' => 'El campo dirección debe ser texto.',
            'direccion.max' => 'El campo dirección no puede tener más de 255 caracteres.',
            
            // Mensajes personalizados para dni
            'dni.required' => 'El DNI es obligatorio.',
            'dni.string' => 'El DNI debe ser texto.',
            'dni.unique' => 'Este DNI ya está registrado en el sistema. Por favor verifique.',
            'dni.size' => 'El DNI debe tener exactamente 8 dígitos.',
            
            // Mensajes personalizados para correo
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'El correo electrónico debe ser una dirección válida.',
            'correo.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'correo.unique' => 'Este correo electrónico ya está registrado en el sistema.',
            
            // Mensajes personalizados para tienda_id
            'tienda_id.exists' => 'La tienda seleccionada no existe.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'dni' => $request->dni,
            'correo' => $request->correo,
            'tienda_id' => $request->tienda_id,
            'user_register' => auth()->user()->id,
            'codigo' => $this->generateCode(),
        ]);

        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'Trabajador creado con éxito');
    }

    public function generateCode()
    {
        $lastCodigo = User::max('codigo') ?? '0000000';
        $nextCodigo = intval($lastCodigo) + 1;
        return str_pad($nextCodigo, 7, '0', STR_PAD_LEFT);
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        $tiendas = Tienda::activas()->select('id', 'nombre')->orderBy('nombre')->get();
        
        return view('role-permission.workers.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'tiendas' => $tiendas
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'dni' => 'required|string|size:8|unique:users,dni,' . $user->id,
            'correo' => 'required|email|max:255|unique:users,correo,' . $user->id,
            'tienda_id' => 'nullable|exists:tiendas,id'
        ], [
            // Mensajes personalizados para name
            'name.required' => 'El campo nombres es obligatorio.',
            'name.string' => 'El campo nombres debe ser texto.',
            'name.max' => 'El campo nombres no puede tener más de 255 caracteres.',
            
            // Mensajes personalizados para password
            'password.string' => 'La contraseña debe ser texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede tener más de 20 caracteres.',
            
            // Mensajes personalizados para roles
            'roles.required' => 'Debe seleccionar al menos un perfil.',
            
            // Mensajes personalizados para apellidos
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.string' => 'El campo apellidos debe ser texto.',
            'apellidos.max' => 'El campo apellidos no puede tener más de 255 caracteres.',
            
            // Mensajes personalizados para telefono
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.string' => 'El campo teléfono debe ser texto.',
            'telefono.max' => 'El campo teléfono no puede tener más de 255 caracteres.',
            
            // Mensajes personalizados para direccion
            'direccion.required' => 'El campo dirección es obligatorio.',
            'direccion.string' => 'El campo dirección debe ser texto.',
            'direccion.max' => 'El campo dirección no puede tener más de 255 caracteres.',
            
            // Mensajes personalizados para dni
            'dni.required' => 'El DNI es obligatorio.',
            'dni.string' => 'El DNI debe ser texto.',
            'dni.unique' => 'Este DNI ya está registrado en el sistema. Por favor verifique.',
            'dni.size' => 'El DNI debe tener exactamente 8 dígitos.',
            
            // Mensajes personalizados para correo
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'El correo electrónico debe ser una dirección válida.',
            'correo.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'correo.unique' => 'Este correo electrónico ya está registrado en el sistema.',
            
            // Mensajes personalizados para tienda_id
            'tienda_id.exists' => 'La tienda seleccionada no existe.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'dni' => $request->dni,
            'correo' => $request->correo,
            'tienda_id' => $request->tienda_id,
            'user_update' => auth()->user()->id
        ];

        if (!empty($request->password)) {
            $data += [
                'password' => Hash::make($request->password),
            ];
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'Trabajador actualizado con éxito');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        $message = $user->status == 1
            ? 'El Trabajador ha sido activado con éxito.'
            : 'El Trabajador ha sido desactivado con éxito.';

        return redirect('/users')->with('status', $message);
    }
}