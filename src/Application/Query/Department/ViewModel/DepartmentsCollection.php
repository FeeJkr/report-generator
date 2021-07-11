<?php

declare(strict_types=1);

namespace App\Application\Query\Department\ViewModel;

final class DepartmentsCollection
{
    private array $departments;

    public function __construct(Department ...$departments)
    {
        $this->departments = $departments;
    }

    public function toArray(): array
    {
        return $this->departments;
    }
}