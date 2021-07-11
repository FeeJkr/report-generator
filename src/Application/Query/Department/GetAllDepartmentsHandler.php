<?php

declare(strict_types=1);

namespace App\Application\Query\Department;

use App\Application\Query\Department\ViewModel\DepartmentsCollection;

final class GetAllDepartmentsHandler
{
    public function __construct(private DepartmentReadModel $readModel){}

    public function handle(): DepartmentsCollection
    {
        return $this->readModel->getAllDepartments();
    }
}