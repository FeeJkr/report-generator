<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Employee\Employee;
use App\Domain\Employee\EmployeeRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RuntimeException;

final class EmployeeDbRepository implements EmployeeRepository
{
    public function __construct(private Connection $connection){}

    public function store(Employee $employee): void
    {
        try {
            $snapshot = $employee->getSnapshot();

            $this->connection->createQueryBuilder()
                ->insert('employees')
                ->values([
                    'id' => ':id',
                    'department_id' => ':departmentId',
                    'first_name' => ':firstName',
                    'last_name' => ':lastName',
                    'salary' => ':salary',
                    'employed_at' => ':employedAt',
                ])
                ->setParameters([
                    'id' => $snapshot->getId(),
                    'departmentId' => $snapshot->getDepartmentId(),
                    'firstName' => $snapshot->getFirstName(),
                    'lastName' => $snapshot->getLastName(),
                    'salary' => $snapshot->getSalary(),
                    'employedAt' => $snapshot->getEmployedAt()->format('Y-m-d 00:00:00'),
                ])
                ->execute();
        } catch (Exception $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}