<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProducerController extends Controller
{
    public function __construct()
    {
        // Protegemos con auth y sólo admin puede gestionar productores
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * 1. Listado de productores
     */
    public function index()
    {
        $producers = Producer::orderBy('name')->paginate(15);

        return view('producers.index', compact('producers'));
    }

    /**
     * 2. Almacenar nuevo productor (incluyendo imagen)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:50'],
            'cif'   => ['required', 'string', 'max:20', 'unique:producers,cif'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // Guarda en storage/app/public/producers/… y deja 'producers/archivo.ext'
            $data['image'] = $request->file('image')
                                    ->store('producers', 'public');
        }

        Producer::create($data);

        return back()->with('success',__('Producer created.'));
    }

    /**
     * 3. Actualizar productor (y reemplazar imagen si suben una nueva)
     */
    public function update(Request $request, Producer $producer)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:50'],
            'cif'   => ['required', 'string', 'max:20', "unique:producers,cif,{$producer->id}"],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // Borra la antigua para no acumular archivos
            if ($producer->image && Storage::disk('public')->exists($producer->image)) {
                Storage::disk('public')->delete($producer->image);
            }
            // Guarda la nueva
            $data['image'] = $request->file('image')
                                    ->store('producers', 'public');
        }

        $producer->update($data);

        return back()->with('success', 'Productora actualizada correctamente.');
    }

    /**
     * 4. Borrar productor (y su imagen asociada)
     */
    public function destroy(Producer $producer)
    {
        if ($producer->image && Storage::disk('public')->exists($producer->image)) {
            Storage::disk('public')->delete($producer->image);
        }

        $producer->delete();

        return back()->with('success', 'Productora eliminada correctamente.');
    }
}
