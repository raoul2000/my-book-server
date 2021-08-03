<?php

namespace app\controllers;

class PasswordRecoveryController extends \yii\web\Controller
{
    public function actionRequest()
    {
        return $this->render('request');
    }

    public function actionReset()
    {
        return $this->render('reset');
    }

}
