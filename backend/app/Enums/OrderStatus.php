<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const OPEN = 1;
    const CLOSED = 2;
    const PAID = 3;
}
