<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function index()
    {
        $users = User::with('roles')->paginate(20);
        $roles = Role::pluck('name','id');
        return view('admin.users.index', compact('users','roles'));
    }

    public function updateRoles(Request $request, User $user)
    {
        $request->validate([
            'roles'   => ['required','array'],
            'roles.*' => ['string','exists:roles,name'],
        ]);

        $user->syncRoles($request->input('roles'));

        return redirect()->route('admin.users.index')
                         ->with('success', "Roles de {$user->name} actualizados.");
    }
}
