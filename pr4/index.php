<?php
declare(strict_types=1);

require_once __DIR__ . '/QueryBuilder.php';

echo "=== Запросы ===" . PHP_EOL;

echo QueryBuilder::table('users')
    ->select('id', 'name', 'email')
    ->where('age', '>=', 18)
    ->where('city', '=', 'Москва')
    ->orderBy('name')
    ->limit(10) . PHP_EOL;

echo QueryBuilder::table('products') . PHP_EOL; // SELECT * FROM products

echo QueryBuilder::table('products')
    ->where('title', 'LIKE', '%ноутбук%')
    ->orderBy('price', 'desc')
    ->limit(5)
    ->toSql() . PHP_EOL;

echo QueryBuilder::table('orders')
    ->select('id', 'total')
    ->where('status', '!=', "it's done")   // кавычка внутри строки экранируется
    ->orderBy('created_at', 'DESC')
    ->orderBy('id') . PHP_EOL;

echo PHP_EOL . "=== Дополнительно: __call ===" . PHP_EOL;
echo QueryBuilder::table('users')->whereCity('Москва')->whereFirstName('Анна') . PHP_EOL;

echo PHP_EOL . "=== Ошибки ===" . PHP_EOL;

$bad = [
    'orderBy("name", "UP")'      => fn () => QueryBuilder::table('users')->orderBy('name', 'UP'),
    'limit(0)'                   => fn () => QueryBuilder::table('users')->limit(0),
    'where("a", "<>", 1)'        => fn () => QueryBuilder::table('users')->where('a', '<>', 1),
    'table("users; DROP ...")'   => fn () => QueryBuilder::table('users; DROP TABLE users'),
    'несуществующий метод'       => fn () => QueryBuilder::table('users')->foo(),
];

foreach ($bad as $title => $fn) {
    try {
        $fn();
        echo "{$title}: ошибки не было (!)" . PHP_EOL;
    } catch (InvalidArgumentException | BadMethodCallException $e) {
        echo "{$title}: " . get_class($e) . ' — ' . $e->getMessage() . PHP_EOL;
    }
}
