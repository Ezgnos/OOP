<?php
declare(strict_types=1);

require_once __DIR__ . '/Book.php';
require_once __DIR__ . '/Library.php';

$library = new Library();
$library->addBook(new Book('Мастер и Маргарита', 'М. Булгаков', 1967, 480));
$library->addBook(new Book('Собачье сердце', 'М. Булгаков', 1925, 160));
$library->addBook(new Book('Преступление и наказание', 'Ф. Достоевский', 1866, 672));
$library->addBook(new Book('Война и мир', 'Л. Толстой', 1869, 1300));
$library->addBook(new Book('Евгений Онегин', 'А. Пушкин', 1833, 224));

echo "=== Все книги ===" . PHP_EOL;
$library->printAll();

echo PHP_EOL . "=== Книги М. Булгакова ===" . PHP_EOL;
foreach ($library->findByAuthor('М. Булгаков') as $book) {
    echo $book->getInfo() . PHP_EOL;
}

echo PHP_EOL . "Всего книг: " . $library->count() . PHP_EOL;

$first = $library->findByAuthor('М. Булгаков')[0];
echo "Возраст книги «{$first->title}»: " . $first->getAge() . ' лет' . PHP_EOL;

$oldest = $library->getOldest();
echo "Самая старая: " . ($oldest?->getInfo() ?? 'библиотека пуста') . PHP_EOL;
echo "Пустая библиотека, getOldest(): " . var_export((new Library())->getOldest(), true) . PHP_EOL;

// ---- Пункт 7: присваивание и клонирование ----
echo PHP_EOL . "=== Присваивание и clone ===" . PHP_EOL;
$b1 = new Book('Старое название', 'Автор А.', 2000, 100);
$b2 = $b1;        // вторая переменная указывает на ТОТ ЖЕ объект
$b3 = clone $b1;  // независимая копия

$b1->title = 'Новое название';

echo '$b1: ' . $b1->getInfo() . PHP_EOL;
echo '$b2: ' . $b2->getInfo() . PHP_EOL;
echo '$b3: ' . $b3->getInfo() . PHP_EOL;

echo '$b1 === $b2 ? ' . var_export($b1 === $b2, true) . PHP_EOL; // true
echo '$b1 === $b3 ? ' . var_export($b1 === $b3, true) . PHP_EOL; // false
