<?php

namespace App\Exceptions\Renderables;

use App\Models\Error;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ModelNotFoundExceptionRender
{
    public function renderModelNotFound(ModelNotFoundException $e): Response
    {
        $replacement = [
            'id' => Arr::first($e->getIds()),
            'model' => Arr::last(explode('\\', $e->getModel())),
        ];

        $error = resolve(Error::class);
        $error->help = trans('exception.model_not_found.help');
        $error->message = trans('exception.model_not_found.error', $replacement);

        return response($error->toJson(), Response::HTTP_NOT_FOUND);
    }
}
