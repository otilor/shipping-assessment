<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Delivery;

class DeliveryApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_valid_delivery()
    {
        $deliveryData = [
            'description' => 'Test Shipment',
            'weight' => 10,
        ];

        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $response = $this->postJson('/api/deliveries', $deliveryData);

        $response->assertStatus(201)
            ->assertJsonFragment($deliveryData);

        $this->assertDatabaseHas('deliveries', $deliveryData);
    }

    /** @test */
    public function it_requires_weight_when_creating_a_delivery()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $response = $this->postJson('/api/deliveries', [
            'description' => fake()->sentence,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('weight');
    }

    /** @test */
    public function it_requires_description_when_creating_a_delivery()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $response = $this->postJson('/api/deliveries', [
            'weight' => mt_rand(1, 800),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('description');
    }

    /** @test */
    public function it_can_get_a_single_delivery()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $delivery = Delivery::factory()->create();

        $response = $this->getJson("/api/deliveries/{$delivery->tracking_number}");

        $delivery->refresh();
        $response->assertStatus(200)
            ->assertJson([
                'delivery' => $delivery->toArray(),
            ]);
    }

    /** @test */
    public function it_returns_404_when_trying_to_get_non_existing_delivery()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $response = $this->getJson("/api/deliveries/999");

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_a_delivery()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $delivery = Delivery::factory()->create();

        $updatedData = [
            'weight' => 15,
            'description' => 'Updated Shipment',
        ];

        $response = $this->putJson("/api/deliveries/{$delivery->tracking_number}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('deliveries', $updatedData);
    }

    /** @test */
    public function it_can_delete_a_delivery()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $delivery = Delivery::factory()->create();

        $response = $this->deleteJson("/api/deliveries/{$delivery->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('deliveries', ['id' => $delivery->id]);
    }
}
