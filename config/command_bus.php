<?php

declare(strict_types=1);

return [
    'buses' => [
        'default' => [
            'class' => \ThinkCodee\Laravel\CommandBus\Default\Bus::class,
            'interface' => \ThinkCodee\Laravel\CommandBus\Contracts\Bus::class,
            'alias' => 'bus.default',
            'middleware' => [],
            'handler_resolver' => \ThinkCodee\Laravel\CommandBus\Resolvers\SuffixHandlerResolver::class,
            'handler_method' => 'handle',
        ],
    ]
];
