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
        $googleResponse = $this->sendRequestGoogleBookApi($isbn);
        if ($googleResponse->isOk) {
            $result = $googleResponse->data;
            $response = [ ];
            if (array_key_exists('totalItems', $result) && $result['totalItems'] > 0) {
                // TODO: validate response data
                $response['title'] = $result['items'][0]['volumeInfo']['title'];
                $response['author'] = $result['items'][0]['volumeInfo']['authors'][0];

                if (array_key_exists('subtitle', $result['items'][0]['volumeInfo'])) {
                    $response['subtitle'] = $result['items'][0]['volumeInfo']['subtitle'];
                }
                return $response;
            } else {
                Yii::$app->getResponse()->setStatusCode(404);
                return [];
            }
        } else {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(500);
            return ['error' => true, 'info' => $response];
        }
    }

    public function actionDescription($isbn)
    {
        $googleResponse = $this->sendRequestGoogleBookApi($isbn);
        if ($googleResponse->isOk) {
            $result = $googleResponse->data;
            // TODO: validate response data

            if (array_key_exists('totalItems', $result) && $result['totalItems'] > 0) {
                $description = '';
                if (array_key_exists('description', $result['items'][0]['volumeInfo'])) {
                    $description = $result['items'][0]['volumeInfo']['description'];
                }
                return [
                    'description' => $description
                ];
            } else {
                Yii::$app->getResponse()->setStatusCode(404);
                return [];
            }
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
