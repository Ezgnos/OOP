<?php
declare(strict_types=1);

require_once __DIR__ . '/Employee.php';

class Manager extends Employee
{
    private const BONUS_PER_SUBORDINATE = 5000.0;

    private int $teamSize;

    public function __construct(string $name, float $baseSalary, string $passport, int $teamSize)
    {
        parent::__construct($name, $baseSalary, $passport);
        $this->teamSize = $teamSize;
    }

    public function getSalary(): float
    {
        return $this->baseSalary + self::BONUS_PER_SUBORDINATE * $this->teamSize; // protected — доступно
    }

    // Налог только с надбавки за команду (использует protected calculateTax)
    public function getTeamBonusTax(): float
    {
        return $this->calculateTax(self::BONUS_PER_SUBORDINATE * $this->teamSize);
    }

    // Для эксперимента: чтение protected-свойства в наследнике
    public function readBaseSalary(): float
    {
        return $this->baseSalary;
    }

    // Для эксперимента: чтение private-свойства родителя в наследнике
    public function readPassport(): mixed
    {
        return $this->passport;
    }
}
