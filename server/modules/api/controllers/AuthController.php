<?php

namespace app\modules\api\controllers;

use Yii;

use app\models\User;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class AuthController extends BaseApiController
{
    public $modelClass = 'app\models\Book';

    protected function verbs()
    {
        return [
            'login' => ['POST', 'OPTIONS'],
        ];
    }
    /**
     * remove authentication filter
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        return $behaviors;
    }    

    public function actionLogin()
    {
        $params = Yii::$app->request->post();
        if (empty($params['username']) || empty($params['password'])) {
            throw new BadRequestHttpException('username and password are required');
        }

        $user = User::findByUsername($params['username']);
        if(empty($user)) {
            throw new UnauthorizedHttpException('invalid credentials');
        }
        
        if($user->status !== User::STATUS_ACTIVE) {
            throw new UnauthorizedHttpException('invalid account');
        }
        
        if ($user->validatePassword($params['password'])) {
            Yii::$app->response->setStatusCode(200);
            return [
                'success' => true,
                'api_key' => $user->api_key
            ];
        } else {
            throw new UnauthorizedHttpException('invalid credentials');
        }
    }
}
