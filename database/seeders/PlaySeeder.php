<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Play, Producer, Character};

class PlaySeeder extends Seeder
{
    public function run(): void
    {
        $producer = Producer::first();
        if (! $producer) {
            $this->command->warn('No hay productores. Ejecuta ProducerSeeder antes.');
            return;
        }

        // Crear dos obras
        $plays = [
            [
                'name'        => 'The Avengers',
                'active'      => true,
                'notes'       => 'action film about the beginning of the Avengers.',
                'image'       => 'plays/play_avengers.jpg',
                'producer_id' => $producer->id,
            ],
            [
                'name'        => 'Avengers Live',
                'active'      => true,
                'notes'       => 'Adaptación teatral del universo Marvel.',
                'image'       => 'plays/play_cap_america.jpg',
                'producer_id' => $producer->id,
            ],
        ];

        foreach ($plays as $playData) {
            $play = Play::create($playData);

            // Tomar algunos personajes aleatorios y vincularlos a la obra
            $characters = Character::inRandomOrder()->take(3)->get();

            foreach ($characters as $character) {
                // Agregamos a tabla pivote character_play
                $play->characters()->attach($character->id);
            }
        }
    }
}
