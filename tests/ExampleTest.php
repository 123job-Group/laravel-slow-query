<?php

namespace Vormkracht10\LaravelSlowQuery\Tests;

use Orchestra\Testbench\TestCase;
use Vormkracht10\LaravelSlowQuery\LaravelSlowQueryServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelSlowQueryServiceProvider::class];
    }
}
