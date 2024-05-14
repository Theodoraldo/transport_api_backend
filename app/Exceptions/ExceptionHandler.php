<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ExceptionHandler extends Exception
{
    public static function handleException(\Exception $e)
    {
        switch (true) {
            case $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException:
                $statusCode = Response::HTTP_NOT_FOUND;
                $customErrorMessage = 'Resource not found.';
                break;
            case $e instanceof \Illuminate\Validation\ValidationException:
                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $customErrorMessage = 'Validation failed.';
                break;
            case $e instanceof \Illuminate\Database\QueryException:
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $customErrorMessage = 'Database error occurred.';
                break;
            case $e instanceof \Symfony\Component\HttpKernel\Exception\BadRequestHttpException:
                $statusCode = Response::HTTP_BAD_REQUEST;
                $customErrorMessage = 'Bad request.';
                break;
            case $e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException:
                $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;
                $customErrorMessage = 'Method not allowed.';
                break;
            case $e instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException:
                $statusCode = Response::HTTP_UNAUTHORIZED;
                $customErrorMessage = 'Unauthorized.';
                break;
            case $e instanceof \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException:
                $statusCode = Response::HTTP_TOO_MANY_REQUESTS;
                $customErrorMessage = 'Too many requests.';
                break;
            case $e instanceof \Illuminate\Auth\Access\AuthorizationException ||
                $e instanceof \Illuminate\Database\Eloquent\MassAssignmentException ||
                $e instanceof \Illuminate\Validation\UnauthorizedException:
                $statusCode = Response::HTTP_FORBIDDEN;
                $customErrorMessage = 'Forbidden.';
                break;
            case $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException:
                $statusCode = Response::HTTP_NOT_FOUND;
                $customErrorMessage = 'Resource not found.';
                break;
            case $e instanceof \Illuminate\Routing\Exceptions\UrlGenerationException:
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $customErrorMessage = 'URL generation error.';
                break;
            default:
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $customErrorMessage = 'An unexpected error occurred.';
                break;
        }

        return response()->json(['status' => $statusCode, 'message' => $customErrorMessage], $statusCode);
    }
}
