<?php

use Griz\Telegram\Service\Container;

return [
    'controllers' => [
        'value' => [
            'defaultNamespace' => '\\Griz\\Telegram\\Controller',
        ],
        'readonly' => true,
    ],
    'services' => [
        'griz.telegram.service.container' => [
            'className' => Container::class
        ]
    ],
];