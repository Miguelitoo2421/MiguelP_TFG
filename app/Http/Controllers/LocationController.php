<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $locations = Location::orderBy('city')->paginate(15);
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'city'         => ['required','string','max:50'],
            'province'     => ['nullable','string','max:50'],
            'region'       => ['nullable','string','max:50'],
            'street_type'  => ['nullable','string','max:20'],
            'street_name'  => ['nullable','string','max:100'],
            'street_number'=> ['nullable','string','max:10'],
            'postal_code'  => ['nullable','string','max:10'],
            'url_map'      => ['nullable','string','max:255'],
            'phone'        => ['nullable','string','max:20'],
            'active'       => ['required','boolean'],
            'notes'        => ['nullable','string','max:255'],
        ]);

        Location::create($data);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Localización creada correctamente.');
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'city'         => ['required','string','max:50'],
            'province'     => ['nullable','string','max:50'],
            'region'       => ['nullable','string','max:50'],
            'street_type'  => ['nullable','string','max:20'],
            'street_name'  => ['nullable','string','max:100'],
            'street_number'=> ['nullable','string','max:10'],
            'postal_code'  => ['nullable','string','max:10'],
            'url_map'      => ['nullable','string','max:255'],
            'phone'        => ['nullable','string','max:20'],
            'active'       => ['required','boolean'],
            'notes'        => ['nullable','string','max:255'],
        ]);

        $location->update($data);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Localización actualizada correctamente.');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()
            ->route('locations.index')
            ->with('success', 'Localización eliminada correctamente.');
    }
}
