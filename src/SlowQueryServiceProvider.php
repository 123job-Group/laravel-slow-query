<?php

namespace Vormkracht10\SlowQuery;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Vormkracht10\SlowQuery\Events\QueryExecutedSlowly;
use Vormkracht10\SlowQuery\Notifications\SlowQueryDetected;

class SlowQueryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/slow-query.php' => config_path('slow-query.php'),
        ], 'config');

        $this->setupEvents($this->app->events);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/slow-query.php', 'slow-query');
    }

    public function setupEvents($events)
    {
        $events->listen(QueryExecuted::class, function (QueryExecuted $query) {
            if ($this->slowQueryCheck($query)) {
                event(new QueryExecutedSlowly($query));
            }
        });

        $events->listen(QueryExecutedSlowly::class, function (QueryExecutedSlowly $event) {
            $provider = Config::get('slow-query.notifications.default');
            $channel = Config::get('slow-query.notifications.' . $provider . '.channel');

            Notification::route($provider, $channel)
                ->notify(new SlowQueryDetected($event->query));
        });
    }

    public function slowQueryCheck(QueryExecuted $query)
    {
        return $query->time >= Config::get('slow-query.treshold_in_ms');
    }
}
