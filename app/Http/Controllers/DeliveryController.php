<?php

namespace App\Http\Controllers;

use App\Enums\DeliveryStatus;
use App\Http\Requests\DeliveryRequest;
use App\Models\Shipment;
use App\Repositories\DeliveryRepository;
use Illuminate\Http\Request;
use App\Models\Delivery;

class DeliveryController extends Controller
{
    public function __construct(public DeliveryRepository $repository)
    {

    }

    // List all deliveries
    public function index()
    {
        $deliveries = Delivery::all();

        return response()->json([
            'deliveries' => $deliveries,
        ], 200);
    }

    // Create a new delivery
    public function store(DeliveryRequest $request)
    {
        $delivery = $this->repository->create($request);

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
    public function update(DeliveryRequest $request, $id)
    {
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
