<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter;

use App\Application\Query\Department\GetDepartmentByIdHandler;
use App\Application\Query\Department\GetDepartmentByIdQuery;
use App\Application\Query\Exception\NotFoundException;
use App\Domain\Employee\Contract\DepartmentContract;
use App\Domain\Employee\DepartmentId;

final class DepartmentAdapter implements DepartmentContract
{
    public function __construct(private GetDepartmentByIdHandler $getDepartmentByIdHandler){}

    public function isDepartmentExists(DepartmentId $departmentId): bool
    {
        try {
            $this->getDepartmentByIdHandler->handle(new GetDepartmentByIdQuery($departmentId->toString()));

            return true;
        } catch (NotFoundException) {
            return false;
        }
    }
}