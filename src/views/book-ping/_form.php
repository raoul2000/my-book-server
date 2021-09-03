<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BookPing */
/* @var $form ActiveForm */
?>
<div class="book-ping-_form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'book_id') ?>
        <?= $form->field($model, 'rate') ?>
        <?= $form->field($model, 'text') ?>
        <?= $form->field($model, 'created_at') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- book-ping-_form -->
