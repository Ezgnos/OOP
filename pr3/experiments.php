<?php
declare(strict_types=1);

require_once __DIR__ . '/Student.php';

function run(string $title, callable $fn): void
{
    echo "--- {$title}" . PHP_EOL;
    try {
        $fn();
    } catch (Throwable $e) {
        echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
    }
    echo PHP_EOL;
}

$s = new Student(2001, 'Тестов', 'Тест', 2);
$s->grades = [5, 4];

run('1. Изменение readonly $id', function () use ($s) {
    $s->id = 5;
});

run('2. Строка в $course при strict_types=1', function () use ($s) {
    $s->course = 'два';
});

run('3. Студент с курсом 7', function () {
    new Student(2002, 'Другой', 'Студент', 7);
});

run('4. Изменение Student::$university', function () use ($s) {
    $other = new Student(2003, 'Второй', 'Студент', 1);
    echo 'До:    ' . Student::$university . PHP_EOL;
    Student::$university = 'Университет ИТ';
    echo 'После: ' . Student::$university . PHP_EOL;
    echo 'Через $s:     ' . $s::$university . PHP_EOL;
    echo 'Через $other: ' . $other::$university . PHP_EOL;
});

run('5a. var_dump()', function () use ($s) {
    var_dump($s);
});

run('5b. get_object_vars()', function () use ($s) {
    print_r(get_object_vars($s));
});
