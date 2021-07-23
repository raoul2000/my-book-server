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

        $bookReview = new BookReview();
        // submiting a book review
        if (Yii::$app->request->isPost) {
            $bookReview->book_id = $book->id;
            $bookReview->load(Yii::$app->request->post());
            $bookReview->validate();

            
            if ($bookReview->load(Yii::$app->request->post()) && $bookReview->save()) {
                Yii::$app->session->setFlash('contactFormSubmitted');
                return $this->render('review-submited');
            }
        } else {
            $ping = new BookPing();
            $ping->book_id = $book->id;
            $ping->save();
        }
        return $this->render('ping-alive', [
            'book' => $book,
            'bookReview' => $bookReview
        ]);
    }
}
