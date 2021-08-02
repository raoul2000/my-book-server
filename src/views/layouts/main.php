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
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-fixed-top navbar-default',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                (Yii::$app->user->isGuest === false && Yii::$app->user->id == 1)
                    ? ([
                        'label' => 'Admin',
                        'items' => [
                            ['label' => 'Users',         'url' => ['/admin/user']],
                            ['label' => 'Email',         'url' => ['/admin/email']],
                            '<li class="divider"></li>',
                            ['label' => 'Books',         'url' => ['/admin/book']],
                            ['label' => 'Book Reviews',  'url' => ['/admin/book-review']],
                            ['label' => 'Book Pings',    'url' => ['/admin/book-ping']]
                        ]
                    ]) : '',

                Yii::$app->user->isGuest
                    ? (['label' => 'Register', 'url' => ['/account/create']])
                    : ['label' => 'Settings',  'url' => ['/user-settings']],

                Yii::$app->user->isGuest
                    ? (['label' => 'Login', 'url' => ['/site/login']])
                    : ('<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            '<span class="glyphicon glyphicon-off" aria-hidden="true"></span> logout (' . Yii::$app->user->identity->username . ')',
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

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>