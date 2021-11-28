<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
    <?php if($forCreate): ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_confirm')->passwordInput() ?>
    <?php endif; ?>
    <?= $form->field($model, 'status')
        ->dropDownList(User::getStatusList(), ['prompt' => 'select a status ...'])
        ->hint("⚠️ le token utilisateur doit être créé manuellement et correspondre au status sélectionné") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
