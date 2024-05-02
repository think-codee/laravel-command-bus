<?php

declare(strict_types=1);


return [
    'buses' => [
        'command' => [
            'class' => null,
            'interface' => null,
            'alias' => 'bus.command',
            'middleware' => [],
            'handler_resolver' => null, //default SuffixHandlerResolver::class
            'handler_method' => null, //default handle
        ],
    ]
];
