<?php

namespace Database\Seeders;

use App\Models\{Play, Character};
use Illuminate\Database\Seeder;

class CharactersSeeder extends Seeder
{
    public function run(): void
    {
        $play = Play::first();

        if (!$play) {
            $this->command->warn('Play no existe. Ejecuta los seeders correspondientes primero.');
            return;
        }

        $marvelCharacters = [
            ['name' => 'Iron Man',        'notes' => 'Genius, billionaire, playboy, philanthropist.', 'image' => 'characters/ironman.jpg'],
            ['name' => 'Spider-Man',      'notes' => 'Friendly neighborhood superhero.',             'image' => 'characters/spiderman.jpg'],
            ['name' => 'Thor',            'notes' => 'God of Thunder.',                              'image' => 'characters/thor.jpg'],
            ['name' => 'Captain America', 'notes' => 'The First Avenger.',                           'image' => 'characters/captain_america.jpg'],
            ['name' => 'Black Widow',     'notes' => 'Master spy and assassin.',                     'image' => 'characters/black_widow.jpg'],
            ['name' => 'Hulk',            'notes' => 'Green beast.',                                 'image' => 'characters/hulk.jpg'],
        ];

        foreach ($marvelCharacters as $data) {
            Character::create([
                'name'  => $data['name'],
                'notes' => $data['notes'],
                'image' => $data['image'],
            ]);
        }
    }
}
