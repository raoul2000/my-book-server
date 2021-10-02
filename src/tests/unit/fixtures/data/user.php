<?php
$password_hash = '$2y$13$hPJTrfs4csFBj58qfs6qAunbv/LXgtXG39nbtLf/H5g6m3qB2H1X2'; // pwd = "password"

return [
    'admin' => [
        'id'            => 1,
        'username'      => 'admin',
        'email'         => 'admin@email.com',
        'password_hash' => '$2y$13$P/okCIsogd514o21zpBT8uNALHfYyjgeY4.u4EdeovdIbbayrhSka',
        'status'        => 10 // STATUS_ACTIVE
    ],
    'bob' => [
        'id'            => 2,
        'username'      => 'bob',
        'email'         => 'bob@email.com',
        'password_hash' => $password_hash,
        'status'        => 10 // STATUS_ACTIVE
    ],
    'tom' => [
        'id'            => 3,
        'username'      => 'tom',
        'email'         => 'tom@email.com',
        'password_hash' => $password_hash,
        'status'        => 1 // STATUS_INACTIVE
    ]
];