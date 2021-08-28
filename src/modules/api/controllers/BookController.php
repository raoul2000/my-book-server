<?php

namespace app\modules\api\controllers;

use Yii;

use yii\rest\ActiveController;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends ActiveController
{
    use \app\modules\api\controllers\ControllerBehaviorTrait;

    public $modelClass = 'app\models\Book';

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD', 'OPTIONS'],
            'view' => ['GET', 'HEAD', 'OPTIONS']
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }
}
