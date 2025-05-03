<?php

namespace Database\Seeders;

use App\Models\{User, Producer, Play, Actor, Character};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharactersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $producer = Producer::factory()->create();
        $play     = Play::factory()->create(['producer_id' => $producer->id]);
        $actor    = Actor::factory()->create();


        // Crear personajes específicos de Marvel
        $marvelCharacters = [
            [
                'name' => 'Iron Man',
                'notes' => 'Genius, billionaire, playboy, philanthropist.',
                'image' => 'characters/ironman.jpg',
            ],
            [
                'name' => 'Spider-Man',
                'notes' => 'Friendly neighborhood superhero.',
                'image' => 'characters/spiderman.jpg',
            ],
            [
                'name' => 'Thor',
                'notes' => 'God of Thunder.',
                'image' => 'characters/thor.jpg',
            ],
            [
                'name' => 'Captain America',
                'notes' => 'The First Avenger.',
                'image' => 'characters/captain_america.jpg',
            ],
            [
                'name' => 'Black Widow',
                'notes' => 'Master spy and assassin.',
                'image' => 'characters/black_widow.jpg',
            ],
            [
                'name' => 'Hulk',
                'notes' => 'green beast.',
                'image' => 'characters/hulk.jpg',
            ],
        ];

        foreach ($marvelCharacters as $data) {
            $character = Character::create([
                'name'    => $data['name'],
                'notes'   => $data['notes'],
                'image'   => $data['image'],
                'play_id' => $play->id,
            ]);

            // Relacionar con el actor
            $actor->characters()->attach($character->id, [
                'mastery_level' => rand(5, 10),
                'notes'         => 'Personaje Marvel asignado automáticamente.',
            ]);
        }
    }
}
