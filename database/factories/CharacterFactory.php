<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Play;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'name'    => $this->faker->firstName,
            'play_id' => Play::factory(),
            'notes'   => $this->faker->sentence,
            'image'   => null,
        ];
    }
}
