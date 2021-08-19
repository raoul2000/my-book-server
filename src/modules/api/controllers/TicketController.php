<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use app\models\User;
use yii\helpers\Url;
use app\models\UserBook;


class TicketController extends Controller
{
    use \app\modules\api\controllers\ControllerBehaviorTrait;

    protected function verbs()
    {
        return [
            'send-email' => ['GET', 'HEAD', 'OPTIONS'],
        ];
    }

    /**
     */
    public function actionSendEmail($id)
    {
        // TODO: add condition book must not be already traveling
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

        $emailSent = false;
        $ticketUrl = Url::to(['/ticket/view', 'id' => $userBook->book->id], true);
        try {
            $user = User::findOne(Yii::$app->user->getId());
            Yii::$app->mailer->compose(
                [
                    'html' => 'travel/ticket-html',
                    'text' => 'travel/ticket-text',
                ],
                [
                    'bookTitle' => $userBook->book->title,
                    'bookSubtitle' => $userBook->book->subtitle,
                    'bookAuthor' => $userBook->book->author,
                    'ticketUrl' => Url::to(['ticket/view', 'id' => $userBook->book->id], true)
                ]
            )
                ->setTo($user->email)
                ->setFrom(['Raoul@ass-team.fr' => 'raoul'])
                ->setReplyTo('no-reply@email.com')
                ->setSubject('travel ticket')
                ->send();
            $emailSent = true;
        } catch (\Throwable $th) {
            // TODO: log error
        }


        return [
            'ticketUrl' => $ticketUrl,
            'emailSent' => $emailSent
        ];
    }
}
