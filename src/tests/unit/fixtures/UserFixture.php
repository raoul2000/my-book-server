<?php
namespace tests\unit\fixtures;

use Codeception\Util\Fixtures;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'app\models\User';
    public $dataFile = __DIR__ . '/data/user.php';

    public function load(): void
    {
        parent::load();
        Fixtures::add(self::class, $this->data);
    }    
}