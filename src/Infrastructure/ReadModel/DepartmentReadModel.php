<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel;

use App\Application\Query\Department\DepartmentReadModel as DepartmentReadModelInterface;
use App\Application\Query\Department\ViewModel\Department;
use App\Application\Query\Department\ViewModel\DepartmentsCollection;
use App\Application\Query\Exception\NotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Doctrine\DBAL\Exception;
use RuntimeException;

final class DepartmentReadModel implements DepartmentReadModelInterface
{
    public function __construct(private Connection $connection){}

    public function getDepartmentById(string $id): Department
    {
        try {
            $row = $this->connection
                ->createQueryBuilder()
                ->select([
                    'id',
                    'name',
                    'extra_pay_type',
                    'extra_pay_value',
                ])
                ->from('departments')
                ->where('id = :id')
                ->setParameter('id', $id)
                ->execute()
                ->fetchAssociative();

            if ($row === false) {
                throw new NotFoundException(sprintf('Department with id (%s) not found.', $id));
            }

            return new Department(
                $row['id'],
                $row['name'],
                $row['extra_pay_type'],
                (float) $row['extra_pay_value'],
            );
        } catch (Exception|DBALDriverException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function getAllDepartments(): DepartmentsCollection
    {
        try {
            $rows = $this->connection
                ->createQueryBuilder()
                ->select([
                    'id',
                    'name',
                    'extra_pay_type',
                    'extra_pay_value',
                ])
                ->from('departments')
                ->execute()
                ->fetchAllAssociative();

            return new DepartmentsCollection(
                ...array_map(
                    static fn(array $row): Department => new Department(
                        $row['id'],
                        $row['name'],
                        $row['extra_pay_type'],
                        (float) $row['extra_pay_value']
                    ),
                    $rows
                )
            );
        } catch (Exception|DBALDriverException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}