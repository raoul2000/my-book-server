<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;
use app\models\forms\ContactForm;
use app\models\UserBook;
use app\models\UserToken;
use app\models\User;
use Da\QrCode\QrCode;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->render('index');
        } else {
            $totalBookCount = UserBook::find()
                ->where([
                    'user_id' => Yii::$app->user->getId()
                ])->count();

            $userToken = UserToken::findOne([
                'user_id' => Yii::$app->user->id,
                'type' => UserToken::TYPE_API_KEY
            ]);
            $apiKey = ($userToken !== null ? $userToken->token : null);
            $qrCode = null;
            if ($apiKey) {
                $qrCode = (new QrCode(Yii::$app->params['bookAppUrl'] . '/' . $apiKey, ))
                    ->setSize(250)
                    ->setMargin(5)
                    ->useForegroundColor(51, 122, 183);
            }

            return $this->render('index-logged', [
                'totalBookCount' => $totalBookCount,
                'apiKey' => $apiKey,
                'qrCode' => $qrCode
            ]);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if (!Yii::$app->user->isGuest) {
            $model->applyCaptcha = false;
            $minimalContactForm = true;

            $user =  User::findOne(Yii::$app->user->id);
            $model->email = $user->email;
            $model->name = $user->username;

        } else {
            $model->applyCaptcha = true;
            $minimalContactForm = false;
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['contactEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        
        return $this->render('contact', [
            'model'              => $model,
            'minimalContactForm' => $minimalContactForm
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    /*
    public function actionAbout()
    {
        return $this->render('about');
    }*/

    public function actionCgu()
    {
        return $this->render('cgu');
    }
}
