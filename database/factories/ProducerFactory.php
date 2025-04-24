<?php

namespace Database\Factories;

use App\Models\Producer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProducerFactory extends Factory
{
    protected $model = Producer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'cif'  => strtoupper($this->faker->bothify('??########')),
            'image'=> null,
        ];
    }
}
