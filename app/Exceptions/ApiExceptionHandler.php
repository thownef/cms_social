<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Throwable $e): JsonResponse
    {
        $statusCode = JsonResponse::HTTP_BAD_REQUEST;
        $message = $e->getMessage();
        $errors = null;

        switch (true) {
            case $e instanceof HttpException:
                $statusCode = $e->getStatusCode();
                $message = $e->getMessage();
                break;
            case $e instanceof ConflictHttpException:
                $statusCode = JsonResponse::HTTP_CONFLICT;
                $message = $e->getMessage();
                break;
            case $e instanceof ValidationException:
                $statusCode = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
                $message = 'Validation failed';
                $errors = $e->validator->errors();
                break;
            case $e instanceof NotFoundHttpException:
                $statusCode = JsonResponse::HTTP_NOT_FOUND;
                $message = 'Resource not found';
                break;
            case $e instanceof ModelNotFoundException:
                $statusCode = JsonResponse::HTTP_NOT_FOUND;
                $message = 'Model not found';
                break;
            case $e instanceof MissingAbilityException:
            case $e instanceof AuthorizationException:
                $statusCode = JsonResponse::HTTP_FORBIDDEN;
                $message = 'Access denied';
                break;
            case $e instanceof AuthenticationException:
                $statusCode = JsonResponse::HTTP_UNAUTHORIZED;
                $message = 'Unauthenticated';
                break;
            case $e instanceof AccessDeniedHttpException:
                $statusCode = JsonResponse::HTTP_FORBIDDEN;
                $message = 'Access denied';
                break;
            default:
                $statusCode = JsonResponse::HTTP_BAD_REQUEST;
                $message = 'Bad Request';
                break;
        }

        return $this->makeJsonResponse(code: $statusCode, message: $message, errors: $errors);
    }

    private function makeJsonResponse(int $code, string $message, $errors): JsonResponse
    {
        $response = [
            'status' => $code,
            'message' => $message,
        ];

        if (! empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
