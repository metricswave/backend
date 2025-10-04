<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * The database connections that should have transactions.
     *
     * @var array<int, string>
     */
    protected $connectionsToTransact = ['mysql', 'visits'];
}
