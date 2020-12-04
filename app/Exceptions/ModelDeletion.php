<?php

namespace App\Exceptions;

use Illuminate\Support\Str;
use Illuminate\Http\Response;

class ModelDeletion extends ApplicationException
{
    private int $id;
    private string $model;

    public function __construct(int $id, string $model)
    {
        $this->id = $id;
        $this->model = $model;
    }

    public function code(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function help(): string
    {
        return trans('exception.model_not_deleted.help');
    }

    public function message(): string
    {
        $modelName = Str::afterLast($this->model, '\\');
        $replacement = ['model' => $modelName, 'id' => $this->id];
        return trans('exception.model_not_updated.message', $replacement);
    }
}
