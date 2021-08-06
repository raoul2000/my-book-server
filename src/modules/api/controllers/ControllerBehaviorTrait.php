<?php

namespace app\modules\api\controllers;

/**
 * Trait to handle CORS and HTTP Header Authentication
 */
trait ControllerBehaviorTrait {

    function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpHeaderAuth::class,
        ];

        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }
}