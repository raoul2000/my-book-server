<?php

namespace app\modules\api\controllers;

use Yii;

use yii\rest\Controller;
use app\modules\api\controllers\ControllerBehaviorTrait;

class InfoController extends Controller
{
    use ControllerBehaviorTrait {
        behaviors as defaultBehaviors;
    }

    protected function verbs()
    {
        return [
            'index' => ['GET']
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

    public function actionIndex()
    {
        return  [
            'version' => APP_BUILD_NUMBER
        ];
    }

}
