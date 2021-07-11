<?php

declare(strict_types=1);

namespace App\Application\Query\Employee;

use App\Application\Query\Employee\ViewModel\EmployeesCollection;

final class GetAllEmployeesHandler
{
    public function __construct(private EmployeeReadModel $readModel){}

    public function handle(): EmployeesCollection
    {
        return $this->readModel->getAllEmployees();
    }
}