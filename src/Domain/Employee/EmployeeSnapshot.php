<?php

declare(strict_types=1);

namespace App\Domain\Employee;

use DateTimeInterface;

final class EmployeeSnapshot
{
    public function __construct(
        private string $id,
        private string $departmentId,
        private string $firstName,
        private string $lastName,
        private float $salary,
        private DateTimeInterface $employedAt,
    ){}

    public function getId(): string
    {
        return $this->id;
    }

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