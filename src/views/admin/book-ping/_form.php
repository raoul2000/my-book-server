<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BookPing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-ping-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="grid">
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'book_id')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
                <?= $form->field($model, 'is_boarding')->checkbox() ?>
                <?= $form->field($model, 'text')->textarea(['rows' => 3]) ?>
                <?= $form->field($model, 'rate') ?>

            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'location_name') ?>
                <?= $form->field($model, 'user_ip') ?>
                <?= $form->field($model, 'email') ?>
            </div>
        </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>