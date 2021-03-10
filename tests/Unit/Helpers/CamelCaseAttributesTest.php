<?php

use App\Models\User;
use App\Exceptions\AttributeNotExistsException;

beforeEach(function () {
    $this->user = new User();
});

it('expects getAttribute to return value when the key is CamelCase', function () {
    $this->user->last_name = 'Miras';

    $returnment = $this->user->getAttribute('lastName');

    expect($returnment)->toBe($this->user->last_name);
});

it('expects getAttribute to throw an exception when the key not exist', function () {
    $this->user->getAttribute('unexistent_attribute');
})->throws(AttributeNotExistsException::class);

it('expects exception when an attribute doesn\'t exists on the model', function () {
    $returnment = $this->user->setAttribute('unexistent_attribute', 'value');

    expect($returnment)->toBeInstanceOf(User::class);
})->throws(AttributeNotExistsException::class);

it('expects User instance when an attribute exists on the model', function () {
    $returnment = $this->user->setAttribute('lastName', 'Miras');

    expect($returnment)->toBeInstanceOf(User::class);
});
