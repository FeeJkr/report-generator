<?php

declare(strict_types=1);

namespace App\UI\Web\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class ErrorResponse extends JsonResponse
{
    public static function respond(array $response, int $statusCode): self
    {
        return new self($response, $statusCode);
    }
}