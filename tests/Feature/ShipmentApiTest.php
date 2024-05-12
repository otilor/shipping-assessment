<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Shipment;

class ShipmentApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_valid_shipment()
    {
        $shipmentData = [
            'description' => 'Test Shipment',
            'weight' => 10,
        ];
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $response = $this->postJson('/api/shipments', $shipmentData);

        $response->assertStatus(201)
            ->assertJsonFragment($shipmentData);

        $this->assertDatabaseHas('shipments', $shipmentData);
    }

    /** @test */
    public function it_requires_weight_when_creating_a_shipment()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $response = $this->postJson('/api/shipments', [
            'description' => 'Test Shipment',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('weight');
    }

    /** @test */
    public function it_requires_description_when_creating_a_shipment()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $response = $this->postJson('/api/shipments', [
            'tracking_number' => 'SH123456',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('description');
    }

    // Add more tests for reading, updating, and deleting shipments...

    /** @test */
    public function it_can_get_a_single_shipment()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $shipment = Shipment::factory()->create();
        $shipment->refresh();

        $response = $this->getJson("/api/shipments/{$shipment->tracking_number}");

        $response->assertStatus(200)
            ->assertJson([
                'shipment' => $shipment->toArray(),
            ]);
    }

    /** @test */
    public function it_returns_404_when_trying_to_get_non_existing_shipment()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $response = $this->getJson("/api/shipments/999");

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_update_a_shipment()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $shipment = Shipment::factory()->create();

        $updatedData = [
            'weight' => 15,
            'description' => 'Updated Shipment',
        ];

        $response = $this->putJson("/api/shipments/{$shipment->tracking_number}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('shipments', $updatedData);
    }

    /** @test */
    public function it_can_delete_a_shipment()
    {
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        $shipment = Shipment::factory()->create();

        $response = $this->deleteJson("/api/shipments/{$shipment->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('shipments', ['id' => $shipment->id]);
    }
}
