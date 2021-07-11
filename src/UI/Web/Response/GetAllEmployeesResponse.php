<?php

declare(strict_types=1);

namespace App\UI\Web\Response;

use App\Application\Query\Employee\ViewModel\Employee;
use App\Application\Query\Employee\ViewModel\EmployeesCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetAllEmployeesResponse
{
    public static function respond(EmployeesCollection $employees): JsonResponse
    {
        return new JsonResponse(
            array_map(
                static fn(Employee $employee): array => self::presentEmployee($employee),
                $employees->toArray()
            )
        );
    }

    private static function presentEmployee(Employee $employee): array
    {
        return [
            'id' => $employee->getId(),
            'department_id' => $employee->getDepartmentId(),
            'department_name' => $employee->getDepartmentName(),
            'first_name' => $employee->getFirstName(),
            'last_name' => $employee->getLastName(),
            'salary' => $employee->getSalary(),
            'employed_at' => $employee->getEmployedAt()->format('Y-m-d'),
        ];
    }
}