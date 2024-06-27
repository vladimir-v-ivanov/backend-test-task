<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $previous = $event->getThrowable()->getPrevious();

        if ($previous instanceof ValidationFailedException) {
            $errors[] = array_map(
                fn($violation) => "Invalid property {$violation->getPropertyPath()}. {$violation->getMessage()}",
                iterator_to_array($previous->getViolations())
            );
        } else {
            $errors = [$exception->getMessage()];
        }

        $response = new JsonResponse([
            'result' => false,
            'errors' => $errors
        ], 400);

        $event->allowCustomResponseCode();
        $event->setResponse($response);
    }
}
