<?php

declare(strict_types=1);

namespace App\Application\Query\PayrollReport;

use App\Application\Query\PayrollReport\ViewModel\Report;

interface PayrollReportReadModel
{
    public function getReport(GeneratePayrollReportQuery $query): Report;
}