<?php

namespace app\controllers\admin;

use yii\filters\AccessControl;

class SettingsController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }    
    public function actionIndex()
    {
        return $this->render('index');
    }

}
