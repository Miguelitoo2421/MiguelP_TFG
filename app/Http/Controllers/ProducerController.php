<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $producers = Producer::orderBy('name')->paginate(15);
        return view('producers.index', compact('producers'));
    }

    public function create()
    {
        return view('producers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:50'],
            'cif'  => ['required','string','max:20','unique:producers,cif'],
            'image'=> ['nullable','string','max:255'],
        ]);

        Producer::create($data);

        return redirect()
            ->route('producers.index')
            ->with('success', 'Productora creada correctamente.');
    }

    public function show(Producer $producer)
    {
        return view('producers.show', compact('producer'));
    }

    public function edit(Producer $producer)
    {
        return view('producers.edit', compact('producer'));
    }

    public function update(Request $request, Producer $producer)
    {
        $data = $request->validate([
            'name' => ['required','string','max:50'],
            'cif'  => ['required','string','max:20',"unique:producers,cif,{$producer->id}"],
            'image'=> ['nullable','string','max:255'],
        ]);

        $producer->update($data);

        return redirect()
            ->route('producers.index')
            ->with('success', 'Productora actualizada correctamente.');
    }

    public function destroy(Producer $producer)
    {
        $producer->delete();

        return redirect()
            ->route('producers.index')
            ->with('success', 'Productora eliminada correctamente.');
    }
}
