<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\UserBook;
use app\models\UserToken;
use Da\QrCode\QrCode;

class UserDashboardController extends \yii\web\Controller
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
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $totalBookCount = UserBook::find()
            ->where([
                'user_id' => Yii::$app->user->getId()
            ])->count();

        $userToken = UserToken::findOne([
            'user_id' => Yii::$app->user->id,
            'type' => UserToken::TYPE_API_KEY
        ]);
        $apiKey = ($userToken !== null ? $userToken->token : null);
        $qrCode = null;
        if ($apiKey) {
            $qrCode = (new QrCode(Yii::$app->params['bookAppUrl'] . '/' . $apiKey, ))
                ->setSize(250)
                ->setMargin(5)
                ->useForegroundColor(51, 122, 183);
        }

        return $this->render('index', [
            'totalBookCount' => $totalBookCount,
            'apiKey' => $apiKey,
            'qrCode' => $qrCode
        ]);
    }

}
