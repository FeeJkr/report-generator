<?php

declare(strict_types=1);

namespace App\Application\Query\Employee;

use App\Application\Query\Employee\ViewModel\EmployeesCollection;

interface EmployeeReadModel
{
    public function getAllEmployees(): EmployeesCollection;
}