<?php
namespace tests\unit\fixtures;

use Yii;
use yii\test\ActiveFixture;

class UserTokenFixture extends ActiveFixture
{
    public $modelClass = 'app\models\UserToken';
    public $dataFile = __DIR__ . '/data/user-token.php';
}