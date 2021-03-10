<?php

namespace App\Exceptions;

use Exception;
use ErrorException;
use App\Helpers\ApiHelpers;
use Illuminate\Database\QueryException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return ApiHelpers::ApiResponse(401, 'Whoops!, the session has expired', $exception->getMessage());
        } elseif ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return ApiHelpers::ApiResponse(401, 'Whoops!, the token is invalid', $exception->getMessage());
        } elseif ($exception instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
            return ApiHelpers::ApiResponse(401, 'Whoops!, the token is absent', $exception->getMessage());
        } elseif($exception instanceof MethodNotAllowedHttpException){
            return ApiHelpers::ApiResponse(403, 'HTTP exception, method not allowed', $exception->getMessage());
        } elseif($exception instanceof NotFoundHttpException){
            return ApiHelpers::ApiResponse(404, 'HTTP exception, URL not found', $exception->getMessage());
        } elseif($exception instanceof ModelNotFoundException){
            return ApiHelpers::ApiResponse(404, 'Whoops, the resource does not exist in the model', $exception->getMessage());
        }elseif($exception instanceof \Illuminate\Database\QueryException){
            return ApiHelpers::ApiResponse(400, 'Whoops!, An error occurred during the request', $exception->getMessage());
        }elseif($exception instanceof FatalThrowableError){
            return ApiHelpers::ApiResponse(500, 'Whoops!', $exception->getMessage());
        }elseif($exception instanceof ErrorException){
           return ApiHelpers::ApiResponse(500, 'Whoops!', $exception->getMessage());
        }elseif($exception instanceof AccessDeniedHttpException){
            return ApiHelpers::ApiResponse(500, 'Whoops!', $exception->getMessage());
        }else {
            return parent::render($request, $exception);
        }
    }
}