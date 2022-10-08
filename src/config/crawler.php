<?php

return [

    'uri' => env('CRAWL_UI_ENDPOINT', 'crawl'),

    'save_query' => env('CRAWLER_SAVE_QUERY', false),

    'security' => [

        'ip' => env('CRAWLER_SECURITY_IP', false),
        'ip_whitelist' => [
            '127.0.0.1'
        ],

        'user_agent' => env('CRAWLER_SECURITY_USER_AGENT', false),
        'user_agent_whitelist' => [
            'chrome'
        ],

        'referer' => env('CRAWLER_SECURITY_REFERER', false),
        'referer_whitelist' => [
            'tester.com'
        ],
    ],

    'storage' => [
        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
            'chunk' => 1000,
        ],
    ],

];
