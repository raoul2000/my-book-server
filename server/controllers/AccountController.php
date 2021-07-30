<?php

namespace app\controllers;

use Yii;
use app\models\UserRegistrationForm;
use app\models\User;
use yii\helpers\Url;

class AccountController extends \yii\web\Controller
{
    /**
     * Activate user account related to the provided token
     */
    public function actionActivate($token)
    {
        $model = User::findByAccountActivationToken($token);
        if ($model) {
            $model->removeAccountActivationToken();
            $model->status = User::STATUS_ACTIVE;
            $success = $model->save(false);
        } else {
            $success = false;
        }

        return $this->render('activate', [
            'success' => $success
        ]);
    }
    /**
     * Create a user Account
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserRegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {

            $userEmail = '';
            if (Yii::$app->params['enableAccountActivation']) {
                $user =  User::findOne($model->getUserId());
                Yii::$app->mailer->compose(
                    [
                        'html' => 'account/activation-html',
                        'text' => 'account/activation-text',
                    ],
                    [
                        'activationUrl' => Url::to(['site/account-activation', 'token' => $user->account_activation_token], true),
                        'username'      => $user->username
                    ]
                )
                    ->setTo($user->email)
                    ->setFrom(['Raoul@ass-team.fr' => 'raoul'])
                    ->setReplyTo('no-reply@email.com')
                    ->setSubject('account activation')
                    ->send();
                $userEmail = $user->email;
            } 

            return $this->render('create-success', [
                'activationRequired' => Yii::$app->params['enableAccountActivation'],
                'email' => $userEmail
            ]);            
        }

        $model->password = '';
        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
