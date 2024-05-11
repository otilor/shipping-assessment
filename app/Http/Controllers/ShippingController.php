<?php

namespace App\Http\Controllers;

use App\Enums\ShipmentStatus;
use Illuminate\Http\Request;
use App\Models\Shipment;

class ShippingController extends Controller
{
    // List all shipments
    public function index()
    {
        $shipments = Shipment::all();

        return response()->json([
            'shipments' => $shipments,
        ], 200);
    }

    // Create a new shipment
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'weight' => 'required|numeric|between:0,999.99'

        ]);

        $shipment = Shipment::create([
            'tracking_number' => mt_rand(10000001, 90000001),
            'description' => $request->description,
            'weight' => $request->weight,
            'status' => ShipmentStatus::IN_TRANSIT
        ]);

        return response()->json([
            'message' => 'Shipment created successfully!',
            'shipment' => $shipment,
        ], 201);
    }

    // Retrieve a specific shipment
    public function show($id)
    {
        $shipment = Shipment::query()->where('tracking_number', $id)->firstOrFail();

        return response()->json([
            'shipment' => $shipment,
        ], 200);
    }

    // Update a shipment
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'weight' => 'required|numeric|between:0,999.99'
        ]);

        $shipment = Shipment::query()->where('tracking_number', $id)->firstOrFail();
        $shipment->update([
            'description' => $request->description,
            'weight' => $request->weight
        ]);

        return response()->json([
            'message' => 'Shipment updated successfully!',
            'shipment' => $shipment,
        ], 200);
    }

    // Delete a shipment
    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();

        return response()->json([
            'message' => 'Shipment deleted successfully!',
        ], 200);
    }
}
