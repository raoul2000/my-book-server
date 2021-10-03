<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use League\Csv\Writer;
use app\models\UserBook;

class ExportBooksController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'update' => ['post'],
                ],
            ],
        ];
    }
    /**
     * Export book and user-book info belonging to the current user
     */
    public function actionIndex()
    {
        $userBooks = UserBook::find()
            ->with('book')
            ->where([
                'user_id' => Yii::$app->user->getId()
            ])->all();

        $header = ['title', 'sub_title', 'author', 'isbn', 'rate', 'read_status', 'created_at', 'traveling', 'ping_count'];
        $records = [];
        $createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
        foreach ($userBooks as $userBook) {
            $createdAt->setTimestamp($userBook->created_at);
            $records[] = [
                $userBook->book->title,
                $userBook->book->subtitle,
                $userBook->book->author,
                $userBook->book->isbn,
                $userBook->rate,
                $userBook->read_status,
                $createdAt->format(\DateTimeInterface::ISO8601),
                $userBook->book->is_traveling,
                $userBook->book->ping_count
            ];
        }

        $csv = Writer::createFromString();
        $csv->setDelimiter(';');
        $csv->insertOne($header);
        $csv->insertAll($records);

        return Yii::$app->response->sendContentAsFile($csv->toString(), "mes-livres.csv", ["text/csv"]);
    }
}
