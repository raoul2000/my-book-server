<?php

namespace app\controllers;

use Yii;
use app\models\Book;
use app\models\BookPing;
use app\models\BookReview;

class BookPingController extends \yii\web\Controller
{
    public $layout = 'naked';
    /**
     * Creates a ping for a book
     * 
     * @param stinrg $id the book id
     */
    public function actionIndex($id)
    {
        $book = Book::findOne($id);
        if ($book === null) {
            return $this->render('ping-dead');
        }

        if ($this->isBookReviewSubmited()) {
            return $this->render('review-submited');
        }

        $bookReview = new BookReview();
        // submiting a book review
        if ($bookReview->load(Yii::$app->request->post())) {
            $bookReview->book_id = $book->id;
            $bookReview->user_ip = Yii::$app->request->getUserIP();
            if ($this->deserveToBeSaved($bookReview)) {
                $bookReview->save();
                $this->setBookReviewSubmited(true);
            }
            return $this->render('review-submited');
        } else {
            if ($this->canSavePing()) {
                $ping = new BookPing();
                $ping->book_id = $book->id;
                $ping->user_ip = Yii::$app->request->getUserIP();
                $ping->save();
                $this->setPingSaved(true);
            }

            return $this->render('ping-alive', [
                'book' => $book,
                'bookReview' => $bookReview
            ]);
        }
    }

    private function isBookReviewSubmited()
    {
        return Yii::$app->session['bookReviewSubmited'] === true;
    }
    private function setBookReviewSubmited($val)
    {
        Yii::$app->session['bookReviewSubmited'] = $val;
    }
    private function isPingSaved()
    {
        return Yii::$app->session['saveBookPing'] === true;
    }
    private function setPingSaved($saved)
    {
        Yii::$app->session['saveBookPing'] = $saved;
    }
    private function canSavePing()
    {
        return Yii::$app->params['saveBookPing'] && $this->isPingSaved() === false;
    }
    private function deserveToBeSaved($bookReview)
    {
        return !empty($bookReview->text)
            || !empty($bookReview->rate)
            || !empty($bookReview->location_name);
    }
}
