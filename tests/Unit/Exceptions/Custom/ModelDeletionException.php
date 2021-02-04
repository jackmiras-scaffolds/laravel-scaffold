<?php

namespace Tests\Unit\Exceptions\Custom;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Exceptions\Custom\ModelDeletionException;

beforeEach(function () {
    $this->id = 1;
    $this->model = 'App\Models\User';
    $this->modelDeletionException = new ModelDeletionException($this->id, $this->model);
});

it('expects render to return a response instance when invoked', function () {
    $response = $this->modelDeletionException->render(request());

    expect($response)->toBeInstanceOf(Response::class);
});

it('expects status code 400 when expection is thrown', function () {
    $status = $this->modelDeletionException->status();

    expect($status)->toBe(Response::HTTP_BAD_REQUEST);
});

it('expects help to be anonymous help when expection is thrown', function () {
    $help = $this->modelDeletionException->help();

    expect($help)->toBe(trans('exception.model_not_deleted.help'));
});

it('expects error to be anonymous error when expection is thrown', function () {
    $error = $this->modelDeletionException->error();
    $replace = ['id' => $this->id, 'model' => Str::afterLast($this->model, '\\')];

    expect($error)->toBe(trans('exception.model_not_deleted.message', $replace));
});
