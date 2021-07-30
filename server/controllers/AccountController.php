<?php

namespace app\controllers;

use Yii;
use app\models\UserRegistrationForm;
use app\models\User;
use yii\helpers\Url;

class AccountController extends \yii\web\Controller
{
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

                Yii::$app->session->setFlash('success', "Your account has been created and you must now activate it."
                    . "Check out your mail box for the account activation email");
            } else {
                Yii::$app->session->setFlash('success', "Registration success ! .. welcome " . $model->username . ", you can now login");
            }
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('create', [
            'model' => $model,
        ]);
    }



}
