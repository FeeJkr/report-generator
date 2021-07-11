<?php

declare(strict_types=1);

namespace App\UI\Web\Request;

use Symfony\Component\HttpFoundation\Request as ServerRequest;

abstract class Request
{
    abstract public static function fromRequest(ServerRequest $request): self;
}