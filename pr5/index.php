<?php
declare(strict_types=1);

require_once __DIR__ . '/Employee.php';
require_once __DIR__ . '/Manager.php';
require_once __DIR__ . '/Developer.php';

function money(float $v): string
{
    return number_format($v, 2, ',', ' ') . ' ₽';
}

$employees = [
    new Employee('Олег Иванов', 60000, '4512 111222'),
    new Manager('Ирина Петрова', 120000, '4510 123456', 5),
    new Developer('Алексей Смирнов', 100000, '4511 654321', 'middle'),
    new Developer('Мария Орлова', 90000, '4513 777888', 'senior'),
];

foreach ($employees as $e) {
    echo $e->name . ' | ' . $e::class
        . ' | до налога: ' . money($e->getSalary())
        . ' | после налога: ' . money($e->getNetSalary())
        . ' | паспорт: ' . $e->getMaskedPassport() . PHP_EOL;
}

echo PHP_EOL . 'Повышение оклада Олега на 10%:' . PHP_EOL;
$employees[0]->raiseSalary(10);
print_r($employees[0]->getSalaryHistory());
echo 'Новая зарплата: ' . money($employees[0]->getSalary()) . PHP_EOL;

echo PHP_EOL . 'Повышение на 60% (должна быть ошибка):' . PHP_EOL;
try {
    $employees[0]->raiseSalary(60);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . PHP_EOL;
}
