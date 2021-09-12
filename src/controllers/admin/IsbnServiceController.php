<?php

namespace app\controllers\admin;

use Yii;
use app\models\forms\IsbnServiceForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\httpclient\Client;


class IsbnServiceController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $bookInfo = [];
        $model = new IsbnServiceForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl('https://www.googleapis.com/books/v1/volumes')
                ->setData(['q' => 'isbn:' . $model->isbn_number])
                ->send();
            if ($response->isOk) {
                $bookInfo = $response->data;
            } else {
                $bookInfo = ['error' => true, 'info' => $response];
            }        
        }

        if(!isset($model->isbn_number)) {
            // set a default valid ISBN number for test purposes
            $model->isbn_number = "9782253120407";
        }
        
        return $this->render('index', [
            'model' => $model,
            'bookInfo' => $bookInfo
        ]);

    }
}
