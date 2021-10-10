<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset Password';
?>
<div>
    <div class="alert alert-info">
        Entrez l'adresse email liée à votre compte pour recevoir <strong>un mail de réinitialisation</strong>
        de votre mot de passe.
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'pwd-reset-form',
        'layout' => 'horizontal'
    ]); ?>

        <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off']) ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Confirmer ', ['class' => 'btn btn-primary', 'name' => 'reset-pwd-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>