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
        'bookAppUrl' => 'http://localhost:3000/#/signin-key',
        /**
         * Captcha Policy settings
         */
        'enableVerifyCodeOnLogin'           => false,
        'enableVerifyCodeOnCreateAccount'   => false
    ],

    'mailer' => [
        'class'            => 'yii\swiftmailer\Mailer',
        'useFileTransport' => true          
    ]
];
