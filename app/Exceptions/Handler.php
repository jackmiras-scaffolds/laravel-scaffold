<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    // public function register()
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //
    //     });
    // }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        //TODO: Check if this function can be replaced by the register(...) function [Fri Dec 17 09:56:55 2021]
        if ($e instanceof ValidationException) {
            $error = new Error(
                help: $e->validator->errors()->first(),
                error: trans('exception.data_validation')
            );

            return response($error->toArray(), Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof ModelNotFoundException) {
            $replacement = [
                'id' => collect($e->getIds())->first(),
                'model' => Arr::last(explode('\\', $e->getModel())),
            ];

            $error = new Error(
                help: trans('exception.model_not_found.help'),
                error: trans('exception.model_not_found.error', $replacement)
            );

            return response($error->toArray(), Response::HTTP_NOT_FOUND);
        }

        if ($e->getCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
            $error = new Error($e->getMessage() ?: get_class($e), 'server_error');
            return response($error->toArray(), Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $e);
    }
}
