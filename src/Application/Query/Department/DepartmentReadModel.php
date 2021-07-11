<?php

declare(strict_types=1);

namespace App\Application\Query\Department;

use App\Application\Query\Department\ViewModel\Department;
use App\Application\Query\Department\ViewModel\DepartmentsCollection;
use App\Application\Query\Exception\NotFoundException;

interface DepartmentReadModel
{
    /**
     * @throws NotFoundException
     */
    public function getDepartmentById(string $id): Department;

    public function getAllDepartments(): DepartmentsCollection;
}