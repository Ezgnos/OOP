<?php
declare(strict_types=1);

// Пункт 7: обращение к несуществующему классу
require __DIR__ . '/autoload.php';

try {
    $order = new Shop\Models\Order();
} catch (Error $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}

// Без try/catch PHP выдал бы:
// PHP Fatal error:  Uncaught Error: Class "Shop\Models\Order" not found in ...
