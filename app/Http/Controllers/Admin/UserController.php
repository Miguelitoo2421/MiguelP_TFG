<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        // Sólo permite admin
        $this->middleware(['auth','role:admin']);
    }

    // 1. Mostrar listado de usuarios con sus roles.
    public function index()
    {
        $users = User::with('roles')->paginate(20);
        // Sólo nombres de roles
        $roles = Role::pluck('name');

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
            'role'     => ['required','string','exists:roles,name'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'remember_token' => Str::random(10),
        ]);

        $user->assignRole($data['role']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Usuario {$user->name} creado.");
    }

    public function create()
    {
        $roles = Role::pluck('name');
        return view('admin.users.create', compact('roles'));
    }

    //2. Actualizar nombre, email y 1 único rol.
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'   => ['required','string','max:255'],
            'email'  => ['required','email','max:255',"unique:users,email,{$user->id}"],
            'roles'  => ['required','array','size:1'],
            'roles.*'=> ['string','exists:roles,name'],
        ]);

        // Actualizamos name/email
        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        // Sincronizamos el único rol
        $user->syncRoles($data['roles']);

        return back()->with('success', "Datos de {$user->name} actualizados.");
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', "Usuario {$user->name} eliminado.");
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name');
        return view('admin.users.edit', compact('user','roles'));
    }
}
