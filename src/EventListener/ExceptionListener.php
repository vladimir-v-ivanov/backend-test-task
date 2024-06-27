<?php

namespace App\EventListener;

use App\Exception\EntityValidationViolation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use function Symfony\Component\DependencyInjection\Loader\Configurator\iterator;

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
        ]);

        $event->allowCustomResponseCode();
        $event->setResponse($response);
    }
}