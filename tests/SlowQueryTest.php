<?php

namespace Vormkracht10\SlowQuery\Tests;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase;
use Vormkracht10\SlowQuery\Events\QueryExecutedSlowly;
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
        $app['config']->set('services.discord', [
            'token' => env('DISCORD_TOKEN'),
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [SlowQueryServiceProvider::class];
    }

    public function test_when_event_dispatches_notification_will_be_sent()
    {
        // wip

        Event::fake();

        $query = (new QueryExecuted('', [], 1000, DB::connection()));

        event(new QueryExecutedSlowly($query));

        Event::assertDispatched(QueryExecutedSlowly::class, function ($event) use ($query) {
            return $event->query->sql == $query->sql;
        });
    }
}
