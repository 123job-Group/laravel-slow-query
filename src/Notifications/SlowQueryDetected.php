<?php

namespace Vormkracht10\SlowQuery\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class SlowQueryDetected extends Notification
{
    use Queueable;

    public $deployment;

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
            '☝🏻',
        ]);

        $message .= ' Slow query has been detected on **' . config('app.name') . '**';

        return DiscordMessage::create($message, [
            'title' => config('app.name'),
            'color' => '3066993',
            'fields' => [
                [
                    'name' => 'SQL',
                    'value' => $this->query->sql,
                    'inline' => false,
                ], [
                    'name' => 'Time run',
                    'value' => $this->query->time,
                    'inline' => false,
                ],
            ],
            // 'url' => request()->fullUrlWithQuery(),
        ]);
    }
}
