<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use app\models\UserBook;
use app\models\BookTicket;
use app\models\User;
use app\models\Book;
use app\models\BookPing;
use yii\helpers\Url;


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
    /**
     * Returns a travel ticket for a given book and for the current user
     * or throws
     * @param $id the book Id
     */
    public function actionIndex($id)
    {
        return $this->findBookTicketModel($id);
    }

    /**
     * Perform boarding operation for a ticket on a given book and
     * for the current user.
     * 
     * @param $id the book Id
     */
    public function actionBoarding($id)
    {
        if (!$this->userBookExists($id)) {
            throw new NotFoundHttpException('book not found');
        }

        $ticket = $this->findBookTicketModel($id);

        $userBook = UserBook::find()
            ->where([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $id
            ])
            ->with('book')
            ->one();


        if ($userBook) {
            if ($userBook->book->is_traveling) {
                throw new ServerErrorHttpException('book already traveling');
            }
            $userBook->book->updateAttributes(['is_traveling' => 1]);

            // Create the 'boarding' track : the first track for this travel that just begins
            $ping = new BookPing(); // TO TEST
            $ping->book_id = $ticket->book->id;
            $ping->user_ip = Yii::$app->request->getUserIP();
            $ping->setAttributes([
                'book_id'       => $ticket->book->id,
                'is_boarding'   => 1,
                'user_ip'       => Yii::$app->request->getUserIP(),
                'location_name' => $ticket->from,
                'rate'          => $userBook->rate
            ]);
            $ping->save();
            
            return [
                'book'   => $userBook->book,
                'ticket' => $ticket
            ];
        } else {
            throw new NotFoundHttpException('book not found');
        }
    }

    /**
     * Creates a travel ticket for a given book a,d for the current user
     * @param $id the book Id
     */
    public function actionCreate($id)
    {
        if (!$this->userBookExists($id)) {
            throw new NotFoundHttpException('book not found');
        }

        if ($this->bookTicketExists($id)) {
            throw new ServerErrorHttpException('ticket already created');
        }

        $ticket = new BookTicket();

        $params = Yii::$app->getRequest()->getBodyParams();
        $ticket->book_id = $id;
        $ticket->user_id = Yii::$app->user->getId();
        $ticket->from = $params['from'];

        if (!empty($params['departure_at'])) {
            $utcDate = new \DateTime($params['departure_at']);
            $ticket->departure_at = $utcDate->format('Y-m-d H:i:00'); // reset seconds
        }

        if ($ticket->save()) {
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
    /**
     * Deletes a ticket for a given book or throw
     * @param $id the book Id
     */
    public function actionDelete($id)
    {
        $ticket = $this->findBookTicketModel($id);
        $book = Book::findOne($ticket->book_id);
        if ($book) {
            // RULE: it is not possible to delete a ticket if boarding has been
            // done
            if ($book->is_traveling) {
                throw new ServerErrorHttpException('book already traveling');
            }
        } else {
            throw new NotFoundHttpException('book not found');
        }
        $ticket->delete();
    }
    /**
     * Returns a ticket for a given book and for the current user 
     * or throws if not found
     * 
     * @param $bookId the book Id
     */
    private function findBookTicketModel($bookId)
    {
        $ticket = BookTicket::find()
            ->where([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $bookId
            ])
            ->one();

        if (!$ticket) {
            throw new NotFoundHttpException('ticket not found');
        }
        return $ticket;
    }
    /**
     * Returns TRUE if a ticket for a given book and the current user
     * exists or throws
     * 
     * @param $bookId the book Id
     */
    private function bookTicketExists($bookId)
    {
        return BookTicket::find()
            ->where([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $bookId
            ])
            ->exists();
    }
    /**
     * Returns TRUE if a given book and for the current user 
     * exists or throws
     * 
     * @param $bookId the book Id
     */
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
