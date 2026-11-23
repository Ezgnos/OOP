<?php
declare(strict_types=1);

require_once __DIR__ . '/Employee.php';

class Developer extends Employee
{
    private string $level;

    public function __construct(string $name, float $baseSalary, string $passport, string $level)
    {
        if (!in_array($level, ['junior', 'middle', 'senior'], true)) {
            throw new InvalidArgumentException("Неизвестный уровень: {$level}");
        }
        parent::__construct($name, $baseSalary, $passport);
        $this->level = $level;
    }

    public function getSalary(): float
    {
        $coefficient = match ($this->level) {
            'junior' => 1.0,
            'middle' => 1.5,
            'senior' => 2.0,
        };
        return $this->baseSalary * $coefficient;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    // Для эксперимента: вызов private-метода родителя
    public function tryValidate(): void
    {
        $this->validatePercent(10);
    }

    // Пункт 6 (переопределение final) сделан отдельно в final_error.php,
    // потому что с ним весь скрипт не запустится.
}
