<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentType extends Enum
{
    const CashOnDelivery =   1;
    const Paypal =   2;
}