<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function __construct()
    {
        // Solo usuarios autenticados (o añade role:admin si es solo para admin)
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actors = Actor::orderBy('last_name')->paginate(15);
        return view('actors.index', compact('actors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('actors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required','string','max:50'],
            'last_name'  => ['required','string','max:50'],
            'phone'      => ['nullable','string','max:15'],
            'email'      => ['nullable','email','max:30'],
            'city'       => ['nullable','string','max:30'],
            'has_car'    => ['sometimes','boolean'],
            'can_drive'  => ['sometimes','boolean'],
            'active'     => ['required','boolean'],
            'image'      => ['nullable','string','max:255'],
            'notes'      => ['nullable','string','max:255'],
        ]);

        Actor::create($data);

        return redirect()
            ->route('actors.index')
            ->with('success', 'Actor creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Actor $actor)
    {
        return view('actors.show', compact('actor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actor $actor)
    {
        return view('actors.edit', compact('actor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actor $actor)
    {
        $data = $request->validate([
            'first_name' => ['required','string','max:50'],
            'last_name'  => ['required','string','max:50'],
            'phone'      => ['nullable','string','max:15'],
            'email'      => ['nullable','email','max:30'],
            'city'       => ['nullable','string','max:30'],
            'has_car'    => ['sometimes','boolean'],
            'can_drive'  => ['sometimes','boolean'],
            'active'     => ['required','boolean'],
            'image'      => ['nullable','string','max:255'],
            'notes'      => ['nullable','string','max:255'],
        ]);

        $actor->update($data);

        return redirect()
            ->route('actors.index')
            ->with('success', 'Actor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actor $actor)
    {
        $actor->delete();

        return redirect()
            ->route('actors.index')
            ->with('success', 'Actor eliminado correctamente.');
    }
}
