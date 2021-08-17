<?php

namespace app\modules\api\controllers;

use Yii;
use app\models\Book;
use yii\rest\Controller;
use yii\httpclient\Client;

class IsbnServiceController extends Controller
{
    use \app\modules\api\controllers\ControllerBehaviorTrait;

    protected function verbs()
    {
        return [
            'search' => ['GET', 'HEAD', 'OPTIONS'],
            'abstract' => ['GET', 'HEAD', 'OPTIONS'],
        ];
    }

    /**
     * Returns the list of books belonging to the current user
     */
    public function actionSearch($isbn)
    {
        $response = $this->sendRequestGoogleBookApi($isbn);
        if ($response->isOk) {
            // TODO: validate response data
            $book = new Book();
            $book->title = $response->data['items'][0]['volumeInfo']['title'];
            $book->author = $response->data['items'][0]['volumeInfo']['authors'][0];

            if (array_key_exists('subtitle', $response->data['items'][0]['volumeInfo'])) {
                $book->subtitle = $response->data['items'][0]['volumeInfo']['subtitle'];
            }
            return $book;
        } else {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(500);
            return ['error' => true, 'info' => $response];
        }
    }

    public function actionDescription($isbn)
    {
        $response = $this->sendRequestGoogleBookApi($isbn);
        if ($response->isOk) {
            // TODO: validate response data

            $description = '';
            if (array_key_exists('description', $response->data['items'][0]['volumeInfo'])) {
                $description = $response->data['items'][0]['volumeInfo']['description'];
            }
            return [
                'description' => $description
            ];
        } else {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(500);
            return ['error' => true, 'info' => $response];
        }
    }
    private function sendRequestGoogleBookApi($isbn) 
    {
        $client = new Client();
        return $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://www.googleapis.com/books/v1/volumes')
            ->setData(['q' => 'isbn:' . $isbn])
            ->send();
    }
}
