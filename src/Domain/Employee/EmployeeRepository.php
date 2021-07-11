<?php

declare(strict_types=1);

namespace App\Domain\Employee;

interface EmployeeRepository
{
    public function store(Employee $employee): void;
}