<?php

return [
    /*
     * The threshold in milliseconds for a query to be slow
     */
    'treshold_in_ms' => 1000,
    /*
    * Notification settings
    */
    'notifications' => [
        'default' => 'discord',
        'discord' => [
            'channel' => null,
        ],
    ],
];
