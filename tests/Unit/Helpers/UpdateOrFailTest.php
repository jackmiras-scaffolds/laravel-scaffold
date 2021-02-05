<?php

use App\Exceptions\ModelUpdatingException;
use App\Helpers\UpdateOrFail;
use App\Models\User;

beforeEach(function () {
    $this->userId = 1;
});

it('expects exception to be thrown when update fails', function () {
    $user = Mockery::mock(User::class);
    $user->shouldReceive('fill')->andReturn($user);
    $user->shouldReceive('update')->andReturn(false);

    $trait = Mockery::mock(UpdateOrFail::class)->shouldAllowMockingProtectedMethods();
    $trait->shouldReceive('findOrFail')->andReturn($user);

    $trait->updateOrFail($this->userId, User::factory()->make()->toArray());
})->throws(ModelUpdatingException::class);

it('expects true to be returned when update succeeds', function () {
    $user = Mockery::mock(User::class);
    $user->shouldReceive('update')->andReturn(true);
    $user->shouldReceive('fill')->andReturn($user);

    $mock = Mockery::mock(UpdateOrFail::class)->shouldAllowMockingProtectedMethods();
    $mock->shouldReceive('findOrFail')->andReturn($user);

    $updated = $mock->updateOrFail($this->userId, User::factory()->make()->toArray());

    expect($updated)->toBe(true);
});
