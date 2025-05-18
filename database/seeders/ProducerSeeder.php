<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producer;

class ProducerSeeder extends Seeder
{
    public function run(): void
    {
        $producers = [
            [
                'name'  => 'Netflix',
                'cif'   => 'B12345678',
                'image' => 'producers/netflix.jpg',
            ],
            [
                'name'  => 'Disney+',
                'cif'   => 'B87654321',
                'image' => 'producers/disney.jpg',
            ],
        ];

        foreach ($producers as $data) {
            Producer::create($data);
        }
    }
}
