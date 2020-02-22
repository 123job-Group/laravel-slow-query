<?php

namespace Vormkracht10\SlowQuery;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Vormkracht10\SlowQuery\Events\QueryExecutedSlowly;
use Vormkracht10\SlowQuery\Notifications\SlowQueryDetected;
use Vormkracht10\SlowQuery\Query;

class SlowQueryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->setupEvents($this->app->events);
    }

    public function register()
    {
    }

    public function setupEvents($events)
    {
        $events->listen(QueryExecuted::class, function (QueryExecuted $query) {
            $query = $this->makeQuery($query->sql, $query->bindings, $query->time, $query->connectionName);

            if ($this->slowQueryCheck($query)) {
                event(QueryExecutedSlowly($query));
            }
        });

        $events->listen(QueryExecutedSlowly::class, function (QueryExecutedSlowly $event) {
            Notification::route('discord', '680703864172707841')
                ->notify(new SlowQueryDetected($event->query));
        });
    }

    public function makeQuery($sql, $bindings, $time, $connectionName)
    {
        return new Query($sql, $bindings, $time, $connectionName);
    }

    public function slowQueryCheck(Query $query)
    {
        return $query->time > Config::get('slow-query.slow_query_treshold_in_ms');
    }
}
