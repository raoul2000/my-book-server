<?php

namespace app\controllers;

use Yii;
use app\models\BookPing;
use app\models\BookTicket;

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
        $ticket = BookTicket::find()
            ->where(['id' => $id])
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

    private function savePingMaybe($ticket)
    {
        if ($this->isPingSaved() === false) {
            $ping = new BookPing();
            $ping->book_id = $ticket->book->id;
            $ping->user_ip = Yii::$app->request->getUserIP();
            $ping->save();
            $ping->refresh();
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
