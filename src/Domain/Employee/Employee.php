<?php

declare(strict_types=1);

namespace App\Domain\Employee;

use DateTime;
use DateTimeInterface;
use JetBrains\PhpStorm\Pure;
use UnexpectedValueException;

final class Employee
{
    private function __construct(
        private EmployeeId $id,
        private DepartmentId $departmentId,
        private string $firstName,
        private string $lastName,
        private float $salary,
        private DateTimeInterface $employedAt,
    ){}

    public static function createNew(
        DepartmentId $departmentId,
        string $firstName,
        string $lastName,
        float $salary,
        DateTimeInterface $employedAt
    ): self {
        if ($employedAt->getTimestamp() > (new DateTime)->getTimestamp()) {
            throw new UnexpectedValueException('Employee must be employed at past time.');
        }

        return new self(
            EmployeeId::generate(),
            $departmentId,
            $firstName,
            $lastName,
            $salary,
            $employedAt,
        );
    }

    #[Pure]
    public function getSnapshot(): EmployeeSnapshot
    {
        return new EmployeeSnapshot(
            $this->id->toString(),
            $this->departmentId->toString(),
            $this->firstName,
            $this->lastName,
            $this->salary,
            $this->employedAt,
        );
    }
}