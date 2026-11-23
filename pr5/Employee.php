<?php
declare(strict_types=1);

class Employee
{
    public string $name;
    protected float $baseSalary;
    private string $passport;
    private array $salaryHistory = [];

    public function __construct(string $name, float $baseSalary, string $passport)
    {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
        $this->passport = $passport;
    }

    public function getSalary(): float
    {
        return $this->baseSalary;
    }

    // Зарплата на руки (после налога) — единственный способ получить её снаружи
    public function getNetSalary(): float
    {
        $gross = $this->getSalary();
        return $gross - $this->calculateTax($gross);
    }

    public function raiseSalary(float $percent): void
    {
        $this->validatePercent($percent);
        $old = $this->baseSalary;
        $this->baseSalary = round($old * (1 + $percent / 100), 2);
        $this->salaryHistory[] = sprintf(
            '%s: %.2f -> %.2f (+%s%%)',
            date('Y-m-d'),
            $old,
            $this->baseSalary,
            $percent
        );
    }

    // final: наследники не могут переопределить маскирование паспорта
    final public function getMaskedPassport(): string
    {
        return '**** **' . substr($this->passport, -4);
    }

    public function getSalaryHistory(): array
    {
        return $this->salaryHistory;
    }

    protected function calculateTax(float $amount): float
    {
        return round($amount * 0.13, 2);
    }

    private function validatePercent(float $p): void
    {
        if ($p < 1 || $p > 50) {
            throw new InvalidArgumentException("Процент повышения должен быть от 1 до 50, получено: {$p}");
        }
    }
}
