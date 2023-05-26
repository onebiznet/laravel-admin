<?php

return [
    'route' => [
        'as' => 'admin.',
        'domain' => null,
        'prefix' => 'admin',
        'middleware' => ['web', 'auth', OneBiznet\Admin\Middleware\AdminAccess::class]
    ]
];