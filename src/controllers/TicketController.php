<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\UserBook;
use Da\QrCode\QrCode;

class TicketController extends \yii\web\Controller
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
            ]
        ];
    }

    public function actionNew($id)
    {
        $userBook = $this->findModel($id);
    }

    public function actionView($id)
    {
        $userBook = $this->findModel($id);

        $qrCode = (new QrCode($userBook->book->id))
            ->setSize(250)
            ->setMargin(5);

        return $this->render('view', [
            'book' => $userBook->book,
            'qrCode' => $qrCode
        ]);
    }

    private function findModel($id)
    {
        // TODO: add condition book must not already be traveling
        $userBook = UserBook::find()
            ->where([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $id
            ])
            ->with('book')
            ->one();

        if (!$userBook) {
            throw new NotFoundHttpException();
        }
        return $userBook;
    }
}
