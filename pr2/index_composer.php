<?php
declare(strict_types=1);

// Пункт 6: вместо autoload.php — автозагрузчик Composer.
// Сначала выполните в папке pr2:  composer dump-autoload
require __DIR__ . '/vendor/autoload.php';

use Shop\Helpers\PriceFormatter;
use Shop\Models\Customer;
use Shop\Models\Product;
use Shop\Orders\Order;
use Shop\Services\Cart;

$customer = new Customer('Анна Иванова', 'anna@example.com');
$cart = new Cart($customer);

$cart->add(new Product('Клавиатура', 1250.00), 2);
$cart->add(new Product('Мышь', 799.50), 1);
$cart->add(new Product('Монитор', 15990.00), 1);

echo 'Итого: ' . PriceFormatter::format($cart->getTotal()) . PHP_EOL;

// Дополнительно: класс из новой папки src/Orders/ подхватился без правок composer.json
echo (new Order($cart))->getSummary() . PHP_EOL;
