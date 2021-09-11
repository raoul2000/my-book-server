<?php

namespace app\controllers;

use Yii;
use app\models\BookPing;
use app\models\BookTicket;
use app\models\forms\TrackerForm;

class BookPingController extends \yii\web\Controller
{
    public $layout = 'naked';
    /**
     * Creates a ping for a traveling book
     * 
     * @param stinrg $id the ticket id
     */
    public function actionIndex($id = null)
    {
        $result = null;
        if (!isset($id)) {
            $result = $this->bookingNumberForm();
        } else {
            $normalizedTicketId = $this->normalizeTicketId($id);
            if (!isset($normalizedTicketId)) {
                $result = $this->render('ping-dead', [
                    'message' => "Ce numéro de réservation n'a pas le bon format."
                ]);
            } else {
                $result = $this->pingForm($normalizedTicketId);
            }
        }
        return $result;
    }

    private function pingForm($ticketId)
    {
        $ticket = BookTicket::find()
            ->where(['id' => $ticketId])
            ->with('book')
            ->one();

        if ($ticket === null) {
            return $this->render('ping-dead', [
                'message' => "Ce numéro de réservation n'est pas répertorié.. ou il ne l'est plus.<br/>
                Est-il possible aussi que vos doigts aient glissés, heurtant au passage une autre touche
                que celle que vous visiez ?"
            ]);
        }

        if ($this->isBookReviewSubmited($ticketId)) {
            return $this->render('review-submited');
        }

        $ping = $this->savePingMaybe($ticket);

        // submiting a book review
        if ($ping->load(Yii::$app->request->post())) {

            if ($this->deserveToBeSaved($ping)) {
                $ping->updateAttributes(['text', 'rate', 'location_name', 'email']);
                $this->setBookReviewSubmited($ticketId);
            }
            return $this->render('review-submited');
        }

        return $this->render('ping-alive', [
            'book' => $ticket->book,
            'bookReview' => $ping
        ]);
    }
    private function bookingNumberForm()
    {
        $model = new  TrackerForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->redirect(['/book-ping', 'id' => $model->booking_number]);
        }

        return $this->render('tracker-form', [
            'model' => $model,
        ]);
    }

    /**
     * Converts ticket id into format 'XXX-XXX' where X is a number or an upper-case letter.
     * If the ticket ID could not be normalized, returns NULL
     */
    private function normalizeTicketId($ticketId)
    {
        $normalizedTicketId = null;
        $re = '/^([[:alnum:]][[:alnum:]][[:alnum:]])[-_\.]?([[:alnum:]][[:alnum:]][[:alnum:]])$/';

        preg_match_all($re, $ticketId, $matches, PREG_SET_ORDER, 0);
        if (count($matches) === 1) {
            $normalizedTicketId = strtoupper($matches[0][1]) . '-' . strtoupper($matches[0][2]);
        }
        return $normalizedTicketId;
    }

    private function savePingMaybe($ticket)
    {
        if ($this->isTicketAlreadyPing($ticket->id) === false) {
            $ping = new BookPing();
            $ping->book_id = $ticket->book->id;
            $ping->user_ip = Yii::$app->request->getUserIP();
            $ping->save();
            $ticket->book->updateCounters(['ping_count' => 1]);
            $this->saveTicketPing($ticket->id, $ping->id);
        } else {
            $ping = BookPing::findOne($this->getTicketPingId($ticket->id));
        }
        return $ping;
    }

    private function isBookReviewSubmited($ticketId)
    {
        return in_array($ticketId, Yii::$app->session->get('bookReviewSubmited', []));
    }
    private function setBookReviewSubmited($ticketId)
    {
        $values = Yii::$app->session->get('bookReviewSubmited', []);
        $values[] = $ticketId;
        Yii::$app->session->set('bookReviewSubmited', $values);
    }
    /**
     * @return bool TRUE if a ping has been done in the current session for 
     * this ticket, FALSE otherwise
     */
    private function isTicketAlreadyPing($ticketId)
    {
        return array_key_exists(
            $ticketId,
            Yii::$app->session->get('ping', [])
        );
    }
    private function saveTicketPing($ticketId, $pingId)
    {
        $map = Yii::$app->session->get('ping', []);
        $map[$ticketId] = $pingId;
        Yii::$app->session->set('ping', $map);
    }
    private function getTicketPingId($ticketId)
    {
        $map = Yii::$app->session->get('ping', []);
        return $map[$ticketId];
    }
    private function deserveToBeSaved($bookReview)
    {
        return !empty($bookReview->text)
            || !empty($bookReview->rate)
            || !empty($bookReview->location_name);
    }
}
