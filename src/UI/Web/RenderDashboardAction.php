<?php

declare(strict_types=1);

namespace App\UI\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class RenderDashboardAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('index.html.twig');
    }
}