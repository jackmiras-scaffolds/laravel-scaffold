<?php

use App\Models\User;
use App\Helpers\DeleteOrFail;
use App\Exceptions\ModelDeletionException;

beforeEach(function () {
    $this->userId = 1;
});

it('expects exception to be throw when an update fails', function () {
    $user = Mockery::mock(User::class);
    $user->shouldReceive('fill')->andReturn($user);
    $user->shouldReceive('delete')->andReturn(false);

    $trait = Mockery::mock(DeleteOrFail::class)->shouldAllowMockingProtectedMethods();
    $trait->shouldReceive('findOrFail')->andReturn($user);

    $trait->deleteOrFail($this->userId);
})->throws(ModelDeletionException::class);

it('expects true to be returned when delete succeeds', function () {
    $user = Mockery::mock(User::class);
    $user->shouldReceive('fill')->andReturn($user);
    $user->shouldReceive('delete')->andReturn(true);

    $trait = Mockery::mock(DeleteOrFail::class)->shouldAllowMockingProtectedMethods();
    $trait->shouldReceive('findOrFail')->andReturn($user);

    $deleted = $trait->deleteOrFail($this->userId);

    expect($deleted)->toBe(true);
});
