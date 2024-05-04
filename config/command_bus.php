<?php

declare(strict_types=1);

return [
    'buses' => [
        'default' => [
            'class' => null,
            'interface' => null,
            'alias' => 'bus.default',
            'middleware' => [
                'method' => 'handle'
            ],
            'handler_resolver' => \ThinkCodee\Laravel\CommandBus\Handler\SuffixHandlerResolver::class,
            'handler_method' => 'handle',
        ],
    ]
];
