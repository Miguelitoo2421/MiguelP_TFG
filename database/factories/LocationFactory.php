<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        return [
            'city'        => $this->faker->city,
            'province'    => $this->faker->state,
            'region'      => $this->faker->state,
            'street_type' => 'C/',
            'street_name' => $this->faker->streetName,
            'street_number'=> $this->faker->buildingNumber,
            'postal_code'=> $this->faker->postcode,
            'url_map'     => null,
            'phone'       => $this->faker->phoneNumber,
            'active'      => true,
            'notes'       => $this->faker->sentence,
        ];
    }
}
