<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\components\PasswordValidator;

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

        <?= $form->field($model, 'username')->textInput(['autocomplete' => 'off']) ?>
        <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off'])->hint($emailFieldHintText) ?>

        <?= $form->field($model, 'password')->passwordInput()->hint('⚠️ doit contenir ' . PasswordValidator::PWD_MIN_LENGTH . ' caractères minimum, majuscules, minuscules et chiffres') ?>
        <?= $form->field($model, 'password_confirm')->passwordInput() ?>

        <?php if(Yii::$app->params['enableVerifyCodeOnCreateAccount']): ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                'template' => '<div class="row"><div class="col-lg-3" title="cliquez pour obtenir un nouveau code" style="cursor:pointer;">{image}</div><div class="col-lg-3">{input}</div></div>',
            ]) ?>
        <?php endif; ?>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?= Html::submitButton('Créer mon compte ', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
