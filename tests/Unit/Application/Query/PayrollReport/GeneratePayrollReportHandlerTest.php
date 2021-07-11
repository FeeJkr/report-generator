<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query\PayrollReport;

use App\Application\Query\FiltersCollection;
use App\Application\Query\PayrollReport\GeneratePayrollReportHandler;
use App\Application\Query\PayrollReport\GeneratePayrollReportQuery;
use App\Application\Query\PayrollReport\PayrollReportReadModel;
use App\Application\Query\PayrollReport\ViewModel\Report;
use App\Application\Query\PayrollReport\ViewModel\ReportItem;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class GeneratePayrollReportHandlerTest extends TestCase
{
    private PayrollReportReadModel|MockObject $payrollReportReadModelMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->payrollReportReadModelMock = $this->createMock(PayrollReportReadModel::class);
    }

    /**
     * @test
     */
    public function shouldGenerateReport(): void
    {
        $expectedData = new Report(
            new ReportItem('Test', 'Testing', 'HR', 123, 100, 'const'),
            new ReportItem('Test', 'Testing', 'HR', 123, 100, 'percentage'),
        );

        $this->payrollReportReadModelMock->expects(self::once())->method('getReport')->willReturn($expectedData);

        $result = $this->getSut()->handle(
            new GeneratePayrollReportQuery(null, new FiltersCollection()),
        );

        self::assertEquals($expectedData, $result);
    }

    #[Pure] public function getSut(): GeneratePayrollReportHandler
    {
        return new GeneratePayrollReportHandler(
            $this->payrollReportReadModelMock,
        );
    }
}