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
     * Creates a ping for a book given its travel ticket Id
     * 
     * @param stinrg $id the ticket id
     */
    public function actionIndex($id)
    {
        $ticketId = $this->normalizeTicketId($id);
        if(!isset($ticketId)) {
            return $this->render('ping-dead');
        }
        $ticket = BookTicket::find()
            ->where(['id' => $ticketId])
            ->with('book')
            ->one();

        if ($ticket === null) {
            return $this->render('ping-dead');
        }

        if ($this->isBookReviewSubmited()) {
            return $this->render('review-submited');
        }

        $ping = $this->savePingMaybe($ticket);

        // submiting a book review
        if ($ping->load(Yii::$app->request->post())) {

            if ($this->deserveToBeSaved($ping)) {
                $ping->updateAttributes(['text', 'rate', 'location_name', 'email']);
                $this->setBookReviewSubmited(true);
            }
            return $this->render('review-submited');
        }

        return $this->render('ping-alive', [
            'book' => $ticket->book,
            'bookReview' => $ping
        ]);
    }

    public function actionForm()
    {
        $model = new  TrackerForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->redirect(['/book-ping', 'id' => $model->booking_number]);
        }

        return $this->render('tracker-form', [
            'model' => $model,
        ]);
    }

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
        if ($this->isPingSaved() === false) {
            $ping = new BookPing();
            $ping->book_id = $ticket->book->id;
            $ping->user_ip = Yii::$app->request->getUserIP();
            $ping->save();
            $ping->refresh();
            $ticket->book->updateCounters(['ping_count' => 1]);
            $this->setPingId($ping->id);
        } else {
            $ping = BookPing::findOne($this->getPingId());
        }
        return $ping;
    }
    private function isBookReviewSubmited()
    {
        return Yii::$app->session['bookReviewSubmited'] === true;
    }
    private function setBookReviewSubmited($submited)
    {
        Yii::$app->session['bookReviewSubmited'] = $submited;
    }
    private function isPingSaved()
    {
        return isset(Yii::$app->session['pingId']);
    }
    private function setPingId($id)
    {
        Yii::$app->session['pingId'] = $id;
    }
    private function getPingId()
    {
        return Yii::$app->session['pingId'];
    }
    private function deserveToBeSaved($bookReview)
    {
        return !empty($bookReview->text)
            || !empty($bookReview->rate)
            || !empty($bookReview->location_name);
    }
}
