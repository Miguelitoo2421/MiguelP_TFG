<?php

namespace Database\Factories;

use App\Models\Actor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActorFactory extends Factory
{
    protected $model = Actor::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'phone'      => $this->faker->phoneNumber,
            'email'      => $this->faker->safeEmail,
            'city'       => $this->faker->city,
            'has_car'    => $this->faker->boolean,
            'can_drive'  => $this->faker->boolean,
            'active'     => true,
            'notes'      => $this->faker->sentence,
            'image'      => null,
        ];
    }
}
