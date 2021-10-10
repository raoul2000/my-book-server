<?php

return [
    'app' => [
        /**
         * Name and Email of the sender of all email
         */
        'senderEmail'  => 'Raoul@ass-team.fr',
        'senderName'   => 'Raoul',
        'saveBookPing' => true,
        /**
         * When TRUE, user must validate account after registration (email registration).
         * Otherwise, account is immediatly active and user can login.
         */
        'enableAccountActivation' => false,
        /**
         * URL of the app "Mes Livres" (mobile and desktop)
         */        
        'bookAppUrl' => 'https://app-my-books.vercel.app/'
    ],

    'mailer' => [
        'class'            => 'yii\swiftmailer\Mailer',
        'useFileTransport' => true          
    ]
];
