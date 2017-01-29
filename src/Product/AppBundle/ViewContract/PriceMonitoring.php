<?php

declare(strict_types=1);

namespace Product\AppBundle\ViewContract;

use Money\Money;

final class PriceMonitoring
{
    /** @var string */
    public $description;
    /** @var string */
    public $sellerName;
    /** @var Money */
    public $price;
}
