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

    public function update(): Collection
    {
        // TODO: Implement update() method.
    }

    public function retrieve($tracking_number): Collection
    {
        // TODO: Implement retrieve() method.
    }
}
