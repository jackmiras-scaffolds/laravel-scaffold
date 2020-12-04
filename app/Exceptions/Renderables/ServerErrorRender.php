<?php

namespace App\Exceptions\Renderables;

use Throwable;
use App\Models\Error;
use Illuminate\Http\Response;

trait ServerErrorRender
{
    public function renderInternalServerError(Throwable $e): Response
    {
        $error = resolve(Error::class);
        $error->message = 'server_error';
        $error->help = $e->getMessage() ?? get_class($e);

        return response($error->toJson(), Response::HTTP_BAD_REQUEST);
    }
}
