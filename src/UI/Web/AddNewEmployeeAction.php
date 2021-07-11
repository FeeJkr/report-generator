<?php

declare(strict_types=1);

namespace App\UI\Web;

use App\Application\Command\Employee\AddNewEmployeeCommand;
use App\Application\Command\Employee\AddNewEmployeeHandler;
use App\UI\Web\Request\AddNewEmployeeRequest;
use App\UI\Web\Response\CreatedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AddNewEmployeeAction extends AbstractController
{
    public function __construct(private AddNewEmployeeHandler $handler){}

    public function __invoke(Request $serverRequest): Response
    {
        $request = AddNewEmployeeRequest::fromRequest($serverRequest);

        $id = $this->handler->handle(
            new AddNewEmployeeCommand(
                $request->getDepartmentId(),
                $request->getFirstName(),
                $request->getLastName(),
                $request->getSalary(),
                $request->getEmployedAt(),
            )
        );

        return CreatedResponse::respond($id);
    }
}