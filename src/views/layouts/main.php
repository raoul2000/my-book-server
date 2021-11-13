<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => '<img src="favicon.svg"/>' . Yii::$app->name . (Yii::$app->user->can('administrate') ? ' - <small>' . APP_BUILD_NUMBER . '</small>': ''),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-fixed-top navbar-default',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                Yii::$app->user->can('administrate') 
                    ? ([
                        'label' => 'Admin',
                        'items' => [
                            ['label' => 'Users',         'url' => ['/admin/user']],
                            ['label' => 'User Token',    'url' => ['/admin/user-token']],
                            ['label' => 'Session',       'url' => ['/admin/session']],
                            ['label' => 'Email',         'url' => ['/admin/email']],
                            ['label' => 'ISBN Service',  'url' => ['/admin/isbn-service']],
                            '<li class="divider"></li>',
                            ['label' => 'Book',         'url' => ['/admin/book']],
                            ['label' => 'User/Book',    'url' => ['/admin/user-book']],
                            ['label' => 'Book Ticket',  'url' => ['/admin/book-ticket']],
                            ['label' => 'Book Ping',    'url' => ['/admin/book-ping']],
                        ]
                    ]) : '',

                Yii::$app->user->isGuest
                    ? (['label' => 'Créer un compte', 'url' => ['/account/create']])
                    : ['label' => 'Paramètres',  'url' => ['/user-settings']],

                Yii::$app->user->isGuest
                    ? (['label' => 'Se connecter', 'url' => ['/site/login']])
                    : ('<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            '<span class="glyphicon glyphicon-off" aria-hidden="true"></span> Se déconnecter (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'),
            ],
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>