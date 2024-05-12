<?php

namespace Database\Factories;

use App\Enums\DeliveryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'weight' => mt_rand(1, 800),
            'description' => fake()->sentence(),
            'status' => DeliveryStatus::IN_TRANSIT,
            'tracking_number' => mt_rand(10000001, 90000001),
        ];
    }
}
