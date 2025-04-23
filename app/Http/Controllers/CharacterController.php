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

    public function index()
    {
        $characters = Character::with('play')->orderBy('name')->paginate(15);
        return view('characters.index', compact('characters'));
    }

    public function create()
    {
        $plays = Play::orderBy('name')->pluck('name','id');
        return view('characters.create', compact('plays'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required','string','max:50'],
            'play_id' => ['required','exists:plays,id'],
            'notes'   => ['nullable','string','max:255'],
            'image'   => ['nullable','string','max:255'],
        ]);

        Character::create($data);

        return redirect()
            ->route('characters.index')
            ->with('success', 'Personaje creado correctamente.');
    }

    public function show(Character $character)
    {
        return view('characters.show', compact('character'));
    }

    public function edit(Character $character)
    {
        $plays = Play::orderBy('name')->pluck('name','id');
        return view('characters.edit', compact('character','plays'));
    }

    public function update(Request $request, Character $character)
    {
        $data = $request->validate([
            'name'    => ['required','string','max:50'],
            'play_id' => ['required','exists:plays,id'],
            'notes'   => ['nullable','string','max:255'],
            'image'   => ['nullable','string','max:255'],
        ]);

        $character->update($data);

        return redirect()
            ->route('characters.index')
            ->with('success', 'Personaje actualizado correctamente.');
    }

    public function destroy(Character $character)
    {
        $character->delete();

        return redirect()
            ->route('characters.index')
            ->with('success', 'Personaje eliminado correctamente.');
    }
}
