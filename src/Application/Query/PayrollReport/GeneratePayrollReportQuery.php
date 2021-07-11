<?php

declare(strict_types=1);

namespace App\Application\Query\PayrollReport;

use App\Application\Query\FiltersCollection;
use App\Application\Query\Sort;

final class GeneratePayrollReportQuery
{
    public function __construct(private ?Sort $sort, private FiltersCollection $filters){}

    public function getSort(): ?Sort
    {
        return $this->sort;
    }

    public function getFilters(): FiltersCollection
    {
        return $this->filters;
    }
}