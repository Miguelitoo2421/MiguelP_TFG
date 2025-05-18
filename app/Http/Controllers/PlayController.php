<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Play;
use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plays = Play::with(['producer', 'characters'])
                     ->orderBy('name')
                     ->paginate(15);

        $producers = Producer::orderBy('name')
                     ->pluck('name', 'id');

        $characters = Character::orderBy('name')
                      ->pluck('name', 'id');

        return view('plays.index', compact('plays', 'producers', 'characters'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required','string','max:100'],
            'producer_id'  => ['required','exists:producers,id'],
            'active'       => ['required','boolean'],
            'notes'        => ['nullable','string','max:255'],
            'image'        => ['nullable','image','max:2048'],
            'characters'   => ['nullable','array'],
            'characters.*' => ['exists:characters,id'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                                    ->store('plays','public');
        }

        // Creamos el play sin el campo characters
        $play = Play::create(
            collect($data)
                ->except('characters')
                ->toArray()
        );

        // Sincronizamos la relación pivote
        $play->characters()->sync($data['characters'] ?? []);

        return redirect()
            ->route('plays.index')
            ->with('success', 'Play created successfully.');
    }

    public function update(Request $request, Play $play)
    {
        $data = $request->validate([
            'name'         => ['required','string','max:100'],
            'producer_id'  => ['required','exists:producers,id'],
            'active'       => ['required','boolean'],
            'notes'        => ['nullable','string','max:255'],
            'image'        => ['nullable','image','max:10240'],
            'characters'   => ['nullable','array'],
            'characters.*' => ['exists:characters,id'],
        ]);

        if ($request->hasFile('image')) {
            if ($play->image && Storage::disk('public')->exists($play->image)) {
                Storage::disk('public')->delete($play->image);
            }
            $data['image'] = $request->file('image')
                                    ->store('plays','public');
        }

        // Actualizamos el play sin el campo characters
        $play->update(
            collect($data)
                ->except('characters')
                ->toArray()
        );

        // Sincronizamos la relación pivote
        $play->characters()->sync($data['characters'] ?? []);

        return redirect()
            ->route('plays.index')
            ->with('success', 'Play updated successfully.');
    }

    public function destroy(Play $play)
    {
        if ($play->image && Storage::disk('public')->exists($play->image)) {
            Storage::disk('public')->delete($play->image);
        }

        $play->delete();

        return redirect()
            ->route('plays.index')
            ->with('success', 'Play deleted successfully.');
    }

    public function removeCharacter(Play $play, Character $character)
    {
        $play->characters()->detach($character->id);
        return response()->json(['success' => true]);
    }
}
