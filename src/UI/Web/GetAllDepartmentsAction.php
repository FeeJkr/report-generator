<?php

declare(strict_types=1);

namespace App\UI\Web;

use App\Application\Query\Department\GetAllDepartmentsHandler;
use App\UI\Web\Response\GetAllDepartmentsResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class GetAllDepartmentsAction extends AbstractController
{
    public function __construct(private GetAllDepartmentsHandler $handler){}

    public function __invoke(): Response
    {
        $departments = $this->handler->handle();

        return GetAllDepartmentsResponse::respond($departments);
    }
}