<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // ->middleware('role:admin'); // si quieres restringir a admins
    }

    public function index()
    {
        $actors = Actor::orderBy('last_name')->paginate(15);
        return view('actors.index', compact('actors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required','string','max:50'],
            'last_name'  => ['required','string','max:50'],
            'phone'      => ['nullable','string','max:15'],
            'email'      => ['nullable','email','max:30'],
            'city'       => ['nullable','string','max:30'],
            'active'     => ['required','boolean'],
            'notes'      => ['nullable','string','max:255'],
            'image'      => ['nullable','image','max:2048'],
        ]);

        // Checkbox
        $data['has_car']   = $request->has('has_car');
        $data['can_drive'] = $request->has('can_drive');

        // Almacenar imagen en disco 'public'
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('actors', 'public');
        }

        Actor::create($data);

        return redirect()->route('actors.index')
                         ->with('success','Actor creado correctamente.');
    }

    public function update(Request $request, Actor $actor)
    {
        $data = $request->validate([
            'first_name' => ['required','string','max:50'],
            'last_name'  => ['required','string','max:50'],
            'phone'      => ['nullable','string','max:15'],
            'email'      => ['nullable','email','max:30'],
            'city'       => ['nullable','string','max:30'],
            'active'     => ['required','boolean'],
            'notes'      => ['nullable','string','max:255'],
            'image'      => ['nullable','image','max:2048'],
        ]);

        // Checkbox
        $data['has_car']   = $request->has('has_car');
        $data['can_drive'] = $request->has('can_drive');

        // Si sube nueva imagen, borra la anterior y guarda la nueva
        if ($request->hasFile('image')) {
            if ($actor->image) {
                Storage::disk('public')->delete($actor->image);
            }
            $data['image'] = $request->file('image')->store('actors', 'public');
        }

        $actor->update($data);

        return redirect()->route('actors.index')
                         ->with('success','Actor actualizado correctamente.');
    }

    public function destroy(Actor $actor)
    {
        // Borrar imagen de disco
        if ($actor->image) {
            Storage::disk('public')->delete($actor->image);
        }
        $actor->delete();

        return redirect()->route('actors.index')
                         ->with('success','Actor eliminado correctamente.');
    }
}
