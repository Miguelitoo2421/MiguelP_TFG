<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    private const CAROUSEL_SIZE = 4;
    private const ROTATION_INTERVAL = 20; // segundos (debe coincidir con la animación CSS)

    public function index()
    {
        $allEvents = Event::with(['play'])->get();
        
        // Si hay 4 o menos eventos, los mostramos todos
        if ($allEvents->count() <= self::CAROUSEL_SIZE) {
            $events = $allEvents;
        } else {
            // Obtenemos el grupo actual basado en el tiempo
            $currentGroup = $this->getCurrentEventGroup($allEvents);
            $events = $currentGroup;
        }

        return view('dashboard', [
            'events' => $events,
            'totalEvents' => $allEvents->count(),
            'currentTime' => now()->timestamp,
            'rotationInterval' => self::ROTATION_INTERVAL,
        ]);
    }

    private function getCurrentEventGroup(Collection $events): Collection
    {
        $totalGroups = ceil($events->count() / self::CAROUSEL_SIZE);
        $currentTime = now()->timestamp;
        
        // Determinamos qué grupo mostrar basado en el tiempo actual
        $currentGroupIndex = floor(($currentTime / self::ROTATION_INTERVAL) % $totalGroups);
        
        return $events->skip($currentGroupIndex * self::CAROUSEL_SIZE)
                     ->take(self::CAROUSEL_SIZE);
    }
} 