<?php

namespace Vormkracht10\LaravelSlowQuery\Tests;

use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase;
use Vormkracht10\LaravelSlowQuery\Events\QueryExecutedSlowly;
use Vormkracht10\LaravelSlowQuery\LaravelSlowQueryServiceProvider;
use Vormkracht10\LaravelSlowQuery\Query;

class SlowQueryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Your code here
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
    }

    protected function getPackageProviders($app)
    {
        return [LaravelSlowQueryServiceProvider::class];
    }

    public function test_when_event_dispatches_notification_will_be_sent()
    {
        // Event::fake();

        $query = new Query('SELECT * FROM customers', [], 2000, 'default');

        event(new QueryExecutedSlowly($query));

        // Event::assertDispatched(QueryExecutedSlowly::class, function ($event) use ($query) {
        //     return $event->query->sql == $query->sql;
        // });
    }
}
