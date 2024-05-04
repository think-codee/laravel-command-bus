<?php

declare(strict_types=1);

return [
    'buses' => [
        'default' => [
            'class' => null,
            'interface' => null,
            'alias' => 'bus.default',
            'middleware' => [

            ],
            'handler_resolver' => \ThinkCodee\Laravel\CommandBus\Resolvers\SuffixHandlerResolver::class,
            'handler_method' => 'handle',
        ],
    ]
];
