<?php

declare(strict_types=1);

namespace App\UI\Web\Response;

use App\Application\Query\PayrollReport\ViewModel\Report;
use App\Application\Query\PayrollReport\ViewModel\ReportItem;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GeneratePayrollReportResponse
{
    public static function respond(Report $report): Response
    {
        return new JsonResponse(
            array_map(
                static fn(ReportItem $item) => self::presentReportItem($item),
                $report->getItems()
            )
        );
    }

    #[Pure]
    #[ArrayShape([
        'first_name' => "string",
        'last_name' => "string",
        'department' => "string",
        'basic_salary' => "float",
        'extra_pay' => "float",
        'extra_pay_type' => "string",
        'salary' => "float"
    ])]
    private static function presentReportItem(ReportItem $item): array
    {
        return [
            'first_name' => $item->getEmployeeFirstName(),
            'last_name' => $item->getEmployeeLastName(),
            'department' => $item->getDepartmentName(),
            'basic_salary' => $item->getEmployeeBasicSalary(),
            'extra_pay' => $item->getEmployeeExtraPay(),
            'extra_pay_type' => $item->getEmployeeExtraPayType(),
            'salary' => $item->getEmployeeSalary(),
        ];
    }
}