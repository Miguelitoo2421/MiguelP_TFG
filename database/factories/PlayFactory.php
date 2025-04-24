<?php

namespace Database\Factories;

use App\Models\Play;
use App\Models\Producer;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayFactory extends Factory
{
    protected $model = Play::class;

    public function definition()
    {
        return [
            'name'        => $this->faker->catchPhrase,
            'producer_id' => Producer::factory(),
            'active'      => true,
            'notes'       => $this->faker->sentence,
        ];
    }
}
