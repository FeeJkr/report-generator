<?php

declare(strict_types=1);

namespace App\Application\Query\PayrollReport;

use App\Application\Query\PayrollReport\ViewModel\Report;

final class GeneratePayrollReportHandler
{
    public function __construct(private PayrollReportReadModel $repository){}

    public function handle(GeneratePayrollReportQuery $query): Report
    {
        return $this->repository->getReport($query);
    }
}
