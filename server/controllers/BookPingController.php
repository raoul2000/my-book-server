<?php

namespace app\controllers;

use Yii;
use app\models\Book;
use app\models\BookPing;

class BookPingController extends \yii\web\Controller
{
    /**
     * Creates a ping for a book
     * 
     * @param stinrg $id the book id
     */
    public function actionIndex($id)
    {
        $this->layout = 'naked';
        if (($model = Book::findOne($id)) !== null) {

            $ping = new BookPing();
            $ping->book_id = $model->id;
            $ping->save();
            
            return $this->render('ping-alive', [
                'model' => $model
            ]);
        }
        return $this->render('ping-dead');

    }

}
