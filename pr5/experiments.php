<?php
declare(strict_types=1);

require_once __DIR__ . '/Employee.php';
require_once __DIR__ . '/Manager.php';
require_once __DIR__ . '/Developer.php';

// Предупреждения (Warning) превращаем в исключения, чтобы увидеть их текст
set_error_handler(function (int $no, string $msg): bool {
    throw new ErrorException($msg, 0, $no);
});

function run(string $title, callable $fn): void
{
    echo "--- {$title}" . PHP_EOL;
    try {
        $r = $fn();
        echo 'OK, значение: ' . var_export($r, true) . PHP_EOL;
    } catch (Throwable $e) {
        echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
    }
    echo PHP_EOL;
}

$m = new Manager('Ирина Петрова', 120000, '4510 123456', 5);
$d = new Developer('Алексей Смирнов', 100000, '4511 654321', 'middle');

run('1. Чтение $name снаружи',                fn () => $m->name);
run('2. Чтение $baseSalary снаружи',          fn () => $m->baseSalary);
run('3. Чтение $baseSalary в Manager',        fn () => $m->readBaseSalary());
run('4. Чтение $passport в Manager',          fn () => $m->readPassport());
run('5. Вызов calculateTax() снаружи',        fn () => $m->calculateTax(1000.0));
run('6. Вызов validatePercent() в Developer', fn () => $d->tryValidate());
