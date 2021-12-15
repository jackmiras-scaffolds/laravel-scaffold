<?php

namespace Tests\Feature;

use Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

it('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
