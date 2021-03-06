<?php

declare(strict_types=1);

namespace App\Application\Query\Department;

final class GetDepartmentByIdQuery
{
    public function __construct(private string $id){}

    public function getId(): string
    {
        return $this->id;
    }
}