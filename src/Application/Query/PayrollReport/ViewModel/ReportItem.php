<?php

declare(strict_types=1);

namespace App\Application\Query\PayrollReport\ViewModel;

use JetBrains\PhpStorm\Pure;

final class ReportItem
{
    public function __construct(
        private string $employeeFirstName,
        private string $employeeLastName,
        private string $departmentName,
        private float $employeeBasicSalary,
        private float $employeeExtraPay,
        private string $employeeExtraPayType,
    ){}

    public function getEmployeeFirstName(): string
    {
        return $this->employeeFirstName;
    }

    public function getEmployeeLastName(): string
    {
        return $this->employeeLastName;
    }

    public function getDepartmentName(): string
    {
        return $this->departmentName;
    }

    public function getEmployeeBasicSalary(): float
    {
        return $this->employeeBasicSalary;
    }

    public function getEmployeeExtraPay(): float
    {
        return $this->employeeExtraPay;
    }

    public function getEmployeeExtraPayType(): string
    {
        return $this->employeeExtraPayType;
    }

    #[Pure]
    public function getEmployeeSalary(): float
    {
        return $this->getEmployeeBasicSalary() + $this->getEmployeeExtraPay();
    }
}