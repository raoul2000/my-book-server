<?php

namespace app\controllers;

use Yii;
use app\models\forms\PasswordResetForm;
use app\models\forms\UpdatePasswordForm;
use yii\helpers\Url;
use app\models\UserToken;

class PasswordResetController extends \yii\web\Controller
{
    /**
     * Initiate a password reset procedure (step 1)
     */
    public function actionRequest()
    {
        // only user NOT logged in
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PasswordResetForm();
        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {

            Yii::$app->mailer->compose(
                [
                    'html' => 'account/reset-password-html',
                    'text' => 'account/reset-password-text',
                ],
                [
                    'resetPasswordUrl' => Url::to(['password-reset/update', 'token' => $model->getPasswordResetToken()], true)
                ]
            )
                ->setTo($model->email)
                ->setFrom(['Raoul@ass-team.fr' => 'raoul'])
                ->setReplyTo('no-reply@email.com')
                ->setSubject('password reset ')
                ->send();

            return $this->render('request-success');
        }

        return $this->render('request', [
            'model' => $model
        ]);
    }

    /**
     * Finalize password reset procedure (step 2)
     */
    public function actionUpdate($token)
    {
        $model = UserToken::findByToken($token, UserToken::TYPE_PASSWORD_RESET);

        if ($model) {
            $userId = $model->user->id;

            $model = new UpdatePasswordForm();
            $model->setScenario(UpdatePasswordForm::SCENARIO_RESET);

            if ($model->load(Yii::$app->request->post()) && $model->updatePassword($userId)) {
                Yii::$app->session->setFlash('success', 'Mot de passe mis à jour. Vous pouvez maintenant vous connecter');
                return $this->redirect(['/site/login']);
            }

            return $this->render('/user-settings/update-password', [
                'model' => $model
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->goHome();
        }
    }
}
