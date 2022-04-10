<?php

use app\models\UserBook;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2mod\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\UserBook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'book_id')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'read_status')
        ->dropDownList(UserBook::getReadStatusList(), ['prompt' => 'select status ...']) ?>

    <?= $form->field($model, 'read_at')->textInput(['autocomplete' => 'off']) ?>

    <?= $form->field($model, 'rate', ['template' => '{input}'])->widget(StarRating::class, [
        'options' => [
            'label' => 'Rate',
            'title' => 'rate',
            'class' => '',
        ],
        'clientOptions' => [
            'number' => 5
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>