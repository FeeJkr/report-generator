<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Department\Department;
use App\Domain\Department\DepartmentRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RuntimeException;

final class DepartmentDbRepository implements DepartmentRepository
{
    public function __construct(private Connection $connection){}

    public function store(Department $department): void
    {
        try {
            $snapshot = $department->getSnapshot();

            $this->connection->createQueryBuilder()
                ->insert('departments')
                ->values([
                    'id' => ':id',
                    'name' => ':name',
                    'extra_pay_type' => ':extraPayType',
                    'extra_pay_value' => ':extraPayValue',
                ])
                ->setParameters([
                    'id' => $snapshot->getId(),
                    'name' => $snapshot->getName(),
                    'extraPayType' => $snapshot->getExtraPaymentType(),
                    'extraPayValue' => $snapshot->getExtraPaymentValue(),
                ])
                ->execute();
        } catch (Exception $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}