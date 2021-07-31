<?php

namespace app\modules\api\controllers;

use Yii;

use yii\rest\ActiveController;
use yii\filters\auth\HttpHeaderAuth;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends BaseApiController
{
    public $modelClass = 'app\models\Book';

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD','OPTIONS'],
            'view' => ['GET', 'HEAD', 'OPTIONS'],
            'create' => ['POST', 'OPTIONS'],
            'update' => ['PUT', 'PATCH', 'OPTIONS'],
            'delete' => ['DELETE', 'OPTIONS'],
        ];
    }
 
}
