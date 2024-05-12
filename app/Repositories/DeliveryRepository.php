<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface DeliveryRepository
{
    public function create(Request $request): Model;

    public function update(): Collection;

    public function retrieve($tracking_number): Collection;
}
