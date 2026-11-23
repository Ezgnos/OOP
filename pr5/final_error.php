<?php
declare(strict_types=1);

// Пункт 6: попытка переопределить final-метод.
// Этот файл НЕ запустится — PHP остановится с фатальной ошибкой. Запустите и перепишите текст ошибки в отчёт.
require_once __DIR__ . '/Developer.php';

class BrokenDeveloper extends Developer
{
    public function getMaskedPassport(): string
    {
        return 'переопределено';
    }
}
