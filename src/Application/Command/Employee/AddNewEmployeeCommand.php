<?php

declare(strict_types=1);

namespace App\Application\Command\Employee;

use DateTimeInterface;

final class AddNewEmployeeCommand
{
    public function __construct(
        private string $departmentId,
        private string $firstName,
        private string $lastName,
        private float $salary,
        private DateTimeInterface $employedAt,
    ){}

    public function getDepartmentId(): string
    {
        return $this->departmentId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function getEmployedAt(): DateTimeInterface
    {
        return $this->employedAt;
    }
}