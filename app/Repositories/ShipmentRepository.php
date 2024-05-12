<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ShipmentRepository
{
    public function create(Request $request): Model;

    public function update(Request $request, $id): Model;

    public function retrieve($tracking_number): Model;
}
