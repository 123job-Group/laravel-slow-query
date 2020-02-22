<?php

namespace Vormkracht10\LaravelSlowQuery\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;
use Vormkracht10\LaravelSlowQuery\Query;

class SlowQueryDetected extends Notification
{
    use Queueable;

    public $deployment;

    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }

    public function toDiscord($notifiable)
    {
        $message = array_random([
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
