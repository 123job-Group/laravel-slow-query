<?php

namespace Vormkracht10\SlowQuery\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class SlowQueryDetected extends Notification
{
    use Queueable;

    public function __construct(QueryExecuted $query)
    {
        $this->query = $query;
    }

    public function via()
    {
        return [DiscordChannel::class];
    }

    public function toDiscord()
    {
        $message = Arr::random([
            '☝🏻', '⚠️', '❗️', '🚨', '🤖',
        ]);

        $message .= ' Slow query has been detected on **' . Config::get('app.name') . '**';
        $additional = [];

        if (!App::runningInConsole()) {
            $url = Request::fullUrl();

            $additional = [
                'url' => $url,
            ];
        }

        return DiscordMessage::create($message, array_merge([
            'title' => Config::get('app.name'),
            'color' => '15105570',
            'fields' => [
                [
                    'name' => 'SQL',
                    'value' => $this->query->sql,
                    'inline' => false,
                ], [
                    'name' => 'Time run',
                    'value' => ($this->query->time / 1000) . ' seconds',
                    'inline' => false,
                ], [
                    'name' => 'URL',
                    'value' => $url ?? 'Console',
                    'inline' => false,
                ],
            ],
        ], $additional));
    }
}
