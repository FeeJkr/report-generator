<?php

declare(strict_types=1);

namespace App\Application\Command\Employee;

use App\Domain\Employee\Contract\DepartmentContract;
use App\Domain\Employee\DepartmentId;
use App\Domain\Employee\Employee;
use App\Domain\Employee\EmployeeRepository;
use DomainException;

final class AddNewEmployeeHandler
{
    public function __construct(
        private EmployeeRepository $repository,
        private DepartmentContract $departmentContract,
    ){}

    public function handle(AddNewEmployeeCommand $command): string
    {
        $departmentId = DepartmentId::fromString($command->getDepartmentId());

        if (!$this->departmentContract->isDepartmentExists($departmentId)) {
            throw new DomainException(sprintf('Department with id (%s) not found.', $departmentId->toString()));
        }

        $employee = Employee::createNew(
            $departmentId,
            $command->getFirstName(),
            $command->getLastName(),
            $command->getSalary(),
            $command->getEmployedAt(),
        );

        $this->repository->store($employee);

        return $employee->getSnapshot()->getId();
    }
}