<?php

declare(strict_types=1);

namespace App\Tests\Integration\PayrollReport;

use App\Tests\Integration\BaseTestCase;
use DateInterval;
use DateTime;

final class GeneratePayrollReportTest extends BaseTestCase
{
    private const ENDPOINT = '/api/payroll/report';

    public function basicReportDataProvider(): array
    {
        return [
            [
                'departmentConfiguration' => [
                    'name' => 'HR',
                    'extraPayType' => 'const',
                    'extraPayValue' => 100,
                ],
                'employeeConfiguration' => [
                    'firstName' => 'Adam',
                    'lastName' => 'Kowalski',
                    'salary' => 1000,
                    'employedAt' => (new DateTime)->sub(new DateInterval('P10Y1D')),
                ],
                'report' => [
                    'first_name' => 'Adam',
                    'last_name' => 'Kowalski',
                    'department' => 'HR',
                    'basic_salary' => 1000,
                    'extra_pay' => 1000,
                    'extra_pay_type' => 'const',
                    'salary' => 2000,
                ]
            ],
            [
                'departmentConfiguration' => [
                    'name' => 'BOK',
                    'extraPayType' => 'percentage',
                    'extraPayValue' => 10,
                ],
                'employeeConfiguration' => [
                    'firstName' => 'Ania',
                    'lastName' => 'Nowak',
                    'salary' => 1100,
                    'employedAt' => (new DateTime)->sub(new DateInterval('P5Y1D')),
                ],
                'report' => [
                    'first_name' => 'Ania',
                    'last_name' => 'Nowak',
                    'department' => 'BOK',
                    'basic_salary' => 1100,
                    'extra_pay' => 110,
                    'extra_pay_type' => 'percentage',
                    'salary' => 1210,
                ]
            ],
        ];
    }

    /**
     * @test
     * @dataProvider basicReportDataProvider
     */
    public function shouldGenerateReportWithoutSortAndFilters(
        array $departmentConfiguration,
        array $employeeConfiguration,
        array $report
    ): void {
        $department = $this->getDepartmentMother()->createNewDepartment(
            $departmentConfiguration['name'],
            $departmentConfiguration['extraPayType'],
            $departmentConfiguration['extraPayValue'],
        );
        $this->getEmployeeMother()->createNewEmployee(
            $department['id'],
            $employeeConfiguration['firstName'],
            $employeeConfiguration['lastName'],
            $employeeConfiguration['salary'],
            $employeeConfiguration['employedAt'],
        );

        $response = $this->get(self::ENDPOINT);

        self::assertEquals($report, json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR)[0]);
    }
}