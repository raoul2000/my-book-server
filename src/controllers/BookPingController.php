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
            if (!isset($normalizedTicketId)) {  // normalization failed
                $result = $this->render('ping-dead', [
                    'message' => "<p>Ce numéro de réservation n'a pas le bon format.</p>"
                ]);
            } else {
                $result = $this->pingForm($normalizedTicketId);
            }
        }
        return $result;
    }

    /**
     * Displays the ping review form for the given travel ticket id.
     */
    private function pingForm($ticketId)
    {
        $ticket = BookTicket::find()
            ->where(['id' => $ticketId])
            ->with('book')
            ->one();

        // ticket must exist
        if ($ticket === null) {
            return $this->render('ping-dead', [
                'message' => "Ce numéro de réservation n'est pas répertorié.. ou il ne l'est plus.
                <p class=\"text-muted\">
                Est-il possible aussi que vos doigts aient glissés, heurtant au passage une autre touche
                que celle que vous visiez ?</p>"
            ]);
        }
        $book = $ticket->book;
        // book must be traveling
        if(!$book->is_traveling) {
            return $this->render('ping-dead', [
                'message' => "Ce numéro de réservation ne correspond pas à un ticket utilisé."
            ]);
        }

        $ping = $this->maybeSavePing($ticket);

        // submiting a book review
        if ($ping->load(Yii::$app->request->post())) {

            if ($this->deserveToBeSaved($ping)) {
                $ping->updateAttributes(['text', 'rate', 'location_name', 'email']);
            }
            return $this->render('review-submited');
        }

        return $this->render('ping-alive', [
            'book' => $ticket->book,
            'bookReview' => $ping
        ]);
    }
    /**
     * Displays the Book ticket ID (so called 'booking number') form
     */
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

    /**
     * Get existing ping or create a new one for the given ticket.
     */
    private function maybeSavePing($ticket)
    {
        $pingId = $this->getTicketPingId($ticket->id);
        if(!isset($pingId)) {
            $ping = new BookPing();
            $ping->book_id = $ticket->book->id;
            $ping->user_ip = Yii::$app->request->getUserIP();
            $ping->save();
            $ticket->book->updateCounters(['ping_count' => 1]);
            $this->saveTicketPing($ticket->id, $ping->id);
        } else {
            $ping = BookPing::findOne($pingId);
        }
        return $ping;
    }

    /**
     * Store in the current session the pair ticketId, pingId
     */
    private function saveTicketPing($ticketId, $pingId)
    {
        $map = Yii::$app->session->get('ping', []);
        $map[$ticketId] = $pingId;
        Yii::$app->session->set('ping', $map);
    }
    /**
     * @return the Ping ID for the given ticket ID previously stored in the current session or
     * NULL if no ticketID, pingID was saved
     */
    private function getTicketPingId($ticketId)
    {
        $map = Yii::$app->session->get('ping', []);
        return array_key_exists($ticketId, $map) ? $map[$ticketId] : null;
    }
    /**
     * @return TRUE if the given book review needs to be saved, FALSE otherwise
     */
    private function deserveToBeSaved($bookReview)
    {
        return !empty($bookReview->text)
            || !empty($bookReview->rate)
            || !empty($bookReview->email)
            || !empty($bookReview->location_name);
    }
}
