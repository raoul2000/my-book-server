<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal'
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="col-sm-offset-3 col-sm-19">
            <?= html::a('Mot de passe Oublié ?', ['password-reset/request']) ?>
        </div>
        
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-sm-offset-3 col-sm-9\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
