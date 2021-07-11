<?php

declare(strict_types=1);

namespace App\UI\Web;

use App\Application\Command\Department\AddNewDepartmentCommand;
use App\Application\Command\Department\AddNewDepartmentHandler;
use App\UI\Web\Request\AddNewDepartmentRequest;
use App\UI\Web\Response\CreatedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AddNewDepartmentAction extends AbstractController
{
    public function __construct(private AddNewDepartmentHandler $handler){}

    public function __invoke(Request $serverRequest): Response
    {
        $request = AddNewDepartmentRequest::fromRequest($serverRequest);

        $id = $this->handler->handle(
            new AddNewDepartmentCommand($request->getName(), $request->getExtraPayType(), $request->getExtraPayValue())
        );

        return CreatedResponse::respond($id);
    }
}