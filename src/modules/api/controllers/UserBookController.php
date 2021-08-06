<?php

namespace app\modules\api\controllers;

use Yii;

use yii\rest\Controller;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
use app\models\Book;
use app\models\User;
use app\models\UserBook;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class UserBookController extends Controller
{
    use \app\modules\api\controllers\ControllerBehaviorTrait;

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD', 'OPTIONS'],
            'view' => ['GET', 'HEAD', 'OPTIONS'],
            'create' => ['POST', 'OPTIONS'],
            'update' => ['PUT', 'PATCH', 'OPTIONS'],
            'delete' => ['DELETE', 'OPTIONS'],
        ];
    }

    /**
     * Returns the list of books belonging to the current user
     */
    public function actionIndex()
    {
        $bookIdsResult = UserBook::find()
            ->select(['book_id'])
            ->where(['user_id' => Yii::$app->user->getId()])
            ->asArray()
            ->all();

        $bookIds = ArrayHelper::getColumn($bookIdsResult, 'book_id');

        $query = Book::find()
            ->where(['in', 'id', $bookIds]);

        return new ActiveDataProvider([
            'query' =>  $query
        ]);
    }

    /**
     * Create a book and link it to the current user
     */
    public function actionCreate()
    {
        $book = new Book();

        $book->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($book->save()) {
            $userBook = new UserBook();
            $userBook->setAttributes([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $book->id
            ]);

            if ($userBook->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);
            } else {
                // rollback : delete book
                $book->delete();
                throw new ServerErrorHttpException('Failed to create user book');
            }
        } else {
            throw new ServerErrorHttpException('Failed to create book.');
        }
    }

    /**
     * Return UserBook and if the expand=book query parameter is set,
     * the related Book record
     */
    public function actionView($id)
    {
        $userBook = UserBook::find()
            ->where(['user_id' => Yii::$app->user->getId()])
            ->andWhere(['book_id' => $id])
            ->one();

        if(!$userBook) {
            throw new NotFoundHttpException("Object not found");
        }

        return $userBook;
    }

    public function actionUpdate($id)
    {
        $userBook = UserBook::find()
            ->where(['user_id' => Yii::$app->user->getId()])
            ->andWhere(['book_id' => $id])
            ->with('book')
            ->one();

        if(!$userBook) {
            throw new NotFoundHttpException("Object not found");
        }

        // FIXME: book id (and all other primary keys) should be protected from user updates
        // TODO: allow user to update userBook model

        $book = $userBook->book;

        $params = Yii::$app->getRequest()->getBodyParams();
        $book->load($params , '');
        if ($book->update()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } else {
            throw new ServerErrorHttpException('Failed to update book.');
        }        
    }

    /**
     * Deletes the UserBook and the related Book records for a given book id
     * and the current user.
     */
    public function actionDelete($id)
    {
        $userBook = UserBook::find()
            ->where(['user_id' => Yii::$app->user->getId()])
            ->andWhere(['book_id' => $id])
            ->with('book')
            ->one(); 
            
        if($userBook) {
            $userBook->delete();
            $userBook->book->delete();
        } else {
            throw new NotFoundHttpException("Object not found");
        }
    }

}
