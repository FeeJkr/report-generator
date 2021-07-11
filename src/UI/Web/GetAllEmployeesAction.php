<?php

declare(strict_types=1);

namespace App\UI\Web;

use App\Application\Query\Employee\GetAllEmployeesHandler;
use App\UI\Web\Response\GetAllEmployeesResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class GetAllEmployeesAction extends AbstractController
{
    public function __construct(private GetAllEmployeesHandler $handler){}

    public function __invoke(): Response
    {
        $employees = $this->handler->handle();

        return GetAllEmployeesResponse::respond($employees);
    }
}