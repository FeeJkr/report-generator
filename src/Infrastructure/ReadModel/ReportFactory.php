<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel;

use App\Application\Query\PayrollReport\ViewModel\Report;
use App\Application\Query\PayrollReport\ViewModel\ReportItem;
use JetBrains\PhpStorm\Pure;

final class ReportFactory
{
    public static function makeReport(array $rows): Report
    {
        $report = new Report;

        foreach ($rows as $row) {
            $report->add(self::makeReportItem($row));
        }

        return $report;
    }

    #[Pure]
    private static function makeReportItem(array $row): ReportItem
    {
        return new ReportItem(
            $row['first_name'],
            $row['last_name'],
            $row['department_name'],
            (float) $row['basic_salary'],
            (float) $row['extra_pay'],
            $row['extra_pay_type'],
        );
    }
}