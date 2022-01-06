<?php
// DEV
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
        'bookAppUrl'  => 'http://localhost:3000/#/signin-key',
        /**
         * URL encoded in the QR-Code with suffix : '&id=BOOK_TICKET_ID'.
         * Also used to redirect from the checkpoint Url (see '/web/ping-redirect/index.php)
         */        
        'qrcodeUrl'     => 'http://localhost:8080/index.php?r=book-ping',        
        /**
         * URL of the checkpoint as it appears on the book ticket.
         * Should point to a redirect page to qrcodeUrl (with no book_ticket_id)
         */ 
        'checkpointUrl' => 'http://localhost:8080/ping-redirect',            
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
