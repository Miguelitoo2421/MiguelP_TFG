<?php

namespace App\Http\Controllers;

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
        $plays     = Play::with('producer')->orderBy('name')->paginate(15);
        $producers = Producer::orderBy('name')->pluck('name','id');

        return view('plays.index', compact('plays', 'producers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:100'],
            'producer_id' => ['required','exists:producers,id'],
            'active'      => ['required','boolean'],
            'notes'       => ['nullable','string','max:255'],
            'image'       => ['nullable','image','max:2048'],  // valida imagen
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                                    ->store('plays','public');
        }

        Play::create($data);

        return redirect()
            ->route('plays.index')
            ->with('success', 'Play created successfully.');
    }

    public function update(Request $request, Play $play)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:100'],
            'producer_id' => ['required','exists:producers,id'],
            'active'      => ['required','boolean'],
            'notes'       => ['nullable','string','max:255'],
            'image'       => ['nullable','image','max:2048'],  // valida imagen
        ]);

        if ($request->hasFile('image')) {
            // borrar imagen anterior si existe
            if ($play->image && Storage::disk('public')->exists($play->image)) {
                Storage::disk('public')->delete($play->image);
            }
            $data['image'] = $request->file('image')
                                    ->store('plays','public');
        }

        $play->update($data);

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
}
