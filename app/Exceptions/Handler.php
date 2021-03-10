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
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

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
        if ($e instanceof ValidationException) {
            $error = resolve(Error::class);
            $error->help = $e->validator->errors()->first();
            $error->error = trans('exception.data_validation');

            return response($error->toArray(), Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof ModelNotFoundException) {
            $ids = $e->getIds();

            $replacement = [
                'id' => is_int($ids) ? $ids : Arr::first($ids),
                'model' => Arr::last(explode('\\', $e->getModel())),
            ];

            $error = resolve(Error::class);
            $error->help = trans('exception.model_not_found.help');
            $error->error = trans('exception.model_not_found.error', $replacement);

            return response($error->toArray(), Response::HTTP_NOT_FOUND);
        }

        if ($e->getCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
            $error = resolve(Error::class);
            $error->error = 'server_error';
            $error->help = $e->getMessage() ?: get_class($e);

            return response($error->toArray(), Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $e);
    }
}
