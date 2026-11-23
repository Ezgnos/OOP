<?php
declare(strict_types=1);

namespace Shop\Orders;

use Shop\Helpers\PriceFormatter;
use Shop\Services\Cart;

class Order
{
    public function __construct(private Cart $cart) {}

    public function getSummary(): string
    {
        return 'Заказ для ' . $this->cart->getCustomer()->name
            . ' на сумму ' . PriceFormatter::format($this->cart->getTotal());
    }
}
