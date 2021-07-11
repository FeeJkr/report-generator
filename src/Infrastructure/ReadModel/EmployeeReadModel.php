<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel;

use App\Application\Query\Employee\EmployeeReadModel as EmployeeReadModelInterface;
use App\Application\Query\Employee\ViewModel\Employee;
use App\Application\Query\Employee\ViewModel\EmployeesCollection;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Doctrine\DBAL\Exception;
use RuntimeException;

final class EmployeeReadModel implements EmployeeReadModelInterface
{
    public function __construct(private Connection $connection){}

    public function getAllEmployees(): EmployeesCollection
    {
        try {
            $rows = $this
                ->connection
                ->createQueryBuilder()
                ->select([
                    'e.id',
                    'd.id as department_id',
                    'd.name as department_name',
                    'e.first_name',
                    'e.last_name',
                    'e.salary',
                    'e.employed_at'
                ])
                ->from('employees', 'e')
                ->join('e', 'departments', 'd', 'd.id = e.department_id')
                ->execute()
                ->fetchAllAssociative();

            return new EmployeesCollection(
                ...array_map(
                    static fn(array $row): Employee => new Employee(
                        $row['id'],
                        $row['department_id'],
                        $row['department_name'],
                        $row['first_name'],
                        $row['last_name'],
                        (float) $row['salary'],
                        DateTime::createFromFormat('Y-m-d H:i:s', $row['employed_at'])
                    ),
                    $rows
                )
            );
        } catch (Exception|DBALDriverException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}