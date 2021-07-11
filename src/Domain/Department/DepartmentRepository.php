<?php

declare(strict_types=1);

namespace App\Domain\Department;

interface DepartmentRepository
{
    public function store(Department $department): void;
}