<?php

declare(strict_types=1);

namespace App\Domain\Employee\Contract;

use App\Domain\Employee\DepartmentId;

interface DepartmentContract
{
    public function isDepartmentExists(DepartmentId $departmentId): bool;
}