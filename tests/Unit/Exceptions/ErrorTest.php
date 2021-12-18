<?php

use App\Exceptions\Error;

beforeEach(function () {
    $this->error = new Error();
});

it('expects error to match struct when JSON serializing', function () {
    $keys = array_keys([
        'error' => '',
        'help' => ''
    ]);

    expect($this->error->jsonSerialize())->toHaveKeys($keys);
});

it('expects error to match string when to json parsed', function () {
    $json = '{"error":"","help":""}';

    expect($this->error->toJson())->toBe($json);
});

it('expects error to match structure when to array transformed', function () {
    $keys = array_keys([
        'error' => '',
        'help' => ''
    ]);

    expect($this->error->toArray())->toHaveKeys($keys);
});
