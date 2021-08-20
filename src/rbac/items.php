<?php

return [
    'administrate' => [
        'type' => 2,
        'description' => 'Administrate the system',
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'administrate',
        ],
    ],
];
