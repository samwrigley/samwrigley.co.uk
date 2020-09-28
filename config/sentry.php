<?php

return [

    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    'release' => trim(exec('git --git-dir ' . base_path('.git') . ' log --pretty="%h" -n1 HEAD')),

    'environment' => env('SENTRY_ENVIRONMENT'),

    'breadcrumbs' => [
        'logs' => true,
        'sql_queries' => true,
        'sql_bindings' => true,
        'queue_info' => true,
        'command_info' => true,
    ],

    // @see: https://docs.sentry.io/error-reporting/configuration/?platform=php#send-default-pii
    'send_default_pii' => false,

    'traces_sample_rate' => \floatval(env('SENTRY_TRACES_SAMPLE_RATE', 0.0)),

];
