<?php

namespace App\Services;

use App\Enums\ShipmentStatus;
use App\Models\Shipment;
use App\Repositories\ShipmentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ShipmentService implements ShipmentRepository
{

    public function create(Request $request): Model
    {
        return Shipment::create([
            'tracking_number' => mt_rand(10000001, 90000001),
            'description' => $request->description,
            'weight' => $request->weight,
            'status' => ShipmentStatus::IN_TRANSIT
        ]);


    }

    public function update(Request $request, $id): Model
    {
        $shipment = Shipment::query()->where('tracking_number', $id)->firstOrFail();
        $shipment->update([
            'description' => $request->description,
            'weight' => $request->weight
        ]);
        return $shipment;
    }

    public function retrieve($tracking_number): Model
    {
        return Shipment::query()->where('tracking_number', $tracking_number)->firstOrFail();
    }
}
