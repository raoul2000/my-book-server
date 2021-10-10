<?php

namespace app\controllers;

use Yii;
use app\models\forms\UploadForm;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use League\Csv\Reader;
use app\models\Book;
use app\models\UserBook;
use yii\helpers\VarDumper;

class ImportBookController extends \yii\web\Controller
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
                        'roles' => ['admin'],
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

    public function actionIndex()
    {
        $records_created = [];
        $records_error = [];
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {

            $model->dataFile = UploadedFile::getInstance($model, 'dataFile');

            // build temporary filepath to store uploaded file
            $uuid = \thamtech\uuid\helpers\UuidHelper::uuid();
            $uploadFilepath = Yii::getAlias('@runtime/tmp/' . $uuid . '.csv');

            if ($model->upload($uploadFilepath)) {
                $csv = Reader::createFromStream(fopen($uploadFilepath, 'r'));
                $csv->setDelimiter(';');
                $csv->setEnclosure('"');
                $csv->setHeaderOffset(0);
                $csvRecords = $csv->getRecords(['title', 'sub_title', 'author', 'isbn', 'rate', 'read_status']);
                foreach ($csvRecords as $record) {

                    $book = new Book([
                        'title' => $record['title'],
                        'subtitle' => $record['sub_title'],
                        'author' => $record['author'],
                        'isbn' => $record['isbn']
                    ]);
                    if ($book->save()) {
                        $userBook = new UserBook([
                            'book_id' => $book->id,
                            'user_id' => Yii::$app->user->getId(),
                            'read_status' => $record['read_status'],
                            'rate' => $record['rate']
                        ]);
                        if ($userBook->save()) {
                            $records_created[] = $record;
                        } else {
                            $records_error[] = [
                                'message' => 'failed to create user-book record',
                                'reason' =>  VarDumper::dumpAsString($userBook->getErrors()),
                                'record' =>  VarDumper::dumpAsString($record)
                            ];
                            $book->delete();
                        }
                    } else {
                        $records_error[] = [
                            'message' => 'failed to create book record',
                            'reason' =>  VarDumper::dumpAsString($book->getErrors()),
                            'record' =>  VarDumper::dumpAsString($record)
                        ];
                    }
                }
                unlink($uploadFilepath);
            }
        }

        return $this->render('index', [
            'model' => $model,
            'records_created' => $records_created,
            'records_error' => $records_error
        ]);
    }
}
