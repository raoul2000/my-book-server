<?php
namespace tests\unit\fixtures;

use Codeception\Util\Fixtures;
use yii\test\ActiveFixture;

class BookFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Book';
    public $dataFile = __DIR__ . '/data/book.php';

    public function load(): void
    {
        parent::load();
        Fixtures::add(self::class, $this->data);
    } 
}