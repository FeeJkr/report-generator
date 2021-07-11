<?php

declare(strict_types=1);

namespace App\Application\Query\Employee\ViewModel;

final class EmployeesCollection
{
    private array $employees;

    public function __construct(Employee ...$employees)
    {
        $this->employees = $employees;
    }

    public function toArray(): array
    {
        return $this->employees;
    }
}