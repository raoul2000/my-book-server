<?php

namespace app\modules\api\controllers;

use Yii;
use app\models\Book;
use app\models\BookPing;
use yii\rest\Controller;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;
use app\modules\api\controllers\ControllerBehaviorTrait;

class TrackerController extends Controller
{
    use ControllerBehaviorTrait {
        behaviors as defaultBehaviors;
    }

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD', 'OPTIONS'],
        ];
    }
    /**
     * remove authentication filter
     */
    public function behaviors()
    {
        $behaviors = $this->defaultBehaviors();
        unset($behaviors['authenticator']);
        return $behaviors;
    }
    /**
     * Returns the track list for a given book
     * 
     * @param string $id - the id of the book to track
     */
    public function actionIndex($id)
    {
        return [
            'track' => BookPing::find()
                ->where(['book_id' => $id])
                ->all()
        ];
    }
}
