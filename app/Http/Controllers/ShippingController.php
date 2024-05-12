<?php

namespace App\Http\Controllers;

use App\Enums\ShipmentStatus;
use App\Http\Requests\ShipmentRequest;
use App\Repositories\ShipmentRepository;
use Illuminate\Http\Request;
use App\Models\Shipment;

class ShippingController extends Controller
{
    public function __construct(public ShipmentRepository $repository)
    {
    }
    // List all shipments
    public function index()
    {
        $shipments = Shipment::all();

        return response()->json([
            'shipments' => $shipments,
        ], 200);
    }

    // Create a new shipment
    public function store(ShipmentRequest $request)
    {
        $shipment = $this->repository->create($request);

        return response()->json([
            'message' => 'Shipment created successfully!',
            'shipment' => $shipment,
        ], 201);
    }

    // Retrieve a specific shipment
    public function show($id)
    {
        $shipment = $this->repository->retrieve($id);

        return response()->json([
            'shipment' => $shipment,
        ], 200);
    }

    // Update a shipment
    public function update(ShipmentRequest $request, $id)
    {
        $shipment = $this->repository->update($request, $id);

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
