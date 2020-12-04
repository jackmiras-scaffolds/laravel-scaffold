<?php

namespace App\Exceptions\Renderables;

use App\Models\Error;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

trait ValidationExceptionRender
{
    public function renderValidation(ValidationException $e): Response
    {
        $error = resolve(Error::class);
        $error->help = $e->validator->errors()->first();
        $error->message = trans('exception.data_validation');

        return response($error->toJson(), Response::HTTP_BAD_REQUEST);
    }
}
