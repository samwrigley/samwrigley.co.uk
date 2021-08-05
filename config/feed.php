<?php

use App\Models\Article;

return [
    'feeds' => [
        'main' => [
            'items' => [Article::class, 'getFeedItems'],
            'url' => '/feed',
            'title' => "Sam Wrigley's Blog",
            'description' => 'The rabblings of a Front-End Developer. Covering HTML, CSS, JavaScript and PHP.',
            'language' => 'en-GB',
            'format' => 'atom',
            'view' => 'feed::atom',
        ],
    ],
];
