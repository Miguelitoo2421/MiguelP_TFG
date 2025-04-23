<?php

namespace App\Http\Controllers;

use App\Models\Play;
use App\Models\Producer;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plays = Play::with('producer')->orderBy('name')->paginate(15);
        return view('plays.index', compact('plays'));
    }

    public function create()
    {
        $producers = Producer::orderBy('name')->pluck('name','id');
        return view('plays.create', compact('producers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:100'],
            'producer_id' => ['required','exists:producers,id'],
            'active'      => ['required','boolean'],
            'notes'       => ['nullable','string','max:255'],
        ]);

        Play::create($data);

        return redirect()
            ->route('plays.index')
            ->with('success', 'Obra creada correctamente.');
    }

    public function show(Play $play)
    {
        return view('plays.show', compact('play'));
    }

    public function edit(Play $play)
    {
        $producers = Producer::orderBy('name')->pluck('name','id');
        return view('plays.edit', compact('play','producers'));
    }

    public function update(Request $request, Play $play)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:100'],
            'producer_id' => ['required','exists:producers,id'],
            'active'      => ['required','boolean'],
            'notes'       => ['nullable','string','max:255'],
        ]);

        $play->update($data);

        return redirect()
            ->route('plays.index')
            ->with('success', 'Obra actualizada correctamente.');
    }

    public function destroy(Play $play)
    {
        $play->delete();

        return redirect()
            ->route('plays.index')
            ->with('success', 'Obra eliminada correctamente.');
    }
}
