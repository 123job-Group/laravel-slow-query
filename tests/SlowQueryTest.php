<?php

namespace Vormkracht10\SlowQuery\Tests;

use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase;
use Vormkracht10\SlowQuery\Events\QueryExecutedSlowly;
use Vormkracht10\SlowQuery\Query;
use Vormkracht10\SlowQuery\SlowQueryServiceProvider;

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
        return [SlowQueryServiceProvider::class];
    }

    public function test_when_event_dispatches_notification_will_be_sent()
    {
        // Event::fake();

        event(new QueryExecutedSlowly());

        // Event::assertDispatched(QueryExecutedSlowly::class, function ($event) use ($query) {
        //     return $event->query->sql == $query->sql;
        // });
    }
}
