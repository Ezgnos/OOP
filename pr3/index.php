<?php
declare(strict_types=1);

require_once __DIR__ . '/Student.php';

// Дополняет строку пробелами с учётом кириллицы (printf считает байты, а не буквы)
function pad(string $s, int $width): string
{
    $len = count(preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY));
    return $s . str_repeat(' ', max(0, $width - $len));
}

$students = [
    new Student(1001, 'Иванов', 'Пётр', 1),
    new Student(1002, 'Петрова', 'Мария', 2),
    new Student(1003, 'Сидоров', 'Алексей', 3),
    new Student(1004, 'Кузнецова', 'Ольга', 4),
];

$students[0]->email = 'ivanov@example.com';
$students[0]->grades = [5, 4, 5, 4];
$students[1]->email = 'petrova@example.com';
$students[1]->grades = [5, 5, 5];
$students[2]->email = null;                    // почта не указана
$students[2]->grades = [3, 4, 4, 3, 4];
$students[3]->email = 'kuznetsova@example.com';
$students[3]->grades = [4, 4, 5];

echo 'Учебное заведение: ' . Student::$university . PHP_EOL . PHP_EOL;

echo pad('Билет', 7) . pad('ФИО', 22) . pad('Курс', 6) . pad('Почта', 26) . 'Ср. балл' . PHP_EOL;
echo str_repeat('-', 70) . PHP_EOL;

foreach ($students as $s) {
    echo pad((string) $s->id, 7)
        . pad($s->getFullName(), 22)
        . pad((string) $s->course, 6)
        . pad($s->email ?? 'не указана', 26)
        . number_format($s->getAverage(), 2, ',', '') . PHP_EOL;
}

echo PHP_EOL . 'Всего студентов: ' . Student::$totalStudents . PHP_EOL;

// Дополнительно: __set
echo PHP_EOL;
$students[0]->nickname = 'Петя';
echo 'История обращений к несуществующим свойствам: ' . implode(', ', $students[0]->getHistory()) . PHP_EOL;
