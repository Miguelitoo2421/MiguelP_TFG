<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Play;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista de personajes + datos de obras para los filtros o selects.
     */
    public function index()
    {
        $characters = Character::with('play')
            ->orderBy('name')
            ->paginate(15);

        $plays = Play::orderBy('name')
            ->pluck('name', 'id');

        return view('characters.index', compact('characters', 'plays'));
    }

    /**
     * Crear un personaje (desde modal).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:50',
            'play_id' => 'nullable|exists:plays,id',
            'notes'   => 'nullable|string|max:255',
            'image'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Almacena en storage/app/public/characters
            $data['image'] = $request->file('image')
                                    ->store('characters', 'public');
        }

        Character::create($data);

        return back()->with('success', __('Character created.'));
    }

    /**
     * Actualizar un personaje (desde modal).
     */
    public function update(Request $request, Character $character)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:50',
            'play_id' => 'nullable|exists:plays,id',
            'notes'   => 'nullable|string|max:255',
            'image'   => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                                    ->store('characters', 'public');
        }

        $character->update($data);

        return back()->with('success', __('Character updated.'));
    }

    /**
     * Borrar un personaje (desde modal).
     */
    public function destroy(Character $character)
    {
        $character->delete();

        return back()->with('success', __('Character deleted.'));
    }
}
