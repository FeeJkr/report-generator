<?php

declare(strict_types=1);

namespace App\Application\Query\Department;

use App\Application\Query\Department\ViewModel\Department;
use App\Application\Query\Exception\NotFoundException;

class GetDepartmentByIdHandler
{
    public function __construct(private DepartmentReadModel $readModel){}

    /**
     * @throws NotFoundException
     */
    public function handle(GetDepartmentByIdQuery $query): Department
    {
        return $this->readModel->getDepartmentById($query->getId());
    }
}