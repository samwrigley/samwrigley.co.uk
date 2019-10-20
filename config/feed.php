<?php

return [
    'feeds' => [
        'main' => [
            'items' => \App\Article::class . '@getFeedItems',
            'url' => '/feed',
            'title' => "Sam Wrigley's Blog",
            'description' => 'The rabblings of a Front-End Developer. Covering HTML, CSS, JavaScript and PHP.',
            'language' => 'en-GB',
        ],
    ],
];
