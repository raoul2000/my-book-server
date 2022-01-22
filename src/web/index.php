<?php

// NOTE : this file is automatically modified during the build process
// so to match target environment. 
// see .\tools\gulp\task\build-source.js

define('ENV_DEV', 'dev');
define('ENV_QA', 'qa');
define('ENV_PROD', 'prod');

// comment out the following two lines when deployed to production
defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'dev'); // dev, qa, prod

defined('APP_VERSION') || define('APP_VERSION', '%%VERSION%%');
defined('APP_BUILD_NUMBER') || define('APP_BUILD_NUMBER', '%%BUILD%%');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

$application = new yii\web\Application($config);

//Yii::setAlias('@qrcodes', '@webroot/files/qr-codes');

$application->run();
