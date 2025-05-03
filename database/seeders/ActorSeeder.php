<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actor;

class ActorSeeder extends Seeder
{
    public function run(): void
    {
        $actors = [
            [
                'first_name' => 'Robert',
                'last_name'  => 'Downey Jr.',
                'phone'      => '123456789',
                'email'      => 'rdj@example.com',
                'city'       => 'Los Angeles',
                'has_car'    => true,
                'can_drive'  => true,
                'active'     => true,
                'notes'      => 'Actor de Iron Man',
                'image'      => 'actors/robert.jpg',
            ],
            [
                'first_name' => 'Chris',
                'last_name'  => 'Hemsworth',
                'phone'      => '987654321',
                'email'      => 'chris@example.com',
                'city'       => 'Sydney',
                'has_car'    => true,
                'can_drive'  => true,
                'active'     => true,
                'notes'      => 'Actor de Thor',
                'image'      => 'actors/chris.jpg',
            ],
            // Puedes añadir más si deseas
        ];

        foreach ($actors as $data) {
            Actor::create($data);
        }
    }
}
