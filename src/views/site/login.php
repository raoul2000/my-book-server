<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Se Connecter';

?>
<div class="site-login">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal'
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'autocomplete' => 'off']) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Se Connecter', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <span style="margin-left:1em">
                    <?= html::a('Mot de passe Oublié ?', ['password-reset/request']) ?>
                </span>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
