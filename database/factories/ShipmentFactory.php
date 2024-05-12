<?php

namespace Database\Factories;

use App\Enums\ShipmentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence,
            'weight' => mt_rand(1, 800),
            'tracking_number' => mt_rand(10000001, 90000001),
            'status' => ShipmentStatus::IN_TRANSIT
        ];
    }
}
