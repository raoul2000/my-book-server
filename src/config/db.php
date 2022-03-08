<?php
// DEV
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=my_books',
    'username' => 'admin',
    'password' => 'admin',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
