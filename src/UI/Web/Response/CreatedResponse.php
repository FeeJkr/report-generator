<?php

declare(strict_types=1);

namespace App\UI\Web\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CreatedResponse
{
    public static function respond(string $id): Response
    {
        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }
}