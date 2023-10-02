<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DeliveryStatus extends Enum
{
    const Processing =   1;
    const Delivered =   2;
    const Cancelled =   3;
    
}