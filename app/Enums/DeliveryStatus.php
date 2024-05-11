<?php

namespace App\Enums;

enum DeliveryStatus: string
{
    case IN_TRANSIT = 'in_transit';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';
}
