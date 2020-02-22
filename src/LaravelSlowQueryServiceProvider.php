<?php

namespace Vormkracht10\LaravelSlowQuery;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;
use Vormkracht10\LaravelSlowQuery\Events\FoundSlowQuery;
use Vormkracht10\LaravelSlowQuery\Notifications\SlowQueryDetected;

class LaravelSlowQueryServiceProvider extends ServiceProvider
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
        if (class_exists(QueryExecuted::class)) {
            $events->listen(QueryExecuted::class, function (QueryExecuted $query) {
                $query = $this->makeQuery($query->sql, $query->bindings, $query->time, $query->connectionName);

                if ($this->slowQueryCheck($query)) {
                    event(FoundSlowQuery($query));
                }
            });
        }
    }

    public function makeQuery($sql, $bindings, $time, $connectionName)
    {
        return new Query($sql, $bindings, $time, $connectionName);
    }

    public function slowQueryCheck(Query $query)
    {
        return $query->time > config('slow-query.slow_query_treshold_in_ms');
    }
}
