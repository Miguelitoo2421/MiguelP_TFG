<?php

namespace Database\Seeders;

use App\Models\{User, Producer, Play, Location, Actor, Character};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {

        $this->call(\Database\Seeders\RolesAndPermissionsSeeder::class);
        

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        

        // 3) Entidades de catálogo
        $producer = Producer::factory()->create();
        

        $play     = Play::factory()->create(['producer_id' => $producer->id]);
        

        $location = Location::factory()->create();
        

        $actor    = Actor::factory()->create();
        

        $character= Character::factory()->create(['play_id' => $play->id]);
        

        // 4) Relacionar actor con personaje (pivot)
        $actor->characters()->attach($character->id, [
            'mastery_level' => 5,
            'notes'         => 'Nivel de dominio medio',
        ]);
        
    }
}
