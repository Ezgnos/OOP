<?php
declare(strict_types=1);

// Собственный автозагрузчик: префикс Shop\ -> папка src/
spl_autoload_register(function (string $class): void {
    $prefix  = 'Shop\\';
    $baseDir = __DIR__ . '/src/';

    if (!str_starts_with($class, $prefix)) {
        return; // не наш класс
    }

    $relative = substr($class, strlen($prefix));                    // Models\Product
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';  // src/Models/Product.php

    if (is_file($file)) {
        require $file;
        echo "Загружен класс: {$class}" . PHP_EOL; // отладочный вывод (пункт 4)
    }
});
