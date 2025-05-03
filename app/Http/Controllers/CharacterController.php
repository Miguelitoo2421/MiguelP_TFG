<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $characters = Character::orderBy('name')->paginate(15);

        return view('characters.index', compact('characters'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:50',
            'notes' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('characters', 'public');
        }

        Character::create($data);

        return back()->with('success', __('Character created.'));
    }

    public function update(Request $request, Character $character)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:50',
            'notes' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('characters', 'public');
        }

        $character->update($data);

        return back()->with('success', __('Character updated.'));
    }

    public function destroy(Character $character)
    {
        $character->delete();

        return back()->with('success', __('Character deleted.'));
    }
}
