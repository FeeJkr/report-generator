<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel;

use App\Application\Query\FiltersCollection;
use App\Application\Query\PayrollReport\GeneratePayrollReportQuery;
use App\Application\Query\PayrollReport\PayrollReportReadModel as PayrollReportReadModelInterface;
use App\Application\Query\PayrollReport\ViewModel\Report;
use App\Application\Query\Sort;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use RuntimeException;

final class PayrollReportReadModel implements PayrollReportReadModelInterface
{
    private const FILTER_FIELDS_MAP = [
        'first_name' => 'e.first_name',
        'last_name' => 'e.last_name',
        'department' => 'd.name',
    ];

    private const SORT_FIELDS_MAP = [
        'first_name' => 'e.first_name',
        'last_name' => 'e.last_name',
        'department' => 'd.name',
        'basic_salary' => 'e.salary',
        'extra_pay' => 'extra_pay',
        'extra_pay_type' => 'd.extra_pay_type',
        'salary' => '(extra_pay + basic_salary)'
    ];

    public function __construct(private Connection $connection){}

    public function getReport(GeneratePayrollReportQuery $query): Report
    {
        try {
            $queryBuilder = $this
                ->connection
                ->createQueryBuilder()
                ->select([
                    'e.first_name',
                    'e.last_name',
                    'd.name as department_name',
                    'e.salary as basic_salary',
                    "
                        (CASE d.extra_pay_type
                            WHEN 'const' THEN 
                                IF(
                                    YEAR(NOW()) - YEAR(e.employed_at) > 10, 
                                    d.extra_pay_value * 10, 
                                    d.extra_pay_value * (YEAR(NOW()) - YEAR(e.employed_at))
                                )
                            WHEN 'percentage' THEN 
                                e.salary * (d.extra_pay_value / 100)
                        END) AS extra_pay
                    ",
                    'd.extra_pay_type',
                ])
                ->from('employees', 'e')
                ->join('e', 'departments', 'd', 'e.department_id = d.id');

            $this->addFilters($queryBuilder, $query->getFilters());
            $this->addSort($queryBuilder, $query->getSort());

            $rows = $queryBuilder
                ->execute()
                ->fetchAllAssociative();

            return ReportFactory::makeReport($rows);
        } catch (Exception|DBALDriverException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    private function addFilters(QueryBuilder $queryBuilder, FiltersCollection $filters): void
    {
        foreach ($filters->toArray() as $filter) {
            if (!array_key_exists($filter->getFieldName(), self::FILTER_FIELDS_MAP)) {
                continue;
            }

            $queryBuilder
                ->andWhere(self::FILTER_FIELDS_MAP[$filter->getFieldName()] . ' like :' . $filter->getFieldName())
                ->setParameter($filter->getFieldName(), "%{$filter->getValue()}%");
        }
    }

    private function addSort(QueryBuilder $queryBuilder, ?Sort $sort): void
    {
        if ($sort !== null && array_key_exists($sort->getColumnName(), self::SORT_FIELDS_MAP)) {
            $queryBuilder->addOrderBy(self::SORT_FIELDS_MAP[$sort->getColumnName()], $sort->getOrder());
        }
    }
}