<?php

declare(strict_types=1);

namespace App\Application\Command\Department;

use App\Domain\Department\Department;
use App\Domain\Department\DepartmentRepository;
use App\Domain\Department\ExtraPayType;

final class AddNewDepartmentHandler
{
    public function __construct(private DepartmentRepository $repository){}

    public function handle(AddNewDepartmentCommand $command): string
    {
        $department = Department::createNew(
            $command->getName(),
            new ExtraPayType($command->getExtraPayType()),
            $command->getExtraPayValue(),
        );

        $this->repository->store($department);

        return $department->getSnapshot()->getId();
    }
}
