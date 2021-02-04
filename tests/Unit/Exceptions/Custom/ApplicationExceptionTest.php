<?php

namespace Tests\Unit\Exceptions\Custom;

use Illuminate\Http\Response;
use App\Exceptions\Custom\ApplicationException;

beforeEach(function () {
    $this->appException = new class extends ApplicationException{
        public function status(): int
        {
            return Response::HTTP_BAD_REQUEST;
        }

        public function help(): string
        {
            return 'Anonymous help';
        }

        public function error(): string
        {
            return 'Anonymous error';
        }
    };
});

it('expects render to return a response instance when invoked', function () {
    $response = $this->appException->render(request());

    expect($response)->toBeInstanceOf(Response::class);
});

it('expects status code 400 when expection is thrown', function () {
    $status = $this->appException->status();

    expect($status)->toBe(Response::HTTP_BAD_REQUEST);
});

it('expects help to be anonymous help when expection is thrown', function () {
    $help = $this->appException->help();

    expect($help)->toBe('Anonymous help');
});

it('expects error to be anonymous error when expection is thrown', function () {
    $error = $this->appException->error();

    expect($error)->toBe('Anonymous error');
});
