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
                'first_name' => 'Thiago',
                'last_name'  => 'Matheus.',
                'phone'      => '123456789',
                'email'      => 't@example.com',
                'city'       => 'Los Angeles',
                'has_car'    => true,
                'can_drive'  => true,
                'active'     => true,
                'notes'      => 'Actor de Iron Man',
                'image'      => 'actors/image_user.png',
            ],
            [
                'first_name' => 'Azai',
                'last_name'  => 'Hemsworth',
                'phone'      => '987654321',
                'email'      => 'chris@example.com',
                'city'       => 'Sydney',
                'has_car'    => true,
                'can_drive'  => true,
                'active'     => true,
                'notes'      => 'Actor de Thor',
                'image'      => 'actors/image_user.png',
            ],
            // Puedes añadir más si deseas
        ];

        foreach ($actors as $data) {
            Actor::create($data);
        }
    }
}
