<?php

declare(strict_types=1);

namespace App\UI\Web\Response;

use App\Application\Query\Department\ViewModel\Department;
use App\Application\Query\Department\ViewModel\DepartmentsCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetAllDepartmentsResponse
{
    public static function respond(DepartmentsCollection $departments): JsonResponse
    {
        return new JsonResponse(
            array_map(
                static fn(Department $department): array => self::presentDepartment($department),
                $departments->toArray()
            )
        );
    }

    private static function presentDepartment(Department $department): array
    {
        return [
            'id' => $department->getId(),
            'name' => $department->getName(),
            'extra_pay_type' => $department->getExtraPayType(),
            'extra_pay_value' => $department->getExtraPayValue(),
        ];
    }
}