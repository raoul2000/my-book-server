<?php

namespace app\modules\api\controllers;

use app\models\BookTicket;
use Yii;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\data\ActiveDataProvider;
use app\models\User;
use yii\helpers\Url;
use app\models\UserBook;


class TicketController extends Controller
{
    use \app\modules\api\controllers\ControllerBehaviorTrait;

    protected function verbs()
    {
        return [
            'index'     => ['GET', 'HEAD', 'OPTIONS'],
            'create'     => ['POST', 'HEAD', 'OPTIONS'],
            'send-email' => ['GET', 'HEAD', 'OPTIONS'],
        ];
    }

    public function actionIndex($id)
    {
        return new ActiveDataProvider([
            'query' =>  BookTicket::find()
                ->where([
                    'user_id' => Yii::$app->user->getId(),
                    'book_id' => $id
                ])
        ]);
    }

    public function actionCreate($id)
    {
        // TODO: add condition book must not be already traveling
        // the book MUST belong to the current user
        $userBookExists = UserBook::find()
            ->where([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $id
            ])
            ->exists();

        if (!$userBookExists) {
            throw new NotFoundHttpException('book not found');
        }

        // a ticket MUST NOT already exist for this book
        $ticketExists = BookTicket::find()
            ->where([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $id
            ])
            ->exists();

        if($ticketExists) {
            throw new ServerErrorHttpException('ticket already created');
        }

        $ticket = new BookTicket();
        //$params = Yii::$app->getRequest()->getBodyParams();
        //$ticket->load($params,'');

        $ticket->book_id = $id;
        $ticket->user_id = Yii::$app->user->getId();
        if( $ticket->save()) {
            $ticket->refresh();
            return $ticket;
        } else {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(500);
            return $ticket->getErrors();
        }
    }

    public function actionUpdate($id)
    {
        // TODO: implement me !
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
