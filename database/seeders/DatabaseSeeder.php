<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            ProducerSeeder::class,
            PlaySeeder::class,
            LocationSeeder::class,
            ActorSeeder::class,
            CharactersSeeder::class,
        ]);

        
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);

        
        $user->assignRole('admin');
    }
}
