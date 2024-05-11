<?php

namespace App\Enums;

enum ShipmentStatus: string
{
    case IN_TRANSIT = 'in_transit';
    case CANCELED = 'canceled';
    case COMPLETED = 'received';
}
