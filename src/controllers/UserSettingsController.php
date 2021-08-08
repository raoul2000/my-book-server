<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\forms\UpdatePasswordForm;
use yii\web\NotFoundHttpException;
use Da\QrCode\QrCode;

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

        $qrCode = null;
        if (!empty($userModel->api_key)) {
            $qrCode = (new QrCode($userModel->api_key))
                ->setSize(250)
                ->setMargin(5)
                ->useForegroundColor(51, 153, 255);
        }

        return $this->render('index', [
            'userModel' => $userModel,
            'qrCode' => $qrCode
        ]);
    }

    public function actionUpdatePassword()
    {
        $model = new UpdatePasswordForm();
        $model->setScenario(UpdatePasswordForm::SCENARIO_UPDATE);
        
        if ($model->load(Yii::$app->request->post()) && $model->updatePassword()) {
            Yii::$app->session->setFlash('success','Mot de passe mis à jour');
            return $this->redirect(['/user-settings']);
        }

        return $this->render('update-password', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
