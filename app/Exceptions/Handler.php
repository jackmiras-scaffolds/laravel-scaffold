<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use App\Exceptions\Renderables\ServerErrorRender;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\Renderables\ValidationExceptionRender;
use App\Exceptions\Renderables\ModelNotFoundExceptionRender;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ServerErrorRender;
    use ValidationExceptionRender;
    use ModelNotFoundExceptionRender;

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
     * @var array
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
            return $this->renderValidation($e);
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->renderModelNotFound($e);
        }

        if ($e->getCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
            return $this->renderInternalServerError($e);
        }

        return parent::render($request, $e);
    }
}
