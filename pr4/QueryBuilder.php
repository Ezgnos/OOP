<?php
declare(strict_types=1);

class QueryBuilder
{
    private const OPERATORS  = ['=', '!=', '>', '<', '>=', '<=', 'LIKE'];
    private const DIRECTIONS = ['ASC', 'DESC'];

    private array $columns = ['*'];
    private array $wheres  = [];
    private array $orders  = [];
    private ?int $limit    = null;

    private function __construct(private string $table) {}

    // Статический метод-фабрика
    public static function table(string $name): static
    {
        self::assertIdentifier($name, 'таблицы');
        return new static($name);
    }

    public function select(string ...$columns): static
    {
        if ($columns === []) {
            $this->columns = ['*'];
            return $this;
        }
        foreach ($columns as $c) {
            self::assertIdentifier($c, 'поля');
        }
        $this->columns = $columns;
        return $this;
    }

    public function where(string $column, string $operator, string|int $value): static
    {
        self::assertIdentifier($column, 'поля');
        $operator = strtoupper($operator);
        if (!in_array($operator, self::OPERATORS, true)) {
            throw new InvalidArgumentException(
                "Недопустимый оператор «{$operator}». Разрешены: " . implode(', ', self::OPERATORS)
            );
        }
        $this->wheres[] = "{$column} {$operator} " . $this->quote($value);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): static
    {
        self::assertIdentifier($column, 'поля');
        $direction = strtoupper($direction);
        if (!in_array($direction, self::DIRECTIONS, true)) {
            throw new InvalidArgumentException("Направление сортировки должно быть ASC или DESC, получено: {$direction}");
        }
        $this->orders[] = "{$column} {$direction}";
        return $this;
    }

    public function limit(int $count): static
    {
        if ($count <= 0) {
            throw new InvalidArgumentException("limit должен быть больше 0, получено: {$count}");
        }
        $this->limit = $count;
        return $this;
    }

    public function toSql(): string
    {
        $sql = 'SELECT ' . implode(', ', $this->columns) . ' FROM ' . $this->table;
        if ($this->wheres !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $this->wheres);
        }
        if ($this->orders !== []) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orders);
        }
        if ($this->limit !== null) {
            $sql .= ' LIMIT ' . $this->limit;
        }
        return $sql;
    }

    public function __toString(): string
    {
        return $this->toSql();
    }

    // Дополнительно: ->whereCity('Москва') => where('city', '=', 'Москва')
    public function __call(string $method, array $args): static
    {
        if (str_starts_with($method, 'where') && strlen($method) > 5 && count($args) === 1) {
            $column = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', substr($method, 5)));
            return $this->where($column, '=', $args[0]);
        }
        throw new BadMethodCallException("Метод {$method}() не существует");
    }

    // Строки — в одинарные кавычки (одинарная кавычка внутри удваивается), числа — как есть
    private function quote(string|int $value): string
    {
        if (is_int($value)) {
            return (string) $value;
        }
        return "'" . str_replace("'", "''", $value) . "'";
    }

    // Имена таблиц и полей — только буквы, цифры, _ и точка (и * для select)
    private static function assertIdentifier(string $name, string $what): void
    {
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_.]*$|^\*$/', $name)) {
            throw new InvalidArgumentException("Недопустимое имя {$what}: «{$name}»");
        }
    }
}
