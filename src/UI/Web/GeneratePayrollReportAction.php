<?php

declare(strict_types=1);

namespace App\UI\Web;

use App\Application\Query\PayrollReport\GeneratePayrollReportHandler;
use App\Application\Query\PayrollReport\GeneratePayrollReportQuery;
use App\UI\Web\Request\GeneratePayrollReportRequest;
use App\UI\Web\Response\GeneratePayrollReportResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GeneratePayrollReportAction extends AbstractController
{
    public function __construct(private GeneratePayrollReportHandler $handler){}

    public function __invoke(Request $serverRequest): Response
    {
        $request = GeneratePayrollReportRequest::fromRequest($serverRequest);

        $report = $this->handler->handle(
            new GeneratePayrollReportQuery(
                $request->getSort(),
                $request->getFilters()
            )
        );

        return GeneratePayrollReportResponse::respond($report);
    }
}
