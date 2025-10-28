<?php
// config/config.php

return [
    'app' => [
        'name' => 'TicketFlow',
        'url' => 'http://localhost',
        'debug' => true
    ],
    'session' => [
        'lifetime' => 24 * 60 * 60, // 24 hours
        'name' => 'ticketapp_session'
    ],
    'paths' => [
        'templates' => __DIR__ . '/../templates',
        'cache' => __DIR__ . '/../cache'
    ]
];

