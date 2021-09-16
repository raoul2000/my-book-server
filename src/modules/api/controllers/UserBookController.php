<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
use app\models\Book;
use app\models\UserBook;
use yii\data\ActiveDataProvider;

class UserBookController extends Controller
{
    use \app\modules\api\controllers\ControllerBehaviorTrait;

    protected function verbs()
    {
        return [
            'index'  => ['GET', 'HEAD', 'OPTIONS'],
            'view'   => ['GET', 'HEAD', 'OPTIONS'],
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
        return new ActiveDataProvider([
            'pagination' => false,
            'query'      => UserBook::find()
                ->with('book')
                ->where([
                    'user_id' => Yii::$app->user->getId()
                ])
                ->orderBy('updated_at DESC')
        ]);
    }

    /**
     * Create a book and link it to the current user
     */
    public function actionCreate()
    {
        $book = new Book();
        $params = Yii::$app->getRequest()->getBodyParams();

        if ($book->load($params['book'], '') && $book->save()) {
            $userBook = new UserBook();
            $userBook->load($params['userBook'], '');
            $userBook->setAttributes([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $book->id
            ]);

            if ($userBook->save()) {
                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);

                return $userBook;
            } else {
                $book->delete();    // rollback : delete book
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
        return $this->findUserbookModel($id);;
    }

    public function actionUpdate($id)
    {
        $userBook = $this->findUserbookModel($id);

        // FIXME: book id (and all other primary keys) should be protected from user updates

        $book = $userBook->book;

        $params = Yii::$app->getRequest()->getBodyParams();
        if (isset($params['book'])) {
            $book->load($params['book'], '');
            if ($book->validate()) {
                $book->update();
                $userBook->touch('updated_at');
            } else {
                throw new ServerErrorHttpException('Failed to update book.');
            }
        }

        if (isset($params['userBook'])) {
            $userBook->load($params['userBook'], '');
            if ($userBook->validate()) {
                $userBook->update();
            } else {
                throw new ServerErrorHttpException('Failed to update user-book.');
            }
        }
        $response = Yii::$app->getResponse();
        $response->setStatusCode(201);
        return $userBook;
    }

    /**
     * Deletes the UserBook and the related Book records for a given book id
     * and the current user.
     */
    public function actionDelete($id)
    {
        $userBook = $this->findUserbookModel($id);
        $userBook->delete();
        $userBook->book->delete();
    }

    /**
     * Find UserBook by Id and for the current user
     */
    private function findUserbookModel($id)
    {
        $userBook = UserBook::find()
            ->where([
                'user_id' => Yii::$app->user->getId(),
                'book_id' => $id
            ])
            ->with('book')
            ->one();

        if ($userBook === null) {
            throw new NotFoundHttpException("Object not found");
        }
        return $userBook;
    }
}
