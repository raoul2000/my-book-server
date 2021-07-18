<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;
use yii\web\NotFoundHttpException;

class UserSettingsController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $userModel = $this->findModel(Yii::$app->user->id);

        return $this->render('index', [
            'userModel' => $userModel,
        ]);
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
