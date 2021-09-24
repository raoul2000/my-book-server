<?php

namespace app\controllers\admin;

use Yii;
use app\models\forms\EmailForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class EmailController extends \yii\web\Controller
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['POST', 'GET'],
                ],
            ],                   
        ];
    }
    
    public function actionIndex()
    {
        $model = new EmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->sendEmail()) {
                Yii::$app->session->setFlash('emailSendSuccess');
            } else {
                Yii::$app->session->setFlash('contactFormSubmitted');
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionTestEmail()
    {
        return $this->render('test-email');
    }

}
