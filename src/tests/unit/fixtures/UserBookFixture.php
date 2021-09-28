<?php
namespace tests\unit\fixtures;

use Yii;
use yii\test\ActiveFixture;

class UserBookFixture extends ActiveFixture
{
    public $modelClass = 'app\models\UserBook';
    public $dataFile = __DIR__ . '/data/user-book.php';
    public $depends = [
        UserFixture::class,
        BookFixture::class
    ];
}