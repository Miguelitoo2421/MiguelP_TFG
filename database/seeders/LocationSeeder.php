<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'city'          => 'New York',
                'province'      => 'New York',
                'region'        => 'Northeast',
                'street_type'   => 'Avenue',
                'street_name'   => 'Broadway',
                'street_number' => '123',
                'postal_code'   => '10001',
                'phone'         => '2125551234',
                'latitude'      => 40.712776,
                'longitude'     => -74.005974,
                'active'        => true,
                'notes'         => 'Ubicación principal para audiciones.',
            ],
            [
                'city'          => 'Los Angeles',
                'province'      => 'California',
                'region'        => 'West Coast',
                'street_type'   => 'Boulevard',
                'street_name'   => 'Sunset',
                'street_number' => '456',
                'postal_code'   => '90028',
                'phone'         => '3105556789',
                'latitude'      => 34.052235,
                'longitude'     => -118.243683,
                'active'        => true,
                'notes'         => 'Oficina secundaria para castings.',
            ],
        ];

        foreach ($locations as $data) {
            Location::create($data);
        }
    }
}
