<?php

declare(strict_types=1);

namespace App\UI\Web\Middleware;

use App\UI\Web\Response\ErrorResponse;
use Assert\InvalidArgumentException;
use Assert\LazyAssertionException;
use DomainException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use UnexpectedValueException;

final class ErrorHandlerMiddleware implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = match ($exception::class) {
            LazyAssertionException::class => ErrorResponse::respond(
                array_map(static fn(InvalidArgumentException $exception) => [
                    'errorMessage' => $exception->getMessage(),
                    'propertyPath' => $exception->getPropertyPath(),
                    'value' => $exception->getValue(),
                ], $exception->getErrorExceptions()),
                Response::HTTP_BAD_REQUEST,
            ),
            UnexpectedValueException::class => ErrorResponse::respond(
                ['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY
            ),
            DomainException::class => ErrorResponse::respond(
                ['error' => $exception->getMessage()], Response::HTTP_CONFLICT,
            ),
            default => ErrorResponse::respond(
                ['error' => 'Internal server error.'], Response::HTTP_INTERNAL_SERVER_ERROR
            ),
        };

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}