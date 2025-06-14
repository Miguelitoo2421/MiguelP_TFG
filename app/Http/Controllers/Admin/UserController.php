<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Actor;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        // Solo admin
        $this->middleware(['auth','role:admin']);
    }

    /**
     * 1. Listado de usuarios con su único rol
     */
    public function index()
    {
        $users = User::with('roles')->paginate(20);
        $roles = Role::pluck('name');

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * 2. Almacenar nuevo usuario (un único rol)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
            'role'     => ['required','string','exists:roles,name'],
        ]);

        $user = User::create([
            'name'           => $data['name'],
            'email'          => $data['email'],
            'password'       => Hash::make($data['password']),
            'remember_token' => Str::random(10),
        ]);

        // Asignamos un único rol
        $user->assignRole($data['role']);

        // Si el rol es 'user', creamos automáticamente un actor
        if ($data['role'] === 'user') {
            // Aseguramos que existe el directorio
            Storage::disk('public')->makeDirectory('actors');
            
            // Copiamos la imagen por defecto
            $defaultImage = public_path('images/default_user_avatar.svg');
            $defaultImagePath = 'actors/default_user_avatar.svg';
            
            if (File::exists($defaultImage)) {
                Storage::disk('public')->put($defaultImagePath, File::get($defaultImage));
            }

            Actor::create([
                'first_name' => $user->name,
                'last_name'  => '',
                'email'      => $user->email,
                'role'       => 'user',
                'active'     => true,
                'image'      => $defaultImagePath,
            ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Usuario {$user->name} creado.");
    }

    /**
     * 3. Actualizar usuario (nombre, email y único rol)
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:255'],
            'email' => ['required','email','max:255',"unique:users,email,{$user->id}"],
            'role'  => ['required','string','exists:roles,name'],
        ]);

        // Actualizamos name y email
        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        // Sincronizamos el rol (reemplaza el anterior)
        $user->syncRoles($data['role']);

        return back()->with('success', "Datos de {$user->name} actualizados.");
    }

    /**
     * 4. Borrar usuario
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('error', "No se puede eliminar al usuario administrador: {$user->name}.");
        }

        $user->delete();

        return back()->with('success', "Usuario {$user->name} eliminado.");
    }
}
