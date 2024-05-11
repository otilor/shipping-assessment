<?php

namespace App\Http\Controllers;

use App\Enums\DeliveryStatus;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Models\Delivery;

class DeliveryController extends Controller
{
    // List all deliveries
    public function index()
    {
        $deliveries = Delivery::all();

        return response()->json([
            'deliveries' => $deliveries,
        ], 200);
    }

    // Create a new delivery
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'weight' => 'required|numeric|between:0,999.99'
        ]);

        $delivery = Delivery::create([
            'tracking_number' => mt_rand(10000001, 90000001),
            'description' => $request->description,
            'weight' => $request->weight,
            'status' => DeliveryStatus::IN_TRANSIT,
        ]);

        return response()->json([
            'message' => 'Delivery created successfully!',
            'delivery' => $delivery,
        ], 201);
    }

    // Retrieve a specific delivery
    public function show($id)
    {
        $delivery = Delivery::query()->where('tracking_number', $id)->firstOrFail();

        return response()->json([
            'delivery' => $delivery,
        ], 200);
    }

    // Update a delivery
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'weight' => 'required|numeric|between:0,999.99'
        ]);

        $delivery = Delivery::query()->where('tracking_number', $id)->firstOrFail();
        $delivery->update([
            'description' => $request->description,
            'weight' => $request->weight
        ]);

        return response()->json([
            'message' => 'Delivery updated successfully!',
            'delivery' => $delivery,
        ], 200);
    }

    // Delete a delivery
    public function destroy($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->delete();

        return response()->json([
            'message' => 'Delivery deleted successfully!',
        ], 200);
    }
}
