<?php

namespace App\Services;

use App\Enums\DeliveryStatus;
use App\Models\Delivery;
use App\Repositories\DeliveryRepository;
use Illuminate\Support\Collection;

class DeliveryService implements DeliveryRepository
{
    public function create($request): \Illuminate\Database\Eloquent\Model
    {
        return Delivery::query()->create([
            'tracking_number' => mt_rand(10000001, 90000001),
            'description' => $request->description,
            'weight' => $request->weight,
            'status' => DeliveryStatus::IN_TRANSIT,
        ]);
    }

    public function update($request, $id): \Illuminate\Database\Eloquent\Model
    {
        $delivery = Delivery::query()->where('tracking_number', $id)->firstOrFail();
        $delivery->update([
            'description' => $request->description,
            'weight' => $request->weight
        ]);

        return $delivery;
    }

    public function retrieve($tracking_number): \Illuminate\Database\Eloquent\Model
    {
        return Delivery::query()->where('tracking_number', $tracking_number)->firstOrFail();
    }
}
