<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ActorCharacter;
use Illuminate\Http\Request;

class EventCastController extends Controller
{
    /**
     * Guarda las asignaciones de actores a personajes para un evento.
     */
    public function store(Request $request, Event $event)
    {
        $casts = $request->input('casts', []);

        foreach ($casts as $characterId => $data) {
            // Si no hay actor, eliminamos cualquier asignación previa
            if (empty($data['actor_id'])) {
                ActorCharacter::where([
                    'event_id'     => $event->id,
                    'character_id' => $characterId,
                ])->delete();
                continue;
            }

            // Creamos o actualizamos la relación
            ActorCharacter::updateOrCreate(
                [
                    'event_id'     => $event->id,
                    'character_id' => $characterId,
                ],
                [
                    'actor_id'      => $data['actor_id'],
                    'mastery_level' => $data['mastery_level'] ?? 1,
                    'notes'         => $data['notes'] ?? null,
                ]
            );
        }

        return response()->json(['success' => true]);
    }
}
