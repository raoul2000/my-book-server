<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'dev');

defined('APP_VERSION') || define('APP_VERSION', '%%VERSION%%');
defined('APP_BUILD_NUMBER') || define('APP_BUILD_NUMBER', '%%BUILD%%');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
