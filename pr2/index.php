<?php
declare(strict_types=1);

// Пункт 5: подключаем ТОЛЬКО autoload.php
require __DIR__ . '/autoload.php';

use Shop\Helpers\PriceFormatter;
use Shop\Models\Customer;
use Shop\Models\Product;
use Shop\Services\Cart;

echo "Старт скрипта, ни один класс ещё не загружен" . PHP_EOL;

$customer = new Customer('Анна Иванова', 'anna@example.com');
$cart = new Cart($customer);

$cart->add(new Product('Клавиатура', 1250.00), 2);
$cart->add(new Product('Мышь', 799.50), 1);
$cart->add(new Product('Монитор', 15990.00), 1);

echo 'Итого: ' . PriceFormatter::format($cart->getTotal()) . PHP_EOL;
