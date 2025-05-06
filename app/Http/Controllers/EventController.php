<?php

// app/Http/Controllers/EventController.php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Play;
use App\Models\Location;
use App\Models\Actor;
use Illuminate\Http\Request;


class EventController extends Controller
{
    public function index()
    {
        $events    = Event::with(['play.characters','location'])
                          ->orderBy('scheduled_at','desc')
                          ->paginate(12);
        $plays     = Play::active()->with('characters')->get();
        $locations = Location::where('active', true)->get();
        $actors    = Actor::all();             // ← Lo nuevo
        return view('events.index', compact('events','plays','locations','actors'));
    }

    public function create()
    {
        $plays     = Play::active()->with('characters')->get();      
        $locations = Location::where('active', true)->get();

        return view('events.create', compact('plays','locations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'play_id'      => 'required|exists:plays,id',
            'location_id'  => 'required|exists:locations,id',
            'title'        => 'required|string|max:100',
            'scheduled_at' => 'required|date',
        ]);

        Event::create($data);

        return redirect()->route('events.index')
                         ->with('success', __('Event created.'));
    }

    public function edit(Event $event)
    {
        $plays     = Play::active()->with('characters')->get();
        $locations = Location::where('active', true)->get();

        return view('events.edit', compact('event','plays','locations'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'play_id'      => 'required|exists:plays,id',
            'location_id'  => 'required|exists:locations,id',
            'title'        => 'required|string|max:100',
            'scheduled_at' => 'required|date',
        ]);

        $event->update($data);

        return back()->with('success', __('Event updated.'));
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', __('Event deleted.'));
    }
}
