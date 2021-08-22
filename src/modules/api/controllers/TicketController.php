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
            'index'      => ['GET', 'HEAD', 'OPTIONS'],
            'create'     => ['POST', 'HEAD', 'OPTIONS'],
            'boarding'   => ['POST', 'HEAD', 'OPTIONS'],
            'send-email' => ['GET', 'HEAD', 'OPTIONS'],
            'delete'     => ['DELETE', 'OPTIONS'],
        ];
    }

    public function actionIndex($id)
    {
        $ticket = $this->findBookTicketModel($id);
        if($ticket) {
            return $ticket;
        }
        throw new NotFoundHttpException('ticket not found');
    }


    public function actionBoarding($id)
    {
        if (!$this->userBookExists($id)) {
            throw new NotFoundHttpException('book not found');
        }

        $ticket = $this->findBookTicketModel($id);
        if (!$ticket) {
            throw new NotFoundHttpException('ticket not found');
        }

        // TODO: implement me !
        return $ticket;
    }

    public function actionCreate($id)
    {
        if (!$this->userBookExists($id)) {
            throw new NotFoundHttpException('book not found');
        }

        if ($this->findBookTicketModel($id)) {
            throw new ServerErrorHttpException('ticket already created');
        }

        $ticket = new BookTicket();
        //$params = Yii::$app->getRequest()->getBodyParams();
        //$ticket->load($params,'');

        $ticket->book_id = $id;
        $ticket->user_id = Yii::$app->user->getId();
        if ($ticket->save()) {
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
        // FIXME: better find book ticket with book relation
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

    public function actionDelete($id)
    {
        // TODO: by business rule a ticket that has benn used (checked-in) 
        // cannot be delete. The traval has started, the ticket must remains
        // unmodified
        if ($this->userBookExists($id)) {
            $ticket = $this->findBookTicketModel($id);
            if($ticket) {
                $ticket->delete();
            } else {
                throw new NotFoundHttpException("Ticket not found");    
            }
        } else {
            throw new NotFoundHttpException("Ticket not found");
        }
    }

    private function findBookTicketModel($bookId)
    {
        return BookTicket::find()
            ->where([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $bookId
            ])
            ->one();
    }

    private function userBookExists($bookId)
    {
        // TODO: add condition book must not be already traveling
        return UserBook::find()
            ->where([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $bookId
            ])
            ->exists();
    }
}
