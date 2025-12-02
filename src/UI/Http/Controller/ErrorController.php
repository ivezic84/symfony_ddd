<?php

namespace App\UI\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Throwable;

class ErrorController extends AbstractController
{

    /**
     * Handles exceptions and returns JSON error responses.
     */
    public function show(Throwable $exception): JsonResponse
    {
        $statusCode = $this->determineStatusCode($exception);
        $message    = $this->determineMessage($exception, $statusCode);

        return $this->createErrorResponse($statusCode, $message);
    }


    /**
     * Determines the HTTP status code based on the exception type.
     */
    private function determineStatusCode(Throwable $exception): int
    {

        if (method_exists($exception, 'getStatusCode')) {
            return $exception->getStatusCode();
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return 403;
        }

        if ($exception instanceof UnprocessableEntityHttpException) {
            return 422;
        }

        if ($exception instanceof NotFoundHttpException) {
            return 404;
        }

        // Default to 500 - Internal Server Error
        return 500;
    }


    /**
     * Determines the error message based on the exception type.
     */
    private function determineMessage(Throwable $exception, int $statusCode): string
    {
        if ($exception instanceof UnprocessableEntityHttpException) {
            $previous = $exception->getPrevious();

            if ($previous instanceof ValidationFailedException) {
                return $this->formatValidationMessages($previous->getViolations());
            }

            return trim($exception->getMessage());
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return "Sie haben keine Berechtigung, auf diese Ressource zuzugreifen.";
        }

        if ($exception instanceof NotFoundHttpException) {
            $message = $exception->getMessage();
            return $message ?: "Route Not found!";
        }

        if ($exception instanceof \InvalidArgumentException) {
            return $exception->getMessage();
        }


        // Default message fallback
        $message = $exception->getMessage();
        return $message ?: $this->defaultMessageForStatusCode($statusCode);
    }


    /**
     * Formats validation violation messages into a single string.
     */
    private function formatValidationMessages($violations): string
    {
        $messages = [];
        foreach ($violations as $violation) {
            $field      = $violation->getPropertyPath();
            $error      = $violation->getMessage();
            $messages[] = sprintf('%s: %s', $field, $error);
        }
        return implode(' ', $messages);
    }


    /**
     * Provides default messages for common HTTP status codes.
     */
    private function defaultMessageForStatusCode(int $statusCode): string
    {
        return match ($statusCode) {
            404 => 'Not Found',
            422 => 'Unprocessable Entity',
            500 => 'Internal Server Error',
            default => 'An error occurred',
        };
    }

    /**
     * Creates a JSON response for the error.
     */
    private function createErrorResponse(int $statusCode, string $message): JsonResponse
    {
        return new JsonResponse([
            'error' => [
                'status'  => $statusCode,
                'message' => $message,
            ],
        ], $statusCode);
    }

}
