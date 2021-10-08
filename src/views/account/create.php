<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Créer mon compte';
$emailFieldHintText = isset($activationRequired) && $activationRequired === true
    ? "le mail sera envoyé à cette adresse pour activer votre compte"
    : "";
?>
<div class="site-register">
    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal'
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'autocomplete' => 'off']) ?>
        <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off'])->hint($emailFieldHintText) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_confirm')->passwordInput() ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Créer mon compte ', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
