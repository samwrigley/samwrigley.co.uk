<?php

return [

    'slack' => [
        'queue' => env('SLACK_QUEUE_WEBHOOK_URL'),
        'contact' => env('SLACK_CONTACT_WEBHOOK_URL'),
    ],

];
